<?php
require_once __DIR__ . '/_auth.php';
session_unset();
session_destroy();
header('Location: login.php');
exit;
