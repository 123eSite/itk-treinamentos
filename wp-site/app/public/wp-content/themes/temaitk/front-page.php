<?php
get_header();
?>

<!-- hero-style2 -->
<?php if (have_rows('hero_slides')): ?>
    <section class="hero-style6">
        <div class="swiper hero-slider2">
            <div class="swiper-wrapper">
                <?php while (have_rows('hero_slides')):
                    the_row();
                    $hero_image = get_sub_field('hero_image');
                    $hero_title = get_sub_field('hero_title');
                    $hero_desc = get_sub_field('hero_desc');
                    $hero_link = get_sub_field('hero_link');

                    $hero_badge = get_sub_field('hero_badge');
                    $hero_date = get_sub_field('hero_date');
                    $hero_course_title = get_sub_field('hero_course_title');
                    $hero_course_highlight = get_sub_field('hero_course_highlight');
                    $hero_course_link = get_sub_field('hero_course_link');
                    ?>
                    <div class="swiper-slide">
                        <div class="hero-content6">
                            <?php if (!empty($hero_image)): ?>
                                <img src="<?php echo esc_url($hero_image['sizes']['banner-principal']); ?>"
                                    alt="<?php echo esc_attr($hero_image['alt']); ?>">
                            <?php endif; ?>
                            <div class="hero-text6">
                                <div class="container2">
                                    <div class="hero-sec-info3 one-time">
                                        <?php if ($hero_title): ?>
                                            <h2 class="title"><?php echo nl2br(esc_html($hero_title)); ?></h2>
                                        <?php endif; ?>
                                        <div class="hero-btn2">
                                            <?php if ($hero_desc): ?>
                                                <p><?php echo nl2br(esc_html($hero_desc)); ?></p>
                                            <?php endif; ?>
                                            <?php if ($hero_link): ?>
                                                <a href="<?php echo esc_url($hero_link['url']); ?>"
                                                    target="<?php echo esc_attr($hero_link['target'] ? $hero_link['target'] : '_self'); ?>"
                                                    title="<?php echo esc_attr($hero_link['title']); ?>"
                                                    class="ibt-btn ibt-btn-secondary">
                                                    <span><?php echo esc_html($hero_link['title']); ?></span>
                                                    <i class="icon-arrow-top"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($hero_course_title || $hero_badge): ?>
                                <div class="exp-box">
                                    <div class="text-center text-lg-start w-100">
                                        <?php if ($hero_badge || $hero_date): ?>
                                            <div class="d-inline-flex align-items-center mb-2">
                                                <?php if ($hero_badge): ?><span
                                                        class="badge me-2"><?php echo esc_html($hero_badge); ?></span><?php endif; ?>
                                                <?php if ($hero_date): ?><span class="text-secondary small fw-bold"><i
                                                            class="far fa-calendar-alt me-1"></i>
                                                        <?php echo esc_html($hero_date); ?></span><?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($hero_course_title): ?>
                                            <h3><?php echo nl2br(esc_html($hero_course_title)); ?></h3>
                                        <?php endif; ?>

                                        <?php if ($hero_course_highlight || $hero_course_link): ?>
                                            <div class="d-lg-flex align-items-center justify-content-between">
                                                <?php if ($hero_course_highlight): ?>
                                                    <p class="text-secondary mb-0"><?php echo nl2br(esc_html($hero_course_highlight)); ?>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if ($hero_course_link): ?>
                                                    <a href="<?php echo esc_url($hero_course_link['url']); ?>"
                                                        target="<?php echo esc_attr($hero_course_link['target'] ? $hero_course_link['target'] : '_self'); ?>">
                                                        <span><?php echo esc_html($hero_course_link['title']); ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="slider-btn">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- End hero-style2 -->

<!-- about-us-sec2 -->
<?php
$about_subtitle = get_field('about_subtitle');
$about_title = get_field('about_title');
$about_counter_number = get_field('about_counter_number');
$about_counter_prefix = get_field('about_counter_prefix');
$about_counter_suffix = get_field('about_counter_suffix');
$about_counter_desc = get_field('about_counter_desc');
$about_text = get_field('about_text');
$about_link = get_field('about_link');

if ($about_title || $about_text):
    ?>
    <section class="about-us-sec2 ibt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-content2">
                        <div class="sec-title">
                            <?php if ($about_subtitle): ?><span
                                    class="sub-title"><?php echo esc_html($about_subtitle); ?></span><?php endif; ?>
                            <?php if ($about_title): ?>
                                <h2 class="title animated-heading"><?php echo nl2br(esc_html($about_title)); ?></h2>
                            <?php endif; ?>
                        </div>
                        <?php if ($about_counter_number): ?>
                            <div class="about-counter">
                                <div class="counter-box4">
                                    <?php if ($about_counter_prefix): ?><span
                                            class="counter-text"><?php echo esc_html($about_counter_prefix); ?></span><?php endif; ?>
                                    <span class="counter-text"><?php echo esc_html($about_counter_number); ?></span>
                                    <?php if ($about_counter_suffix): ?><span
                                            class="counter-text"><?php echo esc_html($about_counter_suffix); ?></span><?php endif; ?>
                                </div>
                                <?php if ($about_counter_desc): ?><span
                                        class="solutions"><?php echo esc_html($about_counter_desc); ?></span><?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-info2">
                        <?php echo $about_text; ?>
                        <?php if ($about_link): ?>
                            <a href="<?php echo esc_url($about_link['url']); ?>"
                                target="<?php echo esc_attr($about_link['target'] ? $about_link['target'] : '_self'); ?>"
                                title="<?php echo esc_attr($about_link['title']); ?>" class="ibt-btn ibt-btn-outline">
                                <span><?php echo esc_html($about_link['title']); ?></span>
                                <i class="icon-arrow-top"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- End about-us-sec2 -->

<!-- testimonials-sec -->
<?php
$testi_subtitle = get_field('testi_subtitle');
$testi_title = get_field('testi_title');
$testi_desc = get_field('testi_desc');
$testi_image = get_field('testi_image');

if (have_rows('testimonials') || $testi_title):
    ?>
    <section class="testimonials-sec ibt-section-gapBottom">
        <div class="container2">
            <div class="row">
                <div class="col-lg-7">
                    <?php if (have_rows('testimonials')): ?>
                        <div class="swiper testi-slider">
                            <div class="swiper-wrapper">
                                <?php while (have_rows('testimonials')):
                                    the_row();
                                    $author_logo = get_sub_field('author_logo');
                                    $text = get_sub_field('text');
                                    $author_details = get_sub_field('author_details');
                                    ?>
                                    <div class="swiper-slide">
                                        <?php if (!empty($author_logo)): ?>
                                            <img src="<?php echo esc_url($author_logo['url']); ?>"
                                                alt="<?php echo esc_attr($author_logo['alt']); ?>">
                                        <?php endif; ?>
                                        <?php if ($text): ?>
                                            <p><?php echo nl2br(esc_html($text)); ?></p><?php endif; ?>
                                        <?php if ($author_details): ?><span><?php echo esc_html($author_details); ?></span><?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                            <div class="slider-btn">
                                <!-- Navigation buttons -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5">
                    <div class="testimonial-content">
                        <?php if (!empty($testi_image)): ?>
                            <img src="<?php echo esc_url($testi_image['sizes']['bg-depoimentos']); ?>"
                                alt="<?php echo esc_attr($testi_image['alt']); ?>">
                        <?php endif; ?>
                        <div class="title-area2">
                            <div class="sec-title white">
                                <?php if ($testi_subtitle): ?><span
                                        class="sub-title"><?php echo esc_html($testi_subtitle); ?></span><?php endif; ?>
                                <?php if ($testi_title): ?>
                                    <h2 class="title animated-heading"><?php echo esc_html($testi_title); ?></h2><?php endif; ?>
                            </div>
                            <?php if ($testi_desc): ?>
                                <p><?php echo nl2br(esc_html($testi_desc)); ?></p><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- End testimonials-sec -->

<!-- service-sec15 -->
<?php
$courses_subtitle = get_field('courses_subtitle');
$courses_title = get_field('courses_title');
$courses_desc = get_field('courses_desc');

if (have_rows('courses_list') || $courses_title):
    ?>
    <section class="service-sec15 ibt-section-gap bg-gray">
        <div class="title-area">
            <div class="container">
                <div class="row end">
                    <div class="col-lg-10">
                        <div class="sec-title mb-0">
                            <?php if ($courses_subtitle): ?><span
                                    class="sub-title"><?php echo esc_html($courses_subtitle); ?></span><?php endif; ?>
                            <?php if ($courses_title): ?>
                                <h2 class="title animated-heading"><?php echo esc_html($courses_title); ?></h2><?php endif; ?>
                            <?php if ($courses_desc): ?>
                                <p><?php echo nl2br(esc_html($courses_desc)); ?></p><?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="sec-btn-box">
                            <div class="slider-btn5">
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (have_rows('courses_list')): ?>
            <div class="container2">
                <div class="swiper ser-slider15">
                    <div class="swiper-wrapper">
                        <?php while (have_rows('courses_list')):
                            the_row();
                            $course_image = get_sub_field('course_image');
                            $course_link = get_sub_field('course_link');
                            $course_tag = get_sub_field('course_tag');
                            $course_text = get_sub_field('course_text');
                            $course_img_alt = !empty($course_image['alt'])
                                ? $course_image['alt']
                                : wp_strip_all_tags($course_tag ? $course_tag : ($course_text ? $course_text : ''));
                            ?>
                            <div class="swiper-slide">
                                <div class="ser-card15">
                                    <div class="ser-img15">
                                        <?php if ($course_link): ?>
                                        <a href="<?php echo esc_url($course_link['url']); ?>" target="<?php echo esc_attr($course_link['target'] ? $course_link['target'] : '_self'); ?>"
                                            title="<?php echo esc_attr($course_link['title']); ?>">
                                        <?php endif; ?>
                                            <?php if (!empty($course_image)): ?>
                                                <img src="<?php echo esc_url($course_image['sizes']['card-curso']); ?>"
                                                    alt="<?php echo esc_attr($course_img_alt); ?>">
                                            <?php endif; ?>
                                        <?php if ($course_link): ?>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($course_tag || $course_text): ?>
                                    <div class="ser-content15">
                                        <?php if ($course_tag): ?>
                                            <span class="badge"><?php echo esc_html($course_tag); ?></span>
                                        <?php endif; ?>
                                        <?php if ($course_text): ?>
                                            <p><?php echo nl2br(esc_html($course_text)); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($course_link): ?>
                                    <a href="<?php echo esc_url($course_link['url']); ?>" target="<?php echo esc_attr($course_link['target'] ? $course_link['target'] : '_self'); ?>"
                                        title="<?php echo esc_attr($course_link['title']); ?>" class="ser-btn">
                                        <i class="icon fontello icon-button-arrow"></i>
                                        <i class="icon2 fontello icon-button-arrow"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>
<!-- End service-sec15 -->

<!-- service-sec17 -->
<?php
$pv_subtitle = get_field('pv_subtitle');
$pv_title = get_field('pv_title');

if (have_rows('pv_items') || $pv_title):
    ?>
    <section class="service-sec17 ibt-section-gapTop">
        <div class="container">
            <div class="sec-title">
                <?php if ($pv_subtitle): ?><span
                        class="sub-title"><?php echo esc_html($pv_subtitle); ?></span><?php endif; ?>
                <?php if ($pv_title): ?>
                    <h2 class="title animated-heading"><?php echo nl2br(esc_html($pv_title)); ?></h2><?php endif; ?>
            </div>
            <?php if (have_rows('pv_items')): ?>
                <div class="row">
                    <?php while (have_rows('pv_items')):
                        the_row();
                        $icon = get_sub_field('icon');
                        $title = get_sub_field('title');
                        $desc = get_sub_field('desc');
                        $link = get_sub_field('link');
                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="ser-card17">
                                <?php if (!empty($icon)): ?>
                                    <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
                                <?php endif; ?>
                                <?php if ($title): ?>
                                    <h4 class="title"><?php echo esc_html($title); ?></h4><?php endif; ?>
                                <?php if ($desc): ?>
                                    <p><?php echo nl2br(esc_html($desc)); ?></p><?php endif; ?>
                                <?php if ($link): ?>
                                    <a href="<?php echo esc_url($link['url']); ?>"
                                        target="<?php echo esc_attr($link['target'] ? $link['target'] : '_self'); ?>"
                                        title="<?php echo esc_attr($link['title']); ?>"
                                        class="ser-btn17"><?php echo esc_html($link['title']); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
<!-- End service-sec17 -->

<!-- service-sec25 -->
<?php
$pv_banner_meditacao_img = get_field('pv_banner_meditacao_img');
$pv_banner_meditacao_link = get_field('pv_banner_meditacao_link');

$pv_banner_loja_img = get_field('pv_banner_loja_img');
$pv_banner_loja_title = get_field('pv_banner_loja_title');
$pv_banner_loja_desc = get_field('pv_banner_loja_desc');
$pv_banner_loja_link = get_field('pv_banner_loja_link');

if ($pv_banner_meditacao_img || $pv_banner_loja_img):
    ?>
    <section class="service-sec25 ibt-section-gapTop no-img-bg">
        <div class="container">
            <div class="row">
                <?php if ($pv_banner_meditacao_img): ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="ser-card25">
                            <?php if ($pv_banner_meditacao_link): ?><a
                                    href="<?php echo esc_url($pv_banner_meditacao_link['url']); ?>"
                                    target="<?php echo esc_attr($pv_banner_meditacao_link['target'] ? $pv_banner_meditacao_link['target'] : '_self'); ?>"
                                    title="<?php echo esc_attr($pv_banner_meditacao_link['title']); ?>"><?php endif; ?>
                                <img src="<?php echo esc_url($pv_banner_meditacao_img['sizes']['banner-home-1']); ?>"
                                    alt="<?php echo esc_attr($pv_banner_meditacao_img['alt']); ?>" class="layer">
                                <?php if ($pv_banner_meditacao_link): ?></a><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($pv_banner_loja_img): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="ser-card25">
                            <?php if ($pv_banner_loja_link): ?><a href="<?php echo esc_url($pv_banner_loja_link['url']); ?>"
                                    target="<?php echo esc_attr($pv_banner_loja_link['target'] ? $pv_banner_loja_link['target'] : '_self'); ?>"
                                    title="<?php echo esc_attr($pv_banner_loja_link['title']); ?>"><?php endif; ?>
                                <img src="<?php echo esc_url($pv_banner_loja_img['sizes']['banner-home-2']); ?>"
                                    alt="<?php echo esc_attr($pv_banner_loja_img['alt']); ?>" class="layer">
                                <?php if ($pv_banner_loja_link): ?></a><?php endif; ?>

                            <div class="ser-content25">
                                <?php if ($pv_banner_loja_title): ?>
                                    <h2 class="title3">
                                        <?php if ($pv_banner_loja_link): ?><a
                                                href="<?php echo esc_url($pv_banner_loja_link['url']); ?>"
                                                target="<?php echo esc_attr($pv_banner_loja_link['target'] ? $pv_banner_loja_link['target'] : '_self'); ?>"
                                                title="<?php echo esc_attr($pv_banner_loja_link['title']); ?>"><?php endif; ?>
                                            <?php echo esc_html($pv_banner_loja_title); ?>
                                            <?php if ($pv_banner_loja_link): ?></a><?php endif; ?>
                                    </h2>
                                <?php endif; ?>
                                <?php if ($pv_banner_loja_desc): ?>
                                    <p><?php echo nl2br(esc_html($pv_banner_loja_desc)); ?></p><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-lg-2 col-md-6">
                    <div class="ser-card25_card3">
                        <div class="service-ai">
                            <img src="<?php bloginfo('template_url'); ?>/assets/images/logos/favicon.png" alt="Icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- End service-sec25 -->

<!-- blog-sec -->
<?php
$blog_subtitle = get_field('blog_subtitle');
$blog_title = get_field('blog_title');
$blog_link = get_field('blog_link');

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post_status' => 'publish'
);
$blog_query = new WP_Query($args);

if ($blog_query->have_posts() || $blog_title):
    ?>
    <section class="blog-sec ibt-section-gap">
        <div class="container">
            <div class="title-area">
                <div class="row end">
                    <div class="col-lg-8">
                        <div class="sec-title mb-0">
                            <?php if ($blog_subtitle): ?><span
                                    class="sub-title"><?php echo esc_html($blog_subtitle); ?></span><?php endif; ?>
                            <?php if ($blog_title): ?>
                                <h2 class="title animated-heading"><?php echo esc_html($blog_title); ?></h2><?php endif; ?>
                        </div>
                    </div>
                    <?php if ($blog_link): ?>
                        <div class="col-lg-4">
                            <div class="sec-btn-box">
                                <a href="<?php echo esc_url($blog_link['url']); ?>"
                                    target="<?php echo esc_attr($blog_link['target'] ? $blog_link['target'] : '_self'); ?>"
                                    title="<?php echo esc_attr($blog_link['title']); ?>" class="ibt-btn ibt-btn-outline">
                                    <span><?php echo esc_html($blog_link['title']); ?></span>
                                    <i class="icon-arrow-top"></i>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($blog_query->have_posts()): ?>
                <div class="row">
                    <?php
                    $post_count = 0;
                    while ($blog_query->have_posts()):
                        $blog_query->the_post();
                        $post_count++;
                        $mb_class = ($post_count == 3) ? ' mb-0' : ''; // Para replicar a classe mb-0 no terceiro item
                        ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-card<?php echo $mb_class; ?>">
                                <div class="blog-img">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        <?php
                                        if (has_post_thumbnail()) {
                                            the_post_thumbnail('thumb-blog');
                                        } else {
                                            echo '<img src="' . get_template_directory_uri() . '/assets/images/blog' . $post_count . '.webp" alt="' . get_the_title() . '">';
                                        }
                                        ?>
                                    </a>
                                    <span class="blog-meta"><?php echo get_the_date(); ?></span>
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
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
<!-- End blog-sec -->

<?php
get_footer();
