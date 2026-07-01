<?php
/**
 * Script de Importação — Página Inicial (Home)
 * =============================================
 * Como executar (no shell do LocalWP):
 *   wp eval-file "D:\Clientes\Localsites\casas-andre-luiz\_scripts\import-home.php" --path="D:\Clientes\Localsites\casas-andre-luiz\wp\app\public"
 */

// ─── Helper de importação de imagem ──────────────────────────────────────────
function _import_theme_image( string $filename, string $title ): int {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $src = get_template_directory() . '/img/' . $filename;
    if ( ! file_exists( $src ) ) { echo "  ⚠  Não encontrado: $filename\n"; return 0; }

    $slug     = sanitize_title( pathinfo( $filename, PATHINFO_FILENAME ) );
    $existing = get_posts( [ 'post_type' => 'attachment', 'post_status' => 'any', 'name' => $slug, 'posts_per_page' => 1 ] );
    if ( $existing ) { echo "  ↩  Já importado: $filename (ID: {$existing[0]->ID})\n"; return (int) $existing[0]->ID; }

    // Permite SVG temporariamente
    $allow_svg = function( $mimes ) { $mimes['svg'] = 'image/svg+xml'; return $mimes; };
    add_filter( 'upload_mimes', $allow_svg );
    add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename ) {
        if ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) === 'svg' ) {
            $data['ext'] = 'svg'; $data['type'] = 'image/svg+xml';
        }
        return $data;
    }, 10, 3 );

    $upload = wp_upload_dir();
    $dest   = trailingslashit( $upload['path'] ) . $filename;
    if ( ! copy( $src, $dest ) ) { echo "  ✗  Erro ao copiar: $filename\n"; remove_filter( 'upload_mimes', $allow_svg ); return 0; }

    $att_id = wp_insert_attachment( [ 'post_mime_type' => wp_check_filetype( $filename )['type'] ?: 'image/svg+xml', 'post_title' => $title, 'post_name' => $slug, 'post_status' => 'inherit' ], $dest );
    if ( is_wp_error( $att_id ) ) { echo "  ✗  {$att_id->get_error_message()}\n"; remove_filter( 'upload_mimes', $allow_svg ); return 0; }

    wp_update_attachment_metadata( $att_id, wp_generate_attachment_metadata( $att_id, $dest ) );
    echo "  ✓  Importado: $filename (ID: $att_id)\n";
    remove_filter( 'upload_mimes', $allow_svg );
    return (int) $att_id;
}

// ─── 1. Localizar a página inicial ───────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "  IMPORT: Página Inicial (Home)\n";
echo "════════════════════════════════════════\n\n";

$pid = (int) get_option( 'page_on_front' );
if ( ! $pid ) { echo "✗  Nenhuma página estática definida como página inicial.\n   Vá em Configurações → Leitura e defina a página inicial.\n"; return; }

$page = get_post( $pid );
echo "📄  Página encontrada: \"{$page->post_title}\" (ID: $pid)\n\n";

update_post_meta( $pid, '_wp_page_template', 'front-page.php' );
echo "✓  Template: front-page.php\n";

// ─── 2. Slider Principal (Repeater) ──────────────────────────────────────────
echo "\n── Aba: Slider Principal ────────────────\n";

$slider_imgs = [
    _import_theme_image( 'slider1.jpg', 'Slider 1 – Doe seu eletroeletrônico' ),
    _import_theme_image( 'slider2.jpg', 'Slider 2 – Ambulatório CER II'       ),
    _import_theme_image( 'slider3.jpg', 'Slider 3 – Um inverno aquecido'       ),
];

$slides = [
    [
        'imagem' => $slider_imgs[0],
        'titulo' => "Doe seu\neletroeletrônico",
        'texto'  => 'Sua doação vira atendimento especializado e gratuito para pessoas com deficiência.',
        'botao'  => [ 'url' => '#', 'title' => 'DOAR AGORA', 'target' => '_self' ],
    ],
    [
        'imagem' => $slider_imgs[1],
        'titulo' => "Ambulatório de\nDeficiências CER II",
        'texto'  => 'Atendimentos especializados e gratuitos a mais de 1.200 pacientes da comunidade.',
        'botao'  => [ 'url' => '#', 'title' => 'DOAR AGORA', 'target' => '_self' ],
    ],
    [
        'imagem' => $slider_imgs[2],
        'titulo' => "Um inverno aquecido\ncom um coração solidário",
        'texto'  => 'Faça a sua doação de roupas, cobertores ou medicamentos.',
        'botao'  => [ 'url' => '#', 'title' => 'DOAR AGORA', 'target' => '_self' ],
    ],
];

// Remove slides sem imagem
$slides = array_filter( $slides, fn($s) => ! empty( $s['imagem'] ) );
update_field( 'home_slider', array_values( $slides ), $pid );
echo '✓  home_slider: ' . count( $slides ) . " slides\n";
echo "⚠  Links dos botões do slider estão como '#' — atualize depois\n";

// ─── 3. CER II Ambulatório ────────────────────────────────────────────────────
echo "\n── Aba: CER II Ambulatório ──────────────\n";

update_field( 'home_cer_subtitle', 'Centro Especializado em Reabilitação', $pid );
update_field( 'home_cer_title',    "CER II Casas André Luiz\nAmbulatório de Deficiências", $pid );
update_field( 'home_cer_desc',
    '<p>O CER II é um serviço de acesso, regulado pelo SIRESP e faz parte da Rede Regional de Atenção à Saúde 2. Oferece atendimento especializado a pessoas de todas as idades, acolhendo e apoiando, também, seus familiares. Referência no cuidado e proteção aos pacientes, visa proporcionar cuidados qualificados em saúde, com ênfase na reabilitação física e intelectual, por meio do acompanhamento médico, avaliações, terapias de reabilitação e Projeto Terapêutico Singular.</p>',
    $pid
);
update_field( 'home_cer_btn', [ 'url' => '#', 'title' => 'Conheça o novo ambulatório', 'target' => '_self' ], $pid );
echo "✓  home_cer_subtitle / home_cer_title / home_cer_desc / home_cer_btn\n";
echo "⚠  home_cer_btn com link '#' — atualize com a URL real\n";

echo "\n  Importando galeria do CER II...\n";
$amb_id = _import_theme_image( 'ambulatorio.jpg', 'Ambulatório CER II' );
if ( $amb_id ) {
    // Gallery field aceita array de IDs
    update_field( 'home_cer_gallery', [ $amb_id ], $pid );
    echo "✓  home_cer_gallery: 1 foto\n";
    echo "⚠  Adicione as fotos reais do ambulatório diretamente no painel\n";
}

// ─── 4. Números / Estatísticas (Repeater) ────────────────────────────────────
echo "\n── Aba: Números ─────────────────────────\n";

$num_icons = [
    _import_theme_image( 'ico-atendimento.svg',  'Ícone Atendimento'  ),
    _import_theme_image( 'ico-pacientes.svg',    'Ícone Pacientes'    ),
    _import_theme_image( 'ico-atendimentos.svg', 'Ícone Atendimentos' ),
    _import_theme_image( 'ico-voluntatio.svg',   'Ícone Voluntariado' ),
];

$numeros = [
    [ 'icone' => $num_icons[0], 'valor' => '100%',   'texto' => 'do atendimento gratuito à população' ],
    [ 'icone' => $num_icons[1], 'valor' => '2.487',  'texto' => 'pacientes atendidos em 2024' ],
    [ 'icone' => $num_icons[2], 'valor' => '57.705', 'texto' => 'atendimentos realizados pelo Ambulatório de Deficiências' ],
    [ 'icone' => $num_icons[3], 'valor' => '24.834', 'texto' => 'horas de trabalho voluntário' ],
];

$numeros = array_filter( $numeros, fn($n) => ! empty( $n['icone'] ) );
update_field( 'home_numbers', array_values( $numeros ), $pid );
echo '✓  home_numbers: ' . count( $numeros ) . " estatísticas\n";

// ─── 5. Mercatudo ─────────────────────────────────────────────────────────────
echo "\n── Aba: Mercatudo ───────────────────────\n";

$merca_img_id  = _import_theme_image( 'Campanha-Mercatudo-1.webp', 'Campanha Mercatudo' );
$merca_logo_id = _import_theme_image( 'logo-mercatudo.svg',         'Logo Mercatudo'     );

if ( $merca_img_id  ) { update_field( 'home_merca_img',  $merca_img_id,  $pid ); echo "✓  home_merca_img\n"; }
if ( $merca_logo_id ) { update_field( 'home_merca_logo', $merca_logo_id, $pid ); echo "✓  home_merca_logo\n"; }

update_field( 'home_merca_title', 'Mais que uma rede de bazares, a ponte entre sua solidariedade e os atendimentos especializados da Casas André Luiz.', $pid );
update_field( 'home_merca_text',  'Cada compra ou doação se transforma em recursos que mantêm nossos serviços gratuitos para pessoas com deficiência.', $pid );
update_field( 'home_merca_btn',   [ 'url' => '#', 'title' => 'Acesse o site do Mercatudo', 'target' => '_blank' ], $pid );
echo "✓  home_merca_title / home_merca_text / home_merca_btn\n";
echo "⚠  home_merca_btn com link '#' — atualize com a URL do site do Mercatudo\n";

// ─── 6. Últimas Notícias ──────────────────────────────────────────────────────
echo "\n── Aba: Últimas Notícias ────────────────\n";

update_field( 'home_news_subtitle', 'BLOG', $pid );
update_field( 'home_news_title',    'Notícias e Atualizações', $pid );
echo "✓  home_news_subtitle / home_news_title\n";
echo "   (Posts são puxados automaticamente do blog — sem configuração extra)\n";

// ─── 7. Depoimentos ───────────────────────────────────────────────────────────
echo "\n── Aba: Depoimentos ─────────────────────\n";

$testi_img_id = _import_theme_image( 'img-depoimento.png', 'Imagem Depoimentos' );
if ( $testi_img_id ) { update_field( 'home_testi_img', $testi_img_id, $pid ); echo "✓  home_testi_img\n"; }

update_field( 'home_testi_subtitle', 'Depoimentos', $pid );
echo "✓  home_testi_subtitle\n";

// Os depoimentos no HTML são Lorem Ipsum — criamos 1 item vazio como placeholder
update_field( 'home_testi_list', [
    [ 'texto' => '', 'autor' => '' ],
], $pid );
echo "⚠  home_testi_list → 1 item vazio criado (depoimentos eram Lorem Ipsum no HTML)\n";
echo "   Preencha com depoimentos reais diretamente no painel\n";

// ─── 8. FAQ ───────────────────────────────────────────────────────────────────
echo "\n── Aba: FAQ ─────────────────────────────\n";

update_field( 'home_faq_subtitle', 'Faq', $pid );
update_field( 'home_faq_title',    'Dúvidas frequentes', $pid );
echo "✓  home_faq_subtitle / home_faq_title\n";

// Apenas a 1ª pergunta tinha resposta real no HTML, as demais eram Lorem Ipsum
$faq_items = [
    [
        'pergunta' => 'O que é a Casas André Luiz?',
        'resposta' => '<p>A Casas André Luiz é uma instituição filantrópica, fundada em 1949, que oferece atendimento especializado e gratuito a pessoas com deficiência intelectual, com ou sem deficiência física associada.</p>',
    ],
    [
        'pergunta' => 'A Casas André Luiz é uma instituição religiosa?',
        'resposta' => '',  // resposta era Lorem Ipsum no HTML
    ],
    [
        'pergunta' => 'Quantas pessoas são atendidas pela instituição?',
        'resposta' => '',
    ],
    [
        'pergunta' => 'Quais serviços a Casas André Luiz oferece?',
        'resposta' => '',
    ],
    [
        'pergunta' => 'Como posso ajudar a Casas André Luiz?',
        'resposta' => '',
    ],
    [
        'pergunta' => 'O que posso doar?',
        'resposta' => '',
    ],
];

update_field( 'home_faq_list', $faq_items, $pid );
echo '✓  home_faq_list: ' . count( $faq_items ) . " perguntas\n";
echo "⚠  5 respostas do FAQ eram Lorem Ipsum — preencha no painel\n";

// ─── Resultado ────────────────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "✅  Concluído! Página ID: $pid\n";
echo '🔗  ' . get_permalink( $pid ) . "\n";
echo "════════════════════════════════════════\n";
echo "\n📋  PENDÊNCIAS PARA O PAINEL:\n";
echo "   • Links dos botões do slider\n";
echo "   • Link do botão CER II (URL real)\n";
echo "   • Link do botão Mercatudo (URL do site)\n";
echo "   • Galeria do CER II (fotos reais)\n";
echo "   • Depoimentos (textos reais)\n";
echo "   • 5 respostas do FAQ\n\n";
