(() => {
    const botoes = document.querySelectorAll("[data-produto-detalhes]");
    if (botoes.length === 0) return;

    const produtos = {
        acoes: {
            titulo: "Ações",
            icone: "icon-bars",
            rendimento: "Até 25% ao ano",
            risco: "Alto",
            riscoClasse: "alto",
            oQueE: "Ações são pequenas partes do capital de uma empresa. Ao comprar uma ação, você se torna sócio daquela companhia e passa a ter direito sobre seus lucros (dividendos) e valorização do negócio.",
            comoFunciona: "Você compra ações pela bolsa de valores (B3). O preço varia diariamente conforme a oferta e demanda do mercado, resultados da empresa e cenário econômico. Você ganha quando o preço sobe ou recebe dividendos distribuídos pela empresa.",
            indicado: "Ideal para investidores com horizonte de longo prazo (mínimo 3 a 5 anos), dispostos a aceitar variações no valor investido em troca de potencial de retorno superior à renda fixa."
        },
        "fundos-imobiliarios": {
            titulo: "Fundos Imobiliários",
            icone: "icon-document",
            rendimento: "8-12% ao ano",
            risco: "Médio",
            riscoClasse: "medio",
            oQueE: "Os Fundos de Investimento Imobiliário (FIIs) permitem investir em imóveis — como shoppings, galpões logísticos e escritórios — sem precisar comprar um imóvel inteiro. Você compra cotas do fundo pela bolsa.",
            comoFunciona: "O fundo recebe aluguéis dos imóveis e distribui mensalmente pelo menos 95% do lucro aos cotistas. Você recebe esse valor direto na conta, sem precisar se preocupar com inquilinos ou manutenção.",
            indicado: "Perfeito para quem busca renda passiva mensal com isenção de Imposto de Renda nos rendimentos (para pessoa física) e quer diversificar sem comprar imóveis físicos."
        },
        "tesouro-direto": {
            titulo: "Tesouro Direto",
            icone: "icon-coins",
            rendimento: "Selic + 2%",
            risco: "Baixo",
            riscoClasse: "baixo",
            oQueE: "O Tesouro Direto é um programa do governo federal que permite que pessoas físicas emprestem dinheiro ao governo comprando títulos públicos. Em troca, o governo paga juros ao investidor.",
            comoFunciona: "Você escolhe entre diferentes tipos de título: Tesouro Selic (pós-fixado, ideal para reserva de emergência), Tesouro IPCA+ (protege da inflação) ou Tesouro Prefixado (taxa garantida). A partir de R$ 30 já é possível investir.",
            indicado: "Indicado para todos os perfis, especialmente iniciantes. O Tesouro Selic é a escolha mais segura e líquida do mercado — melhor que a poupança e com mais segurança que qualquer banco."
        },
        "cdb-lci-lca": {
            titulo: "CDB/LCI/LCA",
            icone: "icon-trend",
            rendimento: "130% do CDI",
            risco: "Baixo",
            riscoClasse: "baixo",
            oQueE: "CDB (Certificado de Depósito Bancário), LCI (Letra de Crédito Imobiliário) e LCA (Letra de Crédito do Agronegócio) são títulos emitidos por bancos. Ao investir, você empresta dinheiro ao banco e recebe juros.",
            comoFunciona: "O banco paga uma taxa de retorno acordada no momento da aplicação, geralmente atrelada ao CDI (pós-fixado) ou a uma taxa prefixada. LCI e LCA são isentos de IR para pessoa física. Todos têm garantia do FGC até R$ 250 mil por CPF por banco.",
            indicado: "Excelente para quem quer mais rendimento que a poupança com risco baixo. LCIs e LCAs são especialmente vantajosas por não terem imposto de renda, sendo ideais para objetivos de médio prazo."
        },
        coe: {
            titulo: "COE",
            icone: "icon-dollar",
            rendimento: "100% + prêmio",
            risco: "Médio",
            riscoClasse: "medio",
            oQueE: "O COE (Certificado de Operações Estruturadas) é um produto que combina renda fixa com derivativos, permitindo exposição a ativos variados (dólar, índices internacionais, commodities) com proteção parcial ou total do capital investido.",
            comoFunciona: "Você investe por um prazo definido (geralmente 2 a 5 anos). No vencimento, recebe de volta pelo menos o capital aplicado (na versão com capital protegido) mais um potencial ganho vinculado ao desempenho de um ativo subjacente, como o S&P500 ou o dólar.",
            indicado: "Interessante para investidores de perfil moderado que querem exposição a mercados internacionais com risco controlado e sem precisar entender de derivativos complexos."
        },
        multimercado: {
            titulo: "Multimercado",
            icone: "icon-globe",
            rendimento: "CDI + 3%",
            risco: "Médio",
            riscoClasse: "medio",
            oQueE: "Fundos Multimercado são fundos de investimento que podem aplicar em várias classes de ativos ao mesmo tempo: renda fixa, ações, câmbio, commodities e derivativos. São geridos por gestores profissionais.",
            comoFunciona: "Você compra cotas do fundo e um gestor especializado decide onde alocar o dinheiro para buscar o maior retorno possível. A diversificação reduz o risco, mas os retornos variam conforme a estratégia adotada. Há taxa de administração e, em alguns casos, taxa de performance.",
            indicado: "Indicado para quem quer diversificação automática e gestão profissional sem precisar acompanhar o mercado diariamente. Funciona bem como parte de uma carteira diversificada para perfis moderados a arrojados."
        }
    };

    const modal = document.createElement("div");
    modal.className = "produto-modal";
    modal.id = "produtoDetalhesModal";
    modal.hidden = true;
    modal.setAttribute("aria-hidden", "true");
    modal.innerHTML = `
        <div class="produto-modal-backdrop" data-produto-fechar></div>
        <section class="produto-dialog" role="dialog" aria-modal="true" aria-labelledby="produtoModalTitulo">
            <header class="produto-dialog-topo">
                <span class="produto-dialog-icone" aria-hidden="true">
                    <svg class="site-icon" focusable="false">
                        <use data-produto-icone></use>
                    </svg>
                </span>
                <div>
                    <span>O que é</span>
                    <h2 id="produtoModalTitulo" data-produto-titulo></h2>
                </div>
                <button class="produto-dialog-fechar" type="button" aria-label="Fechar detalhes do produto" data-produto-fechar>×</button>
            </header>
            <div class="produto-dialog-corpo">
                <div class="produto-explicacao">
                    <span class="produto-explicacao-icone produto-icone-lampada" aria-hidden="true"></span>
                    <div>
                        <h3>O que é?</h3>
                        <p data-produto-o-que-e></p>
                    </div>
                </div>
                <div class="produto-explicacao">
                    <span class="produto-explicacao-icone" aria-hidden="true">
                        <svg class="site-icon" focusable="false"><use href="#icon-clock"></use></svg>
                    </span>
                    <div>
                        <h3>Como funciona?</h3>
                        <p data-produto-como-funciona></p>
                    </div>
                </div>
                <div class="produto-explicacao">
                    <span class="produto-explicacao-icone" aria-hidden="true">
                        <svg class="site-icon" focusable="false"><use href="#icon-shield"></use></svg>
                    </span>
                    <div>
                        <h3>Para quem é indicado?</h3>
                        <p data-produto-indicado></p>
                    </div>
                </div>
                <div class="produto-resumo">
                    <div>
                        <span>Rendimento</span>
                        <strong data-produto-rendimento></strong>
                    </div>
                    <div>
                        <span>Risco</span>
                        <strong class="produto-risco" data-produto-risco></strong>
                    </div>
                </div>
                <button class="produto-dialog-entendi" type="button" data-produto-fechar>Entendi, obrigado!</button>
            </div>
        </section>
    `;
    document.body.append(modal);

    const campos = {
        titulo: modal.querySelector("[data-produto-titulo]"),
        icone: modal.querySelector("[data-produto-icone]"),
        oQueE: modal.querySelector("[data-produto-o-que-e]"),
        comoFunciona: modal.querySelector("[data-produto-como-funciona]"),
        indicado: modal.querySelector("[data-produto-indicado]"),
        rendimento: modal.querySelector("[data-produto-rendimento]"),
        risco: modal.querySelector("[data-produto-risco]")
    };

    let focoAnterior = null;

    function abrirProduto(chave, botao) {
        const produto = produtos[chave];
        if (!produto) return;

        focoAnterior = botao;
        campos.titulo.textContent = produto.titulo;
        campos.icone.setAttribute("href", `#${produto.icone}`);
        campos.oQueE.textContent = produto.oQueE;
        campos.comoFunciona.textContent = produto.comoFunciona;
        campos.indicado.textContent = produto.indicado;
        campos.rendimento.textContent = produto.rendimento;
        campos.risco.textContent = produto.risco;
        campos.risco.className = `produto-risco produto-risco-${produto.riscoClasse}`;

        modal.hidden = false;
        modal.setAttribute("aria-hidden", "false");
        document.body.classList.add("produto-modal-aberto");
        modal.querySelector(".produto-dialog-fechar")?.focus();
    }

    function fecharProduto() {
        if (modal.hidden) return;

        modal.hidden = true;
        modal.setAttribute("aria-hidden", "true");
        document.body.classList.remove("produto-modal-aberto");

        if (focoAnterior instanceof HTMLElement) {
            focoAnterior.focus();
        }
    }

    botoes.forEach((botao) => {
        botao.setAttribute("aria-haspopup", "dialog");
        botao.setAttribute("aria-controls", modal.id);
        botao.addEventListener("click", () => {
            abrirProduto(botao.dataset.produtoDetalhes || "", botao);
        });
    });

    modal.addEventListener("click", (evento) => {
        if (evento.target.closest("[data-produto-fechar]")) {
            fecharProduto();
        }
    });

    document.addEventListener("keydown", (evento) => {
        if (evento.key === "Escape") {
            fecharProduto();
            return;
        }

        if (evento.key !== "Tab" || modal.hidden) return;

        const controles = Array.from(
            modal.querySelectorAll('button:not([disabled]), [href], input:not([disabled]), [tabindex]:not([tabindex="-1"])')
        ).filter((controle) => controle instanceof HTMLElement && !controle.hidden);

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
    });
})();
