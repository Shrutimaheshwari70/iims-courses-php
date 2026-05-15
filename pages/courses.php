<?php
/**
 * pages/courses.php
 */
session_start();
require_once '../data/iims.php';

$page_title       = 'MBA & PGDM Courses at IIMs';
$page_description = 'Explore MBA, PGDM, Executive MBA, Business Analytics and more programmes at India\'s top IIMs.';
$current_page     = 'courses';

include '../includes/header.php';
include '../components/Navbar.php';
?>

<style>
/* ================================================================
   COURSES PAGE — FULL DESIGN SYSTEM
   ================================================================ */

@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

:root {
  --accent-2:      #f5a623;
  --dark:          #0d1117;
  --card-bg:       #ffffff;
  --card-border:   rgba(0,0,0,.07);
  --muted:         #6c757d;
  --chip-bg:       #f0f2f5;
  --chip-color:    #495057;
  --hero-grad:     linear-gradient(135deg,#0d1117 0%,#1a1f35 45%,#0f3460 100%);
  --shadow-sm:     0 2px 8px rgba(0,0,0,.06);
  --shadow-md:     0 8px 24px rgba(0,0,0,.10);
  --shadow-lg:     0 20px 48px rgba(0,0,0,.16);
  --radius-card:   1.1rem;
  --tr:            .3s cubic-bezier(.4,0,.2,1);
}
html,body{
  overflow-x: hidden;
  font-family: var(--font-display);
}
*, *::before, *::after { box-sizing: border-box; }

/* ================================================================
   HERO
   ================================================================ */
.cp-hero {
  background: var(--hero-grad);
  position: relative;
  overflow: hidden;
  padding: 110px 0 84px;
}
.cp-hero::before,
.cp-hero::after {
  content: '';
  position: absolute;
  border-radius: 50%;
  filter: blur(90px);
  pointer-events: none;
}
.cp-hero::before {
  width: 480px; height: 480px;
  background: rgba(233,69,96,.18);
  top: -130px; right: -80px;
}
.cp-hero::after {
  width: 360px; height: 360px;
  background: rgba(15,52,96,.5);
  bottom: -100px; left: 8%;
}
.cp-hero-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 28px;
  position: relative;
  z-index: 1;
}

/* eyebrow badge */
.cp-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  
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
.cp-eyebrow-dot {
  width: 6px; height: 6px;
  background: var(--accent);
  border-radius: 50%;
  animation: cpBlink 1.7s ease infinite;
}
@keyframes cpBlink {
  0%,100% { opacity: 1; transform: scale(1); }
  50%      { opacity: .4; transform: scale(1.6); }
}

.cp-hero h1 {
  
  font-size: clamp(2.4rem, 5vw, 3.9rem);
  font-weight: 600;
  color: #fff;
  line-height: 1.16;
  max-width: 700px;
  margin: 0 0 18px;
}
.cp-hero h1 em {
  font-style: normal;
  background: linear-gradient(90deg, var(--accent), var(--accent-2));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.cp-hero-sub {
  
  color: rgba(255,255,255,.6);
  font-size: 1.05rem;
  line-height: 1.7;
  max-width: 520px;
  margin: 0;
}

/* stats strip */
.cp-stats {
  display: flex;
  gap: 40px;
  margin-top: 48px;
  flex-wrap: wrap;
  align-items: flex-start;
}
.cp-stat-num {
  
  font-size: 1.95rem;
  font-weight: 700;
  color: #fff;
  line-height: 1;
}
.cp-stat-label {
  
  font-size: .68rem;
  font-weight: 600;
  letter-spacing: .09em;
  color: rgba(255,255,255,.42);
  text-transform: uppercase;
  margin-top: 5px;
}
.cp-stat-sep {
  width: 1px;
  height: 40px;
  background: rgba(255,255,255,.12);
  align-self: center;
}

/* wave divider */
.cp-wave {
  display: block;
  width: 100%;
  overflow: hidden;
  line-height: 0;
  background: var(--hero-grad);
}
.cp-wave svg {
  display: block;
  width: 100%;
  height: 48px;
}

/* ================================================================
   SECTION
   ================================================================ */
.cp-section {
  background: #f5f7fb;
  padding: 64px 0 96px;
}
.cp-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 28px;
}

/* section header */
.cp-sh {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 36px;
  gap: 12px;
  flex-wrap: wrap;
}
.cp-sh-title {
  
  font-size: 1.7rem;
  font-weight: 700;
  color: #1a1a2e;
  margin: 0;
}
.cp-sh-badge {
  
  font-size: .75rem;
  font-weight: 600;
  color: var(--muted);
  background: #e8eaf0;
  border: 1px solid rgba(0,0,0,.06);
  padding: .3rem .85rem;
  border-radius: 999px;
  white-space: nowrap;
}

/* ================================================================
   GRID
   ================================================================ */
.cp-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 26px;
}
@media (max-width: 1024px) { .cp-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 640px)  { .cp-grid { grid-template-columns: 1fr; gap: 18px; } }

/* ================================================================
   CARD
   ================================================================ */
.cp-card {
  background: var(--card-bg);
  border-radius: var(--radius-card);
  border: 1px solid var(--card-border);
  box-shadow: var(--shadow-sm);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  opacity: 0;
  transform: translateY(30px);
  transition:
    opacity .55s ease,
    transform .55s ease,
    box-shadow var(--tr);
}
.cp-card.is-visible {
  opacity: 1;
  transform: translateY(0);
}
.cp-card:hover {
  transform: translateY(-7px) !important;
  box-shadow: var(--shadow-lg);
}

/* image */
.cp-ci {
  position: relative;
  aspect-ratio: 16/10;
  overflow: hidden;
  flex-shrink: 0;
}
.cp-ci img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  background: #f5f7fb;

  /* ADD THESE */
  image-rendering: auto;
  backface-visibility: hidden;
  transform: translateZ(0);

  transition: transform .55s ease;
}
.cp-card:hover .cp-ci img { transform: scale(1.07); }

.cp-ci-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, transparent 35%, rgba(13,17,23,.6) 100%);
}
.cp-ci-cat {
  position: absolute;
  top: 12px; left: 12px;
  
  font-size: .58rem;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: #fff;
  background: var(--accent);
  padding: .28rem .7rem;
  border-radius: 999px;
  box-shadow: 0 2px 8px rgba(233,69,96,.35);
}

/* bottom-of-image price tag */
.cp-ci-price {
  position: absolute;
  bottom: 12px; right: 12px;
  
  font-size: .7rem;
  font-weight: 700;
  color: #fff;
  background: rgba(0,0,0,.45);
  backdrop-filter: blur(6px);
  padding: .28rem .7rem;
  border-radius: 6px;
}

/* body */
.cp-cb {
  padding: 1.1rem 1.2rem 1.35rem;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.cp-cb-title {
  
  font-size: .98rem;
  font-weight: 700;
  color: #1a1a2e;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin: 0 0 6px;
}
.cp-cb-desc {
  
  font-size: .81rem;
  color: var(--muted);
  line-height: 1.6;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin: 0;
  flex: 1;
}

/* divider */
.cp-cb-div {
  height: 1px;
  background: #eef0f3;
  margin: 14px 0;
}

/* footer row */
.cp-cb-foot {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
}
.cp-cb-meta {
  
  font-size: .78rem;
  font-weight: 600;
  color: #1a1a2e;
  display: flex;
  align-items: center;
  gap: 6px;
}
.cp-cb-meta-icon {
  width: 26px; height: 26px;
  border-radius: 7px;
  background: linear-gradient(135deg,rgba(233,69,96,.13),rgba(245,166,35,.13));
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .68rem;
  color: var(--accent);
  font-weight: 700;
}
.cp-cb-link {
  
  font-size: .75rem;
  font-weight: 700;
  color: var(--accent);
  display: inline-flex;
  align-items: center;
  gap: 4px;
  white-space: nowrap;
  transition: gap var(--tr);
}
.cp-card:hover .cp-cb-link { gap: 8px; }
.cp-cb-link svg {
  width: 12px; height: 12px;
  flex-shrink: 0;
  transition: transform var(--tr);
}
.cp-card:hover .cp-cb-link svg { transform: translateX(3px); }

/* IIM chips */
.cp-chips {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  margin-top: 11px;
}
.cp-chip {
  
  font-size: .58rem;
  font-weight: 600;
  letter-spacing: .04em;
  padding: .2rem .58rem;
  border-radius: 999px;
  background: var(--chip-bg);
  color: var(--chip-color);
  border: 1px solid rgba(0,0,0,.06);
  transition: background var(--tr), color var(--tr);
}
.cp-card:hover .cp-chip {
  background: rgba(233,69,96,.09);
  color: var(--accent);
}

/* ================================================================
   RESPONSIVE HERO
   ================================================================ */
@media (max-width: 768px) {
  .cp-hero  { padding: 90px 0 60px; }
  .cp-stats { gap: 22px; }
  .cp-stat-sep { display: none; }
}
</style>


<!-- ============================================================
     HERO
     ============================================================ -->
<section class="cp-hero">
  <div class="cp-hero-inner">

    <div class="cp-eyebrow">
      <span class="cp-eyebrow-dot"></span>
      IIM Programmes 2025–26
    </div>

    <h1>All <em>programmes</em><br>at India's top IIMs</h1>

    <p class="cp-hero-sub">
      From flagship MBA to executive education, PGDM &amp; Business Analytics — find the right programme for your career leap.
    </p>

    <div class="cp-stats">
      <div>
        <div class="cp-stat-num"><?= count($COURSES) ?>+</div>
        <div class="cp-stat-label">Programmes</div>
      </div>
      <div class="cp-stat-sep"></div>
      <div>
        <div class="cp-stat-num">20+</div>
        <div class="cp-stat-label">IIM Campuses</div>
      </div>
      <div class="cp-stat-sep"></div>
      <div>
        <div class="cp-stat-num">₹8L+</div>
        <div class="cp-stat-label">Avg. Package</div>
      </div>
      <div class="cp-stat-sep"></div>
      <div>
        <div class="cp-stat-num">95%</div>
        <div class="cp-stat-label">Placement Rate</div>
      </div>
    </div>

  </div>
</section>

<!-- wave transition -->
<div class="cp-wave">
  <svg viewBox="0 0 1440 48" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,32 C360,0 1080,64 1440,16 L1440,0 L0,0 Z" fill="#f5f7fb"/>
  </svg>
</div>


<!-- ============================================================
     COURSES GRID
     ============================================================ -->
<section class="cp-section">
  <div class="cp-container">

    <div class="cp-sh">
      <h2 class="cp-sh-title">All IIMs programmes</h2>
      <span class="cp-sh-badge"><?= count($COURSES) ?> courses available</span>
    </div>

    <div class="cp-grid">
      <?php foreach ($COURSES as $i => $c): ?>

        <div
          class="cp-card"
          style="transition-delay:<?= min($i * 0.06, 0.54) ?>s"
          data-reveal
        >
          <a href="course-details.php?slug=<?= urlencode($c['slug']) ?>" style="display:flex;flex-direction:column;height:100%;text-decoration:none;color:inherit;">

            <!-- Image -->
            <div class="cp-ci">
              <img
                src="<?= htmlspecialchars($c['image']) ?>"
                alt="<?= htmlspecialchars($c['title']) ?>"
                loading="lazy"
              />
              <div class="cp-ci-overlay"></div>
              <span class="cp-ci-cat"><?= htmlspecialchars($c['category']) ?></span>
              <span class="cp-ci-price">₹<?= htmlspecialchars($c['fees']) ?>L</span>
            </div>

            <!-- Body -->
            <div class="cp-cb">
              <h3 class="cp-cb-title"><?= htmlspecialchars($c['title']) ?></h3>
              <p class="cp-cb-desc"><?= htmlspecialchars($c['description']) ?></p>

              <div class="cp-cb-div"></div>

              <div class="cp-cb-foot">
                <span class="cp-cb-meta">
                  <span class="cp-cb-meta-icon">₹</span>
                  <?= htmlspecialchars($c['fees']) ?>L &nbsp;·&nbsp; <?= htmlspecialchars($c['duration']) ?>
                </span>
                <span class="cp-cb-link">
                  View details
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                  </svg>
                </span>
              </div>

              <?php
                $chips = array_slice($c['iims'], 0, 4);
                $validChips = [];
                foreach ($chips as $s) {
                  $iim = getCollege($s);
                  if ($iim) $validChips[] = $iim['short'];
                }
                if (!empty($validChips)):
              ?>
              <div class="cp-chips">
                <?php foreach ($validChips as $short): ?>
                  <span class="cp-chip"><?= htmlspecialchars($short) ?></span>
                <?php endforeach; ?>
              </div>
              <?php endif; ?>

            </div><!-- /.cp-cb -->
          </a>
        </div><!-- /.cp-card -->

      <?php endforeach; ?>
    </div><!-- /.cp-grid -->

  </div><!-- /.cp-container -->
</section>
<!-- ============================================================
     FINAL CTA
     ============================================================ -->
<section class="py-3">
  <div class="container">

    <div class="cta-pro position-relative overflow-hidden rounded-5 p-4 p-lg-5">

      <!-- Glow -->
      <div class="cta-glow"></div>

      <!-- <div class="center-cta d-flex"> -->
        <div class="row align-items-center g-4 position-relative" style="z-index:2;">
          <!-- Left Content -->
          <div class="col-lg-7 text-center mx-auto">

            <span class="cta-badge mb-3 d-inline-flex align-items-center">
              <i class="bi bi-stars me-2"></i>
              Trusted by CAT Aspirants Across India
            </span>

            <h4 class="cta-content display-5 fw-bold text-white mb-2 lh-sm">
              Start Your Journey Towards
              <span class="cta-highlight">Top IIM Admissions</span>
            </h4>

            <p class="cta-text mb-4">
              Get personalised guidance from experienced mentors, IIM alumni, and CAT experts.
              From profile evaluation to final admission strategy — we help you at every step.
            </p>
          </div>
<div class="text-center">
  <button class="button-cta bg-transparent px-4 py-2" onclick="openApplyModal()">
    Apply
  </button>
</div>        </div>
      <!-- </div> -->

    </div>
</section>

<!-- ============================================================
     SCROLL REVEAL
     ============================================================ -->
<script>
(function () {
  'use strict';
  var items = document.querySelectorAll('[data-reveal]');
  if (!items.length || !('IntersectionObserver' in window)) {
    /* fallback: show all immediately */
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
include '../components/Modals.php';

include '../includes/footer.php';
?>