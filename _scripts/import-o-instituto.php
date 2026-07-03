<?php
/**
 * Script de Importação — Página O Instituto - ITK
 * ====================================================
 * Como executar (no shell do LocalWP):
 *   wp eval-file "D:\Clientes\Localsites\itk-treinamentos\_scripts\import-o-instituto.php" --path="D:\Clientes\Localsites\itk-treinamentos\wp-site\app\public"
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

// ─── 1. Localizar a página O Instituto ───────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "  IMPORT: Página O Instituto\n";
echo "════════════════════════════════════════\n\n";

$page = get_page_by_path( 'o-instituto' ) ?: get_page_by_title( 'O Instituto' );
if ( ! $page ) {
    // Se não encontrou, tenta ver se a página 14 (configurada no ACF) existe
    $page = get_post( 14 );
    if ( ! $page || $page->post_type !== 'page' ) {
        echo "✗  Página 'O Instituto' não encontrada. Crie uma página com slug 'o-instituto'.\n"; 
        return;
    }
}
$pid = $page->ID;
echo "📄  Página encontrada: \"{$page->post_title}\" (ID: $pid)\n\n";

update_post_meta( $pid, '_wp_page_template', 'page-instituto.php' ); // Se houver um template específico
echo "✓  Ajustando meta de template se aplicável.\n";

// ─── 2. Aba: Banner Principal ────────────────────────────────────────────────
echo "\n── Aba: Banner Principal ────────────────\n";

$banner_bg = _import_theme_image( 'bg-banner-o-instituto.webp', 'Banner O Instituto' );
if ( $banner_bg ) { update_field( 'banner_bg_image', $banner_bg, $pid ); echo "✓  banner_bg_image\n"; }

update_field( 'banner_title', 'O Instituto', $pid );
update_field( 'banner_watermark', 'ITK', $pid );
echo "✓  banner_title / banner_watermark\n";

// ─── 3. Aba: História e Contadores ───────────────────────────────────────────
echo "\n── Aba: História e Contadores ───────────\n";

$counters = [
    [ 'counter_prefix' => '+', 'counter_number' => '105', 'counter_suffix' => 'mil', 'counter_title' => 'Pessoas treinadas' ],
    [ 'counter_prefix' => '+', 'counter_number' => '1200', 'counter_suffix' => '', 'counter_title' => 'Treinamentos Leader Training' ],
    [ 'counter_prefix' => '+', 'counter_number' => '450', 'counter_suffix' => 'mil', 'counter_title' => 'Seguidores nas redes sociais' ],
];
update_field( 'counters_list', $counters, $pid );
echo '✓  counters_list: ' . count( $counters ) . " itens\n";

update_field( 'about_subtitle', 'Sobre', $pid );
update_field( 'about_title', 'Conheça a história do ITK Treinamentos', $pid );
update_field( 'about_text', 
    '<p>A história do ITK Treinamentos tem início em 2001 e é, na essência, a história do seu idealizador e fundador, Tadashi Kadomoto. Desde 1982, Tadashi Kadomoto já ministrava treinamentos para a área comercial, quando então tomou consciência de sua missão de vida: contribuir efetivamente para despertar nas pessoas o desejo da vida e a sua capacidade de ser feliz.</p>'
    . '<p>Para Tadashi, apenas o fato de existir já pressupõe um agradecimento que, para ele, deveria ser transformado em ajuda ao próximo, para que ele pudesse viver bem consigo mesmo e em grupo. Dessa forma, inicia-se uma trajetória plena de amor ao próximo.</p>'
    . '<p>O auto-conhecimento é o cerne da história de Tadashi e do ITK. Nesse caminho, o Instituto busca, com sua equipe multidisciplinar qualificada, contribuir para que alguém respire melhor, seja por um sorriso, uma vivência, um abraço ou mesmo uma flor. Como visão de futuro, o Instituto almeja ser um agente catalizador das coisas boas, na esperança de trazer mais amor às pessoas e Paz ao mundo.</p>'
    . '<p>Assim, toda sua equipe, coordenada e inspirada pelo exemplo do seu fundador, trabalha para fazer seu papel transformador na vida das pessoas que procuram o Instituto, construindo assim um alicerce sólido, baseado na afetividade, na permanente troca, na solidariedade e no bem-viver.</p>',
    $pid
);
echo "✓  about_subtitle / about_title / about_text\n";

// ─── 4. Aba: Galeria de Fotos ────────────────────────────────────────────────
echo "\n── Aba: Galeria de Fotos ────────────────\n";

$gallery = [
    [ 'image' => _import_theme_image( 'galeria1.jpg', 'Galeria 1' ) ],
    [ 'image' => _import_theme_image( 'galeria2.jpg', 'Galeria 2' ) ],
    [ 'image' => _import_theme_image( 'galeria3.jpg', 'Galeria 3' ) ],
    [ 'image' => _import_theme_image( 'galeria4.jpg', 'Galeria 4' ) ],
];
update_field( 'gallery_images', $gallery, $pid );
echo "✓  gallery_images: 4 imagens únicas importadas\n";


// ─── 5. Aba: Psicologia Transpessoal ─────────────────────────────────────────
echo "\n── Aba: Psicologia Transpessoal ─────────\n";

update_field( 'transpessoal_title', 'O que é Psicologia Transpessoal?', $pid );
update_field( 'transpessoal_text',
    '<p>A Psicologia Transpessoal estuda os diferentes níveis de consciência e suas relações com a percepção de realidade, crenças, valores, ação, doença e saúde das pessoas. Nesse processo, evidencia uma fase adiantada da evolução humana, posterior à instintiva, emocional e mental. Fundamentada em 1986 por Abraham Maslow, James Fadiman, S. Grof, Victor Frankl e Antony Sutich, propicia, simultaneamente, uma nova perspectiva diante da ciência e da religião.</p>'
    . '<p>Vê o homem como um ser bio-psico-social e cósmico, reestabelecendo a possibilidade de se viver a unidade fundamental, homem-cosmo. Inclui os aspectos do desenvolvimento psíquico já estabelecidos pela psicologia clássica, ampliando-os. Trabalha com o ser humano, de forma ampla, permitindo sua plena integração e constante evolução e transformação.</p>'
    . '<p>Atuando com a Psicologia Transpessoal o profissional conta com o conhecimento e o aprendizado dos conceitos de Psicologia e Psicoterapia Transpessoal, além do contato com as várias dimensões da consciência humana e suas aplicações na psicologia.</p>',
    $pid
);
update_field( 'transpessoal_quote', '“Que haja amor, compaixão e paz entre todos os seres do universo.”', $pid );

$trans_img = _import_theme_image( 'imagens-site/750x750/750x750.png', 'Imagem Transpessoal' );
if ( $trans_img ) { update_field( 'transpessoal_image', $trans_img, $pid ); echo "✓  transpessoal_image\n"; }
echo "✓  transpessoal_title / transpessoal_text / transpessoal_quote\n";


// ─── 6. Aba: Nosso Time ──────────────────────────────────────────────────────
echo "\n── Aba: Nosso Time ──────────────────────\n";

update_field( 'team_subtitle', 'Nosso time', $pid );
update_field( 'team_title', 'Equipe ITK Treinamentos', $pid );
update_field( 'team_text', 'Nossa equipe de terapeutas é apaixonada por ajudar pessoas a alcançar o bem-estar. Com experiência e compromisso, eles oferecem suporte terapêutico personalizado para promover transformação e crescimento pessoal.', $pid );
echo "✓  team_subtitle / team_title / team_text\n";

$raw_team = [
    [ 'name' => 'Amine Tarek', 'role' => 'Terapeuta', 'img' => 'Amine-Tarek-scaled.jpg' ],
    [ 'name' => 'Bruno Malatrasi', 'role' => 'Terapeuta', 'img' => 'Bruno-Cesar-Malatrasi-Silva_Easy-Resize.com_-e1756331126781-773x1024.jpg' ],
    [ 'name' => 'Carla Nacif Kadomoto', 'role' => 'Terapeuta', 'img' => 'Carla-Nacif-Kadomoto_Easy-Resize.com_-e1756331143495-773x1024.jpg' ],
    [ 'name' => 'Carlos Roberto S. M. Ciarlo', 'role' => 'Terapeuta', 'img' => 'Carlos-Roberto-S.-M.-Ciarlo_Easy-Resize.com_.jpg' ],
    [ 'name' => 'Elaine Lopes', 'role' => 'Terapeuta', 'img' => 'Elaine-Lopes_Easy-Resize.com_.jpg' ],
    [ 'name' => 'Evelin Elias', 'role' => 'Terapeuta', 'img' => 'Evelin-Elias_Easy-Resize.com_.jpg' ],
    [ 'name' => 'Faustto Rosa', 'role' => 'Terapeuta', 'img' => 'Faustto-Oswaldo-de-Rosa-scaled.jpg' ],
    [ 'name' => 'Felipe Zillo', 'role' => 'Terapeuta', 'img' => 'Felipe-Zillo-scaled.jpg' ],
    [ 'name' => 'Flávia Tonissi Arnosti', 'role' => 'Terapeuta', 'img' => 'itk-treinamentos-equipe-flavia-tonissi.jpg' ],
    [ 'name' => 'Gerson Ramos de Almeida', 'role' => 'Terapeuta', 'img' => 'Gerson-Ramos-de-Almeida_Easy-Resize.com_.jpg' ],
    [ 'name' => 'Heloisa Helena Lacerda Calil', 'role' => 'Terapeuta', 'img' => 'itk-treinamentos-equipe-heloisa-helena.jpg' ],
    [ 'name' => 'Ingrid Prates', 'role' => 'Terapeuta', 'img' => 'Ingrid-Prates-scaled.jpg' ],
    [ 'name' => 'Ivana Rodrigues', 'role' => 'Terapeuta', 'img' => 'Ivana-Rodrigues_Easy-Resize.com_.jpg' ],
    [ 'name' => 'João de Souza Filho', 'role' => 'Terapeuta', 'img' => 'Joao-de-Souza-Filho_Easy-Resize.com_.jpg' ],
    [ 'name' => 'Julia Kadomoto', 'role' => 'Terapeuta', 'img' => 'Julia-Nacif-Kadomoto-scaled.jpg' ],
    [ 'name' => 'Maria Gomes de Carvalho Filha', 'role' => 'Terapeuta', 'img' => 'itk-treinamentos-equipe-maria-gomes.jpg' ],
    [ 'name' => 'Maria Tereza Vitor', 'role' => 'Terapeuta', 'img' => 'itk-treinamentos-maria-tereza-vitor.jpg' ],
    [ 'name' => 'Mariene Rodrigues', 'role' => 'Terapeuta', 'img' => 'Mariene-Rodrigues-scaled.jpg' ],
    [ 'name' => 'Nielson Brambati', 'role' => 'Terapeuta', 'img' => 'Nielson-Roberto-Santana-scaled.jpg' ],
    [ 'name' => 'Rafael Kadomoto', 'role' => 'Terapeuta', 'img' => 'Rafael-Kadomoto_Easy-Resize.com_-e1756331105600-773x1024.jpg' ],
    [ 'name' => 'Robson Hamuche', 'role' => 'Terapeuta', 'img' => 'itk-treinamentos-equipe-robson-hamuche.jpg' ],
    [ 'name' => 'Tadashi Kadomoto', 'role' => 'Cargo/Profissão', 'img' => 'Tadashi-Kadomoto-scaled-e1756330599930.jpg' ],
    [ 'name' => 'Valdir Pinto de Souza Júnior', 'role' => 'Terapeuta', 'img' => 'Valdir-Pinto-de-Souza-Junior-scaled.jpg' ],
];

$team_members = [];
foreach ( $raw_team as $person ) {
    $img_id = _import_theme_image( $person['img'], "Equipe ITK - {$person['name']}" );
    $team_members[] = [
        'member_image'     => $img_id,
        'member_name'      => $person['name'],
        'member_role'      => $person['role'],
        'member_linkedin'  => 'http://www.linkedin.com/', // do HTML
        'member_instagram' => 'https://www.instagram.com/', // do HTML
    ];
}

update_field( 'team_members', $team_members, $pid );
echo '✓  team_members: ' . count( $team_members ) . " membros\n";

// ─── Resultado ────────────────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "✅  Concluído! Página O Instituto (ID: $pid)\n";
echo '🔗  ' . get_permalink( $pid ) . "\n";
echo "════════════════════════════════════════\n\n";

