<?php
require_once dirname(__DIR__) . '/src/config.php';

$q = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');
$sql = 'SELECT * FROM tours WHERE active = 1';
$params = [];

if ($q !== '') {
    $sql .= ' AND (title LIKE :q_title OR short_description LIKE :q_short OR description LIKE :q_description OR location LIKE :q_location OR category LIKE :q_category)';
    $like = "%{$q}%";
    $params['q_title'] = $like;
    $params['q_short'] = $like;
    $params['q_description'] = $like;
    $params['q_location'] = $like;
    $params['q_category'] = $like;
}
if ($category !== '') {
    $sql .= ' AND category = :selected_category';
    $params['selected_category'] = $category;
}
$sql .= ' ORDER BY featured DESC, created_at DESC';
$stmt = db()->prepare($sql);
$stmt->execute($params);
$tours = $stmt->fetchAll();
$categories = db()->query("SELECT DISTINCT category FROM tours WHERE active=1 ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);

$heroVideo = setting('hero_video', '');
$heroPoster = setting('hero_poster', 'https://images.unsplash.com/photo-1725397006223-8a10a4c2bc0b?auto=format&fit=crop&q=88&w=2200');
$jaguarImage = setting('jaguar_image', $heroPoster);
$landscapeImage = setting('transpantaneira_image', 'https://images.unsplash.com/photo-1690989751090-e29411e007b2?auto=format&fit=crop&q=88&w=1800');
$jaguarForestImage = setting('porto_jofre_image', 'https://images.unsplash.com/photo-1681227367357-8968aeab739f?auto=format&fit=crop&q=88&w=1800');
$caimanImage = setting('caiman_image', 'https://images.unsplash.com/photo-1756724945561-19b48767cd10?auto=format&fit=crop&q=85&w=1800');
$whatsapp = preg_replace('/\D/', '', setting('whatsapp_number', env('WHATSAPP_NUMBER', '')));
$siteName = setting('site_name', 'Aruanã Expedições');
$tagline = setting('brand_tagline', 'O Pantanal não se visita. Se vive.');

function whatsapp_icon(): string {
    return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 12.1 0C5.5 0 .2 5.3.2 11.9c0 2.1.6 4.1 1.6 5.9L0 24l6.4-1.7a12 12 0 0 0 5.7 1.5h.1c6.6 0 11.9-5.3 11.9-11.9 0-3.2-1.3-6.2-3.6-8.4Zm-8.4 18.3h-.1a9.9 9.9 0 0 1-5.1-1.4l-.4-.2-3.8 1 1-3.7-.2-.4a9.8 9.8 0 0 1-1.5-5.2C2 6.5 6.5 2 12 2c2.7 0 5.2 1 7 2.9a9.8 9.8 0 0 1 2.9 7c0 5.5-4.4 9.9-9.8 9.9Zm5.4-7.4c-.3-.1-1.8-.9-2.1-1-.3-.1-.5-.1-.7.2-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1-.3-.1-1.3-.5-2.5-1.6a9.4 9.4 0 0 1-1.7-2.1c-.2-.3 0-.5.1-.6l.5-.6.3-.5c.1-.2 0-.4 0-.5-.1-.1-.7-1.8-1-2.4-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1.1 1.1-1.1 2.7s1.2 3.1 1.3 3.3c.1.2 2.3 3.6 5.7 5 .8.3 1.4.5 1.9.7.8.3 1.5.2 2.1.1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.2-.4-.3-.7-.4Z" fill="currentColor"/></svg>';
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= e($siteName) ?> | Expedições exclusivas no Pantanal</title>
  <meta name="description" content="Aruanã Expedições: avistamento de onças, safáris fotográficos e experiências exclusivas no Pantanal, Transpantaneira e Porto Jofre.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" href="assets/css/aruna.css">
</head>
<body>
<header class="site-header aruna-header" data-header>
  <a class="aruna-logo" href="index.php" aria-label="Aruanã Expedições - início">
    <span class="aruna-logo-symbol">A</span>
    <span class="aruna-logo-copy"><b>ARUANÃ</b><small>EXPEDIÇÕES</small><em>PANTANAL · BRASIL</em></span>
  </a>
  <button class="menu-toggle" type="button" data-menu-toggle aria-label="Abrir menu">Menu</button>
  <nav data-menu>
    <a href="#experiencias">Experiências</a><a href="destinos.php">Destinos</a><a href="sobre.php">Sobre nós</a><a href="#galeria">Galeria</a><a href="#faq">FAQ</a>
    <a class="nav-cta whatsapp-cta" href="https://wa.me/<?= e($whatsapp) ?>" target="_blank" rel="noopener"><?= whatsapp_icon() ?><span>Fale no WhatsApp</span></a>
  </nav>
</header>
<main>
<section class="hero hero-premium">
  <?php if ($heroVideo): ?><video autoplay muted loop playsinline poster="<?= e($heroPoster) ?>"><source src="<?= e($heroVideo) ?>" type="video/mp4"></video><?php else: ?><img class="hero-photo" src="<?= e($heroPoster) ?>" alt="Pantanal"><?php endif; ?>
  <div class="hero-shade"></div><div class="hero-noise"></div>
  <div class="hero-content reveal">
    <p class="eyebrow gold">Expedições exclusivas · Pantanal · Brasil</p>
    <h1><?= e(setting('hero_title','Viva o Pantanal de verdade')) ?></h1>
    <p><?= e(setting('hero_subtitle','Expedições exclusivas entre onças, rios e horizontes selvagens. Uma conexão real com a natureza e a vida pantaneira.')) ?></p>
    <div class="hero-actions"><a class="btn-gold" href="#passeios">Explorar experiências</a><a class="text-link" href="sobre.php">Conheça a Aruanã →</a></div>
    <form class="hero-search aruna-search" method="get" action="index.php#passeios">
      <div class="search-field search-main"><span class="search-field-icon"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg></span><label for="q">Encontre sua experiência</label><input id="q" name="q" value="<?= e($q) ?>" placeholder="Ex.: onças em Porto Jofre"></div>
      <div class="search-field"><span class="search-field-icon"><svg viewBox="0 0 24 24"><path d="M4 7h16M7 12h10M10 17h4"/></svg></span><label for="category">Tipo de experiência</label><select id="category" name="category"><option value="">Todas</option><?php foreach ($categories as $cat): ?><option value="<?= e($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>><?= e($cat) ?></option><?php endforeach; ?></select></div>
      <button type="submit"><span>Buscar experiências</span><svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></button>
    </form>
  </div>
  <div class="hero-caption"><?= e($tagline) ?></div>
</section>

<section class="trust-strip premium-trust">
  <div><span class="trust-icon"><svg viewBox="0 0 32 32"><path d="M16 25c5 0 9-3 9-7 0-3-2-5-5-6-1-4-7-4-8 0-3 1-5 3-5 6 0 4 4 6 9 6Z"/><circle cx="9" cy="8" r="2"/><circle cx="16" cy="6" r="2"/><circle cx="23" cy="8" r="2"/></svg></span><strong>Avistamento de onças</strong><span>Porto Jofre</span></div>
  <div><span class="trust-icon"><svg viewBox="0 0 32 32"><circle cx="16" cy="13" r="5"/><path d="M8 27c1-6 4-9 8-9s7 3 8 9M7 5l4 3M25 5l-4 3"/></svg></span><strong>Guias especialistas</strong><span>Conhecimento local</span></div>
  <div><span class="trust-icon"><svg viewBox="0 0 32 32"><path d="M3 20h15l3-5h6l2 5-4 4H8Z"/><circle cx="9" cy="24" r="2"/><circle cx="23" cy="24" r="2"/><path d="M4 10h10l3 6M20 10c4 0 7 2 9 5"/></svg></span><strong>Expedições 4x4 e barco</strong><span>Segurança e conforto</span></div>
  <div><span class="trust-icon"><svg viewBox="0 0 32 32"><rect x="5" y="9" width="22" height="17" rx="3"/><circle cx="16" cy="17.5" r="5"/><path d="M11 9l2-4h6l2 4"/></svg></span><strong>Fotografia</strong><span>Vida selvagem</span></div>
  <div><span class="trust-icon"><svg viewBox="0 0 32 32"><path d="M16 27V13M16 19C9 19 5 14 5 7c7 0 11 4 11 10M16 16c0-7 4-11 11-11 0 7-4 11-11 11Z"/></svg></span><strong>Turismo responsável</strong><span>Grupos reduzidos</span></div>
</section>

<section class="intro premium-intro" id="experiencias"><p class="eyebrow dark">Aruanã Expedições</p><h2><?=e(setting('about_title','Natureza que emociona. Experiências que permanecem.'))?></h2><p><?=e(setting('about_text'))?></p><div class="benefits"><article><span class="benefit-number">01</span><strong>Conhecimento local</strong><span>Guias que leem o território, os rios e os movimentos da fauna.</span></article><article><span class="benefit-number">02</span><strong>Experiência premium</strong><span>Roteiros bem planejados, grupos reduzidos e atenção aos detalhes.</span></article><article><span class="benefit-number">03</span><strong>Turismo responsável</strong><span>Encontros com a natureza sem interferir em seu comportamento.</span></article></div></section>
<section class="jaguar-story"><div class="jaguar-photo reveal"><img src="<?=e($jaguarImage)?>" alt="Onça-pintada no Pantanal"><span>Panthera onca · Pantanal</span></div><div class="story-copy reveal"><p class="eyebrow gold">O grande encontro</p><h2>Em busca da onça-pintada.</h2><p>O Pantanal abriga uma das maiores concentrações de onças-pintadas do planeta. Em Porto Jofre, navegamos pelos rios e corixos acompanhados por guias especializados, respeitando o tempo e o espaço de cada animal.</p><blockquote>“Onde os rios se encontram, a vida selvagem nos ensina o verdadeiro luxo: existir.”</blockquote><a class="btn-gold" href="#passeios">Ver expedições de onça</a></div></section>
<section class="destination-feature"><div class="destination-copy reveal"><p class="eyebrow dark">122 pontes. Um caminho inesquecível.</p><h2>Transpantaneira</h2><p>Mais do que uma estrada, a Transpantaneira é uma travessia pela essência do Pantanal. Jacarés, tuiuiús, capivaras, campos alagados e pores do sol acompanham o caminho até Porto Jofre.</p><a class="text-link dark-link" href="destinos.php">Conhecer o destino →</a></div><img class="reveal" src="<?=e($landscapeImage)?>" alt="Paisagem da Transpantaneira"></section>
<section class="tours-section" id="passeios"><div class="section-title"><div><p class="eyebrow dark">Experiências Aruanã</p><h2>Escolha como viver o Pantanal</h2></div><span><?=count($tours)?> experiência<?=count($tours)===1?'':'s'?></span></div><?php if(!$tours):?><div class="empty">Nenhuma experiência encontrada para sua busca.</div><?php else:?><div class="tour-grid"><?php foreach($tours as $tour):?><article class="tour-card reveal"><a href="passeio.php?slug=<?=urlencode($tour['slug'])?>" class="tour-image"><img src="<?=e($tour['cover_image']?:$heroPoster)?>" alt="<?=e($tour['title'])?>"><?php if($tour['featured']):?><span class="badge">Seleção Aruanã</span><?php endif;?></a><div class="tour-body"><div class="tour-meta"><span><?=e($tour['category'])?></span><span><?=e($tour['duration'])?></span></div><h3><a href="passeio.php?slug=<?=urlencode($tour['slug'])?>"><?=e($tour['title'])?></a></h3><p><?=e($tour['short_description'])?></p><div class="tour-footer"><div><?php if($tour['price_from']):?><small>a partir de</small><strong>R$ <?=number_format((float)$tour['price_from'],2,',','.')?></strong><?php else:?><strong>Consulte</strong><?php endif;?></div><a href="passeio.php?slug=<?=urlencode($tour['slug'])?>">Explorar →</a></div></div></article><?php endforeach;?></div><?php endif;?></section>
<section class="editorial-gallery" id="galeria"><div class="gallery-heading reveal"><p class="eyebrow gold">Natureza em estado puro</p><h2>O Pantanal pelos olhos da Aruanã.</h2></div><div class="editorial-grid"><figure class="large reveal"><img src="<?=e($jaguarForestImage)?>" alt="Onça-pintada"><figcaption>Porto Jofre · Onças</figcaption></figure><figure class="reveal"><img src="<?=e($caimanImage)?>" alt="Jacaré no Pantanal"><figcaption>Rios · Vida selvagem</figcaption></figure><figure class="reveal"><img src="<?=e($landscapeImage)?>" alt="Paisagem pantaneira"><figcaption>Transpantaneira · Horizonte</figcaption></figure></div></section>
<section class="testimonials"><p class="eyebrow dark">Memórias de quem viveu</p><h2>O tipo de viagem que fica.</h2><div class="testimonial-grid"><article class="reveal"><div class="stars">★★★★★</div><p>“A sensação foi de estar em um documentário, mas com toda a tranquilidade de uma viagem muito bem organizada.”</p><strong>Marina & Eduardo</strong><span>São Paulo · SP</span></article><article class="reveal"><div class="stars">★★★★★</div><p>“Ver a onça no Rio Cuiabá foi inesquecível. O conhecimento do guia fez toda diferença.”</p><strong>Ricardo M.</strong><span>Curitiba · PR</span></article><article class="reveal"><div class="stars">★★★★★</div><p>“Do primeiro atendimento ao último pôr do sol, tudo foi cuidadoso e personalizado.”</p><strong>Ana Clara</strong><span>Belo Horizonte · MG</span></article></div></section>
<section class="faq-section" id="faq"><div><p class="eyebrow dark">Antes de viajar</p><h2>Perguntas frequentes</h2><p>Seu roteiro também pode ser construído de forma personalizada pela nossa equipe.</p><a class="btn-dark" href="contato.php">Planejar com a Aruanã</a></div><div class="faq-list"><details><summary>Qual a melhor época para ver onças-pintadas?</summary><p>A estação seca costuma favorecer a observação nos rios da região de Porto Jofre.</p></details><details><summary>Os roteiros são privativos?</summary><p>Podemos organizar experiências privativas ou em grupos reduzidos.</p></details><details><summary>Crianças podem participar?</summary><p>Sim. Ajustamos atividades e duração de acordo com a idade e o perfil da família.</p></details><details><summary>Vocês organizam hospedagem e transporte?</summary><p>Sim. Podemos construir a jornada completa, incluindo hospedagem e transfers.</p></details></div></section>
<section class="brand-manifesto"><div><span>ARUANÃ</span><p><?=e($tagline)?></p><a href="contato.php">Começar minha expedição</a></div></section>
</main>
<footer class="footer-premium"><div><a class="aruna-logo footer-logo" href="index.php"><span class="aruna-logo-symbol">A</span><span class="aruna-logo-copy"><b>ARUANÃ</b><small>EXPEDIÇÕES</small><em>PANTANAL · BRASIL</em></span></a><p><?=e($tagline)?></p></div><div><span>Explorar</span><a href="#passeios">Experiências</a><a href="destinos.php">Destinos</a><a href="sobre.php">Sobre nós</a></div><div><span>Atendimento</span><a href="contato.php">Planejar viagem</a><a class="footer-wa" href="https://wa.me/<?=e($whatsapp)?>" target="_blank" rel="noopener"><?=whatsapp_icon()?> WhatsApp</a></div></footer>
<a class="whatsapp-float" href="https://wa.me/<?=e($whatsapp)?>" target="_blank" rel="noopener" aria-label="Falar com a Aruanã no WhatsApp"><?=whatsapp_icon()?></a>
<script src="assets/js/app.js"></script>
</body></html>