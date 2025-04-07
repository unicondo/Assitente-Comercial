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