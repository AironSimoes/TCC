<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';

ironinvest_header_json();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Metodo nao permitido.']);
    exit;
}

function somente_digitos(string $valor): string
{
    return preg_replace('/\D+/', '', $valor) ?? '';
}

function cpf_valido(string $cpf): bool
{
    if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }

    for ($tamanho = 9; $tamanho < 11; $tamanho++) {
        $soma = 0;
        for ($indice = 0; $indice < $tamanho; $indice++) {
            $soma += (int) $cpf[$indice] * (($tamanho + 1) - $indice);
        }

        $digito = ($soma * 10) % 11;
        $digito = $digito === 10 ? 0 : $digito;

        if ($digito !== (int) $cpf[$tamanho]) {
            return false;
        }
    }

    return true;
}

$nome = trim($_POST['nome_completo'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$cpf = somente_digitos($_POST['cpf'] ?? '');
$telefone = somente_digitos($_POST['telefone'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmarSenha = $_POST['confirmar_senha'] ?? '';
$aceiteTermos = ($_POST['aceite_termos'] ?? '') === '1';

$erros = [];

if (strlen($nome) < 3 || strlen($nome) > 120) {
    $erros['nome_completo'] = 'Informe seu nome completo.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 160) {
    $erros['email'] = 'Informe um e-mail valido.';
}

if (!cpf_valido($cpf)) {
    $erros['cpf'] = 'Informe um CPF valido.';
}

if (strlen($telefone) < 10 || strlen($telefone) > 11) {
    $erros['telefone'] = 'Informe um telefone valido.';
}

if (strlen($senha) < 8 || strlen($senha) > 72) {
    $erros['senha'] = 'A senha deve ter entre 8 e 72 caracteres.';
}

if ($senha !== $confirmarSenha) {
    $erros['confirmar_senha'] = 'As senhas nao conferem.';
}

if (!$aceiteTermos) {
    $erros['aceite_termos'] = 'Aceite os termos para continuar.';
}

if ($erros !== []) {
    http_response_code(422);
    echo json_encode(['erros' => $erros]);
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $pdo = ironinvest_pdo();

    $sql = <<<SQL
        INSERT INTO clientes (nome_completo, email, cpf, telefone, senha_hash, aceite_termos, criado_em)
        VALUES (:nome_completo, :email, :cpf, :telefone, :senha_hash, :aceite_termos, NOW())
    SQL;

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome_completo' => $nome,
        ':email' => $email,
        ':cpf' => $cpf,
        ':telefone' => $telefone,
        ':senha_hash' => $senhaHash,
        ':aceite_termos' => 1,
    ]);

    http_response_code(201);
    echo json_encode(['sucesso' => true, 'mensagem' => 'Conta criada com sucesso.'], JSON_UNESCAPED_UNICODE);
} catch (PDOException $erro) {
    if ($erro->getCode() === '23000') {
        http_response_code(409);
        echo json_encode([
            'erros' => [
                'email' => 'E-mail ou CPF ja cadastrado.',
            ],
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    http_response_code(500);
    echo json_encode(['erro' => 'Nao foi possivel concluir o cadastro agora.'], JSON_UNESCAPED_UNICODE);
}
