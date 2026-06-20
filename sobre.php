<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';
require __DIR__ . '/app/icon-sprite.php';

ironinvest_iniciar_sessao();
ironinvest_exigir_login('acesso.php?pagina=sobre');
ironinvest_header_html();
?><!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Conheça a história, missão, valores e certificações da IronInvest." />
    <meta name="referrer" content="strict-origin-when-cross-origin" />
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self' https://fonts.googleapis.com; font-src https://fonts.gstatic.com; img-src 'self' data:; object-src 'none'; base-uri 'self'; form-action 'self'; connect-src 'self'; upgrade-insecure-requests">
    <title>Sobre a IronInvest</title>
    <link rel="shortcut icon" href="assets/img/iron 512x512.png" type="image/x-icon">
    <link rel="preload" href="assets/img/sede-ironinvest.jpg" as="image" fetchpriority="high">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="assets/js/theme-init.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
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
                    <li><a href="acesso.php?pagina=sobre" aria-current="page">Sobre</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a class="menu-restrito" href="acesso.php?pagina=analises">Análises</a></li>
                    <li><a class="menu-restrito" href="acesso.php?pagina=educacao">Educação</a></li>
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

    <main class="sobre" id="sobre">
        <section class="sobre-topo">
            <div class="container sobre-container">
                <div class="sobre-intro">
                    <h1>Sobre a <span>IronInvest</span></h1>
                    <p>Há mais de 15 anos transformando a vida financeira de milhares de brasileiros através de investimentos inteligentes, seguros e acessíveis.</p>
                </div>

                <div class="sobre-metricas" aria-label="Números da IronInvest">
                    <article class="sobre-metrica-card">
                        <strong>15+</strong>
                        <span>Anos de Mercado</span>
                    </article>

                    <article class="sobre-metrica-card">
                        <strong>500K+</strong>
                        <span>Clientes Ativos</span>
                    </article>

                    <article class="sobre-metrica-card">
                        <strong>R$ 50Bi+</strong>
                        <span>Sob Custódia</span>
                    </article>

                    <article class="sobre-metrica-card">
                        <strong>98%</strong>
                        <span>Satisfação</span>
                    </article>
                </div>
            </div>
        </section>

        <section class="container sobre-container">
            <div class="sobre-historia">
                <div class="sobre-historia-texto">
                    <h2>Nossa História</h2>
                    <p>A <strong>IronInvest</strong> nasceu em 2009 com um propósito claro: democratizar o acesso aos investimentos no Brasil e provar que é possível construir riqueza de forma sólida e segura.</p>
                    <p>Fundada por profissionais experientes do mercado financeiro, começamos como uma pequena corretora em São Paulo. Nossa filosofia sempre foi colocar o cliente em primeiro lugar e investir em tecnologia e educação financeira.</p>
                    <p>Hoje somos uma das principais corretoras do país, com presença nacional e tecnologia de ponta que compete com as maiores do mundo, sempre focados em oferecer as melhores oportunidades de investimento.</p>
                </div>

                <figure class="sobre-historia-imagem">
                    <img src="assets/img/sede-ironinvest.jpg" alt="Prédio corporativo representando a sede da IronInvest" width="459" height="374" fetchpriority="high" decoding="async">
                    <span class="sobre-foto-selo sobre-foto-selo-topo" aria-hidden="true"><?php ironinvest_icon('icon-award'); ?></span>
                    <span class="sobre-foto-selo sobre-foto-selo-baixo" aria-hidden="true"><?php ironinvest_icon('icon-building'); ?></span>
                </figure>
            </div>
        </section>

        <section class="sobre-missao-faixa">
            <div class="container sobre-container">
                <div class="sobre-missao-grid">
                    <article class="sobre-missao-card sobre-card-amarelo">
                        <span class="sobre-card-icone sobre-icone-amarelo" aria-hidden="true"><?php ironinvest_icon('icon-target'); ?></span>
                        <h3>Nossa Missão</h3>
                        <p>Democratizar o acesso aos investimentos no Brasil, oferecendo ferramentas, conhecimento e suporte necessários para que cada pessoa possa construir um futuro financeiro sólido e próspero.</p>
                    </article>

                    <article class="sobre-missao-card sobre-card-verde">
                        <span class="sobre-card-icone sobre-icone-verde" aria-hidden="true"><?php ironinvest_icon('icon-lightbulb'); ?></span>
                        <h3>Nossa Visão</h3>
                        <p>Ser a corretora de investimentos mais confiável e inovadora do Brasil, reconhecida pela excelência no atendimento e por transformar positivamente a vida financeira de milhões de brasileiros.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="sobre-valores-faixa">
            <div class="container sobre-container">
                <div class="sobre-secao-cabecalho">
                    <h2>Nossos Valores</h2>
                    <p>Os princípios que guiam todas as nossas ações</p>
                </div>

                <div class="sobre-valores-grid">
                    <article class="sobre-valor-card">
                        <span class="sobre-valor-icone" aria-hidden="true"><?php ironinvest_icon('icon-shield'); ?></span>
                        <h3>Segurança</h3>
                        <p>Protegemos seus investimentos com as mais rigorosas medidas de segurança e regulamentação CVM.</p>
                    </article>

                    <article class="sobre-valor-card">
                        <span class="sobre-valor-icone" aria-hidden="true"><?php ironinvest_icon('icon-heart'); ?></span>
                        <h3>Transparência</h3>
                        <p>Todas as taxas, custos e informações são claras e acessíveis para nossos clientes.</p>
                    </article>

                    <article class="sobre-valor-card">
                        <span class="sobre-valor-icone" aria-hidden="true"><?php ironinvest_icon('icon-handshake'); ?></span>
                        <h3>Confiança</h3>
                        <p>Relacionamentos duradouros baseados em ética e comprometimento com seu sucesso.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="sobre-certificacoes-faixa" id="certificacoes">
            <div class="container sobre-container">
                <div class="sobre-secao-cabecalho">
                    <h2>Certificações e Reconhecimentos</h2>
                    <p>Sua segurança é nossa prioridade</p>
                </div>

                <div class="sobre-certificacoes-grid">
                    <article class="sobre-certificacao-card">
                        <span class="sobre-certificacao-icone" aria-hidden="true"><?php ironinvest_icon('icon-check-circle'); ?></span>
                        <h3>CVM Regulada</h3>
                        <p>Autorizada e fiscalizada pela Comissão de Valores Mobiliários</p>
                    </article>

                    <article class="sobre-certificacao-card">
                        <span class="sobre-certificacao-icone" aria-hidden="true"><?php ironinvest_icon('icon-lock'); ?></span>
                        <h3>ISO 27001</h3>
                        <p>Certificação internacional em segurança da informação</p>
                    </article>

                    <article class="sobre-certificacao-card">
                        <span class="sobre-certificacao-icone" aria-hidden="true"><?php ironinvest_icon('icon-award'); ?></span>
                        <h3>B3 Oficial</h3>
                        <p>Membro oficial da B3 (Bolsa de Valores Brasileira)</p>
                    </article>

                    <article class="sobre-certificacao-card">
                        <span class="sobre-certificacao-icone" aria-hidden="true"><?php ironinvest_icon('icon-shield'); ?></span>
                        <h3>FGC Protegido</h3>
                        <p>Seus investimentos protegidos pelo Fundo Garantidor de Créditos</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="sobre-cta-faixa">
            <div class="container sobre-container">
                <div class="sobre-cta">
                    <h2>Faça Parte da Nossa História</h2>
                    <p>Junte-se a mais de 500 mil investidores que já confiam na <strong>IronInvest</strong> para construir um futuro financeiro próspero.</p>
                    <div class="sobre-cta-acoes">
                        <a href="cadastro.html" class="sobre-cta-primario">Abrir Minha Conta</a>
                        <a href="#newsletterTitulo" class="sobre-cta-secundario">Falar com Consultor</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
