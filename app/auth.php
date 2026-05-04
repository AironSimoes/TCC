<?php
declare(strict_types=1);

function ironinvest_config(): array
{
    static $config = null;

    if ($config !== null) {
        return $config;
    }

    $arquivoConfig = __DIR__ . '/config.php';
    $config = is_file($arquivoConfig) ? require $arquivoConfig : [];

    return is_array($config) ? $config : [];
}

function ironinvest_config_valor(string $chave, string $padrao): string
{
    $env = getenv($chave);

    if (is_string($env) && $env !== '') {
        return $env;
    }

    $config = ironinvest_config();
    $chaveConfig = strtolower($chave);

    return isset($config[$chaveConfig]) && is_string($config[$chaveConfig])
        ? $config[$chaveConfig]
        : $padrao;
}

function ironinvest_cookie_seguro(): bool
{
    return (
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
    );
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
    $dsn = ironinvest_config_valor('DB_DSN', 'mysql:host=localhost;dbname=ironinvest;charset=utf8mb4');
    $usuario = ironinvest_config_valor('DB_USER', 'root');
    $senha = ironinvest_config_valor('DB_PASS', '');

    return new PDO($dsn, $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}

function ironinvest_redirecionar(string $destino): never
{
    if (headers_sent()) {
        exit;
    }

    header("Location: {$destino}");
    exit;
}

function ironinvest_cliente_logado(): bool
{
    return isset($_SESSION['cliente_id']) && (int) $_SESSION['cliente_id'] > 0;
}

function ironinvest_destino_permitido(string $destino): bool
{
    if ($destino === '' || preg_match('/^https?:\/\//i', $destino)) {
        return false;
    }

    $partes = parse_url($destino);

    if ($partes === false || isset($partes['host']) || isset($partes['scheme'])) {
        return false;
    }

    $caminho = ltrim($partes['path'] ?? '', '/');

    return in_array($caminho, [
        'index.html',
        'acesso.php',
        'sobre.php',
        'suporte.php',
        'area-restrita.php',
    ], true);
}

function ironinvest_destino_login(string $destino): string
{
    return ironinvest_destino_permitido($destino)
        ? $destino
        : 'index.html?login=sessao';
}

function ironinvest_exigir_login(string $destino): void
{
    if (ironinvest_cliente_logado()) {
        return;
    }

    $login = 'index.html?login=necessario&destino=' . rawurlencode($destino) . '#login';
    ironinvest_redirecionar($login);
}

function ironinvest_header_html(): void
{
    header('Content-Type: text/html; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
}

function ironinvest_header_json(): void
{
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
}
