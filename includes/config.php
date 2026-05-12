<?php
/**
 * includes/config.php
 * Global configuration constants and session start.
 */

// Detect base URL automatically
$protocol  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host      = $_SERVER['HTTP_HOST'] ?? 'localhost';
// Find the project root relative to document root
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
// Walk up until we find index.php at root
$base      = rtrim($scriptDir, '/') . '/';

// Simpler: just define base as '/' or subfolder
define('BASE_URL', '/');           // Change to '/iims-courses-php/' if in subfolder
define('SITE_NAME', 'IIMs Courses');
define('SITE_TAGLINE', "India's MBA Discovery Platform");
define('CONTACT_EMAIL', 'hello@iimscourses.com');
define('CONTACT_PHONE', '+91 90000 11122');

// Error reporting (disable in production)
if (defined('DEV_MODE') && DEV_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
