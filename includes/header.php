    <?php
/**
 * includes/header.php
 * HTML <head> + opening <body>
 * Usage: include this at the top of every page.
 *
 * Variables you can set before including:
 *   $page_title       — <title> text
 *   $page_description — meta description
 *   $body_class       — extra classes on <body>
 */

$page_title       = $page_title       ?? 'IIMs Courses — Discover, Compare & Apply to India\'s Top IIMs';
$page_description = $page_description ?? 'Explore all 14 IIMs, MBA & PGDM programmes, verified placements and rankings. Apply with free counselling.';
$body_class       = $body_class       ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta name="description" content="<?= htmlspecialchars($page_description) ?>" />
  <link rel="icon" href="assets/images/favicon.ico" />
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <!-- Main stylesheet -->
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body class="<?= htmlspecialchars($body_class) ?>" id="page-body">