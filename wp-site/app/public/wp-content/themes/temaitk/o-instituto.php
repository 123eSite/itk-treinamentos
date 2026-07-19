<?php
get_header();
?>

<!-- page-banner9 -->
<?php
$banner_bg_image = get_field('banner_bg_image');
$banner_title = get_field('banner_title');
$banner_watermark = get_field('banner_watermark');

if ($banner_title || $banner_bg_image):
    ?>
    <section class="bread-crums-section">
        <div class="container2">
            <div class="page-banner11">
                <?php if (!empty($banner_bg_image)): ?>
                    <img class="bg" src="<?php echo esc_url($banner_bg_image['sizes']['banner-internas']); ?>"
                        alt="<?php echo esc_attr($banner_bg_image['alt']); ?>">
                <?php endif; ?>
                <div class="shape"></div>
                <div class="shape3"></div>
                <?php if ($banner_watermark): ?>
                    <div class="staff-text"><?php echo esc_html($banner_watermark); ?></div>
                <?php endif; ?>
                <div class="page-content">
                    <?php if ($banner_title): ?>
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

<!-- about-us-sec6 -->
<?php
$about_subtitle = get_field('about_subtitle');
$about_title = get_field('about_title');
$about_text = get_field('about_text');

if (have_rows('counters_list') || $about_title || $about_text):
    ?>
    <section class="about-us-sec6 ibt-section-gap">
        <div class="container">
            <div class="row align-items-end">
                <?php if (have_rows('counters_list')): ?>
                    <div class="col-xl-4 col-lg-5">
                        <div class="about-counter6">
                            <?php while (have_rows('counters_list')):
                                the_row();
                                $counter_prefix = get_sub_field('counter_prefix');
                                $counter_number = get_sub_field('counter_number');
                                $counter_suffix = get_sub_field('counter_suffix');
                                $counter_title = get_sub_field('counter_title');
                                ?>
                                <div class="about-counter-content6">
                                    <div class="counter-box15">
                                        <?php if ($counter_prefix): ?><span
                                                class="counter-text"><?php echo esc_html($counter_prefix); ?></span><?php endif; ?>
                                        <span class="counter-number percent-counter2"
                                            data-target="<?php echo esc_attr($counter_number); ?>">0</span>
                                        <?php if ($counter_suffix): ?><span
                                                class="counter-text"><?php echo esc_html($counter_suffix); ?></span><?php endif; ?>
                                    </div>
                                    <?php if ($counter_title): ?><span
                                            class="title"><?php echo esc_html($counter_title); ?></span><?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="<?php echo have_rows('counters_list') ? 'col-xl-8 col-lg-7' : 'col-12'; ?>">
                    <div class="about-content6">
                        <div class="sec-title">
                            <?php if ($about_subtitle): ?><span
                                    class="sub-title"><?php echo esc_html($about_subtitle); ?></span><?php endif; ?>
                            <?php if ($about_title): ?>
                                <h2 class="title animated-heading"><?php echo nl2br(esc_html($about_title)); ?></h2>
                            <?php endif; ?>
                        </div>
                        <?php echo $about_text; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- End about-us-sec6 -->

<!-- service-sec15 (Gallery) -->
<?php if (have_rows('gallery_images')): ?>
    <div class="carousel-gallery">
        <div class="container2">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php while (have_rows('gallery_images')):
                        the_row();
                        $image = get_sub_field('image');
                        if (!empty($image)):
                            ?>
                            <div class="swiper-slide">
                                <img src="<?php echo esc_url($image['sizes']['img-galeria']); ?>"
                                    alt="<?php echo esc_attr($image['alt']); ?>">
                            </div>
                            <?php
                        endif;
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- End service-sec15 -->

<!-- service-sec22 -->
<?php
$transpessoal_title = get_field('transpessoal_title');
$transpessoal_text = get_field('transpessoal_text');
$transpessoal_quote = get_field('transpessoal_quote');
$transpessoal_image = get_field('transpessoal_image');

if ($transpessoal_title || $transpessoal_text || $transpessoal_image):
    ?>
    <section class="service-sec22 ibt-section-gap">
        <div class="container3">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="ser-card22">
                        <div class="ser-content22">
                            <?php if ($transpessoal_title): ?>
                                <h4 class="title"><?php echo esc_html($transpessoal_title); ?></h4><?php endif; ?>
                            <?php echo $transpessoal_text; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="ser-card22 v2">
                        <?php if (!empty($transpessoal_image)): ?>
                            <img src="<?php echo esc_url($transpessoal_image['sizes']['img-half']); ?>"
                                alt="<?php echo esc_attr($transpessoal_image['alt']); ?>">
                        <?php endif; ?>
                        <?php if ($transpessoal_quote): ?>
                            <div class="inner-content2">
                                <h4 class="profection">
                                    <?php echo nl2br(esc_html($transpessoal_quote)); ?>
                                </h4>
                            </div>
                        <?php endif; ?>
                        <div class="ser-video-box">
                            <!-- Box used for video/spacing optionally in layout -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- End service-sec22 -->

<!-- team-section2 -->
<?php
$team_subtitle = get_field('team_subtitle');
$team_title = get_field('team_title');
$team_text = get_field('team_text');

if (have_rows('team_members') || $team_title):
    ?>
    <section class="team-section2 ibt-section-gap">
        <div class="container3">
            <div class="title-area">
                <div class="row align-items-end mb-0">
                    <div class="col-xl-8 col-lg-8">
                        <div class="sec-title">
                            <?php if ($team_subtitle): ?><span
                                    class="sub-title"><?php echo esc_html($team_subtitle); ?></span><?php endif; ?>
                            <?php if ($team_title): ?>
                                <h2 class="title animated-heading"><?php echo esc_html($team_title); ?></h2><?php endif; ?>
                        </div>
                        <?php if ($team_text): ?>
                            <p><?php echo nl2br(esc_html($team_text)); ?></p><?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (have_rows('team_members')): ?>
                <div class="row justify-content-center">
                    <?php while (have_rows('team_members')):
                        the_row();
                        $member_image = get_sub_field('member_image');
                        $member_name = get_sub_field('member_name');
                        $member_role = get_sub_field('member_role');
                        $member_linkedin = get_sub_field('member_linkedin');
                        $member_instagram = get_sub_field('member_instagram');
                        ?>
                        <div class="col-lg-5-cols col-md-6 col-sm-6">
                            <div class="team-member2">
                                <div class="team-card">
                                    <div class="team-img">
                                        <a href="#">
                                            <?php if (!empty($member_image)): ?>
                                                <img src="<?php echo esc_url($member_image['sizes']['foto-equipe']); ?>"
                                                    alt="<?php echo esc_attr($member_image['alt']); ?>">
                                            <?php endif; ?>
                                        </a>
                                        <div class="team-shap"></div>
                                    </div>
                                    <div class="team-content">
                                        <?php if ($member_linkedin || $member_instagram): ?>
                                            <div class="share-box">
                                                <span class="share-icon fa fa-share-alt"></span>
                                                <ul class="social-links">
                                                    <?php if ($member_linkedin): ?>
                                                        <li><a href="<?php echo esc_url($member_linkedin); ?>" target="_blank"
                                                                title="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                                                    <?php endif; ?>
                                                    <?php if ($member_instagram): ?>
                                                        <li><a href="<?php echo esc_url($member_instagram); ?>" target="_blank"
                                                                title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($member_name): ?>
                                            <h4 class="name"><a href="#" title=""><?php echo esc_html($member_name); ?></a></h4>
                                        <?php endif; ?>
                                        <?php if ($member_role): ?><span
                                                class="designation"><?php echo esc_html($member_role); ?></span><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
<!-- End team-section2 -->

<?php
get_footer();
