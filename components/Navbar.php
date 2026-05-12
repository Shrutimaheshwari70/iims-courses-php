<?php
$compareCount = count($_SESSION['compare'] ?? []);
?>
<?php
/**
 * Navbar.php
 */

if (!isset($COLLEGES) || !isset($COURSES)) {
    require_once __DIR__ . '/../data/iims.php';
}

$current_page = $current_page ?? '';
$is_home = ($current_page === 'home' || $_SERVER['REQUEST_URI'] === '/' ||
            $_SERVER['REQUEST_URI'] === '/index.php' || basename($_SERVER['SCRIPT_NAME']) === 'index.php');

$wish_count = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;
$comp_count = isset($_SESSION['compare'])  ? count($_SESSION['compare'])  : 0;

$__script   = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/');
$__parts    = explode('/', trim($__script, '/'));
$asset_base = '/' . ($__parts[0] ?? '') . '/';

$categories = [
    'Management', 'Finance', 'Marketing', 'HR',
    'Operations', 'Business Analytics', 'International Business'
];

$course_cats = array_unique(array_column($COURSES, 'category'));

$colleges_json    = json_encode($COLLEGES);
$courses_json     = json_encode($COURSES);
$course_cats_json = json_encode(array_values($course_cats));
$categories_json  = json_encode($categories);

// ✅ Wishlist AJAX handler
if (isset($_GET['wl_action']) && isset($_GET['wl_slug'])) {
    $wl_slug   = trim($_GET['wl_slug']);
    $wl_action = trim($_GET['wl_action']);
    $wishlist  = $_SESSION['wishlist'] ?? [];

    if ($wl_action === 'add' && !in_array($wl_slug, $wishlist)) {
        $wishlist[] = $wl_slug;
    } elseif ($wl_action === 'remove') {
        $wishlist = array_values(array_filter($wishlist, fn($s) => $s !== $wl_slug));
    }

    $_SESSION['wishlist'] = $wishlist;
    header('Content-Type: application/json');
    echo json_encode(['count' => count($wishlist), 'action' => $wl_action]);
    exit;
}

// ✅ Compare AJAX handler
if (isset($_GET['cmp_action']) && isset($_GET['cmp_slug'])) {
    $cmp_slug   = trim($_GET['cmp_slug']);
    $cmp_action = trim($_GET['cmp_action']);
    $compare    = $_SESSION['compare'] ?? [];

    if ($cmp_action === 'add' && !in_array($cmp_slug, $compare) && count($compare) < 3) {
        $compare[] = $cmp_slug;
    } elseif ($cmp_action === 'remove') {
        $compare = array_values(array_filter($compare, fn($s) => $s !== $cmp_slug));
    }

    $_SESSION['compare'] = $compare;
    header('Content-Type: application/json');
    echo json_encode(['count' => count($compare), 'action' => $cmp_action, 'list' => $compare]);
    exit;
}
?>
<header class="navbar-main" id="navbarMain" data-home="<?= $is_home ? 'true' : 'false' ?>">
    <div class="navbar-container">
        <div class="navbar-inner">
            <!-- Logo -->
            <a href="<?= $asset_base ?>index.php" class="navbar-logo">
                <div class="navbar-logo-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                        <path d="M6 12v5c3 3 9 3 12 0v-5" />
                    </svg>
                </div>
                <div class="navbar-logo-text">
                    <span class="logo-title">IIMs Courses</span>
                    <span class="logo-sub">India's MBA Discovery</span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <nav class="desktop-nav">
                <div class="dropdown-root" id="dropdownCollegesRoot">
                    <button class="nav-link dropdown-trigger" data-dropdown="colleges">
                        IIMs Colleges
                        <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </button>
                    <div class="mega-dropdown" id="megaColleges">
                        <div class="mega-dropdown-inner">
                            <div class="mega-sidebar">
                                <div class="sidebar-label">Categories</div>
                                <div class="category-list" id="collegeCategoriesList"></div>
                            </div>
                            <div class="mega-content">
                                <div class="content-header" id="collegesContentHeader"></div>
                                <div class="content-grid" id="collegesGrid"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown-root" id="dropdownCoursesRoot">
                    <button class="nav-link dropdown-trigger" data-dropdown="courses">
                        Courses
                        <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </button>
                    <div class="mega-dropdown" id="megaCourses">
                        <div class="mega-dropdown-inner">
                            <div class="mega-sidebar">
                                <div class="sidebar-label">Course Types</div>
                                <div class="category-list" id="courseCategoriesList"></div>
                            </div>
                            <div class="mega-content">
                                <div class="content-header" id="coursesContentHeader"></div>
                                <div class="content-grid" id="coursesGrid"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $nav_links = [
                    ['url' => $asset_base . 'pages/about.php',   'label' => 'About',   'page' => 'about'],
                    ['url' => $asset_base . 'pages/blogs.php',   'label' => 'Blogs',   'page' => 'blogs'],
                    ['url' => $asset_base . 'pages/careers.php', 'label' => 'Careers', 'page' => 'careers'],
                    ['url' => $asset_base . 'pages/contact.php', 'label' => 'Contact', 'page' => 'contact'],
                ];
                foreach ($nav_links as $link): ?>
                    <a href="<?= $link['url'] ?>" class="nav-link <?= $current_page === $link['page'] ? 'active' : '' ?>">
                        <?= $link['label'] ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <!-- Right Actions -->
            <div class="navbar-actions">
                <!-- Compare -->
                <a href="<?= $asset_base ?>pages/compare.php" class="icon-btn" aria-label="Compare">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/>
                        <polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/>
                    </svg>
                    <span class="badge" id="cmpBadge" style="<?= $comp_count > 0 ? '' : 'display:none' ?>"><?= $comp_count ?></span>
                </a>

                <!-- Wishlist -->
                <a href="<?= $asset_base ?>pages/wishlist.php" class="icon-btn" id="navWishBtn" aria-label="Wishlist">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    <span class="badge" id="wishBadge" style="<?= $wish_count > 0 ? '' : 'display:none' ?>"><?= $wish_count ?></span>
                </a>

                <button class="btn-primary" id="loginBtn">Login / Signup</button>

                <button class="icon-btn mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menu">
                    <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                    <svg class="close-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-header">
            <span class="mobile-menu-title">IIMs Courses</span>
            <button class="close-menu-btn" id="closeMobileMenu">✕</button>
        </div>
        <nav class="mobile-nav">
            <a href="<?= $asset_base ?>index.php">Home</a>
            <a href="<?= $asset_base ?>pages/colleges.php">IIMs Colleges</a>
            <a href="<?= $asset_base ?>pages/courses.php">Courses</a>
            <a href="<?= $asset_base ?>pages/about.php">About</a>
            <a href="<?= $asset_base ?>pages/blogs.php">Blogs</a>
            <a href="<?= $asset_base ?>pages/careers.php">Careers</a>
            <a href="<?= $asset_base ?>pages/contact.php">Contact</a>
            <a href="<?= $asset_base ?>pages/compare.php">Compare</a>
            <a href="<?= $asset_base ?>pages/wishlist.php">Wishlist</a>
            <button class="btn-primary mobile-login-btn" id="mobileLoginBtn">Login / Signup</button>
        </nav>
    </div>
    <div class="mobile-overlay" id="mobileOverlay"></div>
</header>

<!-- ✅ Compare Bottom Bar — fixed at bottom, shows selected colleges -->
<div id="compareBar" style="display:none">
    <div class="cmpbar-inner">
        <div class="cmpbar-left">
            <span class="cmpbar-label">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/>
                    <polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/>
                </svg>
                Compare
            </span>
            <div class="cmpbar-slots" id="cmpbarSlots"></div>
        </div>
        <div class="cmpbar-right">
            <button class="cmpbar-clear" id="cmpbarClear" title="Clear all">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
                Clear
            </button>
            <a class="cmpbar-go" id="cmpbarGo" href="<?= $asset_base ?>pages/compare.php">
                Compare Now
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal" id="loginModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Welcome Back</h3>
            <button class="modal-close" id="closeModalBtn" aria-label="Close">&#10005;</button>
        </div>
        <div class="modal-body">
            <p class="modal-subtitle">Sign in to access your wishlist, compare colleges, and track applications.</p>
            <form id="loginForm" onsubmit="event.preventDefault(); alert('Demo login — integrate with your auth system.'); closeModal();">
                <div class="form-group">
                    <label for="loginEmail">Email address</label>
                    <input type="email" id="loginEmail" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" id="loginPassword" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-primary full-width">Sign In</button>
            </form>
            <div class="modal-footer-text">
                Don't have an account? <a href="#" onclick="alert('Signup demo'); return false;">Create account</a>
            </div>
        </div>
    </div>
</div>

<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { background: #ffffff; color: #0f172a; font-family: var(--font-display); transition: background 0.2s, color 0.2s; }
html,body { overflow-x: hidden; }
body.dark { background: var(--background); color: var(--foreground); }

.navbar-main { position: fixed; top: 0; left: 0; right: 0; z-index: 50; transition: background 0.3s, box-shadow 0.3s, backdrop-filter 0.3s; }
.navbar-main.scrolled { background: var(--background, #ffffff); backdrop-filter: blur(8px); box-shadow: var(--shadow-soft); border-bottom: 1px solid var(--border, #e2e8f0); }
.navbar-main.transparent { background: transparent; backdrop-filter: none; border-bottom: none; }
.navbar-main.transparent .nav-link,
.navbar-main.transparent .icon-btn svg,
.navbar-main.transparent .logo-title,
.navbar-main.transparent .logo-sub { color: #ffffff; }
.navbar-main.transparent .icon-btn { border-color: rgba(255,255,255,0.3); }
.navbar-main.transparent .icon-btn:hover { background: rgba(255,255,255,0.1); }
.navbar-container { max-width: 1300px; margin: 0 auto; }
.navbar-inner { display: flex; height: 72px; padding: 20px; align-items: center; justify-content: space-between; gap: 1rem; }

.navbar-logo { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; }
.navbar-logo-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--gradient-accent); display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-glow); }
.navbar-logo-icon svg { width: 18px; height: 18px; color: white; stroke: white; }
.navbar-logo-text { display: flex; flex-direction: column; line-height: 1.2; }
.logo-title { font-weight: 800; font-size: 1.1rem; }
.logo-sub { font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.1em; }
.navbar-main.transparent .logo-title,
.navbar-main.transparent .logo-sub { color: white; }
.navbar-main.transparent .logo-sub { opacity: 0.7; }

.desktop-nav { display: none; align-items: center; gap: 0.25rem; margin-left: auto; margin-right: auto; }
@media (min-width: 1024px) { .desktop-nav { display: flex; } }
.nav-link { padding: 0.5rem 0.85rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 500; background: none; border: none; cursor: pointer; transition: background 0.2s, color 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem; }
.nav-link:hover { background: var(--secondary, #f1f5f9); }
.nav-link.active { color: var(--accent); font-weight: 600; }
.navbar-main.transparent .nav-link { color: rgba(255,255,255,0.9); }
.navbar-main.transparent .nav-link:hover { background-color: transparent; color: white; }
.chevron-icon { width: 14px; height: 14px; margin-left: 2px; }

.dropdown-root { position: relative; }
.mega-dropdown { position: absolute; top: 50px; left: 0; min-width: 680px; max-width: 90vw; background: var(--card, #ffffff); border: 1px solid var(--border, #e2e8f0); border-radius: 1rem; box-shadow: var(--shadow-elegant); padding: 1.25rem; opacity: 0; pointer-events: none; transform: translateY(8px); transition: opacity 0.2s, transform 0.2s; z-index: 100; overflow: hidden; }
.dropdown-root.open .mega-dropdown { opacity: 1; pointer-events: auto; transform: translateY(0); }
.mega-dropdown-inner { display: flex; gap: 1.5rem; }
.mega-sidebar { width: 180px; flex-shrink: 0; border-right: 1px solid var(--border, #e2e8f0); padding-right: 1rem; }
.sidebar-label { font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; color: var(--muted-foreground, #64748b); margin-bottom: 0.75rem; }
.category-list { display: flex; flex-direction: column; gap: 0.20rem; }
.cat-btn { text-align: left; padding: 0.5rem 0.10rem; border-radius: 0.5rem; font-size: 0.80rem; font-weight: 500; background: none; border: none; cursor: pointer; color: var(--foreground, #0f172a); transition: background 0.15s; }
.cat-btn:hover { background: var(--secondary, #f1f5f9); }
.cat-btn.active { background: var(--secondary, #f1f5f9); color: var(--accent); }
.content-header { display: flex; justify-content: space-between; gap: 10rem; margin-bottom: 0.6rem; }
.content-header h4 { font-size: 1rem; font-weight: 600; }
.content-header .count { font-size: 0.7rem; color: var(--muted-foreground, #64748b); }
.content-header .view-link { font-size: 0.7rem; color: var(--accent); text-decoration: none; font-weight: 500; white-space: nowrap; margin-left: 0.5rem; }
.mega-content { flex: 1; width: 100%; min-width: 0; }
.content-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; width: 100%; }
.college-card, .course-card { width: 100%; min-width: 200px; padding: 10px; }
.college-card:hover, .course-card:hover { border-color: var(--accent); box-shadow: var(--shadow-soft); }
.college-info .name { font-weight: 600; font-size: 0.80rem; }
.college-info .location { font-size: 0.6rem; color: var(--muted-foreground, #64748b); display: flex; align-items: center; gap: 0.2rem; }
.rating { font-size: 0.7rem; margin-top: 0.25rem; }
.course-card { flex-direction: column; }
.course-title { font-weight: 600; font-size: 0.85rem; }
.course-tags { display: flex; flex-wrap: wrap; gap: 0.3rem; }
.tag { font-size: 0.6rem; padding: 0.2rem 0.5rem; border-radius: 999px; background: var(--secondary, #f1f5f9); }
.dropdown-footer-link { display: block; margin-top: 1rem; padding-top: 0.8rem; border-top: 1px solid var(--border, #e2e8f0); text-align: center; font-size: 0.8rem; color: var(--accent); font-weight: 500; text-decoration: none; }

.navbar-actions { display: flex; align-items: center; gap: 0.4rem; }
.icon-btn { position: relative; width: 35px; height: 35px; border-radius: 50%; background: none; border: 1px solid var(--border, #e2e8f0); cursor: pointer; display: inline-flex; align-items: center; justify-content: center; color: var(--foreground, #0f172a); transition: background 0.2s; text-decoration: none; }
.icon-btn:hover { background: var(--secondary, #f1f5f9); }
.icon-btn svg { width: 18px; height: 18px; stroke: currentColor; }
.badge { position: absolute; top: -4px; right: -4px; background: var(--accent); color: white; font-size: 0.55rem; font-weight: 700; border-radius: 50%; width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; }
.btn-primary { background: var(--gradient-accent); color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 2rem; font-weight: 500; font-size: 0.7rem; cursor: pointer; transition: transform 0.1s, opacity 0.2s; white-space: nowrap; }
.btn-primary:hover { opacity: 0.9; transform: scale(0.98); }
.full-width { width: 100%; padding: 0.7rem; margin-top: 0.5rem; }

.mobile-menu-toggle { display: flex; }
@media (min-width: 1024px) { .mobile-menu-toggle { display: none; } }
.mobile-menu { position: fixed; top: 0; right: 0; bottom: 0; width: 85%; max-width: 320px; background: #ffffff !important; z-index: 60; transform: translateX(100%); transition: transform 0.25s ease; box-shadow: -4px 0 20px rgba(0,0,0,0.25); display: flex; flex-direction: column; }
body.dark .mobile-menu { background: #0f172a !important; }
.mobile-nav a, .mobile-menu-title, .close-menu-btn { color: #0f172a; }
body.dark .mobile-nav a, body.dark .mobile-menu-title, body.dark .close-menu-btn { color: #ffffff; }
.mobile-menu.open { transform: translateX(0); }
.mobile-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 55; opacity: 0; pointer-events: none; transition: opacity 0.25s; }
.mobile-overlay.open { opacity: 1; pointer-events: auto; }
.mobile-menu-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem; border-bottom: 1px solid var(--border, #e2e8f0); }
.mobile-menu-title { font-weight: 800; font-size: 1.2rem; }
.close-menu-btn { background: none; border: none; font-size: 1.5rem; cursor: pointer; }
.mobile-nav { padding: 1rem; display: flex; flex-direction: column; gap: 0.5rem; flex: 1; }
.mobile-nav a { padding: 0.75rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; }
.mobile-nav a:hover { background: var(--secondary, #f1f5f9); }
.mobile-login-btn { margin-top: 1rem; width: 100%; }

.modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 200; align-items: center; justify-content: center; }
.modal.open { display: flex; }
.modal-content { background: var(--card, #ffffff); border-radius: 1rem; width: 90%; max-width: 420px; box-shadow: var(--shadow-elegant); }
.modal-header { display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border, #e2e8f0); }
.modal-header h3 { font-size: 1.25rem; font-weight: 600; margin: 0; }
.modal-close { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; border: 1px solid var(--border, #e2e8f0); background: transparent; font-size: 0.9rem; cursor: pointer; transition: background 0.2s; }
.modal-close:hover { background: var(--secondary, #f1f5f9); }
.modal-body { padding: 1.5rem; }
.modal-subtitle { font-size: 0.85rem; color: var(--muted-foreground, #64748b); margin-bottom: 1rem; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.8rem; font-weight: 500; margin-bottom: 0.3rem; }
.form-group input { width: 100%; padding: 0.6rem; border-radius: 0.5rem; border: 1px solid var(--border, #e2e8f0); background: var(--background, #ffffff); color: var(--foreground, #0f172a); }
.modal-footer-text { text-align: center; font-size: 0.8rem; margin-top: 1rem; }

/* ════════════════════════════════════════════════════
   COMPARE BOTTOM BAR
   ════════════════════════════════════════════════════ */
#compareBar {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    z-index: 49;
    background: #0d1117;
    border-top: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 -4px 24px rgba(0,0,0,0.3);
    transform: translateY(100%);
    transition: transform 0.35s cubic-bezier(.4,0,.2,1);
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
    color: rgba(255,255,255,0.5);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    white-space: nowrap;
    flex-shrink: 0;
}
.cmpbar-label svg {
    width: 14px; height: 14px;
    stroke: rgba(255,255,255,0.5);
}
.cmpbar-slots {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: nowrap;
    overflow: hidden;
}
/* Each slot card */
.cmpbar-slot {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 8px;
    padding: 5px 8px 5px 6px;
    min-width: 0;
    animation: slotIn 0.25s ease;
}
@keyframes slotIn {
    from { opacity: 0; transform: translateY(6px) scale(0.95); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.cmpbar-slot-img {
    width: 28px; height: 28px;
    border-radius: 5px;
    object-fit: cover;
    flex-shrink: 0;
    background: rgba(255,255,255,0.1);
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
    color: rgba(255,255,255,0.45);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 120px;
}
.cmpbar-slot-remove {
    width: 18px; height: 18px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: none;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.5);
    flex-shrink: 0;
    transition: background 0.15s, color 0.15s;
    padding: 0;
}
.cmpbar-slot-remove:hover { background: rgba(233,69,96,0.3); color: #e94560; }
.cmpbar-slot-remove svg { width: 9px; height: 9px; stroke: currentColor; stroke-width: 2.5; }

/* Empty slot placeholders */
.cmpbar-slot-empty {
    width: 120px; height: 40px;
    border: 1.5px dashed rgba(255,255,255,0.15);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.65rem;
    color: rgba(255,255,255,0.25);
    flex-shrink: 0;
}

/* Right buttons */
.cmpbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
.cmpbar-clear {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.75rem; font-weight: 600;
    color: rgba(255,255,255,0.45);
    background: none; border: 1px solid rgba(255,255,255,0.12);
    border-radius: 6px; padding: 0.4rem 0.75rem;
    cursor: pointer;
    transition: color 0.15s, border-color 0.15s, background 0.15s;
}
.cmpbar-clear svg { width: 12px; height: 12px; }
.cmpbar-clear:hover { color: #e94560; border-color: rgba(233,69,96,0.4); background: rgba(233,69,96,0.08); }
.cmpbar-go {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.8rem; font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-radius: 8px; padding: 0.5rem 1.1rem;
    text-decoration: none;
    transition: opacity 0.2s, transform 0.2s;
    box-shadow: 0 3px 12px rgba(59,130,246,0.4);
}
.cmpbar-go svg { width: 13px; height: 13px; }
.cmpbar-go:hover { opacity: 0.88; transform: translateY(-1px); }

@media (max-width: 640px) {
    .cmpbar-label { display: none; }
    .cmpbar-slot-name { max-width: 80px; }
    .cmpbar-slot-loc  { display: none; }
    .cmpbar-slot-empty { width: 80px; }
    .cmpbar-go { font-size: 0.72rem; padding: 0.45rem 0.85rem; }
}

@media (max-width: 570px) { .navbar-actions a { display: none; } }
@media (max-width: 570px) { #themeToggle { display: none; } }
@media (max-width: 400px) { #loginBtn { display: none; } }
</style>

<script>
const collegesData         = <?= $colleges_json ?>;
const coursesData          = <?= $courses_json ?>;
const categoriesList       = <?= $categories_json ?>;
const courseCategoriesList = <?= $course_cats_json ?>;
const assetBase            = "<?= $asset_base ?>";

let activeCollegeCat = categoriesList[0];
let activeCourseCat  = courseCategoriesList[0] || "MBA";

// ================================================================
// ✅ WISHLIST — Global badge + AJAX
// ================================================================
window.updateWishBadge = function (count) {
    var badge = document.getElementById('wishBadge');
    if (!badge) return;
    badge.textContent = count;
    badge.style.display = count > 0 ? 'flex' : 'none';
};

window.applyWishToggleUI = function (btn, action) {
    var svg = btn.querySelector('svg');
    btn.classList.remove('pop');
    if (action === 'add') {
        btn.classList.add('active');
        btn.setAttribute('aria-pressed', 'true');
        if (svg) { svg.setAttribute('fill', '#e94560'); svg.setAttribute('stroke', '#e94560'); }
        btn.title = 'Remove from wishlist';
    } else {
        btn.classList.remove('active');
        btn.setAttribute('aria-pressed', 'false');
        if (svg) { svg.setAttribute('fill', 'none'); svg.setAttribute('stroke', 'currentColor'); }
        btn.title = 'Add to wishlist';
    }
    requestAnimationFrame(function () {
        btn.classList.add('pop');
        btn.addEventListener('animationend', function h() {
            btn.classList.remove('pop');
            btn.removeEventListener('animationend', h);
        });
    });
};

window.toggleWishlist = function (slug, btn) {
    var isActive = btn.classList.contains('active');
    var action   = isActive ? 'remove' : 'add';
    var url      = window.location.pathname + '?wl_action=' + action + '&wl_slug=' + encodeURIComponent(slug);
    window.applyWishToggleUI(btn, action);
    fetch(url, { headers: { 'Accept': 'application/json' } })
        .then(function (r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
        .then(function (data) {
            window.updateWishBadge(data.count);
            if (action === 'remove' && window.location.pathname.indexOf('wishlist') !== -1
                && typeof window.removeCardBySlug === 'function') {
                window.removeCardBySlug(slug);
            }
        })
        .catch(function (err) {
            console.error('Wishlist error:', err);
            window.applyWishToggleUI(btn, action === 'add' ? 'remove' : 'add');
        });
};

// ================================================================
// ✅ COMPARE — Global bar + AJAX
// ================================================================

// In-memory store — mirrors session, populated on load from active buttons
var _cmpStore = [];  // array of { slug, name, image, location }

window.updateCmpBadge = function (count) {
    var badge = document.getElementById('cmpBadge');
    if (!badge) return;
    badge.textContent = count;
    badge.style.display = count > 0 ? 'flex' : 'none';
};

window.renderCompareBar = function () {
    var bar   = document.getElementById('compareBar');
    var slots = document.getElementById('cmpbarSlots');
    if (!bar || !slots) return;

    if (_cmpStore.length === 0) {
        bar.style.display = 'none';
        bar.classList.remove('bar-visible');
        return;
    }

    bar.style.display = 'block';
    requestAnimationFrame(function () { bar.classList.add('bar-visible'); });

    var html = '';
    _cmpStore.forEach(function (item) {
        html += '<div class="cmpbar-slot" data-slug="' + escapeHtml(item.slug) + '">'
            + '<img class="cmpbar-slot-img" src="' + escapeHtml(item.image) + '" alt="" loading="lazy">'
            + '<div class="cmpbar-slot-info">'
            +   '<div class="cmpbar-slot-name">' + escapeHtml(item.name) + '</div>'
            +   '<div class="cmpbar-slot-loc">'  + escapeHtml(item.location) + '</div>'
            + '</div>'
            + '<button class="cmpbar-slot-remove" data-slug="' + escapeHtml(item.slug) + '" title="Remove">'
            +   '<svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
            + '</button>'
            + '</div>';
    });

    // Empty placeholder slots (up to 3)
    for (var i = _cmpStore.length; i < 3; i++) {
        html += '<div class="cmpbar-slot-empty">+ Add IIM</div>';
    }

    slots.innerHTML = html;
};

window.applyCompareToggleUI = function (btn, action) {
    var svg = btn.querySelector('svg');
    btn.classList.remove('pop');
    if (action === 'add') {
        btn.classList.add('active');
        btn.setAttribute('aria-pressed', 'true');
        if (svg) svg.setAttribute('stroke', '#3b82f6');
        btn.title = 'Remove from compare';
    } else {
        btn.classList.remove('active');
        btn.setAttribute('aria-pressed', 'false');
        if (svg) svg.setAttribute('stroke', 'currentColor');
        btn.title = 'Add to compare';
    }
    requestAnimationFrame(function () {
        btn.classList.add('pop');
        btn.addEventListener('animationend', function h() {
            btn.classList.remove('pop');
            btn.removeEventListener('animationend', h);
        });
    });
};

window.toggleCompare = function (slug, btn) {
    var isActive = btn.classList.contains('active');
    var action   = isActive ? 'remove' : 'add';

    // Max 3 check
    if (action === 'add' && _cmpStore.length >= 3) {
        // Shake the bar to signal limit
        var bar = document.getElementById('compareBar');
        if (bar) {
            bar.style.animation = 'none';
            bar.offsetHeight; // reflow
            bar.style.animation = 'cmpShake 0.4s ease';
        }
        return;
    }

    var url = window.location.pathname + '?cmp_action=' + action + '&cmp_slug=' + encodeURIComponent(slug);

    // Optimistic UI
    window.applyCompareToggleUI(btn, action);

    if (action === 'add') {
        _cmpStore.push({
            slug:     slug,
            name:     btn.dataset.name     || slug,
            image:    btn.dataset.image    || '',
            location: btn.dataset.location || ''
        });
    } else {
        _cmpStore = _cmpStore.filter(function (i) { return i.slug !== slug; });
    }

    window.updateCmpBadge(_cmpStore.length);
    window.renderCompareBar();

    fetch(url, { headers: { 'Accept': 'application/json' } })
        .then(function (r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
        .then(function (data) {
            window.updateCmpBadge(data.count);
        })
        .catch(function (err) {
            console.error('Compare error:', err);
            // Roll back
            window.applyCompareToggleUI(btn, action === 'add' ? 'remove' : 'add');
            if (action === 'add') {
                _cmpStore = _cmpStore.filter(function (i) { return i.slug !== slug; });
            } else {
                // Can't perfectly restore without original data — just badge sync
            }
            window.updateCmpBadge(_cmpStore.length);
            window.renderCompareBar();
        });
};

// ── Bootstrap _cmpStore from currently-active .cmp-toggle buttons ──
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cmp-toggle.active').forEach(function (btn) {
        var slug = btn.dataset.slug;
        if (slug && !_cmpStore.find(function (i) { return i.slug === slug; })) {
            _cmpStore.push({
                slug:     slug,
                name:     btn.dataset.name     || slug,
                image:    btn.dataset.image    || '',
                location: btn.dataset.location || ''
            });
        }
    });
    window.updateCmpBadge(_cmpStore.length);
    window.renderCompareBar();
});

// ── Clear button ──
document.addEventListener('click', function (e) {
    if (e.target.closest('#cmpbarClear')) {
        // Remove all active states
        document.querySelectorAll('.cmp-toggle.active').forEach(function (btn) {
            window.applyCompareToggleUI(btn, 'remove');
        });
        _cmpStore = [];
        window.updateCmpBadge(0);
        var bar = document.getElementById('compareBar');
        if (bar) {
            bar.classList.remove('bar-visible');
            setTimeout(function () { bar.style.display = 'none'; }, 350);
        }
        // Sync session
        fetch(window.location.pathname + '?cmp_action=clear_all', { headers: { 'Accept': 'application/json' } }).catch(function(){});
        // Use GET clear on compare.php if needed — or add a clear_all handler to Navbar AJAX
        fetch(assetBase + 'pages/compare.php?clear=1').catch(function(){});
    }
});

// ── Remove single slot from bar ──
document.addEventListener('click', function (e) {
    var removeBtn = e.target.closest('.cmpbar-slot-remove');
    if (!removeBtn) return;
    var slug = removeBtn.dataset.slug;
    if (!slug) return;
    // Find and untoggle the card button
    var cardBtn = document.querySelector('.cmp-toggle[data-slug="' + slug + '"]');
    if (cardBtn) window.toggleCompare(slug, cardBtn);
    else {
        // Button not on page — just update store & session directly
        _cmpStore = _cmpStore.filter(function (i) { return i.slug !== slug; });
        window.updateCmpBadge(_cmpStore.length);
        window.renderCompareBar();
        fetch(window.location.pathname + '?cmp_action=remove&cmp_slug=' + encodeURIComponent(slug), { headers: { 'Accept': 'application/json' } }).catch(function(){});
    }
});

// ── Global event delegation — .wl-toggle and .cmp-toggle clicks ──
document.addEventListener('click', function (e) {
    // Wishlist
    var wlBtn = e.target.closest('.wl-toggle');
    if (wlBtn) {
        e.preventDefault();
        e.stopPropagation();
        var slug = wlBtn.dataset.slug;
        if (slug) window.toggleWishlist(slug, wlBtn);
        return;
    }
    // Compare
    var cmpBtn = e.target.closest('.cmp-toggle');
    if (cmpBtn) {
        e.preventDefault();
        e.stopPropagation();
        var slug = cmpBtn.dataset.slug;
        if (slug) window.toggleCompare(slug, cmpBtn);
    }
}, true);

// ── Shake keyframe ──
var _shakeStyle = document.createElement('style');
_shakeStyle.textContent = '@keyframes cmpShake { 0%,100%{transform:translateX(0)} 20%{transform:translateX(-6px)} 40%{transform:translateX(6px)} 60%{transform:translateX(-4px)} 80%{transform:translateX(4px)} }';
document.head.appendChild(_shakeStyle);

// ================================================================

function renderColleges(category) {
    var filtered = collegesData.filter(function(c){ return c.category && c.category.includes(category); }).slice(0, 8);
    document.getElementById('collegesContentHeader').innerHTML = '<div class="content-header"><div><h4>' + category + ' • IIMs</h4><div class="count">' + filtered.length + ' institutes</div></div><a href="' + assetBase + 'pages/colleges.php" class="view-link">View all →</a></div>';
    var g = '';
    filtered.forEach(function(c){
        g += '<a href="' + assetBase + 'pages/college-details.php?slug=' + c.slug + '" class="college-card"><div class="college-info"><div class="name">' + escapeHtml(c.name) + '</div><div class="location">' + escapeHtml(c.location) + '</div><div class="rating">⭐ ' + c.rating + ' • ₹' + c.fees + 'L</div></div></a>';
    });
    document.getElementById('collegesGrid').innerHTML = '<div class="content-grid">' + g + '</div>';
}

function renderCourses(category) {
    var filtered = coursesData.filter(function(c){ return c.category === category; }).slice(0, 8);
    document.getElementById('coursesContentHeader').innerHTML = '<div class="content-header"><div><h4>' + category + '</h4><div class="count">' + filtered.length + ' programmes</div></div><a href="' + assetBase + 'pages/courses.php" class="view-link">View all →</a></div>';
    var g = '';
    if (!filtered.length) {
        g = '<div style="grid-column:span 2;text-align:center;padding:2rem">No programmes found</div>';
    } else {
        filtered.forEach(function(c){
            var tags = (c.iims || []).slice(0,3).map(function(slug){
                var col = collegesData.find(function(cl){ return cl.slug === slug; });
                return '<span class="tag">' + escapeHtml(col ? (col.short || col.name) : slug) + '</span>';
            }).join('');
            g += '<a href="' + assetBase + 'pages/course-details.php?slug=' + c.slug + '" class="course-card"><div class="course-title">' + escapeHtml(c.title) + '</div><div class="course-tags">' + tags + '</div></a>';
        });
    }
    document.getElementById('coursesGrid').innerHTML = '<div class="content-grid">' + g + '</div>';
}

function buildCategoryButtons(containerId, list, activeCat, onSelect) {
    var container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';
    list.forEach(function(cat){
        var btn = document.createElement('button');
        btn.className = 'cat-btn' + (activeCat === cat ? ' active' : '');
        btn.textContent = cat;
        btn.onmouseenter = function(){
            document.querySelectorAll('#' + containerId + ' .cat-btn').forEach(function(b){ b.classList.remove('active'); });
            btn.classList.add('active');
            onSelect(cat);
        };
        container.appendChild(btn);
    });
}

function escapeHtml(str) {
    return String(str).replace(/[&<>'"]/g, function(m){
        return {'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#39;','"':'&quot;'}[m];
    });
}

var closeTimeout = null;
function setupDropdown(rootId, dropdownId) {
    var root = document.getElementById(rootId);
    if (!root) return;
    var trigger = root.querySelector('.dropdown-trigger');
    var panel   = document.getElementById(dropdownId);
    var open    = function(){ if(closeTimeout) clearTimeout(closeTimeout); document.querySelectorAll('.dropdown-root.open').forEach(function(d){d.classList.remove('open');}); root.classList.add('open'); };
    var close   = function(){ closeTimeout = setTimeout(function(){ root.classList.remove('open'); }, 100); };
    trigger.addEventListener('mouseenter', open);
    panel.addEventListener('mouseenter',   function(){ if(closeTimeout) clearTimeout(closeTimeout); });
    trigger.addEventListener('mouseleave', close);
    panel.addEventListener('mouseleave',   close);
}

function initTheme() {
    if (localStorage.getItem('theme') === 'dark') { document.body.classList.add('dark'); }
    else { document.body.classList.remove('dark'); localStorage.setItem('theme', 'light'); }
}

function initScrollEffect() {
    var navbar = document.getElementById('navbarMain');
    var isHome = navbar && navbar.dataset.home === 'true';
    if (!isHome) { navbar.classList.add('scrolled'); return; }
    var handle = function(){ window.scrollY > 30 ? (navbar.classList.add('scrolled'), navbar.classList.remove('transparent')) : (navbar.classList.remove('scrolled'), navbar.classList.add('transparent')); };
    window.addEventListener('scroll', handle);
    handle();
}

function initMobileMenu() {
    var menu    = document.getElementById('mobileMenu');
    var overlay = document.getElementById('mobileOverlay');
    var openM   = function(){ menu.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow='hidden'; };
    var closeM  = function(){ menu.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow=''; };
    document.getElementById('mobileMenuToggle')?.addEventListener('click', openM);
    document.getElementById('closeMobileMenu')?.addEventListener('click', closeM);
    overlay?.addEventListener('click', closeM);
}

function initModal() {
    var modal  = document.getElementById('loginModal');
    var openFn = function(){ modal.classList.add('open'); document.body.style.overflow='hidden'; };
    window.closeModal = function(){ modal.classList.remove('open'); document.body.style.overflow=''; };
    document.getElementById('loginBtn')?.addEventListener('click', openFn);
    document.getElementById('mobileLoginBtn')?.addEventListener('click', openFn);
    document.getElementById('closeModalBtn')?.addEventListener('click', closeModal);
    modal?.addEventListener('click', function(e){ if(e.target===modal) closeModal(); });
}

function initMegas() {
    buildCategoryButtons('collegeCategoriesList', categoriesList, activeCollegeCat, function(cat){ activeCollegeCat=cat; renderColleges(cat); });
    renderColleges(activeCollegeCat);
    if (courseCategoriesList.length) {
        buildCategoryButtons('courseCategoriesList', courseCategoriesList, activeCourseCat, function(cat){ activeCourseCat=cat; renderCourses(cat); });
        renderCourses(activeCourseCat);
    }
    setupDropdown('dropdownCollegesRoot', 'megaColleges');
    setupDropdown('dropdownCoursesRoot',  'megaCourses');
}

document.addEventListener('DOMContentLoaded', function(){
    initTheme();
    initScrollEffect();
    initMobileMenu();
    initModal();
    initMegas();
});
</script>