<?php
/**
 * Script de Importação — Página Projeto de Vida - ITK
 * ==========================================================
 * Como executar (no shell do LocalWP):
 *   wp eval-file "D:\Clientes\Localsites\itk-treinamentos\_scripts\import-projeto-de-vida.php" --path="D:\Clientes\Localsites\itk-treinamentos\wp-site\app\public"
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
echo "  IMPORT: Página Projeto de Vida\n";
echo "════════════════════════════════════════\n\n";

$page = get_page_by_path( 'projeto-de-vida' ) ?: get_page_by_title( 'Projeto de vida' );
if ( ! $page ) {
    echo "✗  Página 'Projeto de Vida' não encontrada. Crie uma página com slug 'projeto-de-vida'.\n"; 
    return;
}
$pid = $page->ID;
echo "📄  Página encontrada: \"{$page->post_title}\" (ID: $pid)\n\n";

update_post_meta( $pid, '_wp_page_template', 'page-projeto.php' ); // Template custom se existir
echo "✓  Template assinalado (se aplicável)\n";


// ─── 2. Aba: Banner Principal ────────────────────────────────────────────────
echo "\n── Aba: Banner Principal ────────────────\n";

$banner_bg = _import_theme_image( 'cursos-e-treinamentos.webp', 'Banner Projeto de Vida' );
if ( $banner_bg ) { update_field( 'banner_bg_image', $banner_bg, $pid ); echo "✓  banner_bg_image\n"; }

update_field( 'banner_title', 'Projeto de vida', $pid );
update_field( 'banner_watermark', 'ITK', $pid );
echo "✓  banner_title / banner_watermark\n";


// ─── 3. Aba: Destaque Inicial (Hero) ─────────────────────────────────────────
echo "\n── Aba: Destaque Inicial (Hero) ─────────\n";

update_field( 'hero_title', 'Defina suas metas e construa o sucesso e a felicidade que você merece!', $pid );
update_field( 'hero_text', "Qual o seu sonho?\nO que você deseja realizar?", $pid );
echo "✓  hero_title / hero_text\n";


// ─── 4. Aba: Propósito e Direção ─────────────────────────────────────────────
echo "\n── Aba: Propósito e Direção ─────────────\n";

update_field( 'about_subtitle', 'Propósito e Direção', $pid );
update_field( 'about_title', 'Transforme seus sonhos em realidade', $pid );

$about_img = _import_theme_image( 'imagens-site/750x750.png', 'Imagem Propósito' );
if ( $about_img ) { update_field( 'about_image', $about_img, $pid ); echo "✓  about_image\n"; }

update_field( 'about_text', 
    '<p>Quais são as metas para sua vida pessoal, profissional, familiar, espiritual, financeira? Você já tem seus sonhos, metas e propósitos escritos e planejados? Que tal construir o seu projeto de vida?</p>'
    . '<p>Um projeto de vida é um guia, uma fonte, o caminho para transformar seus desejos e sonhos em realidade. É mais do que um grande “mapa”, é uma ferramenta para você usar diariamente e atingir seus objetivos.</p>'
    . '<p>O ITK Treinamentos convida você a preencher seu Projeto de Vida e colocar em prática as mudanças necessárias para que você alcance o SUCESSO e a FELICIDADE de uma maneira simples, planejada e consciente.</p>',
    $pid
);
echo "✓  about_subtitle / about_title / about_text\n";


// ─── 5. Aba: Como Funciona & Formulário ──────────────────────────────────────
echo "\n── Aba: Como Funciona & Formulário ──────\n";

update_field( 'steps_subtitle', 'Seu projeto de vida', $pid );
update_field( 'steps_title', 'Como funciona?', $pid );
update_field( 'steps_form_title', 'Preencha o formulário para receber o seu Projeto de vida.', $pid );
update_field( 'steps_form_shortcode', '[contact-form-7 id="0" title="Formulário Projeto de Vida"]', $pid ); // Placeholder

$steps = [
    [
        'step_icon'  => _import_theme_image( 'feature/feature11-5.svg', 'Ícone Passo 1' ),
        'step_title' => 'Faça seu cadastro',
        'step_text'  => 'Preencha os dados no formulário abaixo para receber o seu projeto de vida por e-mail.'
    ],
    [
        'step_icon'  => _import_theme_image( 'feature/feature2.svg', 'Ícone Passo 2' ),
        'step_title' => 'Defina o que você quer conquistar:',
        'step_text'  => 'Saúde Física, saúde espiritual, saúde social, saúde financeira ou saúde ecológica'
    ],
    [
        'step_icon'  => _import_theme_image( 'feature/feature3.svg', 'Ícone Passo 3' ),
        'step_title' => 'Desenvolva seu plano',
        'step_text'  => 'Elabore o seu plano de COMO e QUANDO (Estipule datas)'
    ],
    [
        'step_icon'  => _import_theme_image( 'feature/feature8.svg', 'Ícone Passo 4' ),
        'step_title' => 'Coloque em prática!',
        'step_text'  => 'Ação! Vá em busca dos seus sonhos! Boa sorte!'
    ]
];
update_field( 'steps_list', $steps, $pid );
echo '✓  steps_list: ' . count( $steps ) . " passos\n";


// ─── Resultado ────────────────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "✅  Concluído! Página Projeto de Vida (ID: $pid)\n";
echo '🔗  ' . get_permalink( $pid ) . "\n";
echo "════════════════════════════════════════\n";
echo "\n📋  PENDÊNCIAS PARA O PAINEL:\n";
echo "   • Substituir o shortcode em 'Como Funciona & Formulário' pelo shortcode correto.\n\n";

