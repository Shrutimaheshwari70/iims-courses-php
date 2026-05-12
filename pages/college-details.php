<?php
/**
 * pages/college-details.php  ←→  src/routes/colleges.$slug.tsx
 * Exact same UI as TypeScript version — fully responsive
 */
session_start();
require_once '../data/iims.php';

$slug = trim($_GET['slug'] ?? '');
$c    = getCollege($slug);

if (!$c) {
    header('HTTP/1.0 404 Not Found');
    $page_title = 'College Not Found';
    include '../includes/header.php';
    include '../components/Navbar.php';
    echo '<section class="section" style="padding-top:8rem;text-align:center"><h1>College not found.</h1><p><a href="colleges.php" class="btn btn-navy" style="display:inline-flex;margin-top:1rem">← Back to IIMs</a></p></section>';
    include '../components/Footer.php';
    include '../includes/footer.php';
    exit;
}

$page_title       = $c['name'].' — Fees, Placements, Admissions';
$page_description = substr($c['about'] ?? '', 0, 150);
$current_page     = 'colleges';

// Session wishlist / compare
$wishlist = $_SESSION['wishlist'] ?? [];
$compare  = $_SESSION['compare']  ?? [];
$inWish   = in_array($slug, $wishlist);
$inCmp    = in_array($slug, $compare);

if (isset($_GET['wish'])) {
    if ($inWish) $wishlist = array_values(array_filter($wishlist, fn($s) => $s !== $slug));
    else         $wishlist[] = $slug;
    $_SESSION['wishlist'] = $wishlist;
    header('Location: college-details.php?slug='.urlencode($slug)); exit;
}
if (isset($_GET['cmp'])) {
    if ($inCmp)               $compare = array_values(array_filter($compare, fn($s) => $s !== $slug));
    elseif (count($compare)<3) $compare[] = $slug;
    $_SESSION['compare'] = $compare;
    header('Location: college-details.php?slug='.urlencode($slug)); exit;
}

$SECTIONS    = ['Overview','Courses','Admissions','Placements','Fees','Reviews','Faculty','FAQ'];
$recommended = array_slice(array_filter($COLLEGES, fn($x) => $x['slug'] !== $slug), 0, 3);

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ============================================================
     HERO  — h-[60vh] full-bleed image + overlay
     ============================================================ -->
<section class="cd-hero">
  <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>" class="cd-hero-img" />
  <div class="cd-hero-overlay"></div>
  <div class="cd-hero-content">

    <!-- NIRF badge -->
    <span class="cd-rank-badge">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
      </svg>
      NIRF Rank #<?= (int)$c['ranking'] ?>
    </span>

    <h1 class="cd-hero-title"><?= htmlspecialchars($c['name']) ?></h1>

    <div class="cd-hero-meta">
      <span class="cd-hero-meta-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <?= htmlspecialchars($c['location']) ?>
      </span>
      <span class="cd-hero-meta-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        <?= $c['rating'] ?> (<?= $c['reviews'] ?>)
      </span>
      <span>Est. <?= $c['established'] ?></span>
    </div>

    <div class="cd-hero-actions">
      <button class="btn btn-hero" onclick="openModal('apply-modal')">
        Apply Now
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </button>
      <button class="btn btn-outline" onclick="alert('Brochure download coming soon!')">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Download Brochure
      </button>
      <!-- Wishlist -->
      <a href="college-details.php?slug=<?= urlencode($slug) ?>&wish=1"
         class="cd-circle-btn <?= $inWish ? 'cd-circle-btn--active' : '' ?>" title="Wishlist">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
             fill="<?= $inWish ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="2">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
      </a>
      <!-- Compare -->
      <a href="college-details.php?slug=<?= urlencode($slug) ?>&cmp=1"
         class="cd-circle-btn <?= $inCmp ? 'cd-circle-btn--active' : '' ?>" title="Compare">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/>
          <polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/>
        </svg>
      </a>
    </div>

  </div>
</section>


<!-- ============================================================
     STICKY TABS  — same as TSX sticky top-16
     ============================================================ -->
<div class="cd-tabs-bar" id="cdTabsBar">
  <div class="container">
    <div class="cd-tabs" id="cdTabs">
      <?php foreach ($SECTIONS as $s): ?>
        <a href="#cd-<?= $s ?>" class="cd-tab" data-section="<?= $s ?>"><?= $s ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</div>


<!-- ============================================================
     CONTENT
     ============================================================ -->
<div class="container cd-body">

  <!-- ── OVERVIEW ── -->
  <section id="cd-Overview" class="cd-section reveal">
    <h2 class="cd-section-heading">Overview</h2>
    <p class="cd-muted cd-text-lg"><?= htmlspecialchars($c['about'] ?? '') ?></p>
    <div class="cd-stat-grid">
      <div class="cd-stat-card">
        <div class="cd-stat-label">Total Fees</div>
        <div class="cd-stat-value">₹<?= $c['fees'] ?>L</div>
      </div>
      <div class="cd-stat-card">
        <div class="cd-stat-label">Avg Placement</div>
        <div class="cd-stat-value">₹<?= $c['placement'] ?>L</div>
      </div>
      <div class="cd-stat-card">
        <div class="cd-stat-label">Highest</div>
        <div class="cd-stat-value">₹<?= $c['highest'] ?>L</div>
      </div>
      <div class="cd-stat-card">
        <div class="cd-stat-label">Faculty</div>
        <div class="cd-stat-value"><?= $c['faculty'] ?>+</div>
      </div>
    </div>
  </section>

  <!-- ── COURSES ── -->
  <section id="cd-Courses" class="cd-section reveal">
    <h2 class="cd-section-heading">Courses Offered</h2>
    <div class="cd-courses-grid">
      <?php foreach ($c['category'] as $cat): ?>
      <div class="cd-card">
        <h4 class="cd-card-title">MBA in <?= htmlspecialchars($cat) ?></h4>
        <div class="cd-course-meta">
          <div><div class="cd-meta-label">Duration</div><div class="cd-meta-val">2 Years</div></div>
          <div><div class="cd-meta-label">Fees</div><div class="cd-meta-val">₹<?= $c['fees'] ?>L</div></div>
          <div><div class="cd-meta-label">Intake</div><div class="cd-meta-val"><?= $c['intake'] ?></div></div>
          <div><div class="cd-meta-label">Eligibility</div><div class="cd-meta-val">CAT + Bachelor's</div></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ── ADMISSIONS ── -->
  <section id="cd-Admissions" class="cd-section reveal">
    <h2 class="cd-section-heading">Admissions Process</h2>
    <div class="cd-adm-grid">
      <?php
      $steps = [
        ['t'=>'1. Entrance Exam',   'd'=>'Qualify '.htmlspecialchars(implode(' or ',$c['exams'])).' with the cutoff percentile.'],
        ['t'=>'2. WAT &amp; PI',    'd'=>'Written Ability Test followed by Personal Interview at IIM campus.'],
        ['t'=>'3. Final Selection', 'd'=>'Based on composite score (CAT %ile, academics, work-ex, gender diversity, WAT-PI).'],
      ];
      foreach ($steps as $step): ?>
      <div class="cd-card">
        <div class="cd-card-title"><?= $step['t'] ?></div>
        <p class="cd-muted" style="font-size:.875rem;margin-top:.5rem"><?= $step['d'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ── PLACEMENTS ── -->
  <section id="cd-Placements" class="cd-section reveal">
    <h2 class="cd-section-heading">Placements</h2>
    <p class="cd-muted" style="margin-bottom:1.5rem">
      <?= htmlspecialchars($c['name']) ?> consistently delivers top-tier placements with an average package of
      ₹<?= $c['placement'] ?>L and the highest reaching ₹<?= $c['highest'] ?>L in the latest cohort.
      Recruiters span consulting, banking, tech and FMCG — including
      <?= htmlspecialchars(implode(', ', array_slice($c['recruiters'],0,4))) ?>.
    </p>

    <div class="cd-placement-charts">
      <!-- Avg placement bar chart (pure CSS bars — same visual as recharts BarChart) -->
      <?php if (!empty($c['placementsByYear'])): ?>
      <div class="cd-card">
        <h4 class="cd-sub-title">Avg &amp; Highest (₹L) — Last 5 Years</h4>
        <div class="cd-bar-chart">
          <?php
          $maxAvg = max(array_column($c['placementsByYear'], 'avg'));
          foreach ($c['placementsByYear'] as $row):
            $pct = $maxAvg ? round(($row['avg']/$maxAvg)*100) : 0;
          ?>
          <div class="cd-bar-col">
            <div class="cd-bar-top">₹<?= $row['avg'] ?>L</div>
            <div class="cd-bar-track">
              <div class="cd-bar-fill" style="height:<?= $pct ?>%"></div>
            </div>
            <div class="cd-bar-lbl"><?= $row['year'] ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- Salary distribution bars -->
      <?php if (!empty($c['salaryDist'])): ?>
      <div class="cd-card">
        <h4 class="cd-sub-title">Salary Distribution (%)</h4>
        <div class="cd-bar-chart">
          <?php
          $sdColors = ['#1e3a6e','#2d5a9e','#e07b39','#e8954d'];
          foreach ($c['salaryDist'] as $idx => $row):
            $color = $sdColors[$idx % count($sdColors)];
          ?>
          <div class="cd-bar-col">
            <div class="cd-bar-top"><?= $row['pct'] ?>%</div>
            <div class="cd-bar-track">
              <div class="cd-bar-fill" style="height:<?= $row['pct'] ?>%;background:<?= $color ?>"></div>
            </div>
            <div class="cd-bar-lbl" style="font-size:.6rem"><?= htmlspecialchars($row['range']) ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <div style="margin-top:1.5rem">
      <h4 class="cd-sub-title">Top Recruiters</h4>
      <div class="cd-chips">
        <?php foreach ($c['recruiters'] as $r): ?>
          <span class="cd-chip"><?= htmlspecialchars($r) ?></span>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ── FEES ── -->
  <section id="cd-Fees" class="cd-section reveal">
    <h2 class="cd-section-heading">Fees &amp; Scholarships</h2>
    <div class="cd-fees-grid">
      <div class="cd-card">
        <h4 class="cd-sub-title">Fee Breakdown (Total ₹<?= $c['fees'] ?>L)</h4>
        <ul class="cd-fees-list">
          <li><span>Tuition fee</span><span>₹<?= number_format($c['fees']*0.7,1) ?>L</span></li>
          <li><span>Hostel &amp; Mess</span><span>₹<?= number_format($c['fees']*0.18,1) ?>L</span></li>
          <li><span>Library &amp; Tech</span><span>₹<?= number_format($c['fees']*0.07,1) ?>L</span></li>
          <li><span>Misc</span><span>₹<?= number_format($c['fees']*0.05,1) ?>L</span></li>
        </ul>
      </div>
      <div class="cd-card">
        <h4 class="cd-sub-title">Scholarships &amp; EMI</h4>
        <ul class="cd-schol-list">
          <?php foreach ($c['scholarships'] as $s): ?>
            <li>• <?= htmlspecialchars($s) ?></li>
          <?php endforeach; ?>
          <li>• Education loans up to ₹40L from leading banks</li>
          <li>• Flexible EMI options post-placement</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ── REVIEWS ── -->
  <section id="cd-Reviews" class="cd-section reveal">
    <h2 class="cd-section-heading">Student Reviews</h2>
    <div class="cd-reviews-grid">
      <?php foreach (array_slice($TESTIMONIALS, 0, 4) as $t): ?>
      <div class="cd-card">
        <div class="cd-review-stars">
          <?php for ($k=0; $k < $t['rating']; $k++): ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          <?php endfor; ?>
          <span class="cd-verified-badge">Verified</span>
        </div>
        <p class="cd-review-text">"<?= htmlspecialchars($t['quote']) ?>"</p>
        <div class="cd-review-author">— <?= htmlspecialchars($t['name']) ?>, <?= htmlspecialchars($t['role']) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ── FACULTY ── -->
  <section id="cd-Faculty" class="cd-section reveal">
    <h2 class="cd-section-heading">Faculty</h2>
    <p class="cd-muted">
      <?= htmlspecialchars($c['name']) ?> has <?= $c['faculty'] ?>+ full-time faculty members with PhDs from top global
      institutions like Harvard, Stanford, Wharton and INSEAD. Many have served as advisors to governments and Fortune 500 firms.
    </p>
  </section>

  <!-- ── FAQ ── -->
  <section id="cd-FAQ" class="cd-section reveal">
    <h2 class="cd-section-heading">Frequently Asked</h2>
    <div class="faq-wrap" style="max-width:100%">
      <?php foreach ($FAQS as $faq): ?>
      <div class="faq-item">
        <div class="faq-question">
          <?= htmlspecialchars($faq['q']) ?>
          <svg class="faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
        </div>
        <div class="faq-answer"><?= htmlspecialchars($faq['a']) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ── RECOMMENDED ── -->
  <section class="cd-section">
    <h3 class="cd-section-heading" style="font-size:clamp(1.5rem,3vw,2rem)">Recommended IIMs</h3>
    <div class="colleges-grid">
      <?php foreach (array_values($recommended) as $index => $college): ?>
        <div class="reveal" style="transition-delay:<?= $index * 0.07 ?>s">
          <?php include '../components/CollegeCard.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ── CTA ── -->
  <div class="cta-box reveal" style="margin-bottom:3rem">
    <div class="cta-inner" style="flex-direction:column;text-align:center;gap:1.5rem">
      <h3 class="cta-title">Ready to apply to <?= htmlspecialchars($c['short'] ?? $c['name']) ?>?</h3>
      <p style="color:rgba(255,255,255,.8);margin:0">Free counselling with IIM alumni.</p>
      <button class="btn btn-hero" onclick="openModal('apply-modal')">Apply Now</button>
    </div>
  </div>

</div><!-- /cd-body -->


<style>
/* ================================================================
   COLLEGE DETAILS PAGE — STYLES
   Mirrors TypeScript: section layout, cards, bars, tabs, hero
   ================================================================ */

/* ── Hero ── */
.cd-hero {
  position: relative;
  height: 60vh;
  min-height: 420px;
  overflow: hidden;
}
.cd-hero-img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.cd-hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(26,35,64,.4) 0%, rgba(20,26,50,.88) 100%);
}
.cd-hero-content {
  position: relative;
  height: 100%;
  max-width: 1300px;
  margin: 0 auto;
  padding: 0 1.5rem 3rem;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  color: #fff;
}
.cd-rank-badge {
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  background: rgba(255,255,255,.15);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,.2);
  border-radius: 999px;
  padding: .3rem .85rem;
  font-size: .7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .08em;
  width: fit-content;
  margin-bottom: 1rem;
}
.cd-rank-badge svg { width: 12px; height: 12px; }
.cd-hero-title {
  font-family: var(--font-display);
  font-weight: 800;
  font-size: clamp(1.8rem, 5vw, 3.75rem);
  line-height: 1.1;
  letter-spacing: -0.02em;
  margin: 0 0 .75rem;
}
.cd-hero-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  font-size: .9rem;
  color: rgba(255,255,255,.9);
  margin-bottom: 1.5rem;
}
.cd-hero-meta-item {
  display: inline-flex;
  align-items: center;
  gap: .35rem;
}
.cd-hero-meta-item svg { width: 15px; height: 15px; flex-shrink: 0; }
.cd-hero-actions {
  display: flex;
  flex-wrap: wrap;
  gap: .75rem;
  align-items: center;
}
.cd-circle-btn {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: rgba(255,255,255,.1);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,.3);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  text-decoration: none;
  transition: background .2s, color .2s;
  flex-shrink: 0;
}
.cd-circle-btn svg { width: 20px; height: 20px; }
.cd-circle-btn:hover,
.cd-circle-btn--active { background: #fff; color: var(--accent); }

/* ── Sticky tabs bar ── */
.cd-tabs-bar {
  position: sticky;
  top: 72px;
  z-index: 30;
  background: rgba(var(--background-rgb, 255,255,255), .95);
  backdrop-filter: blur(8px);
  border-bottom: 1px solid var(--border);
}
body.dark .cd-tabs-bar { background: rgba(15,23,42,.95); }
.cd-tabs {
  display: flex;
  gap: .25rem;
  overflow-x: auto;
  scrollbar-width: none;
  -ms-overflow-style: none;
}
.cd-tabs::-webkit-scrollbar { display: none; }
.cd-tab {
  padding: 1rem 1rem;
  font-size: .82rem;
  font-weight: 500;
  white-space: nowrap;
  text-decoration: none;
  color: var(--muted-foreground);
  border-bottom: 2px solid transparent;
  transition: color .2s, border-color .2s;
  flex-shrink: 0;
}
.cd-tab:hover { color: var(--foreground); }
.cd-tab.active { color: var(--accent); border-bottom-color: var(--accent); }

/* ── Content body ── */
.cd-body {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

/* ── Section headings ── */
.cd-section {
  margin-bottom: 4rem;
  scroll-margin-top: 130px;
}
.cd-section-heading {
  font-family: var(--font-display);
  font-weight: 700;
  font-size: clamp(1.6rem, 3vw, 2.5rem);
  letter-spacing: -0.02em;
  margin-bottom: 1.5rem;
  color: var(--foreground);
}
.cd-muted { color: var(--muted-foreground); line-height: 1.75; }
.cd-text-lg { font-size: 1.05rem; }

/* ── Shared card ── */
.cd-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 1rem;
  padding: 1.5rem;
}

/* ── Stat grid (Overview) ── */
.cd-stat-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1rem;
  margin-top: 2rem;
}
@media (max-width: 768px) { .cd-stat-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 400px) { .cd-stat-grid { grid-template-columns: 1fr 1fr; } }
.cd-stat-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 1rem;
  padding: 1.25rem;
}
.cd-stat-label {
  font-size: .65rem;
  text-transform: uppercase;
  letter-spacing: .1em;
  font-weight: 600;
  color: var(--muted-foreground);
}
.cd-stat-value {
  font-family: var(--font-display);
  font-weight: 700;
  font-size: 1.5rem;
  margin-top: .25rem;
  color: var(--foreground);
}

/* ── Courses grid ── */
.cd-courses-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}
@media (max-width: 640px) { .cd-courses-grid { grid-template-columns: 1fr; } }
.cd-card-title {
  font-family: var(--font-display);
  font-weight: 600;
  font-size: 1.05rem;
  color: var(--foreground);
}
.cd-course-meta {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: .75rem;
  margin-top: .75rem;
  font-size: .85rem;
}
.cd-meta-label { font-size: .7rem; color: var(--muted-foreground); }
.cd-meta-val   { font-weight: 600; color: var(--foreground); }

/* ── Admissions grid ── */
.cd-adm-grid {
  display: grid;
  grid-template-columns: repeat(3,1fr);
  gap: 1rem;
}
@media (max-width: 768px) { .cd-adm-grid { grid-template-columns: 1fr; } }

/* ── Placement charts ── */
.cd-placement-charts {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.25rem;
}
@media (max-width: 768px) { .cd-placement-charts { grid-template-columns: 1fr; } }
.cd-sub-title {
  font-family: var(--font-display);
  font-weight: 600;
  font-size: 1rem;
  margin-bottom: 1rem;
  color: var(--foreground);
}

/* Pure CSS bar chart — mirrors recharts BarChart appearance */
.cd-bar-chart {
  display: flex;
  align-items: flex-end;
  gap: .6rem;
  height: 200px;
  padding-top: 1.5rem;
}
.cd-bar-col {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 1;
  height: 100%;
}
.cd-bar-top {
  font-size: .6rem;
  font-weight: 600;
  color: var(--muted-foreground);
  margin-bottom: .25rem;
  text-align: center;
  flex-shrink: 0;
}
.cd-bar-track {
  flex: 1;
  width: 100%;
  display: flex;
  align-items: flex-end;
  border-radius: 6px 6px 0 0;
  overflow: hidden;
}
.cd-bar-fill {
  width: 100%;
  background: var(--accent);
  border-radius: 6px 6px 0 0;
  transition: height .6s ease;
  min-height: 4px;
}
.cd-bar-lbl {
  font-size: .65rem;
  color: var(--muted-foreground);
  margin-top: .3rem;
  text-align: center;
  flex-shrink: 0;
}

/* Chips */
.cd-chips { display: flex; flex-wrap: wrap; gap: .5rem; }
.cd-chip {
  padding: .35rem .85rem;
  border-radius: 999px;
  background: var(--secondary);
  font-size: .8rem;
  font-weight: 500;
  color: var(--foreground);
}

/* ── Fees grid ── */
.cd-fees-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.25rem;
}
@media (max-width: 640px) { .cd-fees-grid { grid-template-columns: 1fr; } }
.cd-fees-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: .6rem;
  font-size: .875rem;
}
.cd-fees-list li {
  display: flex;
  justify-content: space-between;
  padding-bottom: .6rem;
  border-bottom: 1px solid var(--border);
}
.cd-fees-list li:last-child { border-bottom: none; }
.cd-fees-list li span:last-child { font-weight: 600; color: var(--foreground); }
.cd-schol-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: .5rem;
  font-size: .875rem;
  color: var(--muted-foreground);
}

/* ── Reviews ── */
.cd-reviews-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}
@media (max-width: 640px) { .cd-reviews-grid { grid-template-columns: 1fr; } }
.cd-review-stars {
  display: flex;
  align-items: center;
  gap: .15rem;
  margin-bottom: .6rem;
}
.cd-review-stars svg { width: 14px; height: 14px; }
.cd-verified-badge {
  font-size: .65rem;
  font-weight: 600;
  color: #3ab07b;
  background: rgba(58,176,123,.1);
  padding: .15rem .5rem;
  border-radius: 999px;
  margin-left: .35rem;
}
.cd-review-text {
  font-size: .875rem;
  line-height: 1.65;
  color: var(--foreground);
}
.cd-review-author {
  font-size: .72rem;
  color: var(--muted-foreground);
  margin-top: .75rem;
}

/* ── Responsive misc ── */
@media (max-width: 480px) {
  .cd-hero-actions .btn { font-size: .8rem; padding: .6rem 1rem; }
  .cd-hero-actions .cd-circle-btn { width: 38px; height: 38px; }
}
</style>


<script>
/* Active tab highlight on scroll */
(function () {
  const tabs    = document.querySelectorAll('.cd-tab');
  const sections = document.querySelectorAll('.cd-section[id]');

  function onScroll() {
    let current = '';
    sections.forEach(sec => {
      if (window.scrollY >= sec.offsetTop - 160) current = sec.id.replace('cd-', '');
    });
    tabs.forEach(t => {
      t.classList.toggle('active', t.dataset.section === current);
    });
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();
</script>


<?php
include '../components/Modals.php';
include '../components/Footer.php';
include '../includes/footer.php';
?>