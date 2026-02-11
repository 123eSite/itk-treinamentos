---
description: Design system e contexto do projeto Itk Treinamentos (estrutura, stack, padrões, componentes)
alwaysApply: true
---

# Design system – Itk Treinamentos

**Fonte canônica:** `CONTEXT.md` na raiz do projeto. Ao atualizar o design system, atualize esse arquivo e, se necessário, esta regra para manter o contexto do Cursor alinhado.

---

## Visão Geral

Site institucional da **ITK Treinamentos**.

---

## Estrutura de Arquivos

```
html/
├── css/
│   └── style.css              # CSS principal customizado
├── js/
│   └── script.js              # JavaScript principal (app object)
├── img/                       # Imagens do projeto (.webp, .svg, .jpg, .png)
├── vendor/                    # Bibliotecas de terceiros
│   ├── bootstrap/             # Bootstrap 5
│   ├── swiper/                # Swiper.js (carrosséis)
│   ├── jquery/                # jQuery
│   ├── counter/               # CountUp.js
│   ├── fancybox/              # Lightbox para imagens
│   └── icons/                 # Ícones customizados
└── *.html                     # Páginas HTML
```

---

## Stack Tecnológica

| Tecnologia | Versão | Uso |
|------------|--------|-----|
| Bootstrap | 5.x | Grid system, componentes base |
| Swiper.js | Bundle | Carrosséis e sliders |
| CountUp.js | - | Animação de números |
| jQuery | Min | Manipulação DOM (legado) |
| Font Awesome | Kit | Ícones |
| Google Fonts | Montserrat | Fonte principal |

---

## Padrões de Nomenclatura

### Classes CSS

| Tipo | Padrão | Exemplos |
|------|--------|----------|
| Seções | kebab-case descritivo | `banner-top`, `text-image`, `donate-types` |
| Modificadores | classe direta | `.yellow`, `.blue`, `.bg-gray` |
| Utilitárias | prefixo descritivo | `.padding-tb`, `.img-radius`, `.img-radius-12` |
| Bootstrap | classes nativas | `.container`, `.row`, `.col-lg-*` |

### Estrutura HTML

- Indentação: **4 espaços**
- Atributos: aspas duplas
- Imagens: sempre com `alt=""`
- Classes: ordem - componente, modificador, utilitária, bootstrap

---

## Estrutura Base HTML

- Header fixo (clonado via JS) em `header.fix`
- Conteúdo dentro de `#smooth-wrapper` > `#smooth-content`: header principal, `main`, `footer`
- Scripts na ordem: jQuery, icons.css, Font Awesome, Popper, Bootstrap, Swiper, counter, script.js

---

## Componentes Reutilizáveis


---

## Breakpoints



## CSS responsivo

- **Posição:** Todos os `@media` ficam ao **final** de `style.css`, na seção `/* ========== Responsivo ========== */`.
- Não espalhar blocos responsivos no meio das seções; estilos base primeiro, responsivo concentrado no fim.

---

## JavaScript

Objeto global `app` com `app.init()` chamado no DOMContentLoaded.

---

## Notas para Desenvolvimento

1. Imagens: `.webp` para fotos, `.svg` para ícones/logos
2. Botões: `.button`, variante `.button.blue`
3. Espaçamento: `.padding-tb` entre seções
4. Títulos: `.subtitle` + `.title` em sequência; H2 com `.title`
5. Grid: Bootstrap `.row` + `.col-lg-*`
6. Swiper: apenas data-attributes
7. **CSS aninhado:** Sempre aninhar dentro da seção pai (ex: `header .menu`). Classes genéricas soltas proibidas, exceto componentes globais como `.button`
8. Textos dentro de `.container`
9. Evitar estilos inline; usar CSS
10. CSS responsivo: todos os `@media` ao final de `style.css`
