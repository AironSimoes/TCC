CREATE TABLE IF NOT EXISTS clientes (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome_completo VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL,
    cpf CHAR(11) NOT NULL,
    telefone VARCHAR(11) NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    aceite_termos TINYINT(1) NOT NULL DEFAULT 0,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    ultimo_login_em DATETIME NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uk_clientes_email (email),
    UNIQUE KEY uk_clientes_cpf (cpf)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS seguranca_tentativas (
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
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS perfis_investidor (
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
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
