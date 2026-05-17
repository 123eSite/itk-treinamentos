<?php
/**
 * Template Name: Landing Page
 */
get_header();

if ( have_rows( 'conteudo_lp' ) ) :
    while ( have_rows( 'conteudo_lp' ) ) : the_row();
        get_template_part( 'lp-sections/' . get_row_layout() );
    endwhile;
endif;

get_footer();
