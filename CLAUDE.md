# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Site institucional da **ITK Treinamentos** — developed in two parallel tracks:
1. **HTML estático** em `html/` (protótipo/validação visual)
2. **Tema WordPress** em `wp/app/public/wp-content/themes/temaitk/` (produção)

The WordPress site runs locally via LocalWP; `wp/app/public/` is the WordPress root.

## Repository Structure

```
html/               # HTML estático (protótipo)
  *.html            # Páginas: index.html (home), leader-training.html
  assets/           # CSS, JS, images, fonts, SCSS
docs/               # DEV_GUIDE_WP.md (guia completo de conversão HTML→WP), prompt.md
wp/
  app/public/       # WordPress root (LocalWP)
    wp-content/themes/
      temaitk/      # Tema ativo do projeto
        assets/     # CSS (css/), JS (js/), images, fonts — espelha html/assets/
        acf-json/   # ACF Local JSON para sincronização
      temareferencia/ # Tema boilerplate de referência (não editar)
```

## WordPress Theme Development

Full workflow documented in `docs/DEV_GUIDE_WP.md`. Key rules:

### Estrutura de arquivos do tema
`style.css` (só cabeçalho) · `functions.php` · `header.php` · `footer.php` · `front-page.php` · `index.php` · `page.php` + arquivos por slug

### Regra fundamental
**Nunca alterar a estrutura HTML aprovada.** Não adicionar tags (`<main>`, wrappers extras) que não existam no HTML original.

### URLs no tema
- Em templates (`.php`): `<?php bloginfo( 'template_url' ); ?>/caminho/arquivo`
- Em `functions.php` (enqueue): `get_bloginfo( 'template_url' ) . '/caminho/arquivo'`
- Nunca colocar `<link>` ou `<script>` direto em `header.php`/`footer.php` — sempre via enqueue.

### Páginas internas (`page.php`)
Mapeamento slug → arquivo PHP no tema. Novo par no array `$map` + novo arquivo fatiado para cada nova página.

### ACF — Padrões obrigatórios

- **Conteúdo repetitivo**: sempre ACF Repeater com `have_rows()` / `the_row()` / `get_sub_field()`. **Nunca** usar `get_field()` + `foreach` no array.
- **Blocos compartilhados** (usados em >1 página): grupo ACF separado + `get_template_part()`.
- **Sem fallback** no template PHP — conteúdo vem exclusivamente do ACF.
- **Campos obrigatórios** no JSON: `"required": 1`; repeaters com `"min": 1` quando a seção não faz sentido vazia.
- **Alt em imagens dinâmicas**: tentar `$img['alt']`; fallback para `wp_strip_all_tags( $titulo_relacionado )`.
- **ACF JSON manual**: arquivo começa com `{ "key": "group_..." }` (objeto, não array). Atualizar `"modified"` com timestamp UNIX atual para habilitar sync.
- Nomes de campos em português do Brasil.

### Formulários (Contact Form 7)
Converter HTML de formulários para shortcode CF7. Preservar classes Bootstrap (`mb-3`, `form-label`, `form-control`) e todas as classes do botão original.

## Fases do Projeto

1. **Fase 1** – Setup: `style.css`, `functions.php`, `header.php`, `footer.php`, `front-page.php`
2. **Fase 2** – Páginas e templates adicionais
3. **Fase 3** – Integração ACF (campos + JSON `acf-json/`)
4. **Fase 4** – Formulários CF7 e ajustes finais
