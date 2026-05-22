<?php
// SESSION — always start once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// AJAX handlers
if (
    isset($_GET['wl_action'], $_GET['wl_slug']) ||
    isset($_GET['cmp_action'], $_GET['cmp_slug']) ||
    (isset($_GET['cmp_action']) && $_GET['cmp_action'] === 'clear_all')
) {
    header('Content-Type: application/json');
    header('Cache-Control: no-store');
}
?>

<?php
/**
 * Navbar.php — Fixed: compare & wishlist badge update real-time (no refresh needed)
 */

if (!isset($COLLEGES) || !isset($COURSES)) {
    require_once __DIR__ . '/../data/iims.php';
}

$current_page = $current_page ?? '';
$is_home = ($current_page === 'home' || $_SERVER['REQUEST_URI'] === '/' ||
    $_SERVER['REQUEST_URI'] === '/index.php' || basename($_SERVER['SCRIPT_NAME']) === 'index.php');
$__script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/');
$__parts = explode('/', trim($__script, '/'));
$asset_base = '/' . ($__parts[0] ?? '') . '/';

$categories = [
    'Management',
    'Finance',
    'Marketing',
    'HR',
    'Operations',
    'Business Analytics',
    'International Business'
];

$course_cats = array_unique(array_column($COURSES, 'category'));

$colleges_json = json_encode($COLLEGES);
$courses_json = json_encode($COURSES);
$course_cats_json = json_encode(array_values($course_cats));
$categories_json = json_encode($categories);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #ffffff;
            color: #0f172a;
            font-family: var(--font-display);
            transition: background 0.2s, color 0.2s;
        }

        html,
        body {
            overflow-x: hidden;
        }

        body.dark {
            background: var(--background);
            color: var(--foreground);
        }

        .mobile-menu .nav-link,
        .mobile-menu .icon-btn svg,
        .mobile-menu .logo-title,
        .mobile-menu .logo-sub {
            color: white !important;
        }

        .navbar-main {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            transition: background 0.3s, box-shadow 0.3s, backdrop-filter 0.3s;
        }

        .navbar-main.scrolled {
            background: var(--background, #ffffff);
            box-shadow: var(--shadow-soft);
            border-bottom: 1px solid var(--border, #e2e8f0);
        }

        .navbar-main.transparent {
            background: transparent;
            backdrop-filter: none;
            border-bottom: none;
        }

        .navbar-main.transparent .nav-link,
        .navbar-main.transparent .icon-btn svg,
        .navbar-main.transparent .logo-title,
        .navbar-main.transparent .logo-sub {
            color: #ffffff;
        }

        .navbar-main.transparent .icon-btn {
            border-color: rgba(255, 255, 255, 0.3);
        }

        .navbar-main.transparent .icon-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .navbar-container {
            max-width: 1300px;
            margin: 0 auto;
        }

        .navbar-inner {
            display: flex;
            height: 72px;
            padding: 20px;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }

        .navbar-logo-icon img {
            width: 40px;
            height: 40px;
        }

        .navbar-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .logo-title {
            font-weight: 800;
            font-size: 1.1rem;
        }

        .logo-sub {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .navbar-main.transparent .logo-title,
        .navbar-main.transparent .logo-sub {
            color: white;
        }

        .desktop-nav {
            display: none;
            align-items: center;
            gap: 0.25rem;
            margin-left: auto;
            margin-right: auto;
        }

        @media (min-width: 1024px) {
            .desktop-nav {
                display: flex;
            }
        }

        .nav-link {
            padding: 0.5rem 0.85rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            font-weight: 500;
            background: none;
            border: none;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .nav-link:hover {
            background: var(--secondary, #f1f5f9);
        }

        .nav-link.active {
            color: var(--accent);
            font-weight: 600;
        }

        .navbar-main.transparent .nav-link {
            color: rgba(255, 255, 255, 0.9);
        }

        .navbar-main.transparent .nav-link:hover {
            background-color: transparent;
            color: white;
        }

        .chevron-icon {
            width: 14px;
            height: 14px;
            margin-left: 2px;
        }

        #megaCourses .mega-content {
            max-height: 420px;
        }

        #megaCourses .mega-content::-webkit-scrollbar {
            width: 6px;
        }

        #megaCourses .mega-content::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        #megaCourses .mega-sidebar {
            max-height: 420px;
            overflow-y: auto;
        }

        .icon-btn.active.cmp-toggle,
        .cmp-toggle.active {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .cmp-toggle.active svg {
            stroke: #3b82f6;
        }

        .cmp-toggle.pop {
            animation: cmpPop .25s ease;
        }

        @keyframes cmpPop {
            0% {
                transform: scale(.7);
                opacity: .5;
            }

            70% {
                transform: scale(1.15);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* ══════════════════════════════════════════
           MEGA DROPDOWN — panel shell + sidebar only
           ══════════════════════════════════════════ */
        .mega-dropdown {
            position: absolute;
            top: 70px;
            left: 0;
            min-width: 100%;
            max-width: 100%;
            opacity: 0;
            pointer-events: none;
            transform: translateY(8px);
            transition: opacity 0.2s, transform 0.2s;
        }

        .dropdown-root {
            position: static !important;
        }

        .dropdown-root.open .mega-dropdown {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        /* Better shadow + rounded panel */
        .mega-dropdown.bg-white {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.10), 0 2px 8px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        .mega-dropdown-inner {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
        }

        /* Sidebar — cleaner spacing, lighter divider */
        .mega-sidebar {
            width: 185px;
            flex-shrink: 0;
            padding: 18px 0 18px 4px;
            border-right: 1px solid #f1f5f9;
        }

        .sidebar-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #94a3b8;
            text-transform: uppercase;
            padding: 0 8px;
            margin-bottom: 10px;
            display: block;
        }

        .category-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        /* cat-btn — dot indicator, orange active (matches your accent) */
        .cat-btn {
            text-align: left;
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 0.80rem;
            font-weight: 500;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--foreground, #0f172a);
            transition: background 0.15s, color 0.15s;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .cat-btn::before {
            content: '';
            display: inline-block;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #cbd5e1;
            flex-shrink: 0;
            transition: background 0.15s;
        }

        .cat-btn:hover {
            background: var(--secondary, #f1f5f9);
        }

        .cat-btn:hover::before {
            background: #94a3b8;
        }

        .cat-btn.active {
            background: #fff7ed;
            color: #ff7a00;
            font-weight: 600;
        }

        .cat-btn.active::before {
            background: #ff7a00;
        }

        /* Content area */
        .mega-content {
            flex: 1;
            width: 100%;
            min-width: 0;
            padding: 18px 12px 18px 18px;
        }

        /* Content header — original, just tighter bottom border */
        .content-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Dropdown mega menu cards */
        #megaColleges .college-card,
        #megaCourses .course-card {
            border: 1px solid var(--border, #e2e8f0);
            border-radius: 10px;
            background: var(--card, #fff);
            transition: border-color 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        #megaColleges .college-card:hover,
        #megaCourses .course-card:hover {
            border-color: #ff6600;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .content-header>div:first-child {
            flex: 1;
            min-width: 0;
        }

        .content-header h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .content-header .count {
            font-size: 0.7rem;
            color: var(--muted-foreground, #64748b);
        }

        .content-header .view-link {
            font-size: 0.7rem;
            color: var(--accent);
            text-decoration: none !important;
            font-weight: 500;
            white-space: nowrap;
            flex-shrink: 0;
            margin-left: auto;
        }

        /* ── CARDS — 100% original, zero change ── */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            width: 100%;
        }

        .college-card,
        .course-card {
            width: 100%;
            min-width: 200px;
            padding: 10px;
        }

        .college-card:hover,
        .course-card:hover {
            border-color: var(--accent);
            box-shadow: var(--shadow-soft);
        }

        .college-info .name {
            font-weight: 600;
            font-size: 0.80rem;
        }

        .college-info .location {
            font-size: 0.6rem;
            color: var(--muted-foreground, #64748b);
            display: flex;
            align-items: center;
            gap: 0.2rem;
        }

        .course-card {
            flex-direction: column;
        }

        .course-title {
            font-weight: 600;
            font-size: 0.85rem;
        }

        .course-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem;
        }

        .tag {
            font-size: 0.6rem;
            padding: 0.2rem 0.5rem;
            border-radius: 999px;
            background: var(--secondary, #f1f5f9);
        }

        .dropdown-footer-link {
            display: block;
            margin-top: 1rem;
            padding-top: 0.8rem;
            border-top: 1px solid var(--border, #e2e8f0);
            text-align: center;
            font-size: 0.8rem;
            color: var(--accent);
            font-weight: 500;
            text-decoration: none;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        @media (min-width: 1024px) {

            .navbar-main.scrolled .logo-title,
            .navbar-main.scrolled .logo-sub {
                color: #0f172a !important;
                opacity: 1 !important;
            }
        }

        .navbar-logo-text .logo-sub {
            color: #0d1117;
        }

        .icon-btn {
            position: relative;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: none;
            border: 1px solid var(--border, #e2e8f0);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--foreground, #0f172a);
            transition: background 0.2s;
            text-decoration: none;
        }

        .icon-btn:hover {
            background: var(--secondary, #f1f5f9);
        }

        .icon-btn svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
        }

        .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--accent, #ff7a00);
            color: white;
            font-size: 0.55rem;
            font-weight: 700;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .badge.badge-visible {
            display: flex;
            animation: badgePop 0.25s ease;
        }

        @keyframes badgePop {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            70% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .icon-btn.cmp-active {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .icon-btn.wish-active {
            border-color: #e94560;
            color: #e94560;
        }

        .btn-primary {
            background: var(--gradient-accent);
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 0.6rem;
            font-weight: 500;
            font-size: 0.6rem;
            cursor: pointer;
            transition: transform 0.1s, opacity 0.2s;
            white-space: nowrap;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: scale(0.98);
        }

        .btn-outline {
            color: orange;
            border: 2px solid white;
            padding: 0.4rem 0.8rem;
            border-radius: 0.6rem;
            font-weight: 500;
            font-size: 0.8rem;
            cursor: pointer;
            transition: transform 0.1s, opacity 0.2s;
            white-space: nowrap;
        }

        .full-width {
            width: 100%;
            padding: 0.7rem;
            margin-top: 0.5rem;
        }

        .mobile-menu-toggle {
            display: flex;
        }

        @media (min-width: 1024px) {
            .mobile-menu-toggle {
                display: none;
            }
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 85%;
            max-width: 320px;
            background: #ffffff !important;
            z-index: 60;
            transform: translateX(100%);
            transition: transform 0.25s ease;
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
        }

        body.dark .mobile-menu {
            background: #0f172a !important;
        }

        .mobile-nav a,
        .mobile-menu-title,
        .close-menu-btn {
            color: #0f172a;
        }

        body.dark .mobile-nav a,
        body.dark .mobile-menu-title,
        body.dark .close-menu-btn {
            color: #ffffff;
        }

        .mobile-menu.open {
            transform: translateX(0);
        }

        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 55;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s;
        }

        .mobile-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .close-menu-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .mobile-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }

        .mobile-logo-icon img {
            width: 40px;
            height: 40px;
        }

        .mobile-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .mobile-nav a {
            font-size: 0.9rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
        }

        .mobile-login-btn {
            margin-top: 1rem;
            width: 100%;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 200;
            align-items: center;
            justify-content: center;
        }

        .modal.open {
            display: flex;
        }

        .modal-content {
            background: var(--card, #ffffff);
            border-radius: 1rem;
            width: 90%;
            max-width: 420px;
            box-shadow: var(--shadow-elegant);
        }

        .modal-header {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 1.5rem;
            border-bottom: 1px solid var(--border, #e2e8f0);
        }

        .modal-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }

        .modal-close {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid var(--border, #e2e8f0);
            background: transparent;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-subtitle {
            font-size: 0.85rem;
            color: var(--muted-foreground, #64748b);
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 0.3rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border, #e2e8f0);
            background: var(--background, #ffffff);
            color: var(--foreground, #0f172a);
        }

        .modal-footer-text {
            text-align: center;
            font-size: 0.7rem;
            margin-top: 1rem;
        }

        /* ════════════════════════════════════════════════════
           COMPARE BOTTOM BAR
           ════════════════════════════════════════════════════ */
        #compareBar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 49;
            background: #0d1117;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -4px 24px rgba(0, 0, 0, 0.3);
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(.4, 0, .2, 1);
        }

        #compareBar.bar-visible {
            transform: translateY(0);
        }

        .cmpbar-inner {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .cmpbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            min-width: 0;
        }

        .cmpbar-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .cmpbar-label svg {
            width: 14px;
            height: 14px;
            stroke: rgba(255, 255, 255, 0.5);
        }

        .cmpbar-slots {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: nowrap;
            overflow: hidden;
        }

        .cmpbar-slot {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            padding: 5px 8px 5px 6px;
            min-width: 0;
            animation: slotIn 0.25s ease;
        }

        @keyframes slotIn {
            from {
                opacity: 0;
                transform: translateY(6px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .cmpbar-slot-img {
            width: 28px;
            height: 28px;
            border-radius: 5px;
            object-fit: cover;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.1);
        }

        .cmpbar-slot-info {
            min-width: 0;
        }

        .cmpbar-slot-name {
            font-size: 0.72rem;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
        }

        .cmpbar-slot-loc {
            font-size: 0.6rem;
            color: rgba(255, 255, 255, 0.45);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
        }

        .cmpbar-slot-remove {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.5);
            flex-shrink: 0;
            transition: background 0.15s, color 0.15s;
            padding: 0;
        }

        .cmpbar-slot-remove:hover {
            background: rgba(233, 69, 96, 0.3);
            color: #e94560;
        }

        .cmpbar-slot-remove svg {
            width: 9px;
            height: 9px;
            stroke: currentColor;
            stroke-width: 2.5;
        }

        .cmpbar-slot-empty {
            width: 120px;
            height: 40px;
            border: 1.5px dashed rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.25);
            flex-shrink: 0;
            text-decoration: none;
        }

        .cmpbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .cmpbar-clear {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.45);
            background: none;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 6px;
            padding: 0.4rem 0.75rem;
            cursor: pointer;
            transition: color 0.15s, border-color 0.15s, background 0.15s;
        }

        .cmpbar-clear svg {
            width: 12px;
            height: 12px;
        }

        .cmpbar-clear:hover {
            color: #e94560;
            border-color: rgba(233, 69, 96, 0.4);
            background: rgba(233, 69, 96, 0.08);
        }

        .cmpbar-go {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 8px;
            padding: 0.5rem 1.1rem;
            text-decoration: none;
            transition: opacity 0.2s, transform 0.2s;
            box-shadow: 0 3px 12px rgba(59, 130, 246, 0.4);
        }

        .cmpbar-go svg {
            width: 13px;
            height: 13px;
        }

        .cmpbar-go:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        @media (max-width: 640px) {
            .cmpbar-label {
                display: none;
            }

            .cmpbar-slot-name {
                max-width: 80px;
            }

            .cmpbar-slot-loc {
                display: none;
            }

            .cmpbar-slot-empty {
                width: 80px;
            }

            .cmpbar-go {
                font-size: 0.72rem;
                padding: 0.45rem 0.85rem;
            }
        }

        @media (max-width: 570px) {
            .icon-btn[href*="compare.php"] {
                display: none;
            }
        }

        @media (max-width: 570px) {
            #themeToggle {
                display: none;
            }
        }

        @media (max-width: 400px) {
            #loginBtn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <header class="navbar-main" id="navbarMain" data-home="<?= $is_home ? 'true' : 'false' ?>">
        <div class="navbar-container">
            <div class="navbar-inner">
                <!-- Logo -->
                <a href="<?= $asset_base ?>index.php" class="navbar-logo">
                    <div class="navbar-logo-icon">
                        <img src="<?= $asset_base ?>assets/images/logo.webp" alt="Logo">
                    </div>
                    <div class="navbar-logo-text">
                        <span class="logo-title">IIMs Courses</span>
                        <span class="logo-sub">India's MBA Discovery</span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="desktop-nav">
                    <div class="dropdown-root position-relative" id="dropdownCollegesRoot">
                        <button class="nav-link dropdown-trigger" data-dropdown="colleges">
                            IIMs Colleges
                            <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </button>
                        <div class="mega-dropdown bg-white rounded shadow border py-3 px-2 overflow-hidden z-0"
                            id="megaColleges">
                            <div class="mega-dropdown-inner d-flex gap-3">
                                <div class="mega-sidebar pr-4">
                                    <span class="sidebar-label">Categories</span>
                                    <div class="category-list d-flex flex-column gap-1" id="collegeCategoriesList">
                                    </div>
                                </div>
                                <div class="mega-content">
                                    <div class="content-header justify-content-between gap-5 w-100 align-items-start mb-1"
                                        id="collegesContentHeader"></div>
                                    <div class="content-grid" id="collegesGrid"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown-root position-relative" id="dropdownCoursesRoot">
                        <button class="nav-link dropdown-trigger" data-dropdown="courses">
                            Courses
                            <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </button>
                        <div class="mega-dropdown bg-white rounded shadow border py-3 px-2 overflow-hidden"
                            id="megaCourses">
                            <div class="mega-dropdown-inner d-flex gap-3">
                                <div class="mega-sidebar pr-4">
                                    <span class="sidebar-label">Course Types</span>
                                    <div class="category-list d-flex flex-column gap-1" id="courseCategoriesList"></div>
                                </div>
                                <div class="mega-content">
                                    <div class="content-header justify-content-between gap-5 w-100 align-items-start mb-1"
                                        id="coursesContentHeader"></div>
                                    <div class="content-grid" id="coursesGrid"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $nav_links = [
                        ['url' => $asset_base . 'pages/about.php', 'label' => 'About', 'page' => 'about'],
                        ['url' => $asset_base . 'pages/blogs.php', 'label' => 'Blogs', 'page' => 'blogs'],
                        ['url' => $asset_base . 'pages/careers.php', 'label' => 'Careers', 'page' => 'careers'],
                        ['url' => $asset_base . 'pages/contact.php', 'label' => 'Contact', 'page' => 'contact'],
                    ];
                    foreach ($nav_links as $link): ?>
                        <a href="<?= $link['url'] ?>"
                            class="nav-link <?= $current_page === $link['page'] ? 'active' : '' ?>">
                            <?= $link['label'] ?>
                        </a>
                    <?php endforeach; ?>
                </nav>

                <!-- Right Actions -->
                <div class="navbar-actions">
                    <a href="<?= $asset_base ?>pages/compare.php" class="icon-btn">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="16 3 21 3 21 8" />
                            <line x1="4" y1="20" x2="21" y2="3" />
                            <polyline points="21 16 21 21 16 21" />
                            <line x1="15" y1="15" x2="21" y2="21" />
                        </svg>

                        <span class="badge cmp-count" id="cmpBadge">
                            <?= count($_SESSION['compare'] ?? []) ?>
                        </span>
                    </a>



                    <a href="<?= $asset_base ?>pages/wishlist.php" class="icon-btn">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                        </svg>
                        <span class="badge wish-count" id="wishBadge">
                            <?= count($_SESSION['wishlist'] ?? []) ?>
                        </span>

                    </a>
                    <button class="btn-primary" id="loginBtn">Login / Signup</button>

                    <button class="icon-btn mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menu">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <line x1="3" y1="12" x2="21" y2="12" />
                            <line x1="3" y1="18" x2="21" y2="18" />
                        </svg>
                        <svg class="close-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="display:none">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu — bilkul original -->
        <div class="mobile-menu" id="mobileMenu">
            <div class="nav-text mobile-logo d-flex justify-content-between align-items-center px-3 py-3 border-bottom">
                <div class="mobile-logo-icon d-flex gap-2">
                    <img src="<?= $asset_base ?>assets/images/logo.webp" alt="Logo">
                    <div class="mobile-logo-text">
                        <span class="logo-title">IIMs Courses</span>
                        <span class="logo-sub">India's MBA Discovery</span>
                    </div>
                </div>
                <button class="close-menu-btn" id="closeMobileMenu">✕</button>
            </div>
            <nav class="mobile-nav d-flex flex-column px-2">
                <a class="p-2 border-bottom text-decoration-none py-3" href="<?= $asset_base ?>index.php">Home</a>
                <a class="p-2 border-bottom text-decoration-none py-3" href="<?= $asset_base ?>pages/colleges.php">IIMs
                    Colleges</a>
                <a class="p-2 border-bottom text-decoration-none py-3"
                    href="<?= $asset_base ?>pages/courses.php">Courses</a>
                <a class="p-2 border-bottom text-decoration-none py-3"
                    href="<?= $asset_base ?>pages/about.php">About</a>
                <a class="p-2 border-bottom text-decoration-none py-3"
                    href="<?= $asset_base ?>pages/blogs.php">Blogs</a>
                <a class="p-2 border-bottom text-decoration-none py-3"
                    href="<?= $asset_base ?>pages/careers.php">Careers</a>
                <a class="p-2 border-bottom text-decoration-none py-3"
                    href="<?= $asset_base ?>pages/compare.php">Compare</a>
                <a class="p-2 border-bottom text-decoration-none py-3"
                    href="<?= $asset_base ?>pages/wishlist.php">Wishlist</a>
                <a class="p-2 border-bottom text-decoration-none py-3"
                    href="<?= $asset_base ?>pages/contact.php">Contact</a>
                <button class="btn-primary mobile-login-btn" id="mobileLoginBtn">Login / Signup</button>
            </nav>
        </div>
        <div class="mobile-overlay" id="mobileOverlay"></div>
    </header>

    <!-- COMPARE BOTTOM BAR -->
    <div id="compareBar" style="display:none">
        <div class="cmpbar-inner">
            <div class="cmpbar-left">
                <span class="cmpbar-label">
                    <svg viewBox="0 0 24 24" fill="none">
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
                <button class="cmpbar-clear" id="cmpbarClear">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Clear
                </button>
                <a href="<?= $asset_base ?>pages/compare.php" class="cmpbar-go">
                    Compare Now
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <script>
        const collegesData = <?= $colleges_json ?>;
        const coursesData = <?= $courses_json ?>;
        const categoriesList = <?= $categories_json ?>;
        const courseCategoriesList = <?= $course_cats_json ?>;
        const assetBase = "<?= $asset_base ?>";

        let activeCollegeCat = categoriesList[0];
        let activeCourseCat = courseCategoriesList[0] || "MBA";

        /* ================================================================
           BADGE HELPERS — unified, instant, no-refresh
           ================================================================ */
        function updateBadge(badgeId, count) {
            var badge = document.getElementById(badgeId);
            if (!badge) return;

            var prev = parseInt(badge.textContent, 10) || 0;

            badge.textContent = count;

            if (count > 0) {
                badge.classList.add('badge-visible');

                if (count !== prev) {
                    badge.classList.remove('badge-visible');
                    badge.offsetWidth;
                    badge.classList.add('badge-visible');
                }

            } else {
                badge.classList.remove('badge-visible');
            }
        }

        function initBadge(badgeId, count) {
            var badge = document.getElementById(badgeId);
            if (!badge) return;
            badge.textContent = count;
            if (count > 0) badge.classList.add('badge-visible');
        }

        window.updateWishBadge = function (count) { updateBadge('wishBadge', count); };
        window.updateCmpBadge = function (count) { updateBadge('cmpBadge', count); };
        /* ================================================================
           MEGA DROPDOWN
           ================================================================ */
        function renderColleges(category) {
            var filtered = collegesData.filter(function (c) {
                return c.category && c.category.includes(category);
            }).slice(0, 8);
            document.getElementById('collegesContentHeader').innerHTML =
                '<div class="content-header"><div><h4>' + category + ' • IIMs</h4>'
                + '<div class="count">' + filtered.length + ' institutes</div></div>'
                + '<a href="' + assetBase + 'pages/colleges.php" class="view-link">View all →</a></div>';
            var g = '';
            filtered.forEach(function (c) {
                g += '<a href="' + assetBase + 'pages/college-details.php?slug=' + c.slug
                    + '" class="college-card"><div class="college-info">'
                    + '<div class="name">' + escapeHtml(c.name) + '</div>'
                    + '<div class="location">' + escapeHtml(c.location) + '</div>'
                    + '</div></a>';
            });
            document.getElementById('collegesGrid').innerHTML = '<div class="content-grid">' + g + '</div>';
        }

        function renderCourses(category) {
            var filtered = coursesData.filter(function (c) { return c.category === category; }).slice(0, 8);
            document.getElementById('coursesContentHeader').innerHTML =
                '<div class="content-header"><div><h4>' + category + '</h4>'
                + '<div class="count">' + filtered.length + ' programmes</div></div>'
                + '<a href="' + assetBase + 'pages/courses.php" class="view-link">View all →</a></div>';
            var g = '';
            if (!filtered.length) {
                g = '<div style="grid-column:span 2;text-align:center;padding:2rem">No programmes found</div>';
            } else {
                filtered.forEach(function (c) {
                    var tags = (c.iims || []).slice(0, 3).map(function (slug) {
                        var col = collegesData.find(function (cl) { return cl.slug === slug; });
                        return '<span class="tag">' + escapeHtml(col ? (col.short || col.name) : slug) + '</span>';
                    }).join('');
                    g += '<a href="' + assetBase + 'pages/course-details.php?slug=' + c.slug
                        + '" class="course-card"><div class="course-title">' + escapeHtml(c.title) + '</div>'
                        + '<div class="course-tags">' + tags + '</div></a>';
                });
            }
            document.getElementById('coursesGrid').innerHTML = '<div class="content-grid">' + g + '</div>';
        }

        function buildCategoryButtons(containerId, list, activeCat, onSelect) {
            var container = document.getElementById(containerId);
            if (!container) return;
            container.innerHTML = '';
            list.forEach(function (cat) {
                var btn = document.createElement('button');
                btn.className = 'cat-btn' + (activeCat === cat ? ' active' : '');
                btn.textContent = cat;
                btn.onmouseenter = function () {
                    document.querySelectorAll('#' + containerId + ' .cat-btn')
                        .forEach(function (b) { b.classList.remove('active'); });
                    btn.classList.add('active');
                    onSelect(cat);
                };
                container.appendChild(btn);
            });
        }

        function escapeHtml(str) {
            return String(str).replace(/[&<>'"]/g, function (m) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[m];
            });
        }

        var closeTimeout = null;
        function setupDropdown(rootId, dropdownId) {
            var root = document.getElementById(rootId);
            if (!root) return;
            var trigger = root.querySelector('.dropdown-trigger');
            var panel = document.getElementById(dropdownId);
            var open = function () {
                if (closeTimeout) clearTimeout(closeTimeout);
                document.querySelectorAll('.dropdown-root.open').forEach(function (d) { d.classList.remove('open'); });
                root.classList.add('open');
            };
            var close = function () {
                closeTimeout = setTimeout(function () { root.classList.remove('open'); }, 100);
            };
            trigger.addEventListener('mouseenter', open);
            panel.addEventListener('mouseenter', function () { if (closeTimeout) clearTimeout(closeTimeout); });
            trigger.addEventListener('mouseleave', close);
            panel.addEventListener('mouseleave', close);
        }

        function initTheme() {
            if (localStorage.getItem('theme') === 'dark') document.body.classList.add('dark');
            else { document.body.classList.remove('dark'); localStorage.setItem('theme', 'light'); }
        }

        function initScrollEffect() {
            var navbar = document.getElementById('navbarMain');
            var isHome = navbar && navbar.dataset.home === 'true';
            if (!isHome) { navbar.classList.add('scrolled'); return; }
            var handle = function () {
                if (window.scrollY > 30) {
                    navbar.classList.add('scrolled');
                    navbar.classList.remove('transparent');
                } else {
                    navbar.classList.remove('scrolled');
                    navbar.classList.add('transparent');
                }
            };
            window.addEventListener('scroll', handle);
            handle();
        }

        function initMobileMenu() {
            var menu = document.getElementById('mobileMenu');
            var overlay = document.getElementById('mobileOverlay');
            var openM = function () { menu.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow = 'hidden'; };
            var closeM = function () { menu.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; };
            document.getElementById('mobileMenuToggle')?.addEventListener('click', openM);
            document.getElementById('closeMobileMenu')?.addEventListener('click', closeM);
            overlay?.addEventListener('click', closeM);
        }

        function initModal() {
            var modal = document.getElementById('loginModal');
            if (!modal) return;
            var openFn = function () { modal.classList.add('open'); document.body.style.overflow = 'hidden'; };
            window.closeModal = function () { modal.classList.remove('open'); document.body.style.overflow = ''; };
            document.getElementById('loginBtn')?.addEventListener('click', openFn);
            document.getElementById('mobileLoginBtn')?.addEventListener('click', openFn);
            document.getElementById('closeModalBtn')?.addEventListener('click', closeModal);
            modal?.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
        }

        function initMegas() {
            buildCategoryButtons('collegeCategoriesList', categoriesList, activeCollegeCat, function (cat) {
                activeCollegeCat = cat; renderColleges(cat);
            });
            renderColleges(activeCollegeCat);
            if (courseCategoriesList.length) {
                buildCategoryButtons('courseCategoriesList', courseCategoriesList, activeCourseCat, function (cat) {
                    activeCourseCat = cat; renderCourses(cat);
                });
                renderCourses(activeCourseCat);
            }
            setupDropdown('dropdownCollegesRoot', 'megaColleges');
            setupDropdown('dropdownCoursesRoot', 'megaCourses');
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateWishBadge(
                <?= count($_SESSION['wishlist'] ?? []) ?>
            );

            updateCmpBadge(
                <?= count($_SESSION['compare'] ?? []) ?>
            );
            initTheme();
            initScrollEffect();
            initMobileMenu();
            initModal();
            initMegas();
        });
    </script>
</body>

</html>