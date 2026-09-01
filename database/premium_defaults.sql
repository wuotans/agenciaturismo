USE agencia_pantanal;

INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'Aruanã Expedições'),
('brand_tagline', 'O Pantanal não se visita. Se vive.'),
('brand_descriptor', 'Pantanal · Brasil'),
('hero_title', 'Viva o Pantanal de verdade'),
('hero_subtitle', 'Expedições exclusivas entre onças, rios e horizontes selvagens. Uma conexão real com a natureza, a vida pantaneira e o Brasil profundo.'),
('hero_video', ''),
('hero_poster', 'https://images.unsplash.com/photo-1725397006223-8a10a4c2bc0b?auto=format&fit=crop&q=88&w=2200'),
('about_title', 'Natureza que emociona. Experiências que permanecem.'),
('about_text', 'Na Aruanã Expedições, cada jornada nasce do conhecimento do território e do respeito aos ciclos do Pantanal. Criamos experiências em grupos reduzidos, com guias especializados e logística cuidadosa para aproximar você da vida selvagem sem transformar a natureza em espetáculo.'),
('jaguar_image', 'https://images.unsplash.com/photo-1725397006223-8a10a4c2bc0b?auto=format&fit=crop&q=88&w=1800'),
('transpantaneira_image', 'https://images.unsplash.com/photo-1690989751090-e29411e007b2?auto=format&fit=crop&q=88&w=1800'),
('porto_jofre_image', 'https://images.unsplash.com/photo-1681227367357-8968aeab739f?auto=format&fit=crop&q=88&w=1800'),
('caiman_image', 'https://images.unsplash.com/photo-1756724945561-19b48767cd10?auto=format&fit=crop&q=85&w=1800')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

UPDATE tours SET cover_image = 'https://images.unsplash.com/photo-1725397006223-8a10a4c2bc0b?auto=format&fit=crop&q=85&w=1400' WHERE slug = 'expedicao-onca-pintada';
UPDATE tours SET cover_image = 'https://images.unsplash.com/photo-1690989751090-e29411e007b2?auto=format&fit=crop&q=85&w=1400' WHERE slug = 'safari-fotografico-pantaneiro';
UPDATE tours SET cover_image = 'https://images.unsplash.com/photo-1756724945561-19b48767cd10?auto=format&fit=crop&q=85&w=1400' WHERE slug = 'navegacao-rios-pantanal';