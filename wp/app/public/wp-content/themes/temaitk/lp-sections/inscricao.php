<?php
$subtitulo         = get_sub_field( 'subtitulo' );
$titulo            = get_sub_field( 'titulo' );
$titulo_formulario = get_sub_field( 'titulo_formulario' );
$data_formulario   = get_sub_field( 'data_formulario' );
$texto_formulario  = get_sub_field( 'texto_formulario' );
$shortcode         = get_sub_field( 'shortcode_formulario' );

$infos = [];
if ( have_rows( 'infos' ) ) {
    while ( have_rows( 'infos' ) ) {
        the_row();
        $infos[] = [
            'icone'  => get_sub_field( 'icone' ),
            'rotulo' => get_sub_field( 'rotulo' ),
            'valor'  => get_sub_field( 'valor' ),
        ];
    }
}
$total         = count( $infos );
$inner_classes = trim( 'contact-sec ' . temaitk_lp_section_classes( '', true, false ) );
?>
<!-- main-sec v6 / inscricao -->
<section class="main-sec v6">
    <div id="inscricao" class="<?php echo esc_attr( $inner_classes ); ?>  ibt-section-gapTop">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="contact-content">
                        <div class="sec-title white">
                            <?php if ( $subtitulo ) : ?>
                            <span class="sub-title"><?php echo esc_html( $subtitulo ); ?></span>
                            <?php endif; ?>
                            <h2 class="title animated-heading"><?php echo esc_html( $titulo ); ?></h2>
                        </div>
                        <div class="row">
                            <?php foreach ( $infos as $i => $info ) : ?>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="contact-info">
                                    <div class="call-center call-center--icon<?php echo ( $i === $total - 1 ) ? ' mb-lg-0' : ''; ?>">
                                        <span class="call-center__icon" aria-hidden="true">
                                            <i class="<?php echo esc_attr( $info['icone'] ); ?>"></i>
                                        </span>
                                        <div class="call-center__body">
                                            <h4 class="title"><?php echo esc_html( $info['rotulo'] ); ?></h4>
                                            <span class="nmbr text-white d-block"><?php echo esc_html( $info['valor'] ); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form custom-form">
                        <h2 style="font-size: 28px; line-height: 1.3;">
                            <?php echo esc_html( $titulo_formulario ); ?>
                            <?php if ( $data_formulario ) : ?>
                            <span style="color: var(--color-primary);"><?php echo esc_html( $data_formulario ); ?></span>
                            <?php endif; ?>
                        </h2>
                        <?php if ( $texto_formulario ) : ?>
                        <p><?php echo esc_html( $texto_formulario ); ?></p>
                        <?php endif; ?>
                        <?php echo do_shortcode( $shortcode ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer-style1 -->
    <footer class="footer-style1">
        <div class="footer-botom">
            <div class="container">
                <div class="footer-box">
                    <p><a href="#">©ITK Treinamentos</a> <?php echo date( 'Y' ); ?>. Todos os direitos reservados.</p>
                    <span><a href="#">Política de cookies</a> | <a href="#">Política de privacidade</a></span>
                </div>
            </div>
        </div>
    </footer>
    <!-- End footer-style1 -->
</section>
<!-- End main-sec v6 / inscricao -->
