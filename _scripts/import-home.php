<?php
/**
 * Script de Importação — Página Inicial (Home) TNS Summit
 * ========================================================
 * Como executar (no shell do LocalWP):
 *   wp eval-file "D:\Clientes\Localsites\TNS-Summit\_scripts\import-home.php" --path="D:\Clientes\Localsites\TNS-Summit\wp\app\public"
 *
 * Imagens, ícones e vídeos serão inseridos manualmente pelo painel.
 */

// ─── 1. Localizar a página inicial ───────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "  IMPORT: Página Inicial (Home) — TNS Summit\n";
echo "════════════════════════════════════════\n\n";

$pid = (int) get_option( 'page_on_front' );
if ( ! $pid ) { echo "✗  Nenhuma página estática definida como inicial.\n   Vá em Configurações → Leitura e defina a página inicial.\n"; return; }

$page = get_post( $pid );
echo "📄  Página encontrada: \"{$page->post_title}\" (ID: $pid)\n\n";

update_post_meta( $pid, '_wp_page_template', 'front-page.php' );
echo "✓  Template: front-page.php\n";

// ─── 2. Aba: Hero ────────────────────────────────────────────────────────────
echo "\n── Aba: Hero ────────────────────────────\n";

update_field( 'hero_subtitle', 'TNS Summit 2026', $pid );
update_field( 'hero_title_normal', 'Mais que um evento.', $pid );
update_field( 'hero_title_highlight', 'O ponto de encontro de quem move a logística.', $pid );
update_field( 'hero_text', 'O evento da nstech para quem busca as melhores soluções de software para logística, transporte e supply chain, com foco em decisão, integração e negócios reais.', $pid );
update_field( 'hero_countdown_title', 'Sua jornada na TNS começa aqui.', $pid );
update_field( 'hero_btn_link', '#ingressos', $pid );
update_field( 'hero_btn_text', 'Garanta seu ingresso', $pid );
update_field( 'hero_date_label', '09 e 10 de setembro de 2026', $pid );
update_field( 'hero_location_label', 'São Paulo - SP | Transamérica Expo', $pid );
update_field( 'hero_countdown_date', '2026-09-09 23:59:59', $pid );
echo "✓  hero_subtitle / hero_title_normal / hero_title_highlight\n";
echo "✓  hero_text / hero_countdown_title / hero_countdown_date\n";
echo "✓  hero_btn_link / hero_btn_text / hero_date_label / hero_location_label\n";
echo "⚠  hero_video → inserir manualmente no painel\n";

// ─── 3. Aba: Ticker ──────────────────────────────────────────────────────────
echo "\n── Aba: Ticker ──────────────────────────\n";

update_field( 'ticker_items', [
    [ 'title' => '600 pessoas'          ],
    [ 'title' => 'Palcos temáticos'     ],
    [ 'title' => 'Podcast'              ],
    [ 'title' => 'Audiência qualificada'],
    [ 'title' => 'Tecnologia'           ],
    [ 'title' => 'Conexões'             ],
    [ 'title' => 'Embarcadores'         ],
    [ 'title' => 'transportadores'      ],
    [ 'title' => 'operadores'           ],
    [ 'title' => 'soluções'             ],
    [ 'title' => 'Estratégias'          ],
    [ 'title' => 'Logística'            ],
    [ 'title' => 'Futuro'               ],
    [ 'title' => 'IA'                   ],
], $pid );
echo "✓  ticker_items: 14 itens\n";

// ─── 4. Aba: Sobre ───────────────────────────────────────────────────────────
echo "\n── Aba: Sobre ───────────────────────────\n";

update_field( 'sobre_subtitle', 'SOBRE O EVENTO', $pid );
update_field( 'sobre_title_normal', 'O que é o', $pid );
update_field( 'sobre_title_highlight', 'TNS Summit', $pid );
update_field( 'sobre_desc', 'O TNS Summit acontece junto à Logística do Futuro, integrando-se ao maior ambiente de inovação logística do país com uma experiência própria, exclusiva e orientada a resultados.', $pid );
update_field( 'sobre_list', [
    [ 'text' => 'Enquanto a <strong>Logística do Futuro</strong> amplia o debate, no <strong>TNS Summit</strong> você decide.' ],
    [ 'text' => 'Mais de <strong>2.500 líderes e decisores</strong> reunidos para conectar pessoas, dados, tecnologia e negócios em um único ecossistema.' ],
], $pid );
echo "✓  sobre_subtitle / sobre_title_normal / sobre_title_highlight\n";
echo "✓  sobre_desc / sobre_list: 2 itens\n";
echo "⚠  sobre_video → inserir manualmente no painel\n";

// ─── 5. Aba: Por que participar ──────────────────────────────────────────────
echo "\n── Aba: Por que participar ──────────────\n";

update_field( 'pq_subtitle', 'POR QUE PARTICIPAR', $pid );
update_field( 'pq_title_normal', 'Por que o TNS Summit é', $pid );
update_field( 'pq_title_highlight', 'diferente?', $pid );
update_field( 'pq_diferenciais', [
    [ 'title' => 'Negócios reais',        'text' => 'Conecte-se com quem decide e contrata.'                                       ],
    [ 'title' => 'Decisão mais rápida',   'text' => 'Compare soluções e estratégias em um único ambiente.'                         ],
    [ 'title' => 'Conexões de alto nível','text' => 'Embarcadores, transportadores, operadores, seguradoras e tecnologia.'         ],
    [ 'title' => 'Rede, não silos',       'text' => 'A logística funcionando como um ecossistema integrado.'                       ],
], $pid );
update_field( 'pq_footer_text',
    '<p>A logística não é linear. Ela acontece quando <strong>pessoas</strong>,'
    . ' <strong>dados</strong>, <strong>processos</strong> e <strong>tecnologia</strong> se'
    . ' <strong>conectam</strong>.</p>',
    $pid
);
echo "✓  pq_subtitle / pq_title_normal / pq_title_highlight\n";
echo "✓  pq_diferenciais: 4 itens / pq_footer_text\n";
echo "⚠  pq_diferenciais → ícones de cada item: inserir manualmente no painel\n";

// ─── 6. Aba: O que vai encontrar ─────────────────────────────────────────────
echo "\n── Aba: O que vai encontrar ─────────────\n";

update_field( 'oque_subtitle', 'O QUE VOCÊ VAI ENCONTRAR', $pid );
update_field( 'oque_title_normal', 'Uma', $pid );
update_field( 'oque_title_highlight', 'experiência pensada para quem decide', $pid );
update_field( 'oque_list', [
    [ 'text' => 'Audiência altamente qualificada'                   ],
    [ 'text' => 'Conteúdo estratégico e aplicado'                   ],
    [ 'text' => '8 palcos organizados por segmentos'                ],
    [ 'text' => 'As principais empresas de tecnologia do setor'     ],
], $pid );
update_field( 'oque_text',
    '<p>Aqui, a conversa não é sobre ferramenta.<br>'
    . 'É sobre <strong>visão e impacto no negócio.</strong></p>',
    $pid
);
update_field( 'oque_btn', [ 'url' => '#ingressos', 'title' => 'Garanta seu ingresso', 'target' => '_self' ], $pid );
echo "✓  oque_subtitle / oque_title_normal / oque_title_highlight\n";
echo "✓  oque_list: 4 itens / oque_text / oque_btn\n";
echo "⚠  oque_img_1 / oque_img_2 → inserir manualmente no painel\n";

// ─── 7. Aba: Trilhas ─────────────────────────────────────────────────────────
echo "\n── Aba: Trilhas ─────────────────────────\n";

update_field( 'trilhas_subtitle', 'TRILHAS DE CONTEÚDO', $pid );
update_field( 'trilhas_title_normal', 'Palcos temáticos para facilitar', $pid );
update_field( 'trilhas_title_highlight', 'aprendizado, comparação e decisão.', $pid );
update_field( 'trilhas_lista', [
    [ 'title' => 'Agro Frigorificado',                    'text' => 'Debates sobre logística de cargas refrigeradas, rastreabilidade e controle de temperatura. Cases e estratégias para garantir qualidade, eficiência e segurança na cadeia de proteínas e perecíveis.' ],
    [ 'title' => 'Granel + Químico',                      'text' => 'Conteúdos sobre transporte de granéis sólidos e líquidos, gestão de riscos, compliance e segurança operacional. Discussões sobre eficiência logística em cadeias industriais críticas.' ],
    [ 'title' => 'Alimentos e Bens de Consumo',           'text' => 'Estratégias para operações de alta escala, distribuição eficiente e visibilidade da cadeia. Como reduzir custos e melhorar nível de serviço no transporte de bens de consumo.' ],
    [ 'title' => 'Indústria de Base + Automotivo',        'text' => 'Painéis sobre logística industrial, integração com manufatura e resiliência da cadeia automotiva. Boas práticas para operações complexas e altamente sincronizadas.' ],
    [ 'title' => 'Farma / Cosméticos',                    'text' => 'Debates sobre rastreabilidade, exigências regulatórias e integridade da cadeia logística. Soluções para transporte seguro de produtos sensíveis e de alto valor.' ],
    [ 'title' => 'Tecnologia / E-commerce',               'text' => 'Inovação aplicada à logística digital, integração de plataformas, dados e automação. Discussões sobre eficiência, escalabilidade e desafios do crescimento do e-commerce.' ],
    [ 'title' => 'Transformação Digital do Embarcador',   'text' => 'Como embarcadores estão utilizando tecnologia, dados e inteligência logística para ganhar eficiência, visibilidade e maior controle sobre suas operações.' ],
    [ 'title' => 'Transformação Digital do Transportador','text' => 'Conteúdos sobre digitalização das transportadoras, gestão de frota, produtividade e uso de tecnologia para aumentar competitividade e eficiência operacional.' ],
], $pid );
echo "✓  trilhas_subtitle / trilhas_title_normal / trilhas_title_highlight\n";
echo "✓  trilhas_lista: 8 trilhas\n";
echo "⚠  trilhas_lista → imagem de cada trilha: inserir manualmente no painel\n";

// ─── 8. Aba: Estrutura ───────────────────────────────────────────────────────
echo "\n── Aba: Estrutura ───────────────────────\n";

update_field( 'est_subtitle', 'ESTRUTURA DO EVENTO', $pid );
update_field( 'est_title_normal', 'O', $pid );
update_field( 'est_title_highlight', 'TNS Summit 2026 em números', $pid );
update_field( 'est_desc',
    '<p>O TNS Summit é a TNS acontecendo ao vivo:'
    . ' um <strong>ecossistema</strong> real, <strong>conectado</strong> e em <strong>movimento</strong>.</p>',
    $pid
);
update_field( 'est_numbers', [
    [ 'number' => '8',  'label' => 'trilhas'         ],
    [ 'number' => '8',  'label' => 'palcos temáticos'],
    [ 'number' => '30', 'label' => 'patrocinadores'  ],
], $pid );
update_field( 'est_vip_list', [
    [ 'text' => 'Área VIP para clientes e convidados' ],
    [ 'text' => 'Estúdio de podcast'                  ],
], $pid );
echo "✓  est_subtitle / est_title_normal / est_title_highlight / est_desc\n";
echo "✓  est_numbers: 3 itens / est_vip_list: 2 itens\n";

// ─── 9. Aba: Para quem é ─────────────────────────────────────────────────────
echo "\n── Aba: Para quem é ─────────────────────\n";

update_field( 'pqm_subtitle', 'PARA QUEM É', $pid );
update_field( 'pqm_title_normal', 'Este evento é para', $pid );
update_field( 'pqm_title_highlight', 'você que:', $pid );
update_field( 'pqm_items', [
    [ 'title' => 'Atua em logística, supply chain, operações ou tecnologia'      ],
    [ 'title' => 'Lidera decisões em embarcadores, transportadores e operadores' ],
    [ 'title' => 'Enxerga a logística como vantagem competitiva'                 ],
    [ 'title' => 'Se conectar é o novo competir, este é o seu lugar.'            ],
], $pid );
echo "✓  pqm_subtitle / pqm_title_normal / pqm_title_highlight\n";
echo "✓  pqm_items: 4 itens\n";
echo "⚠  pqm_items → ícone de cada item: inserir manualmente no painel\n";
echo "⚠  pqm_img_1 / pqm_img_2 → inserir manualmente no painel\n";

// ─── 10. Aba: Ingressos ──────────────────────────────────────────────────────
echo "\n── Aba: Ingressos ───────────────────────\n";

update_field( 'ingr_subtitle', 'INGRESSOS', $pid );
update_field( 'ingr_title_normal', 'Garanta sua', $pid );
update_field( 'ingr_title_highlight', 'participação', $pid );
update_field( 'ingr_desc', 'Escolha sua experiência e faça parte do maior ponto de encontro da logística no Brasil.', $pid );
update_field( 'ingr_plans', [
    [
        'title'          => 'Ingresso Simple Pass',
        'desc'           => 'Para quem quer conhecer o evento em um dia.',
        'price'          => 'R$ 220',
        'price_suffix'   => ' /por pessoa',
        'includes_title' => 'O que está incluso:',
        'includes_list'  => [
            [ 'text' => '1 dia de entrada para o evento'        ],
            [ 'text' => 'Acesso às plenárias e conteúdos do dia'],
            [ 'text' => 'Participação nas atividades do evento' ],
        ],
        'button' => [ 'url' => 'https://euvou.events/tnssummit2026', 'title' => 'Garantir Ingresso Básico', 'target' => '_blank' ],
    ],
    [
        'title'          => 'Ingresso Full Pass',
        'desc'           => 'Para quem quer viver a experiência completa do TNS Summit.',
        'price'          => 'R$ 690',
        'price_suffix'   => ' /por pessoa',
        'includes_title' => 'O que está incluso:',
        'includes_list'  => [
            [ 'text' => '2 dias de entrada para o evento'      ],
            [ 'text' => 'Acesso a todos os palcos e conteúdos' ],
            [ 'text' => 'Experiência completa do evento'        ],
        ],
        'button' => [ 'url' => 'https://euvou.events/tnssummit2026', 'title' => 'Garantir Full Pass', 'target' => '_blank' ],
    ],
    [
        'title'          => 'Ingresso VIP Pass',
        'desc'           => 'Experiência premium para quem busca mais conforto e networking qualificado.',
        'price'          => 'R$ 890',
        'price_suffix'   => ' /por pessoa',
        'includes_title' => 'O que está incluso:',
        'includes_list'  => [
            [ 'text' => '2 dias de entrada para o evento'          ],
            [ 'text' => 'Acesso à Área VIP (almoços e happy hour)' ],
            [ 'text' => 'Espaço reservado na plenária principal'   ],
            [ 'text' => 'Credenciamento exclusivo'                 ],
        ],
        'button' => [ 'url' => 'https://euvou.events/tnssummit2026', 'title' => 'Garantir VIP Pass', 'target' => '_blank' ],
    ],
    [
        'title'          => 'TNS Full Pass (clientes nstech)',
        'desc'           => 'Ingresso exclusivo para empresas que fazem parte do ecossistema nstech.',
        'price'          => 'R$ 390',
        'price_suffix'   => ' /por pessoa',
        'includes_title' => 'O que está incluso:',
        'includes_list'  => [
            [ 'text' => '2 dias de entrada para o evento'         ],
            [ 'text' => 'Acesso completo à programação do evento' ],
        ],
        'button' => [ 'url' => 'https://euvou.events/tnssummit2026@tnsfull', 'title' => 'Garantir TNS Full Pass', 'target' => '_blank' ],
    ],
    [
        'title'          => 'Pacotes Corporativos',
        'desc'           => 'Condições especiais para empresas que desejam levar equipes ao evento.',
        'price'          => '',
        'price_suffix'   => '',
        'includes_title' => 'Preços por quantidade (2 dias):',
        'includes_list'  => [
            [ 'text' => '20 ingressos (2 dias): R$ 414 por pessoa'],
            [ 'text' => '10 ingressos (2 dias): R$ 483 por pessoa'],
            [ 'text' => '5 ingressos (2 dias): R$ 552 por pessoa' ],
        ],
        'button' => [ 'url' => 'https://euvou.events/tnssummit2026@ingressocorporativo', 'title' => 'Solicitar Pacote Corporativo', 'target' => '_blank' ],
    ],
], $pid );
echo "✓  ingr_subtitle / ingr_title_normal / ingr_title_highlight / ingr_desc\n";
echo "✓  ingr_plans: 5 planos (Simple Pass, Full Pass, VIP Pass, TNS Full Pass, Corporativo)\n";
echo "⚠  ingr_plans → ícone de cada plano: inserir manualmente no painel\n";

// ─── 11. Aba: Call to Action ─────────────────────────────────────────────────
echo "\n── Aba: Call to Action ──────────────────\n";

update_field( 'cta_subtitle', 'Faça parte da rede', $pid );
update_field( 'cta_title_normal', 'Parece mágica. É', $pid );
update_field( 'cta_title_highlight', 'TNS ao vivo.', $pid );
update_field( 'cta_text',
    '<p>O futuro da logística não será construído por sistemas isolados.<br>'
    . 'Será construído por pessoas conectadas.</p>',
    $pid
);
update_field( 'cta_button', [
    'url'    => 'https://share.hsforms.com/1D1uzlJI3RxSZJE1WVCUeVAdy1fw',
    'title'  => 'Seja um patrocinador do TNS Summit',
    'target' => '_blank',
], $pid );
echo "✓  cta_subtitle / cta_title_normal / cta_title_highlight\n";
echo "✓  cta_text / cta_button\n";

// ─── Resultado ────────────────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "✅  Concluído! Página ID: $pid\n";
echo '🔗  ' . get_permalink( $pid ) . "\n";
echo "════════════════════════════════════════\n";
echo "\n📋  PENDÊNCIAS PARA O PAINEL (inserir manualmente):\n";
echo "   • hero_video (vídeo de fundo do Hero)\n";
echo "   • sobre_video (vídeo manifesto)\n";
echo "   • oque_img_1 / oque_img_2 (bloco O que vai encontrar)\n";
echo "   • trilhas_lista → imagem de cada trilha (8 imagens)\n";
echo "   • pq_diferenciais → ícone de cada diferencial (4 ícones)\n";
echo "   • pqm_items → ícone de cada item (4 ícones)\n";
echo "   • pqm_img_1 / pqm_img_2 (bloco Para quem é)\n";
echo "   • ingr_plans → ícone de cada plano (5 ícones)\n\n";
