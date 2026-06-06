(() => {
    "use strict";

    const cards = Array.from(document.querySelectorAll("[data-produto-card]"));

    if (!cards.length) {
        return;
    }

    function iniciarAnimacaoDosCards() {
        const movimentoReduzido = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

        if (movimentoReduzido || !("IntersectionObserver" in window)) {
            cards.forEach((card) => card.classList.add("produto-catalogo-visivel"));
            return;
        }

        document.documentElement.classList.add("produtos-animacao-ativa");

        const observador = new IntersectionObserver((entradas) => {
            entradas.forEach((entrada) => {
                if (!entrada.isIntersecting) {
                    return;
                }

                entrada.target.classList.add("produto-catalogo-visivel");
                observador.unobserve(entrada.target);
            });
        }, {
            rootMargin: "0px 0px -8% 0px",
            threshold: 0.12,
        });

        cards.forEach((card, indice) => {
            card.style.setProperty("--produto-entrada-atraso", `${(indice % 2) * 55}ms`);
            observador.observe(card);
        });
    }

    function definirEstado(card, aberto) {
        const botao = card.querySelector("[data-produto-toggle]");
        const painel = card.querySelector("[data-produto-panel]");
        const rotulo = card.querySelector("[data-produto-toggle-label]");

        if (!botao || !painel || !rotulo) {
            return;
        }

        card.classList.toggle("produto-catalogo-aberto", aberto);
        botao.setAttribute("aria-expanded", String(aberto));
        painel.hidden = !aberto;
        rotulo.textContent = aberto ? "Ver menos" : "Ver detalhes completos";
    }

    function fecharOutros(cardAtual) {
        cards.forEach((card) => {
            if (card !== cardAtual) {
                definirEstado(card, false);
            }
        });
    }

    cards.forEach((card) => {
        const botao = card.querySelector("[data-produto-toggle]");

        botao?.addEventListener("click", () => {
            const abrir = botao.getAttribute("aria-expanded") !== "true";

            if (abrir) {
                fecharOutros(card);
            }

            definirEstado(card, abrir);
        });
    });

    function abrirProdutoDoHash() {
        const id = decodeURIComponent(window.location.hash.slice(1));
        const card = cards.find((item) => item.id === id);

        if (!card) {
            return;
        }

        fecharOutros(card);
        card.classList.add("produto-catalogo-visivel");
        definirEstado(card, true);
    }

    window.addEventListener("hashchange", abrirProdutoDoHash);
    iniciarAnimacaoDosCards();
    abrirProdutoDoHash();
})();
