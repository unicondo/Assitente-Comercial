<?php
// Configurações iniciais
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '256M');
session_start();

// Configuração da senha (hash para "unicondo")
$senha_correta = '$2y$10$fCacVbnAk6m7zsQJ0dKPt.xlgYAba5g8ZsBVOi4uJvLIT0Vgi.0TW';

// Verificar autenticação
if (!isset($_SESSION['logado'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha'])) {
        if (password_verify($_POST['senha'], $senha_correta)) {
            $_SESSION['logado'] = true;
            $_SESSION['ultima_atividade'] = time();
            $_SESSION['tentativas_login'] = 0;
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } else {
            $_SESSION['tentativas_login'] = ($_SESSION['tentativas_login'] ?? 0) + 1;
            $erro_login = "Senha incorreta. Tente novamente.";
            
            if ($_SESSION['tentativas_login'] >= 35) {
                $erro_login = "Acesso bloqueado. Tente novamente mais tarde.";
                sleep(2);
            }
        }
    }
    
    // Exibir formulário de login se não autenticado
    if (!isset($_SESSION['logado'])) {
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Assistente Comercial</title>
            <link rel="stylesheet" href="https://unicondo.app/api/client/dmsys/project/commercial-assistant/assets/css/root.css">
            <link rel="stylesheet" href="https://unicondo.app/api/client/dmsys/project/commercial-assistant/assets/css/style.css">
        </head>
        <body>
            <div class="login-container">
                <div class="logo"><center><dotlottie-player
  src="https://lottie.host/9b4a348e-8139-420d-83dd-9c92a17193f5/RpeYIo8A8E.lottie"
  background="transparent"
  speed="1"
  style="width: 150px; height: 150px"
  loop
  autoplay
></dotlottie-player></center></div>
                <h3 class="text-center mb-4"><div id="saudacao" class="saudacao"></div>
        <p>Estou aqui para te ajudar com vendas, orçamentos e suporte comercial! 💼</p></h3>
                
                <?php if (isset($erro_login)): ?>
                    <div class="alert"><?php echo htmlspecialchars($erro_login, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3 password-container">
                        <label for="senha" class="form-label">Insira sua senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required autofocus>
                        <span class="toggle-password" onclick="togglePassword()"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Acessar</button>
                </form>
            </div>
             <script>
        const horaAtual = new Date().getHours();
        const elemento = document.getElementById('saudacao');
        let periodo;
        
        if (horaAtual >= 5 && horaAtual < 12) {
            periodo = "Bom dia";
        } else if (horaAtual >= 12 && horaAtual < 18) {
            periodo = "Boa tarde";
        } else {
            periodo = "Boa noite";
        }
        
        elemento.innerHTML = `${periodo}! Eu sou seu novo Assistente Comercial <span class="emoji">👋</span>`;
    </script>
            <script>
                function togglePassword() {
                    const passwordField = document.getElementById('senha');
                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                    } else {
                        passwordField.type = 'password';
                    }
                }
                
                document.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                });
                
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'F12' || 
                        (e.ctrlKey && e.shiftKey && e.key === 'I') || 
                        (e.ctrlKey && e.shiftKey && e.key === 'J') || 
                        (e.ctrlKey && e.key === 'U')) {
                        e.preventDefault();
                    }
                });
            </script>
            <script
  src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs"
  type="module"
></script>
        </body>
        </html>
        <?php
        exit();
    }
}

// Verificar inatividade (30 minutos)
if (isset($_SESSION['ultima_atividade']) && (time() - $_SESSION['ultima_atividade'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
$_SESSION['ultima_atividade'] = time();

// Configurações do upload
$upload_dir = 'uploads/';
if (!file_exists($upload_dir)) {
    if (!mkdir($upload_dir, 0755, true)) {
        die("Falha ao criar diretório de uploads");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistente Comercial</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #121212; color: #ffffff; }
        .container { max-width: 900px; margin: auto; padding: 20px; }
        .btn { margin-top: 10px; }
        .card { background-color: #1e1e1e; border: 1px solid #333; padding: 20px; }
        .form-control, .form-select { background-color: #2a2a2a; color: #ffffff; border: 1px solid #444; }
        .form-control::placeholder, .form-select::placeholder { color: #f0f0f0; }
        h2, h3, label { color: #ffffff; }
        .row > div { margin-bottom: 15px; }
        .w-100 { width: 100%; }
        .uppercase { text-transform: uppercase; }
        .servico-container { margin-bottom: 15px; border-bottom: 1px solid #333; padding-bottom: 15px; }
        .profissional-container { margin-bottom: 15px; padding: 10px; background-color: #252525; border-radius: 5px; }
        .profissionais-container { margin-top: 10px; }
        .btn-info {
            background-color: color-mix(in oklab, #fb6464 10%, transparent);
            color: rgb(251 100 100);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-info:hover {
            background-color: color-mix(in oklab, #fb6464 50%, transparent);
            color: #fff;
        }
        .btn-info:active {
            background-color: color-mix(in oklab, #fb6464 70%, transparent);
            color: #fff;
        }
        .btn-primary {
            background-color: color-mix(in oklab, #9ae600 10%, transparent);
            color: #bbf451;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: color-mix(in oklab, #9ae600 50%, transparent);
            color: #fff;
        }
        .btn-primary:active {
            background-color: color-mix(in oklab, #9ae600 70%, transparent);
            color: #fff;
        }
        .progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: #333;
            z-index: 1000;
        }
        .progress-bar {
            height: 5px;
            width: 0;
            background: blue;
        }
        .onboarding-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            z-index: 2000;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .onboarding-content {
            background: #1e1e1e;
            border-radius: 7px;
            border: 1px solid #333;
            padding: 25px;
            color: #fff;
            max-width: 600px;
            width: 90%;
            text-align: center;
        }
        .onboarding-buttons {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
        }
        .onboarding-progress {
            margin-top: 15px;
            height: 5px;
            background: #333;
            border-radius: 5px;
            overflow: hidden;
        }
        .onboarding-progress-bar {
            height: 100%;
            background: blue;
            width: 0%;
            transition: width 0.3s;
        }
        .periodo-dia-total {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .periodo-dia-total > div {
            flex: 1;
            min-width: 150px;
        }
        @media (max-width: 768px) {
            .periodo-dia-total > div {
                flex: 100%;
            }
        }
        .tabela-resumo {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #1e1e1e;
            color: white;
        }
        .tabela-resumo th, .tabela-resumo td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }
        .tabela-resumo th {
            background-color: #333;
        }
        .tabela-resumo tr:nth-child(even) {
            background-color: #252525;
        }
        .modal-confirmacao {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            z-index: 3000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 5px;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
        }
        .spinner-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 4000;
            justify-content: center;
            align-items: center;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>
    
    <div class="spinner-container" id="spinner">
        <div class="spinner"></div>
    </div>
    
    <div class="container">
        <h2 class="text-center">Solicitação de Proposta Comercial</h2>
        <div class="card mb-3">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label" data-bs-toggle="tooltip" title="Escolha o setor responsável pela solicitação">Setor:</label>
                    <select id="setor" class="form-select">
                        <option value="Contrato">Contrato</option>
                        <option value="Implantação">Implantação</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" data-bs-toggle="tooltip" title="Informe o nome do cliente">Cliente (Obrigatório):</label>
                    <input type="text" id="cliente" class="form-control" placeholder="Nome do Cliente" required>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label" data-bs-toggle="tooltip" title="Informe o nome do solicitante">Nome do Solicitante (Obrigatório):</label>
                    <input type="text" id="solicitante" class="form-control w-100" placeholder="Nome do Solicitante" required>
                </div>
            </div>
        </div>

        <div class="card mb-3" id="equipamentos">
            <h3>Equipamentos</h3>
            <div class="equipamento-container">
                <div class="equipamento row">
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Nome do equipamento">Nome (Obrigatório):</label>
                        <input type="text" class="form-control nome-equipamento" placeholder="Nome do Equipamento" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Modelo do equipamento">Modelo:</label>
                        <input type="text" class="form-control modelo" placeholder="Modelo">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Marca do equipamento">Marca:</label>
                        <input type="text" class="form-control marca" placeholder="Marca">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Quantidade de unidades">Quantidade (Obrigatório):</label>
                        <input type="number" class="form-control quantidade" placeholder="Quantidade" min="1" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" data-bs-toggle="tooltip" title="Especificações técnicas do equipamento">Especificações (Obrigatório):</label>
                        <textarea class="form-control especificacoes" placeholder="Especificações Técnicas" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Se for cabo, informe a metragem">Metragem do Cabo (se aplicável):</label>
                        <input type="number" class="form-control metragem" placeholder="Metros">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Tipo de cabo">Tipo de Cabo:</label>
                        <input type="text" class="form-control tipo-cabo" placeholder="Tipo de Cabo">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Número de vias">Número de Vias:</label>
                        <input type="number" class="form-control numero-vias" placeholder="Número de Vias">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Cor do cabo">Cor:</label>
                        <input type="text" class="form-control cor" placeholder="Cor">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Blindado?">Blindado?</label>
                        <select class="form-select blindado">
                            <option value="Sim">Sim</option>
                            <option value="Não">Não</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button class="btn btn-info w-100" onclick="removerEquipamento(this)">Remover</button>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary mt-3" id="btn-adicionar-equipamento" onclick="adicionarEquipamento()">Adicionar Equipamento</button>
        </div>

        <div class="card mb-3" id="mao-de-obra">
            <h3>Mão-de-Obra</h3>
            <div class="servicos-container">
                <div class="servico-container">
                    <div class="profissionais-container">
                        <div class="profissional-container">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Quantidade de Profissionais:</label>
                                    <select class="form-select quantidade-profissionais">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Profissional:</label>
                                    <select class="form-select tipo-profissional">
                                        <option value="GERENTE DE ENGENHARIA - ENGENHEIRO">GERENTE DE ENGENHARIA - ENGENHEIRO</option>
                                        <option value="COORDENADOR DE INSTALAÇÕES">COORDENADOR DE INSTALAÇÕES</option>
                                        <option value="SUPERVISOR DE INSTALAÇÕES">SUPERVISOR DE INSTALAÇÕES</option>
                                        <option value="TÉCNICO DE AUTOMAÇÃO III">TÉCNICO DE AUTOMAÇÃO III</option>
                                        <option value="TÉCNICO DE AUTOMAÇÃO II">TÉCNICO DE AUTOMAÇÃO II</option>
                                        <option value="TÉCNICO DE AUTOMAÇÃO I">TÉCNICO DE AUTOMAÇÃO I</option>
                                        <option value="TÉCNICO DE TELECOM III">TÉCNICO DE TELECOM III</option>
                                        <option value="TÉCNICO DE TELECOM II">TÉCNICO DE TELECOM II</option>
                                        <option value="TÉCNICO DE TELECOM I">TÉCNICO DE TELECOM I</option>
                                        <option value="INSTALADOR III">INSTALADOR III</option>
                                        <option value="INSTALADOR II">INSTALADOR II</option>
                                        <option value="INSTALADOR I">INSTALADOR I</option>
                                        <option value="TÉCNICO DE INSTALAÇÕES III">TÉCNICO DE INSTALAÇÕES III</option>
                                        <option value="TÉCNICO DE INSTALAÇÕES II">TÉCNICO DE INSTALAÇÕES II</option>
                                        <option value="TÉCNICO DE INSTALAÇÕES I">TÉCNICO DE INSTALAÇÕES I</option>
                                        <option value="AUXILIAR DE INSTALAÇÕES III">AUXILIAR DE INSTALAÇÕES III</option>
                                        <option value="AUXILIAR DE INSTALAÇÕES II">AUXILIAR DE INSTALAÇÕES II</option>
                                        <option value="AUXILIAR DE INSTALAÇÕES I">AUXILIAR DE INSTALAÇÕES I</option>
                                        <option value="PEDREIRO">PEDREIRO</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-info btn-sm mt-2 w-100" onclick="removerProfissional(this)">Remover Profissional</button>
                        </div>
                    </div>
                    
                    <div class="periodo-dia-total mt-3">
                        <div>
                            <label class="form-label">Período do Serviço:</label>
                            <select class="form-select periodo-servico">
                                <option value="Diurno">Diurno</option>
                                <option value="Noturno">Noturno</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Dia do Serviço:</label>
                            <select class="form-select dia-servico">
                                <option value="Dia útil">Dia útil</option>
                                <option value="Fim de semana">Fim de semana</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Total em dias:</label>
                            <input type="number" class="form-control total-dias" placeholder="Dias" min="1" value="1">
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="form-label">Descrição do Serviço:</label>
                            <input type="text" class="form-control servico" placeholder="Descrição do Serviço">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button class="btn btn-primary w-100" onclick="adicionarProfissional(this)">Adicionar Profissional</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info w-100" onclick="removerServico(this)">Remover Serviço</button>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary mt-3" onclick="adicionarServico()">Adicionar Serviço</button>
        </div>

        <div class="card mb-3">
            <label class="form-label" data-bs-toggle="tooltip" title="Anexe o relatório técnico da visita">Relatório Técnico (Obrigatório):</label>
            <input type="file" class="form-control" id="relatorio" required>
            <small class="form-text text-white">O relatório técnico deve incluir imagens claras e de boa qualidade, preferencialmente com boa iluminação, para garantir a precisão das informações.</small>
        </div>

        <button class="btn btn-success w-100" onclick="enviarSolicitacao()">Enviar Solicitação</button>
    </div>

    <div id="modalConfirmacao" class="modal-confirmacao">
        <div class="modal-content">
            <h3 class="text-center mb-4">Confirmação de Proposta</h3>
            <div id="resumoProposta"></div>
            <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-secondary" onclick="fecharModal()">Voltar e Editar</button>
                <button class="btn btn-success" onclick="confirmarEnvio()">Confirmar e Enviar</button>
            </div>
        </div>
    </div>

    <div id="onboardingModal" class="onboarding-modal">
        <div class="onboarding-content">
            <h3 id="onboarding-title">Bem-vindo ao Formulário de Solicitação</h3>
            <p id="onboarding-text">Vamos guiá-lo através do processo de preenchimento deste formulário. Clique em "Próximo" para continuar.</p>
            <div class="onboarding-progress">
                <div id="onboarding-progress-bar" class="onboarding-progress-bar"></div>
            </div>
            <div class="onboarding-buttons">
                <button id="onboarding-back" class="btn btn-secondary" disabled>Voltar</button>
                <div>
                    <button id="onboarding-skip" class="btn btn-info">Pular</button>
                    <button id="onboarding-next" class="btn btn-primary ms-2">Próximo</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variáveis globais
        let relatorioLink = '';
        let relatorioNome = '';
        
        // Funções para equipamentos
        function adicionarEquipamento() {
            let equipamentoContainer = document.querySelector(".equipamento-container");
            let div = document.createElement("div");
            div.classList.add("equipamento", "row", "mt-3");
            div.innerHTML = document.querySelector(".equipamento").innerHTML;
            equipamentoContainer.appendChild(div);
            
            // Move o botão para o final
            document.getElementById("equipamentos").appendChild(document.getElementById("btn-adicionar-equipamento"));
        }

        function removerEquipamento(button) {
            let equipamentos = document.querySelectorAll(".equipamento");
            if (equipamentos.length > 1) {
                button.closest(".equipamento").remove();
            } else {
                alert("Você não pode remover o último equipamento.");
            }
        }

        // Funções para serviços e profissionais
        function adicionarServico() {
            let servicosContainer = document.querySelector(".servicos-container");
            let novoServico = document.createElement("div");
            novoServico.classList.add("servico-container");
            novoServico.innerHTML = document.querySelector(".servico-container").innerHTML;
            servicosContainer.appendChild(novoServico);
        }

        function removerServico(button) {
            let servicos = document.querySelectorAll(".servico-container");
            if (servicos.length > 1) {
                button.closest(".servico-container").remove();
            } else {
                alert("Você não pode remover o último serviço.");
            }
        }

        function adicionarProfissional(button) {
            let servicoContainer = button.closest(".servico-container");
            let profissionaisContainer = servicoContainer.querySelector(".profissionais-container");
            let novoProfissional = document.createElement("div");
            novoProfissional.classList.add("profissional-container");
            
            // Clone o primeiro profissional e limpa os valores
            let primeiroProfissional = servicoContainer.querySelector(".profissional-container");
            novoProfissional.innerHTML = primeiroProfissional.innerHTML;
            
            // Reseta os valores selecionados
            novoProfissional.querySelector(".quantidade-profissionais").value = "1";
            novoProfissional.querySelector(".tipo-profissional").value = "GERENTE DE ENGENHARIA - ENGENHEIRO";
            
            profissionaisContainer.appendChild(novoProfissional);
        }

        function removerProfissional(button) {
            let profissionais = button.closest(".profissionais-container").querySelectorAll(".profissional-container");
            if (profissionais.length > 1) {
                button.closest(".profissional-container").remove();
            } else {
                alert("Você não pode remover o último profissional do serviço.");
            }
        }

        // Função para mostrar o modal de confirmação
        function mostrarModal() {
            document.getElementById("modalConfirmacao").style.display = "flex";
        }

        // Função para fechar o modal
        function fecharModal() {
            document.getElementById("modalConfirmacao").style.display = "none";
        }

        // Função para mostrar o spinner de carregamento
        function mostrarSpinner() {
            document.getElementById("spinner").style.display = "flex";
        }

        // Função para esconder o spinner de carregamento
        function esconderSpinner() {
            document.getElementById("spinner").style.display = "none";
        }

        // Função para gerar o resumo da proposta
        function gerarResumoProposta() {
            // Coletar dados básicos
            const setor = document.getElementById("setor").value;
            const cliente = document.getElementById("cliente").value;
            const solicitante = document.getElementById("solicitante").value;
            const relatorio = document.getElementById("relatorio").files[0];
            
            // Gerar tabela de equipamentos
            let tabelaEquipamentos = "<h4>Equipamentos</h4><table class='tabela-resumo'><tr><th>Nome</th><th>Modelo</th><th>Marca</th><th>Quantidade</th><th>Especificações</th></tr>";
            
            document.querySelectorAll(".equipamento").forEach(equip => {
                tabelaEquipamentos += `<tr>
                    <td>${equip.querySelector(".nome-equipamento").value || '-'}</td>
                    <td>${equip.querySelector(".modelo").value || '-'}</td>
                    <td>${equip.querySelector(".marca").value || '-'}</td>
                    <td>${equip.querySelector(".quantidade").value || '-'}</td>
                    <td>${equip.querySelector(".especificacoes").value || '-'}</td>
                </tr>`;
            });
            tabelaEquipamentos += "</table>";

            // Gerar tabela de serviços
            let tabelaServicos = "<h4>Serviços</h4><table class='tabela-resumo'><tr><th>Profissionais</th><th>Tipo</th><th>Período</th><th>Dia</th><th>Total Dias</th><th>Descrição</th></tr>";
            
            document.querySelectorAll(".servico-container").forEach(servico => {
                const periodo = servico.querySelector(".periodo-servico").value;
                const dia = servico.querySelector(".dia-servico").value;
                const totalDias = servico.querySelector(".total-dias").value;
                const descricao = servico.querySelector(".servico").value;
                
                // Adicionar cada profissional do serviço
                servico.querySelectorAll(".profissional-container").forEach(prof => {
                    const qtd = prof.querySelector(".quantidade-profissionais").value;
                    const tipo = prof.querySelector(".tipo-profissional").value;
                    
                    tabelaServicos += `<tr>
                        <td>${qtd}</td>
                        <td>${tipo}</td>
                        <td>${periodo}</td>
                        <td>${dia}</td>
                        <td>${totalDias}</td>
                        <td>${descricao}</td>
                    </tr>`;
                });
            });
            tabelaServicos += "</table>";

            // Criar o conteúdo do resumo
            const resumo = `
                <p><strong>Setor:</strong> ${setor}</p>
                <p><strong>Cliente:</strong> ${cliente}</p>
                <p><strong>Solicitante:</strong> ${solicitante}</p>
                ${tabelaEquipamentos}
                ${tabelaServicos}
                <p><strong>Relatório Técnico:</strong> ${relatorio ? relatorio.name : 'Não anexado'}</p>
            `;

            // Inserir o resumo no modal
            document.getElementById("resumoProposta").innerHTML = resumo;
        }

        // Função para enviar o arquivo para o servidor
        async function enviarArquivoParaServidor(arquivo) {
            mostrarSpinner();
            const formData = new FormData();
            formData.append('relatorio', arquivo);
            
            try {
                const response = await fetch('upload.php', {
                    method: 'POST',
                    body: formData
                });
                
                if (!response.ok) {
                    throw new Error('Erro ao enviar arquivo');
                }
                
                const data = await response.json();
                
                if (data.success && data.filePath) {
                    relatorioLink = data.filePath;
                    relatorioNome = data.fileName;
                    return true;
                } else {
                    throw new Error(data.message || 'Erro no servidor');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao enviar arquivo: ' + error.message);
                return false;
            } finally {
                esconderSpinner();
            }
        }

        // Função para enviar solicitação
        async function enviarSolicitacao() {
            // Validar campos obrigatórios
            const cliente = document.getElementById("cliente").value;
            const solicitante = document.getElementById("solicitante").value;
            const relatorio = document.getElementById("relatorio").files[0];
            
            if (!cliente || !solicitante || !relatorio) {
                alert("Por favor, preencha todos os campos obrigatórios!");
                return;
            }

            // Enviar arquivo primeiro
            const arquivoEnviado = await enviarArquivoParaServidor(relatorio);
            
            if (arquivoEnviado) {
                // Gerar e mostrar o resumo
                gerarResumoProposta();
                mostrarModal();
            }
        }

        // Função para confirmar o envio (chamada após o upload do arquivo)
        function confirmarEnvio() {
            enviarEmail();
        }

        // Função para enviar o email
        async function enviarEmail() {
            const setor = document.getElementById("setor").value;
            const cliente = document.getElementById("cliente").value;
            const solicitante = document.getElementById("solicitante").value;
            
            // Criar o assunto do email
            const assunto = `Proposta Comercial do ${setor} para ${cliente} - ${solicitante}`;
            
            // Pegar o conteúdo do resumo
            const corpoEmail = document.getElementById("resumoProposta").innerHTML;
            
            // Dados para enviar ao servidor
            const formData = new FormData();
            formData.append('assunto', assunto);
            formData.append('corpo_email', corpoEmail);
            if (relatorioLink) {
                formData.append('caminho_relatorio', relatorioLink);
                formData.append('nome_arquivo', relatorioNome);
            }
            
            // Mostrar spinner
            mostrarSpinner();
            
            try {
                const response = await fetch('enviar_email.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Proposta enviada com sucesso!');
                    fecharModal();
                    // Limpar formulário ou redirecionar se necessário
                } else {
                    alert('Erro ao enviar proposta: ' + data.message);
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao enviar proposta. Por favor, tente novamente.');
            } finally {
                esconderSpinner();
            }
        }

        // Barra de progresso
        window.onscroll = function() {
            var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("progressBar").style.width = scrolled + "%";
        };

        // Onboarding Modal
        document.addEventListener("DOMContentLoaded", function () {
            const onboardingSteps = [
                { 
                    title: "Bem-vindo ao Formulário de Solicitação", 
                    text: "Este formulário permite solicitar propostas comerciais para equipamentos e serviços. Vamos guiá-lo através do processo de preenchimento." 
                },
                { 
                    title: "Informações Básicas", 
                    text: "Comece preenchendo as informações básicas: Setor, Cliente e Nome do Solicitante. Estes campos são essenciais para identificar a solicitação." 
                },
                { 
                    title: "Equipamentos", 
                    text: "Na seção de Equipamentos, adicione todos os itens necessários. Para cada equipamento, preencha nome, modelo, marca, quantidade e especificações técnicas." 
                },
                { 
                    title: "Adicionando Mais Equipamentos", 
                    text: "Se precisar adicionar mais equipamentos, clique no botão 'Adicionar Equipamento'. Você pode remover itens clicando no botão 'Remover' de cada equipamento." 
                },
                { 
                    title: "Mão-de-Obra", 
                    text: "Na seção de Mão-de-Obra, adicione os serviços necessários. Para cada serviço, especifique os profissionais, período de trabalho e dias necessários." 
                },
                { 
                    title: "Profissionais", 
                    text: "Para cada serviço, você pode adicionar diferentes tipos de profissionais. Selecione a quantidade e o tipo de profissional necessário para cada tarefa." 
                },
                { 
                    title: "Detalhes do Serviço", 
                    text: "Especifique o período (Diurno/Noturno), dia (Útil/Fim de semana) e total de dias para cada serviço. Não se esqueça de adicionar uma descrição clara do serviço." 
                },
                { 
                    title: "Adicionando Mais Serviços", 
                    text: "Se sua proposta incluir mais de um serviço, clique em 'Adicionar Serviço' para incluir novas atividades. Cada serviço pode ter sua própria configuração de profissionais." 
                },
                { 
                    title: "Relatório Técnico", 
                    text: "Anexe o relatório técnico obrigatório. Este documento deve conter informações detalhadas e imagens claras para avaliação da proposta." 
                },
                { 
                    title: "Envio da Solicitação", 
                    text: "Após preencher todos os campos necessários, clique em 'Enviar Solicitação'. Você poderá revisar todas as informações antes do envio final." 
                },
                { 
                    title: "Pronto para Começar!", 
                    text: "Agora você está pronto para preencher o formulário. Se precisar de ajuda, consulte este guia novamente ou entre em contato com o suporte." 
                }
            ];

            const modal = document.getElementById('onboardingModal');
            const titleElement = document.getElementById('onboarding-title');
            const textElement = document.getElementById('onboarding-text');
            const backButton = document.getElementById('onboarding-back');
            const nextButton = document.getElementById('onboarding-next');
            const skipButton = document.getElementById('onboarding-skip');
            const progressBar = document.getElementById('onboarding-progress-bar');

            let currentStep = 0;

            function updateModal() {
                titleElement.textContent = onboardingSteps[currentStep].title;
                textElement.textContent = onboardingSteps[currentStep].text;
                
                // Atualizar progresso
                const progress = ((currentStep + 1) / onboardingSteps.length) * 100;
                progressBar.style.width = `${progress}%`;
                
                // Atualizar botões
                backButton.disabled = currentStep === 0;
                nextButton.textContent = currentStep === onboardingSteps.length - 1 ? 'Finalizar' : 'Próximo';
            }

            function nextStep() {
                if (currentStep < onboardingSteps.length - 1) {
                    currentStep++;
                    updateModal();
                } else {
                    modal.style.display = 'none';
                }
            }

            function prevStep() {
                if (currentStep > 0) {
                    currentStep--;
                    updateModal();
                }
            }

            // Event listeners
            nextButton.addEventListener('click', nextStep);
            backButton.addEventListener('click', prevStep);
            skipButton.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            // Iniciar o onboarding
            updateModal();
        });
    </script>
</body>
</html>