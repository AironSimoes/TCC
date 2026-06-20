<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';

ironinvest_iniciar_sessao();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ironinvest_redirecionar('index.html#login');
}

function ironinvest_login_responder_json(array $dados, int $status): never
{
    http_response_code($status);
    ironinvest_header_json();
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit;
}

function ironinvest_login_post_texto(string $campo): string
{
    $valor = $_POST[$campo] ?? '';

    return is_string($valor) ? $valor : '';
}

function ironinvest_login_falhar(string $destinoErro, bool $responderJson): never
{
    $email = strtolower(trim(ironinvest_login_post_texto('email')));
    $ip = ironinvest_ip_cliente();

    ironinvest_rate_limit_registrar('login_ip', $ip, 30, 900, 900);

    if ($email !== '') {
        ironinvest_rate_limit_registrar('login_email', "{$ip}|{$email}", 5, 900, 900);
    }

    if ($responderJson) {
        ironinvest_login_responder_json([
            'sucesso' => false,
            'erro' => 'E-mail ou senha invalidos.',
        ], 401);
    }

    ironinvest_redirecionar('index.html?login=erro' . $destinoErro . '#login');
}

function ironinvest_login_csrf_invalido(string $destinoErro, bool $responderJson): never
{
    if ($responderJson) {
        ironinvest_login_responder_json([
            'sucesso' => false,
            'erro' => 'Sessao expirada. Recarregue a pagina e tente novamente.',
        ], 403);
    }

    ironinvest_redirecionar('index.html?login=csrf' . $destinoErro . '#login');
}

function ironinvest_login_limite_excedido(string $destinoErro, bool $responderJson): never
{
    if ($responderJson) {
        ironinvest_login_responder_json([
            'sucesso' => false,
            'erro' => 'Muitas tentativas. Aguarde alguns minutos e tente novamente.',
        ], 429);
    }

    ironinvest_redirecionar('index.html?login=bloqueado' . $destinoErro . '#login');
}

function ironinvest_login_sucesso(string $destino, bool $responderJson): never
{
    if ($responderJson) {
        ironinvest_login_responder_json([
            'sucesso' => true,
            'mensagem' => 'Login realizado com sucesso.',
        ], 200);
    }

    ironinvest_redirecionar($destino);
}

$email = strtolower(trim(ironinvest_login_post_texto('email')));
$senha = ironinvest_login_post_texto('senha');
$destinoInformado = trim(ironinvest_login_post_texto('destino'));
$destino = ironinvest_destino_login($destinoInformado);
$destinoErro = ironinvest_destino_permitido($destinoInformado)
    ? '&destino=' . rawurlencode($destinoInformado)
    : '';
$responderJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
$ip = ironinvest_ip_cliente();
$chaveLogin = "{$ip}|{$email}";

if (!ironinvest_csrf_valido()) {
    ironinvest_login_csrf_invalido($destinoErro, $responderJson);
}

if (
    ironinvest_rate_limit_bloqueado('login_ip', $ip)
    || ($email !== '' && ironinvest_rate_limit_bloqueado('login_email', $chaveLogin))
) {
    ironinvest_login_limite_excedido($destinoErro, $responderJson);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 160 || strlen($senha) < 8 || strlen($senha) > 72) {
    ironinvest_login_falhar($destinoErro, $responderJson);
}

try {
    $pdo = ironinvest_pdo();
    $stmt = $pdo->prepare(
        'SELECT id, nome_completo, email, senha_hash FROM clientes WHERE email = :email LIMIT 1'
    );
    $stmt->execute([':email' => $email]);
    $cliente = $stmt->fetch();

    if (!$cliente || !password_verify($senha, $cliente['senha_hash'])) {
        ironinvest_login_falhar($destinoErro, $responderJson);
    }

    session_regenerate_id(true);
    $_SESSION['cliente_id'] = (int) $cliente['id'];
    $_SESSION['cliente_nome'] = $cliente['nome_completo'];
    $_SESSION['cliente_email'] = $cliente['email'];
    $_SESSION['logado_em'] = time();
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    $stmt = $pdo->prepare('UPDATE clientes SET ultimo_login_em = NOW() WHERE id = :id');
    $stmt->execute([':id' => (int) $cliente['id']]);

    ironinvest_rate_limit_limpar('login_ip', $ip);
    ironinvest_rate_limit_limpar('login_email', $chaveLogin);

    ironinvest_login_sucesso($destino, $responderJson);
} catch (PDOException $erro) {
    ironinvest_login_falhar($destinoErro, $responderJson);
}
