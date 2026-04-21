<?php
$subtitulo = get_sub_field( 'subtitulo' );
$titulo    = get_sub_field( 'titulo' );
$texto     = get_sub_field( 'texto' );
$botao     = get_sub_field( 'botao_texto' );
$classes   = temaitk_lp_section_classes( 'feature-sec1' );
?>
<!-- feature-sec1 -->
<section class="<?php echo esc_attr( $classes ); ?>">
    <div class="container3">
        <div class="row">
            <div class="col-lg-5">
                <div class="sec-title">
                    <?php if ( $subtitulo ) : ?>
                    <span class="sub-title"><?php echo esc_html( $subtitulo ); ?></span>
                    <?php endif; ?>
                    <h2 class="title animated-heading"><?php echo esc_html( $titulo ); ?></h2>
                    <?php if ( $texto ) : ?>
                    <p><?php echo esc_html( $texto ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-7 d-flex align-items-center">
                <div class="row text-center">
                    <?php if ( have_rows( 'saudes' ) ) : while ( have_rows( 'saudes' ) ) : the_row();
                        $icone = get_sub_field( 'icone' );
                        $nome  = get_sub_field( 'nome' );
                        $alt   = $icone['alt'] ?: wp_strip_all_tags( $nome );
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="feature-card">
                            <img width="80"
                                 src="<?php echo esc_url( $icone['sizes']['itk-icon'] ); ?>"
                                 alt="<?php echo esc_attr( $alt ); ?>">
                            <h4 class="title"><?php echo esc_html( $nome ); ?></h4>
                        </div>
                    </div>
                    <?php endwhile; endif; ?>
                    <?php if ( $botao ) : ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                        <a href="#inscricao" class="ibt-btn ibt-btn-secondary scroll-to-id">
                            <span><?php echo esc_html( $botao ); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End feature-sec1 -->
