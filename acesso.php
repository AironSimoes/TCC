<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';

ironinvest_iniciar_sessao();

$pagina = strtolower(trim($_GET['pagina'] ?? ''));
$ancora = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['ancora'] ?? '') ?? '';

$rotas = [
    'sobre' => 'sobre.php',
    'produtos' => 'produtos.php',
    'suporte' => 'suporte.php',
    'analises' => 'area-restrita.php?area=analises',
    'educacao' => 'area-restrita.php?area=educacao',
];

if (!isset($rotas[$pagina])) {
    ironinvest_redirecionar('index.html');
}

$destino = 'acesso.php?pagina=' . rawurlencode($pagina);
if ($ancora !== '') {
    $destino .= '&ancora=' . rawurlencode($ancora);
}

ironinvest_exigir_login($destino);

$url = $rotas[$pagina];
if ($ancora !== '' && in_array($pagina, ['sobre', 'produtos', 'suporte'], true)) {
    $url .= '#' . $ancora;
}

ironinvest_redirecionar($url);
