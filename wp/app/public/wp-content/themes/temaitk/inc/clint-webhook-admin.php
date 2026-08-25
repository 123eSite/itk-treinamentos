<?php
/**
 * Homologação da integração Clint: Ferramentas → Clint webhook.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_menu', 'temaitk_clint_admin_menu' );
add_action( 'admin_init', 'temaitk_clint_admin_handle_actions' );

function temaitk_clint_admin_menu() {
    add_management_page(
        'Clint webhook',
        'Clint webhook',
        'manage_options',
        'temaitk-clint-webhook',
        'temaitk_clint_admin_page'
    );
}

function temaitk_clint_admin_handle_actions() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( empty( $_POST['temaitk_clint_action'] ) ) {
        return;
    }

    check_admin_referer( 'temaitk_clint_admin' );

    $action = sanitize_key( wp_unslash( $_POST['temaitk_clint_action'] ) );

    if ( $action === 'test' ) {
        $post_id = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0;
        $result  = temaitk_clint_send_test_payload( $post_id );

        if ( $result['ok'] ) {
            add_settings_error(
                'temaitk_clint',
                'temaitk_clint_ok',
                sprintf(
                    'Teste enviado (HTTP %d). Confira o lead na Clint. Página: %s.',
                    $result['code'],
                    $post_id ? get_the_title( $post_id ) : '—'
                ),
                'success'
            );
        } else {
            add_settings_error(
                'temaitk_clint',
                'temaitk_clint_fail',
                sprintf(
                    'Falha no teste: %s (HTTP %d).',
                    $result['error'] ? $result['error'] : 'resposta inválida',
                    $result['code']
                ),
                'error'
            );
        }
    }

    if ( $action === 'clear_log' ) {
        delete_option( 'temaitk_clint_log' );
        add_settings_error( 'temaitk_clint', 'temaitk_clint_cleared', 'Log apagado.', 'success' );
    }
}

/**
 * @param string $url
 * @return string
 */
function temaitk_clint_mask_url( $url ) {
    if ( $url === '' ) {
        return '—';
    }

    $path = (string) wp_parse_url( $url, PHP_URL_PATH );
    $tail = $path ? substr( $path, -8 ) : substr( $url, -8 );

    return '…' . $tail;
}

function temaitk_clint_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $pages = get_posts(
        [
            'post_type'      => 'page',
            'post_status'    => [ 'publish', 'draft' ],
            'numberposts'    => 100,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]
    );

    $with_url = 0;
    $rows     = [];
    foreach ( $pages as $page ) {
        $url = temaitk_clint_get_webhook_url( $page->ID );
        if ( $url ) {
            $with_url++;
        }
        $rows[] = [
            'id'    => $page->ID,
            'title' => $page->post_title,
            'url'   => $url,
        ];
    }

    $log = get_option( 'temaitk_clint_log', [] );
    if ( ! is_array( $log ) ) {
        $log = [];
    }

    $acf_ok = function_exists( 'acf_get_field' ) && (bool) acf_get_field( 'field_clint_url_webhook' );

    settings_errors( 'temaitk_clint' );
    ?>
    <div class="wrap">
        <h1>Clint webhook</h1>

        <p>Use esta tela para homologar o envio dos formulários para a Clint. O motivo mais comum de o lead não chegar é a página sem a URL do webhook no ACF.</p>

        <h2>Checklist</h2>
        <ol>
            <li>Campo ACF <code>url_webhook_clint</code>: <?php echo $acf_ok ? '<strong>carregado</strong>' : '<strong style="color:#b32d2e">não encontrado — sincronize o grupo em ACF → Grupos de campos</strong>'; ?></li>
            <li>Cole a URL da Clint em cada página com formulário (coluna lateral “Integração Clint”).</li>
            <li>Clique em <strong>Enviar teste</strong> na página e confira o lead na Clint.</li>
            <li>Envie o formulário real na LP e veja o log abaixo. Se aparecer <code>sem_url_webhook</code>, a URL não está salva nessa página.</li>
        </ol>

        <p>
            Páginas com webhook: <strong><?php echo (int) $with_url; ?></strong> de <?php echo count( $rows ); ?>.
            <?php if ( $with_url === 0 ) : ?>
                <span style="color:#b32d2e">Nenhuma página tem URL. Os leads não serão enviados até isso ser preenchido.</span>
            <?php endif; ?>
        </p>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Página</th>
                    <th>ID</th>
                    <th>Webhook</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if ( ! $rows ) : ?>
                    <tr><td colspan="4">Nenhuma página encontrada.</td></tr>
                <?php endif; ?>
                <?php foreach ( $rows as $row ) : ?>
                    <tr>
                        <td>
                            <a href="<?php echo esc_url( get_edit_post_link( $row['id'] ) ); ?>">
                                <?php echo esc_html( $row['title'] ?: '(sem título)' ); ?>
                            </a>
                        </td>
                        <td><?php echo (int) $row['id']; ?></td>
                        <td>
                            <?php if ( $row['url'] ) : ?>
                                <code><?php echo esc_html( temaitk_clint_mask_url( $row['url'] ) ); ?></code>
                            <?php else : ?>
                                <span style="color:#b32d2e">vazio</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ( $row['url'] ) : ?>
                                <form method="post" style="display:inline">
                                    <?php wp_nonce_field( 'temaitk_clint_admin' ); ?>
                                    <input type="hidden" name="temaitk_clint_action" value="test">
                                    <input type="hidden" name="post_id" value="<?php echo (int) $row['id']; ?>">
                                    <button type="submit" class="button">Enviar teste</button>
                                </form>
                            <?php else : ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 style="margin-top:2em">Últimos envios</h2>
        <form method="post" style="margin-bottom:1em">
            <?php wp_nonce_field( 'temaitk_clint_admin' ); ?>
            <input type="hidden" name="temaitk_clint_action" value="clear_log">
            <button type="submit" class="button">Limpar log</button>
        </form>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Motivo</th>
                    <th>Página</th>
                    <th>Form</th>
                    <th>CF7 / HTTP</th>
                </tr>
            </thead>
            <tbody>
                <?php if ( ! $log ) : ?>
                    <tr><td colspan="6">Nenhum envio registrado ainda. Envie um teste ou preencha o formulário no site.</td></tr>
                <?php endif; ?>
                <?php foreach ( $log as $entry ) : ?>
                    <?php
                    $status = isset( $entry['status'] ) ? (string) $entry['status'] : '';
                    $color  = 'enviado' === $status ? '#00a32a' : ( 'erro' === $status ? '#b32d2e' : '#996800' );
                    ?>
                    <tr>
                        <td><?php echo esc_html( isset( $entry['time'] ) ? $entry['time'] : '' ); ?></td>
                        <td style="color:<?php echo esc_attr( $color ); ?>;font-weight:600"><?php echo esc_html( $status ); ?></td>
                        <td><code><?php echo esc_html( isset( $entry['motivo'] ) ? $entry['motivo'] : '' ); ?></code></td>
                        <td>
                            <?php
                            echo esc_html( isset( $entry['pagina'] ) ? $entry['pagina'] : '' );
                            if ( ! empty( $entry['post_id'] ) ) {
                                echo ' (' . (int) $entry['post_id'] . ')';
                            }
                            ?>
                        </td>
                        <td><?php echo isset( $entry['form_id'] ) ? (int) $entry['form_id'] : 0; ?></td>
                        <td>
                            <?php echo esc_html( isset( $entry['cf7'] ) ? $entry['cf7'] : '' ); ?>
                            <?php if ( ! empty( $entry['http'] ) ) : ?>
                                / HTTP <?php echo (int) $entry['http']; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
