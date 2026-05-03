<?php
declare(strict_types=1);

function ironinvest_cookie_seguro(): bool
{
    return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
}

function ironinvest_iniciar_sessao(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    session_name('ironinvest_sessao');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => ironinvest_cookie_seguro(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function ironinvest_pdo(): PDO
{
    $dsn = getenv('DB_DSN') ?: 'mysql:host=localhost;dbname=ironinvest;charset=utf8mb4';
    $usuario = getenv('DB_USER') ?: 'root';
    $senha = getenv('DB_PASS') ?: '';

    return new PDO($dsn, $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}

function ironinvest_redirecionar(string $destino): never
{
    header("Location: {$destino}");
    exit;
}
