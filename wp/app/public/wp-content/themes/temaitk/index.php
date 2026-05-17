<?php
/**
 * Fallback do tema (somente Landing Pages).
 * Páginas com template "Landing Page" usam template-landing-page.php.
 */
get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        if ( have_rows( 'conteudo_lp' ) ) :
            while ( have_rows( 'conteudo_lp' ) ) :
                the_row();
                get_template_part( 'lp-sections/' . get_row_layout() );
            endwhile;
        else :
            the_content();
        endif;
    endwhile;
endif;

get_footer();
