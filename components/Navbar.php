<?php
$compareCount = count($_SESSION['compare'] ?? []);
?>
<?php
/**
 * Navbar.php - Modern navbar component matching the TypeScript version
 * 
 * Features:
 * - Fixed navbar with transparent/scrolled states
 * - Mega dropdowns for IIMs Colleges & Courses (hover-based)
 * - Dynamic filtering by category using client-side JS
 * - Dark/light theme toggle with localStorage persistence
 * - Wishlist & compare counts from session
 * - Mobile slide-out menu
 * - Login/Signup modal
 * 
 * Dependencies: $COLLEGES, $COURSES from data/iims.php, session started
 */

if (!isset($COLLEGES) || !isset($COURSES)) {
    require_once __DIR__ . '/../data/iims.php';
}

// Determine current page for active link styling
$current_page = $current_page ?? '';
$is_home = ($current_page === 'home' || $_SERVER['REQUEST_URI'] === '/' || 
            $_SERVER['REQUEST_URI'] === '/index.php' || basename($_SERVER['SCRIPT_NAME']) === 'index.php');

// Session counts
$wish_count = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;
$comp_count = isset($_SESSION['compare']) ? count($_SESSION['compare']) : 0;

// Asset base path
$__script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/');
$__parts = explode('/', trim($__script, '/'));
$asset_base = '/' . ($__parts[0] ?? '') . '/';

// Categories for colleges (as per TS version)
$categories = [
    'Management', 'Finance', 'Marketing', 'HR', 
    'Operations', 'Business Analytics', 'International Business'
];

// Course categories from data
$course_cats = array_unique(array_column($COURSES, 'category'));

// Prepare JSON data for client-side filtering
$colleges_json = json_encode($COLLEGES);
$courses_json = json_encode($COURSES);
$course_cats_json = json_encode(array_values($course_cats));
$categories_json = json_encode($categories);
?>
<!-----------------------------------------------------------------------------
    NAVBAR MARKUP
----------------------------------------------------------------------------->
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
                    <span class="logo-title ">IIMs Courses</span>
                    <span class="logo-sub">India's MBA Discovery</span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <nav class="desktop-nav">
                <!-- Colleges Mega Dropdown -->
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

                <!-- Courses Mega Dropdown -->
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

                <!-- Regular Nav Links -->
                <?php
                $nav_links = [
                    ['url' => $asset_base . 'pages/about.php', 'label' => 'About', 'page' => 'about'],
                    ['url' => $asset_base . 'pages/blogs.php', 'label' => 'Blogs', 'page' => 'blogs'],
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
                <!-- Theme Toggle -->
                
                <!-- Compare -->
                <a href="<?= $asset_base ?>pages/compare.php" class="icon-btn" aria-label="Compare">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/>
                        <polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/>
                    </svg>
                    <?php if ($comp_count > 0): ?>
                        <span class="badge"><?= $comp_count ?></span>
                    <?php endif; ?>
                </a>

                <!-- Wishlist -->
                <a href="<?= $asset_base ?>pages/wishlist.php" class="icon-btn" aria-label="Wishlist">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    <?php if ($wish_count > 0): ?>
                        <span class="badge"><?= $wish_count ?></span>
                    <?php endif; ?>
                </a>

                <!-- Login/Signup Button -->
                <button class="btn-primary" id="loginBtn">Login / Signup</button>

                <!-- Mobile Menu Toggle -->
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

    <!-- Mobile Slide-out Menu -->
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
/* ---------- CSS Variables (Light/Dark) ---------- */

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    background: #ffffff;
    color: #0f172a;
    font-family: var(--font-display);
    transition: background 0.2s, color 0.2s;
}
html,body{
    overflow-x:hidden;
}
body.dark {
    background: var(--background);
    color: var(--foreground);
}

/* ---------- Navbar Core ---------- */
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
    backdrop-filter: blur(8px);
    box-shadow: var(--shadow-soft);

    border-bottom: 1px solid var(--border, #e2e8f0);
}
.navbar-main.transparent { background: transparent; backdrop-filter: none; border-bottom: none; }
.navbar-main.transparent .nav-link,
.navbar-main.transparent .icon-btn svg,
.navbar-main.transparent .logo-title,
.navbar-main.transparent .logo-sub { color: #ffffff; }
.navbar-main.transparent .icon-btn { border-color: rgba(255,255,255,0.3); }
.navbar-main.transparent .icon-btn:hover { background: rgba(255,255,255,0.1); }
.navbar-container { max-width: 1300px; margin: 0 auto; }
.navbar-inner {
    display: flex;
    height: 72px;
    padding:20px;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

/* Logo */
.navbar-logo { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; }
.navbar-logo-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: var(--gradient-accent);
    display: flex; align-items: center; justify-content: center;
    box-shadow: var(--shadow-glow);
}
.navbar-logo-icon svg { width: 18px; height: 18px; color: white; stroke: white; }
.navbar-logo-text { display: flex; flex-direction: column; line-height: 1.2; }
.logo-title { font-weight: 800; font-size: 1.1rem;}
.logo-sub { font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.1em; }
.navbar-main.transparent .logo-title,
.navbar-main.transparent .logo-sub { color: white; }
.navbar-main.transparent .logo-sub { opacity: 0.7; }

/* Desktop Nav */
.desktop-nav { display: none; align-items: center; gap: 0.25rem; margin-left: auto; margin-right: auto; }
@media (min-width: 1024px) { .desktop-nav { display: flex; } }
.nav-link {
    padding: 0.5rem 0.85rem;
    border-radius: 0.5rem;
    font-size: 0.8rem;
    font-weight: 500;
    background: none;
    border: none;
    color: white
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}
.nav-link:hover { background: var(--secondary, #f1f5f9); }
.nav-link.active { color: var(--accent); font-weight: 600; }
.navbar-main.transparent .nav-link { color: rgba(255,255,255,0.9); }
.navbar-main.transparent .nav-link:hover { background-color:transparent; color: white; }
.chevron-icon { width: 14px; height: 14px; margin-left: 2px; }

/* Mega Dropdown */
.dropdown-root { position: relative; }
.mega-dropdown {
    position: absolute;
    top: 50px;
    left: 0;
    min-width: 680px;
    max-width: 90vw;
    background: var(--card, #ffffff);
    border: 1px solid var(--border, #e2e8f0);
    border-radius: 1rem;
    box-shadow: var(--shadow-elegant);
    padding: 1.25rem;
    opacity: 0;
    pointer-events: none;
    transform: translateY(8px);
    transition: opacity 0.2s, transform 0.2s;
    z-index: 100;
    overflow: hidden;
}
.dropdown-root.open .mega-dropdown {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
}
.mega-dropdown-inner { display: flex; gap: 1.5rem; }
.mega-sidebar { width: 180px; flex-shrink: 0; border-right: 1px solid var(--border, #e2e8f0); padding-right: 1rem; }
.sidebar-label {
    font-size: 0.6rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
    color: var(--muted-foreground, #64748b);
    margin-bottom: 0.75rem;
}
.category-list { display: flex; flex-direction: column; gap: 0.20rem; }
.cat-btn {
    text-align: left;
    padding: 0.5rem 0.10rem;
    border-radius: 0.5rem;
    font-size: 0.80rem;
    font-weight: 500;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--foreground, #0f172a);
    transition: background 0.15s;
}
.cat-btn:hover { background: var(--secondary, #f1f5f9); }
.cat-btn.active {
    background: var(--secondary, #f1f5f9);
    color: var(--accent);
}
.content-header {
    display: flex;
    justify-content: space-between;
    gap: 10rem;
    margin-bottom: 0.6rem;
}
.content-header h4 { font-size: 1rem; font-weight: 600; }
.content-header .count { font-size: 0.7rem; color: var(--muted-foreground, #64748b); }
.content-header .view-link {
    font-size: 0.7rem;
    color: var(--accent);
    text-decoration: none;
    font-weight: 500;
    white-space: nowrap;
    margin-left: 0.5rem;
}
.mega-content {
    flex: 1;
    width: 100%;
    min-width: 0;
}
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
.college-card:hover, .course-card:hover {
    border-color: var(--accent);
    box-shadow: var(--shadow-soft);
}
.college-info .name { font-weight: 600; font-size: 0.80rem; }
.college-info .location { font-size: 0.6rem; color: var(--muted-foreground, #64748b); display: flex; align-items: center; gap: 0.2rem; }
.rating { font-size: 0.7rem; margin-top: 0.25rem; }
.course-card { flex-direction: column; }
.course-title { font-weight: 600; font-size: 0.85rem; }
.course-tags { display: flex; flex-wrap: wrap; gap: 0.3rem; }
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

/* Actions */
.navbar-actions { display: flex; align-items: center; gap: 0.4rem; }
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
.icon-btn:hover { background: var(--secondary, #f1f5f9); }
.icon-btn svg { width: 18px; height: 18px; stroke: currentColor; }
.badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: var(--accent);
    color: white;
    font-size: 0.55rem;
    font-weight: 700;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-primary {
    background: var(--gradient-accent);
    color: white;
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 2rem;
    font-weight: 500;
    font-size: 0.7rem;
    cursor: pointer;
    transition: transform 0.1s, opacity 0.2s;
    white-space: nowrap;
}
.btn-primary:hover { opacity: 0.9; transform: scale(0.98); }
.full-width { width: 100%; padding: 0.7rem; margin-top: 0.5rem; }

/* Theme icons */
.sun-icon { display: block; }
.moon-icon { display: none; }
body.dark .sun-icon { display: none; }
body.dark .moon-icon { display: block; }

/* Mobile menu */
.mobile-menu-toggle { display: flex; }
@media (min-width: 1024px) { .mobile-menu-toggle { display: none; } }
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
    box-shadow: -4px 0 20px rgba(0,0,0,0.25);

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
.mobile-menu.open { transform: translateX(0); }
.mobile-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 55; opacity: 0;
    pointer-events: none;
    transition: opacity 0.25s;
}
.mobile-overlay.open { opacity: 1; pointer-events: auto; }
.mobile-menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid var(--border, #e2e8f0);
}
.mobile-menu-title { font-weight: 800; font-size: 1.2rem; }
.close-menu-btn { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--foreground, #0f172a); }
.mobile-nav { padding: 1rem; display: flex; flex-direction: column; gap: 0.5rem; flex: 1; }
.mobile-nav a {
    padding: 0.75rem;
    border-radius: 0.5rem;
    text-decoration: none;
    color: var(--foreground, #0f172a);
    font-weight: 500;
}
.mobile-nav a:hover { background: var(--secondary, #f1f5f9); }
.mobile-login-btn { margin-top: 1rem; width: 100%; }

/* ===== MODAL ===== */
.modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.7);
    z-index: 200;
    align-items: center;
    justify-content: center;
}
.modal.open { display: flex; }
.modal-content {
    background: var(--card, #ffffff);
    border-radius: 1rem;
    width: 90%;
    max-width: 420px;
    box-shadow: var(--shadow-elegant);
    /* overflow hidden removed so nothing clips */
}

/* ===== KEY FIX: modal-header =====
   - display: flex, flex-direction: row
   - align-items: center  <-- yahi cross ko vertically center karta hai
   - justify-content: space-between  <-- h3 left, button right
   - NO min-height / extra padding that was pushing button up
*/
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
    padding: 0;
    line-height: 1.2;
}

/* ===== KEY FIX: modal-close =====
   - display: inline-flex + align-items + justify-content centers the ✕ glyph
   - align-self: center ensures it stays in the flex row middle
   - NO position: absolute, NO top/right offsets
*/
.modal-close {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    align-self: center;          /* <-- stays in row center */
    flex-shrink: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid var(--border, #e2e8f0);
    background: transparent;
    color: var(--foreground, #0f172a);
    font-size: 0.9rem;
    line-height: 1;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
}
.modal-close:hover {
    background: var(--secondary, #f1f5f9);
    border-color: var(--muted-foreground, #94a3b8);
}
body.dark .modal-close {
    border-color: #334155;
    color: #f8fafc;
}
body.dark .modal-close:hover {
    background: #334155;
}

.modal-body { padding: 1.5rem; }
.modal-subtitle { font-size: 0.85rem; color: var(--muted-foreground, #64748b); margin-bottom: 1rem; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.8rem; font-weight: 500; margin-bottom: 0.3rem; }
.form-group input {
    width: 100%;
    padding: 0.6rem;
    border-radius: 0.5rem;
    border: 1px solid var(--border, #e2e8f0);
    background: var(--background, #ffffff);
    color: var(--foreground, #0f172a);
}
.modal-footer-text { text-align: center; font-size: 0.8rem; margin-top: 1rem; }

@media (max-width: 570px) { .navbar-actions a { display: none; } }
@media (max-width: 570px) { #themeToggle { display: none; } }
@media (max-width: 400px) { #loginBtn { display: none; } }
</style>

<script>
// ---------- Data from PHP ----------
const collegesData = <?= $colleges_json ?>;
const coursesData = <?= $courses_json ?>;
const categoriesList = <?= $categories_json ?>;
const courseCategoriesList = <?= $course_cats_json ?>;
const assetBase = "<?= $asset_base ?>";

// ---------- Global State ----------
let activeCollegeCat = categoriesList[0];
let activeCourseCat = courseCategoriesList[0] || "MBA";

// ---------- Helper: Render College Grid ----------
function renderColleges(category) {
    const filtered = collegesData.filter(c => c.category && c.category.includes(category)).slice(0, 8);
    const headerHtml = `
        <div class="content-header">
            <div><h4>${category} • IIMs</h4><div class="count">${filtered.length} institutes offering ${category}</div></div>
            <a href="${assetBase}pages/colleges.php" class="view-link">View all IIMs →</a>
        </div>
    `;
    let gridHtml = '<div class="content-grid">';
    filtered.forEach(c => {
        gridHtml += `
            <a href="${assetBase}pages/college-details.php?slug=${c.slug}" class="college-card">
                <div class="college-info">
                    <div class="name">${escapeHtml(c.name)}</div>
                    <div class="location"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="display:inline"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> ${escapeHtml(c.location)}</div>
                    <div class="rating">⭐ ${c.rating} • ₹${c.fees}L</div>
                </div>
            </a>
        `;
    });
    gridHtml += '</div>';
    document.getElementById('collegesContentHeader').innerHTML = headerHtml;
    document.getElementById('collegesGrid').innerHTML = gridHtml;
}

function renderCourses(category) {
    const filtered = coursesData.filter(c => c.category === category).slice(0, 8);
    const headerHtml = `
        <div class="content-header">
            <div>
                <h4>${category}</h4>
                <div class="count">${filtered.length} programmes from top IIMs</div>
            </div>
            <a href="${assetBase}pages/courses.php" class="view-link">View all courses →</a>
        </div>
    `;
    let gridHtml = '<div class="content-grid">';
    if (filtered.length === 0) {
        gridHtml += `<div style="grid-column: span 2; text-align:center; padding:2rem;">No programmes found</div>`;
    } else {
        filtered.forEach(c => {
            const iimShortNames = c.iims.map(slug => {
                const college = collegesData.find(clg => clg.slug === slug);
                return college ? (college.short || college.name.split(' ').slice(0,2).join(' ')) : slug;
            }).slice(0,3);
            const tagsHtml = iimShortNames.map(name => `<span class="tag">${escapeHtml(name)}</span>`).join('');
            gridHtml += `
                <a href="${assetBase}pages/course-details.php?slug=${c.slug}" class="course-card">
                    <div class="course-title">${escapeHtml(c.title)}</div>
                    <div class="course-tags">${tagsHtml}</div>
                </a>
            `;
        });
    }
    gridHtml += '</div>';
    document.getElementById('coursesContentHeader').innerHTML = headerHtml;
    document.getElementById('coursesGrid').innerHTML = gridHtml;
}

function buildCategoryButtons(containerId, list, type, activeCat, onSelect) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';
    list.forEach(cat => {
        const btn = document.createElement('button');
        btn.className = `cat-btn ${activeCat === cat ? 'active' : ''}`;
        btn.textContent = cat;
        btn.onmouseenter = () => {
            document.querySelectorAll(`#${containerId} .cat-btn`).forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            onSelect(cat);
        };
        container.appendChild(btn);
    });
}

function escapeHtml(str) {
    return String(str).replace(/[&<>]/g, function(m){
        if(m==='&') return '&amp;';
        if(m==='<') return '&lt;';
        if(m==='>') return '&gt;';
        return m;
    });
}

// ---------- Dropdown hover logic ----------
let closeTimeout = null;
function setupDropdown(rootId, dropdownId, onOpen = null) {
    const root = document.getElementById(rootId);
    if (!root) return;
    const trigger = root.querySelector('.dropdown-trigger');
    const panel = document.getElementById(dropdownId);
    const openDropdown = () => {
        if (closeTimeout) clearTimeout(closeTimeout);
        document.querySelectorAll('.dropdown-root.open').forEach(d => d.classList.remove('open'));
        root.classList.add('open');
        if (onOpen) onOpen();
    };
    const closeDropdownDelayed = () => {
        closeTimeout = setTimeout(() => { root.classList.remove('open'); }, 100);
    };
    trigger.addEventListener('mouseenter', openDropdown);
    panel.addEventListener('mouseenter', () => { if (closeTimeout) clearTimeout(closeTimeout); });
    trigger.addEventListener('mouseleave', closeDropdownDelayed);
    panel.addEventListener('mouseleave', closeDropdownDelayed);
}

// ---------- Theme Toggle ----------
// FIX: Default is always LIGHT. Dark only applies if user explicitly saved 'dark'.
function initTheme() {
    const savedTheme = localStorage.getItem('theme');

    // If no saved preference OR saved preference is 'light' → apply light (remove dark class)
    if (savedTheme === 'dark') {
        document.body.classList.add('dark');
    } else {
        document.body.classList.remove('dark');
        // Set 'light' explicitly so all pages start from same baseline
        localStorage.setItem('theme', 'light');
    }

    const themeBtn = document.getElementById('themeToggle');
    themeBtn?.addEventListener('click', () => {
        document.body.classList.toggle('dark');
        if (document.body.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
}

// ---------- Scroll & Transparency ----------
function initScrollEffect() {
    const navbar = document.getElementById('navbarMain');
    const isHome = navbar?.dataset.home === 'true';
    if (!isHome) {
        navbar.classList.add('scrolled');
        navbar.classList.remove('transparent');
        return;
    }
    const handleScroll = () => {
        if (window.scrollY > 30) {
            navbar.classList.add('scrolled');
            navbar.classList.remove('transparent');
        } else {
            navbar.classList.remove('scrolled');
            navbar.classList.add('transparent');
        }
    };
    window.addEventListener('scroll', handleScroll);
    handleScroll();
}

// ---------- Mobile Menu ----------
function initMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('mobileOverlay');
    const toggleBtn = document.getElementById('mobileMenuToggle');
    const closeBtn = document.getElementById('closeMobileMenu');
    function openMenu() { menu.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
    function closeMenu() { menu.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }
    toggleBtn?.addEventListener('click', openMenu);
    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);
    document.querySelectorAll('.mobile-nav a').forEach(link => link.addEventListener('click', closeMenu));
}

// ---------- Modal ----------
function initModal() {
    const modal = document.getElementById('loginModal');
    const openBtns = [document.getElementById('loginBtn'), document.getElementById('mobileLoginBtn')];
    function openModal() { modal.classList.add('open'); document.body.style.overflow = 'hidden'; }
    window.closeModal = function() { modal.classList.remove('open'); document.body.style.overflow = ''; };
    openBtns.forEach(btn => btn?.addEventListener('click', openModal));
    document.getElementById('closeModalBtn')?.addEventListener('click', closeModal);
    modal?.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });
}

// ---------- Initialize Mega Dropdown Content ----------
function initMegas() {
    buildCategoryButtons('collegeCategoriesList', categoriesList, 'college', activeCollegeCat, (cat) => { activeCollegeCat = cat; renderColleges(cat); });
    renderColleges(activeCollegeCat);
    if (courseCategoriesList.length) {
        buildCategoryButtons('courseCategoriesList', courseCategoriesList, 'course', activeCourseCat, (cat) => { activeCourseCat = cat; renderCourses(cat); });
        renderCourses(activeCourseCat);
    }
    setupDropdown('dropdownCollegesRoot', 'megaColleges');
    setupDropdown('dropdownCoursesRoot', 'megaCourses');
}

// ---------- Run everything ----------
document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initScrollEffect();
    initMobileMenu();
    initModal();
    initMegas();
});
</script>