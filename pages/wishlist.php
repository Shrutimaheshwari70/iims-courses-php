<?php
/**
 * pages/wishlist.php  ←→  src/routes/wishlist.tsx
 * Wishlist slugs stored in PHP session.
 */
session_start();
require_once '../data/iims.php';

$page_title       = 'Your Wishlist — IIMs Courses';
$page_description = 'Your saved IIMs.';
$current_page     = 'wishlist';

/* ── Handle add / remove ── */
$wishlist = $_SESSION['wishlist'] ?? [];

if (isset($_GET['add'])) {
    $slug = trim($_GET['add']);
    if ($slug && !in_array($slug, $wishlist)) {
        $wishlist[] = $slug;
    }
    $_SESSION['wishlist'] = $wishlist;
    $ref = $_SERVER['HTTP_REFERER'] ?? 'wishlist.php';
    header('Location: ' . $ref);
    exit;
}

if (isset($_GET['remove'])) {
    $remove   = trim($_GET['remove']);
    $wishlist = array_values(array_filter($wishlist, fn($s) => $s !== $remove));
    $_SESSION['wishlist'] = $wishlist;
    header('Location: wishlist.php');
    exit;
}

$savedColleges = array_values(
    array_filter(array_map(fn($s) => getCollege($s), $wishlist))
);

include '../includes/header.php';
include '../components/Navbar.php';
?>

<style>
/* ================================================================
   WISHLIST PAGE — DESIGN SYSTEM  (matches courses.php)
   ================================================================ */

@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

:root {
  --accent-2:    #f5a623;
  --dark:        #0d1117;
  --card-bg:     #ffffff;
  --card-border: rgba(0,0,0,.07);
  --muted:       #6c757d;
  --chip-bg:     #f0f2f5;
  --chip-color:  #495057;
  --hero-grad:   linear-gradient(135deg,#0d1117 0%,#1a1f35 45%,#0f3460 100%);
  --shadow-sm:   0 2px 8px rgba(0,0,0,.06);
  --shadow-lg:   0 20px 48px rgba(0,0,0,.16);
  --radius:      1.1rem;
  --tr:          .3s cubic-bezier(.4,0,.2,1);
}

*, *::before, *::after { box-sizing: border-box; }
a { text-decoration: none; color: inherit; }
img { display: block; }

/* ================================================================
   HERO STRIP
   ================================================================ */
.wl-hero {
  background: var(--hero-grad);
  position: relative;
  overflow: hidden;
  padding: 110px 0 80px;
}
.wl-hero::before,
.wl-hero::after {
  content: '';
  position: absolute;
  border-radius: 50%;
  filter: blur(90px);
  pointer-events: none;
}
.wl-hero::before {
  width: 420px; height: 420px;
  background: rgba(233,69,96,.18);
  top: -110px; right: -70px;
}
.wl-hero::after {
  width: 320px; height: 320px;
  background: rgba(15,52,96,.5);
  bottom: -80px; left: 10%;
}
.wl-hero-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 28px;
  position: relative;
  z-index: 1;
}

/* eyebrow */
.wl-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'DM Sans', sans-serif;
  font-size: .68rem;
  font-weight: 700;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--accent);
  background: rgba(233,69,96,.12);
  border: 1px solid rgba(233,69,96,.28);
  padding: .35rem .95rem;
  border-radius: 999px;
  margin-bottom: 22px;
}
.wl-eyebrow-dot {
  width: 6px; height: 6px;
  background: var(--accent);
  border-radius: 50%;
  animation: wlBlink 1.7s ease infinite;
}
@keyframes wlBlink {
  0%,100% { opacity:1; transform:scale(1); }
  50%      { opacity:.4; transform:scale(1.6); }
}

.wl-hero h1 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2.2rem, 4.5vw, 3.6rem);
  font-weight: 800;
  color: #fff;
  line-height: 1.16;
  margin: 0 0 16px;
}
.wl-hero h1 em {
  font-style: normal;
  background: linear-gradient(90deg, var(--accent), var(--accent-2));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.wl-hero-sub {
  font-family: 'DM Sans', sans-serif;
  color: rgba(255,255,255,.55);
  font-size: 1rem;
  line-height: 1.7;
  max-width: 460px;
  margin: 0;
}

/* count badge in hero */
.wl-hero-count {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  margin-top: 28px;
  font-family: 'DM Sans', sans-serif;
  font-size: .82rem;
  font-weight: 600;
  color: rgba(255,255,255,.7);
  background: rgba(255,255,255,.08);
  border: 1px solid rgba(255,255,255,.14);
  padding: .4rem 1rem;
  border-radius: 999px;
}
.wl-hero-count svg {
  width: 14px; height: 14px;
  stroke: var(--accent);
}

/* wave */
.wl-wave {
  display: block;
  width: 100%;
  overflow: hidden;
  line-height: 0;
  background: var(--hero-grad);
}
.wl-wave svg {
  display: block;
  width: 100%;
  height: 48px;
}

/* ================================================================
   MAIN SECTION
   ================================================================ */
.wl-section {
  background: #f5f7fb;
  padding: 64px 0 96px;
}
.wl-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 28px;
}

/* section header */
.wl-sh {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 36px;
  gap: 12px;
  flex-wrap: wrap;
}
.wl-sh-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.6rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0;
}
.wl-sh-badge {
  font-family: 'DM Sans', sans-serif;
  font-size: .75rem;
  font-weight: 600;
  color: var(--muted);
  background: #e8eaf0;
  border: 1px solid rgba(0,0,0,.06);
  padding: .3rem .85rem;
  border-radius: 999px;
}

/* ================================================================
   EMPTY STATE
   ================================================================ */
.wl-empty {
  margin-top: 12px;
  border: 2px dashed #d8dce6;
  border-radius: var(--radius);
  padding: 80px 28px;
  text-align: center;
  background: #fff;
}
.wl-empty-icon {
  width: 64px; height: 64px;
  margin: 0 auto 20px;
  background: rgba(233,69,96,.08);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.wl-empty-icon svg {
  width: 30px; height: 30px;
  stroke: var(--accent);
  fill: none;
}
.wl-empty-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.35rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0 0 8px;
}
.wl-empty-text {
  font-family: 'DM Sans', sans-serif;
  font-size: .9rem;
  color: var(--muted);
  margin: 0 0 24px;
  max-width: 340px;
  margin-left: auto;
  margin-right: auto;
  line-height: 1.6;
}
.wl-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-family: 'DM Sans', sans-serif;
  font-size: .85rem;
  font-weight: 700;
  color: #fff;
  background: linear-gradient(135deg, var(--accent), #c73652);
  border: none;
  padding: .7rem 1.5rem;
  border-radius: 999px;
  cursor: pointer;
  box-shadow: 0 4px 16px rgba(233,69,96,.35);
  transition: transform var(--tr), box-shadow var(--tr);
  text-decoration: none;
}
.wl-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(233,69,96,.45);
  color: #fff;
}
.wl-btn svg { width: 14px; height: 14px; }

/* ================================================================
   COLLEGE GRID
   ================================================================ */
.wl-grid {
  display: grid;
  grid-template-columns: repeat(3,1fr);
  gap: 26px;
}
@media (max-width: 1024px) { .wl-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 640px)  { .wl-grid { grid-template-columns: 1fr; gap: 18px; } }

/* ================================================================
   COLLEGE CARD
   ================================================================ */
.wl-card {
  background: var(--card-bg);
  border-radius: var(--radius);
  border: 1px solid var(--card-border);
  box-shadow: var(--shadow-sm);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  opacity: 0;
  transform: translateY(28px);
  transition:
    opacity .52s ease,
    transform .52s ease,
    box-shadow var(--tr);
}
.wl-card.is-visible { opacity:1; transform:translateY(0); }
.wl-card:hover { transform:translateY(-6px) !important; box-shadow: var(--shadow-lg); }

/* image */
.wl-ci {
  position: relative;
  aspect-ratio: 16/9;
  overflow: hidden;
  flex-shrink: 0;
}
.wl-ci img {
  width:100%; height:100%;
  object-fit: cover;
  transition: transform .52s ease;
}
.wl-card:hover .wl-ci img { transform: scale(1.07); }
.wl-ci-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, transparent 35%, rgba(13,17,23,.6) 100%);
}
.wl-ci-badge {
  position: absolute;
  top: 11px; left: 11px;
  font-family: 'DM Sans', sans-serif;
  font-size: .58rem;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: #fff;
  background: var(--accent);
  padding: .27rem .68rem;
  border-radius: 999px;
  box-shadow: 0 2px 8px rgba(233,69,96,.35);
}
.wl-ci-rank {
  position: absolute;
  bottom: 11px; right: 11px;
  font-family: 'DM Sans', sans-serif;
  font-size: .68rem;
  font-weight: 700;
  color: #fff;
  background: rgba(0,0,0,.45);
  backdrop-filter: blur(6px);
  padding: .25rem .65rem;
  border-radius: 6px;
}

/* body */
.wl-cb {
  padding: 1.1rem 1.2rem 1.3rem;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.wl-cb-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 8px;
}
.wl-cb-name {
  font-family: 'DM Sans', sans-serif;
  font-size: .97rem;
  font-weight: 700;
  color: #1a1a2e;
  line-height: 1.38;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin: 0;
}

/* remove (heart) button */
.wl-remove {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px; height: 32px;
  border-radius: 50%;
  border: 1.5px solid rgba(233,69,96,.25);
  background: rgba(233,69,96,.06);
  color: var(--accent);
  cursor: pointer;
  flex-shrink: 0;
  transition: background var(--tr), border-color var(--tr), transform var(--tr);
  text-decoration: none;
}
.wl-remove:hover {
  background: var(--accent);
  border-color: var(--accent);
  color: #fff;
  transform: scale(1.12);
}
.wl-remove svg { width: 14px; height: 14px; fill: currentColor; }

.wl-cb-location {
  font-family: 'DM Sans', sans-serif;
  font-size: .78rem;
  color: var(--muted);
  margin: 5px 0 0;
  display: flex;
  align-items: center;
  gap: 4px;
}
.wl-cb-location svg { width: 11px; height: 11px; stroke: var(--muted); fill: none; flex-shrink:0; }

/* divider */
.wl-cb-div {
  height: 1px;
  background: #eef0f3;
  margin: 12px 0;
}

/* stats row */
.wl-cb-stats {
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
}
.wl-cb-stat {
  display: flex;
  flex-direction: column;
}
.wl-cb-stat-val {
  font-family: 'DM Sans', sans-serif;
  font-size: .82rem;
  font-weight: 700;
  color: #1a1a2e;
  line-height: 1;
}
.wl-cb-stat-key {
  font-family: 'DM Sans', sans-serif;
  font-size: .62rem;
  color: var(--muted);
  margin-top: 3px;
  white-space: nowrap;
}

/* footer */
.wl-cb-foot {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: auto;
  padding-top: 13px;
}
.wl-cb-link {
  font-family: 'DM Sans', sans-serif;
  font-size: .78rem;
  font-weight: 700;
  color: var(--accent);
  display: inline-flex;
  align-items: center;
  gap: 4px;
  transition: gap var(--tr);
}
.wl-card:hover .wl-cb-link { gap: 8px; }
.wl-cb-link svg {
  width: 12px; height: 12px;
  transition: transform var(--tr);
}
.wl-card:hover .wl-cb-link svg { transform: translateX(3px); }

/* chips */
.wl-chips {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  margin-top: 10px;
}
.wl-chip {
  font-family: 'DM Sans', sans-serif;
  font-size: .58rem;
  font-weight: 600;
  padding: .2rem .58rem;
  border-radius: 999px;
  background: var(--chip-bg);
  color: var(--chip-color);
  border: 1px solid rgba(0,0,0,.06);
  transition: background var(--tr), color var(--tr);
}
.wl-card:hover .wl-chip {
  background: rgba(233,69,96,.09);
  color: var(--accent);
}

/* ================================================================
   RESPONSIVE HERO
   ================================================================ */
@media (max-width: 768px) {
  .wl-hero { padding: 90px 0 60px; }
}
</style>


<!-- ============================================================
     HERO
     ============================================================ -->
<section class="wl-hero">
  <div class="wl-hero-inner">

    <div class="wl-eyebrow">
      <span class="wl-eyebrow-dot"></span>
      My Saved Colleges
    </div>

    <h1>Your <em>Wishlist</em></h1>
    <p class="wl-hero-sub">All your saved IIM colleges in one place. Compare and apply with ease.</p>

    <div class="wl-hero-count">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
      </svg>
      <?= count($savedColleges) ?> college<?= count($savedColleges) !== 1 ? 's' : '' ?> saved
    </div>

  </div>
</section>

<!-- wave transition -->
<div class="wl-wave">
  <svg viewBox="0 0 1440 48" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,32 C360,0 1080,64 1440,16 L1440,0 L0,0 Z" fill="#f5f7fb"/>
  </svg>
</div>


<!-- ============================================================
     MAIN CONTENT
     ============================================================ -->
<section class="wl-section">
  <div class="wl-container">

    <?php if (empty($savedColleges)): ?>
    <!-- ── EMPTY STATE ── -->
      <div class="wl-empty">
        <div class="wl-empty-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
        </div>
        <h2 class="wl-empty-title">Nothing saved yet</h2>
        <p class="wl-empty-text">No saved IIMs yet. Tap the heart icon on any college card to add it here.</p>
        <a href="colleges.php" class="wl-btn">
          Browse IIMs
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
      </div>

    <?php else: ?>
    <!-- ── GRID ── -->
      <div class="wl-sh">
        <h2 class="wl-sh-title">Saved colleges</h2>
        <span class="wl-sh-badge"><?= count($savedColleges) ?> saved</span>
      </div>

      <div class="wl-grid">
        <?php foreach ($savedColleges as $index => $college): ?>
          <div
            class="wl-card"
            style="transition-delay:<?= min($index * 0.06, 0.48) ?>s"
            data-reveal
          >
            <!-- Image -->
            <div class="wl-ci">
              <img
                src="<?= htmlspecialchars($college['image'] ?? '') ?>"
                alt="<?= htmlspecialchars($college['name'] ?? '') ?>"
                loading="lazy"
              />
              <div class="wl-ci-overlay"></div>
              <?php if (!empty($college['type'])): ?>
                <span class="wl-ci-badge"><?= htmlspecialchars($college['type']) ?></span>
              <?php endif; ?>
              <?php if (!empty($college['rank'])): ?>
                <span class="wl-ci-rank">#<?= htmlspecialchars($college['rank']) ?> Rank</span>
              <?php endif; ?>
            </div>

            <!-- Body -->
            <div class="wl-cb">

              <div class="wl-cb-top">
                <h3 class="wl-cb-name"><?= htmlspecialchars($college['name'] ?? '') ?></h3>
                <!-- Remove from wishlist -->
                <a
                  href="wishlist.php?remove=<?= urlencode($college['slug']) ?>"
                  class="wl-remove"
                  title="Remove from wishlist"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                  </svg>
                </a>
              </div>

              <?php if (!empty($college['location'])): ?>
                <p class="wl-cb-location">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                  </svg>
                  <?= htmlspecialchars($college['location']) ?>
                </p>
              <?php endif; ?>

              <div class="wl-cb-div"></div>

              <!-- Stats row -->
              <div class="wl-cb-stats">
                <?php if (!empty($college['fees'])): ?>
                  <div class="wl-cb-stat">
                    <span class="wl-cb-stat-val">₹<?= htmlspecialchars($college['fees']) ?>L</span>
                    <span class="wl-cb-stat-key">Total Fees</span>
                  </div>
                <?php endif; ?>
                <?php if (!empty($college['avg_package'])): ?>
                  <div class="wl-cb-stat">
                    <span class="wl-cb-stat-val">₹<?= htmlspecialchars($college['avg_package']) ?>L</span>
                    <span class="wl-cb-stat-key">Avg Package</span>
                  </div>
                <?php endif; ?>
                <?php if (!empty($college['intake'])): ?>
                  <div class="wl-cb-stat">
                    <span class="wl-cb-stat-val"><?= htmlspecialchars($college['intake']) ?></span>
                    <span class="wl-cb-stat-key">Intake</span>
                  </div>
                <?php endif; ?>
              </div>

              <!-- Footer -->
              <div class="wl-cb-foot">
                <!-- IIM chips -->
                <div class="wl-chips">
                  <?php if (!empty($college['short'])): ?>
                    <span class="wl-chip"><?= htmlspecialchars($college['short']) ?></span>
                  <?php endif; ?>
                  <?php if (!empty($college['established'])): ?>
                    <span class="wl-chip">Est. <?= htmlspecialchars($college['established']) ?></span>
                  <?php endif; ?>
                </div>
                <a
                  href="college-details.php?slug=<?= urlencode($college['slug']) ?>"
                  class="wl-cb-link"
                >
                  View details
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                  </svg>
                </a>
              </div>

            </div><!-- /.wl-cb -->
          </div><!-- /.wl-card -->
        <?php endforeach; ?>
      </div><!-- /.wl-grid -->

    <?php endif; ?>

  </div><!-- /.wl-container -->
</section>


<!-- ============================================================
     SCROLL REVEAL
     ============================================================ -->
<script>
(function () {
  'use strict';
  var items = document.querySelectorAll('[data-reveal]');
  if (!items.length || !('IntersectionObserver' in window)) {
    items.forEach(function (el) { el.classList.add('is-visible'); });
    return;
  }
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) {
        e.target.classList.add('is-visible');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.08 });
  items.forEach(function (el) { io.observe(el); });
})();
</script>


<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>