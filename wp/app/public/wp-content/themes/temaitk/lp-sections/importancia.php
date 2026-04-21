<?php
$subtitulo = get_sub_field( 'subtitulo' );
$titulo    = get_sub_field( 'titulo' );
$texto     = get_sub_field( 'texto' );
$classes   = temaitk_lp_section_classes( 'main-sec3' );
?>
<!-- main-sec3 / service-sec15 -->
<section class="<?php echo esc_attr( $classes ); ?>">
    <div class="service-sec15 ibt-section-gapTop">
        <div class="title-area">
            <div class="container">
                <div class="row end">
                    <div class="col-lg-7">
                        <div class="sec-title mb-0">
                            <?php if ( $subtitulo ) : ?>
                            <span class="sub-title"><?php echo esc_html( $subtitulo ); ?></span>
                            <?php endif; ?>
                            <h2 class="title animated-heading"><?php echo esc_html( $titulo ); ?></h2>
                            <?php if ( $texto ) : ?>
                            <p><?php echo esc_html( $texto ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-5">
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
        <div class="container2">
            <div class="swiper no-shape ser-slider15">
                <div class="swiper-wrapper">
                    <?php if ( have_rows( 'cards' ) ) : while ( have_rows( 'cards' ) ) : the_row();
                        $imagem      = get_sub_field( 'imagem' );
                        $titulo_card = get_sub_field( 'titulo_card' );
                        $texto_card  = get_sub_field( 'texto_card' );
                        $alt         = $imagem['alt'] ?: wp_strip_all_tags( $titulo_card );
                    ?>
                    <div class="swiper-slide">
                        <div class="ser-card15 bg-gray">
                            <div class="ser-img15">
                                <img src="<?php echo esc_url( $imagem['sizes']['itk-service-card'] ); ?>"
                                     alt="<?php echo esc_attr( $alt ); ?>">
                            </div>
                            <div class="ser-content15">
                                <h4 class="title"><a href="#" title=""><?php echo esc_html( $titulo_card ); ?></a></h4>
                                <?php if ( $texto_card ) : ?>
                                <p><?php echo esc_html( $texto_card ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End main-sec3 / service-sec15 -->
