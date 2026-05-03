<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';

ironinvest_iniciar_sessao();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ironinvest_redirecionar('index.html#login');
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($senha) < 8) {
    ironinvest_redirecionar('index.html?login=erro#login');
}

try {
    $pdo = ironinvest_pdo();
    $stmt = $pdo->prepare(
        'SELECT id, nome_completo, email, senha_hash FROM clientes WHERE email = :email LIMIT 1'
    );
    $stmt->execute([':email' => $email]);
    $cliente = $stmt->fetch();

    if (!$cliente || !password_verify($senha, $cliente['senha_hash'])) {
        ironinvest_redirecionar('index.html?login=erro#login');
    }

    session_regenerate_id(true);
    $_SESSION['cliente_id'] = (int) $cliente['id'];
    $_SESSION['cliente_nome'] = $cliente['nome_completo'];
    $_SESSION['cliente_email'] = $cliente['email'];
    $_SESSION['logado_em'] = time();

    ironinvest_redirecionar('index.html?login=sessao');
} catch (PDOException $erro) {
    ironinvest_redirecionar('index.html?login=erro#login');
}
