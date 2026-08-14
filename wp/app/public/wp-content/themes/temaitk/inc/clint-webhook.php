<?php
/**
 * Integração Contact Form 7 → Clint CRM (webhook de entrada).
 *
 * Dispara após envio bem-sucedido do CF7 e envia JSON para a URL
 * configurada no campo ACF `url_webhook_clint` da página de origem.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * IDs dos formulários CF7 que disparam o webhook.
 * Array vazio = todos os formulários (desde que a página tenha URL da Clint).
 */
function temaitk_clint_cf7_form_ids() {
    return apply_filters( 'temaitk_clint_cf7_form_ids', [] );
}

/**
 * Mapeamento: chave JSON enviada à Clint → nomes possíveis dos campos no CF7.
 */
function temaitk_clint_field_map() {
    return apply_filters(
        'temaitk_clint_field_map',
        [
            'nome'     => [ 'nome', 'your-name', 'name' ],
            'email'    => [ 'email', 'your-email' ],
            'telefone' => [ 'telefone', 'phone', 'tel', 'your-phone' ],
        ]
    );
}

/**
 * ID da página onde o formulário foi exibido (CF7 envia via AJAX).
 *
 * @param array<string, mixed> $posted
 * @param WPCF7_Submission     $submission
 * @return int
 */
function temaitk_clint_get_source_post_id( array $posted, $submission ) {
    if ( $submission instanceof WPCF7_Submission ) {
        $meta_id = (int) $submission->get_meta( 'container_post_id' );
        if ( $meta_id > 0 ) {
            return $meta_id;
        }
    }

    if ( ! empty( $posted['_wpcf7_container_post'] ) ) {
        $container_id = (int) $posted['_wpcf7_container_post'];
        if ( $container_id > 0 ) {
            return $container_id;
        }
    }

    if ( ! empty( $posted['_wpcf7_unit_tag'] ) ) {
        $unit_tag = sanitize_text_field( (string) $posted['_wpcf7_unit_tag'] );
        if ( preg_match( '/-p(\d+)-/', $unit_tag, $match ) ) {
            return (int) $match[1];
        }
    }

    $queried = (int) get_queried_object_id();
    if ( $queried > 0 ) {
        return $queried;
    }

    return (int) get_the_ID();
}

/**
 * URL do webhook da Clint para a página de origem.
 *
 * Prioridade: ACF da página → constante TEMAITK_CLINT_WEBHOOK_URL (wp-config).
 *
 * @param int $post_id
 * @return string
 */
function temaitk_clint_get_webhook_url( $post_id ) {
    $url = '';

    if ( $post_id && function_exists( 'get_field' ) ) {
        $url = trim( (string) get_field( 'url_webhook_clint', $post_id ) );
    }

    if ( $url === '' && defined( 'TEMAITK_CLINT_WEBHOOK_URL' ) && TEMAITK_CLINT_WEBHOOK_URL ) {
        $url = (string) TEMAITK_CLINT_WEBHOOK_URL;
    }

    $url = esc_url_raw( $url );

    return apply_filters( 'temaitk_clint_webhook_url', $url, $post_id );
}

/**
 * Monta o payload JSON a partir dos dados enviados pelo CF7.
 *
 * @param array<string, mixed> $posted  Dados do submission.
 * @param int                  $post_id Página de origem.
 * @return array<string, string>
 */
function temaitk_clint_build_payload( array $posted, $post_id = 0 ) {
    $payload = [];

    foreach ( temaitk_clint_field_map() as $clint_key => $cf7_keys ) {
        foreach ( (array) $cf7_keys as $cf7_key ) {
            if ( ! isset( $posted[ $cf7_key ] ) || $posted[ $cf7_key ] === '' ) {
                continue;
            }

            $value = $posted[ $cf7_key ];
            if ( is_array( $value ) ) {
                $value = implode( ', ', array_filter( $value ) );
            }

            $payload[ $clint_key ] = sanitize_text_field( (string) $value );
            break;
        }
    }

    if ( ! empty( $posted['_wpcf7_unit_tag'] ) ) {
        $unit_tag = sanitize_text_field( (string) $posted['_wpcf7_unit_tag'] );
        if ( preg_match( '/wpcf7-f(\d+)-/', $unit_tag, $match ) ) {
            $payload['formulario_id'] = $match[1];
        }
    }

    $post_id = (int) $post_id;
    if ( $post_id > 0 ) {
        $payload['origem_pagina'] = wp_strip_all_tags( (string) get_the_title( $post_id ) );
        $payload['url_pagina']    = (string) get_permalink( $post_id );
    }

    return apply_filters( 'temaitk_clint_payload', $payload, $posted, $post_id );
}

/**
 * Envia os dados do formulário para o webhook da Clint da página de origem.
 */
function temaitk_clint_send_webhook( $contact_form ) {
    if ( ! $contact_form instanceof WPCF7_ContactForm ) {
        return;
    }

    $form_ids = temaitk_clint_cf7_form_ids();
    if ( $form_ids && ! in_array( (int) $contact_form->id(), array_map( 'intval', $form_ids ), true ) ) {
        return;
    }

    $submission = WPCF7_Submission::get_instance();
    if ( ! $submission ) {
        return;
    }

    $posted      = $submission->get_posted_data();
    $post_id     = temaitk_clint_get_source_post_id( $posted, $submission );
    $webhook_url = temaitk_clint_get_webhook_url( $post_id );

    if ( ! $webhook_url ) {
        return;
    }

    $payload = temaitk_clint_build_payload( $posted, $post_id );

    if ( empty( $payload['nome'] ) && empty( $payload['email'] ) && empty( $payload['telefone'] ) ) {
        return;
    }

    $response = wp_remote_post(
        $webhook_url,
        [
            'timeout' => 15,
            'headers' => [
                'Content-Type' => 'application/json; charset=utf-8',
                'Accept'       => 'application/json',
            ],
            'body'    => wp_json_encode( $payload ),
        ]
    );

    if ( is_wp_error( $response ) ) {
        error_log( 'Clint webhook erro: ' . $response->get_error_message() );
        return;
    }

    $status_code = (int) wp_remote_retrieve_response_code( $response );
    if ( $status_code < 200 || $status_code >= 300 ) {
        error_log(
            sprintf(
                'Clint webhook HTTP %d: %s',
                $status_code,
                wp_remote_retrieve_body( $response )
            )
        );
    }
}
add_action( 'wpcf7_mail_sent', 'temaitk_clint_send_webhook' );
