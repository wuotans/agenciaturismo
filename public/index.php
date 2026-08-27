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

$heroVideo = setting('hero_video', '');
$heroPoster = setting('hero_poster', 'https://images.unsplash.com/photo-1725397006223-8a10a4c2bc0b?auto=format&fit=crop&q=88&w=2200');
$jaguarImage = setting('jaguar_image', 'https://images.unsplash.com/photo-1725397006223-8a10a4c2bc0b?auto=format&fit=crop&q=88&w=1800');
$landscapeImage = setting('transpantaneira_image', 'https://images.unsplash.com/photo-1690989751090-e29411e007b2?auto=format&fit=crop&q=88&w=1800');
$jaguarForestImage = setting('porto_jofre_image', 'https://images.unsplash.com/photo-1681227367357-8968aeab739f?auto=format&fit=crop&q=88&w=1800');
$caimanImage = setting('caiman_image', 'https://images.unsplash.com/photo-1621121658295-5f090c7d9274?auto=format&fit=crop&q=85&w=1600');
$whatsapp = preg_replace('/\D/', '', setting('whatsapp_number', env('WHATSAPP_NUMBER', '')));
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e(setting('site_name', 'Pantanal Experience')) ?> | Expedições exclusivas no Pantanal</title>
  <meta name="description" content="Expedições, safáris fotográficos e roteiros personalizados no Pantanal, Transpantaneira e Porto Jofre.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
<header class="site-header" data-header>
  <a class="brand" href="index.php"><span>PE</span><b><?= e(setting('site_name', 'Pantanal Experience')) ?></b></a>
  <button class="menu-toggle" type="button" data-menu-toggle aria-label="Abrir menu">Menu</button>
  <nav data-menu>
    <a href="#experiencias">Experiências</a>
    <a href="destinos.php">Destinos</a>
    <a href="sobre.php">Sobre nós</a>
    <a href="#faq">FAQ</a>
    <a class="nav-cta" href="#passeios">Planejar viagem</a>
  </nav>
</header>

<main>
<section class="hero hero-premium">
  <?php if ($heroVideo): ?>
    <video autoplay muted loop playsinline poster="<?= e($heroPoster) ?>"><source src="<?= e($heroVideo) ?>"></video>
  <?php else: ?>
    <img class="hero-photo" src="<?= e($heroPoster) ?>" alt="Onça-pintada próxima à água no Pantanal">
  <?php endif; ?>
  <div class="hero-shade"></div>
  <div class="hero-noise"></div>
  <div class="hero-content reveal">
    <p class="eyebrow">Pantanal · Mato Grosso · Brasil</p>
    <h1><?= e(setting('hero_title', 'O Pantanal em sua forma mais extraordinária')) ?></h1>
    <p><?= e(setting('hero_subtitle', 'Expedições autorais, encontros com a vida selvagem e roteiros construídos para quem quer sentir o Pantanal de verdade.')) ?></p>
    <div class="hero-actions"><a class="btn-light" href="#passeios">Explorar experiências</a><a class="text-link" href="sobre.php">Conheça nossa forma de viajar →</a></div>
    <form class="hero-search glass" method="get" action="index.php#passeios">
      <div><label for="q">O que você quer viver?</label><input id="q" name="q" value="<?= e($q) ?>" placeholder="Onça-pintada, safari, rio..."></div>
      <div><label for="category">Tipo de experiência</label><select id="category" name="category"><option value="">Todas</option><?php foreach ($categories as $cat): ?><option value="<?= e($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>><?= e($cat) ?></option><?php endforeach; ?></select></div>
      <button type="submit">Buscar</button>
    </form>
  </div>
  <div class="hero-sidecard reveal"><span>01</span><p>Safáris de barco em Porto Jofre com foco em observação da onça-pintada.</p></div>
  <div class="scroll-mark">Role para explorar</div>
</section>

<section class="lux-intro reveal">
  <div><p class="eyebrow dark">Curadoria pantaneira</p><h2>Menos turismo de massa.<br>Mais Pantanal de verdade.</h2></div>
  <div><p><?= e(setting('about_text', 'Criamos jornadas com ritmo, contexto e profundidade. Combinamos conhecimento local, logística bem planejada e acesso aos cenários mais emblemáticos do Pantanal para transformar cada viagem em uma experiência memorável.')) ?></p><a href="sobre.php" class="arrow-link">Nossa história e propósito →</a></div>
</section>

<section class="feature-story jaguar-story" id="experiencias">
  <div class="feature-media reveal"><img src="<?= e($jaguarImage) ?>" alt="Onça-pintada bebendo água no Pantanal"><div class="media-label">Panthera onca · Pantanal Norte</div></div>
  <div class="feature-copy reveal"><p class="eyebrow dark">A grande protagonista</p><h2>O encontro com a onça-pintada</h2><p>Entre julho e outubro, os rios da região de Porto Jofre concentram algumas das melhores oportunidades de observação de onças-pintadas em vida livre. Nossos roteiros priorizam tempo de campo, guias experientes e uma aproximação responsável.</p><ul class="clean-list"><li>Saídas de barco ao amanhecer e no fim da tarde</li><li>Guias especializados em fauna e fotografia</li><li>Grupos reduzidos e roteiros flexíveis</li><li>Observação responsável, sem interferir no comportamento animal</li></ul><a class="btn-dark" href="#passeios">Ver expedições de onça</a></div>
</section>

<section class="route-section">
  <div class="route-head reveal"><p class="eyebrow">Do portal ao coração do Pantanal</p><h2>Uma viagem que começa na Transpantaneira e termina onde o selvagem dita o ritmo.</h2></div>
  <div class="route-grid">
    <article class="route-card reveal"><img src="<?= e($landscapeImage) ?>" alt="Paisagem do Pantanal"><div><span>01</span><h3>Transpantaneira</h3><p>Uma das estradas de natureza mais emblemáticas do Brasil, cercada por campos alagáveis, pontes de madeira e fauna abundante.</p><a href="destinos.php#transpantaneira">Explorar destino →</a></div></article>
    <article class="route-card reveal"><img src="<?= e($jaguarForestImage) ?>" alt="Onça-pintada no Pantanal"><div><span>02</span><h3>Porto Jofre</h3><p>No fim da estrada, os rios Cuiabá, São Lourenço e Piquiri revelam o território mais conhecido para observação de onças-pintadas.</p><a href="destinos.php#porto-jofre">Explorar destino →</a></div></article>
  </div>
</section>

<section class="tours-section" id="passeios">
  <div class="section-title reveal"><div><p class="eyebrow dark">Experiências selecionadas</p><h2>Escolha como viver o Pantanal</h2></div><span><?= count($tours) ?> experiência<?= count($tours) === 1 ? '' : 's' ?> disponível<?= count($tours) === 1 ? '' : 'is' ?></span></div>
  <?php if (!$tours): ?><div class="empty">Nenhum passeio encontrado. Experimente outra busca.</div><?php else: ?>
  <div class="tour-grid">
    <?php foreach ($tours as $tour): ?>
      <article class="tour-card reveal">
        <a href="passeio.php?slug=<?= urlencode($tour['slug']) ?>" class="tour-image"><img src="<?= e($tour['cover_image'] ?: $jaguarImage) ?>" alt="<?= e($tour['title']) ?>"><?php if ($tour['featured']): ?><span class="badge">Seleção especial</span><?php endif; ?></a>
        <div class="tour-body"><div class="tour-meta"><span><?= e($tour['category']) ?></span><span><?= e($tour['duration']) ?></span></div><h3><a href="passeio.php?slug=<?= urlencode($tour['slug']) ?>"><?= e($tour['title']) ?></a></h3><p><?= e($tour['short_description']) ?></p><div class="tour-footer"><div><?php if ($tour['price_from']): ?><small>a partir de</small><strong>R$ <?= number_format((float)$tour['price_from'], 2, ',', '.') ?></strong><?php else: ?><strong>Consulte</strong><?php endif; ?></div><a href="passeio.php?slug=<?= urlencode($tour['slug']) ?>">Ver experiência →</a></div></div>
      </article>
    <?php endforeach; ?>
  </div><?php endif; ?>
</section>

<section class="editorial-grid reveal">
  <div class="editorial-copy"><p class="eyebrow dark">Natureza em movimento</p><h2>O Pantanal muda a cada estação.</h2><p>Águas, seca, flores, aves, felinos e rios redesenham a paisagem ao longo do ano. A melhor viagem é aquela planejada de acordo com o que você mais quer observar e sentir.</p><a href="contato.php" class="arrow-link">Fale com nossa equipe →</a></div>
  <figure class="editorial-tall"><img src="<?= e($caimanImage) ?>" alt="Jacaré nas águas do Pantanal"><figcaption>Jacarés fazem parte da paisagem cotidiana dos rios e corixos pantaneiros.</figcaption></figure>
  <figure><img src="<?= e($jaguarForestImage) ?>" alt="Vida selvagem no Pantanal"></figure>
  <figure><img src="<?= e($landscapeImage) ?>" alt="Paisagem pantaneira ao entardecer"></figure>
</section>

<section class="testimonials-section">
  <div class="section-kicker reveal"><p class="eyebrow dark">Quem viveu, conta</p><h2>Viagens que ficam na memória.</h2></div>
  <div class="testimonial-track">
    <blockquote class="reveal"><p>“A logística foi impecável e tivemos tempo de verdade para observar a fauna. Ver a onça no rio foi inesquecível.”</p><footer>Mariana & Rafael <span>São Paulo</span></footer></blockquote>
    <blockquote class="reveal"><p>“O roteiro não parecia pacote pronto. Tudo foi adaptado ao nosso ritmo, inclusive as saídas para fotografia.”</p><footer>Eduardo Martins <span>Curitiba</span></footer></blockquote>
    <blockquote class="reveal"><p>“A Transpantaneira já é uma experiência por si só. Porto Jofre completou a viagem com encontros incríveis.”</p><footer>Ana Paula <span>Belo Horizonte</span></footer></blockquote>
  </div>
</section>

<section class="faq-section" id="faq">
  <div class="faq-title reveal"><p class="eyebrow dark">Antes de embarcar</p><h2>Perguntas frequentes</h2><p>Se sua dúvida não estiver aqui, nossa equipe monta uma orientação personalizada pelo WhatsApp.</p></div>
  <div class="faq-list">
    <details class="reveal"><summary>Qual é a melhor época para ver onça-pintada?</summary><p>A estação seca, especialmente de julho a outubro, costuma oferecer ótimas condições de navegação e observação nas margens dos rios de Porto Jofre.</p></details>
    <details class="reveal"><summary>Os passeios são indicados para crianças?</summary><p>Sim. A idade ideal depende da duração, deslocamentos e tipo de atividade. Informe a idade das crianças na solicitação para recomendarmos o roteiro adequado.</p></details>
    <details class="reveal"><summary>Vocês montam roteiros personalizados?</summary><p>Sim. Podemos combinar hospedagem, deslocamentos, safáris terrestres, navegação, fotografia e experiências de acordo com o número de dias e perfil do grupo.</p></details>
    <details class="reveal"><summary>Como funciona a reserva?</summary><p>Você escolhe a experiência, informa viajantes e datas e o site envia tudo organizado para nosso WhatsApp. A equipe confirma disponibilidade e condições antes da reserva.</p></details>
  </div>
</section>

<section class="cta-cinematic" style="--cta-image:url('<?= e($jaguarImage) ?>')">
  <div class="reveal"><p class="eyebrow">Sua próxima história começa aqui</p><h2>Planeje uma expedição que tenha a sua cara.</h2><p>Conte quantas pessoas vão viajar, quando pretendem vir e o que mais desejam conhecer.</p><a class="btn-light" href="https://wa.me/<?= e($whatsapp) ?>" target="_blank" rel="noopener">Conversar pelo WhatsApp</a></div>
</section>
</main>

<footer id="contato" class="footer-premium"><div><a class="brand footer-brand" href="index.php"><span>PE</span><b><?= e(setting('site_name', 'Pantanal Experience')) ?></b></a><p>Expedições e experiências cuidadosamente desenhadas no Pantanal de Mato Grosso.</p></div><div><span>Explorar</span><a href="#passeios">Experiências</a><a href="destinos.php">Destinos</a><a href="sobre.php">Sobre nós</a></div><div><span>Atendimento</span><a href="contato.php">Planejar viagem</a><a href="https://wa.me/<?= e($whatsapp) ?>" target="_blank" rel="noopener">WhatsApp</a></div></footer>
<a class="whatsapp-float" href="https://wa.me/<?= e($whatsapp) ?>" target="_blank" rel="noopener" aria-label="Falar no WhatsApp">WA</a>
<script src="assets/js/app.js"></script>
</body>
</html>
