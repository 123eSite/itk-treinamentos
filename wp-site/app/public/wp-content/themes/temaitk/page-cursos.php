<?php
/* Template Name: Cursos e Treinamentos */
get_header();
?>

        <!-- page-banner9 -->
        <?php
        $banner_bg_image = get_field('banner_bg_image');
        $banner_title = get_field('banner_title');
        $banner_watermark = get_field('banner_watermark');

        if ( $banner_title || $banner_bg_image ):
        ?>
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
                        <?php if( $banner_title ): ?>
                        <h1 class="title"><?php echo esc_html($banner_title); ?></h1>
                        <?php endif; ?>
                    </div>
                    <ul class="breadcrumbs">
                        <li><a href="<?php echo home_url(); ?>" title="Home">Home</a></li>
                        <li>/</li>
                        <li><?php echo $banner_title ? esc_html($banner_title) : get_the_title(); ?></li>
                    </ul>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- End page-banner9 -->

        <!-- service-sec15 -->
        <?php
        $courses_title = get_field('courses_title');
        $courses_text = get_field('courses_text');

        if( $courses_title || $courses_text || have_rows('courses_list') ):
        ?>
        <section class="service-sec15 ibt-section-gap bg-gray">
            <div class="title-area">
                <div class="container">
                    <div class="row end">
                        <div class="col-lg-10">
                            <div class="sec-title mb-0">
                                <?php if( $courses_title ): ?>
                                <h2 class="title animated-heading"><?php echo esc_html($courses_title); ?></h2>
                                <?php endif; ?>
                                <?php if( $courses_text ): ?>
                                <p><?php echo nl2br(esc_html($courses_text)); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if( have_rows('courses_list') ): ?>
            <div class="container2">
                <div class="row">
                    <?php while( have_rows('courses_list') ): the_row();
                        $course_image = get_sub_field('course_image');
                        $course_link = get_sub_field('course_link');
                        $course_tag = get_sub_field('course_tag');
                        $course_text = get_sub_field('course_text');
                        $course_img_alt = !empty($course_image['alt'])
                            ? $course_image['alt']
                            : wp_strip_all_tags($course_tag ? $course_tag : ($course_text ? $course_text : ''));
                    ?>
                    <div class="col-lg-3 mb-5">
                        <div class="ser-card15">
                            <div class="ser-img15">
                                <?php if( $course_link ): ?>
                                <a href="<?php echo esc_url($course_link['url']); ?>" target="<?php echo esc_attr($course_link['target'] ? $course_link['target'] : '_self'); ?>" title="<?php echo esc_attr($course_link['title']); ?>">
                                <?php endif; ?>

                                    <?php if( !empty($course_image) ): ?>
                                    <img src="<?php echo esc_url($course_image['sizes']['card-curso']); ?>" alt="<?php echo esc_attr($course_img_alt); ?>">
                                    <?php endif; ?>

                                <?php if( $course_link ): ?>
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php if( $course_tag || $course_text ): ?>
                            <div class="ser-content15">
                                <?php if( $course_tag ): ?>
                                <span class="badge"><?php echo esc_html($course_tag); ?></span>
                                <?php endif; ?>
                                <?php if( $course_text ): ?>
                                <p><?php echo nl2br(esc_html($course_text)); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <?php if( $course_link ): ?>
                            <a href="<?php echo esc_url($course_link['url']); ?>" target="<?php echo esc_attr($course_link['target'] ? $course_link['target'] : '_self'); ?>" title="<?php echo esc_attr($course_link['title']); ?>" class="ser-btn">
                                <i class="icon fontello icon-button-arrow"></i>
                                <i class="icon2 fontello icon-button-arrow"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>
        <!-- End service-sec15 -->

<?php
get_footer();
