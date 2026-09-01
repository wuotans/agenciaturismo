<?php
require_once __DIR__ . '/_auth.php';
require_admin();
$tourId = (int)($_POST['tour_id'] ?? 0);
if (empty($_FILES['image']['name']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) exit('Falha no upload.');
$allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
$mime = mime_content_type($_FILES['image']['tmp_name']);
if (!isset($allowed[$mime])) exit('Formato de imagem inválido.');
$dir = dirname(__DIR__) . '/uploads/tours';
if (!is_dir($dir)) mkdir($dir, 0775, true);
$name = bin2hex(random_bytes(10)) . '.' . $allowed[$mime];
move_uploaded_file($_FILES['image']['tmp_name'], $dir . '/' . $name);
$stmt = db()->prepare('INSERT INTO tour_images (tour_id,image_path,alt_text) VALUES (:tour_id,:image_path,:alt_text)');
$stmt->execute(['tour_id'=>$tourId,'image_path'=>'uploads/tours/'.$name,'alt_text'=>trim($_POST['alt_text'] ?? '')]);
header('Location: galeria.php?tour_id='.$tourId);
exit;
