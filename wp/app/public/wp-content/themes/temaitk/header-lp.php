<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="<?php bloginfo( 'template_url' ); ?>/assets/images/logos/icon.png">

    <?php wp_head(); ?>
</head>

<body <?php body_class( 'landing-page' ); ?>>
    <div class="wrapper">

        <!-- Preloader -->
        <div id="preloader">
            <div class="loader">
                <img src="<?php bloginfo( 'template_url' ); ?>/assets/images/logos/icon.png" alt="Carregando...">
            </div>
        </div>
        <!-- End Preloader -->

        <div class="video-modal">
            <div class="video-modal-content">
                <span class="close-btn">&times;</span>
                <iframe allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>

        <!-- Overlay for Mobile Menu -->
        <div class="overlay2"></div>
