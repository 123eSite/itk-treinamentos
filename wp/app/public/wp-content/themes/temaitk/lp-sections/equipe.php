<?php
$subtitulo = get_sub_field( 'subtitulo' );
$titulo    = get_sub_field( 'titulo' );
$texto     = get_sub_field( 'texto' );
$classes   = temaitk_lp_section_classes( 'team-section2' );
?>
<!-- team-section2 -->
<section class="<?php echo esc_attr( $classes ); ?>">
    <div class="container3">
        <div class="title-area">
            <div class="row align-items-end mb-0">
                <div class="col-xl-8 col-lg-8">
                    <div class="sec-title">
                        <?php if ( $subtitulo ) : ?>
                        <span class="sub-title"><?php echo esc_html( $subtitulo ); ?></span>
                        <?php endif; ?>
                        <h2 class="title animated-heading"><?php echo esc_html( $titulo ); ?></h2>
                    </div>
                    <?php if ( $texto ) : ?>
                    <p><?php echo esc_html( $texto ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if ( have_rows( 'membros' ) ) : while ( have_rows( 'membros' ) ) : the_row();
                $foto      = get_sub_field( 'foto' );
                $nome      = get_sub_field( 'nome' );
                $cargo     = get_sub_field( 'cargo' );
                $linkedin  = get_sub_field( 'linkedin' );
                $instagram = get_sub_field( 'instagram' );
                $alt_foto  = $foto['alt'] ?: wp_strip_all_tags( $nome );
            ?>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-member2">
                    <div class="team-card">
                        <div class="team-img">
                            <a href="#">
                                <img src="<?php echo esc_url( $foto['sizes']['itk-team-member'] ); ?>"
                                     alt="<?php echo esc_attr( $alt_foto ); ?>">
                            </a>
                            <div class="team-shap"></div>
                        </div>
                        <div class="team-content">
                            <?php if ( $linkedin || $instagram ) : ?>
                            <div class="share-box">
                                <span class="share-icon fa fa-share-alt"></span>
                                <ul class="social-links">
                                    <?php if ( $linkedin ) : ?>
                                    <li><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a></li>
                                    <?php endif; ?>
                                    <?php if ( $instagram ) : ?>
                                    <li><a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                            <h4 class="name"><a href="#"><?php echo esc_html( $nome ); ?></a></h4>
                            <span class="designation"><?php echo esc_html( $cargo ); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>
<!-- End team-section2 -->
