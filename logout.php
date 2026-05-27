<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';

ironinvest_iniciar_sessao();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ironinvest_redirecionar('index.html');
}

if (!ironinvest_csrf_valido()) {
    ironinvest_redirecionar('index.html?login=csrf#login');
}

$_SESSION = [];

$parametros = session_get_cookie_params();
setcookie(session_name(), '', [
    'expires' => time() - 3600,
    'path' => $parametros['path'],
    'domain' => $parametros['domain'] ?? '',
    'secure' => $parametros['secure'],
    'httponly' => $parametros['httponly'],
    'samesite' => $parametros['samesite'] ?? 'Lax',
]);

session_destroy();

ironinvest_redirecionar('index.html');
