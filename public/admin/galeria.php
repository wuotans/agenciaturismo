<?php
require_once __DIR__ . '/_auth.php';
require_admin();
$tourId = (int)($_GET['tour_id'] ?? 0);
$stmt = db()->prepare('SELECT id,title FROM tours WHERE id=:id');
$stmt->execute(['id'=>$tourId]);
$tour = $stmt->fetch();
if (!$tour) exit('Passeio não encontrado.');
$images = db()->prepare('SELECT * FROM tour_images WHERE tour_id=:tour_id ORDER BY sort_order,id');
$images->execute(['tour_id'=>$tourId]);
$gallery = $images->fetchAll();
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Galeria | <?= e($tour['title']) ?></title><link rel="stylesheet" href="../assets/css/app.css"></head><body class="admin-shell"><header class="admin-top"><strong>Galeria · <?= e($tour['title']) ?></strong><a href="index.php">Voltar</a></header><main class="admin-main"><section class="admin-panel"><form class="admin-form" method="post" action="galeria-salvar.php" enctype="multipart/form-data"><input type="hidden" name="tour_id" value="<?= $tourId ?>"><div class="two"><label>Nova foto<input type="file" name="image" accept="image/jpeg,image/png,image/webp" required></label><label>Texto alternativo<input name="alt_text" placeholder="Onça-pintada às margens do rio"></label></div><button class="btn" type="submit">Adicionar foto</button></form></section><section class="admin-panel" style="margin-top:24px"><h2>Fotos cadastradas</h2><div class="gallery"><?php foreach($gallery as $image): ?><div><img src="../<?= e($image['image_path']) ?>" alt="<?= e($image['alt_text']) ?>"><form method="post" action="galeria-excluir.php" onsubmit="return confirm('Excluir esta foto?')"><input type="hidden" name="id" value="<?= (int)$image['id'] ?>"><input type="hidden" name="tour_id" value="<?= $tourId ?>"><button class="btn danger" type="submit" style="margin-top:8px">Excluir foto</button></form></div><?php endforeach; ?></div></section></main></body></html>
