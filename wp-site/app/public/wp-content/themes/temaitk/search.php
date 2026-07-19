<?php
get_header();

// Obtém o ID da página configurada como Blog para puxar os campos ACF do banner (se houver)
$blog_page_id = get_option('page_for_posts');

// Banner details
$banner_bg_image = get_field('banner_bg_image', $blog_page_id);
$banner_watermark = get_field('banner_watermark', $blog_page_id);

// Título da pesquisa
$search_query = get_search_query();
$archive_title = 'Resultados para: "' . $search_query . '"';
?>

<!-- page-banner9 -->
<section class="bread-crums-section">
    <div class="container2">
        <div class="page-banner11">
            <?php if (!empty($banner_bg_image)): ?>
                <img class="bg" src="<?php echo esc_url($banner_bg_image['sizes']['banner-internas']); ?>"
                    alt="<?php echo esc_attr($banner_bg_image['alt']); ?>">
            <?php else: ?>
                <img class="bg" src="<?php echo get_template_directory_uri(); ?>/assets/images/banner-blog.webp" alt="">
            <?php endif; ?>
            
            <div class="shape"></div>
            <div class="shape3"></div>
            
            <?php if ($banner_watermark): ?>
                <div class="staff-text"><?php echo esc_html($banner_watermark); ?></div>
            <?php else: ?>
                <div class="staff-text">ITK</div>
            <?php endif; ?>
            
            <div class="page-content">
                <h1 class="title"><?php echo esc_html($archive_title); ?></h1>
            </div>
            <ul class="breadcrumbs">
                <li><a href="<?php echo home_url(); ?>" title="Home">Home</a></li>
                <li>/</li>
                <li><a href="<?php echo get_permalink($blog_page_id); ?>" title="Blog">Blog</a></li>
                <li>/</li>
                <li>Pesquisa</li>
            </ul>
        </div>
    </div>
</section>
<!-- End page-banner9 -->

<!-- blog-sec -->
<section class="blog-sec v2 ibt-section-gap">
    <div class="container">
        <div class="row">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            
            // Query customizada para forçar a busca APENAS em posts
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                's' => $search_query,
                'paged' => $paged,
            );
            $search_wp_query = new WP_Query($args);
            
            if ($search_wp_query->have_posts()):
                while ($search_wp_query->have_posts()):
                    $search_wp_query->the_post(); ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="blog-card h-100">
                            <div class="blog-img">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('thumb-blog', ['alt' => get_the_title()]); ?>
                                    <?php else: ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog1.webp"
                                            alt="<?php the_title_attribute(); ?>">
                                    <?php endif; ?>
                                </a>
                                <span class="blog-meta"><?php echo get_the_date('j \d\e F \d\e Y'); ?></span>
                            </div>
                            <div class="blog-content">
                                <h4 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        <?php the_title(); ?></a>
                                </h4>
                                <span>
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo esc_html($categories[0]->name);
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

                <div class="col-12 mt-4 text-center">
                    <?php
                    $total_pages = $search_wp_query->max_num_pages;
                    if ($total_pages > 1) {
                        $current_page = max(1, get_query_var('paged'));
                        echo paginate_links(array(
                            'base' => get_pagenum_link(1) . '%_%',
                            'format' => 'page/%#%',
                            'current' => $current_page,
                            'total' => $total_pages,
                            'prev_text' => __('Anterior', 'temaitk'),
                            'next_text' => __('Próximo', 'temaitk'),
                        ));
                    }
                    ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="col-12">
                    <p>Nenhum post encontrado para "<strong><?php echo esc_html($search_query); ?></strong>".</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
get_footer();
