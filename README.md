
# 🚀 Assistente Comercial - Sistema de Solicitação de Propostas

## 📌 Visão Geral

O **Assistente Comercial** é uma aplicação web completa que **padroniza, organiza e automatiza** o processo de solicitação de propostas técnicas e comerciais. Desenvolvido para empresas que lidam com integrações de equipamentos, serviços e documentação técnica, o sistema centraliza todas as etapas da solicitação, garantindo **eficiência, clareza e segurança**.

---

## ✨ Funcionalidades Principais

### 🔐 Autenticação Segura
- Login com hash `bcrypt`
- Bloqueio automático após 35 tentativas incorretas (delay de 2 segundos)
- Sessão com timeout de 30 minutos

### 💾 Salvamento Automático
- Armazena dados localmente com `localStorage`
- Evita perda de informações por fechamento/acidente
- Dados são apagados automaticamente após envio

### 🧾 Protocolo Único por Solicitação
- Cada proposta gera um código de protocolo exclusivo
- Inserido no e-mail e na confirmação
- Facilita rastreabilidade de solicitações

### 🖥️ Interface Responsiva e Intuitiva
- Layout moderno, escuro e adaptado para dispositivos móveis
- Navegação por **etapas (tabs)**
- Validação em tempo real dos campos obrigatórios
- Barra de progresso no topo com animação

### 📑 Formulário Completo
- Seção de Informações Básicas:
  - Setor (Contrato/Implantação), Cliente, Solicitante
  - Prioridade com destaque visual
  - Tipo de proposta (Produto, Serviço, Completa)
  - Opção de notificação por e-mail
  - Aditivo Contratual

- Seção de Equipamentos:
  - Adição de múltiplos itens com nome, modelo, marca, quantidade
  - Detalhes técnicos: tipo e metragem de cabos, cor, vias, blindagem

- Seção de Mão de Obra:
  - Vários serviços por proposta
  - Tipo de profissional, período (diurno/noturno), tipo de dia, dias necessários

- Upload de relatório técnico (obrigatório)

### 📤 Envio Inteligente
- Geração de **resumo visual interativo**
- Upload de arquivo com validação
- Geração de e-mail com corpo estruturado + protocolo
- Confirmação visual de envio

### 🛡️ Proteção Contra Uso Indevido
- Inputs sanitizados
- Desativação de clique direito, F12 e inspeção de código
- Proteção de sessão e diretório de uploads

---

## 🆕 Novidades da Versão 2.0.0

- Geração automática de protocolo
- Salvamento automático com LocalStorage
- Validação mais inteligente de campos
- Interface com navegação por abas
- Confirmação visual melhorada com resumo interativo
- Melhor compatibilidade mobile
- Proteção contra ferramentas de desenvolvedor
- Design visual mais limpo e moderno

---

# 🔍 Análise do Código PHP/HTML/JavaScript

## 1. Configurações Iniciais (PHP)

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '256M');
session_start();
```

- Ativa exibição de erros
- Define limite de memória
- Inicia sessão para controle de autenticação

---

## 2. Autenticação por Senha

```php
$senha_correta = '$2y$10$fCacVbnAk6m7zsQJ0dKPt.xlgYAba5g8ZsBVOi4uJvLIT0Vgi.0TW';
```

- Verifica senha contra hash ("unicondo")
- Bloqueia login após 35 tentativas (delay de 2s)

---

## 3. Página de Login

- Animação Lottie com saudação dinâmica (bom dia/tarde/noite)
- Campo de senha com botão mostrar/ocultar
- Proteção contra inspeção e cópia (F12, clique direito bloqueados)

---

## 4. Controle de Sessão

- Sessão expira após 30 minutos
- Redireciona automaticamente ao login

---

## 5. Página Principal (Após Login)

### Layout
- Barra de progresso no scroll
- Spinner de carregamento
- Modal de confirmação de envio
- Modal de tutorial onboarding (DotLottie)

### Seções do Formulário

#### Informações Básicas
- Campos obrigatórios: Setor, Cliente, Solicitante
- Prioridade visual (com cores: verde, amarelo, vermelho, roxo)
- Tipo de proposta e opções extras (email/aditivo)

#### Equipamentos
- Blocos dinâmicos com botão adicionar/remover
- Campos para cabos (ativados conforme tipo selecionado)

#### Mão de Obra
- Blocos de serviço com múltiplos profissionais
- Campos dinâmicos: tipo, período, dias
- Adição e remoção em tempo real

#### Upload
- Arquivo obrigatório (PDF, DOCX)
- Upload com feedback visual

---

## 6. Funcionalidades JavaScript

### 🔁 Fluxo Lógico
- `atualizarVisibilidadeSecoes()` – mostra/oculta seções por tipo de proposta
- `gerarProtocolo()` – cria código único com base na data/hora
- `gerarResumoProposta()` – compila os dados em HTML para envio
- `enviarSolicitacao()` e `enviarEmail()` – processam envio final
- `enviarArquivoParaServidor()` – upload via AJAX para PHP

### 🧩 Interatividade
- `adicionarEquipamento()` / `removerEquipamento()` – gestão de equipamentos
- `adicionarServico()` / `removerServico()` – gestão de serviços
- `adicionarProfissional()` / `removerProfissional()` – por serviço

### 📦 UI/UX
- Validação de campos obrigatórios
- Modais interativos (tutorial, confirmação)
- Scroll progressivo com barra visual
- Efeitos visuais em prioridades e botões

---

## 7. Estilo CSS

- Tema escuro elegante
- Destaques por prioridade (verde, amarelo, vermelho, roxo)
- Responsivo para mobile e desktop
- Modais e tabelas estilizadas
- Feedback visual para botões e hover

---

## 8. Backend (Implícito)

- `upload.php`: recebe relatório técnico
- `enviar_email.php`: gera e envia e-mail com dados da proposta + anexo

---

## 🚦 Fluxo Completo

1. Usuário acessa e faz login
2. Preenche dados básicos
3. Adiciona equipamentos e serviços
4. Anexa relatório técnico
5. Visualiza resumo e confirma envio
6. Sistema gera protocolo e envia e-mail
7. Dados são apagados do LocalStorage

---

## 🧰 Tecnologias Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript (ES6+), Bootstrap 5, DotLottie
- **Backend**: PHP 7.4+, Sessões, Uploads, `bcrypt`, envio de e-mail

---

## 🧾 Requisitos

- Servidor com PHP 7.4+
- Extensões: `openssl`, `fileinfo`, `bcrypt`, `mbstring`
- Pasta `uploads/` com permissão de escrita
- HTTPS recomendado

---

## 📈 Benefícios

- Processo padronizado e centralizado
- Economia de tempo e retrabalho
- Controle por protocolo
- Melhor comunicação entre áreas técnicas e comerciais
- Interface clara e segura

---

## 📞 Suporte

**Allvz Startup**  
📱 WhatsApp: [+55 11 98793-5241](https://wa.me/5511987935241)

---

> *Solução robusta para empresas que valorizam agilidade, clareza e segurança nas solicitações comerciais.*
