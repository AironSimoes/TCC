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
        loginBotao: ".login-btn",
        loginModal: "#loginModal",
        loginFechar: "[data-login-close]",
        loginForm: ".login-form",
        loginEmail: "#loginEmail",
        loginStatus: ".login-status",
        cadastroForm: ".cadastro-form",
        cadastroCpf: "#cadastroCpf",
        cadastroTelefone: "#cadastroTelefone",
        cadastroSenha: "#cadastroSenha",
        cadastroConfirmarSenha: "#cadastroConfirmarSenha",
        cadastroStatus: ".cadastro-status",
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
        loginBotao: document.querySelector(seletor.loginBotao),
        loginModal: document.querySelector(seletor.loginModal),
        loginFechar: document.querySelectorAll(seletor.loginFechar),
        loginForm: document.querySelector(seletor.loginForm),
        loginEmail: document.querySelector(seletor.loginEmail),
        loginStatus: document.querySelector(seletor.loginStatus),
        cadastroForm: document.querySelector(seletor.cadastroForm),
        cadastroCpf: document.querySelector(seletor.cadastroCpf),
        cadastroTelefone: document.querySelector(seletor.cadastroTelefone),
        cadastroSenha: document.querySelector(seletor.cadastroSenha),
        cadastroConfirmarSenha: document.querySelector(seletor.cadastroConfirmarSenha),
        cadastroStatus: document.querySelector(seletor.cadastroStatus),
        temaBotao: document.querySelector(seletor.temaBotao),
        temaIcone: document.querySelector(seletor.temaIcone)
    };

    const chaveTema = "ironinvest-theme";
    const iconeLua = "imagens/lua_16_x_16.png";
    const iconeSol = "imagens/brightness_9253338.png";
    let taxaMensal = 0.0115;
    let focoAntesLogin = null;

    const formatarMoeda = (valor) => moeda.format(valor);
    const somenteDigitos = (valor) => valor.replace(/\D/g, "");
    function salvarCookie(nome, valor, dias) {
        const maxAge = Math.max(dias, 1) * 24 * 60 * 60;
        const seguro = window.location.protocol === "https:" ? "; Secure" : "";
        document.cookie = `${nome}=${encodeURIComponent(valor)}; Max-Age=${maxAge}; Path=/; SameSite=Lax${seguro}`;
    }

    function parametrosLogin() {
        return new URLSearchParams(window.location.search).get("login") || "";
    }
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
            salvarCookie("ironinvest_theme", escuro ? "dark" : "light", 365);
        } catch (erro) {
            // O tema continua funcionando mesmo se o navegador bloquear cookies.
        }

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

    function abrirLogin() {
        if (!elementos.loginModal) return;

        focoAntesLogin = document.activeElement;
        definirMenu(false);
        elementos.loginModal.hidden = false;
        elementos.loginModal.setAttribute("aria-hidden", "false");
        document.body.classList.add("login-modal-aberto");
        if (elementos.loginStatus) {
            elementos.loginStatus.textContent = "";
        }
        elementos.loginEmail?.focus();
    }

    function fecharLogin() {
        if (!elementos.loginModal || elementos.loginModal.hidden) return;

        elementos.loginModal.setAttribute("aria-hidden", "true");
        elementos.loginModal.hidden = true;
        document.body.classList.remove("login-modal-aberto");

        if (focoAntesLogin instanceof HTMLElement) {
            focoAntesLogin.focus();
        }
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

    function formatarCpf(valor) {
        return somenteDigitos(valor)
            .slice(0, 11)
            .replace(/(\d{3})(\d)/, "$1.$2")
            .replace(/(\d{3})(\d)/, "$1.$2")
            .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    }

    function formatarTelefone(valor) {
        const digitos = somenteDigitos(valor).slice(0, 11);

        if (digitos.length <= 10) {
            return digitos
                .replace(/(\d{2})(\d)/, "($1) $2")
                .replace(/(\d{4})(\d)/, "$1-$2");
        }

        return digitos
            .replace(/(\d{2})(\d)/, "($1) $2")
            .replace(/(\d{5})(\d)/, "$1-$2");
    }

    function validarCpf(valor) {
        const cpf = somenteDigitos(valor);
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

        const calcularDigito = (base) => {
            const soma = base
                .split("")
                .reduce((total, numero, indice) => total + Number(numero) * (base.length + 1 - indice), 0);
            const resto = (soma * 10) % 11;
            return resto === 10 ? 0 : resto;
        };

        return calcularDigito(cpf.slice(0, 9)) === Number(cpf[9])
            && calcularDigito(cpf.slice(0, 10)) === Number(cpf[10]);
    }

    function validarCadastro(evento) {
        if (!elementos.cadastroForm) return;

        const senha = elementos.cadastroSenha?.value || "";
        const confirmarSenha = elementos.cadastroConfirmarSenha?.value || "";
        const cpfValido = validarCpf(elementos.cadastroCpf?.value || "");

        elementos.cadastroCpf?.setCustomValidity(cpfValido ? "" : "Informe um CPF válido.");
        elementos.cadastroConfirmarSenha?.setCustomValidity(
            senha === confirmarSenha ? "" : "As senhas precisam ser iguais."
        );

        if (!elementos.cadastroForm.checkValidity()) {
            evento.preventDefault();
            elementos.cadastroForm.reportValidity();
            return;
        }

        if (window.location.protocol === "file:") {
            evento.preventDefault();
            if (elementos.cadastroStatus) {
                elementos.cadastroStatus.textContent = "Formulário validado. Ao conectar o PHP, envie para cadastro.php.";
            }
        }
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
    elementos.cadastroCpf?.addEventListener("input", () => {
        elementos.cadastroCpf.value = formatarCpf(elementos.cadastroCpf.value);
        elementos.cadastroCpf.setCustomValidity("");
    });
    elementos.cadastroTelefone?.addEventListener("input", () => {
        elementos.cadastroTelefone.value = formatarTelefone(elementos.cadastroTelefone.value);
    });
    elementos.cadastroSenha?.addEventListener("input", () => {
        elementos.cadastroConfirmarSenha?.setCustomValidity("");
    });
    elementos.cadastroConfirmarSenha?.addEventListener("input", () => {
        elementos.cadastroConfirmarSenha.setCustomValidity("");
    });
    elementos.cadastroForm?.addEventListener("submit", validarCadastro);
    elementos.temaBotao?.addEventListener("click", alternarTema);
    elementos.loginBotao?.addEventListener("click", abrirLogin);
    elementos.loginFechar.forEach((controle) => {
        controle.addEventListener("click", fecharLogin);
    });
    elementos.loginForm?.addEventListener("submit", (evento) => {
        if (!elementos.loginForm.checkValidity()) {
            evento.preventDefault();
            elementos.loginForm.reportValidity();
            return;
        }

        if (window.location.protocol === "file:") {
            evento.preventDefault();
            if (elementos.loginStatus) {
                elementos.loginStatus.textContent = "Login validado. Rode em PHP para criar a sessão.";
            }
            elementos.loginForm.reset();
        }
    });
    elementos.newsletter?.addEventListener("submit", (evento) => {
        evento.preventDefault();
    });
    elementos.busca?.addEventListener("submit", (evento) => {
        evento.preventDefault();
    });
    document.addEventListener("keydown", (evento) => {
        if (evento.key === "Escape") {
            fecharLogin();
            definirMenu(false);
        }
    });

    definirTema(document.documentElement.dataset.theme === "dark" ? "dark" : "light", false);

    if (elementos.valor && elementos.prazo) {
        calcularSimulacao();
    }

    iniciarCarrossel();

    if (parametrosLogin() === "erro") {
        abrirLogin();
        if (elementos.loginStatus) {
            elementos.loginStatus.textContent = "E-mail ou senha inválidos.";
        }
    } else if (parametrosLogin() === "sessao") {
        abrirLogin();
        if (elementos.loginStatus) {
            elementos.loginStatus.textContent = "Sessão iniciada com segurança.";
        }
    } else if (window.location.hash === "#login") {
        abrirLogin();
    }
})();
