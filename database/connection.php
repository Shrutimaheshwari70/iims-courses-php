<?php
/**
 * database/connection.php
 * PDO database connection. Update credentials in includes/config.php or .env.
 *
 * Usage:
 *   require_once __DIR__ . '/../database/connection.php';
 *   $row = $pdo->query("SELECT * FROM colleges LIMIT 1")->fetch();
 */

// Database credentials — override via environment variables in production
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'iims_courses';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_port = getenv('DB_PORT') ?: '3306';
$db_charset = 'utf8mb4';

$dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset={$db_charset}";

$pdo_options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
} catch (PDOException $e) {
    // Log but don't expose details in production
    error_log('DB connection failed: ' . $e->getMessage());
    // Gracefully fall back — app uses static data/iims.php as data source
    $pdo = null;
}
