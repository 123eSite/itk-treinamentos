# Itk Treinamentos - Documentação do Projeto Front-end

> **Última atualização:** 08/02/2026
> **Status:** Em desenvolvimento

---

## Visão Geral

Site institucional da **Itk Treinamentos**

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
│   ├── gsap-public/           # GSAP + ScrollSmoother + ScrollTrigger
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
| GSAP | 3.x | Animações avançadas |
| ScrollSmoother | GSAP Plugin | Scroll suave |
| ScrollTrigger | GSAP Plugin | Animações baseadas em scroll |
| CountUp.js | - | Animação de números |
| jQuery | Min | Manipulação DOM (legado) |
| Font Awesome | Kit | Ícones |
| Google Fonts | Sora | Fonte principal |

---

## Variáveis CSS

```css
:root {

}
```

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

```html
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casas André Luiz | Centro Espírita Nosso Lar</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header fixo (clonado via JS) -->
    <header class="fix">
        <div class="container">
            <nav class="navbar navbar-expand-lg"></nav>
        </div>
    </header>

    <!-- Wrapper para smooth scroll -->
    <div id="smooth-wrapper">
        <div id="smooth-content">

            <!-- Header principal -->
            <header>
                <div class="container">
                    <nav class="navbar navbar-expand-lg">
                        <!-- Logo + Menu + Botão DOE AGORA -->
                    </nav>
                </div>
            </header>

            <main>
                <!-- Seções de conteúdo -->
            </main>

            <footer>
                <!-- Grid 8 colunas com menus -->
                <!-- Bottom com logo + info + certificações -->
                <!-- Copy com logo Midiaria -->
            </footer>

        </div>
    </div>

    <!-- Scripts (ordem importante) -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="vendor/icons/icons.css">
    <script src="https://kit.fontawesome.com/fa64eccb28.js" crossorigin="anonymous"></script>
    <script src="vendor/bootstrap/js/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="vendor/swiper/swiper-bundle.min.css" />
    <script src="vendor/swiper/swiper-bundle.min.js"></script>
    <script src="vendor/counter/index.js"></script>
    <script src="vendor/gsap-public/minified/gsap.min.js"></script>
    <script src="vendor/gsap-public/minified/ScrollSmoother.min.js"></script>
    <script src="vendor/gsap-public/minified/ScrollTrigger.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
```

---

## Componentes Reutilizáveis

**Características:**
- Imagem com `.bg` usando `position: absolute` (vai até a borda)
- Texto sempre dentro de `.container` (mantém alinhamento central)
- Layout alternado usando `.reverse` (muda imagem de lado)
- **CSS aninhado**: todos os estilos ficam dentro de precisam sempre seguir a regra de aninhamento ex.: header .top, header .bottom, header .menu.

---

## Classes Utilitárias

| Classe | CSS |
|--------|-----|
| `.padding-tb` | padding: 100px 0 |
| `.padding-t` | padding-top: 100px |
| `.padding-b` | padding-bottom: 100px |
| `.title` |
| `.subtitle` |
| `.button` |
| `.button.blue` |

---

## Status das Páginas

| Arquivo | Status | Observações |
|---------|--------|-------------|
| `index.html` | 🔄 Em progresso | Home com todos os componentes |

---

## JavaScript (script.js)

O arquivo usa um objeto `app` com métodos:

```javascript
var app = {
    menuFix: () => {},       // Clona menu para header fixo
    swiper: () => {},        // Inicializa swipers via data-attributes
    counterNumbers: () => {},// Animação de contadores
    init: () => {}           // Inicialização no DOMContentLoaded
}
app.init()
```

---

## Breakpoints Responsivos

```css

```

---

## Tarefas Pendentes



---

## Notas para Desenvolvimento

1. **Imagens:** Preferir formato `.webp` para fotos, `.svg` para ícones/logos
2. **Botões:** Usar classe `.button`, variante `.button.blue` para fundo azul
3. **Espaçamento:** Usar `.padding-tb` entre seções
4. **Títulos:** Sempre usar `.subtitle` + `.title` em sequência
5. **Grid:** Usar Bootstrap `.row` + `.col-lg-*` para layouts
6. **Swiper:** Configurar via data-attributes, não editar script.js
7. **CSS Aninhado:** Sempre aninhar estilos dentro da seção pai para evitar conflitos (ex: `.cat-program .category-item` em vez de `.category-item`)
8. **Textos em container:** Manter textos dentro de `.container` para alinhamento central consistente

---

*Documento gerado para auxiliar no desenvolvimento contínuo do projeto.*
