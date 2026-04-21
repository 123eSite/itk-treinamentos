<?php
$titulo  = get_sub_field( 'titulo' );
$classes = temaitk_lp_section_classes( 'testimonial-sec2 no-blur' );
?>
<!-- testimonial-sec2 -->
<section class="<?php echo esc_attr( $classes ); ?>">
    <div class="container3">
        <div class="testi-title">
            <ul class="rating">
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
            </ul>
            <h2 class="title"><?php echo esc_html( $titulo ); ?></h2>
        </div>
        <div class="row">
            <?php if ( have_rows( 'videos' ) ) : while ( have_rows( 'videos' ) ) : the_row(); ?>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="video-wrapper-gsap" style="position: relative; width: 100%; height: 100%;">
                    <div class="iframe-scroll-overlay"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; cursor: pointer;"></div>
                    <iframe class="responsive-iframe"
                        src="<?php echo esc_url( get_sub_field( 'url_youtube' ) ); ?>"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen></iframe>
                </div>
            </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>
<!-- End testimonial-sec2 -->
