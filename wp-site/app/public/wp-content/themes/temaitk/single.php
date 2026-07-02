<?php
get_header();

// Fetch banner fields from the Blog page options if available
$blog_page_id = get_option('page_for_posts');
$banner_bg_image = get_field('banner_bg_image', $blog_page_id);
$banner_watermark = get_field('banner_watermark', $blog_page_id);
?>

        <!-- page-banner9 -->
        <section class="bread-crums-section">
            <div class="container2">
                <div class="page-banner11">
                    <?php if( !empty($banner_bg_image) ): ?>
                    <img class="bg" src="<?php echo esc_url($banner_bg_image['sizes']['banner-internas']); ?>" alt="<?php echo esc_attr($banner_bg_image['alt']); ?>">
                    <?php endif; ?>
                    <div class="shape"></div>
                    <div class="shape3"></div>
                    <?php if( $banner_watermark ): ?>
                    <div class="staff-text"><?php echo esc_html($banner_watermark); ?></div>
                    <?php endif; ?>
                    <div class="page-content">
                        <h1 class="title">Blog</h1>
                    </div>
                    <ul class="breadcrumbs">
                        <li><a href="<?php echo home_url(); ?>" title="Home">Home</a></li>
                        <li>/</li>
                        <li><a href="<?php echo get_permalink($blog_page_id); ?>" title="Blog">Blog</a></li>
                        <li>/</li>
                        <li><?php the_title(); ?></li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- End page-banner9 -->

        <!-- blog-sec4 -->
        <section class="blog-single ibt-section-gap">
            <button class="sidebar-toggle"></button>
            <!-- Overlay -->
            <div class="sidebar-overlay"></div>
            
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-8">
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <div class="blog-single-content">
                            <div class="blog-img4 mb-5">
                                <?php if ( has_post_thumbnail() ): ?>
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?></a>
                                <?php endif; ?>
                                <span class="blog-meta4"><?php echo get_the_date('j M. Y'); ?> / <?php the_author(); ?></span>
                            </div>
                            
                            <div class="entry-content clr" itemprop="text">
                                <h2 class="mb-4"><?php the_title(); ?></h2>
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                        <div class="post-meta2 mt-5">
                            <h4 class="name">Por <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a></h4>
                            <ul class="tag-list">
                                <?php
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) {
                                    foreach( $categories as $category ) {
                                        echo '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( $category->name ) . '">/ ' . esc_html( $category->name ) . ' /</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                            <ul class="social-icon">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" title="Compartilhar no Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" title="Compartilhar no Twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" title="Compartilhar no LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                            </ul>
                        </div>
                        <?php endwhile; endif; ?>
                    </div>
                    
                    <div class="offset-lg-1 col-lg-4">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- End blog-sec4 -->

<?php
get_footer();
