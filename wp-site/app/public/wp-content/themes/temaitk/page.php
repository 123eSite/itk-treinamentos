<?php
get_header();

global $post;
$slug = $post->post_name;

$map = array(
	'o-instituto'           => 'o-instituto',
	'cursos-e-treinamentos' => 'cursos-e-treinamentos',
	'mandala'               => 'mandala',
	'projeto-de-vida'       => 'projeto-de-vida',
	'blog'                  => 'blog',
);

$template_name = isset( $map[ $slug ] ) ? $map[ $slug ] : $slug;
$template_file = get_template_directory() . '/' . $template_name . '.php';

if ( file_exists( $template_file ) ) {
	include $template_file;
} else {
	// Fallback genérico para páginas sem template fatiado
    echo '<div class="container py-5 default-page"><div class="entry-content">';
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            the_content();
        }
    }
    echo '</div></div>';
}

get_footer();
