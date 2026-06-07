(() => {
    const api = window.IronInvest;
    const botaoIniciar = document.querySelector("[data-perfil-iniciar]");
    const acoesHeader = document.querySelector(".header .actions");

    if (!api || (!botaoIniciar && !acoesHeader)) return;

    const perguntas = [
        {
            titulo: "Qual é o seu principal objetivo ao investir?",
            opcoes: [
                "Preservar meu patrimônio com segurança",
                "Crescer meu patrimônio de forma estável",
                "Maximizar o retorno aceitando riscos",
                "Obter altos ganhos no curto prazo"
            ]
        },
        {
            titulo: "Por quanto tempo você pretende deixar seu dinheiro investido?",
            opcoes: [
                "Menos de 1 ano",
                "De 1 a 3 anos",
                "De 3 a 5 anos",
                "Mais de 5 anos"
            ]
        },
        {
            titulo: "Se sua carteira caísse 20% em um mês, o que faria?",
            opcoes: [
                "Venderia tudo imediatamente",
                "Ficaria preocupado, mas esperaria recuperar",
                "Manteria a posição com calma",
                "Aproveitaria para comprar mais"
            ]
        },
        {
            titulo: "Qual é a sua experiência com investimentos?",
            opcoes: [
                "Nenhuma, sou iniciante",
                "Tenho poupança e Tesouro Direto",
                "Já invisto em ações e fundos",
                "Tenho experiência com derivativos e cripto"
            ]
        },
        {
            titulo: "Qual percentual da sua renda mensal você consegue investir?",
            opcoes: [
                "Menos de 5%",
                "Entre 5% e 15%",
                "Entre 15% e 30%",
                "Mais de 30%"
            ]
        },
        {
            titulo: "Como você se sentiria sabendo que pode perder parte do dinheiro investido?",
            opcoes: [
                "Não aceito perdas de forma alguma",
                "Aceito perdas pequenas, de até 5%",
                "Aceito perdas moderadas, de até 20%",
                "Aceito perdas altas em busca de ganhos maiores"
            ]
        }
    ];

    const detalhesPerfil = {
        baixo: {
            risco: "Baixo risco",
            nome: "Conservador",
            descricao: "Você prioriza segurança e estabilidade. Seu perfil combina com investimentos previsíveis e de baixa oscilação.",
            produtos: ["Tesouro Direto", "CDBs", "LCI e LCA", "Fundos DI"],
            simbolo: "✓"
        },
        medio: {
            risco: "Médio risco",
            nome: "Moderado",
            descricao: "Você busca equilíbrio entre segurança e crescimento, aceitando oscilações controladas para melhorar seus resultados.",
            produtos: ["Tesouro IPCA+", "Fundos Multimercado", "ETFs", "Fundos Imobiliários"],
            simbolo: "↗"
        },
        alto: {
            risco: "Alto risco",
            nome: "Arrojado",
            descricao: "Você busca crescimento e aceita as oscilações do mercado. Seu perfil permite explorar ativos com maior potencial de retorno.",
            produtos: ["Ações", "ETFs", "BDRs", "Fundos de Ações"],
            simbolo: "ϟ"
        }
    };

    let indiceAtual = 0;
    let respostas = Array(perguntas.length).fill(null);
    let perfilAtual = null;
    let focoAntesModal = null;
    let retomadaProcessada = false;
    let carregamentoPerfil = null;

    const modal = document.createElement("div");
    modal.className = "perfil-modal";
    modal.id = "perfilInvestidorModal";
    modal.hidden = true;
    modal.setAttribute("aria-hidden", "true");
    modal.innerHTML = `
        <div class="perfil-backdrop" data-perfil-fechar></div>
        <section class="perfil-dialog" role="dialog" aria-modal="true" aria-labelledby="perfilTitulo">
            <div class="perfil-topo">
                <img src="assets/img/Iron_logo.svg" alt="IronInvest" class="logo perfil-logo" width="90" height="34">
                <button class="perfil-fechar" type="button" aria-label="Fechar questionário" data-perfil-fechar>×</button>
            </div>
            <div class="perfil-conteudo" data-perfil-conteudo></div>
        </section>
    `;
    document.body.append(modal);

    const conteudo = modal.querySelector("[data-perfil-conteudo]");
    const botaoIndicador = document.createElement("button");
    botaoIndicador.className = "perfil-indicador";
    botaoIndicador.type = "button";
    botaoIndicador.hidden = true;
    botaoIndicador.setAttribute("aria-controls", modal.id);
    acoesHeader?.append(botaoIndicador);

    function escaparHtml(valor) {
        const elemento = document.createElement("span");
        elemento.textContent = valor;
        return elemento.innerHTML;
    }

    function limparParametroPerfil() {
        if (!window.history?.replaceState) return;

        const url = new URL(window.location.href);
        url.searchParams.delete("perfil");
        window.history.replaceState(null, "", `${url.pathname}${url.search}${url.hash}`);
    }

    function atualizarIndicador(perfil) {
        perfilAtual = perfil;

        if (!botaoIndicador || !perfil) {
            botaoIndicador.hidden = true;
            return;
        }

        const detalhes = detalhesPerfil[perfil.nivel_risco];
        if (!detalhes) {
            botaoIndicador.hidden = true;
            return;
        }

        botaoIndicador.className = `perfil-indicador perfil-indicador-${perfil.nivel_risco}`;
        botaoIndicador.innerHTML = `
            <span aria-hidden="true"></span>
            <span>
                <small>Perfil</small>
                <strong>${escaparHtml(detalhes.risco)}</strong>
            </span>
        `;
        botaoIndicador.setAttribute(
            "aria-label",
            `Perfil de investidor: ${detalhes.nome}, ${detalhes.risco}. Ver resultado.`
        );
        botaoIndicador.hidden = false;
    }

    async function carregarPerfilSalvo() {
        if (carregamentoPerfil) return carregamentoPerfil;

        carregamentoPerfil = fetch("perfil-investidor.php", {
            headers: {
                Accept: "application/json"
            },
            credentials: "same-origin"
        })
            .then(async (resposta) => {
                if (resposta.status === 401) {
                    atualizarIndicador(null);
                    return null;
                }

                if (!resposta.ok) return null;

                const dados = await resposta.json().catch(() => ({}));
                atualizarIndicador(dados.perfil || null);
                return dados.perfil || null;
            })
            .catch(() => null)
            .finally(() => {
                carregamentoPerfil = null;
            });

        return carregamentoPerfil;
    }

    function abrirModal(mostrarResultado = false) {
        focoAntesModal = document.activeElement;
        modal.hidden = false;
        modal.setAttribute("aria-hidden", "false");
        document.body.classList.add("perfil-modal-aberto");

        if (mostrarResultado && perfilAtual) {
            renderizarResultado(perfilAtual);
        } else {
            indiceAtual = 0;
            respostas = Array(perguntas.length).fill(null);
            renderizarPergunta();
        }

        modal.querySelector(".perfil-fechar")?.focus();
    }

    function fecharModal() {
        if (modal.hidden) return;

        modal.hidden = true;
        modal.setAttribute("aria-hidden", "true");
        document.body.classList.remove("perfil-modal-aberto");

        if (focoAntesModal instanceof HTMLElement) {
            focoAntesModal.focus();
        }
    }

    function manterFocoNoModal(evento) {
        if (evento.key !== "Tab" || modal.hidden) return;

        const controles = Array.from(
            modal.querySelectorAll('button:not([disabled]), [href], input:not([disabled]), [tabindex]:not([tabindex="-1"])')
        ).filter((controle) =>
            controle instanceof HTMLElement &&
            !controle.hidden &&
            controle.getClientRects().length > 0
        );

        if (controles.length === 0) return;

        const primeiro = controles[0];
        const ultimo = controles[controles.length - 1];

        if (evento.shiftKey && document.activeElement === primeiro) {
            evento.preventDefault();
            ultimo.focus();
        } else if (!evento.shiftKey && document.activeElement === ultimo) {
            evento.preventDefault();
            primeiro.focus();
        }
    }

    function renderizarPergunta() {
        const pergunta = perguntas[indiceAtual];
        const respostaAtual = respostas[indiceAtual];

        conteudo.innerHTML = `
            <div class="perfil-etapa-topo">
                <button class="perfil-voltar" type="button" aria-label="Voltar à pergunta anterior" data-perfil-voltar ${indiceAtual === 0 ? "hidden" : ""}>‹</button>
                <span>Perfil de investidor</span>
                <small>${indiceAtual + 1} de ${perguntas.length}</small>
            </div>
            <div class="perfil-progresso" data-progresso="${indiceAtual + 1}" aria-hidden="true">
                <span></span>
            </div>
            <h2 id="perfilTitulo">${escaparHtml(pergunta.titulo)}</h2>
            <fieldset class="perfil-opcoes">
                <legend class="sr-only">${escaparHtml(pergunta.titulo)}</legend>
                ${pergunta.opcoes.map((opcao, indice) => `
                    <label class="perfil-opcao ${respostaAtual === indice ? "selecionada" : ""}">
                        <input type="radio" name="perfil-resposta" value="${indice}" ${respostaAtual === indice ? "checked" : ""}>
                        <span class="perfil-radio" aria-hidden="true"></span>
                        <span>${escaparHtml(opcao)}</span>
                    </label>
                `).join("")}
            </fieldset>
            <button class="perfil-proximo" type="button" data-perfil-proximo ${respostaAtual === null ? "disabled" : ""}>
                ${indiceAtual === perguntas.length - 1 ? "Ver meu perfil" : "Próxima pergunta"}
                <span aria-hidden="true">→</span>
            </button>
            <p class="perfil-status" role="status" aria-live="polite"></p>
        `;
    }

    function renderizarResultado(perfil) {
        const detalhes = detalhesPerfil[perfil.nivel_risco] || detalhesPerfil.medio;

        conteudo.innerHTML = `
            <div class="perfil-resultado perfil-resultado-${perfil.nivel_risco}">
                <div class="perfil-resultado-faixa">
                    <span class="perfil-resultado-icone" aria-hidden="true">${detalhes.simbolo}</span>
                    <div>
                        <small>Seu perfil de investidor é</small>
                        <h2 id="perfilTitulo">${escaparHtml(detalhes.nome)}</h2>
                        <strong>${escaparHtml(detalhes.risco)}</strong>
                    </div>
                </div>
                <p>${escaparHtml(detalhes.descricao)}</p>
                <div class="perfil-recomendacoes">
                    <h3><span aria-hidden="true">✓</span> Produtos recomendados para você</h3>
                    <ul>
                        ${detalhes.produtos.map((produto) => `<li>${escaparHtml(produto)}</li>`).join("")}
                    </ul>
                </div>
                <div class="perfil-resultado-acoes">
                    <button class="perfil-comecar" type="button" data-perfil-explorar-produtos>
                        Começar a investir <span aria-hidden="true">→</span>
                    </button>
                    <button class="perfil-explorar" type="button" data-perfil-fechar>
                        Explorar plataforma
                    </button>
                </div>
                <p class="perfil-refazer">Você pode refazer o teste a qualquer momento pelo botão “Começar a Investir”.</p>
            </div>
        `;
    }

    async function salvarPerfil() {
        const botao = conteudo.querySelector("[data-perfil-proximo]");
        const status = conteudo.querySelector(".perfil-status");

        botao?.setAttribute("disabled", "");
        if (status) status.textContent = "Calculando seu perfil...";

        try {
            const token = await api.obterCsrfToken();
            if (!token) throw new Error("csrf");

            const formulario = new FormData();
            formulario.set("csrf_token", token);
            formulario.set("respostas", JSON.stringify(respostas));

            const resposta = await fetch("perfil-investidor.php", {
                method: "POST",
                body: formulario,
                headers: {
                    Accept: "application/json"
                },
                credentials: "same-origin"
            });
            const dados = await resposta.json().catch(() => ({}));

            if (resposta.status === 401) {
                fecharModal();
                api.definirDestinoLogin("index.html?perfil=questionario");
                api.abrirLogin();
                return;
            }

            if (!resposta.ok || !dados.perfil) {
                throw new Error(dados.erro || "salvar");
            }

            atualizarIndicador(dados.perfil);
            renderizarResultado(dados.perfil);
        } catch (erro) {
            if (status) {
                status.textContent = erro.message && erro.message !== "salvar" && erro.message !== "csrf"
                    ? erro.message
                    : "Não foi possível salvar seu perfil agora. Tente novamente.";
            }
            botao?.removeAttribute("disabled");
        }
    }

    async function solicitarQuestionario() {
        const sessao = await api.carregarSessao();

        if (!sessao?.logado) {
            api.definirDestinoLogin("index.html?perfil=questionario");
            api.abrirLogin();

            const statusLogin = document.querySelector(".login-status");
            if (statusLogin) {
                statusLogin.textContent = "Faça login para responder ao questionário de perfil.";
            }
            return;
        }

        abrirModal(false);
    }

    async function tratarSessao(sessao) {
        if (!sessao?.logado) {
            atualizarIndicador(null);
            return;
        }

        await carregarPerfilSalvo();

        if (
            !retomadaProcessada
            && new URLSearchParams(window.location.search).get("perfil") === "questionario"
        ) {
            retomadaProcessada = true;
            limparParametroPerfil();
            abrirModal(false);
        }
    }

    botaoIniciar?.addEventListener("click", () => {
        void solicitarQuestionario();
    });

    botaoIndicador.addEventListener("click", () => {
        abrirModal(Boolean(perfilAtual));
    });

    modal.addEventListener("change", (evento) => {
        const campo = evento.target.closest('input[name="perfil-resposta"]');
        if (!campo) return;

        respostas[indiceAtual] = Number(campo.value);
        renderizarPergunta();
        conteudo.querySelector("[data-perfil-proximo]")?.focus();
    });

    modal.addEventListener("click", (evento) => {
        if (evento.target.closest("[data-perfil-fechar]")) {
            fecharModal();
            return;
        }

        if (evento.target.closest("[data-perfil-voltar]")) {
            indiceAtual = Math.max(indiceAtual - 1, 0);
            renderizarPergunta();
            return;
        }

        if (evento.target.closest("[data-perfil-proximo]")) {
            if (respostas[indiceAtual] === null) return;

            if (indiceAtual < perguntas.length - 1) {
                indiceAtual += 1;
                renderizarPergunta();
                return;
            }

            void salvarPerfil();
            return;
        }

        if (evento.target.closest("[data-perfil-explorar-produtos]")) {
            fecharModal();

            const produtos = document.getElementById("produtos");
            if (produtos) {
                produtos.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        }
    });

    document.addEventListener("keydown", (evento) => {
        if (evento.key === "Escape") {
            fecharModal();
            return;
        }

        manterFocoNoModal(evento);
    });

    document.addEventListener("ironinvest:sessao", (evento) => {
        void tratarSessao(evento.detail);
    });

    void api.carregarSessao().then(tratarSessao);
})();
