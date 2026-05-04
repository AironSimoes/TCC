<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';

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
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="referrer" content="strict-origin-when-cross-origin" />
    <title><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?> | IronInvest</title>
    <link rel="shortcut icon" href="assets/img/iron 512x512.png" type="image/x-icon">
    <script src="assets/js/theme-init.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="cadastro-main">
        <section class="container cadastro-layout">
            <div class="cadastro-copy">
                <h1><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p>Área restrita acessada com login. O conteúdo desta seção pode ser desenvolvido depois.</p>
                <div class="hero-buttons">
                    <a class="btn btn-primary" href="index.html">Voltar ao início</a>
                    <a class="btn btn-secondary" href="logout.php">Sair</a>
                </div>
            </div>
        </section>
    </main>
    <script src="assets/js/site.js" defer></script>
</body>
</html>
