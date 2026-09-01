<?php

declare(strict_types=1);

function env(string $key, ?string $default = null): ?string
{
    static $vars = null;
    if ($vars === null) {
        $vars = [];
        $path = dirname(__DIR__) . '/.env';
        if (is_file($path)) {
            foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                    continue;
                }
                [$name, $value] = array_map('trim', explode('=', $line, 2));
                $vars[$name] = trim($value, "\"'");
            }
        }
    }

    return $vars[$key] ?? $_ENV[$key] ?? getenv($key) ?: $default;
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        env('DB_HOST', '127.0.0.1'),
        env('DB_PORT', '3306'),
        env('DB_NAME', 'agencia_pantanal')
    );

    $pdo = new PDO($dsn, env('DB_USER', 'root'), env('DB_PASS', ''), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

function setting(string $key, ?string $default = null): ?string
{
    static $settings = null;
    if ($settings === null) {
        $settings = [];
        try {
            foreach (db()->query('SELECT setting_key, setting_value FROM site_settings') as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Throwable $e) {
            return $default;
        }
    }

    return $settings[$key] ?? $default;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function app_url(string $path = ''): string
{
    $base = rtrim((string) env('APP_URL', ''), '/');
    return $base . '/' . ltrim($path, '/');
}
