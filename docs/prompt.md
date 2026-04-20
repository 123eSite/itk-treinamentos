# ATUE COMO: Senior WordPress Developer & Automation Architect

Estou iniciando um novo projeto de desenvolvimento de tema WordPress do zero. Tenho o HTML estático pronto dentro da pasta e um tema de referência (boilerplate) que uso como padrão.

# OBJETIVO
Sua missão é converter o HTML estático em um Tema WordPress funcional, seguindo estritamente meu workflow, mas adaptando ao layout atual. O processo deve ser iterativo e passo a passo.

# CONTEXTO E INSUMOS
1. **HTML Estático:** Estarei fornecendo os arquivos HTML na pasta html.
2. **Tema de Desenvolvimento:** Já copiei os assets do projeto que serão usados no tema da pasta html.
2. **Tema de Referência:** Usaremos a estrutura de arquivos e lógica do tema de referência que anexarei (app/public/wp-content/themes/temareferencia).
3. **Documentação:** Precisamos criar/atualizar um arquivo `DEV_GUIDE_WP.md` com as regras lógicas usadas (ex: convenções de nomes, estrutura de pastas), para replicar em projetos futuros. Gostaria de ao aplicar essa documentação em qualquer outro projeto como esse, mesmo com um layout diferente, não seja mais necessário explicar através desse prompt. Vou criar um padrão de criação de template de Wordpress.

# REGRAS DE DESENVOLVIMENTO (MANDATÓRIAS)

1.  **Estrutura de Arquivos:** Siga a hierarquia do WordPress (header.php, footer.php, front-page.php, functions.php, page.php).
2.  **Fatiamento (Slicing):**
    * Separe o HTML comum em `header.php` e `footer.php` ou em arquivos que serão implementados com `get_template_part()`.
3.  **ACF (Advanced Custom Fields):**
    * Todo conteúdo editável deve virar um campo ACF.
    * **CRÍTICO:** Ao criar a lógica do campo no PHP (ex: `get_field`), você deve SIMULTANEAMENTE gerar o código do array JSON correspondente a esse grupo de campos para que eu possa sincronizar no admin do WP ou salvar na pasta `acf-json`. Importante sempre criar campos com nomes em português do Brasil e que tenham similaridade com o conteúdo em questão. Seguir como referência o tema de referência.
    Sempre criar um arquivo de planejamento mapeando os campos que serão criados no ACF com uma tabela: Nome do campo, descrição, se é obrigatório, se é repetidor, se é galeria, etc.
4.  **Formulários:** O HTML de formulários deve ser convertido para a sintaxe de shortcode do Contact Form 7 e disponibilizado para copiar e colar dentro do plug-in.
5.  **Documentação Contínua:** A cada etapa concluída, atualize o `DEV_GUIDE_WP.md` com padrões abstratos (não específicos do cliente, mas da lógica de dev).

# FLUXO DE TRABALHO (STEP-BY-STEP)

Não execute tudo de uma vez. Vamos seguir estas etapas. Aguarde meu "OK" para avançar:

**FASE 1: Setup e Estrutura Básica**
- Analisar o HTML vs Tema de Referência.
- Criar um arquivo gitignore da pasta app/public/wp-content/themes/temareferencia.
- Configurar `style.css` e `functions.php` (enfileiramento de assets).
- Fatiar `header.php` , `footer.php` e `front-page.php` para fazemos os primeiros testes.
- A pasta do tema já foi criada e os arquivos dos assets da pasta HTML já estão dentro e não será necessário migrar da pasta html.

**FASE 2: Páginas e Templates**
- Criar os demais arquivos em PHP e fatiar o restante das páginas uma a uma para ir validando.
- Integrar o HTML estático.

**FASE 3: Integração ACF (A mais importante)**
- Analisar o template.
- Definir os campos necessários.
- Criar o código PHP de exibição e o JSON de configuração.

**FASE 4: Formulários e Ajustes Finais**
- Converter forms para CF7.
- Revisão final.

---
**AGORA:** Por favor, analise os arquivos que anexei (HTML e Referência) e me dê um resumo do que você entendeu. Vou dar os comandos de cada fase e seção antes que inicie. A ideia é ir montando o template por etapas para que seja mais fácil analisar e testar.