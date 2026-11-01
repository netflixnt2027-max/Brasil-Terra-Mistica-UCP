-- Execute este arquivo no phpMyAdmin do banco do Terra Mística.
-- Não altera a tabela contas nem os dados dos jogadores.
CREATE TABLE IF NOT EXISTS portal_noticias (
 id INT AUTO_INCREMENT PRIMARY KEY,
 titulo VARCHAR(140) NOT NULL,
 resumo TEXT NOT NULL,
 categoria VARCHAR(40) NOT NULL DEFAULT 'Comunicado',
 publicado TINYINT(1) NOT NULL DEFAULT 1,
 criado_por VARCHAR(32) NOT NULL,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_portal_publicado (publicado, criado_em)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
