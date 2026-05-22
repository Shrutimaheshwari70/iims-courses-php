<?php
/**
 * includes/header.php
 */

$page_title = $page_title ?? 'IIMs Courses — Discover, Compare & Apply to India\'s Top IIMs';
$page_description = $page_description ?? 'Explore all 14 IIMs, MBA & PGDM programmes, verified placements and rankings. Apply with free counselling.';
$body_class = $body_class ?? '';

// Auto-detect root path — works from index.php (root) AND pages/anything.php
$__script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$__parts = explode('/', trim($__script, '/'));
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
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="/iims-courses-php/assets/css/output.css">
    <link rel="stylesheet" href="<?= $__assetBase ?>assets/css/style.css" />
</head>
<style>
    /* Reading progress bar */
    #reading-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, var(--color-accent, #e25c2a), var(--color-primary, #1a3c6e));
        z-index: 9999;
        transition: width 0.1s linear;
    }
</style>
<!-- Reading progress bar -->
<div id="reading-progress"></div>
<div id="compareBar" style="display:none">
    <div class="cmpbar-inner">
        <div class="cmpbar-left">
            <span class="cmpbar-label">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <polyline points="16 3 21 3 21 8" />
                    <line x1="4" y1="20" x2="21" y2="3" />
                    <polyline points="21 16 21 21 16 21" />
                    <line x1="15" y1="15" x2="21" y2="21" />
                </svg>
                Compare
            </span>
            <div class="cmpbar-slots" id="cmpbarSlots"></div>
        </div>
        <div class="cmpbar-right">
            <button class="cmpbar-clear" id="cmpbarClear" title="Clear all">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6s" y1="6" x2="18" y2="18" />
                </svg>
                Clear
            </button>
            <a class="cmpbar-go" id="cmpbarGo" href="<?= $__assetBase ?>pages/compare.php">
                Compare Now
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                </svg>
            </a>
        </div>
    </div>
</div>

</body>
<script>
    (function () {
        var bar = document.getElementById('reading-progress');
        window.addEventListener('scroll', function () {
            var d = document.documentElement;
            var scrollTop = d.scrollTop || document.body.scrollTop;
            var total = d.scrollHeight - d.clientHeight;
            bar.style.width = (total > 0 ? (scrollTop / total * 100) : 0) + '%';
        }, { passive: true });
    })();

</script>

<body class="<?= htmlspecialchars($body_class) ?>" id="page-body">