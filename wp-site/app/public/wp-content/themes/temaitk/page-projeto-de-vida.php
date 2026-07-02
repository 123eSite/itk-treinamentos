<?php
/* Template Name: Projeto de Vida */
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

        <!-- her-style1 -->
        <?php
        $hero_title = get_field('hero_title');
        $hero_text = get_field('hero_text');
        
        if( $hero_title || $hero_text ):
        ?>
        <section class="hero-style1">
            <div class="hero-info">
                <div class="container-fluid">
                    <div class="row end">
                        <div class="col-lg-8">
                            <div class="hero-title">
                                <?php if( $hero_title ): ?>
                                <h2><?php echo esc_html($hero_title); ?></h2>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="hero-content">
                                <?php 
                                if( $hero_text ): 
                                    $lines = explode("\n", $hero_text);
                                    foreach($lines as $line) {
                                        if(trim($line)) {
                                            echo '<h4>' . esc_html(trim($line)) . '</h4>';
                                        }
                                    }
                                endif; 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- End hero-style1 -->

        <!-- feature-sec9 -->
        <?php
        $about_subtitle = get_field('about_subtitle');
        $about_title = get_field('about_title');
        $about_text = get_field('about_text');
        $about_image = get_field('about_image');
        
        if( $about_title || $about_text || $about_image ):
        ?>
        <section class="feature-sec9 ibt-section-gapBottom bg-gray">
            <div class="container3">
                <div class="row">
                    <div class="col-lg-6 d-lg-flex align-items-center">
                        <div class="feature-content9 pe-lg-5">
                            <div class="sec-title">
                                <?php if( $about_subtitle ): ?><span class="sub-title"><?php echo esc_html($about_subtitle); ?></span><?php endif; ?>
                                <?php if( $about_title ): ?><h2 class="title animated-heading"><?php echo esc_html($about_title); ?></h2><?php endif; ?>
                                <?php echo $about_text; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="feature-img9 mt-0">
                            <div class="empty4"></div>
                            <?php if( !empty($about_image) ): ?>
                            <img src="<?php echo esc_url($about_image['sizes']['img-half']); ?>" alt="<?php echo esc_attr($about_image['alt']); ?>">
                            <?php endif; ?>
                            <!-- Trigger button -->
                            <div class="ser-video-box bg-gray">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- End feature-sec9 -->

        <!-- feature-style1 -->
        <?php
        $steps_subtitle = get_field('steps_subtitle');
        $steps_title = get_field('steps_title');
        $steps_form_title = get_field('steps_form_title');
        $steps_form_shortcode = get_field('steps_form_shortcode');
        
        if( $steps_title || have_rows('steps_list') || $steps_form_shortcode ):
        ?>
        <section class="feature-sec1 ibt-section-gap">
            <div class="container">
                <div class="sec-title">
                    <?php if( $steps_subtitle ): ?><span class="sub-title"><?php echo esc_html($steps_subtitle); ?></span><?php endif; ?>
                    <?php if( $steps_title ): ?><h2 class="title animated-heading"><?php echo esc_html($steps_title); ?></h2><?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-lg-6 d-lg-flex align-items-center">
                        <div class="contact-form pt-0 pb-0 ps-0 w-100">
                            <div class="custom-form">
                                <?php if( $steps_form_title ): ?>
                                <h2 class="mb-4"><?php echo esc_html($steps_form_title); ?></h2>
                                <?php endif; ?>
                                
                                <?php if( $steps_form_shortcode ): ?>
                                    <?php echo do_shortcode($steps_form_shortcode); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <?php if( have_rows('steps_list') ): while( have_rows('steps_list') ): the_row(); 
                                $step_icon = get_sub_field('step_icon');
                                $step_title = get_sub_field('step_title');
                                $step_text = get_sub_field('step_text');
                            ?>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="feature-card">
                                    <?php if( !empty($step_icon) ): ?>
                                    <img src="<?php echo esc_url($step_icon['url']); ?>" alt="<?php echo esc_attr($step_icon['alt']); ?>">
                                    <?php endif; ?>
                                    <?php if( $step_title ): ?><h4 class="title"><?php echo esc_html($step_title); ?></h4><?php endif; ?>
                                    <?php if( $step_text ): ?><p><?php echo nl2br(esc_html($step_text)); ?></p><?php endif; ?>
                                </div>
                            </div>
                            <?php endwhile; endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <!-- End feature-style1 -->

<?php
get_footer();
