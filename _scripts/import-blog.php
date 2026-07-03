<?php
/**
 * Script de Importação — Página de Blog - ITK
 * ==========================================================
 * Como executar (no shell do LocalWP):
 *   wp eval-file "D:\Clientes\Localsites\itk-treinamentos\_scripts\import-blog.php" --path="D:\Clientes\Localsites\itk-treinamentos\wp-site\app\public"
 */

// ─── Helper de importação de imagem ──────────────────────────────────────────
function _import_theme_image( string $filename, string $title ): int {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $src = get_template_directory() . '/assets/images/' . ltrim( $filename, '/' );
    if ( ! file_exists( $src ) ) { echo "  ⚠  Não encontrado: $filename\n"; return 0; }

    $slug     = sanitize_title( pathinfo( $filename, PATHINFO_FILENAME ) );
    $existing = get_posts( [ 'post_type' => 'attachment', 'post_status' => 'any', 'name' => $slug, 'posts_per_page' => 1 ] );
    if ( $existing ) { echo "  ↩  Já importado: $filename (ID: {$existing[0]->ID})\n"; return (int) $existing[0]->ID; }

    // Permite SVG
    $allow_svg = function( $mimes ) { $mimes['svg'] = 'image/svg+xml'; return $mimes; };
    add_filter( 'upload_mimes', $allow_svg );
    add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename ) {
        if ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) === 'svg' ) {
            $data['ext'] = 'svg'; $data['type'] = 'image/svg+xml';
        }
        return $data;
    }, 10, 3 );

    $upload = wp_upload_dir();
    $dest   = trailingslashit( $upload['path'] ) . basename($filename);
    if ( ! copy( $src, $dest ) ) { echo "  ✗  Erro ao copiar: $filename\n"; remove_filter( 'upload_mimes', $allow_svg ); return 0; }

    $att_id = wp_insert_attachment( [ 'post_mime_type' => wp_check_filetype( $filename )['type'] ?: 'image/svg+xml', 'post_title' => $title, 'post_name' => $slug, 'post_status' => 'inherit' ], $dest );
    if ( is_wp_error( $att_id ) ) { echo "  ✗  {$att_id->get_error_message()}\n"; remove_filter( 'upload_mimes', $allow_svg ); return 0; }

    wp_update_attachment_metadata( $att_id, wp_generate_attachment_metadata( $att_id, $dest ) );
    echo "  ✓  Importado: $filename (ID: $att_id)\n";
    remove_filter( 'upload_mimes', $allow_svg );
    return (int) $att_id;
}

// ─── 1. Localizar a página de Blog ───────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "  IMPORT: Página de Blog\n";
echo "════════════════════════════════════════\n\n";

$pid = (int) get_option( 'page_for_posts' );
if ( ! $pid ) {
    echo "✗  Nenhuma página configurada como 'Página de Posts' no painel de Leitura.\n   Tente localizar pelo slug 'blog'...\n";
    $page = get_page_by_path( 'blog' );
    if ( ! $page ) {
        echo "✗  Página 'Blog' não encontrada. Crie a página e configure-a em Configurações → Leitura.\n";
        return;
    }
    $pid = $page->ID;
} else {
    $page = get_post( $pid );
}
echo "📄  Página de Blog encontrada: \"{$page->post_title}\" (ID: $pid)\n\n";

// ─── 2. Aba: Banner Principal ────────────────────────────────────────────────
echo "\n── Aba: Banner Principal ────────────────\n";

$banner_bg = _import_theme_image( 'banner-blog.webp', 'Banner Blog' );
if ( $banner_bg ) { update_field( 'banner_bg_image', $banner_bg, $pid ); echo "✓  banner_bg_image\n"; }

update_field( 'banner_title', 'Blog', $pid );
update_field( 'banner_watermark', 'ITK', $pid );
echo "✓  banner_title / banner_watermark\n";


// ─── Resultado ────────────────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "✅  Concluído! Página Blog (ID: $pid)\n";
echo '🔗  ' . get_permalink( $pid ) . "\n";
echo "════════════════════════════════════════\n\n";

