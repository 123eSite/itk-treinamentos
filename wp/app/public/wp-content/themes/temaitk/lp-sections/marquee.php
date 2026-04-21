<?php
$classes = temaitk_lp_section_classes( 'marquee-sec small' );

$frases = [];
if ( have_rows( 'frases' ) ) {
    while ( have_rows( 'frases' ) ) {
        the_row();
        $frases[] = get_sub_field( 'frase' );
    }
}
if ( ! $frases ) return;
?>
<!-- marquee-sec -->
<section class="<?php echo esc_attr( $classes ); ?>">
    <h2 style="display:none;">Marquee Section</h2>
    <div class="marquee">
        <div class="marquee-inner">
            <?php for ( $r = 0; $r < 4; $r++ ) : foreach ( $frases as $frase ) : ?>
            <span><?php echo esc_html( $frase ); ?></span>
            <?php endforeach; endfor; ?>
        </div>
    </div>
</section>
<!-- End marquee-sec -->
