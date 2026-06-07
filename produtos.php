<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';
require __DIR__ . '/app/icon-sprite.php';

ironinvest_iniciar_sessao();
ironinvest_exigir_login('acesso.php?pagina=produtos');
ironinvest_header_html();

$produtos = [
    [
        'id' => 'acoes',
        'classe' => 'acoes',
        'icone' => 'icon-trend',
        'nome' => 'Ações',
        'subtitulo' => 'Seja sócio das maiores empresas do Brasil',
        'risco' => 'Alto',
        'risco_classe' => 'alto',
        'rendimento' => 'Até 25% ao ano',
        'minimo' => 'A partir de 1 ação (varia por empresa)',
        'resumo' => 'Ações são frações do capital social de uma empresa aberta na bolsa de valores. Quando você compra uma ação, torna-se oficialmente sócio daquela companhia, com direito a participar dos lucros e da valorização do negócio.',
        'funcionamento' => 'As ações são negociadas diariamente na B3 (Bolsa de Valores do Brasil). O preço oscila conforme resultados trimestrais, perspectivas de crescimento, cenário econômico e humor do mercado. Você pode ganhar pela valorização das ações ou pelos dividendos, que são parte do lucro distribuída periodicamente pela empresa.',
        'vantagens' => [
            'Maior potencial de retorno no longo prazo',
            'Dividendos isentos de IR para pessoa física',
            'Alta liquidez, com negociação nos dias de pregão',
            'Diversificação em diferentes setores da economia',
        ],
        'atencao' => [
            'O preço oscila diariamente e exige tolerância à volatilidade',
            'É importante estudar as empresas antes de investir',
            'O horizonte recomendado é de, no mínimo, 3 a 5 anos',
        ],
        'indicado' => 'Ideal para investidores de perfil moderado a arrojado, com horizonte de longo prazo e disposição para estudar as empresas. Não é indicado para quem precisará do dinheiro no curto prazo.',
    ],
    [
        'id' => 'fundos-imobiliarios',
        'classe' => 'fiis',
        'icone' => 'icon-building',
        'nome' => 'Fundos Imobiliários (FIIs)',
        'subtitulo' => 'Renda de imóveis sem precisar comprar um',
        'risco' => 'Médio',
        'risco_classe' => 'medio',
        'rendimento' => '8–12% ao ano',
        'minimo' => 'A partir de 1 cota (geralmente R$ 10 a R$ 200)',
        'resumo' => 'Os Fundos de Investimento Imobiliário permitem investir no mercado imobiliário comprando cotas de fundos que possuem imóveis físicos, como shoppings, galpões, hospitais e escritórios, ou títulos de crédito imobiliário. Tudo pela bolsa e sem a burocracia de um imóvel próprio.',
        'funcionamento' => 'O fundo recebe os aluguéis dos imóveis ou os juros dos títulos e distribui aos cotistas pelo menos 95% do lucro apurado, conforme as regras aplicáveis. Você recebe esse valor em sua conta como renda passiva, enquanto o preço das cotas também pode oscilar no mercado.',
        'vantagens' => [
            'Renda mensal de aluguéis sem administrar um imóvel',
            'Rendimentos geralmente isentos de IR para pessoa física, conforme a legislação',
            'Acesso a imóveis de alto padrão com pouco capital',
            'Diversificação dentro do próprio fundo',
        ],
        'atencao' => [
            'As cotas oscilam no mercado e podem se desvalorizar',
            'Vacância e inadimplência podem reduzir os rendimentos',
            'Há cobrança de taxa de administração pelo gestor',
        ],
        'indicado' => 'Perfeito para quem busca renda passiva mensal e diversificação. Pode complementar a aposentadoria ou compor uma carteira de renda, atendendo principalmente a perfis conservadores e moderados.',
    ],
    [
        'id' => 'tesouro-direto',
        'classe' => 'tesouro',
        'icone' => 'icon-shield',
        'nome' => 'Tesouro Direto',
        'subtitulo' => 'A opção mais segura do mercado brasileiro',
        'risco' => 'Baixo',
        'risco_classe' => 'baixo',
        'rendimento' => 'Selic + até 2% ao ano',
        'minimo' => 'A partir de R$ 30',
        'resumo' => 'O Tesouro Direto é um programa do governo federal que permite que qualquer pessoa física compre títulos da dívida pública. Na prática, você empresta dinheiro ao governo e recebe o valor de volta com juros.',
        'funcionamento' => 'Existem três tipos principais: Tesouro Selic, indicado para reserva de emergência; Tesouro IPCA+, que acompanha a inflação e adiciona uma taxa; e Tesouro Prefixado, cuja rentabilidade é conhecida na compra. Os títulos têm liquidez diária, mas resgates antes do vencimento podem sofrer oscilações de preço.',
        'vantagens' => [
            'Garantia do Tesouro Nacional',
            'Liquidez diária em todos os títulos',
            'Investimento inicial acessível',
            'Plataforma gratuita e simples de usar',
        ],
        'atencao' => [
            'Incidência de Imposto de Renda regressivo',
            'Cobrança de IOF para resgates em menos de 30 dias',
            'Títulos Prefixados e IPCA+ podem oscilar antes do vencimento',
        ],
        'indicado' => 'Indicado para todos os perfis. O Tesouro Selic é especialmente recomendado para a reserva de emergência, enquanto o IPCA+ atende bem a objetivos de longo prazo, como aposentadoria.',
    ],
    [
        'id' => 'cdb-lci-lca',
        'classe' => 'renda-fixa',
        'icone' => 'icon-trend',
        'nome' => 'CDB / LCI / LCA',
        'subtitulo' => 'Renda fixa que rende mais que a poupança',
        'risco' => 'Baixo',
        'risco_classe' => 'baixo',
        'rendimento' => 'Até 130% do CDI',
        'minimo' => 'A partir de R$ 1.000 (varia por banco)',
        'resumo' => 'CDB, LCI e LCA são títulos de renda fixa emitidos por bancos. Ao investir, você empresta dinheiro à instituição financeira e recebe juros por isso.',
        'funcionamento' => 'O banco define uma taxa de retorno, geralmente um percentual do CDI ou uma taxa prefixada. LCI e LCA são isentas de Imposto de Renda para pessoa física; o CDB segue a tabela regressiva. Esses produtos podem contar com a garantia do FGC até os limites e condições vigentes.',
        'vantagens' => [
            'LCI e LCA isentas de IR para pessoa física',
            'Cobertura do FGC até os limites regulamentares',
            'Diversas opções de prazo e liquidez',
            'Produtos simples de entender e contratar',
        ],
        'atencao' => [
            'CDB tem incidência de Imposto de Renda regressivo',
            'Alguns produtos possuem carência e não permitem resgate antecipado',
            'Existe risco de crédito da instituição emissora',
        ],
        'indicado' => 'Excelente para perfis conservadores e moderados que buscam rentabilidade superior à poupança com baixo risco. LCI e LCA podem ser vantajosas para quem deseja eficiência tributária.',
    ],
    [
        'id' => 'coe',
        'classe' => 'coe',
        'icone' => 'icon-document',
        'nome' => 'COE',
        'subtitulo' => 'Exposição internacional com capital protegido',
        'risco' => 'Médio',
        'risco_classe' => 'medio',
        'rendimento' => '100% do capital + prêmio variável',
        'minimo' => 'A partir de R$ 5.000 (varia por emissão)',
        'resumo' => 'O COE (Certificado de Operações Estruturadas) é um produto financeiro híbrido que combina características da renda fixa com exposição a ativos de risco, como índices internacionais, moedas ou commodities. Algumas emissões oferecem proteção parcial ou total do capital no vencimento.',
        'funcionamento' => 'Você investe por um prazo predefinido, geralmente de 2 a 5 anos. No vencimento, recebe o valor estabelecido nas condições da emissão e um possível ganho ligado ao desempenho do ativo de referência. As regras de proteção, participação nos ganhos e perdas variam em cada oferta.',
        'vantagens' => [
            'Exposição a mercados internacionais com risco controlado',
            'Possibilidade de proteção do capital no vencimento',
            'Ganhos vinculados a ativos que exigiriam maior conhecimento técnico',
            'Diversificação além do mercado brasileiro',
        ],
        'atencao' => [
            'Baixa liquidez e possíveis custos para resgate antecipado',
            'Rentabilidade pode ser limitada pelas regras da emissão',
            'Investimento mínimo geralmente mais elevado',
        ],
        'indicado' => 'Indicado para investidores de perfil moderado que desejam exposição cambial ou a índices internacionais com regras de proteção. Não é recomendado para quem pode precisar do dinheiro antes do vencimento.',
    ],
    [
        'id' => 'fundos-multimercado',
        'classe' => 'multimercado',
        'icone' => 'icon-pulse',
        'nome' => 'Fundos Multimercado',
        'subtitulo' => 'Gestão profissional em múltiplas classes de ativos',
        'risco' => 'Médio',
        'risco_classe' => 'medio',
        'rendimento' => 'CDI + 3% ao ano (média histórica)',
        'minimo' => 'A partir de R$ 500 (varia por fundo)',
        'resumo' => 'Fundos Multimercado podem alocar o patrimônio dos cotistas em diversas classes de ativos, como renda fixa, ações, câmbio, commodities e derivativos. As decisões são conduzidas por equipes de gestão profissional.',
        'funcionamento' => 'Você compra cotas do fundo e um gestor decide onde alocar o capital para buscar o melhor retorno possível dentro da estratégia definida. A diversificação reduz a concentração em uma única categoria, enquanto taxas de administração e, em alguns casos, de performance impactam o resultado.',
        'vantagens' => [
            'Diversificação automática entre múltiplas classes',
            'Gestão realizada por profissionais especializados',
            'Possibilidade de retornos superiores ao CDI',
            'Acesso a estratégias complexas de forma simplificada',
        ],
        'atencao' => [
            'Taxas de administração e performance reduzem o retorno líquido',
            'Rentabilidade passada não garante resultados futuros',
            'A liquidez pode variar de diária a mensal, conforme o fundo',
        ],
        'indicado' => 'Indicado para investidores de perfil moderado a arrojado que desejam delegar a gestão a profissionais e diversificar automaticamente. Pode compor uma parcela da carteira que busca retorno acima da renda fixa.',
    ],
];

function produtos_h(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}
?><!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Conheça em detalhes os produtos de investimento disponíveis na IronInvest." />
    <meta name="referrer" content="strict-origin-when-cross-origin" />
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self' https://fonts.googleapis.com; font-src https://fonts.gstatic.com; img-src 'self' data:; object-src 'none'; base-uri 'self'; form-action 'self'; connect-src 'self'; upgrade-insecure-requests">
    <title>Produtos de Investimento | IronInvest</title>
    <link rel="shortcut icon" href="assets/img/iron 512x512.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="assets/js/theme-init.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="produtos-page">
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
                    <li><a href="produtos.php" aria-current="page">Produtos</a></li>
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
                <input type="hidden" name="csrf_token" value="<?php echo produtos_h(ironinvest_csrf_token()); ?>">
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

    <main class="produtos-pagina">
        <section class="produtos-pagina-hero" aria-labelledby="produtosPaginaTitulo">
            <div class="container produtos-pagina-container">
                <span class="produtos-pagina-kicker">IronInvest</span>
                <h1 id="produtosPaginaTitulo">Produtos de <span>Investimento</span></h1>
                <p>Conheça em detalhes cada produto disponível na IronInvest e descubra qual combina com o seu perfil e objetivo.</p>
            </div>
        </section>

        <section class="produtos-catalogo" aria-label="Catálogo de produtos de investimento">
            <div class="container produtos-pagina-container">
                <div class="produtos-risco-legenda" aria-label="Legenda dos níveis de risco">
                    <span>Nível de risco:</span>
                    <span class="produto-risco produto-risco-baixo">Baixo</span>
                    <span class="produto-risco produto-risco-medio">Médio</span>
                    <span class="produto-risco produto-risco-alto">Alto</span>
                </div>

                <div class="produtos-catalogo-lista">
                    <?php foreach ($produtos as $produto): ?>
                    <article class="produto-catalogo-card produto-catalogo-<?php echo produtos_h($produto['classe']); ?>" id="<?php echo produtos_h($produto['id']); ?>" data-produto-card>
                        <div class="produto-catalogo-resumo">
                            <div class="produto-catalogo-cabecalho">
                                <div class="produto-catalogo-identidade">
                                    <span class="produto-catalogo-icone" aria-hidden="true"><?php ironinvest_icon($produto['icone']); ?></span>
                                    <div>
                                        <h2><?php echo produtos_h($produto['nome']); ?></h2>
                                        <p><?php echo produtos_h($produto['subtitulo']); ?></p>
                                    </div>
                                </div>
                                <span class="produto-risco produto-risco-<?php echo produtos_h($produto['risco_classe']); ?>"><?php echo produtos_h($produto['risco']); ?></span>
                            </div>

                            <div class="produto-catalogo-metricas">
                                <div>
                                    <span>Rendimento estimado</span>
                                    <strong><?php echo produtos_h($produto['rendimento']); ?></strong>
                                </div>
                                <div>
                                    <span>Investimento mínimo</span>
                                    <strong><?php echo produtos_h($produto['minimo']); ?></strong>
                                </div>
                            </div>

                            <p class="produto-catalogo-descricao"><?php echo produtos_h($produto['resumo']); ?></p>

                            <button class="produto-detalhes-toggle" type="button" aria-expanded="false" aria-controls="detalhes-<?php echo produtos_h($produto['id']); ?>" data-produto-toggle>
                                <span data-produto-toggle-label>Ver detalhes completos</span>
                                <span class="produto-toggle-seta" aria-hidden="true"></span>
                            </button>
                        </div>

                        <div class="produto-catalogo-detalhes" id="detalhes-<?php echo produtos_h($produto['id']); ?>" data-produto-panel hidden>
                            <section class="produto-detalhe-bloco">
                                <span class="produto-detalhe-icone produto-detalhe-icone-info" aria-hidden="true"><?php ironinvest_icon('icon-clock'); ?></span>
                                <div>
                                    <h3>Como funciona</h3>
                                    <p><?php echo produtos_h($produto['funcionamento']); ?></p>
                                </div>
                            </section>

                            <section class="produto-detalhe-bloco">
                                <span class="produto-detalhe-icone produto-detalhe-icone-vantagem" aria-hidden="true"><?php ironinvest_icon('icon-check-circle'); ?></span>
                                <div>
                                    <h3>Vantagens</h3>
                                    <ul class="produto-detalhe-lista produto-detalhe-lista-vantagens">
                                        <?php foreach ($produto['vantagens'] as $vantagem): ?>
                                        <li><?php echo produtos_h($vantagem); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </section>

                            <section class="produto-detalhe-bloco">
                                <span class="produto-detalhe-icone produto-detalhe-icone-atencao" aria-hidden="true">△</span>
                                <div>
                                    <h3>Pontos de atenção</h3>
                                    <ul class="produto-detalhe-lista produto-detalhe-lista-atencao">
                                        <?php foreach ($produto['atencao'] as $ponto): ?>
                                        <li><?php echo produtos_h($ponto); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </section>

                            <section class="produto-indicado">
                                <span aria-hidden="true"><?php ironinvest_icon('icon-shield'); ?></span>
                                <div>
                                    <h3>Para quem é indicado</h3>
                                    <p><?php echo produtos_h($produto['indicado']); ?></p>
                                </div>
                            </section>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <section class="produtos-pagina-cta">
                    <h2>Pronto para começar a investir?</h2>
                    <p>Abra sua conta gratuitamente e comece a investir com segurança e inteligência.</p>
                    <a href="cadastro.html">Abrir conta grátis <span aria-hidden="true">→</span></a>
                </section>
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
                    <a href="#acoes">Ações</a>
                    <a href="#fundos-imobiliarios">Fundos Imobiliários</a>
                    <a href="#tesouro-direto">Tesouro Direto</a>
                    <a href="#cdb-lci-lca">CDB/LCI/LCA</a>
                    <a href="#coe">COE</a>
                    <a href="#fundos-multimercado">Fundos Multimercado</a>
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
    <script src="assets/js/produtos-pagina.js" defer></script>
</body>
</html>
