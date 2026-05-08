<?php
/**
 * components/Navbar.php
 * PHP conversion of src/components/Navbar.tsx
 *
 * Requires: $COLLEGES, $COURSES already loaded via data/iims.php
 * Usage: include 'components/Navbar.php';
 *
 * Active page detection: set $current_page = 'colleges' | 'courses' | etc.
 */
$current_page = $current_page ?? '';
$wish_count   = isset($_SESSION['wishlist'])  ? count($_SESSION['wishlist'])  : 0;
$comp_count   = isset($_SESSION['compare'])   ? count($_SESSION['compare'])   : 0;

$categories = ['Management','Finance','Marketing','HR','Operations','Business Analytics','International Business'];
$course_cats = array_unique(array_column($COURSES, 'category'));
?>

<header class="navbar" id="navbar">
  <div class="navbar-inner">

    <!-- Logo -->
    <a href="index.php" class="navbar-logo">
      <div class="navbar-logo-icon">
        <!-- GraduationCap icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
          <path d="M6 12v5c3 3 9 3 12 0v-5"/>
        </svg>
      </div>
      <div class="navbar-logo-text">
        <span class="navbar-logo-title">IIMs Courses</span>
        <span class="navbar-logo-sub">India's MBA Discovery</span>
      </div>
    </a>

    <!-- Desktop Nav -->
    <nav class="navbar-nav" id="desktop-nav">
      <a href="index.php" class="nav-link <?= $current_page==='home' ? 'active' : '' ?>">Home</a>

      <!-- Colleges Mega Menu -->
      <div class="nav-dropdown-wrap" id="dd-colleges">
        <button class="nav-link" onclick="toggleDropdown('dd-colleges')">
          Colleges
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;display:inline;margin-left:2px">
            <polyline points="6 9 12 15 18 9"/>
          </svg>
        </button>
        <div class="dropdown-panel">
          <div class="dropdown-inner">
            <div class="dd-sidebar">
              <?php foreach ($categories as $cat): ?>
              <button class="dd-cat-btn" onclick="filterColleges('<?= htmlspecialchars($cat) ?>')"><?= htmlspecialchars($cat) ?></button>
              <?php endforeach; ?>
            </div>
            <div class="dd-content" id="dd-colleges-list">
              <?php foreach (array_slice($COLLEGES, 0, 6) as $c): ?>
              <a href="pages/college-details.php?slug=<?= $c['slug'] ?>" class="dd-college-item">
                <img src="<?= $c['image'] ?>" alt="<?= htmlspecialchars($c['name']) ?>" />
                <div>
                  <div class="dd-college-name"><?= htmlspecialchars($c['name']) ?></div>
                  <div class="dd-college-loc"><?= htmlspecialchars($c['location']) ?></div>
                </div>
              </a>
              <?php endforeach; ?>
            </div>
          </div>
          <a href="pages/colleges.php" class="dd-footer-link">View all 14 IIMs →</a>
        </div>
      </div>

      <!-- Courses link -->
      <a href="pages/courses.php" class="nav-link <?= $current_page==='courses' ? 'active' : '' ?>">Courses</a>
      <a href="compare.php"       class="nav-link <?= $current_page==='compare' ? 'active' : '' ?>">Compare</a>
      <a href="pages/blogs.php"   class="nav-link <?= $current_page==='blogs'   ? 'active' : '' ?>">Blogs</a>
      <a href="about.php"         class="nav-link <?= $current_page==='about'   ? 'active' : '' ?>">About</a>
      <a href="contact.php"       class="nav-link <?= $current_page==='contact' ? 'active' : '' ?>">Contact</a>
    </nav>

    <!-- Right actions -->
    <div class="navbar-actions">
      <!-- Wishlist -->
      <a href="wishlist.php" class="icon-btn" title="Wishlist">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
        <?php if ($wish_count > 0): ?><span class="badge"><?= $wish_count ?></span><?php endif; ?>
      </a>
      <!-- Compare -->
      <a href="compare.php" class="icon-btn" title="Compare">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px">
          <polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/>
          <polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/>
        </svg>
        <?php if ($comp_count > 0): ?><span class="badge"><?= $comp_count ?></span><?php endif; ?>
      </a>
      <!-- Dark mode toggle -->
      <button class="icon-btn" id="theme-toggle" title="Toggle theme" onclick="toggleTheme()">
        <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;display:none">
          <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/>
          <line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
          <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/>
          <line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
          <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
        </svg>
        <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
        </svg>
      </button>
      <!-- Apply CTA -->
      <button class="btn btn-hero btn-sm" onclick="openModal('apply-modal')">Apply Now</button>
      <!-- Mobile menu -->
      <button class="icon-btn navbar-mobile-btn" id="mobile-menu-btn" onclick="toggleMobileMenu()">
        <svg id="menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px">
          <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu Panel -->
  <div id="mobile-menu" style="display:none; background:var(--background); border-top:1px solid var(--border); padding:1rem 1.5rem;">
    <nav style="display:flex;flex-direction:column;gap:.5rem;">
      <a href="index.php"           class="nav-link" style="text-align:left;">Home</a>
      <a href="pages/colleges.php"  class="nav-link" style="text-align:left;">Colleges</a>
      <a href="pages/courses.php"   class="nav-link" style="text-align:left;">Courses</a>
      <a href="compare.php"         class="nav-link" style="text-align:left;">Compare</a>
      <a href="pages/blogs.php"     class="nav-link" style="text-align:left;">Blogs</a>
      <a href="about.php"           class="nav-link" style="text-align:left;">About</a>
      <a href="contact.php"         class="nav-link" style="text-align:left;">Contact</a>
    </nav>
  </div>
</header>

<!-- Navbar CSS extras for dropdown -->
<style>
.nav-dropdown-wrap { position: relative; }
.dropdown-panel {
  position: absolute; top: 100%; left: 0; min-width: 640px;
  background: var(--card); border: 1px solid var(--border);
  border-radius: 16px; box-shadow: var(--shadow-elegant); padding: 1.25rem;
  opacity: 0; pointer-events: none; transform: translateY(8px);
  transition: opacity .2s, transform .2s; z-index: 100;
}
.nav-dropdown-wrap.open .dropdown-panel { opacity:1; pointer-events:all; transform:translateY(0); }
.dropdown-inner { display: flex; gap: 1rem; }
.dd-sidebar { display:flex; flex-direction:column; gap:.25rem; min-width:160px; }
.dd-cat-btn {
  text-align:left; padding:.45rem .75rem; border:none; background:none;
  border-radius:8px; cursor:pointer; font-size:.85rem; font-weight:500; color:var(--foreground);
  transition:background .15s;
}
.dd-cat-btn:hover { background:var(--secondary); }
.dd-content { display:grid; grid-template-columns:1fr 1fr; gap:.5rem; flex:1; }
.dd-college-item {
  display:flex; align-items:center; gap:.6rem; padding:.5rem .6rem;
  border-radius:10px; text-decoration:none; color:var(--foreground);
  transition:background .15s;
}
.dd-college-item:hover { background:var(--secondary); }
.dd-college-item img { width:36px; height:36px; border-radius:8px; object-fit:cover; }
.dd-college-name { font-size:.82rem; font-weight:600; }
.dd-college-loc  { font-size:.68rem; color:var(--muted-foreground); }
.dd-footer-link {
  display:block; margin-top:.75rem; padding:.5rem .75rem; border-top:1px solid var(--border);
  text-align:center; font-size:.82rem; color:var(--accent); font-weight:600;
}
.nav-link.active { color:var(--accent); }
</style>