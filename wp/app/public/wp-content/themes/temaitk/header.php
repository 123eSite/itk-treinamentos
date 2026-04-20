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

<body <?php body_class(); ?>>
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

        <!-- search-popup -->
        <div class="search-popup" data-popup="1">
            <div class="search-popup-content">
                <form>
                    <button type="submit"><i class="fa fa-search"></i></button>
                    <input type="text" placeholder="O que está pesquisando?" required>
                </form>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div data-menu="mobileMenu" class="side-menu2">
            <div class="menu-btns">
                <a href="#" class="popup-search" data-popup="1"><i class="fa fa-search"></i></a>
                <button id="mobileCloseBtn2" class="close-btn"></button>
            </div>
            <ul>
                <li>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="active">Home</a>
                </li>
                <li>
                    <a href="#">O Instituto ITK</a>
                </li>
                <li class="menu-item-has-children">
                    <a href="#">Cursos e Treinamentos</a>
                    <ul class="sub-menu">
                        <li><a href="#">Leader Training</a></li>
                        <li><a href="#">Leader Training 2</a></li>
                        <li><a href="#">A Transformação através do amor</a></li>
                        <li><a href="#">Constelações Familiares</a></li>
                        <li><a href="#">Reiki nível I</a></li>
                        <li><a href="#">Reiki nível II</a></li>
                        <li><a href="#">Sob medida</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children">
                    <a href="#">Para Você</a>
                    <ul class="sub-menu">
                        <li><a href="#">Agenda</a></li>
                        <li><a href="#">Projeto de vida</a></li>
                        <li><a href="#">Mandala</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Blog</a>
                </li>
            </ul>
            <div class="menu-contact">
                <span>Mais informações</span>
                <a href="tel:+5519997222250" class="nmbr" title="(19) 99722-2250">(19) 99722-2250</a>
                <a href="mailto:itk@itktreinamentos.com.br" title="" class="gmail">itk@itktreinamentos.com.br</a>
            </div>
            <div class="menu-links">
                <span>Siga a gente:</span>
                <ul class="social-icon">
                    <li><a href="#" title=""><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#" title=""><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#" title=""><i class="fab fa-youtube"></i></a></li>
                </ul>
                <a href="#" title="" class="ibt-btn ibt-btn-outline-3 ibt-btn-rounded">
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
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <img width="300" src="<?php bloginfo( 'template_url' ); ?>/assets/images/logos/logo-itk-positivo.png" alt="ITK Treinamentos">
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <nav class="main-menu menu-style1">
                            <ul>
                                <li>
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="active">
                                        <span class="menu-item">Home</span>
                                        <span class="menu-item2">Home</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="menu-item">O Instituto</span>
                                        <span class="menu-item2">O Instituto</span>
                                    </a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">
                                        <span class="menu-item">Cursos e Treinamentos</span>
                                        <span class="menu-item2">Cursos e Treinamentos</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><a href="#">Leader Training</a></li>
                                        <li><a href="#">Leader Training 2</a></li>
                                        <li><a href="#">A Transformação através do amor</a></li>
                                        <li><a href="#">Constelações Familiares</a></li>
                                        <li><a href="#">Reiki nível I</a></li>
                                        <li><a href="#">Reiki nível II</a></li>
                                        <li><a href="#">Sob medida</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">
                                        <span class="menu-item">Para Você</span>
                                        <span class="menu-item2">Para Você</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><a href="#">Agenda</a></li>
                                        <li><a href="#">Projeto de vida</a></li>
                                        <li><a href="#">Mandala</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="menu-item">Blog</span>
                                        <span class="menu-item2">Blog</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-auto d-none d-xl-block">
                        <div class="btn-box">
                            <a href="#" class="popup-search" data-popup="1"><i class="fa fa-search"></i></a>
                            <a href="#" title="" class="ibt-btn ibt-btn-outline">
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
                                <a href="tel:+5519997222250">(19) 99722-2250</a>
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
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                        <img width="300" src="<?php bloginfo( 'template_url' ); ?>/assets/images/logos/logo-itk-positivo.png" alt="ITK Treinamentos">
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <nav class="main-menu menu-style1">
                                    <ul>
                                        <li>
                                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="active">
                                                <span class="menu-item">Home</span>
                                                <span class="menu-item2">Home</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="menu-item">O Instituto</span>
                                                <span class="menu-item2">O Instituto</span>
                                            </a>
                                        </li>
                                        <li class="menu-item-has-children">
                                            <a href="#">
                                                <span class="menu-item">Cursos e Treinamentos</span>
                                                <span class="menu-item2">Cursos e Treinamentos</span>
                                            </a>
                                            <ul class="sub-menu">
                                                <li><a href="#">Leader Training</a></li>
                                                <li><a href="#">Leader Training 2</a></li>
                                                <li><a href="#">A Transformação através do amor</a></li>
                                                <li><a href="#">Constelações Familiares</a></li>
                                                <li><a href="#">Reiki nível I</a></li>
                                                <li><a href="#">Reiki nível II</a></li>
                                                <li><a href="#">Sob medida</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children">
                                            <a href="#">
                                                <span class="menu-item">Para Você</span>
                                                <span class="menu-item2">Para Você</span>
                                            </a>
                                            <ul class="sub-menu">
                                                <li><a href="#">Agenda</a></li>
                                                <li><a href="#">Projeto de vida</a></li>
                                                <li><a href="#">Mandala</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="menu-item">Blog</span>
                                                <span class="menu-item2">Blog</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-auto d-none d-xl-block">
                                <div class="btn-box">
                                    <a href="#" class="popup-search" data-popup="1"><i class="fa fa-search"></i></a>
                                    <a href="#" title="" class="ibt-btn ibt-btn-outline">
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
