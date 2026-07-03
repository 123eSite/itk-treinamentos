<?php
/**
 * Script de Importação — Página Cursos e Treinamentos - ITK
 * ==========================================================
 * Como executar (no shell do LocalWP):
 *   wp eval-file "D:\Clientes\Localsites\itk-treinamentos\_scripts\import-cursos-e-treinamentos.php" --path="D:\Clientes\Localsites\itk-treinamentos\wp-site\app\public"
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

// ─── 1. Localizar a página ───────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "  IMPORT: Página Cursos e Treinamentos\n";
echo "════════════════════════════════════════\n\n";

$page = get_page_by_path( 'cursos-e-treinamentos' ) ?: get_page_by_title( 'Cursos e Treinamentos' );
if ( ! $page ) {
    echo "✗  Página 'Cursos e Treinamentos' não encontrada. Crie uma página com slug 'cursos-e-treinamentos'.\n"; 
    return;
}
$pid = $page->ID;
echo "📄  Página encontrada: \"{$page->post_title}\" (ID: $pid)\n\n";

update_post_meta( $pid, '_wp_page_template', 'page-cursos.php' ); // Template custom se existir
echo "✓  Template assinalado (se aplicável)\n";


// ─── 2. Aba: Banner Principal ────────────────────────────────────────────────
echo "\n── Aba: Banner Principal ────────────────\n";

$banner_bg = _import_theme_image( 'cursos-e-treinamentos.webp', 'Banner Cursos' );
if ( $banner_bg ) { update_field( 'banner_bg_image', $banner_bg, $pid ); echo "✓  banner_bg_image\n"; }

update_field( 'banner_title', 'Cursos e Treinamentos', $pid );
update_field( 'banner_watermark', 'ITK', $pid );
echo "✓  banner_title / banner_watermark\n";


// ─── 3. Aba: Lista de Cursos ─────────────────────────────────────────────────
echo "\n── Aba: Lista de Cursos ─────────────────\n";

update_field( 'courses_title', 'Mais consciência, mais realização', $pid );
update_field( 'courses_text', 'O ITK Treinamentos é especializado em treinamento comportamental, crescimento pessoal e desenvolvimento, buscando auxiliar os participantes na compreensão de sua missão no mundo e na percepção das consequências, tanto positivas quanto negativas, de suas ações, palavras e gestos, ressaltando o poder transformador que eles possuem.', $pid );
echo "✓  courses_title / courses_text\n";

$courses = [
    [
        'course_image' => _import_theme_image( 'Leader-Training.webp', 'Leader Training' ),
        'course_link'  => [ 'url' => '#', 'title' => 'Curso presencial', 'target' => '_self' ]
    ],
    [
        'course_image' => _import_theme_image( 'Leader-Training-2-1.jpg', 'Leader Training 2' ),
        'course_link'  => [ 'url' => '#', 'title' => 'Curso presencial', 'target' => '_self' ]
    ],
    [
        'course_image' => _import_theme_image( 'transformacao.jpg', 'Transformação' ),
        'course_link'  => [ 'url' => '#', 'title' => 'Curso presencial', 'target' => '_self' ]
    ],
    [
        'course_image' => _import_theme_image( 'acreditando-em-voce.jpg', 'Acreditando em você' ),
        'course_link'  => [ 'url' => '#', 'title' => 'Curso presencial', 'target' => '_self' ]
    ],
    [
        'course_image' => _import_theme_image( 'reiki.jpg', 'Reiki' ),
        'course_link'  => [ 'url' => '#', 'title' => 'Curso online', 'target' => '_self' ]
    ]
];

update_field( 'courses_list', $courses, $pid );
echo '✓  courses_list: ' . count( $courses ) . " cursos\n";


// ─── Resultado ────────────────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "✅  Concluído! Página Cursos e Treinamentos (ID: $pid)\n";
echo '🔗  ' . get_permalink( $pid ) . "\n";
echo "════════════════════════════════════════\n\n";

