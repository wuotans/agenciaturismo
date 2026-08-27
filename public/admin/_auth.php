<?php
require_once dirname(__DIR__, 2) . '/src/config.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
function require_admin(): void
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}
