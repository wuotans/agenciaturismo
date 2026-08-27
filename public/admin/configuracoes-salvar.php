<?php
require_once __DIR__ . '/_auth.php';
require_admin();

function upload_site_file(string $field, array $allowed, string $folder): ?string
{
    if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $mime = mime_content_type($_FILES[$field]['tmp_name']);
    if (!isset($allowed[$mime])) exit('Formato de arquivo inválido.');
    $dir = dirname(__DIR__) . '/uploads/' . $folder;
    if (!is_dir($dir)) mkdir($dir, 0775, true);
    $name = bin2hex(random_bytes(10)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $dir . '/' . $name)) exit('Não foi possível salvar o arquivo.');
    return 'uploads/' . $folder . '/' . $name;
}

$values = [
    'site_name' => trim($_POST['site_name'] ?? ''),
    'hero_title' => trim($_POST['hero_title'] ?? ''),
    'hero_subtitle' => trim($_POST['hero_subtitle'] ?? ''),
    'whatsapp_number' => preg_replace('/\D/', '', $_POST['whatsapp_number'] ?? ''),
    'about_title' => trim($_POST['about_title'] ?? ''),
    'about_text' => trim($_POST['about_text'] ?? ''),
];
$video = upload_site_file('hero_video_file', ['video/mp4'=>'mp4','video/webm'=>'webm'], 'site');
$poster = upload_site_file('hero_poster_file', ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'], 'site');
if ($video) $values['hero_video'] = $video;
if ($poster) $values['hero_poster'] = $poster;

$stmt = db()->prepare('INSERT INTO site_settings (setting_key,setting_value) VALUES (:key,:value) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');
foreach ($values as $key=>$value) $stmt->execute(['key'=>$key,'value'=>$value]);
header('Location: configuracoes.php');
exit;
