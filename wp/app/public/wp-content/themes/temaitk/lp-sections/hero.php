<?php
$imagem_banner = get_sub_field('imagem_banner');
$logo_principal = get_sub_field('logo_principal');
$data_evento = get_sub_field('data_evento');
$titulo = get_sub_field('titulo');
$texto = get_sub_field('texto');
$botao_texto = get_sub_field('botao_texto');
$cor_titulo = get_sub_field('cor_titulo');
$cor_texto = get_sub_field('cor_texto');
?>
<!-- hero-style8 -->
<section class="hero-style8">
    <?php if ($imagem_banner): ?>
        <div class="parallax-wrap">
            <img src="<?php echo esc_url($imagem_banner['sizes']['itk-hero']); ?>"
                alt="<?php echo esc_attr($imagem_banner['alt']); ?>" class="parallax-img">
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="hero-content8 text-center">
                    <?php if ($data_evento): ?>
                        <div class="date"><?php echo esc_html($data_evento); ?></div>
                    <?php endif; ?>
                    <?php if ($logo_principal): ?>
                        <img width="400" src="<?php echo esc_url($logo_principal['url']); ?>"
                            alt="<?php echo esc_attr($logo_principal['alt']); ?>" class="logo-leader-training">
                    <?php endif; ?>
                    <h2 class="title" <?php echo $cor_titulo ? ' style="color: ' . esc_attr($cor_titulo) . ';"' : ''; ?>><?php echo esc_html($titulo); ?></h2>
                    <?php if ($texto): ?>
                        <p<?php echo $cor_texto ? ' style="color: ' . esc_attr($cor_texto) . ';"' : ''; ?>>
                            <?php echo nl2br(esc_html($texto)); ?></p>
                        <?php endif; ?>
                        <?php if ($botao_texto): ?>
                            <a href="#oque-e" class="ibt-btn scroll-to-id">
                                <span><?php echo esc_html($botao_texto); ?></span>
                            </a>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-scroll">
        <span>Descubra</span>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
</section>
<!-- End hero-style8 -->