<div class="side-bar2">
    <button class="sidebar-close"></button>
    <div class="form-widget side-widget2 mb-0">
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="text" name="s" placeholder="Pesquisar" value="<?php echo get_search_query(); ?>" required>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    
    <div class="ser-widget side-widget2">
        <h4 class="side-bar-title">Categorias</h4>
        <?php
        $categories = get_categories( array(
            'orderby' => 'name',
            'order'   => 'ASC'
        ) );
        foreach( $categories as $category ) {
            echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( $category->name ) . '">' . esc_html( $category->name ) . '</a>';
        }
        ?>
    </div>
    
    <div class="post-widget side-widget2">
        <h4 class="side-bar-title">Posts recentes</h4>
        <?php
        $recent_posts = new WP_Query( array(
            'posts_per_page'      => 3,
            'ignore_sticky_posts' => true
        ) );
        if ( $recent_posts->have_posts() ) :
            while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
        ?>
        <div class="recent-post">
            <?php if ( has_post_thumbnail() ): ?>
                <?php the_post_thumbnail('thumbnail'); ?>
            <?php else: ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog1.webp" alt="<?php the_title_attribute(); ?>">
            <?php endif; ?>
            <span class="sub-title"><?php echo get_the_date('j M. Y'); ?></span>
            <h4 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
        </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
    
    <div class="archive-widget side-widget2">
        <h4 class="side-bar-title">Arquivo</h4>
        <?php
        $archives = wp_get_archives( array(
            'type'            => 'monthly',
            'limit'           => 6,
            'format'          => 'custom',
            'before'          => '',
            'after'           => '',
            'show_post_count' => false,
            'echo'            => 0
        ) );
        echo $archives;
        ?>
    </div>
    
    <div class="tag-list-widget side-widget2">
        <h4 class="side-bar-title">Tags</h4>
        <ul class="tag-list">
            <?php
            $tags = get_tags();
            if ( $tags ) {
                foreach ( $tags as $tag ) {
                    echo '<li><a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" title="' . esc_attr( $tag->name ) . '">/ ' . esc_html( $tag->name ) . ' /</a></li>';
                }
            }
            ?>
        </ul>
    </div>
</div>
