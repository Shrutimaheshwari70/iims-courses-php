<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');
header('Cache-Control: no-store');

$slug = trim($_GET['slug'] ?? '');
if (!$slug) { echo json_encode(['success' => false]); exit; }

$list  = $_SESSION['compare'] ?? [];
$added = false;

if (in_array($slug, $list, true)) {
    $list = array_values(array_filter($list, fn($s) => $s !== $slug));
} else {
    if (count($list) >= 3) {
        echo json_encode(['success' => false, 'message' => 'Max 3 colleges can be compared']);
        exit;
    }
    $list[] = $slug;
    $added  = true;
}

$_SESSION['compare'] = $list;

echo json_encode([
    'success' => true,
    'added'   => $added,
    'count'   => count($list),
]);