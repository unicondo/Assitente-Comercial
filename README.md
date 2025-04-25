# 🚀 Assistente Comercial - Sistema de Solicitação de Propostas

## 📌 Visão Geral

O **Assistente Comercial** é uma aplicação web robusta que **padroniza, organiza e automatiza** o processo de solicitação de propostas técnicas e comerciais. Desenvolvido para empresas que gerenciam integrações de equipamentos, serviços e documentação técnica, o sistema centraliza todas as etapas, promovendo **eficiência, clareza e segurança**. Ideal para equipes técnicas e comerciais que buscam reduzir retrabalho e melhorar a comunicação.

---

## ✨ Funcionalidades Principais

### 🔐 Autenticação Segura
- Login com hash `bcrypt` (senha: "unicondo")
- Bloqueio após 35 tentativas incorretas com delay de 2 segundos
- Sessão com timeout de 30 minutos
- Proteção contra inspeção de código (F12, clique direito)

### 💾 Salvamento Automático
- Dados armazenados localmente via `localStorage`
- Previne perda de informações por fechamento acidental
- Limpeza automática dos dados após envio

### 🧾 Protocolo Único
- Geração automática de protocolo (ex.: `DMSYS25042025-103900-XYZ`)
- Incluído no e-mail e na confirmação
- Facilita rastreamento de solicitações

### 🖥️ Interface Responsiva e Intuitiva
- Tema escuro moderno, otimizado para mobile e desktop
- Navegação por abas com barra de progresso animada
- Validação em tempo real de campos obrigatórios
- Modal de onboarding com tutorial interativo (DotLottie)
- Modal de confirmação com resumo visual interativo

### 📑 Formulário Completo

#### Informações Básicas
- **Campos**: Setor (Contrato/Implantação), Cliente, Solicitante (obrigatórios)
- Prioridade com destaque visual (Normal, Média, Alta, Urgente)
- Tipo de proposta: Produto, Serviço, Completa
- Opções: Notificação por e-mail, Aditivo Contratual
- E-mail de notificação com protocolo único

#### Escopo do Projeto
- Editor de texto rico com **Summernote** (formatação, listas, tabelas)
- Campo obrigatório para descrição detalhada do projeto
- Suporte a objetivos, requisitos e entregas esperadas

#### Equipamentos
- Adição dinâmica de múltiplos itens
- **Campos**: Nome, Modelo, Marca, Quantidade, Especificações (obrigatórios)
- Opção de cabo com detalhes: metragem, tipo, vias, cor, blindagem

#### Mão de Obra
- Múltiplos serviços por proposta
- **Campos por serviço**: Descrição, Período (Diurno/Noturno), Dia (Útil/Fim de semana), Total de dias
- Profissionais dinâmicos por serviço: tipo (ex.: Técnico de Automação), quantidade
- Adição/remoção em tempo real

#### Upload
- Relatório técnico obrigatório (PDF, DOCX)
- Validação com feedback visual
- Instruções para imagens claras e de alta qualidade

### 📤 Envio Inteligente
- Geração de resumo visual em tabela com contraste otimizado
- Upload de arquivo via AJAX com feedback de spinner
- E-mail estruturado com protocolo e anexo
- Confirmação visual de envio com recarregamento automático

### 🛡️ Proteção Contra Uso Indevido
- Sanitização de inputs
- Bloqueio de clique direito, F12 e atalhos de inspeção
- Proteção de sessão e diretório de uploads
- Validação rigorosa de campos obrigatórios

---

## 🆕 Novidades da Versão 2.1.0

- 📝 **Editor de Escopo com Summernote**: Novo campo de texto rico para descrever o escopo do projeto com formatação avançada (negrito, listas, tabelas).
- 🎨 **Melhorias na Interface**:
  - Modal de confirmação com fundo escuro, texto branco e tabelas de alto contraste.
  - Estilização otimizada para botões (transições suaves com `color-mix`).
  - Campo de e-mail e protocolo exibidos lado a lado (responsivo).
- 🛠️ **Otimização de Validação**:
  - Validação mais rigorosa para equipamentos e serviços.
  - Feedback claro para campos obrigatórios, incluindo escopo.
- 🔄 **Melhorias no Fluxo**:
  - Integração do escopo do projeto no resumo e e-mail.
  - Recarregamento automático do formulário após envio.
- 📱 **Compatibilidade Mobile**:
  - Ajustes no layout para telas menores (ex.: campos de período/dia em coluna).
  - Melhor responsividade no modal de onboarding.
- 🛡️ **Segurança Aprimorada**:
  - Validação adicional no upload de arquivos via AJAX.
  - Proteção reforçada contra tentativas de login maliciosas.
- 🌐 **SEO e Compartilhamento**:
  - Adição de Open Graph e Twitter Card para melhor compartilhamento.
  - Metadados otimizados (favicon, autor, direitos).

---

## 🛠️ Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/unicondo/Assitente-Comercial.git
   ```
2. Configure um servidor com PHP 7.4+ e extensões (`openssl`, `fileinfo`, `bcrypt`, `mbstring`).
3. Crie a pasta `Uploads/` na raiz do projeto com permissões de escrita:
   ```bash
   mkdir Uploads && chmod 775 Uploads
   ```
4. Configure o servidor de e-mail no arquivo `enviar_email.php`.
5. Acesse a aplicação via navegador (HTTPS recomendado).

---

## 🔍 Análise do Código

### 1. Configurações Iniciais (PHP)
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '256M');
session_start();
```
- Ativa exibição de erros para depuração
- Define limite de memória (256M)
- Inicia sessão para autenticação

### 2. Autenticação
- Hash `bcrypt` para senha segura ("Dmsys-1290")
- Bloqueio após 35 tentativas com delay
- Timeout de sessão (30 minutos)

### 3. Página de Login
- Animação Lottie com saudação dinâmica (bom dia/tarde/noite)
- Campo de senha com toggle (mostrar/ocultar)
- Proteção contra F12, clique direito e atalhos
- Metadados Open Graph e Twitter Card para SEO

### 4. Página Principal
#### Layout
- Tema escuro com Bootstrap 5
- Barra de progresso no scroll
- Spinner de carregamento
- Modais: confirmação (resumo) e onboarding (tutorial)

#### Formulário
- **Informações Básicas**: Setor, Cliente, Solicitante, Prioridade, Tipo de Proposta
- **Escopo do Projeto**: Editor Summernote com formatação rica
- **Equipamentos**: Blocos dinâmicos com campos de cabo condicionais
- **Mão de Obra**: Serviços com profissionais dinâmicos
- **Upload**: Relatório técnico com validação

### 5. JavaScript
#### Fluxo Lógico
- `atualizarVisibilidadeSecoes()`: Mostra/oculta seções por tipo de proposta
- `gerarProtocolo()`: Cria código único (data/hora + letras aleatórias)
- `gerarResumoProposta()`: Compila dados em HTML para modal e e-mail
- `enviarSolicitacao()`: Valida e inicia envio
- `enviarArquivoParaServidor()`: Upload via AJAX
- `enviarEmail()`: Envia e-mail com anexo

#### Interatividade
- Funções para adicionar/remover: `adicionarEquipamento()`, `adicionarServico()`, `adicionarProfissional()`
- Validação em tempo real
- Onboarding interativo com progresso

### 6. Estilo CSS
- Tema escuro com `color-mix` para botões
- Tabelas de alto contraste no resumo
- Responsividade para mobile
- Animações (ex.: prioridade urgente com `pulse`)

### 7. Backend
- `upload.php`: Processa upload de relatórios
- `enviar_email.php`: Envia e-mail com dados e anexo

---

## 🚦 Fluxo Completo

1. Usuário faz login com senha
2. Preenche informações básicas e escopo do projeto
3. Adiciona equipamentos e/ou serviços
4. Anexa relatório técnico
5. Visualiza resumo em modal interativo
6. Confirma envio, gerando protocolo e e-mail
7. Formulário é reiniciado

---

## 🧰 Tecnologias Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript (ES6+), Bootstrap 5, Summernote, DotLottie
- **Backend**: PHP 7.4+, Sessões, Uploads, `bcrypt`, Envio de e-mail
- **Bibliotecas**: jQuery, Bootstrap JS, Summernote JS

---

## 🧾 Requisitos

- Servidor com PHP 7.4+
- Extensões: `openssl`, `fileinfo`, `bcrypt`, `mbstring`
- Pasta `Uploads/` com permissão 775
- Servidor SMTP configurado
- HTTPS recomendado

---

## 📈 Benefícios

- **Padronização**: Processo centralizado e estruturado
- **Eficiência**: Redução de retrabalho e tempo
- **Rastreabilidade**: Controle por protocolo único
- **Comunicação**: Integração clara entre áreas
- **Segurança**: Proteção de dados e acesso

---

## ⚠️ Limitações

- O envio de e-mails depende de um servidor SMTP configurado.
- Proteções contra F12/clique direito podem ser contornadas por usuários avançados.
- O uso de `localStorage` limita o armazenamento para formulários extensos.

---

## 🤝 Contribuição

1. Faça um fork do projeto.
2. Crie uma branch para sua feature:
   ```bash
   git checkout -b feature/nova-funcionalidade
   ```
3. Commit suas alterações:
   ```bash
   git commit -m 'Adiciona nova funcionalidade'
   ```
4. Envie para o repositório remoto:
   ```bash
   git push origin feature/nova-funcionalidade
   ```
5. Abra um Pull Request.

---

## 📜 Licença

Este projeto está licenciado sob a [MIT License](LICENSE).

---

## 📞 Suporte

**Allvz Startup**  
📱 WhatsApp: [+55 11 98793-5241](https://wa.me/5511987935241)  
📧 E-mail: suporte@allvzstartup.com

---

> *Solução robusta para empresas que valorizam agilidade, clareza e segurança nas solicitações comerciais.*
