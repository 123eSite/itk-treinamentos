<?php
/* Template Name: Mandalas */
get_header();
?>

        <!-- page-banner9 -->
        <?php
        $banner_bg_image = get_field('banner_bg_image');
        $banner_title = get_field('banner_title');
        $banner_watermark = get_field('banner_watermark');
        
        if( $banner_title || $banner_bg_image ):
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

        <!-- about-us-sec2 -->
        <?php
        $about_subtitle = get_field('about_subtitle');
        $about_title = get_field('about_title');
        $about_image = get_field('about_image');
        $about_text = get_field('about_text');
        
        if( $about_title || $about_text || $about_image ):
        ?>
        <section class="about-us-sec10 ibt-section-gap bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about-content10">
                            <div class="sec-title">
                                <?php if( $about_subtitle ): ?><span class="sub-title"><?php echo esc_html($about_subtitle); ?></span><?php endif; ?>
                                <?php if( $about_title ): ?><h2 class="title animated-heading"><?php echo esc_html($about_title); ?></h2><?php endif; ?>
                            </div>
                            <?php if( !empty($about_image) ): ?>
                            <img src="<?php echo esc_url($about_image['url']); ?>" alt="<?php echo esc_attr($about_image['alt']); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-info10">
                            <?php echo $about_text; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- End about-us-sec2 -->

        <!-- feature-style1 -->
        <?php
        $download_subtitle = get_field('download_subtitle');
        $download_title = get_field('download_title');
        $download_form_shortcode = get_field('download_form_shortcode');
        $download_info_title = get_field('download_info_title');
        $download_info_text = get_field('download_info_text');
        
        if( $download_title || $download_form_shortcode || $download_info_title ):
        ?>
        <section class="feature-sec1 ibt-section-gap">
            <div class="container">
                <div class="sec-title">
                    <?php if( $download_subtitle ): ?><span class="sub-title"><?php echo esc_html($download_subtitle); ?></span><?php endif; ?>
                    <?php if( $download_title ): ?><h2 class="title animated-heading"><?php echo esc_html($download_title); ?></h2><?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-lg-6 d-lg-flex align-items-center">
                        <div class="contact-form pt-0 pb-0 ps-0 w-100">
                            <div class="custom-form">
                                <?php if( $download_form_shortcode ): ?>
                                    <?php echo do_shortcode($download_form_shortcode); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <?php if( $download_info_title ): ?>
                        <h4 class="title"><?php echo esc_html($download_info_title); ?></h4>
                        <?php endif; ?>
                        <?php echo $download_info_text; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- End feature-style1 -->

<?php
get_footer();
