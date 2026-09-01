<?php
require_once dirname(__DIR__) . '/src/config.php';
$whatsapp = preg_replace('/\D/', '', setting('whatsapp_number', env('WHATSAPP_NUMBER', '')));
$hero = setting('transpantaneira_image', 'https://images.unsplash.com/photo-1690989751090-e29411e007b2?auto=format&fit=crop&q=88&w=2200');
$tours = db()->query("SELECT title FROM tours WHERE active = 1 ORDER BY featured DESC,title")->fetchAll(PDO::FETCH_COLUMN);
$siteName = setting('site_name','Aruanã Expedições');

function wa_icon(): string {
    return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 12.1 0C5.5 0 .2 5.3.2 11.9c0 2.1.6 4.1 1.6 5.9L0 24l6.4-1.7a12 12 0 0 0 5.7 1.5h.1c6.6 0 11.9-5.3 11.9-11.9 0-3.2-1.3-6.2-3.6-8.4Zm-8.4 18.3h-.1a9.9 9.9 0 0 1-5.1-1.4l-.4-.2-3.8 1 1-3.7-.2-.4a9.8 9.8 0 0 1-1.5-5.2C2 6.5 6.5 2 12 2c2.7 0 5.2 1 7 2.9a9.8 9.8 0 0 1 2.9 7c0 5.5-4.4 9.9-9.8 9.9Z" fill="currentColor"/></svg>';
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Planeje sua viagem | <?= e($siteName) ?></title>
  <meta name="description" content="Conte como imagina sua viagem ao Pantanal e receba um atendimento personalizado da Aruanã Expedições.">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/app.css"><link rel="stylesheet" href="assets/css/aruna.css">
</head>
<body class="contact-page">
<header class="site-header aruna-header" data-header>
  <a class="aruna-logo" href="index.php"><span class="aruna-logo-symbol">A</span><span class="aruna-logo-copy"><b>ARUANÃ</b><small>EXPEDIÇÕES</small><em>PANTANAL · BRASIL</em></span></a>
  <button class="menu-toggle" type="button" data-menu-toggle>Menu</button>
  <nav data-menu><a href="index.php#experiencias">Experiências</a><a href="destinos.php">Destinos</a><a href="sobre.php">Sobre nós</a><a href="index.php#faq">FAQ</a><a class="nav-cta whatsapp-cta" href="https://wa.me/<?=e($whatsapp)?>" target="_blank" rel="noopener"><?=wa_icon()?> <span>Fale no WhatsApp</span></a></nav>
</header>
<main>
<section class="contact-hero" style="background-image:url('<?=e($hero)?>')">
  <div class="contact-hero-inner reveal"><p class="eyebrow gold">Planejamento personalizado</p><h1>Sua viagem começa antes de chegar ao Pantanal.</h1><p>Conte o que você deseja viver e nossa equipe transforma suas datas, interesses e perfil em uma experiência pensada especialmente para você.</p></div>
</section>

<section class="contact-methods">
  <a class="contact-method reveal" href="https://wa.me/<?=e($whatsapp)?>" target="_blank" rel="noopener"><span class="contact-method-icon wa"><?=wa_icon()?></span><span><small>Resposta rápida</small><strong>Conversar pelo WhatsApp</strong></span></a>
  <div class="contact-method reveal"><span class="contact-method-icon"><svg viewBox="0 0 24 24"><path d="M12 21s7-5.2 7-12a7 7 0 1 0-14 0c0 6.8 7 12 7 12Z"/><circle cx="12" cy="9" r="2.5"/></svg></span><span><small>Base de operação</small><strong>Pantanal · Mato Grosso</strong></span></div>
  <div class="contact-method reveal"><span class="contact-method-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><span><small>Atendimento</small><strong>Roteiros sob medida</strong></span></div>
</section>

<section class="contact-premium-grid">
  <div class="contact-copy reveal"><p class="eyebrow dark">Atendimento Aruanã</p><h2>Não vendemos apenas datas. Construímos a experiência certa.</h2><p>Queremos entender se sua prioridade é observação de onças, fotografia, família, aves, navegação, aventura, conforto ou uma combinação de tudo isso.</p><p>Com esse contexto, conseguimos recomendar região, duração, hospedagem, deslocamentos e o ritmo ideal de cada dia.</p>
    <div class="contact-steps">
      <div class="contact-step"><b>01</b><div><strong>Você conta o que procura</strong><span>Datas, número de viajantes, interesses e preferências.</span></div></div>
      <div class="contact-step"><b>02</b><div><strong>Nós desenhamos o roteiro</strong><span>Selecionamos experiências e logística adequadas ao seu perfil.</span></div></div>
      <div class="contact-step"><b>03</b><div><strong>Você recebe tudo pelo WhatsApp</strong><span>Continuamos o atendimento de forma simples e direta.</span></div></div>
    </div>
  </div>

  <div class="planning-card reveal"><div class="planning-card-head"><div><p class="eyebrow dark">Começar agora</p><h3>Planeje sua expedição</h3></div><span>Leva menos de 2 minutos</span></div>
    <form id="general-whatsapp-form" class="premium-form" data-whatsapp="<?=e($whatsapp)?>">
      <label>Seu nome<input name="name" placeholder="Como podemos chamar você?" required></label>
      <label>Experiência de interesse<select name="tour"><option value="Roteiro personalizado">Quero ajuda para escolher</option><?php foreach($tours as $tour):?><option value="<?=e($tour)?>"><?=e($tour)?></option><?php endforeach;?></select></label>
      <div class="form-row"><label>Adultos<input type="number" min="1" name="adults" value="2" required></label><label>Crianças<input type="number" min="0" name="children" value="0" required></label></div>
      <div class="form-row"><label>Data de entrada<input type="date" name="start_date" required></label><label>Data de saída<input type="date" name="end_date" required></label></div>
      <label>O que não pode faltar?<textarea name="notes" placeholder="Ex.: quero ver onças, fazer fotografia, navegar no Rio Cuiabá, viajar com crianças..."></textarea></label>
      <button class="btn-whatsapp-submit" type="submit"><?=wa_icon()?> <span>Continuar pelo WhatsApp</span></button>
      <p class="privacy-note">Ao enviar, nenhuma informação é armazenada no site. A conversa será aberta diretamente no WhatsApp.</p>
    </form>
  </div>
</section>
<section class="contact-quote reveal"><p>“O melhor roteiro é aquele que respeita o seu tempo e o tempo da natureza.”</p><span>Aruanã Expedições · Pantanal</span></section>
</main>
<footer class="footer-premium"><div><a class="aruna-logo footer-logo" href="index.php"><span class="aruna-logo-symbol">A</span><span class="aruna-logo-copy"><b>ARUANÃ</b><small>EXPEDIÇÕES</small><em>PANTANAL · BRASIL</em></span></a><p>O Pantanal não se visita. Se vive.</p></div><div><span>Explorar</span><a href="index.php#passeios">Experiências</a><a href="destinos.php">Destinos</a><a href="sobre.php">Sobre nós</a></div><div><span>Atendimento</span><a class="footer-wa" href="https://wa.me/<?=e($whatsapp)?>" target="_blank" rel="noopener"><?=wa_icon()?> WhatsApp</a></div></footer>
<a class="whatsapp-float" href="https://wa.me/<?=e($whatsapp)?>" target="_blank" rel="noopener" aria-label="Falar no WhatsApp"><?=wa_icon()?></a>
<script src="assets/js/app.js"></script>
</body></html>