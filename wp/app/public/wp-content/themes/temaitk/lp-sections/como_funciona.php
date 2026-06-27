<?php
$imagem    = get_sub_field( 'imagem' );
$subtitulo = get_sub_field( 'subtitulo' );
$titulo    = get_sub_field( 'titulo' );
$classes   = temaitk_lp_section_classes( 'feature-sec8 no-tab' );
$alt       = ( is_array( $imagem ) && ! empty( $imagem['alt'] ) ) ? $imagem['alt'] : wp_strip_all_tags( $titulo );
?>
<!-- feature-sec8 -->
<section class="<?php echo esc_attr( $classes ); ?>">
    <div class="container3">
        <div class="row">
            <div class="col-lg-5">
                <div class="feature-img8">
                    <div class="empty4"></div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <?php if ( is_array( $imagem ) && ! empty( $imagem['sizes']['itk-feature-wide'] ) ) : ?>
                            <img src="<?php echo esc_url( $imagem['sizes']['itk-feature-wide'] ); ?>"
                                 alt="<?php echo esc_attr( $alt ); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="feature-tabs8">
                    <div class="sec-title">
                        <?php if ( $subtitulo ) : ?>
                        <span class="sub-title"><?php echo esc_html( $subtitulo ); ?></span>
                        <?php endif; ?>
                        <h2 class="title animated-heading"><?php echo esc_html( $titulo ); ?></h2>
                    </div>
                    <ul class="nav nav-tabs8" id="myTab" role="tablist">
                        <?php if ( have_rows( 'etapas' ) ) : while ( have_rows( 'etapas' ) ) : the_row(); ?>
                        <li class="nav-item" role="presentation">
                            <div class="feature-block8">
                                <h4 class="title"><?php echo esc_html( get_sub_field( 'titulo_etapa' ) ); ?></h4>
                                <p><?php echo esc_html( get_sub_field( 'texto_etapa' ) ); ?></p>
                            </div>
                        </li>
                        <?php endwhile; endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End feature-sec8 -->
