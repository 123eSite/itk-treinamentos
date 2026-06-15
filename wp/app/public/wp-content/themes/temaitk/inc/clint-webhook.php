<?php
/**
 * Integração Contact Form 7 → Clint CRM (webhook de entrada).
 *
 * Dispara após envio bem-sucedido do CF7 e envia JSON para a URL configurada.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * URL do webhook gerada na Clint (Integrações → Webhook).
 * Pode ser sobrescrita em wp-config.php: define( 'TEMAITK_CLINT_WEBHOOK_URL', '...' );
 */
if ( ! defined( 'TEMAITK_CLINT_WEBHOOK_URL' ) ) {
    define(
        'TEMAITK_CLINT_WEBHOOK_URL',
        'https://functions-api.clint.digital/endpoints/integration/webhook/7aabb78e-c3ce-4ded-8ce8-20ebb25f5895'
    );
}

/**
 * IDs dos formulários CF7 que disparam o webhook.
 * Encontre o ID em Contato → Formulários de contato (coluna shortcode).
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
 * Monta o payload JSON a partir dos dados enviados pelo CF7.
 *
 * @param array<string, mixed> $posted Dados do submission.
 * @return array<string, string>
 */
function temaitk_clint_build_payload( array $posted ) {
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

    $payload['origem_pagina'] = wp_strip_all_tags( (string) get_the_title() );
    $payload['url_pagina']    = (string) get_permalink();

    return apply_filters( 'temaitk_clint_payload', $payload, $posted );
}

/**
 * Envia os dados do formulário para o webhook da Clint.
 */
function temaitk_clint_send_webhook( $contact_form ) {
    if ( ! $contact_form instanceof WPCF7_ContactForm ) {
        return;
    }

    $form_ids = temaitk_clint_cf7_form_ids();
    if ( $form_ids && ! in_array( (int) $contact_form->id(), array_map( 'intval', $form_ids ), true ) ) {
        return;
    }

    $webhook_url = apply_filters( 'temaitk_clint_webhook_url', TEMAITK_CLINT_WEBHOOK_URL );
    if ( ! $webhook_url ) {
        return;
    }

    $submission = WPCF7_Submission::get_instance();
    if ( ! $submission ) {
        return;
    }

    $posted  = $submission->get_posted_data();
    $payload = temaitk_clint_build_payload( $posted );

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
