<?php
/**
 * Integração Contact Form 7 → Clint CRM (webhook de entrada).
 *
 * Envia JSON para a URL do campo ACF `url_webhook_clint` da página de origem.
 * Homologação: Ferramentas → Clint webhook.
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
            'origem'   => [ 'origem', 'source' ],
        ]
    );
}

/**
 * Grava uma entrada no log de homologação (últimos 30 envios).
 *
 * @param array<string, mixed> $entry
 */
function temaitk_clint_record( array $entry ) {
    $entry['time'] = current_time( 'mysql' );

    $log = get_option( 'temaitk_clint_log', [] );
    if ( ! is_array( $log ) ) {
        $log = [];
    }

    array_unshift( $log, $entry );
    update_option( 'temaitk_clint_log', array_slice( $log, 0, 30 ), false );

    error_log( 'Clint webhook: ' . wp_json_encode( $entry ) );
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

        $unit_tag = (string) $submission->get_meta( 'unit_tag' );
        if ( $unit_tag && preg_match( '/-p(\d+)-/', $unit_tag, $match ) && (int) $match[1] > 0 ) {
            return (int) $match[1];
        }

        $from_url = temaitk_clint_post_id_from_url( (string) $submission->get_meta( 'url' ) );
        if ( $from_url > 0 ) {
            return $from_url;
        }
    }

    $container = 0;
    if ( function_exists( 'wpcf7_superglobal_post' ) ) {
        $container = (int) wpcf7_superglobal_post( '_wpcf7_container_post' );
    } elseif ( ! empty( $_POST['_wpcf7_container_post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
        $container = (int) $_POST['_wpcf7_container_post']; // phpcs:ignore WordPress.Security.NonceVerification.Missing
    }
    if ( $container > 0 ) {
        return $container;
    }

    $queried = (int) get_queried_object_id();
    if ( $queried > 0 ) {
        return $queried;
    }

    return (int) get_the_ID();
}

/**
 * Resolve o ID da página a partir da URL de origem do envio (referer do CF7).
 *
 * @param string $url
 * @return int
 */
function temaitk_clint_post_id_from_url( $url ) {
    $url = trim( (string) $url );
    if ( $url === '' ) {
        return 0;
    }

    $parts = wp_parse_url( $url );
    if ( ! empty( $parts['scheme'] ) && ! empty( $parts['host'] ) ) {
        $url = $parts['scheme'] . '://' . $parts['host'] . ( isset( $parts['path'] ) ? $parts['path'] : '/' );
    }

    $post_id = (int) url_to_postid( $url );
    if ( $post_id > 0 ) {
        return $post_id;
    }

    $path = isset( $parts['path'] ) ? (string) $parts['path'] : '';
    if ( $path === '' || $path === '/' ) {
        $front = (int) get_option( 'page_on_front' );
        return $front > 0 ? $front : 0;
    }

    $page = get_page_by_path( trim( $path, '/' ) );
    return $page ? (int) $page->ID : 0;
}

/**
 * O CF7 só preenche `_wpcf7_container_post` dentro do Loop.
 * Garante o ID da página atual mesmo quando o shortcode roda fora dele.
 *
 * @param array<string, mixed> $fields
 * @return array<string, mixed>
 */
function temaitk_clint_cf7_hidden_fields( $fields ) {
    if ( empty( $fields['_wpcf7_container_post'] ) ) {
        $post_id = (int) get_queried_object_id();
        if ( $post_id <= 0 ) {
            $post_id = (int) get_the_ID();
        }
        if ( $post_id > 0 ) {
            $fields['_wpcf7_container_post'] = $post_id;
        }
    }

    return $fields;
}
add_filter( 'wpcf7_form_hidden_fields', 'temaitk_clint_cf7_hidden_fields' );

/**
 * URL do webhook da Clint para a página de origem.
 *
 * Prioridade: ACF da página → post meta → constante TEMAITK_CLINT_WEBHOOK_URL (wp-config).
 *
 * @param int $post_id
 * @return string
 */
function temaitk_clint_get_webhook_url( $post_id ) {
    $url = '';

    if ( $post_id && function_exists( 'get_field' ) ) {
        $url = trim( (string) get_field( 'url_webhook_clint', $post_id ) );
    }

    if ( $url === '' && $post_id ) {
        $url = trim( (string) get_post_meta( $post_id, 'url_webhook_clint', true ) );
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
 * @param int                  $form_id ID do formulário CF7.
 * @return array<string, string>
 */
function temaitk_clint_build_payload( array $posted, $post_id = 0, $form_id = 0 ) {
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

    if ( (int) $form_id > 0 ) {
        $payload['formulario_id'] = (string) (int) $form_id;
    }

    $post_id = (int) $post_id;
    if ( $post_id > 0 ) {
        $payload['origem_pagina'] = wp_strip_all_tags( (string) get_the_title( $post_id ) );
        $payload['url_pagina']    = (string) get_permalink( $post_id );
    }

    return apply_filters( 'temaitk_clint_payload', $payload, $posted, $post_id );
}

/**
 * POST JSON para a URL da Clint.
 *
 * @param string               $webhook_url
 * @param array<string, mixed> $payload
 * @return array{ok: bool, code: int, body: string, error: string}
 */
function temaitk_clint_post_json( $webhook_url, array $payload ) {
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
        return [
            'ok'    => false,
            'code'  => 0,
            'body'  => '',
            'error' => $response->get_error_message(),
        ];
    }

    $code = (int) wp_remote_retrieve_response_code( $response );
    $body = (string) wp_remote_retrieve_body( $response );

    return [
        'ok'    => $code >= 200 && $code < 300,
        'code'  => $code,
        'body'  => $body,
        'error' => '',
    ];
}

/**
 * Envia payload de homologação para o webhook da página.
 *
 * @param int $post_id
 * @return array{ok: bool, code: int, body: string, error: string, url: string}
 */
function temaitk_clint_send_test_payload( $post_id ) {
    $post_id     = (int) $post_id;
    $webhook_url = temaitk_clint_get_webhook_url( $post_id );

    if ( ! $webhook_url ) {
        return [
            'ok'    => false,
            'code'  => 0,
            'body'  => '',
            'error' => 'Página sem URL do webhook Clint.',
            'url'   => '',
        ];
    }

    $payload = [
        'nome'          => 'Teste Homologação ITK',
        'email'         => 'homologacao@itktreinamentos.com.br',
        'telefone'      => '11999999999',
        'origem'        => 'Homologação',
        'origem_pagina' => $post_id ? wp_strip_all_tags( (string) get_the_title( $post_id ) ) : '',
        'url_pagina'    => $post_id ? (string) get_permalink( $post_id ) : '',
        'homologacao'   => '1',
    ];

    $result        = temaitk_clint_post_json( $webhook_url, $payload );
    $result['url'] = $webhook_url;

    temaitk_clint_record(
        [
            'status'     => $result['ok'] ? 'enviado' : 'erro',
            'motivo'     => $result['ok'] ? 'teste_manual' : ( $result['error'] ?: 'http_' . $result['code'] ),
            'form_id'    => 0,
            'post_id'    => $post_id,
            'pagina'     => $payload['origem_pagina'],
            'http'       => $result['code'],
            'teste'      => 1,
        ]
    );

    return $result;
}

/**
 * Processa o envio após submit válido do CF7 (e-mail enviado ou falho).
 *
 * @param WPCF7_ContactForm        $contact_form
 * @param array<string, mixed>|null $result
 */
function temaitk_clint_send_webhook( $contact_form, $result = null ) {
    if ( ! $contact_form instanceof WPCF7_ContactForm ) {
        return;
    }

    $cf7_status = is_array( $result ) ? (string) ( $result['status'] ?? '' ) : 'mail_sent';
    $form_id    = (int) $contact_form->id();

    $form_ids = temaitk_clint_cf7_form_ids();
    if ( $form_ids && ! in_array( $form_id, array_map( 'intval', $form_ids ), true ) ) {
        temaitk_clint_record(
            [
                'status'  => 'ignorado',
                'motivo'  => 'form_id_fora_da_lista',
                'form_id' => $form_id,
                'post_id' => 0,
                'cf7'     => $cf7_status,
            ]
        );
        return;
    }

    $submission = WPCF7_Submission::get_instance();
    if ( ! $submission ) {
        temaitk_clint_record(
            [
                'status'  => 'ignorado',
                'motivo'  => 'sem_submission',
                'form_id' => $form_id,
                'post_id' => 0,
                'cf7'     => $cf7_status,
            ]
        );
        return;
    }

    $posted      = (array) $submission->get_posted_data();
    $post_id     = temaitk_clint_get_source_post_id( $posted, $submission );
    $webhook_url = temaitk_clint_get_webhook_url( $post_id );
    $pagina      = $post_id ? wp_strip_all_tags( (string) get_the_title( $post_id ) ) : '';

    if ( ! $webhook_url ) {
        temaitk_clint_record(
            [
                'status'  => 'ignorado',
                'motivo'  => 'sem_url_webhook',
                'form_id' => $form_id,
                'post_id' => $post_id,
                'pagina'  => $pagina,
                'cf7'     => $cf7_status,
            ]
        );
        return;
    }

    $payload = temaitk_clint_build_payload( $posted, $post_id, $form_id );

    if ( empty( $payload['nome'] ) && empty( $payload['email'] ) && empty( $payload['telefone'] ) ) {
        temaitk_clint_record(
            [
                'status'  => 'ignorado',
                'motivo'  => 'sem_campos_nome_email_telefone',
                'form_id' => $form_id,
                'post_id' => $post_id,
                'pagina'  => $pagina,
                'cf7'     => $cf7_status,
                'campos'  => array_keys( $posted ),
            ]
        );
        return;
    }

    $response = temaitk_clint_post_json( $webhook_url, $payload );

    temaitk_clint_record(
        [
            'status'  => $response['ok'] ? 'enviado' : 'erro',
            'motivo'  => $response['ok'] ? 'ok' : ( $response['error'] ?: 'http_' . $response['code'] ),
            'form_id' => $form_id,
            'post_id' => $post_id,
            'pagina'  => $pagina,
            'cf7'     => $cf7_status,
            'http'    => $response['code'],
            'email'   => isset( $payload['email'] ) ? $payload['email'] : '',
        ]
    );
}

/**
 * Dispara o webhook em envio válido, mesmo se o e-mail do CF7 falhar (SMTP local).
 *
 * @param WPCF7_ContactForm    $contact_form
 * @param array<string, mixed> $result
 */
function temaitk_clint_on_cf7_submit( $contact_form, $result ) {
    $status = is_array( $result ) ? (string) ( $result['status'] ?? '' ) : '';

    if ( ! in_array( $status, [ 'mail_sent', 'mail_failed' ], true ) ) {
        return;
    }

    temaitk_clint_send_webhook( $contact_form, $result );
}
add_action( 'wpcf7_submit', 'temaitk_clint_on_cf7_submit', 10, 2 );

if ( is_admin() ) {
    require_once __DIR__ . '/clint-webhook-admin.php';
}
