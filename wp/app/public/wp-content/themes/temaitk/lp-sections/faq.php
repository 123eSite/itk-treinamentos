<?php
$subtitulo = get_sub_field( 'subtitulo' );
$titulo    = get_sub_field( 'titulo' );
$classes   = temaitk_lp_section_classes( 'faq-sec' );

$perguntas = [];
if ( have_rows( 'perguntas' ) ) {
    while ( have_rows( 'perguntas' ) ) {
        the_row();
        $perguntas[] = [
            'pergunta' => get_sub_field( 'pergunta' ),
            'resposta' => get_sub_field( 'resposta' ),
        ];
    }
}
$total = count( $perguntas );
?>
<!-- faq-sec -->
<section class="<?php echo esc_attr( $classes ); ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="faq-content">
                    <div class="sec-title">
                        <?php if ( $subtitulo ) : ?>
                        <span class="sub-title"><?php echo esc_html( $subtitulo ); ?></span>
                        <?php endif; ?>
                        <h2 class="title animated-heading"><?php echo esc_html( $titulo ); ?></h2>
                    </div>
                    <div class="accordion" id="accordionLp">
                        <?php foreach ( $perguntas as $i => $item ) :
                            $heading_id  = 'lpFaqHeading' . ( $i + 1 );
                            $collapse_id = 'lpFaqCollapse' . ( $i + 1 );
                            $is_first    = $i === 0;
                            $is_last     = $i === $total - 1;
                        ?>
                        <div class="accordion-item<?php echo $is_last ? ' mb-0' : ''; ?>">
                            <h2 class="accordion-header" id="<?php echo esc_attr( $heading_id ); ?>">
                                <button class="accordion-button<?php echo $is_first ? '' : ' collapsed'; ?>"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>"
                                    aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
                                    aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
                                    <?php echo esc_html( $item['pergunta'] ); ?>
                                </button>
                            </h2>
                            <div id="<?php echo esc_attr( $collapse_id ); ?>"
                                class="accordion-collapse collapse<?php echo $is_first ? ' show' : ''; ?>"
                                aria-labelledby="<?php echo esc_attr( $heading_id ); ?>"
                                data-bs-parent="#accordionLp">
                                <div class="accordion-body">
                                    <?php echo wp_kses_post( $item['resposta'] ); ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End faq-sec -->
