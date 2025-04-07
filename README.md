# Assistente Comercial - Sistema de Solicitação de Propostas

## 📌 Visão Geral

O **Assistente Comercial** é uma aplicação web desenvolvida para padronizar e otimizar o processo de solicitação de propostas comerciais entre equipes. O sistema foi criado com o objetivo principal de:

- **Alinhar as solicitações** entre diferentes setores da empresa  
- **Evitar retrabalho** com informações incompletas ou inconsistentes  
- **Centralizar** todas as solicitações em um único fluxo padronizado  
- **Facilitar** a comunicação entre equipes comerciais e técnicas  

## ✨ Funcionalidades Principais

### 🔐 Sistema de Autenticação Segura
- Login com senha protegida por hash bcrypt  
- Limite de tentativas de login (35 tentativas) para prevenção de força bruta  
- Sessão com timeout de 30 minutos por inatividade  

### 🖥️ Interface Intuitiva
- Design moderno e responsivo (funciona em dispositivos móveis)  
- Onboarding interativo para novos usuários  
- Barra de progresso visual  
- Validação de campos obrigatórios  

### 🛠️ Gestão de Equipamentos
- Cadastro completo de equipamentos com:  
  - Nome, modelo e marca  
  - Quantidade e especificações técnicas  
  - Detalhes para cabos (metragem, tipo, vias, cor, blindagem)  
- Possibilidade de adicionar múltiplos equipamentos  

### 👷 Gestão de Mão-de-Obra
- Cadastro de serviços com:  
  - Seleção de profissionais por categoria  
  - Configuração de período (diurno/noturno)  
  - Tipo de dia (útil/fim de semana)  
  - Quantidade de dias necessários  
- Adição de múltiplos profissionais por serviço  
- Criação de vários serviços diferentes  

### 📎 Anexos
- Upload de relatório técnico com:  
  - Validação de arquivo obrigatório  
  - Feedback visual  
  - Armazenamento seguro no servidor  

### ✉️ Fluxo de Envio
- Pré-visualização completa da proposta antes do envio  
- Geração automática de e-mail com todos os detalhes  
- Confirmação visual do envio bem-sucedido  

## 🛠️ Tecnologias Utilizadas

### Front-end
- HTML5, CSS3, JavaScript moderno (ES6+)  
- Bootstrap 5 para componentes UI  
- DotLottie para animações  
- Design System próprio com variáveis CSS  

### Back-end
- PHP para processamento do servidor  
- Sessões PHP para autenticação  
- Upload seguro de arquivos  
- Envio de e-mails com anexos  

## 🔧 Requisitos do Sistema

- Servidor web com PHP (versão 7.4 ou superior)  
- Permissão de escrita no diretório `uploads/`  
- Extensão PHP para hash bcrypt habilitada  
- Configuração de memória PHP mínima de 256MB  

## 🚀 Como Implementar

1. **Configuração inicial**:  
   - Criar diretório `uploads/` com permissões de escrita  
   - Verificar se o PHP está configurado com `memory_limit` de pelo menos 256M  
   - Garantir que a extensão para hash bcrypt está habilitada  

2. **Segurança**:  
   - Alterar a senha padrão (o hash atual é para "unicondo")  
   - Configurar HTTPS para o servidor  
   - Restringir acesso ao diretório `uploads/`  

3. **Personalização**:  
   - Atualizar os tipos de profissionais conforme necessário  
   - Ajustar o design através do arquivo CSS  
   - Modificar os destinatários dos e-mails no script `enviar_email.php`  

## 📋 Fluxo de Trabalho Recomendado

1. **Login**: Acesse o sistema com as credenciais autorizadas  
2. **Preenchimento**:  
   - Informe os dados básicos (setor, cliente, solicitante)  
   - Adicione todos os equipamentos necessários  
   - Especifique os serviços de mão-de-obra  
   - Anexe o relatório técnico completo  
3. **Revisão**: Confira todas as informações no resumo antes do envio  
4. **Envio**: Finalize o processo e aguarde a confirmação  

## 🛡️ Considerações de Segurança

- **Proteção contra injeção**: Todos os inputs são sanitizados antes do processamento  
- **Proteção de sessão**: Timeout automático após 30 minutos  
- **Bloqueio de tentativas**: Sistema bloqueia após 35 tentativas falhas  
- **Proteção do cliente**: Desabilitado menu de contexto e ferramentas de desenvolvedor  

## 📈 Benefícios Esperados

- **Redução de retrabalho**: Informações completas desde o primeiro envio  
- **Padronização**: Todos seguem o mesmo formato para solicitações  
- **Transparência**: Histórico claro de todas as solicitações  
- **Eficiência**: Processo mais rápido para todas as equipes envolvidas  

## 📞 Suporte e Contato

Para dúvidas, suporte ou sugestões, entre em contato:

**Allvz Startup**  
📱 WhatsApp: [+55 11 98793-5241](https://wa.me/5511987935241)

---

**Nota**: Este sistema foi desenvolvido para otimizar a comunicação entre equipes e garantir que todas as solicitações comerciais cheguem completas e padronizadas ao setor responsável.
