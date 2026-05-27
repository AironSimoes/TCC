<?php
declare(strict_types=1);

require __DIR__ . '/app/auth.php';

ironinvest_iniciar_sessao();

ironinvest_header_json();

echo json_encode([
    'logado' => ironinvest_cliente_logado(),
    'nome' => $_SESSION['cliente_nome'] ?? null,
    'csrf_token' => ironinvest_csrf_token(),
], JSON_UNESCAPED_UNICODE);
