(() => {
    const seletor = {
        menuToggle: ".menu-toggle",
        investimento: ".tipo-investimento",
        atalhoValor: ".atalhos-valor",
        valor: "#valor",
        prazo: "#prazo",
        valorFinal: "#valorFinal",
        valorInvestido: "#valorInvestido",
        rendimento: "#rendimento",
        prazoValor: "#prazoValor",
        taxaResumo: "#taxaResumo",
        rentabilidade: "#rentabilidade",
        carrossel: "[data-carousel]",
        carrosselTrack: "[data-carousel-track]",
        carrosselAnterior: "[data-carousel-prev]",
        carrosselProximo: "[data-carousel-next]",
        carrosselPontos: "[data-carousel-dots]",
        newsletter: ".newsletter-form",
        busca: ".suporte-busca",
        temaBotao: ".theme-btn",
        temaIcone: ".theme-btn img"
    };

    const moeda = new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL"
    });

    const elementos = {
        menuToggle: document.querySelector(seletor.menuToggle),
        menu: document.getElementById("main-menu"),
        investimento: document.querySelector(seletor.investimento),
        atalhoValor: document.querySelector(seletor.atalhoValor),
        valor: document.querySelector(seletor.valor),
        prazo: document.querySelector(seletor.prazo),
        valorFinal: document.querySelector(seletor.valorFinal),
        valorInvestido: document.querySelector(seletor.valorInvestido),
        rendimento: document.querySelector(seletor.rendimento),
        prazoValor: document.querySelector(seletor.prazoValor),
        taxaResumo: document.querySelector(seletor.taxaResumo),
        rentabilidade: document.querySelector(seletor.rentabilidade),
        carrossel: document.querySelector(seletor.carrossel),
        carrosselTrack: document.querySelector(seletor.carrosselTrack),
        carrosselAnterior: document.querySelector(seletor.carrosselAnterior),
        carrosselProximo: document.querySelector(seletor.carrosselProximo),
        carrosselPontos: document.querySelector(seletor.carrosselPontos),
        newsletter: document.querySelector(seletor.newsletter),
        busca: document.querySelector(seletor.busca),
        temaBotao: document.querySelector(seletor.temaBotao),
        temaIcone: document.querySelector(seletor.temaIcone)
    };

    const chaveTema = "ironinvest-theme";
    const iconeLua = "imagens/lua_16_x_16.png";
    const iconeSol = "imagens/brightness_9253338.png";
    let taxaMensal = 0.0115;

    const formatarMoeda = (valor) => moeda.format(valor);
    const textoMeses = (meses) => meses === 1 ? "1 mês" : `${meses} meses`;

    function definirTema(tema, salvar = true) {
        const escuro = tema === "dark";
        document.documentElement.dataset.theme = escuro ? "dark" : "light";

        elementos.temaBotao?.setAttribute("aria-pressed", String(escuro));
        elementos.temaBotao?.setAttribute("aria-label", escuro ? "Ativar modo claro" : "Ativar modo escuro");

        if (elementos.temaIcone) {
            elementos.temaIcone.src = escuro ? iconeSol : iconeLua;
        }

        if (!salvar) return;

        try {
            localStorage.setItem(chaveTema, escuro ? "dark" : "light");
        } catch (erro) {
            // O tema continua funcionando mesmo se o navegador bloquear o armazenamento.
        }
    }

    function alternarTema() {
        const temaAtual = document.documentElement.dataset.theme === "dark" ? "dark" : "light";
        definirTema(temaAtual === "dark" ? "light" : "dark");
    }

    function definirMenu(aberto) {
        if (!elementos.menuToggle || !elementos.menu) return;

        elementos.menu.classList.toggle("open", aberto);
        elementos.menuToggle.setAttribute("aria-expanded", String(aberto));
    }

    function alternarMenu() {
        definirMenu(!elementos.menu?.classList.contains("open"));
    }

    function calcularSimulacao() {
        if (
            !elementos.valor ||
            !elementos.prazo ||
            !elementos.valorFinal ||
            !elementos.valorInvestido ||
            !elementos.rendimento ||
            !elementos.rentabilidade ||
            !elementos.prazoValor
        ) {
            return;
        }

        const valor = Math.max(Number(elementos.valor.value) || 0, 0);
        const meses = Math.max(Number(elementos.prazo.value) || 1, 1);
        const montante = valor * Math.pow(1 + taxaMensal, meses);
        const lucro = montante - valor;
        const percentual = valor > 0 ? (lucro / valor) * 100 : 0;

        elementos.valorFinal.textContent = formatarMoeda(montante);
        elementos.valorInvestido.textContent = formatarMoeda(valor);
        elementos.rendimento.textContent = `+ ${formatarMoeda(lucro)}`;
        elementos.rentabilidade.textContent = `+${percentual.toFixed(2).replace(".", ",")}%`;
        elementos.prazoValor.textContent = textoMeses(meses);
    }

    function selecionarInvestimento(evento) {
        const botao = evento.target.closest("button[data-taxa]");
        if (!botao || !elementos.investimento || !elementos.taxaResumo) return;

        elementos.investimento.querySelectorAll("button").forEach((item) => {
            item.classList.toggle("ativo", item === botao);
            item.setAttribute("aria-pressed", String(item === botao));
        });

        taxaMensal = Number(botao.dataset.taxa) || 0.0115;
        elementos.taxaResumo.textContent = botao.dataset.resumo || "1.15% ao mês";
        calcularSimulacao();
    }

    function aplicarValorRapido(evento) {
        const botao = evento.target.closest("button[data-valor]");
        if (!botao || !elementos.valor) return;

        elementos.valor.value = botao.dataset.valor || "10000";
        calcularSimulacao();
    }

    function iniciarCarrossel() {
        const {
            carrossel,
            carrosselTrack,
            carrosselAnterior,
            carrosselProximo,
            carrosselPontos
        } = elementos;

        if (!carrossel || !carrosselTrack || !carrosselPontos) return;

        const cards = Array.from(carrosselTrack.children);
        let paginaAtual = 0;
        let totalPaginas = 1;
        let inicioToque = 0;
        let quadroResize = 0;
        let autoplayCarrossel = 0;
        const intervaloAutoplay = 5000;

        const cardsPorTela = () => {
            const valor = getComputedStyle(carrosselTrack).getPropertyValue("--cards-visiveis");
            return Math.max(parseInt(valor, 10) || 1, 1);
        };

        function irParaPagina(pagina) {
            totalPaginas = Math.max(Math.ceil(cards.length / cardsPorTela()), 1);
            paginaAtual = (pagina + totalPaginas) % totalPaginas;
            atualizarCarrossel();
        }

        function criarPontos() {
            carrosselPontos.replaceChildren();

            Array.from({ length: totalPaginas }, (_, indice) => {
                const ponto = document.createElement("button");
                ponto.type = "button";
                ponto.setAttribute("aria-label", `Mostrar grupo ${indice + 1}`);
                ponto.dataset.carouselPage = String(indice);
                carrosselPontos.appendChild(ponto);
                return ponto;
            });
        }

        function atualizarCarrossel() {
            const visiveis = cardsPorTela();
            const paginasCalculadas = Math.max(Math.ceil(cards.length / visiveis), 1);

            if (paginasCalculadas !== totalPaginas) {
                totalPaginas = paginasCalculadas;
                paginaAtual = Math.min(paginaAtual, totalPaginas - 1);
                criarPontos();
            }

            const gap = parseFloat(getComputedStyle(carrosselTrack).gap) || 0;
            const larguraCard = cards[0]?.getBoundingClientRect().width || 0;
            const deslocamento = paginaAtual * visiveis * (larguraCard + gap);

            carrosselTrack.style.transform = `translate3d(${-deslocamento}px, 0, 0)`;

            cards.forEach((card, indice) => {
                const inicio = paginaAtual * visiveis;
                const fim = inicio + visiveis;
                const escondido = indice < inicio || indice >= fim;
                const botao = card.querySelector("button");

                card.setAttribute("aria-hidden", String(escondido));
                if (botao) botao.tabIndex = escondido ? -1 : 0;
            });

            carrosselPontos.querySelectorAll("button").forEach((ponto, indice) => {
                const ativo = indice === paginaAtual;
                ponto.classList.toggle("ativo", ativo);
                ponto.setAttribute("aria-current", ativo ? "true" : "false");
            });
        }

        function pausarAutoplay() {
            clearInterval(autoplayCarrossel);
            autoplayCarrossel = 0;
        }

        function iniciarAutoplay() {
            pausarAutoplay();
            if (totalPaginas <= 1) return;
            autoplayCarrossel = setInterval(() => {
                irParaPagina(paginaAtual + 1);
            }, intervaloAutoplay);
        }

        function reiniciarAutoplay() {
            pausarAutoplay();
            iniciarAutoplay();
        }

        carrosselAnterior?.addEventListener("click", () => {
            irParaPagina(paginaAtual - 1);
            reiniciarAutoplay();
        });

        carrosselProximo?.addEventListener("click", () => {
            irParaPagina(paginaAtual + 1);
            reiniciarAutoplay();
        });

        carrosselPontos.addEventListener("click", (evento) => {
            const ponto = evento.target.closest("button[data-carousel-page]");
            if (!ponto) return;
            irParaPagina(Number(ponto.dataset.carouselPage) || 0);
            reiniciarAutoplay();
        });

        carrossel.addEventListener("keydown", (evento) => {
            if (evento.key === "ArrowLeft") {
                irParaPagina(paginaAtual - 1);
                reiniciarAutoplay();
            }

            if (evento.key === "ArrowRight") {
                irParaPagina(paginaAtual + 1);
                reiniciarAutoplay();
            }
        });

        carrossel.addEventListener("pointerdown", (evento) => {
            inicioToque = evento.clientX;
            pausarAutoplay();
        });

        carrossel.addEventListener("pointerup", (evento) => {
            const distancia = evento.clientX - inicioToque;
            if (Math.abs(distancia) >= 45) {
                irParaPagina(distancia > 0 ? paginaAtual - 1 : paginaAtual + 1);
            }

            iniciarAutoplay();
        });

        carrossel.addEventListener("mouseenter", pausarAutoplay);
        carrossel.addEventListener("mouseleave", iniciarAutoplay);
        carrossel.addEventListener("focusin", pausarAutoplay);
        carrossel.addEventListener("focusout", iniciarAutoplay);

        document.addEventListener("visibilitychange", () => {
            if (document.hidden) {
                pausarAutoplay();
                return;
            }

            iniciarAutoplay();
        });

        window.addEventListener("resize", () => {
            cancelAnimationFrame(quadroResize);
            quadroResize = requestAnimationFrame(() => {
                atualizarCarrossel();
                reiniciarAutoplay();
            });
        });

        totalPaginas = Math.max(Math.ceil(cards.length / cardsPorTela()), 1);
        criarPontos();
        atualizarCarrossel();
        iniciarAutoplay();
    }

    elementos.menuToggle?.addEventListener("click", alternarMenu);
    elementos.menu?.addEventListener("click", (evento) => {
        if (evento.target.closest("a")) {
            definirMenu(false);
        }
    });
    elementos.investimento?.addEventListener("click", selecionarInvestimento);
    elementos.atalhoValor?.addEventListener("click", aplicarValorRapido);
    elementos.valor?.addEventListener("input", calcularSimulacao);
    elementos.prazo?.addEventListener("input", calcularSimulacao);
    elementos.temaBotao?.addEventListener("click", alternarTema);
    elementos.newsletter?.addEventListener("submit", (evento) => {
        evento.preventDefault();
    });
    elementos.busca?.addEventListener("submit", (evento) => {
        evento.preventDefault();
    });
    document.addEventListener("keydown", (evento) => {
        if (evento.key === "Escape") {
            definirMenu(false);
        }
    });

    definirTema(document.documentElement.dataset.theme === "dark" ? "dark" : "light", false);

    if (elementos.valor && elementos.prazo) {
        calcularSimulacao();
    }

    iniciarCarrossel();
})();
