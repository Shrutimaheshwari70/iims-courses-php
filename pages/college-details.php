<?php
/**
 * pages/college-details.php  ←→  src/routes/colleges.$slug.tsx  (CollegeDetail)
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
  echo '<section class="section" style="padding-top:8rem;text-align:center"><h1>College not found.</h1><p><a href="colleges.php" class="btn btn-outline" style="display:inline-flex;margin-top:1rem">← Back to IIMs</a></p></section>';
  include '../components/Footer.php';
  include '../includes/footer.php';
  exit;
}

$page_title       = $c['name'].' — Fees, Placements, Admissions';
$page_description = substr($c['about'] ?? '', 0, 150);
$current_page     = 'colleges';

// Wishlist & compare (session)
$wishlist = $_SESSION['wishlist'] ?? [];
$compare  = $_SESSION['compare']  ?? [];
$inWish   = in_array($slug, $wishlist);
$inCmp    = in_array($slug, $compare);

// Handle wishlist toggle
if (isset($_GET['wish'])) {
  if ($inWish)  $wishlist = array_values(array_filter($wishlist, fn($s)=>$s!==$slug));
  else          $wishlist[] = $slug;
  $_SESSION['wishlist'] = $wishlist;
  header('Location: college-details.php?slug='.urlencode($slug)); exit;
}
// Handle compare toggle
if (isset($_GET['cmp'])) {
  if ($inCmp)                           $compare = array_values(array_filter($compare, fn($s)=>$s!==$slug));
  elseif (count($compare) < 3)         $compare[] = $slug;
  $_SESSION['compare'] = $compare;
  header('Location: college-details.php?slug='.urlencode($slug)); exit;
}

$SECTIONS = ['Overview','Courses','Admissions','Placements','Fees','Reviews','Faculty','FAQ'];
$recommended = array_slice(array_filter($COLLEGES, fn($x)=>$x['slug']!==$slug), 0, 3);

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="cd-hero">
  <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>" class="cd-hero-img" />
  <div class="cd-hero-overlay"></div>
  <div class="cd-hero-content">
    <span class="cd-rank-badge">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px">
        <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
      </svg>
      NIRF Rank #<?= (int)$c['ranking'] ?>
    </span>
    <h1 class="cd-hero-title"><?= htmlspecialchars($c['name']) ?></h1>
    <div class="cd-hero-meta">
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;display:inline">
          <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
        </svg>
        <?= htmlspecialchars($c['location']) ?>
      </span>
      <span>★ <?= $c['rating'] ?> (<?= $c['reviews'] ?>)</span>
      <span>Est. <?= $c['established'] ?></span>
    </div>
    <div class="cd-hero-actions">
      <button class="btn btn-hero" onclick="openModal('apply-modal')">
        Apply Now
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </button>
      <button class="btn btn-outline-white" onclick="alert('Brochure download coming soon!')">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Download Brochure
      </button>
      <a href="college-details.php?slug=<?= urlencode($slug) ?>&wish=1" class="cd-icon-btn <?= $inWish?'active-wish':'' ?>" title="Wishlist">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="<?= $inWish?'currentColor':'none' ?>" stroke="currentColor" stroke-width="2" style="width:20px;height:20px">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
      </a>
      <a href="college-details.php?slug=<?= urlencode($slug) ?>&cmp=1" class="cd-icon-btn <?= $inCmp?'active-cmp':'' ?>" title="Compare">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px">
          <polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/>
          <polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/>
        </svg>
      </a>
    </div>
  </div>
</section>


<!-- ============================================================
     STICKY TABS
     ============================================================ -->
<div class="cd-tabs-bar">
  <div class="container">
    <div class="cd-tabs">
      <?php foreach ($SECTIONS as $s): ?>
        <a href="#<?= $s ?>" class="cd-tab"><?= $s ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</div>


<!-- ============================================================
     CONTENT SECTIONS
     ============================================================ -->
<div class="container cd-content">

  <!-- OVERVIEW -->
  <section id="Overview" class="cd-section reveal">
    <h2 class="cd-section-title">Overview</h2>
    <p class="text-muted leading-relaxed text-lg"><?= htmlspecialchars($c['about'] ?? '') ?></p>
    <div class="cd-stat-grid">
      <div class="cd-stat"><div class="cd-stat-label">Total Fees</div><div class="cd-stat-value">₹<?= $c['fees'] ?>L</div></div>
      <div class="cd-stat"><div class="cd-stat-label">Avg Placement</div><div class="cd-stat-value">₹<?= $c['placement'] ?>L</div></div>
      <div class="cd-stat"><div class="cd-stat-label">Highest</div><div class="cd-stat-value">₹<?= $c['highest'] ?>L</div></div>
      <div class="cd-stat"><div class="cd-stat-label">Faculty</div><div class="cd-stat-value"><?= $c['faculty'] ?>+</div></div>
    </div>
  </section>

  <!-- COURSES -->
  <section id="Courses" class="cd-section reveal">
    <h2 class="cd-section-title">Courses Offered</h2>
    <div class="cd-courses-grid">
      <?php foreach ($c['category'] as $cat): ?>
      <div class="cd-course-card">
        <h4 class="cd-course-name">MBA in <?= htmlspecialchars($cat) ?></h4>
        <div class="cd-course-meta-grid">
          <div><div class="cd-meta-label">Duration</div><div class="cd-meta-val">2 Years</div></div>
          <div><div class="cd-meta-label">Fees</div><div class="cd-meta-val">₹<?= $c['fees'] ?>L</div></div>
          <div><div class="cd-meta-label">Intake</div><div class="cd-meta-val"><?= $c['intake'] ?></div></div>
          <div><div class="cd-meta-label">Eligibility</div><div class="cd-meta-val">CAT + Bachelor's</div></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ADMISSIONS -->
  <section id="Admissions" class="cd-section reveal">
    <h2 class="cd-section-title">Admissions Process</h2>
    <div class="cd-adm-grid">
      <div class="cd-adm-step">
        <div class="cd-adm-title">1. Entrance Exam</div>
        <p class="cd-adm-desc">Qualify <?= htmlspecialchars(implode(' or ', $c['exams'])) ?> with the cutoff percentile.</p>
      </div>
      <div class="cd-adm-step">
        <div class="cd-adm-title">2. WAT &amp; PI</div>
        <p class="cd-adm-desc">Written Ability Test followed by Personal Interview at IIM campus.</p>
      </div>
      <div class="cd-adm-step">
        <div class="cd-adm-title">3. Final Selection</div>
        <p class="cd-adm-desc">Based on composite score (CAT %ile, academics, work-ex, gender diversity, WAT-PI).</p>
      </div>
    </div>
  </section>

  <!-- PLACEMENTS -->
  <section id="Placements" class="cd-section reveal">
    <h2 class="cd-section-title">Placements</h2>
    <p class="text-muted leading-relaxed mb-5">
      <?= htmlspecialchars($c['name']) ?> consistently delivers top-tier placements with an average package of
      ₹<?= $c['placement'] ?>L and the highest reaching ₹<?= $c['highest'] ?>L in the latest cohort.
      Recruiters span consulting, banking, tech and FMCG — including
      <?= htmlspecialchars(implode(', ', array_slice($c['recruiters'],0,4))) ?>.
    </p>

    <!-- Simple bar chart: placement by year (pure CSS/HTML) -->
    <?php if (!empty($c['placementsByYear'])): ?>
    <div class="cd-bar-chart-wrap">
      <h4 class="cd-chart-title">Avg Placement (₹L) — Last 5 Years</h4>
      <div class="cd-bar-chart">
        <?php
        $max = max(array_column($c['placementsByYear'], 'avg'));
        foreach ($c['placementsByYear'] as $row):
          $pct = $max ? round(($row['avg']/$max)*100) : 0;
        ?>
        <div class="cd-bar-col">
          <div class="cd-bar-val">₹<?= $row['avg'] ?>L</div>
          <div class="cd-bar" style="height:<?= $pct ?>%"></div>
          <div class="cd-bar-label"><?= $row['year'] ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <div style="margin-top:1.5rem">
      <h4 class="cd-sub-title">Top Recruiters</h4>
      <div class="recruiter-chips">
        <?php foreach ($c['recruiters'] as $r): ?>
          <span class="recruiter-chip"><?= htmlspecialchars($r) ?></span>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- FEES -->
  <section id="Fees" class="cd-section reveal">
    <h2 class="cd-section-title">Fees &amp; Scholarships</h2>
    <div class="cd-fees-grid">
      <div class="cd-fees-card">
        <h4 class="cd-sub-title">Fee Breakdown (Total ₹<?= $c['fees'] ?>L)</h4>
        <ul class="cd-fees-list">
          <li><span>Tuition fee</span><span>₹<?= number_format($c['fees']*0.7,1) ?>L</span></li>
          <li><span>Hostel &amp; Mess</span><span>₹<?= number_format($c['fees']*0.18,1) ?>L</span></li>
          <li><span>Library &amp; Tech</span><span>₹<?= number_format($c['fees']*0.07,1) ?>L</span></li>
          <li><span>Misc</span><span>₹<?= number_format($c['fees']*0.05,1) ?>L</span></li>
        </ul>
      </div>
      <div class="cd-fees-card">
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

  <!-- REVIEWS -->
  <section id="Reviews" class="cd-section reveal">
    <h2 class="cd-section-title">Student Reviews</h2>
    <div class="cd-reviews-grid">
      <?php foreach (array_slice($TESTIMONIALS, 0, 4) as $t): ?>
      <div class="cd-review-card">
        <div class="cd-review-stars">
          <?php for ($k=0; $k < $t['rating']; $k++): ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:14px;height:14px;fill:#f59e0b">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
          <?php endfor; ?>
          <span class="cd-review-verified">Verified</span>
        </div>
        <p class="cd-review-quote">"<?= htmlspecialchars($t['quote']) ?>"</p>
        <div class="cd-review-author">— <?= htmlspecialchars($t['name']) ?>, <?= htmlspecialchars($t['role']) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- FACULTY -->
  <section id="Faculty" class="cd-section reveal">
    <h2 class="cd-section-title">Faculty</h2>
    <p class="text-muted leading-relaxed">
      <?= htmlspecialchars($c['name']) ?> has <?= $c['faculty'] ?>+ full-time faculty members with PhDs from top global
      institutions like Harvard, Stanford, Wharton and INSEAD. Many have served as advisors to governments and Fortune 500 firms.
    </p>
  </section>

  <!-- FAQ -->
  <section id="FAQ" class="cd-section reveal">
    <h2 class="cd-section-title">Frequently Asked</h2>
    <div class="faq-wrap">
      <?php foreach ($FAQS as $i => $faq): ?>
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

  <!-- RECOMMENDED -->
  <section class="cd-section">
    <h3 class="cd-section-title" style="font-size:1.75rem">Recommended IIMs</h3>
    <div class="colleges-grid">
      <?php foreach (array_values($recommended) as $index => $college): ?>
        <div class="reveal" style="transition-delay:<?= $index * 0.07 ?>s">
          <?php include '../components/CollegeCard.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- CTA -->
  <div class="cta-box reveal" style="margin-bottom:3rem">
    <div class="cta-inner" style="flex-direction:column;text-align:center;gap:1.5rem">
      <h3 class="cta-title">Ready to apply to <?= htmlspecialchars($c['short']) ?>?</h3>
      <p style="color:rgba(255,255,255,.8);margin:0">Free counselling with IIM alumni.</p>
      <button class="btn btn-hero" onclick="openModal('apply-modal')">Apply Now</button>
    </div>
  </div>

</div>

<?php
include '../components/Modals.php';
include '../components/Footer.php';
include '../includes/footer.php';
?>s