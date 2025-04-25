# Changelog

Todas as mudanças importantes neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/), e este projeto segue a [Semantic Versioning](https://semver.org/lang/pt-BR/spec/v2.0.0.html).

---

## [2.1.0] - 2025-04-25

### Adicionado
- **Editor de Escopo com Summernote**: Campo de texto rico para descrição detalhada do escopo do projeto, com suporte a formatação (negrito, listas, tabelas).
- **Metadados de SEO**: Open Graph e Twitter Card para melhor compartilhamento em redes sociais, com favicon e thumbnail personalizados.
- **Validação Rigorosa**:
  - Validação obrigatória para o campo "Escopo do Projeto".
  - Verificação aprimorada de campos de equipamentos e serviços.
- **Modal de Confirmação Melhorado**: Tabelas de resumo com alto contraste, fundo escuro e texto branco.
- **Onboarding Responsivo**: Modal de tutorial com layout otimizado para dispositivos móveis.
- **Feedback Visual**:
  - Botões com transições suaves usando `color-mix`.
  - Spinner de carregamento durante upload de arquivos.
- **Campos Dinâmicos**: Exibição condicional de e-mail e protocolo em layout lado a lado (responsivo).
- **Recarregamento Automático**: Formulário reinicia após envio bem-sucedido.
- **Documentação Expandida**:
  - Seções de instalação, contribuição e limitações no `README.md`.
  - Detalhamento das novidades da versão 2.1.0.

### Alterado
- **Interface**:
  - Ajustes de responsividade para campos de período/dia em telas menores.
  - Estilização otimizada de tabelas e modais para maior clareza.
- **Segurança**:
  - Reforço na validação de uploads via AJAX.
  - Melhor proteção contra tentativas de login maliciosas.
- **JavaScript**:
  - Modularização aprimorada das funções de validação e envio.
  - Integração do Summernote para o campo de escopo.
- **CSS**:
  - Uso de `color-mix` para botões com transições mais suaves.
  - Ajustes no layout de tabelas para melhor legibilidade.

### Removido
- Protocolo de segurança com PIN de 4 dígitos (substituído por validação direta no modal de confirmação).
- Contagem regressiva de 5 segundos após envio (substituída por recarregamento automático).

---

## [2.0.0] - 2025-04-15

### Adicionado
- Salvamento automático do formulário usando `localStorage`, garantindo preservação de dados em caso de interrupção.
- Validação de campos obrigatórios com feedback visual (borda vermelha e foco no campo).
- Layout 100% responsivo para desktop e mobile.
- Geração automática de protocolo único para rastreamento.
- Modal de onboarding com tutorial interativo (DotLottie).
- Modal de confirmação com resumo visual interativo.
- Proteção contra inspeção de código (F12, clique direito).
- Explicação completa de uso no `README.md`, com instruções para instalação.

### Alterado
- Estrutura geral do HTML e CSS reorganizada para facilitar manutenção.
- Melhorias no script JavaScript para modularizar funções.

---

## [1.0.0] - 2025-04-10

### Adicionado
- Primeira versão funcional com formulário de coleta de dados.
- Campos básicos de preenchimento (Setor, Cliente, Solicitante).
