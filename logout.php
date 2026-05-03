<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';

ironinvest_iniciar_sessao();

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
