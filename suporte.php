<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';
require __DIR__ . '/app/icon-sprite.php';

ironinvest_iniciar_sessao();
ironinvest_exigir_login('acesso.php?pagina=suporte');
ironinvest_header_html();
?><!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Central de suporte IronInvest com perguntas frequentes, canais de atendimento e ajuda para investidores." />
    <meta name="referrer" content="strict-origin-when-cross-origin" />
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self' https://fonts.googleapis.com; font-src https://fonts.gstatic.com; img-src 'self' data:; object-src 'none'; base-uri 'self'; form-action 'self'; connect-src 'self'; upgrade-insecure-requests">
    <title>Suporte IronInvest</title>
    <link rel="shortcut icon" href="assets/img/iron 512x512.png" type="image/x-icon">
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
                <img src="assets/img/iron 300x80.png" alt="Logo IronInvest" class="logo" width="300" height="80" decoding="async">
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
                    <li><a href="index.html#produtos">Produtos</a></li>
                    <li><a class="menu-restrito" href="acesso.php?pagina=analises">Análises</a></li>
                    <li><a class="menu-restrito" href="acesso.php?pagina=educacao">Educação</a></li>
                    <li><a href="acesso.php?pagina=suporte" aria-current="page">Suporte</a></li>
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
                    <input type="email" id="loginEmail" name="email" inputmode="email" autocomplete="email" placeholder="seu@email.com" required>
                </div>

                <div class="login-campo">
                    <label for="loginSenha">
                        <span class="login-label-icon login-label-lock" aria-hidden="true"></span>
                        Senha
                    </label>
                    <input type="password" id="loginSenha" name="senha" autocomplete="current-password" minlength="8" placeholder="Mínimo 8 caracteres" required>
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

    <main class="suporte" id="suporte">
        <section class="suporte-hero">
            <div class="container suporte-container">
                <div class="suporte-hero-conteudo">
                    <span class="suporte-hero-icone" aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span>
                    <h1>Como Podemos <span>Ajudar?</span></h1>
                    <p>Encontre respostas rápidas para as perguntas mais frequentes sobre a <strong>IronInvest</strong></p>

                    <form class="suporte-busca" role="search">
                        <label class="sr-only" for="suporteBusca">Buscar por pergunta ou palavra-chave</label>
                        <span aria-hidden="true"><?php ironinvest_icon('icon-search'); ?></span>
                        <input type="search" id="suporteBusca" autocomplete="off" placeholder="Buscar por pergunta ou palavra-chave...">
                    </form>
                </div>
            </div>
        </section>

        <section class="suporte-faq" id="perguntas">
            <div class="container suporte-container">
                <div class="suporte-categorias" aria-label="Perguntas frequentes">
                    <details class="suporte-categoria suporte-categoria-amarela">
                        <summary>
                            <span class="suporte-categoria-icone" aria-hidden="true"><?php ironinvest_icon('icon-users'); ?></span>
                            <strong>Conta e Cadastro</strong>
                            <span class="suporte-categoria-acao" aria-hidden="true"></span>
                        </summary>

                        <div class="suporte-perguntas">
                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Como faço para abrir minha conta na IronInvest?</summary>
                                <p>Você pode abrir sua conta pelo botão "Abrir Conta", preencher seus dados e enviar a documentação solicitada. A análise costuma ser concluída em poucos minutos.</p>
                            </details>

                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Existe taxa para abertura de conta?</summary>
                                <p>Não! A abertura de conta na IronInvest é 100% gratuita. Também não cobramos taxa de manutenção mensal. Você só paga taxas quando realizar operações específicas, e sempre de forma transparente.</p>
                            </details>

                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Encerrei minha conta, como faço para reabri-la?</summary>
                                <p>Para reabrir sua conta, entre em contato com nosso suporte através do telefone 0800 123 4567 ou pelo e-mail suporte@ironinvest.com.br. Nossa equipe irá verificar sua solicitação e orientar sobre os próximos passos. O processo é rápido e você poderá voltar a investir em breve.</p>
                            </details>
                        </div>
                    </details>

                    <details class="suporte-categoria suporte-categoria-verde">
                        <summary>
                            <span class="suporte-categoria-icone" aria-hidden="true"><?php ironinvest_icon('icon-trend'); ?></span>
                            <strong>Investimentos</strong>
                            <span class="suporte-categoria-acao" aria-hidden="true"></span>
                        </summary>

                        <div class="suporte-perguntas">
                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Qual o valor mínimo para começar a investir?</summary>
                                <p>Você pode começar a investir com valores a partir de R$ 1,00 em alguns produtos como fundos de investimento. Para ações e outros ativos, o valor mínimo varia conforme o preço unitário de cada ativo no mercado.</p>
                            </details>

                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Como funciona a tributação dos investimentos?</summary>
                                <p>A tributação varia conforme o tipo de investimento. Renda fixa geralmente segue a tabela regressiva do IR (de 22,5% a 15%). Ações têm alíquota de 15% sobre o lucro em operações comuns. Oferecemos relatórios completos para sua declaração de IR.</p>
                            </details>

                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Como escolher o melhor investimento para mim?</summary>
                                <p>Ao abrir sua conta, você responderá um questionário de suitability que identifica seu perfil de investidor (conservador, moderado ou arrojado). Com base nisso, recomendamos produtos adequados ao seu perfil, objetivos e prazo.</p>
                            </details>
                        </div>
                    </details>

                    <details class="suporte-categoria suporte-categoria-amarela">
                        <summary>
                            <span class="suporte-categoria-icone" aria-hidden="true"><?php ironinvest_icon('icon-credit-card'); ?></span>
                            <strong>Depósitos e Saques</strong>
                            <span class="suporte-categoria-acao" aria-hidden="true"></span>
                        </summary>

                        <div class="suporte-perguntas">
                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Como fazer um depósito na minha conta?</summary>
                                <p>Transfira via Pix ou TED usando uma conta bancária de mesma titularidade. Assim que confirmado, o saldo aparece na plataforma.</p>
                            </details>

                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Quanto tempo demora para o saldo aparecer?</summary>
                                <p>Depósitos via Pix normalmente aparecem em poucos minutos. TEDs podem depender do horário de compensação bancária.</p>
                            </details>

                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Como solicitar um saque?</summary>
                                <p>No painel da conta, acesse a área de transferências, escolha a conta cadastrada e confirme a solicitação de retirada.</p>
                            </details>
                        </div>
                    </details>

                    <details class="suporte-categoria suporte-categoria-verde">
                        <summary>
                            <span class="suporte-categoria-icone" aria-hidden="true"><?php ironinvest_icon('icon-shield'); ?></span>
                            <strong>Segurança</strong>
                            <span class="suporte-categoria-acao" aria-hidden="true"></span>
                        </summary>

                        <div class="suporte-perguntas">
                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Meu dinheiro está seguro na IronInvest?</summary>
                                <p>Sim. Trabalhamos com proteção de dados, autenticação segura e produtos regulados conforme as regras do mercado financeiro.</p>
                            </details>

                            <details class="suporte-pergunta">
                                <summary><span aria-hidden="true"><?php ironinvest_icon('icon-question'); ?></span> Como protejo minha conta de fraudes?</summary>
                                <p>Ative recursos de segurança, nunca compartilhe senhas e confirme se está acessando os canais oficiais da IronInvest.</p>
                            </details>
                        </div>
                    </details>
                </div>
            </div>
        </section>

        <section class="suporte-contato" id="contato">
            <div class="container suporte-container">
                <div class="suporte-secao-cabecalho">
                    <h2>Ainda Precisa de <span>Ajuda?</span></h2>
                    <p>Nossa equipe está pronta para atender você</p>
                </div>

                <div class="suporte-contato-grid">
                    <article class="suporte-contato-card suporte-contato-amarelo">
                        <span class="suporte-contato-icone" aria-hidden="true"><?php ironinvest_icon('icon-phone'); ?></span>
                        <h3>Telefone</h3>
                        <strong>0800 123 4567</strong>
                        <p>Seg-Sex: 8h-20h | Sáb: 9h-15h</p>
                    </article>

                    <article class="suporte-contato-card suporte-contato-verde">
                        <span class="suporte-contato-icone" aria-hidden="true"><?php ironinvest_icon('icon-mail'); ?></span>
                        <h3>E-mail</h3>
                        <strong>suporte@ironinvest.com.br</strong>
                        <p>Resposta em até 24 horas</p>
                    </article>

                    <article class="suporte-contato-card suporte-contato-amarelo">
                        <span class="suporte-contato-icone" aria-hidden="true"><?php ironinvest_icon('icon-message'); ?></span>
                        <h3>Chat Online</h3>
                        <strong>Disponível no App</strong>
                        <p>Atendimento 24/7</p>
                    </article>
                </div>

                <div class="suporte-cliente-card">
                    <h2>Ainda não é cliente?</h2>
                    <p>Abra sua conta e comece a investir hoje mesmo com a <strong>IronInvest</strong></p>
                    <a href="cadastro.html">Abrir Minha Conta Grátis <span aria-hidden="true">→</span></a>
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
                    <input type="email" id="newsletterEmail" inputmode="email" autocomplete="email" placeholder="Seu melhor e-mail">
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
                    <a href="index.html#produtos">Ações</a>
                    <a href="index.html#produtos">Fundos Imobiliários</a>
                    <a href="index.html#produtos">Tesouro Direto</a>
                    <a href="index.html#produtos">CDB/LCI/LCA</a>
                    <a href="index.html#produtos">Fundos de Investimento</a>
                    <a href="index.html#produtos">Previdência Privada</a>
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
</body>
</html>
