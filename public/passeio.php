<?php
require_once dirname(__DIR__) . '/src/config.php';

$slug = trim($_GET['slug'] ?? '');
$stmt = db()->prepare('SELECT * FROM tours WHERE slug = :slug AND active = 1 LIMIT 1');
$stmt->execute(['slug' => $slug]);
$tour = $stmt->fetch();
if (!$tour) {
    http_response_code(404);
    exit('Passeio não encontrado.');
}

$images = db()->prepare('SELECT * FROM tour_images WHERE tour_id = :tour_id ORDER BY sort_order, id');
$images->execute(['tour_id' => $tour['id']]);
$gallery = $images->fetchAll();
$whatsapp = preg_replace('/\D/', '', setting('whatsapp_number', env('WHATSAPP_NUMBER', '')));
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($tour['title']) ?> | <?= e(setting('site_name', 'Pantanal Experience')) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
<header class="site-header solid"><a class="brand" href="index.php"><span>PE</span><?= e(setting('site_name', 'Pantanal Experience')) ?></a><nav><a href="index.php#passeios">Passeios</a><a href="index.php#sobre">Sobre</a><a class="nav-cta" href="#orcamento">Planejar viagem</a></nav></header>
<main class="tour-detail">
<section class="detail-hero"><img src="<?= e($tour['cover_image'] ?: 'assets/img/placeholder.jpg') ?>" alt="<?= e($tour['title']) ?>"><div class="detail-overlay"><a href="index.php#passeios">← Voltar aos passeios</a><p class="eyebrow"><?= e($tour['category']) ?> · <?= e($tour['location']) ?></p><h1><?= e($tour['title']) ?></h1><p><?= e($tour['short_description']) ?></p></div></section>
<section class="detail-layout"><article class="detail-content"><div class="facts"><div><small>Duração</small><strong><?= e($tour['duration']) ?></strong></div><div><small>Local</small><strong><?= e($tour['location']) ?></strong></div><div><small>Categoria</small><strong><?= e($tour['category']) ?></strong></div></div><h2>Sobre esta experiência</h2><p><?= nl2br(e($tour['description'])) ?></p><?php if ($gallery): ?><div class="gallery"><?php foreach ($gallery as $image): ?><img src="<?= e($image['image_path']) ?>" alt="<?= e($image['alt_text'] ?: $tour['title']) ?>"><?php endforeach; ?></div><?php endif; ?></article>
<aside class="quote-card" id="orcamento"><p class="eyebrow dark">Monte sua viagem</p><h2>Solicite pelo WhatsApp</h2><?php if ($tour['price_from']): ?><div class="price"><small>a partir de</small><strong>R$ <?= number_format((float)$tour['price_from'], 2, ',', '.') ?></strong></div><?php endif; ?><form id="whatsapp-form" data-whatsapp="<?= e($whatsapp) ?>" data-tour="<?= e($tour['title']) ?>"><label>Seu nome<input name="name" required placeholder="Nome completo"></label><div class="form-row"><label>Adultos<input type="number" name="adults" required min="1" value="2"></label><label>Crianças<input type="number" name="children" required min="0" value="0"></label></div><div class="form-row"><label>Data de entrada<input type="date" name="start_date" required></label><label>Data de saída<input type="date" name="end_date" required></label></div><button type="submit">Enviar solicitação no WhatsApp</button><p class="form-note">Você será redirecionado ao WhatsApp com todos os dados já preenchidos.</p></form></aside></section>
</main>
<a class="whatsapp-float" href="https://wa.me/<?= e($whatsapp) ?>" target="_blank" rel="noopener">WA</a>
<script src="assets/js/app.js"></script>
</body>
</html>
