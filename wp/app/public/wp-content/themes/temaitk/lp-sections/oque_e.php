<?php
$subtitulo  = get_sub_field( 'subtitulo' );
$titulo     = get_sub_field( 'titulo' );
$video      = get_sub_field( 'video' );
$logo_marca = get_sub_field( 'logo_marca' );
$par1       = get_sub_field( 'paragrafo_1' );
$botao      = get_sub_field( 'botao_texto' );
$classes    = temaitk_lp_section_classes( 'about-us-sec9' );
?>
<!-- about-us-sec9 -->
<section id="oque-e" class="<?php echo esc_attr( $classes ); ?>">
    <div class="container3">
        <div class="title-area">
            <div class="sec-title">
                <?php if ( $subtitulo ) : ?>
                <span class="sub-title"><?php echo esc_html( $subtitulo ); ?></span>
                <?php endif; ?>
                <h2 class="title animated-heading"><?php echo esc_html( $titulo ); ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 d-lg-flex align-items-center">
                <div class="anxiety-video-wrap">
                    <video id="anxietyVideo" class="w-100" autoplay loop muted playsinline controls>
                        <source src="<?php echo esc_url( $video['url'] ); ?>" type="video/mp4">
                    </video>
                    <button class="anxiety-video-play-btn" type="button" data-video-target="anxietyVideo"
                        aria-label="Reproduzir vídeo com som">
                        <i class="fa-solid fa-play"></i>
                    </button>
                </div>
            </div>
            <div class="col-lg-6 d-lg-flex align-items-center">
                <div class="about-info9 ps-lg-5">
                    <?php if ( $par1 ) : ?><p><?php echo $par1; ?></p><?php endif; ?>
                    <div class="d-xl-flex justify-content-center align-items-center gap-3">
                        <?php if ( $botao ) : ?>
                        <a href="#inscricao" class="ibt-btn ibt-btn-secondary scroll-to-id">
                            <span><?php echo esc_html( $botao ); ?></span>
                        </a>
                        <?php endif; ?>
                        <?php if ( $logo_marca ) : ?>
                        <img class="mt-3 mt-xl-0" width="260"
                             src="<?php echo esc_url( $logo_marca['url'] ); ?>"
                             alt="<?php echo esc_attr( $logo_marca['alt'] ); ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End about-us-sec9 -->
