<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Preconnect for faster font loading (PUT THIS FIRST!) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- favicon -->
    <link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/assets/images/logos/icon.png">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
    // Opções Globais do Tema
    $logo_header = get_field('logo_header', 'option');
    $link_loja = get_field('link_loja', 'option');
    $telefone_1 = get_field('telefone_1', 'option');
    $telefone_2 = get_field('telefone_2', 'option');
    $email_contato = get_field('email_contato', 'option');

    $url_facebook = get_field('url_facebook', 'option');
    $url_instagram = get_field('url_instagram', 'option');
    $url_youtube = get_field('url_youtube', 'option');

    // Fallback Logo
    $logo_src = !empty($logo_header) ? $logo_header['url'] : get_template_directory_uri() . '/assets/images/logos/logo-itk-positivo.png';
    ?>
    <div class="wrapper">

        <div class="video-modal">
            <div class="video-modal-content">
                <span class="close-btn">&times;</span>
                <iframe allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
        <!-- search-popup -->
        <div class="search-popup" data-popup="1">
            <div class="search-popup-content">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <button type="submit"><i class="fa fa-search"></i></button>
                    <input type="text" name="s" placeholder="O que está pesquisando?"
                        value="<?php echo get_search_query(); ?>" required>
                </form>
            </div>
        </div>

        <!-- New Mobile Menu -->
        <div data-menu="mobileMenu" class="side-menu2">
            <div class="menu-btns">
                <a href="#" class="popup-search" data-popup="1"><i class="fa fa-search"></i></a>
                <button id="mobileCloseBtn2" class="close-btn"></button>
            </div>

            <?php
            $mobile_menu = wp_nav_menu(array(
                'theme_location' => 'menu-principal',
                'container' => false,
                'items_wrap' => '<ul>%3$s</ul>',
                'fallback_cb' => false,
                'echo' => false,
                'is_mobile_menu' => true,
            ));
            // Garante que nenhuma <div> extra envolva a <ul>, pois o CSS do tema exige .side-menu2 > ul
            echo preg_replace(array('#^<div[^>]*>#', '#</div>$#'), '', trim($mobile_menu));
            ?>
            <div class="menu-contact">
                <span>Mais informações</span>
                <?php if ($telefone_2): ?>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $telefone_2)); ?>" class="nmbr"
                        title="<?php echo esc_attr($telefone_2); ?>"><?php echo esc_html($telefone_2); ?></a>
                <?php endif; ?>
                <?php if ($email_contato): ?>
                    <a href="mailto:<?php echo esc_attr($email_contato); ?>" title=""
                        class="gmail"><?php echo esc_html($email_contato); ?></a>
                <?php endif; ?>
            </div>
            <div class="menu-links">
                <span>Siga a gente:</span>
                <ul class="social-icon">
                    <?php if ($url_facebook): ?>
                        <li><a href="<?php echo esc_url($url_facebook); ?>" target="_blank" title="Facebook"><i
                                    class="fab fa-facebook-f"></i></a></li><?php endif; ?>
                    <?php if ($url_instagram): ?>
                        <li><a href="<?php echo esc_url($url_instagram); ?>" target="_blank" title="Instagram"><i
                                    class="fab fa-instagram"></i></a></li><?php endif; ?>
                    <?php if ($url_youtube): ?>
                        <li><a href="<?php echo esc_url($url_youtube); ?>" target="_blank" title="Youtube"><i
                                    class="fab fa-youtube"></i></a></li><?php endif; ?>
                </ul>
                <a href="#contato" title="" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
                    <span>Fale Conosco</span>
                </a>
            </div>
        </div>
        <!-- Overlay for Mobile Menu -->
        <div class="overlay2"></div>

        <!-- sticky header -->
        <header class="sticky-active">
            <div class="header-menu-area">
                <div class="row gx-20 align-items-center justify-content-between">
                    <div class="col-auto">
                        <div class="header-logo">
                            <a href="<?php echo home_url(); ?>">
                                <img width="300" src="<?php echo esc_url($logo_src); ?>" alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <nav class="main-menu menu-style1">
                            <?php
                            $sticky_menu = wp_nav_menu(array(
                                'theme_location' => 'menu-principal',
                                'container' => false,
                                'items_wrap' => '<ul>%3$s</ul>',
                                'fallback_cb' => false,
                                'echo' => false,
                            ));
                            echo preg_replace(array('#^<div[^>]*>#', '#</div>$#'), '', trim($sticky_menu));
                            ?>
                        </nav>
                    </div>
                    <div class="col-auto d-none d-xl-block">
                        <div class="btn-box">
                            <a href="#" class="popup-search" data-popup="1"><i class="fa fa-search"></i></a>
                            <a href="#contato" title="" class="ibt-btn ibt-btn-outline">
                                <span>Fale Conosco</span>
                                <i class="icon-arrow-top"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <button class="hamburger popup-menu" data-menu="mobileMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </header>
        <!-- End sticky header -->

        <!--======== Header ========-->
        <header class="vs-header6">
            <div class="header-top4">
                <div class="container-fluid">
                    <div class="header-top-content4">
                        <ul class="top-bar-socials">
                            <?php if ($url_facebook): ?>
                                <li><a href="<?php echo esc_url($url_facebook); ?>" target="_blank" title="Facebook"><i
                                            class="fab fa-facebook-f"></i></a></li><?php endif; ?>
                            <?php if ($url_instagram): ?>
                                <li><a href="<?php echo esc_url($url_instagram); ?>" target="_blank" title="Instagram"><i
                                            class="fab fa-instagram"></i></a></li><?php endif; ?>
                            <?php if ($url_youtube): ?>
                                <li><a href="<?php echo esc_url($url_youtube); ?>" target="_blank" title="Youtube"><i
                                            class="fab fa-youtube"></i></a></li><?php endif; ?>
                        </ul>
                        <ul class="top-bar-contacts">
                            <?php if ($telefone_2): ?>
                                <li>
                                    <i class="fab fa-whatsapp"></i>
                                    <a
                                        href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $telefone_2)); ?>"><?php echo esc_html($telefone_2); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if ($email_contato): ?>
                                <li>
                                    <i class="far fa-envelope"></i>
                                    <a
                                        href="mailto:<?php echo esc_attr($email_contato); ?>"><?php echo esc_html($email_contato); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if ($link_loja): ?>
                                <li>
                                    <i class="fas fa-bag-shopping"></i>
                                    <a href="<?php echo esc_url($link_loja['url']); ?>"
                                        target="<?php echo esc_attr($link_loja['target']); ?>"><?php echo esc_html($link_loja['title'] ?: 'Acesse nossa loja'); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>

                    </div>
                </div>
            </div>
            <!--vs-main-menu-wrapper start-->
            <div class="header-bottom2">
                <div class="container2 position-relative">
                    <div class="header-menu-area m-0">
                        <div class="row gx-20 align-items-center justify-content-between">
                            <div class="col-auto">
                                <div class="header-logo">
                                    <a href="<?php echo home_url(); ?>">
                                        <img width="300" src="<?php echo esc_url($logo_src); ?>" alt="logo">
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <nav class="main-menu menu-style1">
                                    <?php
                                    $normal_menu = wp_nav_menu(array(
                                        'theme_location' => 'menu-principal',
                                        'container' => false,
                                        'items_wrap' => '<ul>%3$s</ul>',
                                        'fallback_cb' => false,
                                        'echo' => false,
                                    ));
                                    echo preg_replace(array('#^<div[^>]*>#', '#</div>$#'), '', trim($normal_menu));
                                    ?>
                                </nav>
                            </div>
                            <div class="col-auto d-none d-xl-block">
                                <div class="btn-box">
                                    <a href="#" class="popup-search" data-popup="1"><i class="fa fa-search"></i></a>
                                    <a href="#contato" title="" class="ibt-btn ibt-btn-outline">
                                        <span>Fale Conosco</span>
                                        <i class="icon-arrow-top"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button class="hamburger popup-menu" data-menu="mobileMenu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!--vs-main-menu-wrapper end-->
        </header>
        <!--======== / Header ========-->