<?php
/**
 * Template Name: Landing Page
 */
get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();

        if ( have_rows( 'conteudo_lp' ) ) :
            while ( have_rows( 'conteudo_lp' ) ) : the_row();
                get_template_part( 'lp-sections/' . get_row_layout() );
            endwhile;
        endif;
    endwhile;
endif;

get_footer();
