# Documentação — Scripts de Importação de Conteúdo WordPress via WP-CLI

> **Objetivo:** Registrar o padrão adotado para migrar conteúdo estático (HTML, Word, planilhas, etc.)
> para o WordPress populando campos ACF via WP-CLI, sem tocar no painel de administração.
> Seguir este documento garante scripts consistentes, idempotentes e com log legível.

---

## Índice

1. [Visão Geral da Abordagem](#1-visão-geral-da-abordagem)
2. [Pré-requisitos](#2-pré-requisitos)
3. [Como Executar um Script](#3-como-executar-um-script)
4. [Estrutura Padrão de um Script](#4-estrutura-padrão-de-um-script)
5. [Helper de Importação de Imagem](#5-helper-de-importação-de-imagem)
6. [Tipos de Campo ACF e Como Populá-los](#6-tipos-de-campo-acf-e-como-populá-los)
7. [Padrão de Log (Output)](#7-padrão-de-log-output)
8. [Convenções de Nomenclatura](#8-convenções-de-nomenclatura)
9. [Template Completo de Script](#9-template-completo-de-script)
10. [Projeto de Referência: Casas André Luiz](#10-projeto-de-referência-casas-andré-luiz)
11. [Adaptando para Outros Projetos](#11-adaptando-para-outros-projetos)
12. [Erros Comuns e Soluções](#12-erros-comuns-e-soluções)

---

## 1. Visão Geral da Abordagem

Em vez de inserir conteúdo manualmente pelo painel do WordPress, usamos **scripts PHP executados via WP-CLI** (`wp eval-file`). Isso permite:

- Importar texto, HTML rico, imagens e arquivos de forma programática
- Repetir a importação sem duplicar dados (scripts **idempotentes**)
- Ter log completo no terminal de tudo que foi feito
- Versionar os scripts junto com o projeto no Git
- Reexecutar a qualquer momento (ex: após resetar o banco em ambiente local)

### Fluxo resumido

```
Conteúdo fonte          Script PHP              WordPress
(HTML / Word / JSON) ──► _scripts/import-*.php ──► update_field() / wp_insert_attachment()
Imagens em pasta     ──► _import_theme_image()  ──► Media Library + thumbs gerados
```

---

## 2. Pré-requisitos

| Requisito | Detalhe |
|---|---|
| **WP-CLI** instalado | Disponível no shell do LocalWP ou no servidor |
| **ACF Pro** ativo | Necessário para `update_field()` e `get_field()` |
| **Páginas já criadas no WP** | Os scripts localizam páginas existentes — não criam novas |
| **Field groups ACF configurados** | Os campos devem existir antes de rodar o script |
| **Imagens na pasta correta** | Por padrão: `/wp-content/themes/{tema}/img/` |

> **Importante:** Os scripts **nunca criam páginas**. Eles localizam a página pelo slug
> (`get_page_by_path()`), definem o template e populam os campos ACF.
> Crie todas as páginas no WP antes de rodar os scripts.

---

## 3. Como Executar um Script

### No shell do LocalWP (Windows)

```bash
wp eval-file "C:\Caminho\Para\_scripts\import-nome-pagina.php" --path="C:\Caminho\Para\wp\app\public"
```

### No terminal do servidor (Linux/Mac)

```bash
wp eval-file /var/www/html/_scripts/import-nome-pagina.php --path=/var/www/html
```

### Dica: executar vários em sequência

```bash
wp eval-file "_scripts/import-home.php" --path="..." && \
wp eval-file "_scripts/import-sobre.php" --path="..." && \
wp eval-file "_scripts/import-servicos.php" --path="..."
```

---

## 4. Estrutura Padrão de um Script

Todo script segue **exatamente esta ordem de seções**:

```
1. Docblock com nome da página e comando de execução
2. Helper _import_theme_image() (se o script usa imagens)
3. Cabeçalho de log (═══ IMPORT: Nome da Página ═══)
4. Localizar a página por slug (get_page_by_path)
5. Definir o template (update_post_meta _wp_page_template)
6. Seções de conteúdo — uma por aba do ACF, nesta ordem:
   a. Card da Especialidade (se for subpágina de especialidade)
   b. Banner
   c. Sobre / Intro
   d. Demais seções (cards, listas, galeria, etc.)
7. Rodapé de log com URL da página e pendências (⚠)
```

### Regras obrigatórias

- **Um script por página** — nunca misturar duas páginas no mesmo arquivo
- **Nome do arquivo** = `import-{slug-da-pagina}.php`
- **Idempotência** — rodar duas vezes não duplica dados
  - Imagens: verificam se já existem pelo slug antes de importar
  - Campos ACF: `update_field()` substitui o valor anterior
- **Avisos** (`⚠`) para todo campo que ficou em branco ou com pendência

---

## 5. Helper de Importação de Imagem

Incluir no topo de todo script que usa imagens. A função é **sempre a mesma** — copie e cole sem alteração.

```php
function _import_theme_image( string $filename, string $title ): int {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $src = get_template_directory() . '/img/' . $filename;
    if ( ! file_exists( $src ) ) { echo "  ⚠  Não encontrado: $filename\n"; return 0; }

    $slug     = sanitize_title( pathinfo( $filename, PATHINFO_FILENAME ) );
    $existing = get_posts( [ 'post_type' => 'attachment', 'post_status' => 'any', 'name' => $slug, 'posts_per_page' => 1 ] );
    if ( $existing ) { echo "  ↩  Já importado: $filename (ID: {$existing[0]->ID})\n"; return (int) $existing[0]->ID; }

    $upload = wp_upload_dir();
    $dest   = trailingslashit( $upload['path'] ) . $filename;
    if ( ! copy( $src, $dest ) ) { echo "  ✗  Erro ao copiar: $filename\n"; return 0; }

    $att_id = wp_insert_attachment( [ 'post_mime_type' => wp_check_filetype( $filename )['type'], 'post_title' => $title, 'post_name' => $slug, 'post_status' => 'inherit' ], $dest );
    if ( is_wp_error( $att_id ) ) { echo "  ✗  {$att_id->get_error_message()}\n"; return 0; }

    wp_update_attachment_metadata( $att_id, wp_generate_attachment_metadata( $att_id, $dest ) );
    echo "  ✓  Importado: $filename (ID: $att_id)\n";
    return (int) $att_id;
}
```

### O que ela faz

| Passo | Função WordPress |
|---|---|
| Verifica se o arquivo existe na pasta do tema | `file_exists()` |
| Verifica se já foi importada (evita duplicata) | `get_posts()` por slug |
| Copia o arquivo para `wp-content/uploads/` | `copy()` |
| Cria o post de attachment no banco | `wp_insert_attachment()` |
| Gera todos os tamanhos registrados em `functions.php` | `wp_generate_attachment_metadata()` |
| Salva os metadados (dimensões, tamanhos gerados) | `wp_update_attachment_metadata()` |

### Retorno

- `int` com o **ID do attachment** (usar direto no `update_field()`)
- `0` em caso de erro (sempre checar antes de salvar no campo)

### Variante para imagens fora do tema

Quando as imagens estão em outra pasta (ex: projetos com Word + pasta de imagens):

```php
function _import_image_from_path( string $filepath, string $title ): int {
    // ... mesmas requires ...
    $src = $filepath; // caminho absoluto completo
    // ... resto idêntico ao helper padrão ...
}

// Uso:
$id = _import_image_from_path( 'C:/projetos/cliente/imagens/banner.webp', 'Banner' );
```

---

## 6. Tipos de Campo ACF e Como Populá-los

### Text / Textarea

```php
update_field( 'nome_do_campo', 'Valor simples', $pid );
```

### WYSIWYG (HTML rico)

```php
update_field( 'nome_do_campo',
    '<p>Primeiro parágrafo.</p>'
    . '<p>Segundo parágrafo com <strong>negrito</strong>.</p>',
    $pid
);
```

> Sempre usar concatenação de strings para manter o código legível.
> Nunca usar heredoc em scripts WP-CLI (pode causar problemas de parse).

### Image (retorna ID)

```php
$img_id = _import_theme_image( 'arquivo.webp', 'Título da Imagem' );
if ( $img_id ) {
    update_field( 'nome_do_campo_imagem', $img_id, $pid );
}
```

### Gallery (array de IDs)

```php
$ids = [];
foreach ( [ ['foto1.webp', 'Foto 1'], ['foto2.webp', 'Foto 2'] ] as [ $file, $title ] ) {
    $id = _import_theme_image( $file, $title );
    if ( $id ) $ids[] = $id;
}
if ( $ids ) {
    update_field( 'nome_da_galeria', $ids, $pid );
}
```

### File (PDF, etc.)

```php
// Arquivos que não existem localmente — cria a estrutura sem arquivo vinculado
update_field( 'nome_do_campo_arquivo', '', $pid );
// ⚠ Enviar o arquivo real pelo painel depois
```

### Repeater (sem sub-repeater)

```php
update_field( 'nome_do_repeater', [
    [
        'sub_campo_1' => 'Valor A',
        'sub_campo_2' => '<p>Conteúdo HTML</p>',
    ],
    [
        'sub_campo_1' => 'Valor B',
        'sub_campo_2' => '<p>Outro conteúdo</p>',
    ],
], $pid );
```

### Repeater aninhado (repeater dentro de repeater)

```php
update_field( 'repeater_pai', [
    [
        'campo_simples' => 'Categoria A',
        'repeater_filho' => [
            [ 'nome' => 'Item 1', 'arquivo' => '' ],
            [ 'nome' => 'Item 2', 'arquivo' => '' ],
        ],
    ],
], $pid );
```

### Select

```php
// Passar o value (não o label) conforme definido no ACF
update_field( 'campo_select', 'blue', $pid );   // ou 'yellow', 'gray', etc.
```

### True/False

```php
update_field( 'campo_boolean', true, $pid );
update_field( 'campo_boolean', false, $pid );
```

### Link

```php
update_field( 'campo_link', [
    'url'    => 'https://exemplo.com',
    'title'  => 'Texto do link',
    'target' => '_blank',  // ou '' para mesma aba
], $pid );
```

### Post Object / Relationship

```php
// Passar o ID do post relacionado
update_field( 'campo_post', 42, $pid );
// Para múltiplos:
update_field( 'campo_posts', [ 42, 57, 88 ], $pid );
```

---

## 7. Padrão de Log (Output)

Todos os scripts produzem o **mesmo formato de log** no terminal.

### Cabeçalho

```
════════════════════════════════════════
  IMPORT: Nome da Página
════════════════════════════════════════

📄  Página encontrada (ID: 42)

✓  Template: nome-template.php
```

### Seções

```
── Aba: Nome da Aba ─────────────────────
  Importando imagens...
  ✓  Importado: arquivo.webp (ID: 156)
  ↩  Já importado: outro.webp (ID: 120)
  ⚠  Não encontrado: faltando.webp
✓  nome_do_campo_texto
✓  nome_da_galeria: 3 imagens
⚠  campo_pendente → preencher no painel
```

### Rodapé

```
════════════════════════════════════════
✅  Concluído! Página ID: 42
🔗  https://site.local/pagina/
════════════════════════════════════════

📋  PENDÊNCIAS PARA O PAINEL:
   • PDFs a enviar
   • Campos que precisam de revisão
```

### Ícones e seus significados

| Ícone | Significado |
|---|---|
| `✓` | Campo/imagem salvo com sucesso |
| `↩` | Imagem já existia na biblioteca — reutilizada |
| `⚠` | Arquivo não encontrado ou campo deixado em branco intencionalmente |
| `✗` | Erro real (falha ao copiar, erro WP, etc.) |
| `📄` | Página localizada |
| `✅` | Script concluído sem erros críticos |
| `🔗` | URL da página importada |
| `📋` | Lista de pendências para o painel |

---

## 8. Convenções de Nomenclatura

### Arquivos de script

```
import-{slug-exato-da-pagina}.php
```

Exemplos:
- `import-home.php` → página `/`
- `import-sobre.php` → página `/sobre/`
- `import-area-medica.php` → página `/especialidades/area-medica/`

### Imagens (padrão deste projeto)

| Uso | Convenção | Exemplo |
|---|---|---|
| Card grande (pin/home) | `{especialidade}.webp` | `fisioterapia.webp` |
| Card thumb (pág. listagem) | `{especialidade}1.webp` | `fisioterapia1.webp` |
| Banner interno | `banner-{especialidade}.webp` | `banner-fisioterapia.webp` |
| Imagem da seção Sobre | `{especialidade}-{descritor}.webp` | `fisioterapia-nas-casas-andre-luiz.webp` |

### Campos ACF — prefixos por página

Cada página tem um prefixo único para seus campos. Campos compartilhados entre páginas do mesmo tipo **usam o mesmo nome sem prefixo**.

Exemplo deste projeto:
- Campos do card de especialidade: `am_card_img`, `am_card_img_p`, `am_card_desc` (igual em todas as especialidades)
- Campos da própria página: `{prefixo}_banner_title`, `{prefixo}_sobre_text`, etc.

---

## 9. Template Completo de Script

Copie este template como ponto de partida para qualquer nova página:

```php
<?php
/**
 * Script de Importação — Página/Especialidade "Nome"
 * ====================================================
 * Como executar (no shell do LocalWP):
 *   wp eval-file "C:\Caminho\_scripts\import-nome.php" --path="C:\Caminho\wp\app\public"
 */

// ─── Helper de importação de imagem ──────────────────────────────────────────
// (incluir apenas se o script usar imagens)
function _import_theme_image( string $filename, string $title ): int {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $src = get_template_directory() . '/img/' . $filename;
    if ( ! file_exists( $src ) ) { echo "  ⚠  Não encontrado: $filename\n"; return 0; }

    $slug     = sanitize_title( pathinfo( $filename, PATHINFO_FILENAME ) );
    $existing = get_posts( [ 'post_type' => 'attachment', 'post_status' => 'any', 'name' => $slug, 'posts_per_page' => 1 ] );
    if ( $existing ) { echo "  ↩  Já importado: $filename (ID: {$existing[0]->ID})\n"; return (int) $existing[0]->ID; }

    $upload = wp_upload_dir();
    $dest   = trailingslashit( $upload['path'] ) . $filename;
    if ( ! copy( $src, $dest ) ) { echo "  ✗  Erro ao copiar: $filename\n"; return 0; }

    $att_id = wp_insert_attachment( [ 'post_mime_type' => wp_check_filetype( $filename )['type'], 'post_title' => $title, 'post_name' => $slug, 'post_status' => 'inherit' ], $dest );
    if ( is_wp_error( $att_id ) ) { echo "  ✗  {$att_id->get_error_message()}\n"; return 0; }

    wp_update_attachment_metadata( $att_id, wp_generate_attachment_metadata( $att_id, $dest ) );
    echo "  ✓  Importado: $filename (ID: $att_id)\n";
    return (int) $att_id;
}

// ─── 1. Localizar a página ────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "  IMPORT: Página \"Nome da Página\"\n";
echo "════════════════════════════════════════\n\n";

// Para página raiz:       get_page_by_path( 'slug-da-pagina' )
// Para subpágina:         get_page_by_path( 'pai/slug-da-pagina' )
$page = get_page_by_path( 'slug-da-pagina' );
if ( ! $page ) { echo "✗  Página 'slug-da-pagina' não encontrada.\n"; return; }
$pid = (int) $page->ID;
echo "📄  Página encontrada (ID: $pid)\n\n";

update_post_meta( $pid, '_wp_page_template', 'nome-template.php' );
echo "✓  Template: nome-template.php\n";

// ─── 2. Aba: Banner ──────────────────────────────────────────────────────────
echo "\n── Aba: Banner ──────────────────────────\n";

update_field( 'prefixo_banner_title', 'Título do Banner', $pid );
echo "✓  prefixo_banner_title\n";

echo "  Importando imagem do banner...\n";
$banner_img_id = _import_theme_image( 'banner-nome.webp', 'Banner Nome' );
if ( $banner_img_id ) { update_field( 'prefixo_banner_img', $banner_img_id, $pid ); echo "✓  prefixo_banner_img\n"; }

// ─── 3. Aba: Sobre ───────────────────────────────────────────────────────────
echo "\n── Aba: Sobre ───────────────────────────\n";

update_field( 'prefixo_sobre_tit', 'Título da Seção', $pid );
update_field( 'prefixo_sobre_text',
    '<p>Primeiro parágrafo.</p>'
    . '<p>Segundo parágrafo.</p>',
    $pid
);
echo "✓  prefixo_sobre_tit / prefixo_sobre_text\n";

$sobre_img_id = _import_theme_image( 'foto-sobre.webp', 'Foto Sobre' );
if ( $sobre_img_id ) { update_field( 'prefixo_sobre_img', $sobre_img_id, $pid ); echo "✓  prefixo_sobre_img\n"; }

// ─── 4. Aba: Cards / Lista / etc. ────────────────────────────────────────────
echo "\n── Aba: Cards ───────────────────────────\n";

update_field( 'prefixo_cards_list', [
    [
        'cor'      => 'blue',
        'titulo'   => 'Título do Card',
        'conteudo' => '<p>Conteúdo do card.</p>',
    ],
], $pid );
echo "✓  prefixo_cards_list\n";

// ─── Resultado ────────────────────────────────────────────────────────────────
echo "\n════════════════════════════════════════\n";
echo "✅  Concluído! Página ID: $pid\n";
echo '🔗  ' . get_permalink( $pid ) . "\n";
echo "════════════════════════════════════════\n\n";
```

---

## 10. Projeto de Referência: Casas André Luiz

### Scripts criados

| Script | Página WordPress | Template |
|---|---|---|
| `import-home.php` | `/` | `front-page.php` |
| `import-quem-somos.php` | `/quem-somos/` | `quem-somos.php` |
| `import-o-que-fazemos.php` | `/o-que-fazemos/` | `o-que-fazemos.php` |
| `import-campanhas.php` | `/campanhas/` | `campanhas.php` |
| `import-mercatudo.php` | `/mercatudo/` | `mercatudo.php` |
| `import-transparencia.php` | `/transparencia/` | `transparencia.php` |
| `import-faq.php` | `/faq/` | `faq.php` |
| `import-contato.php` | `/contato/` | `contato.php` |
| `import-como-ajudar.php` | `/como-ajudar/` | `como-ajudar.php` |
| `import-area-medica.php` | `/especialidades/area-medica/` | `area-medica.php` |
| `import-educacao-fisica.php` | `/especialidades/educacao-fisica/` | `educacao-fisica.php` |
| `import-enfermagem.php` | `/especialidades/enfermagem/` | `enfermagem.php` |
| `import-fisioterapia.php` | `/especialidades/fisioterapia/` | `fisioterapia.php` |
| `import-fonoaudiologia.php` | `/especialidades/fonoaudiologia/` | `fonoaudiologia.php` |
| `import-psicologia.php` | `/especialidades/psicologia/` | `psicologia.php` |
| `import-arteterapia.php` | `/especialidades/arteterapia/` | `arteterapia.php` |
| `import-odontologia.php` | `/especialidades/odontologia/` | `odontologia.php` |

### Padrão das subpáginas de especialidade

Todas as especialidades compartilham os mesmos campos do card (definidos no ACF com o mesmo `name` em todos os grupos):

| Campo ACF | Conteúdo | Fonte |
|---|---|---|
| `am_card_img` | Imagem grande retrato (pin/home) | HTML da própria especialidade |
| `am_card_img_p` | Thumb paisagem (pág. especialidades) | `especialidades.html` |
| `am_card_desc` | Texto curto do card | `especialidades.html` |

> `am_galeria` (pin-wrapper) foi intencionalmente **omitido** de todos os scripts
> de especialidade — campo populado manualmente se necessário.

### Localização das imagens

```
wp/app/public/wp-content/themes/temacasasandreluiz/img/
```

### Comando base (LocalWP — Windows)

```bash
wp eval-file "D:\Clientes\Localsites\casas-andre-luiz\_scripts\import-NOME.php" --path="D:\Clientes\Localsites\casas-andre-luiz\wp\app\public"
```

---

## 11. Adaptando para Outros Projetos

### Conteúdo em HTML estático

Abra o `.html` no editor, localize os blocos de conteúdo e copie o texto diretamente para as strings PHP. Use o inspector do navegador para identificar qual texto pertence a qual seção.

### Conteúdo em Word (.docx)

**Opção rápida — Pandoc:**

```bash
# Instalar: https://pandoc.org/
pandoc conteudo.docx -o conteudo.html --no-highlight
```

Abra o `conteudo.html` gerado, extraia os blocos e cole nas strings do script.

**Opção automatizada — phpoffice/phpword:**

```bash
composer require phpoffice/phpword
```

```php
require 'vendor/autoload.php';
$phpWord = \PhpOffice\PhpWord\IOFactory::load( '/caminho/para/arquivo.docx' );
// percorrer seções e parágrafos para montar as strings
```

### Conteúdo em planilha Excel/CSV

**CSV:**

```php
$handle = fopen( '/caminho/dados.csv', 'r' );
while ( ( $row = fgetcsv( $handle, 0, ';' ) ) !== false ) {
    // $row[0] = título, $row[1] = texto, etc.
    update_field( 'campo', $row[1], $pid );
}
fclose( $handle );
```

**Excel (.xlsx):**

```bash
composer require phpoffice/phpspreadsheet
```

```php
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load( 'dados.xlsx' );
$sheet = $spreadsheet->getActiveSheet();
foreach ( $sheet->getRowIterator(2) as $row ) { // linha 2 em diante (pula header)
    $cells = $row->getCellIterator();
    // processar células
}
```

### Imagens em pasta externa ao tema

Substitua o helper padrão pela variante de caminho absoluto:

```php
function _import_image_from_path( string $filepath, string $title ): int {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    if ( ! file_exists( $filepath ) ) { echo "  ⚠  Não encontrado: $filepath\n"; return 0; }

    $filename = basename( $filepath );
    $slug     = sanitize_title( pathinfo( $filename, PATHINFO_FILENAME ) );

    $existing = get_posts( [ 'post_type' => 'attachment', 'post_status' => 'any', 'name' => $slug, 'posts_per_page' => 1 ] );
    if ( $existing ) { echo "  ↩  Já importado: $filename (ID: {$existing[0]->ID})\n"; return (int) $existing[0]->ID; }

    $upload = wp_upload_dir();
    $dest   = trailingslashit( $upload['path'] ) . $filename;
    if ( ! copy( $filepath, $dest ) ) { echo "  ✗  Erro ao copiar: $filename\n"; return 0; }

    $att_id = wp_insert_attachment( [ 'post_mime_type' => wp_check_filetype( $filename )['type'], 'post_title' => $title, 'post_name' => $slug, 'post_status' => 'inherit' ], $dest );
    if ( is_wp_error( $att_id ) ) { echo "  ✗  {$att_id->get_error_message()}\n"; return 0; }

    wp_update_attachment_metadata( $att_id, wp_generate_attachment_metadata( $att_id, $dest ) );
    echo "  ✓  Importado: $filename (ID: $att_id)\n";
    return (int) $att_id;
}

// Uso:
$id = _import_image_from_path( 'C:/projetos/cliente/imagens/foto.webp', 'Foto' );
```

### Criação de posts (CPT) em loop

Quando o conteúdo não é uma página, mas sim um Custom Post Type (ex: produtos, notícias):

```php
$items = [
    [ 'titulo' => 'Produto A', 'preco' => '99.90', 'foto' => 'produto-a.webp' ],
    [ 'titulo' => 'Produto B', 'preco' => '149.90', 'foto' => 'produto-b.webp' ],
];

foreach ( $items as $item ) {
    // Verifica se já existe pelo título
    $existing = get_posts( [ 'post_type' => 'produto', 'title' => $item['titulo'], 'posts_per_page' => 1 ] );
    if ( $existing ) {
        $post_id = $existing[0]->ID;
        echo "↩  Já existe: {$item['titulo']} (ID: $post_id)\n";
    } else {
        $post_id = wp_insert_post( [
            'post_type'   => 'produto',
            'post_title'  => $item['titulo'],
            'post_status' => 'publish',
        ] );
        echo "✓  Criado: {$item['titulo']} (ID: $post_id)\n";
    }

    update_field( 'preco', $item['preco'], $post_id );

    $foto_id = _import_theme_image( $item['foto'], $item['titulo'] );
    if ( $foto_id ) set_post_thumbnail( $post_id, $foto_id );
}
```

---

## 12. Erros Comuns e Soluções

### Página não encontrada

```
✗  Página 'especialidades/area-medica' não encontrada.
```

**Causas:**
- Slug errado (verificar a URL real da página no WP)
- Para subpáginas, usar o caminho completo: `pai/filho` (não só `filho`)
- A página ainda não foi criada no WP

**Solução:** Verificar a URL no navegador (`/especialidades/area-medica/`) e usar exatamente `especialidades/area-medica` no `get_page_by_path()`.

---

### Imagem não encontrada

```
⚠  Não encontrado: banner-pagina.webp
```

**Causas:**
- Nome do arquivo diferente do esperado (maiúsculas, espaços, extensão)
- Arquivo em pasta diferente de `/img/`

**Solução:** Verificar o nome exato do arquivo na pasta do tema.

---

### Fatal error: Cannot redeclare _import_theme_image

Acontece se dois scripts forem incluídos no mesmo `eval-file` ou se o script for chamado dentro de um `require`. 

**Solução:** Cada script deve ser executado com seu próprio `wp eval-file`. Nunca incluir um script dentro de outro.

---

### update_field() não salva

**Causas:**
- ACF não está ativo
- O field group não está associado ao template correto
- O template ainda não foi definido com `update_post_meta` antes do `update_field()`

**Solução:** Garantir que `update_post_meta( $pid, '_wp_page_template', 'template.php' )` vem **antes** de qualquer `update_field()` no script.

---

### Tamanhos de imagem não gerados

Se um `add_image_size()` foi adicionado ao `functions.php` **depois** de rodar os scripts:

```bash
wp media regenerate --yes --path="C:\Caminho\wp\app\public"
```

---

### SVG não importa

O WordPress bloqueia SVG por padrão. Adicionar ao `functions.php` do tema:

```php
add_filter( 'upload_mimes', function( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
} );

add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename ) {
    if ( substr( $filename, -4 ) === '.svg' ) {
        $data['ext']  = 'svg';
        $data['type'] = 'image/svg+xml';
    }
    return $data;
}, 10, 3 );
```

Ou adicionar temporariamente no próprio script antes de importar o SVG.

---

*Documentação gerada em maio de 2025 — Projeto Casas André Luiz*
*Padrão aplicável a qualquer projeto WordPress + ACF + WP-CLI*
