<?php



register_nav_menus(
	array(
		'menu-principal' => __('Menu principal', 'temaitk'),
		'menu-mobile' => __('Menu mobile', 'temaitk'),
	)
);

// Filtro para adicionar as tags <span> usadas para a animação do menu desktop
add_filter('nav_menu_item_title', 'temaitk_nav_menu_spans', 10, 4);
function temaitk_nav_menu_spans($title, $item, $args, $depth)
{
	// Adiciona o efeito apenas para itens de nível principal (depth == 0) no menu desktop
	if (isset($args->theme_location) && $args->theme_location === 'menu-principal' && $depth === 0) {
		return '<span class="menu-item">' . $title . '</span><span class="menu-item2">' . $title . '</span>';
	}
	return $title;
}



function temaitk_enqueue_assets()
{
	$template_uri = get_bloginfo('template_url');

	// Preconnect tags are usually added in header.php or via wp_head hooks, but for CSS imports we just enqueue the fonts.
	wp_enqueue_style('temaitk-sora', 'https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap', array(), null);
	wp_enqueue_style('temaitk-manrope', 'https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap', array(), null);

	wp_enqueue_style('temaitk-fontawesome', $template_uri . '/assets/css/font-awesome.min.css', array(), null);
	wp_enqueue_style('temaitk-fontello-enqueue', $template_uri . '/assets/css/plugins/fontello-enqueue.css', array(), null);
	wp_enqueue_style('temaitk-fontello-icons', $template_uri . '/assets/css/plugins/fontello-icons.css', array(), null);
	wp_enqueue_style('temaitk-bootstrap', $template_uri . '/assets/css/plugins/bootstrap.min.css', array(), null);
	wp_enqueue_style('temaitk-swiper', $template_uri . '/assets/css/plugins/swiper-bundle.min.css', array(), null);
	wp_enqueue_style('temaitk-lightgallery', $template_uri . '/assets/css/plugins/lightgallery-bundle.min.css', array(), null);
	wp_enqueue_style('temaitk-style', $template_uri . '/assets/css/style.css', array(), '1.0.0');

	// JS principais
	wp_enqueue_script('temaitk-bootstrap-js', $template_uri . '/assets/js/bootstrap.min.js', array(), null, true);
	wp_enqueue_script('temaitk-swiper-js', $template_uri . '/assets/js/vendor/swiper-bundle.min.js', array(), null, true);
	wp_enqueue_script('temaitk-lenis', $template_uri . '/assets/js/vendor/lenis.min.js', array(), null, true);
	wp_enqueue_script('temaitk-gsap', $template_uri . '/assets/js/vendor/gsap.min.js', array(), null, true);
	wp_enqueue_script('temaitk-scrolltrigger', $template_uri . '/assets/js/vendor/ScrollTrigger.min.js', array(), null, true);
	wp_enqueue_script('temaitk-main', $template_uri . '/assets/js/main.js', array('temaitk-bootstrap-js'), null, true);
}
add_action('wp_enqueue_scripts', 'temaitk_enqueue_assets');

function temaitk_setup()
{
	// Suporte nativo
	add_theme_support('menus');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	// ==============================================================================
	// TAMANHOS DE IMAGENS DO TEMA (Custom Image Sizes)
	// ==============================================================================
	// Aqui você pode configurar os recortes automáticos que o WP vai gerar
	// quando o usuário fizer upload via ACF ou Destacada.
	// Parâmetros: 'nome-do-tamanho', largura, altura, crop (true/false)

	add_image_size('banner-principal', 1880, 785, true); // Banner de topo das páginas
	add_image_size('banner-internas', 1920, 500, true); // Banner topo páginas internas
	add_image_size('bg-depoimentos', 763, 569, true); // Bg da seção depoimentos home
	add_image_size('card-curso', 400, 400, true);         // Cards de cursos e treinamentos
	add_image_size('blog', 743, 391, true);         // blog (posts)
	add_image_size('thumb-blog', 421, 221, true);         // Miniaturas do blog
	add_image_size('banner-home-1', 686, 485, true);         // Banner 1 home
	add_image_size('banner-home-2', 362, 485, true);         // Banner 2 home
	add_image_size('foto-equipe', 500, 662, true);        // Fotos do time (quadrado)
	add_image_size('img-galeria', 444, 296, true);        // Imagens de galerias
	add_image_size('img-half', 750, 750, true);        // Imagens de half
}
add_action('after_setup_theme', 'temaitk_setup');

// ==============================================================================
// ACF OPTIONS PAGE (Opções do Tema)
// ==============================================================================
if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title' => 'Opções do Tema',
		'menu_title' => 'Opções do Tema',
		'menu_slug' => 'opcoes-do-tema',
		'capability' => 'edit_posts',
		'redirect' => false,
		'position' => 2,
		'icon_url' => 'dashicons-admin-generic',
	));

}
