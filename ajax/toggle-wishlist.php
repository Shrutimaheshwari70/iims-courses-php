<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');
header('Cache-Control: no-store');

$slug = trim($_GET['slug'] ?? '');
if (!$slug) { echo json_encode(['success' => false]); exit; }

$list  = $_SESSION['wishlist'] ?? [];
$added = false;

if (in_array($slug, $list, true)) {
    $list = array_values(array_filter($list, fn($s) => $s !== $slug));
} else {
    $list[] = $slug;
    $added  = true;
}

$_SESSION['wishlist'] = $list;

echo json_encode([
    'success' => true,
    'added'   => $added,
    'count'   => count($list),
]);