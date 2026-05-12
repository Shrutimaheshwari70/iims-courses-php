<?php
/**
 * includes/header.php
 */

$page_title       = $page_title       ?? 'IIMs Courses — Discover, Compare & Apply to India\'s Top IIMs';
$page_description = $page_description ?? 'Explore all 14 IIMs, MBA & PGDM programmes, verified placements and rankings. Apply with free counselling.';
$body_class       = $body_class       ?? '';

// Auto-detect root path — works from index.php (root) AND pages/anything.php
$__script    = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$__parts     = explode('/', trim($__script, '/'));
$__assetBase = '/' . $__parts[0] . '/';
// e.g. /iims-courses-php/  — works for root AND pages/ subpages
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta name="description" content="<?= htmlspecialchars($page_description) ?>" />
  <link rel="icon" href="<?= $__assetBase ?>assets/images/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/iims-courses-php/assets/css/output.css">
  <link rel="stylesheet" href="<?= $__assetBase ?>assets/css/style.css" />
</head>

<body class="<?= htmlspecialchars($body_class) ?>" id="page-body">