# Guia de Desenvolvimento de Temas WordPress – Padrão 123eSite

Este guia documenta um **padrão genérico** para converter HTML estático em tema WordPress.
Ele deve ser reaproveitado em qualquer projeto similar, mudando apenas nomes e layouts.

## 0. Parâmetros de projeto (preenchimento inicial)

Antes de começar a conversão em qualquer projeto, preencha estes campos para ter um “cartão de configuração” padrão:

- **Nome da pasta do tema de referência**: `temareferencia`
- **Nome da pasta do novo tema**: `temaitk`
- **Nome do tema (Theme Name)**: `ITK Treinamentos`
- **Autor (Author)**: `Victor / Energia das Marcas`
- **Text Domain (slug do tema)**: `temaitk`
- **URL do site final (Theme URI)**: `https://itktreinamentos.com.br/`
- **Versão inicial do tema**: `1.0.0`

Esses dados devem ser usados:

- No cabeçalho do `style.css` (Theme Name, Author, Version, Text Domain, Theme URI).
- Em qualquer lugar onde o guia usar `slug-do-tema` ou `slug_tema_*` (substituir pelo slug real do projeto).

> Regra: sempre copiar este bloco e atualizá-lo no início de cada novo projeto, para evitar inconsistências de nomes entre pasta do tema, text domain e funções.

## Regra fundamental: estrutura HTML

**Não alterar em nada a estrutura do HTML já validada e aprovada.**
Não adicionar tags (ex.: `<main>`, wrappers extras) que não existam no HTML original, a não ser que seja estritamente necessário para evitar erros e o solicitante autorize. O fatiamento deve preservar exatamente as mesmas tags e hierarquia do layout aprovado.

## 1. Estrutura mínima do tema

Todo novo tema deve começar, no mínimo, com:

- `style.css` – apenas o cabeçalho do tema.
- `functions.php` – configuração básica e enqueue de assets.
- `header.php` – `<html>`, `<head>`, abertura de `<body>` e cabeçalho visual.
- `footer.php` – rodapé visual, fechamento de `wrapper`, `wp_footer()`, `</body></html>`.
- `front-page.php` – layout da home (quando o site é tipo landing institucional).
- `index.php` – fallback genérico da hierarquia do WordPress.

### 1.1. `style.css` (cabeçalho do tema)

Sempre usar um cabeçalho mínimo como:

```css
/**
 * Theme Name:  Nome do Tema
 * Theme URI:   https://exemplo.com/
 * Description: Descrição curta do tema.
 * Author:      Nome do autor / agência
 * Version:     1.0.0
 * Text Domain: slug-do-tema
 */
```

> Regra: os estilos reais ficam em arquivos próprios (ex: `assets/css/style.css`), não no `style.css` do tema.

## 2. Enfileiramento de CSS e JS (`functions.php`)

### 2.1. Suportes básicos e menus

Sempre declarar ao menos:

```php
add_theme_support( 'title-tag' );

register_nav_menus(
	array(
		'menu-principal' => __( 'Menu principal', 'slug-do-tema' ),
	)
);
```

### 2.2. Padrão de enqueue

1. Replicar os `<link rel="stylesheet">` e `<script src>` do HTML estático.
2. Converter para `wp_enqueue_style()` e `wp_enqueue_script()`.
3. Usar `get_bloginfo( 'template_url' )` para apontar para a pasta do tema (no enqueue, onde é preciso retornar o valor).

Exemplo genérico:

```php
function slug_tema_enqueue_assets() {
	$template_uri = get_bloginfo( 'template_url' );

	// Exemplo de fonte externa
	wp_enqueue_style(
		'slug-tema-google-fonts',
		'https://fonts.googleapis.com/css2?family=NomeDaFonte:wght@400;700&display=swap',
		array(),
		null
	);

	// CSS principais (ordem igual ao HTML estático)
	wp_enqueue_style(
		'slug-tema-libraries',
		$template_uri . '/assets/css/libraries.css',
		array(),
		null
	);

	wp_enqueue_style(
		'slug-tema-icons',
		$template_uri . '/assets/css/icons.css',
		array( 'slug-tema-libraries' ),
		null
	);

	wp_enqueue_style(
		'slug-tema-style',
		$template_uri . '/assets/css/style.css',
		array( 'slug-tema-icons' ),
		'1.0.0'
	);

	// JS principais (ordem igual ao HTML estático)
	wp_enqueue_script(
		'slug-tema-libraries',
		$template_uri . '/assets/js/libraries.js',
		array(),
		null,
		true
	);

	wp_enqueue_script(
		'slug-tema-main',
		$template_uri . '/assets/js/main.js',
		array( 'slug-tema-libraries' ),
		null,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'slug_tema_enqueue_assets' );
```

> **Padrão de URL do tema:** nos templates (header, footer, front-page, etc.) usar `<?php bloginfo( 'template_url' ); ?>/caminho/arquivo` para exibir a URL. No `functions.php`, ao montar a URL para `wp_enqueue_style` / `wp_enqueue_script`, usar `get_bloginfo( 'template_url' )` (retorna o valor para concatenar).
>
> Regra: manter a mesma **ordem de carregamento** do HTML original para evitar quebrar sliders, carrosséis, etc.

## 3. Fatiamento de HTML em `header.php` e `footer.php`

### 3.1. `header.php`

Responsável por:

- Abertura de `<!DOCTYPE html>`, `<html <?php language_attributes(); ?>>`, `<head>` e metas básicas.
- Inclusão de favicon.
- Chamada a `wp_head();` antes de fechar o `<head>`.
- Abertura do `<body <?php body_class(); ?>>`.
- Abertura de `div.wrapper` (quando o layout usar um wrapper global).
- HTML do cabeçalho (logo, navegação, botões, etc.).

Padrão genérico:

```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="icon" href="<?php bloginfo( 'template_url' ); ?>/assets/images/favicon/favicon.png">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="wrapper">
		<!-- HTML do header visual vai aqui -->
```

> Regra: **não** colocar `<link rel="stylesheet">` nem `<script>` direto no `header.php`; tudo deve vir via enqueue no `functions.php`.

### 3.2. `footer.php`

Responsável por:

- HTML do rodapé (textos, links, ícones).
- Fechamento de `wrapper`.
- Chamada a `wp_footer();` antes de fechar `</body>`.
- Fechamento de `</body></html>`.

Padrão genérico:

```php
		<footer class="footer" id="contato">
			<!-- HTML do footer visual -->
		</footer>
	</div><!-- /.wrapper -->

	<?php wp_footer(); ?>
</body>
</html>
```

> Regra: scripts específicos (por ex. plugins de acessibilidade ou trackers) devem ser enfileirados via `wp_enqueue_script()` sempre que possível, e não colados diretamente no `footer.php`.

## 4. `front-page.php` (Home)

Quando o site é uma landing page institucional, a home deve ser tratada em `front-page.php`:

1. Copiar o HTML da home estática (entre o fechamento do `</header>` e a abertura do `<footer>`).
2. Remover do arquivo original:
   - `<html>`, `<head>`, `<body>`, `<footer>`, `</html>`.
   - `<link>` e `<script>` (já estarão no enqueue).
3. Adaptar caminhos de imagens e assets para `<?php bloginfo( 'template_url' ); ?>/caminho/arquivo` (padrão do projeto).
4. **Não** adicionar tags que não existam no HTML aprovado (ex.: não envolver o conteúdo em `<main>` se o original não tiver).

Padrão mínimo:

```php
<?php
get_header();
?>

	<!-- Blocos da home (slider, seções, etc.) – mesma hierarquia do HTML original -->
	<section class="slider">...</section>
	<section class="banner-layout8">...</section>
	...

<?php
get_footer();
```

> Regra: na Fase 1 o conteúdo pode permanecer estático; na Fase 3, cada bloco deve ser substituído por campos ACF, mantendo a mesma estrutura visual. Nunca alterar a estrutura de tags do HTML aprovado.

## 5. `index.php` (fallback)

Mesmo em projetos que usam `front-page.php`, é obrigatório ter um `index.php` básico para respeitar a hierarquia do WordPress. O conteúdo fallback deve usar apenas containers que já existam no layout (ex.: `div.container`), sem introduzir tags como `<main>` se o HTML aprovado não as tiver.

Padrão genérico:

```php
<?php
get_header();
?>

	<div class="container py-5 default-index">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-5' ); ?>>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<section class="no-results not-found">
				<h1 class="entry-title">Nada encontrado</h1>
				<p>Não há conteúdo publicado ainda. Crie uma página e defina-a como página inicial em Configurações &gt; Leitura.</p>
			</section>
		<?php endif; ?>
	</div>

<?php
get_footer();
```

## 6. Páginas internas: `page.php` + arquivo por slug

Para páginas criadas no admin (ex.: Quem Somos, O que fazemos, Cases), usar um único `page.php` que carrega o conteúdo conforme o **slug** da página:

1. Em `page.php`: obter o slug da página atual; mapear slug → nome do arquivo PHP (ex.: `quem-somos` → `quem-somos.php`).
2. Se existir o arquivo correspondente no tema, dar `include` nesse arquivo.
3. Caso contrário, exibir o conteúdo do editor (`the_content()`) dentro de um container padrão.

O arquivo de conteúdo (ex.: `altavia.php`) contém **apenas** o HTML fatiado da página estática (entre o fim do header e o início do footer), com caminhos de assets em `<?php bloginfo( 'template_url' ); ?>/...`. Não chama `get_header()` nem `get_footer()` — isso fica em `page.php`.

Exemplo de mapeamento em `page.php`:

```php
$map = array(
	'quem-somos'     => 'quem-somos',
	'o-que-fazemos' => 'o-que-fazemos',
	'cases'         => 'cases',
);
$template_name = isset( $map[ $slug ] ) ? $map[ $slug ] : $slug;
$template_file = get_template_directory() . '/' . $template_name . '.php';
if ( file_exists( $template_file ) ) {
	include $template_file;
} else {
	// Fallback: the_content() em container padrão
}
```

Regra: o **slug** da página no WordPress (URL amigável) deve coincidir com a chave do array; o **valor** é o nome do arquivo PHP (sem `.php`) no tema. Novas páginas = novo par no array + novo arquivo fatiado.

### 6.1. Páginas filhas (layout único para filhos de uma página)

Quando uma página deve ter **filhas** que compartilham o mesmo layout (ex.: Cases → cada case é uma página filha), usar a seguinte lógica em `page.php`:

1. **Antes** do mapeamento por slug, verificar se a página atual tem **pai** (`wp_get_post_parent_id()`).
2. Se o **slug do pai** for o da página “lista” (ex.: `cases`), incluir o template de layout interno (ex.: `cases-interna.php`) e encerrar (chamar `get_footer(); return;`).
3. O template interno (ex.: `cases-interna.php`) usa título e breadcrumb dinâmicos: `the_title()` para o H1; breadcrumb Home > [pai] > [título atual].

Assim, qualquer página criada no WP como **filha de Cases** usará automaticamente o layout `cases-interna.php`, sem precisar de novo par no mapeamento.

---

## 7. ACF (Advanced Custom Fields) – Padrões obrigatórios

### 7.1. Blocos compartilhados = grupo ACF separado

Quando um bloco de conteúdo é **reutilizado em várias páginas** (ex.: page title com título + imagem de fundo), criar um **grupo ACF próprio** para esse bloco, com localização ampla (ex.: Post Type = Página). Não misturar com os campos da página específica.

- **Exemplo:** Bloco “Page Title” usado em A AltaVia, Cases, O que fazemos, Cases internas → grupo `Bloco Page Title (compartilhado)` com campos `page_title_titulo`, `page_title_imagem`, localização “Página”.
- O template usa um **template part** (ex.: `template-parts/page-title.php`) que lê esses campos e monta o HTML. Todas as páginas que exibem o bloco chamam `get_template_part( 'template-parts/page-title' );`.

### 7.2. Conteúdo repetitivo = ACF Repeater + `have_rows()` / `the_row()` / `get_sub_field()`

Todo conteúdo **repetitivo** (lista de logos, depoimentos, itens de ecossistema, parágrafos com ícone, etc.) deve ser modelado como **ACF Repeater**. No PHP, **sempre** usar a API de repeaters do ACF:

- `have_rows( 'nome_do_repeater' )` para verificar se há itens.
- `while ( have_rows( 'nome_do_repeater' ) ) { the_row(); ... }` para iterar.
- `get_sub_field( 'nome_do_subcampo' )` para obter o valor de cada linha.

**Não** usar `get_field( 'repeater' )` e depois `foreach` no array retornado. O padrão do projeto é `have_rows()` + `the_row()` + `get_sub_field()`.

### 7.3. Clientes, depoimentos, ecossistema, texto com ícones

- **Clientes (logos):** Repeater com subcampo URL (ou imagem, conforme definido). No template: `have_rows( 'clientes_logos' )` e, em cada linha, `get_sub_field( 'url' )` (ou o nome do subcampo).
- **Depoimentos:** Repeater (número, nome, cargo, texto). Template: `have_rows( 'depoimentos_lista' )` e `get_sub_field( 'numero' )`, `get_sub_field( 'nome' )`, etc.
- **Ecossistema (itens com ícone, título, descrição):** Repeater. Template: `have_rows( 'ecossistema_itens' )` e `get_sub_field( 'icone' )`, `get_sub_field( 'titulo' )`, `get_sub_field( 'descricao' )`.
- **Texto com ícones (ex.: parágrafos do fundador):** Repeater (texto obrigatório; ícone/URL opcional se não exibido). Template: `have_rows( 'fundador_paragrafos' )` e `get_sub_field( 'texto' )`.

### 7.4. Sem fallbacks no template

- **Não** implementar conteúdo padrão (fallback) no PHP quando o campo ACF estiver vazio.
- Todo conteúdo editável vem **exclusivamente** do ACF. Se o campo for obrigatório no JSON, o preenchimento é garantido no admin; se estiver vazio, a seção não é exibida (ou fica vazia, conforme a regra de negócio).
- Exibir uma seção apenas quando os dados necessários existirem (ex.: `if ( get_field( 'x' ) && have_rows( 'y' ) ) : … endif;`).

### 7.5. Campos obrigatórios no JSON ACF

- No JSON do grupo ACF, definir **todos os campos como obrigatórios** (`"required": 1`), exceto os que forem explicitamente opcionais (ex.: URL do botão “deixar vazio para ocultar”).
- Para **Repeaters**, definir `"min": 1` (pelo menos um item) quando a seção não fizer sentido vazia.
- Subcampos dos repeaters também devem ser obrigatórios quando corresponderem a conteúdo que sempre deve aparecer (título, texto, etc.).

### 7.6. Imagem do Page Title (e outras imagens compartilhadas)

- Blocos compartilhados que tenham **imagem** (ex.: fundo do page title) devem ter um campo do tipo **Image** no grupo ACF correspondente.
- No template part, usar o helper do tema para tamanho (ex.: `temaaltavia_image_url( $imagem, 'altavia_page_title' )`) e exibir a versão redimensionada; sem fallback para imagem estática do tema.

### 7.7. Textos Alternativos (alt) em Imagens Dinâmicas

- A acessibilidade e o SEO são critérios fundamentais. Para toda **tag `<img>` cuja origem seja o painel (campos ACF, Thumbnail de Post, Options, etc)**, o atributo `alt` deve tentar primeiro resgatar o texto alternativo configurado nativamente na Biblioteca de Mídia do WP (como `$imagem['alt']`).
- Caso a imagem não possua texto alternativo cadastrado, **deve-se prover um fallback (texto lógico padrão)**. Geralmente pode ser obtido removendo tags de algum campo de título relacionado da seção (`wp_strip_all_tags( $titulo_da_secao )`).
- Exemplo prático de output seguro: `alt="<?php echo esc_attr( $img['alt'] ? $img['alt'] : wp_strip_all_tags( $titulo_relacionado ) ); ?>">`

### 7.8. Criação Manual de ACF JSON (Local JSON)

- Ao criar ou manipular manualmente arquivos `.json` diretamente na pasta `acf-json/`, é obrigatório seguir as regras estruturais que o plugin exige para habilitar a **Sincronização (Sync Available)**:
  1. **Raiz do Objeto**: O conteúdo do arquivo deve iniciar com chaves representando um único objeto JSON (`{ "key": "group_..." }`). Nunca o envolva com colchetes de array (`[ { ... } ]`), caso contrário o ACF o ignorará por ser estruturalmente inválido.
  2. **Timestamp (modified)**: A chave `"modified"` no JSON controla a sincronização. O ACF apenas libera a importação/sincronização no painel se este timestamp UNIX for mais recente (maior) do que o registrado pelo banco de dados. Indispensável colocar um timestamp válido após terminar sua edição manual.

### 7.9. Resumo para futuros projetos

1. **Bloco usado em mais de uma página** → grupo ACF separado + template part.
2. **Listas / itens repetidos** → ACF Repeater + no PHP sempre `have_rows()` / `the_row()` / `get_sub_field()`.
3. **Nada de fallback** no template; conteúdo só do ACF.
4. **Campos obrigatórios** no JSON (e `min: 1` em repeaters quando aplicável).
5. **Imagens editáveis** → campo Image no ACF + tamanhos registrados no tema + helper para URL do tamanho.

---

> Próximas fases neste guia:
> - **Fase 4** – Conversão de formulários HTML para shortcodes do Contact Form 7.

## 8. Formulários (Contact Form 7)
Quando o layout contiver formulários, siga este padrão:

1. **Shortcode no PHP:** Inclua o shortcode padrão do plugin dentro da div correspondente no seu template (ex: `front-page.php`).
```php
<div class="wrapper-form">
    <?php echo do_shortcode('[contact-form-7 id="meu_form_id" title="Formulário"]'); ?>
</div>
```
2. **Tags de Formulário:** Sempre mantenha o layout estrutural do HTML aprovado (ex: uso de Bootstrap `.mb-3`, `.form-label`, `.form-control`).
3. **Exemplo de syntax CF7 mantendo classes originais:**
```html
<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    [text* your-name id:nome class:form-control placeholder "Seu nome"]
</div>
```
4. **Botão de submit:** Preserve TODAS as classes do botão original.
`[submit class:button class:green class:w-100 class:border-0 "Enviar"]`
