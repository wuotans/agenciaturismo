<?php
require_once __DIR__ . '/_auth.php';
require_admin();

function save_image(string $field): ?string
{
    if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
    $mime = mime_content_type($_FILES[$field]['tmp_name']);
    if (!isset($allowed[$mime])) exit('Formato de imagem inválido.');
    $dir = dirname(__DIR__) . '/uploads/tours';
    if (!is_dir($dir)) mkdir($dir, 0775, true);
    $name = bin2hex(random_bytes(10)) . '.' . $allowed[$mime];
    move_uploaded_file($_FILES[$field]['tmp_name'], $dir . '/' . $name);
    return 'uploads/tours/' . $name;
}

$id = (int)($_POST['id'] ?? 0);
$data = [
    'title'=>trim($_POST['title'] ?? ''),
    'slug'=>trim($_POST['slug'] ?? ''),
    'short_description'=>trim($_POST['short_description'] ?? ''),
    'description'=>trim($_POST['description'] ?? ''),
    'location'=>trim($_POST['location'] ?? ''),
    'duration'=>trim($_POST['duration'] ?? ''),
    'category'=>trim($_POST['category'] ?? ''),
    'price_from'=>($_POST['price_from'] ?? '') !== '' ? $_POST['price_from'] : null,
    'featured'=>isset($_POST['featured']) ? 1 : 0,
    'active'=>isset($_POST['active']) ? 1 : 0,
];
$cover = save_image('cover_image');
if ($id) {
    $sql = 'UPDATE tours SET title=:title,slug=:slug,short_description=:short_description,description=:description,location=:location,duration=:duration,category=:category,price_from=:price_from,featured=:featured,active=:active';
    if ($cover) { $sql .= ',cover_image=:cover_image'; $data['cover_image']=$cover; }
    $sql .= ' WHERE id=:id'; $data['id']=$id;
    db()->prepare($sql)->execute($data);
} else {
    $data['cover_image']=$cover;
    db()->prepare('INSERT INTO tours (title,slug,short_description,description,location,duration,category,price_from,featured,active,cover_image) VALUES (:title,:slug,:short_description,:description,:location,:duration,:category,:price_from,:featured,:active,:cover_image)')->execute($data);
}
header('Location: index.php');
exit;
