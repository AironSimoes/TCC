<?php
declare(strict_types=1);

function ironinvest_config(): array
{
    static $config = null;

    if ($config !== null) {
        return $config;
    }

    $arquivoLocal = __DIR__ . '/config.local.php';
    $arquivoConfig = is_file($arquivoLocal)
        ? $arquivoLocal
        : __DIR__ . '/config.php';
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
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');

    $caminhoSessao = session_save_path();
    if ($caminhoSessao === '' || !is_writable($caminhoSessao)) {
        $caminhoSessaoLocal = dirname(__DIR__) . '/storage/sessions';

        if (!is_dir($caminhoSessaoLocal)) {
            @mkdir($caminhoSessaoLocal, 0750, true);
        }

        if (is_dir($caminhoSessaoLocal) && is_writable($caminhoSessaoLocal)) {
            session_save_path($caminhoSessaoLocal);
        }
    }

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => ironinvest_cookie_seguro(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function ironinvest_headers_seguranca(): void
{
    header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' https://fonts.googleapis.com; font-src https://fonts.gstatic.com; img-src 'self' data:; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; connect-src 'self'; upgrade-insecure-requests");
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

    if (ironinvest_cookie_seguro()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
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

function ironinvest_csrf_token(): string
{
    ironinvest_iniciar_sessao();

    if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function ironinvest_csrf_valido(): bool
{
    ironinvest_iniciar_sessao();

    $tokenSessao = $_SESSION['csrf_token'] ?? '';
    $tokenRecebido = $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');

    return is_string($tokenSessao)
        && is_string($tokenRecebido)
        && $tokenSessao !== ''
        && hash_equals($tokenSessao, $tokenRecebido);
}

function ironinvest_ip_cliente(): string
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function ironinvest_rate_limit_garantir_tabela(PDO $pdo): void
{
    static $criada = false;

    if ($criada) {
        return;
    }

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS seguranca_tentativas (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            escopo VARCHAR(40) NOT NULL,
            chave_hash CHAR(64) NOT NULL,
            tentativas INT UNSIGNED NOT NULL DEFAULT 0,
            primeira_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            ultima_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            bloqueado_ate DATETIME NULL DEFAULT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY uk_seguranca_tentativas (escopo, chave_hash),
            KEY idx_seguranca_bloqueio (bloqueado_ate)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );

    $criada = true;
}

function ironinvest_rate_limit_hash(string $escopo, string $chave): string
{
    return hash('sha256', $escopo . '|' . $chave);
}

function ironinvest_rate_limit_bloqueado(string $escopo, string $chave): bool
{
    try {
        $pdo = ironinvest_pdo();
        ironinvest_rate_limit_garantir_tabela($pdo);

        $stmt = $pdo->prepare(
            'SELECT bloqueado_ate FROM seguranca_tentativas
             WHERE escopo = :escopo AND chave_hash = :chave_hash
             LIMIT 1'
        );
        $stmt->execute([
            ':escopo' => $escopo,
            ':chave_hash' => ironinvest_rate_limit_hash($escopo, $chave),
        ]);
        $registro = $stmt->fetch();

        return $registro
            && isset($registro['bloqueado_ate'])
            && strtotime((string) $registro['bloqueado_ate']) > time();
    } catch (PDOException $erro) {
        return false;
    }
}

function ironinvest_rate_limit_registrar(string $escopo, string $chave, int $limite, int $janelaSegundos, int $bloqueioSegundos): void
{
    try {
        $pdo = ironinvest_pdo();
        ironinvest_rate_limit_garantir_tabela($pdo);

        $hash = ironinvest_rate_limit_hash($escopo, $chave);
        $stmt = $pdo->prepare(
            'SELECT tentativas, primeira_em FROM seguranca_tentativas
             WHERE escopo = :escopo AND chave_hash = :chave_hash
             LIMIT 1'
        );
        $stmt->execute([
            ':escopo' => $escopo,
            ':chave_hash' => $hash,
        ]);
        $registro = $stmt->fetch();
        $agora = time();

        if (!$registro || $agora - strtotime((string) $registro['primeira_em']) > $janelaSegundos) {
            $stmt = $pdo->prepare(
                'INSERT INTO seguranca_tentativas (escopo, chave_hash, tentativas, primeira_em, ultima_em, bloqueado_ate)
                 VALUES (:escopo, :chave_hash, 1, NOW(), NOW(), NULL)
                 ON DUPLICATE KEY UPDATE tentativas = 1, primeira_em = NOW(), ultima_em = NOW(), bloqueado_ate = NULL'
            );
            $stmt->execute([
                ':escopo' => $escopo,
                ':chave_hash' => $hash,
            ]);
            return;
        }

        $tentativas = (int) $registro['tentativas'] + 1;
        $bloqueadoAte = $tentativas >= $limite
            ? date('Y-m-d H:i:s', $agora + $bloqueioSegundos)
            : null;

        $stmt = $pdo->prepare(
            'UPDATE seguranca_tentativas
             SET tentativas = :tentativas, ultima_em = NOW(), bloqueado_ate = :bloqueado_ate
             WHERE escopo = :escopo AND chave_hash = :chave_hash'
        );
        $stmt->execute([
            ':tentativas' => $tentativas,
            ':bloqueado_ate' => $bloqueadoAte,
            ':escopo' => $escopo,
            ':chave_hash' => $hash,
        ]);
    } catch (PDOException $erro) {
        return;
    }
}

function ironinvest_rate_limit_limpar(string $escopo, string $chave): void
{
    try {
        $pdo = ironinvest_pdo();
        ironinvest_rate_limit_garantir_tabela($pdo);

        $stmt = $pdo->prepare(
            'DELETE FROM seguranca_tentativas WHERE escopo = :escopo AND chave_hash = :chave_hash'
        );
        $stmt->execute([
            ':escopo' => $escopo,
            ':chave_hash' => ironinvest_rate_limit_hash($escopo, $chave),
        ]);
    } catch (PDOException $erro) {
        return;
    }
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
    ironinvest_headers_seguranca();
    header('Content-Type: text/html; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
}

function ironinvest_header_json(): void
{
    ironinvest_headers_seguranca();
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
}
