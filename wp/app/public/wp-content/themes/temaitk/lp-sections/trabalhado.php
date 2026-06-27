<?php
$titulo  = get_sub_field( 'titulo' );
$par1    = get_sub_field( 'paragrafo_1' );
$imagem  = get_sub_field( 'imagem' );
$legenda = get_sub_field( 'legenda_contador' );
$numero  = get_sub_field( 'numero_contador' );
$classes = temaitk_lp_section_classes( 'service-sec22' );
$alt     = ( is_array( $imagem ) && ! empty( $imagem['alt'] ) ) ? $imagem['alt'] : wp_strip_all_tags( $titulo );
?>
<!-- service-sec22 -->
<section class="<?php echo esc_attr( $classes ); ?>">
    <div class="container3">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="ser-card22">
                    <div class="ser-content22">
                        <h4 class="title"><?php echo esc_html( $titulo ); ?></h4>
                        <?php if ( $par1 ) : ?><p><?php echo $par1; ?></p><?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="ser-card22 v2">
                    <?php if ( is_array( $imagem ) && ! empty( $imagem['sizes']['itk-feature-square'] ) ) : ?>
                    <img src="<?php echo esc_url( $imagem['sizes']['itk-feature-square'] ); ?>"
                         alt="<?php echo esc_attr( $alt ); ?>">
                    <?php endif; ?>
                    <div class="inner-content2">
                        <h4 class="profection"><?php echo nl2br( esc_html( $legenda ) ); ?></h4>
                        <div class="ser-counter22">
                            <div class="counter-box22">
                                <span class="counter-text">+</span>
                                <span class="counter-number percent-counter" data-target="<?php echo esc_attr( $numero ); ?>">0</span>
                                <span class="counter-text">k</span>
                            </div>
                        </div>
                    </div>
                    <div class="ser-video-box"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End service-sec22 -->
