<?php
/**
 * Script de Importação — Página Mandala - ITK
 * ==========================================================
 * Como executar (no shell do LocalWP):
 *   wp eval-file "D:\Clientes\Localsites\itk-treinamentos\_scripts\import-mandala.php" --path="D:\Clientes\Localsites\itk-treinamentos\wp-site\app\public"
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
echo "  IMPORT: Página Mandala\n";
echo "════════════════════════════════════════\n\n";

$page = get_page_by_path( 'mandala' ) ?: get_page_by_title( 'Mandalas' );
if ( ! $page ) {
    $page = get_page_by_title( 'Mandala' );
}
if ( ! $page ) {
    echo "✗  Página 'Mandala' não encontrada. Crie uma página com slug 'mandala' ou 'mandalas'.\n"; 
    return;
}
$pid = $page->ID;
echo "📄  Página encontrada: \"{$page->post_title}\" (ID: $pid)\n\n";

update_post_meta( $pid, '_wp_page_template', 'page-mandalas.php' ); // Template custom se existir
echo "✓  Template assinalado (se aplicável)\n";


// ─── 2. Aba: Banner Principal ────────────────────────────────────────────────
echo "\n── Aba: Banner Principal ────────────────\n";

$banner_bg = _import_theme_image( 'banner-mandalas.webp', 'Banner Mandalas' );
if ( $banner_bg ) { update_field( 'banner_bg_image', $banner_bg, $pid ); echo "✓  banner_bg_image\n"; }

update_field( 'banner_title', 'Mandalas', $pid );
update_field( 'banner_watermark', 'ITK', $pid );
echo "✓  banner_title / banner_watermark\n";


// ─── 3. Aba: Sobre Mandalas ──────────────────────────────────────────────────
echo "\n── Aba: Sobre Mandalas ──────────────────\n";

update_field( 'about_subtitle', 'Sobre', $pid );
update_field( 'about_title', 'Você sabe o que são Mandalas?', $pid );

$about_img = _import_theme_image( 'mandalas-768x341.webp', 'Imagem Sobre Mandalas' );
if ( $about_img ) { update_field( 'about_image', $about_img, $pid ); echo "✓  about_image\n"; }

update_field( 'about_text', 
    '<p>Mandalas são desenhos de formas geométricas concêntricas. Ou seja, que se desenvolvem a partir de um mesmo centro.</p>'
    . '<p>É um símbolo de harmonização, capaz de transformar a energia das pessoas como também dos ambientes. Nós tivemos contato e consciência que as mandalas existem através do oriente, mas bem na verdade elas já existem desde sempre nos processos naturais da vida, basta observar a natureza… Veja um ciclone olhado de cima, os nossos olhos, uma laranja, um girassol…todos esses fluxos são redondos, formam um desenho que podemos dizer e considerar como mandalas, por isso elas são como um presente da natureza para nossas vidas.</p>'
    . '<p>As mandalas naturais são símbolos da harmonia perfeita entre o micro, que é o ser humano e o macro que é o universo, por isso pode ser traduzido como fonte de harmonia universal.</p>'
    . '<p>A mandala é uma concentração de energia. É importante conhecer seu significado e não utilizar apenas por estar na moda ou ser bonita.</p>'
    . '<p>Mandalas não são apenas uma forma. Sua energia tem o poder de levar a estados de meditação, tranquilidade e harmonia. Ela possui propriedades relaxantes e espirituais, pois está carregada de uma energia que irá penetrar no ambiente que ela está.</p>',
    $pid
);
echo "✓  about_subtitle / about_title / about_text\n";


// ─── 4. Aba: Download ────────────────────────────────────────────────────────
echo "\n── Aba: Download ────────────────────────\n";

update_field( 'download_subtitle', 'Download', $pid );
update_field( 'download_title', 'Vamos construir Mandalas?', $pid );

// Insere um placeholder se não tiver ainda
update_field( 'download_form_shortcode', '[contact-form-7 id="0" title="Formulário Mandalas"]', $pid );

update_field( 'download_info_title', 'Preencha o formulário para receber a sua Mandala.', $pid );
update_field( 'download_info_text', 
    '<p>Sente-se em um lugar tranquilo e pegue uma folha de papel branco. Em primeiro lugar você precisa saber a sua intenção, quer fazer uma mandala para o amor, prosperidade, tranquilidade, cura, pequena, grande… Depois de escolher todas as características conforme seu desejo ou necessidade, comece a desenhar! Deixe seu coração guiar suas mãos.</p>'
    . '<p>Tanto criar uma mandala como pintar / colorir mandalas pode ser um exercício relaxante, que promove serenidade, paz, harmonia.</p>',
    $pid
);
echo "✓  download_subtitle / download_title / download_info_title / download_info_text\n";


// ─── Resultado ────────────────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "✅  Concluído! Página Mandala (ID: $pid)\n";
echo '🔗  ' . get_permalink( $pid ) . "\n";
echo "════════════════════════════════════════\n";
echo "\n📋  PENDÊNCIAS PARA O PAINEL:\n";
echo "   • Substituir o shortcode do formulário em 'Download' pelo shortcode correto do Contact Form 7 ou WPForms.\n\n";

