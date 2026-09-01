CREATE DATABASE IF NOT EXISTS agencia_pantanal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE agencia_pantanal;

CREATE TABLE admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tours (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  slug VARCHAR(190) NOT NULL UNIQUE,
  short_description VARCHAR(300) NOT NULL,
  description TEXT NOT NULL,
  location VARCHAR(180) NOT NULL,
  duration VARCHAR(100) NOT NULL,
  category VARCHAR(100) NOT NULL,
  price_from DECIMAL(10,2) NULL,
  featured TINYINT(1) NOT NULL DEFAULT 0,
  active TINYINT(1) NOT NULL DEFAULT 1,
  cover_image VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tour_images (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tour_id INT UNSIGNED NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  alt_text VARCHAR(190) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_tour_images_tour FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
);

CREATE TABLE site_settings (
  setting_key VARCHAR(120) PRIMARY KEY,
  setting_value TEXT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'Pantanal Experience'),
('hero_title', 'Viva o Pantanal de perto'),
('hero_subtitle', 'Expedições autênticas entre rios, fauna selvagem e paisagens inesquecíveis.'),
('hero_video', 'assets/video/pantanal-hero.mp4'),
('hero_poster', 'assets/img/hero-poster.jpg'),
('whatsapp_number', '5565999999999'),
('about_title', 'O Pantanal como ele realmente é'),
('about_text', 'Roteiros pensados para quem quer contemplar a vida selvagem, a cultura pantaneira e a natureza com conforto e segurança.')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

-- Senha inicial: Pantanal@2026
INSERT INTO admins (name, email, password_hash) VALUES
('Administrador', 'admin@pantanal.local', '$2y$10$LIuZqpMcs.KWlYCA5rcSfOVxQ8b1RQx73InYTFTnGFenXO5Z/hy9u');

INSERT INTO tours (title, slug, short_description, description, location, duration, category, price_from, featured, cover_image) VALUES
('Safari Fotográfico Pantaneiro', 'safari-fotografico-pantaneiro', 'Saída guiada para observação de onças, jacarés, aves e outros animais do Pantanal.', 'Uma experiência de imersão em áreas estratégicas para observação de fauna, com acompanhamento de guia local e paradas para fotografia.', 'Poconé e Transpantaneira', '1 dia', 'Safari', 690.00, 1, 'assets/img/tour-safari.jpg'),
('Expedição Onça-Pintada', 'expedicao-onca-pintada', 'Roteiro focado na busca responsável pela onça-pintada em seu habitat natural.', 'Expedição com navegação e observação silenciosa em regiões conhecidas pela presença de onças-pintadas, sempre respeitando a fauna e as regras ambientais.', 'Porto Jofre', '3 dias', 'Vida Selvagem', 2890.00, 1, 'assets/img/tour-onca.jpg'),
('Navegação pelos Rios do Pantanal', 'navegacao-rios-pantanal', 'Passeio de barco por corixos e rios com paisagens, aves, jacarés e pôr do sol.', 'Passeio fluvial com guia, pontos de observação de animais e tempo para contemplação e fotografia.', 'Rio Cuiabá', '4 horas', 'Navegação', 390.00, 1, 'assets/img/tour-rio.jpg');
