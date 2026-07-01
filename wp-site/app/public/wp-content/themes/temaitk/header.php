<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Preconnect for faster font loading (PUT THIS FIRST!) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- favicon -->
    <link rel="icon" type="image/png" href="<?php bloginfo( 'template_url' ); ?>/assets/images/logos/icon.png">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
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
                <form>
                    <button type="submit"><i class="fa fa-search"></i></button>
                    <input type="text" placeholder="O que está pesquisando?" required>
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
            wp_nav_menu( array(
                'theme_location' => 'menu-mobile',
                'container'      => false,
                'fallback_cb'    => false,
            ) );
            ?>
            <div class="menu-contact">
                <span>Mais informações</span>
                <a href="#" class="nmbr" title="(19) 99722-2250">(19) 99722-2250</a>
                <a href="mailto:itk@itktreinamentos.com.br" title="" class="gmail">itk@itktreinamentos.com.br</a>
            </div>
            <div class="menu-links">
                <span>Siga a gente:</span>
                <ul class="social-icon">
                    <li><a href="#" title=""><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#" title=""><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#" title=""><i class="fab fa-youtube"></i></a></li>
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
                            <a href="#">
                                <img width="300" src="<?php bloginfo( 'template_url' ); ?>/assets/images/logos/logo-itk-positivo.png" alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <nav class="main-menu menu-style1">
                            <?php
                            wp_nav_menu( array(
                                'theme_location' => 'menu-principal',
                                'container'      => false,
                                'fallback_cb'    => false,
                            ) );
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
                            <li><a href="#" title=""><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" title=""><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#" title=""><i class="fab fa-youtube"></i></a></li>
                        </ul>
                        <ul class="top-bar-contacts">
                            <li>
                                <i class="fab fa-whatsapp"></i>
                                <a href="tel:+18005291037">(19) 99722-2250</a>
                            </li>
                            <li>
                                <i class="far fa-envelope"></i>
                                <a href="mailto:itk@itktreinamentos.com.br">itk@itktreinamentos.com.br</a>
                            </li>
                            <li>
                                <i class="fas fa-bag-shopping"></i>
                                <a href="#">Acesse nossa loja</a>
                            </li>
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
                                    <a href="#">
                                        <img width="300" src="<?php bloginfo( 'template_url' ); ?>/assets/images/logos/logo-itk-positivo.png" alt="logo">
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <nav class="main-menu menu-style1">
                                    <?php
                                    wp_nav_menu( array(
                                        'theme_location' => 'menu-principal',
                                        'container'      => false,
                                        'fallback_cb'    => false,
                                    ) );
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
