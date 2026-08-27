USE agencia_pantanal;

INSERT INTO site_settings (setting_key, setting_value) VALUES
('hero_title', 'O Pantanal em sua forma mais extraordinária'),
('hero_subtitle', 'Expedições autorais, encontros com a vida selvagem e roteiros construídos para quem quer sentir o Pantanal de verdade.'),
('hero_video', ''),
('hero_poster', 'https://images.unsplash.com/photo-1725397006223-8a10a4c2bc0b?auto=format&fit=crop&q=88&w=2200'),
('about_title', 'Menos turismo de massa. Mais Pantanal de verdade.'),
('about_text', 'Criamos jornadas com ritmo, contexto e profundidade. Combinamos conhecimento local, logística bem planejada e acesso aos cenários mais emblemáticos do Pantanal para transformar cada viagem em uma experiência memorável.'),
('jaguar_image', 'https://images.unsplash.com/photo-1725397006223-8a10a4c2bc0b?auto=format&fit=crop&q=88&w=1800'),
('transpantaneira_image', 'https://images.unsplash.com/photo-1690989751090-e29411e007b2?auto=format&fit=crop&q=88&w=1800'),
('porto_jofre_image', 'https://images.unsplash.com/photo-1681227367357-8968aeab739f?auto=format&fit=crop&q=88&w=1800'),
('caiman_image', 'https://images.unsplash.com/photo-1756724945561-19b48767cd10?auto=format&fit=crop&q=85&w=1800')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

UPDATE tours SET cover_image = 'https://images.unsplash.com/photo-1725397006223-8a10a4c2bc0b?auto=format&fit=crop&q=85&w=1400' WHERE slug = 'expedicao-onca-pintada';
UPDATE tours SET cover_image = 'https://images.unsplash.com/photo-1690989751090-e29411e007b2?auto=format&fit=crop&q=85&w=1400' WHERE slug = 'safari-fotografico-pantaneiro';
UPDATE tours SET cover_image = 'https://images.unsplash.com/photo-1756724945561-19b48767cd10?auto=format&fit=crop&q=85&w=1400' WHERE slug = 'navegacao-rios-pantanal';