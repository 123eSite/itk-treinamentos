# Prompt — Fase 1: HTML do Design System e Mapa do Site

Use o texto abaixo (ou anexe este arquivo junto com `design-tokens.md` e `sitemap.md`) para solicitar à IA a geração do HTML.

---

## Instruções para a IA

Gere um **único arquivo HTML** (ou um HTML principal + CSS inline ou em `<style>`) para o projeto **ITK Treinamentos**. Use como fonte única de verdade os arquivos **design-tokens.md** e **sitemap.md** desta pasta.

### Requisitos gerais

- **Identidade visual do cliente:** aplique em todo o documento a logomarca **positiva** (`assets/img/logo-itk-positivo.png`), as cores, fontes e tamanhos definidos no design-tokens.
- **Visual:** clean e moderno; bastante espaço em branco, hierarquia clara e leitura fácil.
- **Fontes:** Open Sans (texto) e Montserrat (títulos), via Google Fonts.
- **Cores:** paleta do design-tokens (azuis #162947, #022d66, #00214c, #00204B; preto/branco; cinzas; gradiente #022D66 → #00214C).
- **Espaçamentos:** malha de 8px (8, 16, 24, 32, 64, 128) e 100px entre seções (top e bottom), conforme design-tokens.
- O HTML deve ser **semântico**, **acessível** (ARIA quando fizer sentido) e pronto para evoluir para WordPress.

---

### Parte 1 — Cabeçalho e identidade

- No topo da página, um **header** com a logomarca positiva do ITK, alinhada de forma limpa (ex.: à esquerda ou centralizada).
- Título da página: algo como “Design System — ITK Treinamentos”.
- Opcional: um subtítulo breve (ex.: “Identidade visual e estrutura do site”).

---

### Parte 2 — Design system em seções

Exiba o design system de forma **bonita e organizada**, com uma seção visual para cada grupo abaixo. Cada seção deve ter título claro, fundo ou borda sutil e os exemplos visuais descritos.

#### Seção 1 — Imagens / Logomarca

- **Marca principal:** exibir a logo positiva (`assets/img/logo-itk-positivo.png`), com altura controlada (ex.: max-height 60–80px).
- **Favicon:** referência ou miniatura ao `assets/img/favicon.png`.
- **Logos dos cursos:** em grid ou lista de imagens (com placeholders ou caminhos), para: A Força do seu lugar, Leader Training, Acreditando em você, Despertando o poder pessoal, Curso de Reiki online (arquivos em `assets/img/` conforme design-tokens).
- Legendas curtas para cada bloco (ex.: “Marca principal”, “Logos dos cursos”).

#### Seção 2 — Cores

- Mostrar **amostras de cor** (quadrados ou retângulos) para:
  - Azuis: #162947, #022d66, #00214c, #00204B (do mais claro ao mais escuro), com o hex ao lado ou abaixo.
  - Neutros: #000000, #ffffff.
  - Cinzas: as 5 variações (ex.: #f5f5f5, #e8e8e8, #9e9e9e, #616161, #212121).
  - **Gradiente:** uma faixa ou card com o gradiente #022D66 → #00214C.
- Título da seção: “Cores” e, se quiser, subgrupos (Azul, Neutros, Cinza, Gradiente).

#### Seção 3 — Tipografia

- **Títulos:** uma amostra de cada nível (H1 a H6) usando **Montserrat** e os tamanhos do design-tokens (ex.: h1 36px, h2 32px, h3 28px, h4 24px, h5 20px, h6 18px).
- **Corpo:** parágrafo de exemplo com **Open Sans** 16px.
- **Legenda:** um trecho em 14px (Open Sans) com label “Legenda / texto menor”.
- Indicar que as fontes vêm do Google Fonts (link ou menção breve).

#### Seção 4 — Espaçamentos

- Explicar a **malha de 8px**: 8, 16, 24, 32, 64, 128.
- Mostrar visualmente (barras, blocos ou diagrama) cada valor, com o número em px ao lado.
- Destacar o **espaçamento entre seções:** 100px (top e bottom).

---

### Parte 3 — Mapa do site (visual)

- Uma **seção final** dedicada ao **mapa do site**, bem **visual**, para o cliente enxergar todas as **seções principais** do site.
- Use o conteúdo de **sitemap.md** (navegação principal e estrutura hierárquica).
- Formas possíveis (escolha uma ou combine):
  - **Diagrama em árvore** (títulos como “Home”, “O Instituto ITK”, “Cursos e treinamentos”, “Agenda”, “Blog”, “Fale com o ITK”, “Para Você”, “Loja”) com níveis e subníveis (ex.: Cursos → Leader Training; Blog → Categorias).
  - **Cards ou blocos** por grupo (Institucional, Cursos, Agenda, Blog, Contato, Loja), cada um com os links principais e, se couber, sublinks.
  - **Lista hierárquica estilizada** com indentação, ícones ou cores por nível.
- Inclua pelo menos: Home, O Instituto ITK, Cursos e treinamentos (e Leader Training), Agenda, Blog do ITK (e categorias principais), Para Você, Fale com o ITK, Loja.
- O mapa deve ser **legível e bonito** (cores da marca, tipografia do design system, espaçamentos da malha de 8px).

---

### Entrega

- Um arquivo **HTML** autocontido (CSS no próprio arquivo, em `<style>` ou inline).
- Comentários breves no HTML por seção (ex.: `<!-- Seção: Cores -->`).
- No topo do arquivo ou em comentário, um índice das seções: Cabeçalho, Imagens/Logomarca, Cores, Tipografia, Espaçamentos, Mapa do site.

Se preferir separar, pode gerar um `design-system.html` e um `styles.css` na mesma pasta; o importante é que, ao abrir o HTML, a página exiba a identidade visual, o design system em seções e o mapa do site visual.

---

*Prompt para uso com design-tokens.md e sitemap.md (pasta design-system).*
