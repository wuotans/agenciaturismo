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

function valid_http_url(string $value): string
{
    $value = trim($value);
    return $value !== '' && filter_var($value, FILTER_VALIDATE_URL) && preg_match('/^https?:\/\//i', $value) ? $value : '';
}

$values = [
    'site_name' => trim($_POST['site_name'] ?? ''),
    'hero_title' => trim($_POST['hero_title'] ?? ''),
    'hero_subtitle' => trim($_POST['hero_subtitle'] ?? ''),
    'whatsapp_number' => preg_replace('/\D/', '', $_POST['whatsapp_number'] ?? ''),
    'about_title' => trim($_POST['about_title'] ?? ''),
    'about_text' => trim($_POST['about_text'] ?? ''),
    'jaguar_image' => valid_http_url($_POST['jaguar_image'] ?? ''),
    'transpantaneira_image' => valid_http_url($_POST['transpantaneira_image'] ?? ''),
    'porto_jofre_image' => valid_http_url($_POST['porto_jofre_image'] ?? ''),
    'caiman_image' => valid_http_url($_POST['caiman_image'] ?? ''),
];

$video = upload_site_file('hero_video_file', ['video/mp4'=>'mp4','video/webm'=>'webm'], 'site');
$poster = upload_site_file('hero_poster_file', ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'], 'site');
$videoUrl = valid_http_url($_POST['hero_video_url'] ?? '');
$posterUrl = valid_http_url($_POST['hero_poster_url'] ?? '');
if ($video) $values['hero_video'] = $video;
elseif ($videoUrl) $values['hero_video'] = $videoUrl;
if ($poster) $values['hero_poster'] = $poster;
elseif ($posterUrl) $values['hero_poster'] = $posterUrl;

$stmt = db()->prepare('INSERT INTO site_settings (setting_key,setting_value) VALUES (:key,:value) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');
foreach ($values as $key=>$value) $stmt->execute(['key'=>$key,'value'=>$value]);
header('Location: configuracoes.php');
exit;