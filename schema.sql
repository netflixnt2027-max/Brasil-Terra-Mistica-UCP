-- Banco adicional do UCP Brasil Terra Mística
CREATE TABLE IF NOT EXISTS btm_posts (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nick VARCHAR(32) NOT NULL,
 imagem VARCHAR(255) NOT NULL,
 legenda TEXT,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_posts_data (criado_em),
 INDEX idx_posts_nick (nick)
);
CREATE TABLE IF NOT EXISTS btm_post_likes (
 post_id INT NOT NULL,
 nick VARCHAR(32) NOT NULL,
 PRIMARY KEY(post_id,nick),
 INDEX idx_like_post(post_id)
);
CREATE TABLE IF NOT EXISTS btm_comments (
 id INT AUTO_INCREMENT PRIMARY KEY,
 post_id INT NOT NULL,
 nick VARCHAR(32) NOT NULL,
 comentario TEXT NOT NULL,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_comments_post(post_id)
);
CREATE TABLE IF NOT EXISTS denuncias (
 id INT AUTO_INCREMENT PRIMARY KEY,
 denunciante VARCHAR(32) NOT NULL,
 denunciado VARCHAR(32) NOT NULL,
 motivo VARCHAR(120) NOT NULL,
 descricao TEXT NOT NULL,
 prova VARCHAR(255),
 status VARCHAR(30) NOT NULL DEFAULT 'Pendente',
 admin VARCHAR(32) DEFAULT NULL,
 resposta TEXT,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 INDEX idx_denuncias_status(status),
 INDEX idx_denuncias_denunciante(denunciante)
);
CREATE TABLE IF NOT EXISTS denuncia_historico (
 id INT AUTO_INCREMENT PRIMARY KEY,
 denuncia_id INT NOT NULL,
 admin VARCHAR(32) NOT NULL,
 status VARCHAR(30) NOT NULL,
 resposta TEXT,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_hist_denuncia(denuncia_id)
);
CREATE TABLE IF NOT EXISTS btm_musicas (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nick VARCHAR(32) NOT NULL,
 titulo VARCHAR(120) NOT NULL,
 artista VARCHAR(120),
 mp3_url VARCHAR(500) NOT NULL,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_musicas_data(criado_em)
);
CREATE TABLE IF NOT EXISTS btm_music_likes (
 musica_id INT NOT NULL,
 nick VARCHAR(32) NOT NULL,
 PRIMARY KEY(musica_id,nick)
);
CREATE TABLE IF NOT EXISTS btm_music_favoritos (
 musica_id INT NOT NULL,
 nick VARCHAR(32) NOT NULL,
 PRIMARY KEY(musica_id,nick)
);
CREATE TABLE IF NOT EXISTS notificacoes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nick VARCHAR(32) NOT NULL,
 titulo VARCHAR(120) NOT NULL,
 mensagem TEXT NOT NULL,
 lida TINYINT(1) NOT NULL DEFAULT 0,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_notif_nick(nick,lida)
);
