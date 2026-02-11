# Mapa do site — ITK Treinamentos

Documento gerado a partir da varredura do site [itktreinamentos.com.br](https://itktreinamentos.com.br/). Referência para construção do HTML e do site.

---

## Navegação principal

| Label | URL |
|-------|-----|
| O Instituto | `/o-instituto-itk/` |
| Acesse nossa loja | `https://loja.itktreinamentos.com.br/` (subdomínio) |
| Fale com o ITK | `/fale-com-o-itk/` |
| Cursos e treinamentos | `/treinamentos/` |
| Para Você | `/para-voce/` |
| Blog do ITK | `/artigos/` |

### Submenu “Para Você” (referência do site atual)

- Agenda → `/agenda/`
- Projeto de vida (página a confirmar no site)
- Mandala (página a confirmar no site)

---

## Estrutura hierárquica

### 1. Páginas institucionais

| Página | URL |
|--------|-----|
| Home | `https://itktreinamentos.com.br/` |
| O Instituto ITK | `https://itktreinamentos.com.br/o-instituto-itk/` |
| Fale com o ITK | `https://itktreinamentos.com.br/fale-com-o-itk/` |
| Para Você | `https://itktreinamentos.com.br/para-voce/` |

### 2. Cursos e treinamentos

| Página | URL |
|--------|-----|
| Listagem de cursos | `https://itktreinamentos.com.br/treinamentos/` |
| Leader Training | `https://itktreinamentos.com.br/treinamentos/leader-training` |

*(Demais cursos do site atual aparecem na listagem em `/treinamentos/`; incluir cada curso conforme existir página própria.)*

### 3. Agenda

| Página | URL |
|--------|-----|
| Agenda geral | `https://itktreinamentos.com.br/agenda/` |
| Leader Training 06 a 08 de março | `https://itktreinamentos.com.br/agenda/leader-training-06-a-08-de-marco` |

### 4. Blog (artigos)

| Página | URL |
|--------|-----|
| Blog do ITK (listagem) | `https://itktreinamentos.com.br/artigos/` |

#### Categorias do blog

| Categoria | URL |
|-----------|-----|
| Inteligência Emocional | `https://itktreinamentos.com.br/inteligencia-emocional/` |
| Meditação | `https://itktreinamentos.com.br/meditacao` |
| Empresarial | `https://itktreinamentos.com.br/empresarial/` |
| Dicas e novidades ITK | `https://itktreinamentos.com.br/dicas-e-novidades/` |

#### Artigos extraídos (URLs)

| Artigo | URL |
|--------|-----|
| Meditação Mindfulness: Como Incorporar a Prática no Dia a Dia... | `https://itktreinamentos.com.br/artigos/meditacao-mindfulness-como-incorporar-a-pratica-no-dia-a-dia-para-um-vida-mais-plena/` |
| Como se livrar de um vício psicológico | `https://itktreinamentos.com.br/artigos/como-se-livrar-de-um-vicio-psicologico/` |
| O que é resiliência emocional e como desenvolver a sua | `https://itktreinamentos.com.br/artigos/o-que-e-resiliencia-emocional-e-como-desenvolver-a-sua/` |
| Ciúmes possessivo: conheça os sinais e o que fazer | `https://itktreinamentos.com.br/artigos/ciumes-possessivo-conheca-os-sinais-e-o-que-fazer/` |
| Autoestima baixa com o corpo: o que fazer para mudar isso? | `https://itktreinamentos.com.br/artigos/autoestima-baixa-com-o-corpo-o-que-fazer-para-mudar-isso/` |
| Como ter amor próprio? A chave para uma vida plena e feliz | `https://itktreinamentos.com.br/artigos/como-ter-amor-proprio/` |
| 6 dicas para desenvolver a autoaceitação | `https://itktreinamentos.com.br/artigos/6-dicas-para-desenvolver-a-autoaceitacao/` |
| Autoconfiança: estratégias para desenvolver sua melhor versão | `https://itktreinamentos.com.br/artigos/autoconfianca-estrategias-para-desenvolver-sua-melhor-versao/` |
| Trauma de relacionamento: como lidar e seguir em frente | `https://itktreinamentos.com.br/artigos/trauma-de-relacionamento-como-lidar-e-seguir-em-frente/` |
| Sintomas de homem casado apaixonado por outra pessoa | `https://itktreinamentos.com.br/artigos/sintomas-de-homem-casado-apaixonado-por-outra-pessoa/` |

### 5. Loja (externo)

| Página | URL |
|--------|-----|
| Loja ITK | `https://loja.itktreinamentos.com.br/` |

### 6. Rodapé / páginas secundárias (referência do site atual)

- Política de Privacidade
- Termos e condições
- Mapa do site
- Loja (link para subdomínio acima)
- Fale com o ITK

*(URLs exatas dessas páginas devem ser confirmadas no site; costumam ser algo como `/politica-de-privacidade/`, `/termos-e-condicoes/`, `/mapa-do-site/`.)*

---

## Lista plana de URLs internas (base do domínio itktreinamentos.com.br)

```
/
/o-instituto-itk/
/fale-com-o-itk/
/para-voce/
/treinamentos/
/treinamentos/leader-training
/agenda/
/agenda/leader-training-06-a-08-de-marco
/artigos/
/inteligencia-emocional/
/meditacao
/empresarial/
/dicas-e-novidades/
/artigos/meditacao-mindfulness-como-incorporar-a-pratica-no-dia-a-dia-para-um-vida-mais-plena/
/artigos/como-se-livrar-de-um-vicio-psicologico/
/artigos/o-que-e-resiliencia-emocional-e-como-desenvolver-a-sua/
/artigos/ciumes-possessivo-conheca-os-sinais-e-o-que-fazer/
/artigos/autoestima-baixa-com-o-corpo-o-que-fazer-para-mudar-isso/
/artigos/como-ter-amor-proprio/
/artigos/6-dicas-para-desenvolver-a-autoaceitacao/
/artigos/autoconfianca-estrategias-para-desenvolver-sua-melhor-versao/
/artigos/trauma-de-relacionamento-como-lidar-e-seguir-em-frente/
/artigos/sintomas-de-homem-casado-apaixonado-por-outra-pessoa/
```

---

## Observações

- **Loja:** fica em subdomínio (`loja.itktreinamentos.com.br`); no HTML/WordPress pode ser link externo ou integração conforme decisão do projeto.
- **Blog:** novos artigos geram novas URLs em `/artigos/<slug>/`; o sitemap pode ser expandido ou gerado dinamicamente no WordPress.
- **Agenda:** eventos têm URLs em `/agenda/<slug>/`; incluir novos eventos conforme forem publicados.
- Páginas como **Projeto de vida**, **Mandala**, **Equipe**, **Terapia transpessoal**, **Política de Privacidade**, **Termos e condições** e **Mapa do site** foram referenciadas no conteúdo do site; vale confirmar slugs e criar entradas no sitemap quando as páginas existirem.

---

*Documento para uso na geração do HTML e do site (fase 1 e fase 2).*
