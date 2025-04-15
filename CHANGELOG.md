# Changelog

Todas as mudanças importantes neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/), e este projeto segue a [Semantic Versioning](https://semver.org/lang/pt-BR/spec/v2.0.0.html).

---

## [2.0.0] - 2025-04-15

### Adicionado
- Protocolo de segurança com PIN de 4 dígitos para validação do envio.
- Salvamento automático do formulário usando `localStorage`, garantindo que os dados sejam preservados em caso de interrupção.
- Validação de campos obrigatórios com feedback visual (borda vermelha e foco no campo).
- Mensagem de envio com contagem regressiva e redirecionamento automático após 5 segundos.
- Feedback de erro na validação de PIN incorreto.
- Layout 100% responsivo para desktop e mobile.
- Explicação completa de uso no `README.md`, com instruções para instalação e exemplos.

### Alterado
- Estrutura geral do HTML e CSS foi reorganizada para facilitar manutenção.
- Melhorias no script JavaScript para modularizar funções.

---

## [1.0.0] - 2025-04-10

### Adicionado
- Primeira versão funcional com formulário de coleta de dados.
- Campos básicos de preenchimento.
