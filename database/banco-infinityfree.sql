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
