<?php
require_once __DIR__ . '/_auth.php';
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = db()->prepare('SELECT * FROM admins WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        header('Location: index.php');
        exit;
    }
    $error = 'E-mail ou senha inválidos.';
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Admin | Pantanal Experience</title><link rel="stylesheet" href="../assets/css/app.css"></head><body class="login-page"><div class="login-card"><h1>Painel administrativo</h1><p>Gerencie passeios, imagens e conteúdo do site.</p><?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?><form class="admin-form" method="post"><label>E-mail<input type="email" name="email" required></label><label>Senha<input type="password" name="password" required></label><button class="btn" type="submit">Entrar</button></form></div></body></html>
