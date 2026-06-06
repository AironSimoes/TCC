<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';

ironinvest_iniciar_sessao();
ironinvest_header_json();

if (!ironinvest_cliente_logado()) {
    http_response_code(401);
    echo json_encode(['erro' => 'Faça login para acessar seu perfil.'], JSON_UNESCAPED_UNICODE);
    exit;
}

function ironinvest_perfil_garantir_tabela(PDO $pdo): void
{
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS perfis_investidor (
            cliente_id INT UNSIGNED NOT NULL,
            nivel_risco VARCHAR(10) NOT NULL,
            perfil_nome VARCHAR(20) NOT NULL,
            pontuacao TINYINT UNSIGNED NOT NULL,
            respostas_json VARCHAR(255) NOT NULL,
            atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (cliente_id),
            CONSTRAINT fk_perfis_investidor_cliente
                FOREIGN KEY (cliente_id) REFERENCES clientes (id)
                ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
}

function ironinvest_perfil_classificar(int $pontuacao): array
{
    if ($pontuacao <= 6) {
        return [
            'nivel_risco' => 'baixo',
            'perfil_nome' => 'Conservador',
        ];
    }

    if ($pontuacao <= 12) {
        return [
            'nivel_risco' => 'medio',
            'perfil_nome' => 'Moderado',
        ];
    }

    return [
        'nivel_risco' => 'alto',
        'perfil_nome' => 'Arrojado',
    ];
}

function ironinvest_perfil_resposta(array $registro): array
{
    return [
        'nivel_risco' => $registro['nivel_risco'],
        'perfil_nome' => $registro['perfil_nome'],
        'pontuacao' => (int) $registro['pontuacao'],
        'atualizado_em' => $registro['atualizado_em'],
    ];
}

$clienteId = (int) $_SESSION['cliente_id'];
$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {
    $pdo = ironinvest_pdo();
    ironinvest_perfil_garantir_tabela($pdo);

    if ($metodo === 'GET') {
        $stmt = $pdo->prepare(
            'SELECT nivel_risco, perfil_nome, pontuacao, atualizado_em
             FROM perfis_investidor
             WHERE cliente_id = :cliente_id
             LIMIT 1'
        );
        $stmt->execute([':cliente_id' => $clienteId]);
        $registro = $stmt->fetch();

        echo json_encode([
            'perfil' => $registro ? ironinvest_perfil_resposta($registro) : null,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($metodo !== 'POST') {
        http_response_code(405);
        echo json_encode(['erro' => 'Método não permitido.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!ironinvest_csrf_valido()) {
        http_response_code(403);
        echo json_encode([
            'erro' => 'Sessão expirada. Recarregue a página e tente novamente.',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $respostasJson = $_POST['respostas'] ?? '';
    $respostas = is_string($respostasJson)
        ? json_decode($respostasJson, true)
        : null;

    if (!is_array($respostas) || count($respostas) !== 6) {
        http_response_code(422);
        echo json_encode(['erro' => 'Responda todas as perguntas.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $respostasValidas = [];

    foreach ($respostas as $resposta) {
        if (!is_int($resposta) || $resposta < 0 || $resposta > 3) {
            http_response_code(422);
            echo json_encode(['erro' => 'Uma das respostas é inválida.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $respostasValidas[] = $resposta;
    }

    $pontuacao = array_sum($respostasValidas);
    $classificacao = ironinvest_perfil_classificar($pontuacao);
    $respostasPersistidas = json_encode($respostasValidas, JSON_UNESCAPED_UNICODE);

    $stmt = $pdo->prepare(
        'INSERT INTO perfis_investidor (
            cliente_id,
            nivel_risco,
            perfil_nome,
            pontuacao,
            respostas_json,
            atualizado_em
        ) VALUES (
            :cliente_id,
            :nivel_risco,
            :perfil_nome,
            :pontuacao,
            :respostas_json,
            NOW()
        )
        ON DUPLICATE KEY UPDATE
            nivel_risco = VALUES(nivel_risco),
            perfil_nome = VALUES(perfil_nome),
            pontuacao = VALUES(pontuacao),
            respostas_json = VALUES(respostas_json),
            atualizado_em = NOW()'
    );
    $stmt->execute([
        ':cliente_id' => $clienteId,
        ':nivel_risco' => $classificacao['nivel_risco'],
        ':perfil_nome' => $classificacao['perfil_nome'],
        ':pontuacao' => $pontuacao,
        ':respostas_json' => $respostasPersistidas,
    ]);

    echo json_encode([
        'sucesso' => true,
        'perfil' => [
            'nivel_risco' => $classificacao['nivel_risco'],
            'perfil_nome' => $classificacao['perfil_nome'],
            'pontuacao' => $pontuacao,
            'atualizado_em' => date('Y-m-d H:i:s'),
        ],
    ], JSON_UNESCAPED_UNICODE);
} catch (PDOException $erro) {
    http_response_code(500);
    echo json_encode([
        'erro' => 'Não foi possível salvar seu perfil agora.',
    ], JSON_UNESCAPED_UNICODE);
}
