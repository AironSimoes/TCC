<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';
require __DIR__ . '/app/icon-sprite.php';

ironinvest_iniciar_sessao();

$area = strtolower(trim($_GET['area'] ?? ''));
$titulos = [
    'analises' => 'Análises',
    'educacao' => 'Educação',
];

if (!isset($titulos[$area])) {
    ironinvest_redirecionar('index.html');
}

ironinvest_exigir_login('acesso.php?pagina=' . $area);
ironinvest_header_html();

$titulo = $titulos[$area];
$bodyClass = 'restrita-page';
if ($area === 'analises') {
    $bodyClass = 'analises-page';
} elseif ($area === 'educacao') {
    $bodyClass = 'educacao-page';
}
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Área de <?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?> da IronInvest." />
    <meta name="referrer" content="strict-origin-when-cross-origin" />
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self' https://fonts.googleapis.com; font-src https://fonts.gstatic.com; img-src 'self' data:; object-src 'none'; base-uri 'self'; form-action 'self'; connect-src 'self'; upgrade-insecure-requests">
    <title><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?> | IronInvest</title>
    <link rel="shortcut icon" href="assets/img/iron 512x512.png" type="image/x-icon">
    <?php if ($area === 'analises'): ?>
    <link rel="preload" href="assets/img/analise-destaque-clean.png" as="image" fetchpriority="high">
    <?php elseif ($area === 'educacao'): ?>
    <link rel="preload" href="assets/img/educacao-destaque-clean.jpg" as="image" fetchpriority="high">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="assets/js/theme-init.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="<?php echo htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8'); ?>">
    <?php ironinvest_svg_sprite(); ?>
    <header class="header">
        <div class="container header-container">
            <a href="index.html" class="logo-link">
                <img src="assets/img/Iron_logo.svg" alt="Logo IronInvest" class="logo" width="90" height="34" decoding="async">
            </a>

            <nav class="nav" role="navigation" aria-label="Menu principal">
                <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-menu">
                    <span class="sr-only">Abrir menu</span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
                <ul class="menu" id="main-menu">
                    <li><a href="acesso.php?pagina=sobre">Sobre</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a class="menu-restrito" href="acesso.php?pagina=analises"<?php echo $area === 'analises' ? ' aria-current="page"' : ''; ?>>Análises</a></li>
                    <li><a class="menu-restrito" href="acesso.php?pagina=educacao"<?php echo $area === 'educacao' ? ' aria-current="page"' : ''; ?>>Educação</a></li>
                    <li><a href="acesso.php?pagina=suporte">Suporte</a></li>
                    <li class="menu-mobile-acao"><a href="cadastro.html">Abrir Conta</a></li>
                </ul>
            </nav>

            <div class="actions">
                <button class="theme-btn" type="button" aria-label="Ativar modo escuro" aria-pressed="false">
                    <img src="assets/img/lua_16_x_16.png" alt="" width="16" height="16" decoding="async">
                </button>
                <button class="login-btn" type="button" aria-haspopup="dialog" aria-controls="loginModal">
                    <img src="assets/img/user_16_x_16.png" alt="" width="16" height="16" decoding="async">
                    <span>Entrar</span>
                </button>
                <a class="primary-btn" href="cadastro.html">Abrir Conta</a>
            </div>
        </div>
    </header>

    <div class="login-modal" id="loginModal" hidden aria-hidden="true">
        <div class="login-backdrop" data-login-close></div>
        <section class="login-dialog" role="dialog" aria-modal="true" aria-labelledby="loginTitulo">
            <div class="login-topo">
                <h2 id="loginTitulo">Fazer Login</h2>
                <button class="login-close" type="button" aria-label="Fechar login" data-login-close>×</button>
            </div>

            <form class="login-form" action="login.php" method="post" autocomplete="on">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(ironinvest_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                <div class="login-campo">
                    <label for="loginEmail">
                        <span class="login-label-icon login-label-email" aria-hidden="true"></span>
                        E-mail
                    </label>
                    <input type="email" id="loginEmail" name="email" inputmode="email" autocomplete="email" placeholder="seu@email.com" maxlength="160" required>
                </div>

                <div class="login-campo">
                    <label for="loginSenha">
                        <span class="login-label-icon login-label-lock" aria-hidden="true"></span>
                        Senha
                    </label>
                    <input type="password" id="loginSenha" name="senha" autocomplete="current-password" minlength="8" maxlength="72" placeholder="Mínimo 8 caracteres" required>
                </div>

                <button class="login-submit" type="submit">
                    Fazer Login
                    <span aria-hidden="true">→</span>
                </button>

                <button class="login-link" type="button">Esqueci minha senha</button>

                <p class="login-cadastro">Não tem uma conta? <a href="cadastro.html">Criar conta</a></p>
                <p class="login-status" role="status" aria-live="polite"></p>
            </form>
        </section>
    </div>

    <?php if ($area === 'analises'): ?>
    <main>
        <section class="analises" id="analises" aria-labelledby="analisesTitulo">
            <div class="analises-hero">
                <div class="container analises-hero-inner">
                    <div class="analises-copy">
                        <span class="analises-kicker"><span class="kicker-icon" aria-hidden="true"><?php ironinvest_icon('icon-pulse'); ?></span> IronInvest Research</span>
                        <h1 id="analisesTitulo">Análises de <span>Mercado</span></h1>
                        <p>Acompanhe indicadores em tempo real e leia análises aprofundadas para embasar cada decisão de investimento.</p>

                        <div class="analises-metricas" aria-label="Métricas de pesquisa">
                            <div>
                                <span aria-hidden="true"><?php ironinvest_icon('icon-book'); ?></span>
                                <strong>240+</strong>
                                <small>Análises publicadas</small>
                            </div>

                            <div>
                                <span aria-hidden="true"><?php ironinvest_icon('icon-eye'); ?></span>
                                <strong>85k</strong>
                                <small>Leituras este mês</small>
                            </div>

                            <div>
                                <span aria-hidden="true"><?php ironinvest_icon('icon-star'); ?></span>
                                <strong>4.9</strong>
                                <small>Avaliação média</small>
                            </div>
                        </div>
                    </div>

                    <p class="analises-status"><span aria-hidden="true"></span>Mercado aberto · Dados ao vivo</p>
                </div>
            </div>

            <div class="analises-corpo">
                <div class="container analises-container">
                    <div class="indicadores-topo">
                        <h2>Indicadores de Mercado</h2>
                        <span>Ao vivo</span>
                    </div>

                    <div class="indicadores-grid" aria-label="Indicadores de mercado">
                        <article>
                            <span>IBOVESPA</span>
                            <strong>128.450</strong>
                            <small class="positivo indicador-variacao"><?php ironinvest_icon('icon-trend'); ?> +1,24%</small>
                        </article>

                        <article>
                            <span>Selic</span>
                            <strong>10,50% aa</strong>
                            <small class="positivo indicador-variacao"><?php ironinvest_icon('icon-trend'); ?> estável</small>
                        </article>

                        <article>
                            <span>Dólar</span>
                            <strong>R$ 4,97</strong>
                            <small class="negativo indicador-variacao"><?php ironinvest_icon('icon-trend-down'); ?> -0,38%</small>
                        </article>

                        <article>
                            <span>Euro</span>
                            <strong>R$ 5,42</strong>
                            <small class="positivo indicador-variacao"><?php ironinvest_icon('icon-trend'); ?> +0,12%</small>
                        </article>

                        <article>
                            <span>Ouro</span>
                            <strong>R$ 18.320</strong>
                            <small class="positivo indicador-variacao"><?php ironinvest_icon('icon-trend'); ?> +0,87%</small>
                        </article>

                        <article>
                            <span>IFIX</span>
                            <strong>3.142</strong>
                            <small class="negativo indicador-variacao"><?php ironinvest_icon('icon-trend-down'); ?> -0,21%</small>
                        </article>
                    </div>

                    <article class="analise-destaque-card">
                        <div class="analise-destaque-img">
                            <img src="assets/img/analise-destaque-clean.png" alt="Investidor acompanhando gráficos em notebooks" width="342" height="455" fetchpriority="high" decoding="async">
                            <span>Em Destaque</span>
                        </div>

                        <div class="analise-destaque-conteudo">
                            <span class="analise-tag macro">Macroeconomia</span>
                            <h2>Cenário Macroeconômico 2026: O que esperar da Selic e do PIB brasileiro?</h2>
                            <p>O Banco Central sinalizou postura cautelosa para o segundo semestre. Analisamos os principais indicadores e o impacto na sua carteira de investimentos.</p>

                            <div class="analise-meta">
                                <span class="analise-meta-item destaque">Equipe IronInvest</span>
                                <span class="analise-meta-item"><?php ironinvest_icon('icon-calendar'); ?>02 Mai 2026</span>
                                <span class="analise-meta-item"><?php ironinvest_icon('icon-clock'); ?>8 min</span>
                                <span class="analise-meta-item"><?php ironinvest_icon('icon-eye'); ?>12.4k leituras</span>
                            </div>

                            <button class="analise-abrir" type="button" data-analise-open>Ler análise completa <span aria-hidden="true">→</span></button>
                        </div>
                    </article>

                    <div class="analises-recentes-top">
                        <h2>Análises Recentes</h2>

                        <div class="analises-filtros" aria-label="Filtrar análises recentes">
                            <button type="button" class="ativo" data-analise-filter="todos" aria-pressed="true">Todos</button>
                            <button type="button" data-analise-filter="macroeconomia" aria-pressed="false">Macroeconomia</button>
                            <button type="button" data-analise-filter="acoes" aria-pressed="false">Ações</button>
                            <button type="button" data-analise-filter="renda-fixa" aria-pressed="false">Renda Fixa</button>
                            <button type="button" data-analise-filter="fiis" aria-pressed="false">FIIs</button>
                            <button type="button" data-analise-filter="cripto" aria-pressed="false">Cripto</button>
                            <button type="button" data-analise-filter="internacional" aria-pressed="false">Internacional</button>
                        </div>
                    </div>

                    <div class="analises-grid">
                        <article class="analise-card" data-analise-card data-category="renda-fixa">
                            <figure class="analise-card-media">
                                <img src="assets/img/analise-renda-fixa-hq.jpg" alt="Documentos financeiros, gráfico e calculadora sobre uma mesa" width="960" height="540" loading="lazy" decoding="async">
                                <span class="analise-card-tag renda-fixa">Renda Fixa</span>
                            </figure>
                            <div class="analise-card-conteudo">
                                <h3>CDB pós-fixado x Tesouro Selic: Qual escolher em 2026?</h3>
                                <p>Comparamos os melhores produtos de renda fixa e te ajudamos a decidir.</p>
                                <span class="analise-card-meta"><span>01 Mai 2026</span><span><?php ironinvest_icon('icon-clock'); ?>5 min</span></span>
                            </div>
                        </article>

                        <article class="analise-card" data-analise-card data-category="cripto">
                            <figure class="analise-card-media">
                                <img src="assets/img/analise-cripto-hq.jpg" alt="Moeda de bitcoin sobre gráfico financeiro digital" width="960" height="540" loading="lazy" decoding="async">
                                <span class="analise-card-tag cripto">Cripto</span>
                            </figure>
                            <div class="analise-card-conteudo">
                                <h3>Bitcoin bate novos recordes: momento de entrar ou esperar?</h3>
                                <p>Análise técnica e fundamentalista do BTC após a valorização recente.</p>
                                <span class="analise-card-meta"><span>30 Abr 2026</span><span><?php ironinvest_icon('icon-clock'); ?>7 min</span></span>
                            </div>
                        </article>

                        <article class="analise-card" data-analise-card data-category="fiis">
                            <figure class="analise-card-media">
                                <img src="assets/img/analise-fiis-hq.jpg" alt="Prédios comerciais e residenciais em uma cidade" width="960" height="540" loading="lazy" decoding="async">
                                <span class="analise-card-tag fiis">FIIs</span>
                            </figure>
                            <div class="analise-card-conteudo">
                                <h3>Os 5 FIIs com melhor dividend yield do mês de abril</h3>
                                <p>Selecionamos os fundos imobiliários que mais distribuíram proventos.</p>
                                <span class="analise-card-meta"><span>29 Abr 2026</span><span><?php ironinvest_icon('icon-clock'); ?>6 min</span></span>
                            </div>
                        </article>

                        <article class="analise-card" data-analise-card data-category="acoes">
                            <figure class="analise-card-media">
                                <img src="assets/img/analise-acoes-hq.jpg" alt="Consultor apresentando gráficos financeiros para um cliente" width="960" height="540" loading="lazy" decoding="async">
                                <span class="analise-card-tag acoes">Ações</span>
                            </figure>
                            <div class="analise-card-conteudo">
                                <h3>Carteira recomendada: as 10 ações para maio de 2026</h3>
                                <p>Nossa equipe selecionou as principais oportunidades da Bolsa para o mês.</p>
                                <span class="analise-card-meta"><span>28 Abr 2026</span><span><?php ironinvest_icon('icon-clock'); ?>9 min</span></span>
                            </div>
                        </article>
                    </div>

                    <p class="analises-vazio" data-analise-empty hidden>Nenhuma análise encontrada para Internacional.</p>
                </div>
            </div>
        </section>
    </main>

    <div class="analise-modal" id="analiseModal" hidden aria-hidden="true">
        <div class="analise-modal-backdrop" data-analise-close></div>
        <article class="analise-dialog" role="dialog" aria-modal="true" aria-labelledby="analiseModalTitulo">
            <button class="analise-fechar" type="button" aria-label="Fechar análise" data-analise-close>×</button>
            <img class="analise-modal-img" src="assets/img/analise-macro-wide.png" alt="Investidor acompanhando gráficos em notebooks" width="342" height="162" loading="lazy" decoding="async">

            <div class="analise-modal-conteudo">
                <span class="analise-tag macro">Macroeconomia</span>
                <h2 id="analiseModalTitulo">Cenário Macroeconômico 2026: O que esperar da Selic e do PIB brasileiro?</h2>

                <div class="analise-meta">
                    <span class="analise-meta-item destaque">Equipe IronInvest</span>
                    <span class="analise-meta-item"><?php ironinvest_icon('icon-calendar'); ?>02 Mai 2026</span>
                    <span class="analise-meta-item"><?php ironinvest_icon('icon-clock'); ?>8 min de leitura</span>
                </div>

                <div class="analise-texto">
                    <h3>O que o Banco Central está sinalizando?</h3>
                    <p>O Copom encerrou seu último ciclo de alta com a Selic em 10,50% ao ano, e as atas mais recentes indicam manutenção desse patamar pelo menos até o final do terceiro trimestre de 2026.</p>

                    <h3>PIB: crescimento moderado à vista</h3>
                    <p>As projeções de mercado apontam para crescimento de 2,1% em 2026. O consumo das famílias segue como principal motor, beneficiado pelo mercado de trabalho aquecido e pela expansão do crédito.</p>

                    <h3>Impacto na sua carteira</h3>
                    <p>Com a Selic em 10,50%, a renda fixa continua atrativa. Para investidores mais arrojados, a Bolsa começa a ficar mais interessante à medida que o ciclo de corte se aproxima.</p>

                    <h3>O que monitorar nos próximos meses</h3>
                    <p>Fique atento às próximas reuniões do Copom, aos dados mensais de IPCA e ao comportamento do dólar. Uma eventual piora fiscal pode forçar o Banco Central a rever o ritmo de queda dos juros.</p>

                    <p>Em resumo: 2026 é um ano de transição. Manter diversificação entre renda fixa e renda variável é a estratégia mais sensata para a maioria dos perfis de investidor.</p>
                </div>

                <button class="analise-modal-botao" type="button" data-analise-close>Fechar análise</button>
            </div>
        </article>
    </div>
    <?php elseif ($area === 'educacao'): ?>
    <main>
        <section class="educacao" id="educacao" aria-labelledby="educacaoTitulo">
            <div class="educacao-hero">
                <div class="container educacao-hero-inner">
                    <div class="educacao-copy">
                        <span class="educacao-kicker"><span class="kicker-icon" aria-hidden="true"><?php ironinvest_icon('icon-graduation'); ?></span> IronInvest Academy</span>
                        <h1 id="educacaoTitulo">Educação <span>Financeira</span></h1>
                        <p>Cursos, webinars e materiais gratuitos para você investir com mais conhecimento e segurança.</p>
                    </div>
                </div>
            </div>

            <div class="educacao-corpo">
                <div class="container educacao-container">
                    <div class="educacao-metricas" aria-label="Métricas de educação financeira">
                        <article>
                            <span aria-hidden="true"><?php ironinvest_icon('icon-graduation'); ?></span>
                            <strong>48.000+</strong>
                            <small>Alunos formados</small>
                        </article>

                        <article>
                            <span aria-hidden="true"><?php ironinvest_icon('icon-book'); ?></span>
                            <strong>32</strong>
                            <small>Cursos disponíveis</small>
                        </article>

                        <article>
                            <span aria-hidden="true"><?php ironinvest_icon('icon-video'); ?></span>
                            <strong>120+</strong>
                            <small>Webinars realizados</small>
                        </article>

                        <article>
                            <span aria-hidden="true"><?php ironinvest_icon('icon-document'); ?></span>
                            <strong>15</strong>
                            <small>E-books gratuitos</small>
                        </article>
                    </div>

                    <article class="educacao-destaque-card">
                        <div class="educacao-destaque-img">
                            <img src="assets/img/educacao-destaque-clean.jpg" alt="Caderno com gráficos financeiros, livro e café sobre mesa de estudos" width="1280" height="687" fetchpriority="high" decoding="async">
                            <button class="educacao-destaque-play" type="button" aria-label="Assistir prévia do curso">
                                <?php ironinvest_icon('icon-play'); ?>
                            </button>
                            <span>Curso em Destaque</span>
                        </div>

                        <div class="educacao-destaque-conteudo">
                            <div class="educacao-tags">
                                <span>Todos os níveis</span>
                                <span>Certificado</span>
                            </div>
                            <h2>Investindo do Zero ao Avançado</h2>
                            <p>Do básico à gestão de carteira profissional. Aprenda a investir com segurança e inteligência em 12 módulos completos.</p>

                            <div class="educacao-info-grid" aria-label="Detalhes do curso">
                                <span><?php ironinvest_icon('icon-book'); ?>48 aulas</span>
                                <span><?php ironinvest_icon('icon-clock'); ?>14h 30min</span>
                                <span><?php ironinvest_icon('icon-users'); ?>12.400 alunos</span>
                                <span><?php ironinvest_icon('icon-star'); ?>4.9</span>
                            </div>

                            <button class="educacao-botao" type="button">Começar gratuitamente <span aria-hidden="true">→</span></button>
                        </div>
                    </article>

                    <div class="educacao-secao-topo">
                        <h2><span aria-hidden="true"><?php ironinvest_icon('icon-book'); ?></span> Cursos Disponíveis</h2>
                        <button type="button">Ver todos <span aria-hidden="true">›</span></button>
                    </div>

                    <div class="educacao-cursos-grid">
                        <article class="educacao-curso-card">
                            <div class="educacao-curso-img">
                                <img src="assets/img/curso-renda-fixa.jpg" alt="Caderno de estudos, gráfico financeiro e calculadora sobre uma mesa" width="960" height="540" loading="lazy" decoding="async">
                                <span class="curso-selo-gratis">Grátis</span>
                                <button class="curso-play" type="button" aria-label="Assistir prévia do curso Renda Fixa Descomplicada"><?php ironinvest_icon('icon-play'); ?></button>
                            </div>
                            <div>
                                <div class="curso-linha">
                                    <span>Iniciante</span>
                                    <strong class="curso-rating"><span aria-hidden="true"><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?></span>4.8</strong>
                                </div>
                                <h3>Renda Fixa Descomplicada</h3>
                                <p><span><?php ironinvest_icon('icon-book'); ?>12 aulas</span><span><?php ironinvest_icon('icon-clock'); ?>3h 20min</span></p>
                            </div>
                        </article>

                        <article class="educacao-curso-card">
                            <div class="educacao-curso-img">
                                <img src="assets/img/curso-acoes.jpg" alt="Notebook com gráficos financeiros e materiais de estudo sobre ações" width="960" height="540" loading="lazy" decoding="async">
                                <button class="curso-play" type="button" aria-label="Assistir prévia do curso Análise Fundamentalista de Ações"><?php ironinvest_icon('icon-play'); ?></button>
                            </div>
                            <div>
                                <div class="curso-linha">
                                    <span>Intermediário</span>
                                    <strong class="curso-rating"><span aria-hidden="true"><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?></span>4.9</strong>
                                </div>
                                <h3>Análise Fundamentalista de Ações</h3>
                                <p><span><?php ironinvest_icon('icon-book'); ?>20 aulas</span><span><?php ironinvest_icon('icon-clock'); ?>6h 10min</span></p>
                            </div>
                        </article>

                        <article class="educacao-curso-card">
                            <div class="educacao-curso-img">
                                <img src="assets/img/curso-fiis.jpg" alt="Maquetes de prédios e relatório financeiro sobre uma mesa" width="960" height="540" loading="lazy" decoding="async">
                                <span class="curso-selo-gratis">Grátis</span>
                                <button class="curso-play" type="button" aria-label="Assistir prévia do curso Fundos Imobiliários na Prática"><?php ironinvest_icon('icon-play'); ?></button>
                            </div>
                            <div>
                                <div class="curso-linha">
                                    <span>Iniciante</span>
                                    <strong class="curso-rating"><span aria-hidden="true"><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?></span>4.7</strong>
                                </div>
                                <h3>Fundos Imobiliários na Prática</h3>
                                <p><span><?php ironinvest_icon('icon-book'); ?>15 aulas</span><span><?php ironinvest_icon('icon-clock'); ?>4h 45min</span></p>
                            </div>
                        </article>

                        <article class="educacao-curso-card">
                            <div class="educacao-curso-img">
                                <img src="assets/img/curso-cripto.jpg" alt="Tablet com gráficos de cripto e caderno de estudos sobre uma mesa" width="960" height="540" loading="lazy" decoding="async">
                                <button class="curso-play" type="button" aria-label="Assistir prévia do curso Cripto para Iniciantes"><?php ironinvest_icon('icon-play'); ?></button>
                            </div>
                            <div>
                                <div class="curso-linha">
                                    <span>Iniciante</span>
                                    <strong class="curso-rating"><span aria-hidden="true"><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?><?php ironinvest_icon('icon-star'); ?></span>4.6</strong>
                                </div>
                                <h3>Cripto para Iniciantes</h3>
                                <p><span><?php ironinvest_icon('icon-book'); ?>10 aulas</span><span><?php ironinvest_icon('icon-clock'); ?>2h 50min</span></p>
                            </div>
                        </article>
                    </div>

                    <div class="educacao-secao-topo">
                        <h2><span aria-hidden="true"><?php ironinvest_icon('icon-video'); ?></span> Webinars</h2>
                        <button type="button">Ver todos <span aria-hidden="true">›</span></button>
                    </div>

                    <div class="educacao-webinars-grid">
                        <article class="educacao-webinar-card">
                            <div class="educacao-webinar-img">
                                <img src="assets/img/webinar-live-clean.jpg" alt="Especialista apresentando um webinar de investimentos ao vivo" width="540" height="960" loading="lazy" decoding="async">
                                <span class="webinar-live-badge">AO VIVO</span>
                                <span class="webinar-play" aria-hidden="true"><?php ironinvest_icon('icon-play'); ?></span>
                            </div>
                            <div>
                                <h3>Mercado ao Vivo: Perspectivas para o 2º Semestre 2026</h3>
                                <p>Dr. Carlos Mendes</p>
                                <span class="educacao-data"><?php ironinvest_icon('icon-clock'); ?>15 Mai 2026 às 19h00</span>
                                <button type="button">Inscrever-se</button>
                            </div>
                        </article>

                        <article class="educacao-webinar-card">
                            <div class="educacao-webinar-img">
                                <img src="assets/img/webinar-gravado-clean.jpg" alt="Mesa de estudos com notebook e gráficos financeiros para webinar gravado" width="540" height="960" loading="lazy" decoding="async">
                                <span class="webinar-play" aria-hidden="true"><?php ironinvest_icon('icon-play'); ?></span>
                            </div>
                            <div>
                                <h3>Como montar uma carteira diversificada do zero</h3>
                                <p>Ana Paula Ferreira</p>
                                <span class="educacao-data"><?php ironinvest_icon('icon-clock'); ?>22 Mai 2026 às 18h30</span>
                                <button type="button">Assistir gravação</button>
                            </div>
                        </article>
                    </div>

                    <div class="educacao-secao-topo educacao-secao-simples">
                        <h2><span aria-hidden="true"><?php ironinvest_icon('icon-document'); ?></span> E-books Gratuitos</h2>
                    </div>

                    <div class="educacao-ebooks-grid">
                        <article>
                            <span aria-hidden="true"><?php ironinvest_icon('icon-document'); ?></span>
                            <div>
                                <h3>Guia Definitivo do Investidor Iniciante</h3>
                                <p>84 páginas · 12k downloads</p>
                            </div>
                            <button type="button" aria-label="Baixar Guia Definitivo do Investidor Iniciante"><?php ironinvest_icon('icon-download'); ?></button>
                        </article>

                        <article>
                            <span aria-hidden="true"><?php ironinvest_icon('icon-document'); ?></span>
                            <div>
                                <h3>Renda Passiva: Do Sonho à Realidade</h3>
                                <p>56 páginas · 18k downloads</p>
                            </div>
                            <button type="button" aria-label="Baixar Renda Passiva"><?php ironinvest_icon('icon-download'); ?></button>
                        </article>

                        <article>
                            <span aria-hidden="true"><?php ironinvest_icon('icon-document'); ?></span>
                            <div>
                                <h3>Tesouro Direto Passo a Passo</h3>
                                <p>40 páginas · 24k downloads</p>
                            </div>
                            <button type="button" aria-label="Baixar Tesouro Direto Passo a Passo"><?php ironinvest_icon('icon-download'); ?></button>
                        </article>
                    </div>

                    <section class="educacao-cta" aria-labelledby="educacaoCtaTitulo">
                        <span aria-hidden="true"><?php ironinvest_icon('icon-graduation'); ?></span>
                        <h2 id="educacaoCtaTitulo">Pronto para investir melhor?</h2>
                        <p>Abra sua conta na IronInvest e coloque em prática tudo que você aprendeu.</p>
                        <a href="cadastro.html">Abrir Conta Gratuita</a>
                    </section>
                </div>
            </div>
        </section>
    </main>
    <?php else: ?>
    <main class="cadastro-main">
        <section class="container cadastro-layout">
            <div class="cadastro-copy">
                <h1><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p>Área restrita acessada com login. O conteúdo desta seção pode ser desenvolvido depois.</p>
                <div class="hero-buttons">
                    <a class="btn btn-primary" href="index.html">Voltar ao início</a>
                    <form class="logout-inline" action="logout.php" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(ironinvest_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                        <button class="btn btn-secondary" type="submit">Sair</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <?php endif; ?>

    <footer class="footer-site">
        <div class="container footer-container">
            <section class="newsletter" aria-labelledby="newsletterTitulo">
                <div>
                    <h2 id="newsletterTitulo">Receba dicas de investimento</h2>
                    <p>Inscreva-se em nossa newsletter e receba análises exclusivas e oportunidades.</p>
                </div>

                <form class="newsletter-form">
                    <label class="sr-only" for="newsletterEmail">Seu melhor e-mail</label>
                    <input type="email" id="newsletterEmail" inputmode="email" autocomplete="email" placeholder="Seu melhor e-mail" maxlength="160" required>
                    <button type="submit">Inscrever-se</button>
                </form>
            </section>

            <div class="footer-links">
                <div class="footer-brand">
                    <h2>IronInvest</h2>
                    <p>Sua corretora de confiança há mais de 15 anos no mercado financeiro brasileiro.</p>

                    <ul class="footer-contato">
                        <li><span class="footer-icon" aria-hidden="true"><?php ironinvest_icon('icon-map-pin'); ?></span> São Paulo, SP</li>
                        <li><span class="footer-icon" aria-hidden="true"><?php ironinvest_icon('icon-phone'); ?></span> (11) 3000-0000</li>
                        <li><span class="footer-icon" aria-hidden="true"><?php ironinvest_icon('icon-mail'); ?></span> contato@ironinvest.com</li>
                    </ul>

                    <div class="footer-social" aria-label="Redes sociais">
                        <span class="footer-social-placeholder" aria-label="Facebook"><?php ironinvest_icon('icon-facebook'); ?></span>
                        <span class="footer-social-placeholder" aria-label="Instagram"><?php ironinvest_icon('icon-instagram'); ?></span>
                        <span class="footer-social-placeholder" aria-label="Twitter"><?php ironinvest_icon('icon-x'); ?></span>
                        <span class="footer-social-placeholder" aria-label="YouTube"><?php ironinvest_icon('icon-youtube'); ?></span>
                        <span class="footer-social-placeholder" aria-label="LinkedIn"><?php ironinvest_icon('icon-linkedin'); ?></span>
                    </div>
                </div>

                <div class="footer-coluna">
                    <h3>Produtos</h3>
                    <a href="acesso.php?pagina=produtos&amp;ancora=acoes">Ações</a>
                    <a href="acesso.php?pagina=produtos&amp;ancora=fundos-imobiliarios">Fundos Imobiliários</a>
                    <a href="acesso.php?pagina=produtos&amp;ancora=tesouro-direto">Tesouro Direto</a>
                    <a href="acesso.php?pagina=produtos&amp;ancora=cdb-lci-lca">CDB/LCI/LCA</a>
                    <a href="acesso.php?pagina=produtos&amp;ancora=coe">COE</a>
                    <a href="acesso.php?pagina=produtos&amp;ancora=fundos-multimercado">Fundos Multimercado</a>
                </div>

                <div class="footer-coluna">
                    <h3>Empresa</h3>
                    <a href="acesso.php?pagina=sobre">Sobre Nós</a>
                    <span class="footer-link-disabled" aria-disabled="true">Carreiras</span>
                    <span class="footer-link-disabled" aria-disabled="true">Imprensa</span>
                    <span class="footer-link-disabled" aria-disabled="true">Investidores</span>
                    <span class="footer-link-disabled" aria-disabled="true">Responsabilidade Social</span>
                    <a href="acesso.php?pagina=sobre&amp;ancora=certificacoes">Certificações</a>
                </div>

                <div class="footer-coluna">
                    <h3>Suporte</h3>
                    <a href="acesso.php?pagina=suporte&amp;ancora=perguntas">Central de Ajuda</a>
                    <a href="acesso.php?pagina=suporte&amp;ancora=perguntas">Como Investir</a>
                    <a href="acesso.php?pagina=suporte&amp;ancora=perguntas">Abertura de Conta</a>
                    <a href="acesso.php?pagina=suporte&amp;ancora=perguntas">Transferência</a>
                    <a href="acesso.php?pagina=suporte&amp;ancora=perguntas">Regulamentações</a>
                    <a href="acesso.php?pagina=suporte&amp;ancora=contato">Fale Conosco</a>
                </div>

                <div class="footer-coluna">
                    <h3>Educação</h3>
                    <span class="footer-link-disabled" aria-disabled="true">Blog</span>
                    <span class="footer-link-disabled" aria-disabled="true">Cursos Gratuitos</span>
                    <span class="footer-link-disabled" aria-disabled="true">Webinars</span>
                    <span class="footer-link-disabled" aria-disabled="true">E-books</span>
                    <a href="index.html#simulador">Calculadora de Juros</a>
                    <a href="index.html#simulador">Simuladores</a>
                </div>
            </div>

            <div class="footer-base">
                <div class="footer-legal">
                    <span>© 2026 <strong>IronInvest</strong>. Todos os direitos reservados.</span>
                    <span class="footer-link-disabled" aria-disabled="true">Privacidade</span>
                    <span class="footer-link-disabled" aria-disabled="true">Termos de Uso</span>
                    <span class="footer-link-disabled" aria-disabled="true">Cookies</span>
                </div>

                <div class="footer-selos">
                    <span>Regulamentada por:</span>
                    <strong>CVM</strong>
                    <strong>ANBIMA</strong>
                    <strong>FGC</strong>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/js/site.js" defer></script>
    <script src="assets/js/perfil-investidor.js" defer></script>
</body>
</html>
