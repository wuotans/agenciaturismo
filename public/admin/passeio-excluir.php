<?php
require_once __DIR__ . '/_auth.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
$id = (int)($_POST['id'] ?? 0);
$stmt = db()->prepare('DELETE FROM tours WHERE id = :id');
$stmt->execute(['id'=>$id]);
header('Location: index.php');
exit;
