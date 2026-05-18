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

/* ---------- TRENDING COURSES ---------- */
.trending-sec {
  background: #fff;
  padding: 64px 0;
  border-bottom: 1px solid rgba(0,0,0,.06);
}
.trend-scroll {
  display: flex;
  gap: 18px;
  overflow-x: auto;
  padding-bottom: 8px;
  scroll-snap-type: x mandatory;
  scrollbar-width: none;
}
.trend-scroll::-webkit-scrollbar { display: none; }
.trend-card {
  flex-shrink: 0;
  width: 280px;
  scroll-snap-align: start;
  background: #f8f9fc;
  border: 1.5px solid #eef0f3;
  border-radius: 14px;
  padding: 20px;
  cursor: pointer;
  transition: transform .3s, box-shadow .3s, border-color .3s;
  position: relative;
  overflow: hidden;
}
.trend-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--accent), var(--accent-2));
  transform: scaleX(0);
  transform-origin: left;
  transition: transform .3s;
}
.trend-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: rgba(233,69,96,.2); }
.trend-card:hover::before { transform: scaleX(1); }
.trend-rank {

  font-size: 2.2rem;
  font-weight: 500;
  color: #eef0f3;
  position: absolute;
  top: 12px; right: 14px;
  line-height: 1;
}
.trend-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: .62rem;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: #fff;
  background: var(--accent);
  padding: .22rem .6rem;
  border-radius: 999px;
  margin-bottom: 10px;
}
.trend-title {
  font-weight: 700;
  font-size: .92rem;
  color: #1a1a2e;
  margin-bottom: 6px;
  line-height: 1.4;
}
.trend-meta {
  font-size: .75rem;
  color: var(--muted);
  display: flex;
  gap: 12px;
  margin-top: 10px;
}
.trend-meta span { display: flex; align-items: center; gap: 4px; }
.trend-bar {
  height: 3px;
  background: #eef0f3;
  border-radius: 99px;
  margin-top: 14px;
  overflow: hidden;
}
.trend-bar-fill {
  height: 100%;
  background: linear-gradient(90deg, var(--accent), var(--accent-2));
  border-radius: 99px;
  transition: width 1s ease;
  width: 0;
}
.trend-bar-fill.animated { width: var(--w); }
/* ---------- CAREER OUTCOMES ---------- */
.career-sec {
  background: #f5f7fb;
  padding: 64px 0;
}
.career-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 28px;
  align-items: start;
}
@media (max-width: 860px) { .career-grid { grid-template-columns: 1fr; } }
.career-left { }
.career-section-label {
  font-size: .68rem;
  font-weight: 700;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 10px;
}
.career-title {

  font-size: 2rem;
  font-weight: 500;
  color: #1a1a2e;
  line-height: 1.25;
  margin-bottom: 14px;
}
.career-desc {
  font-size: .9rem;
  color: var(--muted);
  line-height: 1.7;
  margin-bottom: 24px;
}
.career-role-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.career-role {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 16px;
  background: #fff;
  border-radius: 10px;
  border: 1.5px solid #eef0f3;
  transition: border-color .25s, transform .25s;
}
.career-role:hover { border-color: rgba(233,69,96,.25); transform: translateX(4px); }
.career-role-icon {
  width: 36px; height: 36px;
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  font-size: .9rem;
  flex-shrink: 0;
}
.career-role-name { font-size: .85rem; font-weight: 700; color: #1a1a2e; }
.career-role-company { font-size: .72rem; color: var(--muted); margin-top: 1px; }
.career-role-pkg {
  margin-left: auto;
  font-size: .78rem;
  font-weight: 700;
  color: var(--accent);
  white-space: nowrap;
}

.career-right { }
.career-chart-label {
  font-size: .72rem;
  font-weight: 600;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: .08em;
  margin-bottom: 14px;
}
.career-bar-item {
  margin-bottom: 14px;
}
.career-bar-head {
  display: flex;
  justify-content: space-between;
  font-size: .8rem;
  font-weight: 600;
  color: #1a1a2e;
  margin-bottom: 6px;
}
.career-bar-track {
  height: 8px;
  background: #e8eaf0;
  border-radius: 99px;
  overflow: hidden;
}
.career-bar-fill {
  height: 100%;
  background: linear-gradient(90deg, var(--accent), var(--accent-2));
  border-radius: 99px;
  width: 0;
  transition: width 1.2s cubic-bezier(.4,0,.2,1);
}
.career-bar-fill.animated { width: var(--w); }
.career-recruiter-title {
  font-size: .72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: var(--muted);
  margin: 28px 0 14px;
}
.career-logos {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}
.career-logo-chip {
  padding: 7px 14px;
  background: #fff;
  border: 1.5px solid #eef0f3;
  border-radius: 8px;
  font-size: .75rem;
  font-weight: 700;
  color: #1a1a2e;
  transition: border-color .2s, transform .2s;
}
.career-logo-chip:hover { border-color: rgba(233,69,96,.3); transform: translateY(-2px); }

/* ---------- FAQ ---------- */
.faq-wrap { max-width: 768px; margin: 0 auto; display: flex; flex-direction: column; gap: .75rem; }
.faq-item { border-radius: 12px; border: 1px solid var(--border); background: var(--card); overflow: hidden; }
.faq-question {
  display: flex; align-items: center; justify-content: space-between;
  padding: 0.8rem 1rem; cursor: pointer;  font-weight: 600;
  gap: 1rem;
  font-size: 0.8rem;
}
.faq-question:hover { background: var(--secondary); }
.faq-arrow { width: 20px; height: 20px; flex-shrink: 0; transition: transform .3s; }
.faq-item.open .faq-arrow { transform: rotate(180deg); }
.faq-answer { padding: 0 1.25rem; max-height: 0; overflow: hidden; transition: max-height .4s ease, padding .3s; color: var(--muted-foreground); line-height: 1.7; font-size: .9rem; }
.faq-item.open .faq-answer { max-height: 400px; padding: 0 1.25rem 1.25rem; }
.faq-item.open { box-shadow: var(--shadow-card); }
/* GENERAL UTILITIES */
.sec-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: .68rem;
  font-weight: 700;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 8px;
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
        i
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
     [3] TRENDING COURSES
     ============================================================ -->
<section class="trending-sec" id="trending">
  <div class="cp-container">

    <div class="cp-sh">
      <div>
        <span class="sec-eyebrow"><i class="bi bi-fire"></i> Hot Right Now</span>
        <h2 class="cp-sh-title" style="margin-top:4px;">Trending Programmes</h2>
      </div>
      <span class="cp-sh-badge">Most searched this week</span>
    </div>

    <div class="trend-scroll" id="trend-scroll">
      <?php
        // Show first 8 courses as trending (sorted by some criteria – here just first N)
        $trendCourses = array_slice($COURSES, 0, min(8, count($COURSES)));
        $popularities  = [98, 94, 91, 88, 85, 82, 79, 75];
        foreach ($trendCourses as $idx => $tc):
          $pop = $popularities[$idx] ?? 70;
      ?>
      <div class="trend-card" onclick="window.location='course-details.php?slug=<?= urlencode($tc['slug']) ?>'">
        <div class="trend-rank"><?= str_pad($idx+1, 2, '0', STR_PAD_LEFT) ?></div>
        <div class="trend-badge"><i class="bi bi-lightning-charge-fill"></i> Trending</div>
        <div class="trend-title"><?= htmlspecialchars($tc['title']) ?></div>
        <div class="trend-meta">
          <span><i class="bi bi-clock"></i> <?= htmlspecialchars($tc['duration']) ?></span>
          <span><i class="bi bi-currency-rupee"></i> <?= htmlspecialchars($tc['fees']) ?>L</span>
        </div>
        <div class="trend-bar">
          <div class="trend-bar-fill" style="--w:<?= $pop ?>%" data-bar></div>
        </div>
        <div style="font-size:.68rem;color:var(--muted);margin-top:6px;font-weight:600;"><?= $pop ?>% interest score</div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- ============================================================
     COURSES GRID (original — untouched)
     ============================================================ -->
<section class="cp-section" id="all-courses">
  <div class="cp-container">

    <div class="cp-sh">
      <h2 class="cp-sh-title">All IIMs programmes</h2>
      <span class="cp-sh-badge" id="grid-count"><?= count($COURSES) ?> courses available</span>
    </div>

    <div id="sf-no-results">
      <i class="bi bi-search"></i>
      <strong>No programmes found</strong><br>
      <span style="font-size:.85rem;">Try a different keyword or reset filters.</span>
    </div>

    <div class="cp-grid" id="cp-grid-container">
      <?php foreach ($COURSES as $i => $c): ?>

        <div
          class="cp-card"
          style="transition-delay:<?= min($i * 0.06, 0.54) ?>s"
          data-reveal
          data-title="<?= htmlspecialchars(strtolower($c['title'])) ?>"
          data-cat="<?= htmlspecialchars($c['category']) ?>"
          data-dur="<?= htmlspecialchars($c['duration']) ?>"
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
     [8] CAREER OUTCOMES
     ============================================================ -->
<section class="career-sec" id="career">
  <div class="cp-container">

    <div class="career-grid">
      <!-- Left: roles -->
      <div class="career-left">
        <div class="career-section-label"><i class="bi bi-briefcase-fill me-1"></i> Career Outcomes</div>
        <h2 class="career-title">Where IIM graduates<br>land after graduation</h2>
        <p class="career-desc">IIM alumni command premium roles across consulting, finance, tech, and general management. Here's a snapshot of top placements.</p>

        <div class="career-role-list">
          <?php
            $roles = [
              ['icon'=>'bi-graph-up-arrow','bg'=>'rgba(233,69,96,.1)','color'=>'var(--accent)','name'=>'Management Consultant','co'=>'McKinsey · BCG · Bain','pkg'=>'₹28–45 LPA'],
              ['icon'=>'bi-bank','bg'=>'rgba(15,52,96,.1)','color'=>'#0f3460','name'=>'Investment Banking Analyst','co'=>'Goldman · JPMorgan · Citi','pkg'=>'₹25–40 LPA'],
              ['icon'=>'bi-cpu','bg'=>'rgba(21,90,46,.1)','color'=>'#155a2e','name'=>'Product Manager','co'=>'Google · Amazon · Flipkart','pkg'=>'₹22–38 LPA'],
              ['icon'=>'bi-bar-chart-fill','bg'=>'rgba(245,166,35,.12)','color'=>'#c17d11','name'=>'Business Analyst','co'=>'Deloitte · EY · KPMG','pkg'=>'₹16–26 LPA'],
              ['icon'=>'bi-megaphone-fill','bg'=>'rgba(102,45,145,.1)','color'=>'#662d91','name'=>'Brand / Marketing Manager','co'=>'HUL · P&G · Marico','pkg'=>'₹14–24 LPA'],
            ];
            foreach ($roles as $r):
          ?>
          <div class="career-role">
            <div class="career-role-icon" style="background:<?= $r['bg'] ?>;color:<?= $r['color'] ?>;"><i class="bi <?= $r['icon'] ?>"></i></div>
            <div>
              <div class="career-role-name"><?= $r['name'] ?></div>
              <div class="career-role-company"><?= $r['co'] ?></div>
            </div>
            <div class="career-role-pkg"><?= $r['pkg'] ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Right: bar chart + recruiters -->
      <div class="career-right">
        <div class="career-chart-label">Placement by Sector (%)</div>
        <?php
          $sectors = [
            ['label'=>'Consulting', 'pct'=>32],
            ['label'=>'Finance & Banking', 'pct'=>28],
            ['label'=>'Technology', 'pct'=>22],
            ['label'=>'FMCG / Consumer', 'pct'=>10],
            ['label'=>'Others', 'pct'=>8],
          ];
          foreach ($sectors as $sec):
        ?>
        <div class="career-bar-item">
          <div class="career-bar-head">
            <span><?= $sec['label'] ?></span>
            <span><?= $sec['pct'] ?>%</span>
          </div>
          <div class="career-bar-track">
            <div class="career-bar-fill" style="--w:<?= $sec['pct'] ?>%" data-bar></div>
          </div>
        </div>
        <?php endforeach; ?>

        <div class="career-recruiter-title">Top Recruiters</div>
        <div class="career-logos">
          <?php
            $recruiters = ['McKinsey','BCG','Google','Amazon','Goldman Sachs','Deloitte','HUL','Flipkart','Infosys','HDFC Bank','Asian Paints','Tata Sons'];
            foreach ($recruiters as $r) {
              echo '<div class="career-logo-chip">' . htmlspecialchars($r) . '</div>';
            }
          ?>
        </div>
      </div>
    </div>

  </div>
</section>


<!-- ============================================================
     [9] FAQ
     ============================================================ -->
<section id="faq" class="cd-section reveal  py-4">
  <div class="container">
  <h2 class="cd-section-heading">Frequently Asked Questions</h2>

    <div class="faq-wrap" style="max-width:100%">

        <?php
        $faqs = [
          ['q'=>'What is the eligibility to apply for IIM MBA programmes?','a'=>'Most IIM MBA and PGDM programmes require a Bachelor\'s degree with minimum 50% marks (45% for SC/ST/PWD). Candidates must also have a valid CAT score. Work experience requirements vary — flagship PGP programmes typically prefer 0–2 years, while Executive MBA programmes require 5+ years of work experience.'],
          ['q'=>'Which entrance exams are accepted by IIMs?','a'=>'For flagship PGP/MBA programmes, CAT (Common Admission Test) is the primary entrance exam accepted by all IIMs. Some executive programmes also accept GMAT or GRE. International students may be considered on GMAT scores directly. Each IIM independently shortlists candidates after CAT results.'],
          ['q'=>'What is the average fee for an IIM MBA programme?','a'=>'Fees vary significantly across IIMs. IIM Ahmedabad, Bangalore, and Calcutta charge approximately ₹23–25 Lakhs for their 2-year PGP. Newer IIMs typically charge ₹12–18 Lakhs. Executive MBA programmes range from ₹20L to ₹32L depending on the IIM. Scholarships and loan facilities are widely available.'],
          ['q'=>'What is the placement track record at top IIMs?','a'=>'The top 3 IIMs (A, B, C) consistently achieve 100% placement. Median packages at IIM Ahmedabad exceed ₹28 LPA, while IIM Bangalore and Calcutta median packages hover around ₹24–26 LPA. Top international offers can go up to ₹1 Crore+. Consulting, Finance, and Technology are the dominant sectors.'],
          ['q'=>'Can I apply to multiple IIM programmes simultaneously?','a'=>'Yes. A single CAT score is valid for all IIMs. You can apply to multiple IIMs and multiple programmes simultaneously. Each IIM has its own application process, shortlisting criteria (CAT percentile, WAT-PI performance, academic background, diversity factors), and selection weightage. There is no central application portal.'],
          ['q'=>'Are there online or part-time MBA programmes at IIMs?','a'=>'Yes. Many IIMs now offer online and blended executive education programmes. IIM Bangalore\'s EPGP online, IIM Calcutta\'s PGPEX, and various IIM Executive MBA programmes are available in part-time or online formats. These are ideal for working professionals who cannot take a career break.'],
          ['q'=>'What is the difference between PGP and PGDM at IIMs?','a'=>'IIM Ahmedabad, Bangalore, and Calcutta offer PGP (Post Graduate Programme) degrees, which are considered equivalent to an MBA by the AIU (Association of Indian Universities). Other IIMs offer PGDM (Post Graduate Diploma in Management), which is a diploma rather than a degree. Both are highly valued by employers and are equivalent for all practical purposes in India and globally.'],
        ];
        ?>

        <?php foreach ($faqs as $faq): ?>
            <div class="faq-item">

                <div class="faq-question">
                    <?= htmlspecialchars($faq['q']) ?>

                    <svg class="faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </div>

                <div class="faq-answer">
                    <?= htmlspecialchars($faq['a']) ?>
                </div>

            </div>
        <?php endforeach; ?>

    </div>

  </div>
  
</section>


<!-- ============================================================
     FINAL CTA (original — untouched)
     ============================================================ -->
<section class="py-3">
  <div class="container">

    <div class="cta-pro position-relative overflow-hidden rounded-5 p-4 p-lg-5">

      <!-- Glow -->
      <div class="cta-glow"></div>

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
          </div>
        </div>

    </div>
  </div>
</section>


<!-- ============================================================
     SCROLL REVEAL (original)
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


<!-- ============================================================
     JAVASCRIPT — SEARCH/FILTER, COMPARISON, BARS, IIM TABS, FAQ
     ============================================================ -->
<script>
(function () {
  'use strict';

  /* ── SEARCH + FILTER ─────────────────────────────────────── */
  var cards      = document.querySelectorAll('#cp-grid-container .cp-card');
  var searchEl   = document.getElementById('sf-search');
  var catEl      = document.getElementById('sf-cat');
  var durEl      = document.getElementById('sf-dur');
  var countEl    = document.getElementById('sf-count');
  var gridCount  = document.getElementById('grid-count');
  var noRes      = document.getElementById('sf-no-results');
  var tagBtns    = document.querySelectorAll('.sf-tag');
  var activeTag  = '';

  function filterCards () {
    var q   = searchEl  ? searchEl.value.toLowerCase().trim() : '';
    var cat = catEl     ? catEl.value : '';
    var dur = durEl     ? durEl.value : '';
    var vis = 0;

    cards.forEach(function (card) {
      var title   = card.dataset.title || '';
      var cardCat = card.dataset.cat   || '';
      var cardDur = card.dataset.dur   || '';

      var matchQ   = !q   || title.indexOf(q) !== -1;
      var matchCat = !cat || cardCat === cat;
      var matchDur = !dur || cardDur === dur;
      var matchTag = !activeTag || title.indexOf(activeTag.toLowerCase()) !== -1 || cardCat.indexOf(activeTag) !== -1;

      var show = matchQ && matchCat && matchDur && matchTag;
      card.style.display = show ? '' : 'none';
      if (show) vis++;
    });

    var label = vis + ' programme' + (vis !== 1 ? 's' : '');
    if (countEl)  countEl.textContent  = label;
    if (gridCount) gridCount.textContent = vis + ' courses available';
    if (noRes)    noRes.style.display  = vis === 0 ? 'block' : 'none';
  }

  if (searchEl) searchEl.addEventListener('input', filterCards);
  if (catEl)    catEl.addEventListener('change', filterCards);
  if (durEl)    durEl.addEventListener('change', filterCards);

  tagBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      tagBtns.forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      activeTag = btn.dataset.tag || '';
      filterCards();
    });
  });

  /* ── ANIMATED BARS (career + trending) ───────────────────── */
  var bars = document.querySelectorAll('[data-bar]');
  if ('IntersectionObserver' in window && bars.length) {
    var barIO = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          e.target.classList.add('animated');
          barIO.unobserve(e.target);
        }
      });
    }, { threshold: 0.2 });
    bars.forEach(function (b) { barIO.observe(b); });
  } else {
    bars.forEach(function (b) { b.classList.add('animated'); });
  }

  /* ── IIM TAB HIGHLIGHT ON SCROLL ─────────────────────────── */
  var iimTabs = document.querySelectorAll('.iim-tab');
  var iimSections = document.querySelectorAll('.iim-sec[id]');
  if (iimTabs.length && iimSections.length && 'IntersectionObserver' in window) {
    var tabIO = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          var id = '#' + e.target.id;
          iimTabs.forEach(function (t) {
            t.classList.toggle('active', t.getAttribute('href') === id);
          });
        }
      });
    }, { rootMargin: '-40% 0px -55% 0px' });
    iimSections.forEach(function (s) { tabIO.observe(s); });
  }

  /* ── FAQ ACCORDION ───────────────────────────────────────── */
  document.querySelectorAll('.faq-q').forEach(function (q) {
    q.addEventListener('click', function () {
      var item = q.closest('.faq-item');
      var isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach(function (o) {
        o.classList.remove('open');
      });
      if (!isOpen) item.classList.add('open');
    });
  });

  /* ── SMOOTH ANCHOR SCROLL ────────────────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var target = document.querySelector(a.getAttribute('href'));
      if (!target) return;
      e.preventDefault();
      var offset = 130;
      var top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top: top, behavior: 'smooth' });
    });
  });

})();
</script>


<?php
include '../components/Footer.php';
include '../components/Modals.php';
include '../includes/footer.php';
?>