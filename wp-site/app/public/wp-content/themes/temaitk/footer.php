        <?php
        // Opções Globais do Tema
        $telefone_1 = get_field('telefone_1', 'option');
        $telefone_2 = get_field('telefone_2', 'option');
        $email_contato = get_field('email_contato', 'option');
        $endereco = get_field('endereco', 'option');
        
        $url_facebook = get_field('url_facebook', 'option');
        $url_instagram = get_field('url_instagram', 'option');
        $url_youtube = get_field('url_youtube', 'option');
        
        $footer_contact_title = get_field('footer_contact_title', 'option') ?: 'Dê o próximo passo na sua jornada';
        $footer_contact_text = get_field('footer_contact_text', 'option');
        $footer_contact_shortcode = get_field('footer_contact_shortcode', 'option');
        
        $footer_news_title = get_field('footer_news_title', 'option') ?: 'Cadastre-se para receber nossas novidades';
        $footer_news_shortcode = get_field('footer_news_shortcode', 'option');
        
        $link_politica_cookies = get_field('link_politica_cookies', 'option');
        $link_politica_privacidade = get_field('link_politica_privacidade', 'option');
        ?>
        <!-- main-sec -->
        <section class="main-sec v6">
            <!-- contact-sec -->
            <div id="contato" class="contact-sec ibt-section-gapTop">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="contact-content">
                                <div class="sec-title white">
                                    <span class="sub-title">Mais informações</span>
                                    <h2 class="title animated-heading"><?php echo esc_html($footer_contact_title); ?></h2>
                                    <?php if($footer_contact_text): ?>
                                    <p><?php echo wp_kses_post($footer_contact_text); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="contact-info">
                                            <div class="call-center">
                                                <h4 class="title">Telefones</h4>
                                                <?php if($telefone_1): ?>
                                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $telefone_1)); ?>" class="nmbr"><?php echo esc_html($telefone_1); ?></a>
                                                <?php endif; ?>
                                                <?php if($telefone_2): ?>
                                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $telefone_2)); ?>" class="nmbr"><?php echo esc_html($telefone_2); ?></a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="call-center mb-0">
                                                <h4 class="title">Email</h4>
                                                <?php if($email_contato): ?>
                                                <a href="mailto:<?php echo esc_attr($email_contato); ?>" class="gmail"><?php echo esc_html($email_contato); ?></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="contact-info">
                                            <div class="call-center">
                                                <h4 class="title">Endereço</h4>
                                                <?php if($endereco): ?>
                                                <p><?php echo wp_kses_post($endereco); ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="call-center mb-0">
                                                <h4 class="title">Siga a gente</h4>
                                                <ul class="social-icon">
                                                    <?php if($url_facebook): ?><li><a href="<?php echo esc_url($url_facebook); ?>" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li><?php endif; ?>
                                                    <?php if($url_instagram): ?><li><a href="<?php echo esc_url($url_instagram); ?>" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li><?php endif; ?>
                                                    <?php if($url_youtube): ?><li><a href="<?php echo esc_url($url_youtube); ?>" target="_blank" title="Youtube"><i class="fab fa-youtube"></i></a></li><?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="contact-form">
                                <?php if($footer_contact_shortcode): ?>
                                    <div class="custom-form">
                                        <?php echo do_shortcode($footer_contact_shortcode); ?>
                                    </div>
                                <?php else: ?>
                                <form action="#" method="post" class="custom-form">
                                    <h2>Envie sua mensagem</h2>
                                    <input type="text" id="name" name="name" placeholder="Nome" required>
                                    <input type="email" id="email" name="email" placeholder="E-mail" required>
                                    <input type="text" id="subject" name="subject" placeholder="Telefone" required>
                                    <textarea id="message" name="message" rows="5" placeholder="Mensagem..." required></textarea>

                                    <button type="submit" class="ibt-btn ibt-btn-outline">
                                        <span>Enviar</span>
                                        <i class="icon-arrow-top"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End contact-sec -->

            <!-- footer-style1 -->
            <footer class="footer-style1">
                <div class="footer-top5">
                    <div class="container">
                        <div class="footer-content5">
                            <h2 class="title"><?php echo esc_html($footer_news_title); ?></h2>
                            <div class="form-box5">
                                <?php if($footer_news_shortcode): ?>
                                    <?php echo do_shortcode($footer_news_shortcode); ?>
                                <?php else: ?>
                                <form method="get" class="footer-form5">
                                    <input type="text" placeholder="Email" required="">
                                    <button class="ibt-btn">
                                        <span>Subscribe</span>
                                        <i class="icon-arrow-top"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-botom">
                    <div class="container">
                        <div class="footer-box">
                            <p><a href="<?php echo home_url(); ?>">©ITK Treinamentos</a> <?php echo date('Y'); ?>. Todos os direitos reservados.</p>
                            <span>
                                <?php if($link_politica_cookies): ?>
                                <a href="<?php echo esc_url($link_politica_cookies['url']); ?>" target="<?php echo esc_attr($link_politica_cookies['target']); ?>"><?php echo esc_html($link_politica_cookies['title'] ?: 'Política de cookies'); ?></a>
                                <?php endif; ?>
                                <?php if($link_politica_cookies && $link_politica_privacidade): ?> | <?php endif; ?>
                                <?php if($link_politica_privacidade): ?>
                                <a href="<?php echo esc_url($link_politica_privacidade['url']); ?>" target="<?php echo esc_attr($link_politica_privacidade['target']); ?>"><?php echo esc_html($link_politica_privacidade['title'] ?: 'Política de privacidade'); ?></a>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- footer-style1 -->
        </section>
        <!-- End main-sec -->

    </div><!-- /.wrapper -->

    <?php wp_footer(); ?>
</body>
</html>
