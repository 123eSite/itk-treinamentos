<?php
/**
 * Script de Importação — Página Inicial (Home) - ITK
 * ====================================================
 * Como executar (no shell do LocalWP):
 *   wp eval-file "D:\Clientes\Localsites\itk-treinamentos\_scripts\import-home.php" --path="D:\Clientes\Localsites\itk-treinamentos\wp-site\app\public"
 */

// ─── Helper de importação de imagem ──────────────────────────────────────────
function _import_theme_image( string $filename, string $title ): int {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    // A pasta de imagens do tema ITK é /assets/images/
    $src = get_template_directory() . '/assets/images/' . ltrim( $filename, '/' );
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
    $dest   = trailingslashit( $upload['path'] ) . basename($filename);
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
if ( ! $pid ) { echo "✗  Nenhuma página estática definida como página inicial.\n   Vá em Configurações → Leitura e defina a página inicial no WordPress.\n"; return; }

$page = get_post( $pid );
echo "📄  Página encontrada: \"{$page->post_title}\" (ID: $pid)\n\n";

update_post_meta( $pid, '_wp_page_template', 'front-page.php' );
echo "✓  Template: front-page.php\n";

// ─── 2. Aba: Banner Principal ────────────────────────────────────────────────
echo "\n── Aba: Banner Principal ────────────────\n";

$slides = [
    [
        'hero_image'            => _import_theme_image( 'slider3.webp', 'Slider 1' ),
        'hero_title'            => "Cursos e treinamentos\n de desenvolvimento \ne inteligência emocional",
        'hero_desc'             => 'Aprimore suas habilidades pessoais e profissionais com formações práticas, humanas e aplicáveis no dia a dia.',
        'hero_link'             => [ 'url' => '#', 'title' => 'Mais informações', 'target' => '_self' ],
        'hero_badge'            => 'PRÓXIMA TURMA',
        'hero_date'             => '06 a 08 de Março',
        'hero_course_title'     => 'Leader Training — Desperte seu Lider Interior',
        'hero_course_highlight' => "Últimas vagas para\n a imersão de março.",
        'hero_course_link'      => [ 'url' => '#', 'title' => 'Garanta sua vaga', 'target' => '_self' ],
    ],
    [
        'hero_image'            => _import_theme_image( 'slider2.webp', 'Slider 2' ),
        'hero_title'            => "Aprenda, cresça e transforme sua forma de agir e liderar",
        'hero_desc'             => 'Treinamentos pensados para fortalecer sua mente, sua comunicação e sua capacidade de tomar decisões com equilíbrio.',
        'hero_link'             => [ 'url' => '#', 'title' => 'Mais informações', 'target' => '_self' ],
        'hero_badge'            => 'PRÓXIMA TURMA',
        'hero_date'             => '06 a 08 de Março',
        'hero_course_title'     => 'Leader Training — Desperte seu Lider Interior',
        'hero_course_highlight' => "Últimas vagas para\n a imersão de março.",
        'hero_course_link'      => [ 'url' => '#', 'title' => 'Garanta sua vaga', 'target' => '_self' ],
    ],
];

update_field( 'hero_slides', $slides, $pid );
echo '✓  hero_slides: ' . count( $slides ) . " slides\n";

// ─── 3. Aba: Sobre o Instituto ───────────────────────────────────────────────
echo "\n── Aba: Sobre o Instituto ───────────────\n";

update_field( 'about_subtitle', 'Sobre', $pid );
update_field( 'about_title', 'O ITK transformou a vida de milhares de pessoas nos últimos 30 anos', $pid );
update_field( 'about_counter_number', '100', $pid );
update_field( 'about_counter_prefix', '+', $pid );
update_field( 'about_counter_suffix', 'mil', $pid );
update_field( 'about_counter_desc', 'Pessoas transformadas', $pid );
update_field( 'about_text',
    '<p>O ITK Treinamentos é especializado em treinamento comportamental, desenvolvimento pessoal e crescimento, com a missão de ajudar os participantes a se conscientizarem de sua missão neste mundo. Nossos programas visam destacar as repercussões, tanto positivas quanto negativas, de cada ação, palavra e gesto, capacitando-os para gerar impactos significativos.</p>'
    . '<p>Acreditamos no poder transformador das pessoas e buscamos guiá-las em sua jornada de autodescoberta e autodesenvolvimento, capacitando-as a criar um futuro mais promissor para si mesmas e para a sociedade como um todo.</p>',
    $pid
);
update_field( 'about_link', [ 'url' => '#', 'title' => 'Conheça o Instituto', 'target' => '_self' ], $pid );

echo "✓  about_subtitle / about_title / about_text / about_link\n";
echo "✓  Campos de contador\n";

// ─── 4. Aba: Depoimentos ─────────────────────────────────────────────────────
echo "\n── Aba: Depoimentos ─────────────────────\n";

update_field( 'testi_subtitle', 'depoimentos', $pid );
update_field( 'testi_title', 'Para quem é indicado os nossos treinamentos', $pid );
update_field( 'testi_desc', 'Para pessoas que desejam encontrar seu propósito de vida e estão interessados em melhorar seu desenvolvimento emocional, pessoal e profissional. O ITK Treinamentos tem como principal objetivo direcionar as pessoas em uma jornada de descoberta e utilização de seu potencial interior, com foco no gerenciamento das emoções.', $pid );

$testi_img = _import_theme_image( 'treinamento-dpp-itk-scaled.webp', 'Para quem é indicado' );
if ( $testi_img ) { update_field( 'testi_image', $testi_img, $pid ); echo "✓  testi_image\n"; }

$testi_logo = _import_theme_image( 'logos/favicon.png', 'Logo Autor Depoimento' );

$testimonials = [
    [
        'author_logo'    => $testi_logo,
        'text'           => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Impedit eius aliquam sunt ipsum, quod atque suscipit, reiciendis iste culpa magni similique adipisci possimus dolores. Recusandae maxime molestias eaque officia corporis?',
        'author_details' => '- Nome do cliente, Cargo - Empresa',
    ],
    [
        'author_logo'    => $testi_logo,
        'text'           => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Impedit eius aliquam sunt ipsum, quod atque suscipit, reiciendis iste culpa magni similique adipisci possimus dolores. Recusandae maxime molestias eaque officia corporis?',
        'author_details' => '- Nome do cliente, Cargo - Empresa',
    ],
];

update_field( 'testimonials', $testimonials, $pid );
echo '✓  testimonials: ' . count( $testimonials ) . " depoimentos\n";
echo "⚠  Depoimentos estão como Lorem Ipsum (vindos do HTML) — preencher no painel!\n";

// ─── 5. Aba: Cursos e Treinamentos ───────────────────────────────────────────
echo "\n── Aba: Cursos e Treinamentos ───────────\n";

update_field( 'courses_subtitle', 'Cursos e treinamentos', $pid );
update_field( 'courses_title', 'Mais consciência, mais realização', $pid );
update_field( 'courses_desc', 'Amplie sua percepção, sua consciência sobre o mundo, sobre si mesmo e lidere sua própria vida em direção à realização dos seus sonhos.', $pid );

$courses = [
    [ 'course_image' => _import_theme_image( 'Leader-Training.webp', 'Leader Training' ), 'course_link' => [ 'url' => '#', 'title' => '', 'target' => '_self' ] ],
    [ 'course_image' => _import_theme_image( 'Leader-Training-2-1.jpg', 'Leader Training 2' ), 'course_link' => [ 'url' => '#', 'title' => '', 'target' => '_self' ] ],
    [ 'course_image' => _import_theme_image( 'transformacao.jpg', 'Transformação' ), 'course_link' => [ 'url' => '#', 'title' => '', 'target' => '_self' ] ],
    [ 'course_image' => _import_theme_image( 'acreditando-em-voce.jpg', 'Acreditando em você' ), 'course_link' => [ 'url' => '#', 'title' => '', 'target' => '_self' ] ],
    [ 'course_image' => _import_theme_image( 'reiki.jpg', 'Reiki' ), 'course_link' => [ 'url' => '#', 'title' => '', 'target' => '_self' ] ],
];

update_field( 'courses_list', $courses, $pid );
echo '✓  courses_list: ' . count( $courses ) . " cursos\n";

// ─── 6. Aba: Para Você ───────────────────────────────────────────────────────
echo "\n── Aba: Para Você ───────────────────────\n";

update_field( 'pv_subtitle', 'Para você', $pid );
update_field( 'pv_title', 'Materiais e experiências para você', $pid );

$pv_items = [
    [
        'icon'  => _import_theme_image( 'service/ser2-2.svg', 'Ícone Projeto de vida' ),
        'title' => 'Projeto de vida',
        'desc'  => 'Defina suas metas e construa o sucesso e a felicidade que você merece! Um projeto de vida é um guia, uma fonte, o caminho para transformar seus desejos e sonhos em realidade.',
        'link'  => [ 'url' => '#', 'title' => 'Acesse agora', 'target' => '_self' ],
    ],
    [
        'icon'  => _import_theme_image( 'service/ser2-3.svg', 'Ícone Mandala' ),
        'title' => 'Mandala',
        'desc'  => 'Mandalas são desenhos de formas geométricas concêntricas. Ou seja, que se desenvolvem a partir de um mesmo centro. Criar uma mandala pode ser um exercício relaxante, que promove serenidade, paz, harmonia.',
        'link'  => [ 'url' => '#', 'title' => 'Acesse agora', 'target' => '_self' ],
    ],
];

update_field( 'pv_items', $pv_items, $pid );
echo "✓  pv_subtitle / pv_title / pv_items\n";

$banner_med_img = _import_theme_image( 'meditacao-diaria.webp', 'Meditação Diária' );
if ( $banner_med_img ) { update_field( 'pv_banner_meditacao_img', $banner_med_img, $pid ); echo "✓  pv_banner_meditacao_img\n"; }
update_field( 'pv_banner_meditacao_link', [ 'url' => '#', 'title' => '', 'target' => '_self' ], $pid );

$banner_loja_img = _import_theme_image( 'loja-virtual.webp', 'Loja Virtual' );
if ( $banner_loja_img ) { update_field( 'pv_banner_loja_img', $banner_loja_img, $pid ); echo "✓  pv_banner_loja_img\n"; }
update_field( 'pv_banner_loja_title', 'Pensado especialmente para você!', $pid );
update_field( 'pv_banner_loja_desc', 'Conheça nossa loja virtual. Acesse já!', $pid );
update_field( 'pv_banner_loja_link', [ 'url' => '#', 'title' => '', 'target' => '_self' ], $pid );

// ─── 7. Aba: Blog ────────────────────────────────────────────────────────────
echo "\n── Aba: Blog ────────────────────────────\n";

update_field( 'blog_subtitle', 'Artigos e Notícias', $pid );
update_field( 'blog_title', 'Fique por dentro das últimas matérias e novidades', $pid );
update_field( 'blog_link', [ 'url' => '#', 'title' => 'Acesse todos', 'target' => '_self' ], $pid );

echo "✓  blog_subtitle / blog_title / blog_link\n";

// ─── Resultado ────────────────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "✅  Concluído! Página ID: $pid\n";
echo '🔗  ' . get_permalink( $pid ) . "\n";
echo "════════════════════════════════════════\n";
echo "\n📋  PENDÊNCIAS PARA O PAINEL:\n";
echo "   • Atualizar os links (vários botões e banners estão com o link '#')\n";
echo "   • Substituir os depoimentos 'Lorem Ipsum' por textos reais\n\n";

