<?php
$subtitulo = get_sub_field( 'subtitulo' );
$titulo    = get_sub_field( 'titulo' );
$texto     = get_sub_field( 'paragrafos' );
$imagem    = get_sub_field( 'imagem' );
$botao     = get_sub_field( 'botao_texto' );
$classes   = temaitk_lp_section_classes( 'feature-sec9' );
$alt       = $imagem['alt'] ?: wp_strip_all_tags( $titulo );
?>
<!-- feature-sec9 -->
<section class="<?php echo esc_attr( $classes ); ?>">
    <div class="container3">
        <div class="row row-reverse">
            <div class="col-lg-6 d-lg-flex align-items-center">
                <div class="feature-content9 pe-lg-5 mt-5 mt-lg-0">
                    <div class="sec-title">
                        <?php if ( $subtitulo ) : ?>
                        <span class="sub-title"><?php echo esc_html( $subtitulo ); ?></span>
                        <?php endif; ?>
                        <h2 class="title animated-heading"><?php echo esc_html( $titulo ); ?></h2>
                        <?php if ( $texto ) : ?>
                        <?php echo wp_kses_post( $texto ); ?>
                        <?php endif; ?>
                        <?php if ( $botao ) : ?>
                        <a href="#inscricao" class="ibt-btn ibt-btn-secondary scroll-to-id mt-4">
                            <span><?php echo esc_html( $botao ); ?></span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-img9 mt-0">
                    <div class="empty4"></div>
                    <img src="<?php echo esc_url( $imagem['sizes']['itk-feature-square'] ); ?>"
                         alt="<?php echo esc_attr( $alt ); ?>">
                    <div class="ser-video-box"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End feature-sec9 -->
