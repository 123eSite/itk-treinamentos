<?php

add_theme_support('title-tag');
add_theme_support('post-thumbnails');

// Tamanhos de imagem do tema
add_image_size('itk-hero', 1920, 900, true); // Hero slider e banner LP
add_image_size('itk-service-card', 380, 400, true); // Cards de serviço (slider)
add_image_size('itk-feature-square', 750, 1200, false); // Imagem quadrada de seção
add_image_size('itk-feature-wide', 790, 1200, false); // Imagem de feature com tabs
add_image_size('itk-blog-card', 400, 300, true); // Cards de blog (col-lg-4)
add_image_size('itk-icon', 80, 80, true); // Ícones de features
add_image_size('itk-team-member', 323, 332, true); // Fotos da equipe

register_nav_menus(array(
    'menu-principal' => __('Menu principal', 'temaitk'),
));

// ─── Assets: global (home + LP usam o mesmo stack) ───────────────────────────

function temaitk_enqueue_assets()
{
    $uri = get_bloginfo('template_url');

    // Google Fonts
    wp_enqueue_style('temaitk-font-sora', 'https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap', [], null);
    wp_enqueue_style('temaitk-font-manrope', 'https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap', [], null);

    // CSS (ordem idêntica ao HTML estático)
    wp_enqueue_style('temaitk-font-awesome', $uri . '/assets/css/font-awesome.min.css', [], null);
    wp_enqueue_style('temaitk-fontello-enqueue', $uri . '/assets/css/plugins/fontello-enqueue.css', [], null);
    wp_enqueue_style('temaitk-fontello-icons', $uri . '/assets/css/plugins/fontello-icons.css', [], null);
    wp_enqueue_style('temaitk-bootstrap', $uri . '/assets/css/plugins/bootstrap.min.css', [], null);
    wp_enqueue_style('temaitk-swiper', $uri . '/assets/css/plugins/swiper-bundle.min.css', [], null);
    wp_enqueue_style('temaitk-lightgallery', $uri . '/assets/css/plugins/lightgallery-bundle.min.css', [], null);
    wp_enqueue_style('temaitk-style', $uri . '/assets/css/style.css', [], '1.0.0');

    // JS (ordem idêntica ao HTML estático, todos no footer)
    wp_enqueue_script('temaitk-bootstrap', $uri . '/assets/js/bootstrap.min.js', [], null, true);
    wp_enqueue_script('temaitk-swiper', $uri . '/assets/js/vendor/swiper-bundle.min.js', [], null, true);
    wp_enqueue_script('temaitk-lenis', $uri . '/assets/js/vendor/lenis.min.js', [], null, true);
    wp_enqueue_script('temaitk-gsap', $uri . '/assets/js/vendor/gsap.min.js', [], null, true);
    wp_enqueue_script('temaitk-scrolltrigger', $uri . '/assets/js/vendor/ScrollTrigger.min.js', ['temaitk-gsap'], null, true);
    wp_enqueue_script('temaitk-main', $uri . '/assets/js/main.js', ['temaitk-swiper', 'temaitk-scrolltrigger'], null, true);

    // Scripts inline específicos da Landing Page
    if (is_page_template('template-landing-page.php')) {
        wp_add_inline_script('temaitk-main', "
            document.querySelectorAll('.anxiety-video-play-btn').forEach(function(playBtn) {
                var videoTargetId = playBtn.getAttribute('data-video-target');
                var targetVideo = videoTargetId ? document.getElementById(videoTargetId) : null;
                if (!targetVideo) return;
                playBtn.addEventListener('click', function() {
                    targetVideo.currentTime = 0;
                    targetVideo.muted = false;
                    targetVideo.play();
                    playBtn.style.display = 'none';
                });
            });

            document.querySelectorAll('.iframe-scroll-overlay').forEach(function(overlay) {
                var wrapper = overlay.parentElement;
                var iframe  = wrapper.querySelector('iframe');
                overlay.addEventListener('click', function() {
                    this.style.pointerEvents = 'none';
                    if (iframe && iframe.tagName === 'IFRAME') {
                        if (!iframe.src.includes('autoplay=1')) {
                            iframe.src += (iframe.src.includes('?') ? '&' : '?') + 'autoplay=1';
                        }
                    }
                });
                wrapper.addEventListener('mouseleave', function() {
                    overlay.style.pointerEvents = 'auto';
                });
            });
        ");
    }
}
add_action('wp_enqueue_scripts', 'temaitk_enqueue_assets');

// ─── Helper: classes CSS de seção para layouts da LP ─────────────────────────

function temaitk_lp_section_classes( $base = '' ) {
    $classes = $base ? [ $base ] : [];
    switch ( get_sub_field( 'espaco' ) ) {
        case 'superior': $classes[] = 'ibt-section-gapTop';    break;
        case 'inferior': $classes[] = 'ibt-section-gapBottom'; break;
        case 'ambos':    $classes[] = 'ibt-section-gap';       break;
    }
    if ( get_sub_field( 'cor_fundo' ) === 'cinza' ) {
        $classes[] = 'bg-gray';
    }
    return implode( ' ', array_filter( $classes ) );
}
