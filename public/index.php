<?php
require_once dirname(__DIR__) . '/src/config.php';

$q = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');

$sql = 'SELECT * FROM tours WHERE active = 1';
$params = [];
if ($q !== '') {
    $sql .= ' AND (title LIKE :q OR short_description LIKE :q OR description LIKE :q OR location LIKE :q OR category LIKE :q)';
    $params['q'] = "%{$q}%";
}
if ($category !== '') {
    $sql .= ' AND category = :category';
    $params['category'] = $category;
}
$sql .= ' ORDER BY featured DESC, created_at DESC';
$stmt = db()->prepare($sql);
$stmt->execute($params);
$tours = $stmt->fetchAll();
$categories = db()->query("SELECT DISTINCT category FROM tours WHERE active = 1 ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);

$heroVideo = setting('hero_video', 'assets/video/pantanal-hero.mp4');
$heroPoster = setting('hero_poster', 'assets/img/hero-poster.jpg');
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e(setting('site_name', 'Pantanal Experience')) ?> | Turismo no Pantanal</title>
  <meta name="description" content="Passeios, safáris fotográficos, expedições de onça-pintada e experiências autênticas no Pantanal.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
<header class="site-header">
  <a class="brand" href="index.php"><span>PE</span><?= e(setting('site_name', 'Pantanal Experience')) ?></a>
  <nav><a href="#passeios">Passeios</a><a href="#sobre">Sobre</a><a href="#contato">Contato</a><a class="nav-cta" href="#passeios">Planejar viagem</a></nav>
</header>

<main>
<section class="hero">
  <video autoplay muted loop playsinline poster="<?= e($heroPoster) ?>">
    <source src="<?= e($heroVideo) ?>" type="video/mp4">
  </video>
  <div class="hero-shade"></div>
  <div class="hero-content">
    <p class="eyebrow">Mato Grosso · Pantanal</p>
    <h1><?= e(setting('hero_title', 'Viva o Pantanal de perto')) ?></h1>
    <p><?= e(setting('hero_subtitle')) ?></p>
    <form class="hero-search" method="get" action="index.php#passeios">
      <div><label for="q">O que você quer viver?</label><input id="q" name="q" value="<?= e($q) ?>" placeholder="Onça-pintada, safari, rio..."></div>
      <div><label for="category">Experiência</label><select id="category" name="category"><option value="">Todas</option><?php foreach ($categories as $cat): ?><option value="<?= e($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>><?= e($cat) ?></option><?php endforeach; ?></select></div>
      <button type="submit">Buscar passeios</button>
    </form>
  </div>
  <div class="hero-caption">Natureza selvagem. Experiências cuidadosamente planejadas.</div>
</section>

<section class="intro" id="sobre">
  <p class="eyebrow dark">Experiências autênticas</p>
  <h2><?= e(setting('about_title')) ?></h2>
  <p><?= e(setting('about_text')) ?></p>
  <div class="benefits"><article><strong>Guias locais</strong><span>Conhecimento profundo da fauna, rios e caminhos pantaneiros.</span></article><article><strong>Roteiros personalizados</strong><span>Experiências ajustadas ao perfil, período e tamanho do grupo.</span></article><article><strong>Turismo responsável</strong><span>Observação de fauna com respeito à natureza e às comunidades locais.</span></article></div>
</section>

<section class="tours-section" id="passeios">
  <div class="section-title"><div><p class="eyebrow dark">Explore o Pantanal</p><h2>Encontre seu próximo passeio</h2></div><span><?= count($tours) ?> experiência<?= count($tours) === 1 ? '' : 's' ?> encontrada<?= count($tours) === 1 ? '' : 's' ?></span></div>
  <?php if (!$tours): ?><div class="empty">Nenhum passeio encontrado. Experimente outra busca.</div><?php else: ?>
  <div class="tour-grid">
    <?php foreach ($tours as $tour): ?>
      <article class="tour-card">
        <a href="passeio.php?slug=<?= urlencode($tour['slug']) ?>" class="tour-image"><img src="<?= e($tour['cover_image'] ?: 'assets/img/placeholder.jpg') ?>" alt="<?= e($tour['title']) ?>"><?php if ($tour['featured']): ?><span class="badge">Destaque</span><?php endif; ?></a>
        <div class="tour-body"><div class="tour-meta"><span><?= e($tour['category']) ?></span><span><?= e($tour['duration']) ?></span></div><h3><a href="passeio.php?slug=<?= urlencode($tour['slug']) ?>"><?= e($tour['title']) ?></a></h3><p><?= e($tour['short_description']) ?></p><div class="tour-footer"><div><?php if ($tour['price_from']): ?><small>a partir de</small><strong>R$ <?= number_format((float)$tour['price_from'], 2, ',', '.') ?></strong><?php else: ?><strong>Consulte</strong><?php endif; ?></div><a href="passeio.php?slug=<?= urlencode($tour['slug']) ?>">Ver experiência →</a></div></div>
      </article>
    <?php endforeach; ?>
  </div><?php endif; ?>
</section>

<section class="wild-banner"><div><p class="eyebrow">Seu encontro com o Pantanal começa aqui</p><h2>Da Transpantaneira aos rios de Porto Jofre.</h2><a href="#passeios">Escolher uma experiência</a></div></section>
</main>

<footer id="contato"><div><strong><?= e(setting('site_name', 'Pantanal Experience')) ?></strong><p>Experiências que conectam pessoas à maior planície alagável do mundo.</p></div><div><span>Atendimento</span><a href="https://wa.me/<?= preg_replace('/\D/', '', setting('whatsapp_number', env('WHATSAPP_NUMBER', ''))) ?>" target="_blank" rel="noopener">Falar no WhatsApp</a><a href="mailto:contato@pantanalexperience.com.br">contato@pantanalexperience.com.br</a></div></footer>
<a class="whatsapp-float" href="https://wa.me/<?= preg_replace('/\D/', '', setting('whatsapp_number', env('WHATSAPP_NUMBER', ''))) ?>" target="_blank" rel="noopener" aria-label="Falar no WhatsApp">WA</a>
<script src="assets/js/app.js"></script>
</body>
</html>
