<?php
require_once __DIR__ . '/_auth.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
$id = (int)($_POST['id'] ?? 0);
$tourId = (int)($_POST['tour_id'] ?? 0);
$stmt = db()->prepare('SELECT image_path FROM tour_images WHERE id=:id');
$stmt->execute(['id'=>$id]);
$image = $stmt->fetch();
if ($image) {
    $file = dirname(__DIR__) . '/' . $image['image_path'];
    if (is_file($file)) @unlink($file);
    db()->prepare('DELETE FROM tour_images WHERE id=:id')->execute(['id'=>$id]);
}
header('Location: galeria.php?tour_id='.$tourId);
exit;
