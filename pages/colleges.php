<?php
/**
 * pages/colleges.php
 * Single file — handles BOTH the list view AND the detail view.
 * ?slug=iim-ahmedabad  → college detail page (colleges.$slug.tsx)
 * (no slug)            → colleges list page  (colleges.index.tsx)
 *
 * Requires: ../data/iims.php  (provides $COLLEGES, $FAQS, $TESTIMONIALS,
 *            getCollege($slug), $RECRUITERS, etc.)
 */

session_start();
require_once '../data/iims.php';

$slug = trim($_GET['slug'] ?? '');

/* ── route decision ────────────────────────────────────────────── */
if ($slug !== '') {
    /* ── DETAIL VIEW ── */
    $c = getCollege($slug);
    if (!$c) {
        header('HTTP/1.0 404 Not Found');
        $page_title = 'College Not Found';
        include '../includes/header.php';
        include '../components/Navbar.php';
        echo '<div style="padding-top:8rem;text-align:center;font-size:1.1rem;">College not found.</div>';
        include '../components/Footer.php';
        include '../includes/footer.php';
        exit;
    }
    $page_title       = htmlspecialchars($c['name']) . ' — Fees, Placements, Admissions';
    $page_description = htmlspecialchars(mb_substr($c['about'] ?? '', 0, 150));
    $current_page     = 'colleges';

    $SECTIONS = ['Overview','Courses','Admissions','Placements','Fees','Reviews','Faculty','FAQ'];
    $recommended = array_values(array_slice(array_filter($COLLEGES, fn($x) => $x['slug'] !== $slug), 0, 3));

    include '../includes/header.php';
    include '../components/Navbar.php';
?>

<!-- Bootstrap Icons only (no full Bootstrap CSS globally) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Bootstrap CSS scoped ONLY inside .bs via a style tag trick -->
<style id="bs-scope-style"></style>

<!-- =====================================================================
     COLLEGE DETAIL PAGE  ←→  colleges.$slug.tsx
     ===================================================================== -->

<!-- ── Hero ── -->
<section class="cd-hero">
  <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>" class="cd-hero-img" />
  <div class="cd-hero-overlay"></div>
  <div class="cd-hero-content">

    <span class="cd-rank-badge">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
        <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
      </svg>
      NIRF Rank #<?= (int)($c['ranking'] ?? 0) ?>
    </span>

    <h1 class="cd-hero-title"><?= htmlspecialchars($c['name']) ?></h1>

    <div class="cd-hero-meta">
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <?= htmlspecialchars($c['location']) ?>
      </span>
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="1" width="16" height="16"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        <?= number_format((float)($c['rating'] ?? 0), 1) ?> (<?= htmlspecialchars($c['reviews'] ?? '') ?>)
      </span>
      <span>Est. <?= htmlspecialchars($c['established'] ?? '') ?></span>
    </div>

    <div class="cd-hero-actions">
      <button class="btn btn-hero btn-sm" onclick="openModal('apply-modal')">
        Apply Now
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </button>
      <button class="btn cd-outline-btn btn-sm" onclick="showToast('Brochure download started!','success')">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Download Brochure
      </button>
      <!-- Wishlist -->
      <button class="cd-icon-btn" id="wish-btn" onclick="toggleWishlist()" title="Wishlist">
        <svg id="wish-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
      </button>
      <!-- Compare -->
      <button class="cd-icon-btn" onclick="showToast('Added to compare!','success')" title="Compare">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
    <line x1="18" y1="20" x2="18" y2="10"/>
    <line x1="12" y1="20" x2="12" y2="4"/>
    <line x1="6" y1="20" x2="6" y2="14"/>
  </svg>
</button>
    </div>
  </div>
</section>

<!-- ── Sticky Tabs ── -->
<div class="cd-tabs-bar" id="cd-tabs-bar">
  <div class="cd-tabs-inner">
    <?php foreach ($SECTIONS as $sec): ?>
    <a href="#<?= $sec ?>" class="cd-tab" onclick="setTab('<?= $sec ?>')" id="tab-<?= $sec ?>"><?= $sec ?></a>
    <?php endforeach; ?>
  </div>
</div>

<!-- ── Main Content ── -->
<div class="cd-main">

  <!-- OVERVIEW -->
  <section id="Overview" class="cd-section reveal">
    <h2 class="cd-section-title">Overview</h2>
    <p class="cd-lead"><?= htmlspecialchars($c['about'] ?? '') ?></p>
    <div class="cd-stats-grid">
      <div class="cd-stat-card"><div class="cd-stat-label">Total Fees</div><div class="cd-stat-value">₹<?= htmlspecialchars($c['fees'] ?? '') ?>L</div></div>
      <div class="cd-stat-card"><div class="cd-stat-label">Avg Placement</div><div class="cd-stat-value">₹<?= htmlspecialchars($c['placement'] ?? '') ?>L</div></div>
      <div class="cd-stat-card"><div class="cd-stat-label">Highest</div><div class="cd-stat-value">₹<?= htmlspecialchars($c['highest'] ?? '') ?>L</div></div>
      <div class="cd-stat-card"><div class="cd-stat-label">Faculty</div><div class="cd-stat-value"><?= htmlspecialchars($c['faculty'] ?? '') ?>+</div></div>
    </div>
  </section>

  <!-- COURSES -->
  <section id="Courses" class="cd-section reveal">
    <h2 class="cd-section-title">Courses Offered</h2>
    <div class="cd-courses-grid">
      <?php foreach (($c['category'] ?? []) as $cat): ?>
      <div class="cd-course-card">
        <h4 class="cd-course-name">MBA in <?= htmlspecialchars($cat) ?></h4>
        <div class="cd-course-meta-grid">
          <div><div class="cd-meta-label">Duration</div><div class="cd-meta-val">2 Years</div></div>
          <div><div class="cd-meta-label">Fees</div><div class="cd-meta-val">₹<?= htmlspecialchars($c['fees'] ?? '') ?>L</div></div>
          <div><div class="cd-meta-label">Intake</div><div class="cd-meta-val"><?= htmlspecialchars($c['intake'] ?? '') ?></div></div>
          <div><div class="cd-meta-label">Eligibility</div><div class="cd-meta-val">CAT + Bachelor's</div></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ADMISSIONS -->
  <section id="Admissions" class="cd-section reveal">
    <h2 class="cd-section-title">Admissions Process</h2>
    <div class="cd-admit-grid">
      <?php
      $examsStr = implode(' or ', $c['exams'] ?? []);
      $admSteps = [
        ['t' => '1. Entrance Exam',    'd' => "Qualify {$examsStr} with the cutoff percentile."],
        ['t' => '2. WAT & PI',         'd' => 'Written Ability Test followed by Personal Interview at IIM campus.'],
        ['t' => '3. Final Selection',  'd' => 'Based on composite score (CAT %ile, academics, work-ex, gender diversity, WAT-PI).'],
      ];
      foreach ($admSteps as $s):
      ?>
      <div class="cd-admit-card">
        <div class="cd-admit-step-title"><?= htmlspecialchars($s['t']) ?></div>
        <p class="cd-admit-desc"><?= htmlspecialchars($s['d']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- PLACEMENTS -->
  <section id="Placements" class="cd-section reveal">
    <h2 class="cd-section-title">Placements</h2>
    <p class="cd-lead">
      <?= htmlspecialchars($c['name']) ?> consistently delivers top-tier placements with an average package of
      ₹<?= htmlspecialchars($c['placement'] ?? '') ?>L and the highest reaching ₹<?= htmlspecialchars($c['highest'] ?? '') ?>L
      in the latest cohort. Recruiters span consulting, banking, tech and FMCG — including
      <?= htmlspecialchars(implode(', ', array_slice($c['recruiters'] ?? [], 0, 4))) ?>.
    </p>

    <div class="cd-charts-grid">
      <!-- Avg placement trend chart -->
      <div class="cd-chart-card">
        <h4 class="cd-chart-title">Avg &amp; Highest (₹L) — last 5 years</h4>
        <div class="cd-chart-wrap">
          <canvas id="chart-trend"></canvas>
        </div>
      </div>
      <!-- Salary distribution chart -->
      <div class="cd-chart-card">
        <h4 class="cd-chart-title">Salary Distribution</h4>
        <div class="cd-chart-wrap">
          <canvas id="chart-dist"></canvas>
        </div>
      </div>
    </div>

    <!-- Top Recruiters -->
    <div class="cd-recruiters">
      <h4 class="cd-sub-title">Top Recruiters</h4>
      <div class="cd-recruiter-chips">
        <?php foreach (($c['recruiters'] ?? []) as $r): ?>
        <span class="cd-chip"><?= htmlspecialchars($r) ?></span>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- FEES -->
  <section id="Fees" class="cd-section reveal">
    <h2 class="cd-section-title">Fees &amp; Scholarships</h2>
    <div class="cd-fees-grid">
      <div class="cd-fees-card">
        <h4 class="cd-sub-title">Fee Breakdown (Total ₹<?= htmlspecialchars($c['fees'] ?? '') ?>L)</h4>
        <ul class="cd-fee-list">
          <?php
          $fees = (float)($c['fees'] ?? 0);
          $breakdown = [
            'Tuition fee'    => round($fees * 0.70, 1),
            'Hostel & Mess'  => round($fees * 0.18, 1),
            'Library & Tech' => round($fees * 0.07, 1),
            'Misc'           => round($fees * 0.05, 1),
          ];
          foreach ($breakdown as $label => $amt):
          ?>
          <li class="cd-fee-row">
            <span><?= htmlspecialchars($label) ?></span>
            <span class="cd-fee-amt">₹<?= $amt ?>L</span>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="cd-fees-card">
        <h4 class="cd-sub-title">Scholarships &amp; EMI</h4>
        <ul class="cd-scholarship-list">
          <?php foreach (($c['scholarships'] ?? []) as $s): ?>
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
      <?php foreach (array_slice($TESTIMONIALS, 0, 4) as $ti => $t):
        $initials = mb_strtoupper(mb_substr(trim($t['name']), 0, 1));
        $colors   = ['#6366f1','#0ea5e9','#10b981','#f59e0b'];
        $color    = $colors[$ti % 4];
      ?>
      <div class="cd-review-card">
        <div class="cd-review-stars">
          <?php for ($s = 0; $s < (int)($t['rating'] ?? 0); $s++): ?>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="1" width="16" height="16">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
          </svg>
          <?php endfor; ?>
          <span class="cd-verified-badge">Verified</span>
        </div>
        <p class="cd-review-quote">"<?= htmlspecialchars($t['quote']) ?>"</p>
        <div class="cd-review-author">
          <?php if (!empty($t['image'])): ?>
            <img src="<?= htmlspecialchars($t['image']) ?>" alt="<?= htmlspecialchars($t['name']) ?>"
                 class="cd-review-avatar-img"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
            <div class="cd-review-avatar" style="display:none;background:<?= $color ?>"><?= $initials ?></div>
          <?php else: ?>
            <div class="cd-review-avatar" style="background:<?= $color ?>"><?= $initials ?></div>
          <?php endif; ?>
          <div>
            <div class="cd-review-name"><?= htmlspecialchars($t['name']) ?></div>
            <div class="cd-review-role"><?= htmlspecialchars($t['role']) ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- FACULTY -->
  <section id="Faculty" class="cd-section reveal">
    <h2 class="cd-section-title">Faculty</h2>
    <p class="cd-lead">
      <?= htmlspecialchars($c['name']) ?> has <?= htmlspecialchars($c['faculty'] ?? '') ?>+ full-time faculty members
      with PhDs from top global institutions like Harvard, Stanford, Wharton, and INSEAD.
      Many have served as advisors to governments and Fortune 500 firms.
    </p>
  </section>

  <!-- FAQ -->
  <section id="FAQ" class="cd-section reveal">
    <h2 class="cd-section-title">Frequently Asked</h2>
    <div class="faq-wrap">
      <?php foreach ($FAQS as $faq): ?>
      <div class="faq-item">
        <div class="faq-question">
          <?= htmlspecialchars($faq['q']) ?>
          <svg class="faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 12 15 18 9"/>
          </svg>
        </div>
        <div class="faq-answer"><?= htmlspecialchars($faq['a']) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- RECOMMENDED IIMs -->
  <section class="cd-section reveal">
    <h2 class="cd-section-title" style="font-size:1.75rem;">Recommended IIMs</h2>
    <div class="colleges-grid">
      <?php foreach ($recommended as $index => $college): ?>
        <div class="reveal" style="transition-delay:<?= $index * 0.06 ?>s">
          <?php include '../components/CollegeCard.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- FINAL CTA -->
  <div class="cd-final-cta reveal">
    <h3 class="cd-cta-title">Ready to apply to <?= htmlspecialchars($c['short'] ?? $c['name']) ?>?</h3>
    <p class="cd-cta-sub">Free counselling with IIM alumni.</p>
    <button class="btn btn-hero btn-lg" style="margin-top:1.5rem" onclick="openModal('apply-modal')">Apply Now</button>
  </div>

</div><!-- /cd-main -->

<!-- ── Placement Chart JS (Chart.js via CDN) ── -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function () {
  /* Data injected from PHP */
  var trendData  = <?= json_encode(array_values($c['placementsByYear'] ?? [])) ?>;
  var distData   = <?= json_encode(array_values($c['salaryDist']       ?? [])) ?>;

  var isDark = document.documentElement.classList.contains('dark');
  var gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
  var labelColor = isDark ? '#94a3b8' : '#64748b';

  /* Trend chart */
  if (trendData.length) {
    new Chart(document.getElementById('chart-trend'), {
      type: 'bar',
      data: {
        labels: trendData.map(function(d){ return d.year; }),
        datasets: [{
          label: 'Avg (₹L)',
          data: trendData.map(function(d){ return d.avg; }),
          backgroundColor: 'oklch(0.72 0.19 50)',
          borderRadius: 8,
        }]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(ctx){ return '₹' + ctx.raw + 'L'; } } } },
        scales: {
          x: { grid: { color: gridColor }, ticks: { color: labelColor } },
          y: { grid: { color: gridColor }, ticks: { color: labelColor, callback: function(v){ return '₹'+v+'L'; } } }
        }
      }
    });
  }

  /* Distribution chart */
  if (distData.length) {
    var barColors = ['oklch(0.36 0.08 255)','oklch(0.5 0.1 255)','oklch(0.72 0.19 50)','oklch(0.78 0.16 60)'];
    new Chart(document.getElementById('chart-dist'), {
      type: 'bar',
      data: {
        labels: distData.map(function(d){ return d.range; }),
        datasets: [{
          label: '% of students',
          data: distData.map(function(d){ return d.pct; }),
          backgroundColor: distData.map(function(_,i){ return barColors[i % barColors.length]; }),
          borderRadius: 8,
        }]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(ctx){ return ctx.raw + '%'; } } } },
        scales: {
          x: { grid: { color: gridColor }, ticks: { color: labelColor } },
          y: { grid: { color: gridColor }, ticks: { color: labelColor, callback: function(v){ return v+'%'; } } }
        }
      }
    });
  }

  /* Sticky tab highlighting on scroll */
  var sections = document.querySelectorAll('.cd-section[id]');
  function onScroll() {
    var scrollY = window.scrollY + 120;
    sections.forEach(function(sec) {
      var tab = document.getElementById('tab-' + sec.id);
      if (!tab) return;
      var top = sec.offsetTop, bot = top + sec.offsetHeight;
      tab.classList.toggle('active', scrollY >= top && scrollY < bot);
    });
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* Wishlist toggle */
  var wishlisted = false;
  window.toggleWishlist = function () {
    wishlisted = !wishlisted;
    var icon = document.getElementById('wish-icon');
    var btn  = document.getElementById('wish-btn');
    icon.setAttribute('fill', wishlisted ? 'var(--accent, #f97316)' : 'none');
    icon.setAttribute('stroke', wishlisted ? 'var(--accent, #f97316)' : 'currentColor');
    btn.style.borderColor = wishlisted ? 'var(--accent, #f97316)' : '';
    if (typeof showToast === 'function') showToast(wishlisted ? 'Added to wishlist' : 'Removed from wishlist', 'success');
  };
/* Compare add */
window.addToCompare = function(slug) {
  fetch('../actions/toggle-compare.php?slug=' + encodeURIComponent(slug))
    .then(res => res.json())
    .then(data => {

      if (typeof showToast === 'function') {
        showToast(data.message, data.success ? 'success' : 'error');
      }

      /* Navbar compare count update */
      var compareCount = document.getElementById('compare-count');
      if (compareCount) {
        compareCount.textContent = data.count;
        compareCount.style.display = data.count > 0 ? 'flex' : 'none';
      }

      /* Optional redirect */
      // window.location.href = 'compare.php';
    });
};
  /* Tab click */
  window.setTab = function(name) {
    document.querySelectorAll('.cd-tab').forEach(function(t){ t.classList.remove('active'); });
    var tab = document.getElementById('tab-' + name);
    if (tab) tab.classList.add('active');
  };
})();
</script>

<?php
    /* ── styles injected once for detail page ── */
?>
<style>
/* ── College Detail Hero ── */
.cd-hero { position:relative; height:60vh; min-height:420px; overflow:hidden; }
.cd-hero-img { position:absolute; inset:0; width:100%; height:100%; object-fit:contain; }
.cd-hero-overlay { position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,.75) 0%, rgba(0,0,0,.35) 60%, transparent 100%); }
.cd-hero-content { position:relative; height:100%; max-width:88rem; margin:0 auto; padding:0 4.5rem; display:flex; flex-direction:column; justify-content:flex-end; padding-bottom:3rem; color:#fff; }
.cd-rank-badge { display:inline-flex; align-items:center; gap:.4rem; background:rgba(255,255,255,.15); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,.2); border-radius:9999px; padding:.3rem .85rem; font-size:.7rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; width:fit-content; }
.cd-rank-badge svg{
  color: #ea580c;
}
.cd-hero-title {font-size: 3rem; font-weight:600; margin-top:1rem; line-height:1.1; }
.cd-hero-meta { display:flex; flex-wrap:wrap; gap:1rem; margin-top:.15rem; color:rgba(255,255,255,.85); font-size:.85rem; }
.cd-hero-meta span { display:flex; align-items:center; gap:.3rem; }
.cd-hero-actions { display:flex; flex-wrap:wrap; gap:.75rem; margin-top:1.5rem; align-items:center; }
.cd-outline-btn { background:rgba(255,255,255,.12); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,.3); color:#fff; display:inline-flex; align-items:center; gap:.45rem; }
.cd-outline-btn:hover { background:#fff; color:var(--navy,#0f2167); }
.cd-icon-btn { width:2.75rem; height:2.75rem; border-radius:50%; background:rgba(255,255,255,.12); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,.3); color:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background .2s,color .2s,border-color .2s; }
.cd-icon-btn:hover { background:#fff; color:var(--navy,#0f2167); }

/* ── Sticky Tabs ── */
.cd-tabs-bar { position:sticky; top:4rem; z-index:30; background:rgba(var(--background-rgb,255,255,255),.95); backdrop-filter:blur(12px); border-bottom:1px solid var(--border,#e5e7eb); }
.cd-tabs-inner { max-width:88rem; margin:0 auto; padding:0 1.5rem; display:flex; gap:.25rem; overflow-x:auto; scrollbar-width:none;width:83rem }
.cd-tabs-inner::-webkit-scrollbar { display:none; }
.cd-tab { padding:1rem; font-size:.875rem; font-weight:500; white-space:nowrap; border-bottom:2px solid transparent; color:var(--muted-foreground,#64748b); text-decoration:none; transition:color .2s, border-color .2s; }
.cd-tab:hover { color:var(--foreground,#0f172a); }
.cd-tab.active { border-bottom-color:var(--accent,#f97316); color:var(--accent,#f97316); }

/* ── Main layout ── */
.cd-main { max-width:88rem; margin:0 auto; padding:3rem 1.5rem; display:flex; flex-direction:column; gap:4rem; }
.cd-section { scroll-margin-top:8rem; }
.cd-section-title { font-size:clamp(1.5rem,4vw,2.25rem); font-weight:800; margin-bottom:1.5rem; }
.cd-lead { font-size:1.05rem; color:var(--muted-foreground,#64748b); line-height:1.8; }

/* ── Stats grid ── */
.cd-stats-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:1rem; margin-top:2rem; }
.cd-stat-card { border:1px solid var(--border,#e5e7eb); border-radius:1rem; padding:1.25rem; background:var(--card,#fff); }
.cd-stat-label { font-size:.7rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted-foreground,#64748b); font-weight:600; }
.cd-stat-value { font-size:1.5rem; font-weight:800; margin-top:.25rem; }

/* ── Courses grid ── */
.cd-courses-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:1rem; }
.cd-course-card { border:1px solid var(--border,#e5e7eb); border-radius:1rem; padding:1.25rem; background:var(--card,#fff); }
.cd-course-name { font-weight:700; font-size:1.05rem; margin-bottom:.75rem; }
.cd-course-meta-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; font-size:.875rem; }
.cd-meta-label { font-size:.7rem; color:var(--muted-foreground,#64748b); margin-bottom:.1rem; }
.cd-meta-val { font-weight:600; }

/* ── Admissions ── */
.cd-admit-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:1rem; }
.cd-admit-card { border:1px solid var(--border,#e5e7eb); border-radius:1rem; padding:1.25rem; background:var(--card,#fff); }
.cd-admit-step-title { font-weight:700; margin-bottom:.5rem; }
.cd-admit-desc { font-size:.875rem; color:var(--muted-foreground,#64748b); }

/* ── Charts ── */
.cd-charts-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:1.5rem; }
.cd-chart-card { border:1px solid var(--border,#e5e7eb); border-radius:1rem; padding:1.25rem; background:var(--card,#fff); }
.cd-chart-title { font-weight:700; margin-bottom:1rem; font-size:.95rem; }
.cd-chart-wrap { height:260px; position:relative; }
.cd-sub-title { font-weight:700; margin-bottom:.75rem; }

/* ── Recruiters ── */
.cd-recruiters { margin-top:1.5rem; }
.cd-recruiter-chips { display:flex; flex-wrap:wrap; gap:.5rem; }
.cd-chip { background:var(--secondary,#f1f5f9); border-radius:9999px; padding:.35rem .85rem; font-size:.8rem; font-weight:500; }

/* ── Fees ── */
.cd-fees-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:1.5rem; }
.cd-fees-card { border:1px solid var(--border,#e5e7eb); border-radius:1rem; padding:1.5rem; background:var(--card,#fff); }
.cd-fee-list { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:.6rem; font-size:.9rem; }
.cd-fee-row { display:flex; justify-content:space-between; }
.cd-fee-amt { font-weight:600; }
.cd-scholarship-list { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:.5rem; font-size:.875rem; color:var(--muted-foreground,#64748b); }

/* ── Reviews ── */
.cd-reviews-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:1rem; }
.cd-review-card { border:1px solid var(--border,#e5e7eb); border-radius:1rem; padding:1.25rem; background:var(--card,#fff); }
.cd-review-stars { display:flex; align-items:center; gap:.2rem; margin-bottom:.6rem; }
.cd-verified-badge { font-size:.65rem; font-weight:700; padding:.15rem .5rem; border-radius:9999px; background:rgba(16,185,129,.1); color:#10b981; margin-left:.5rem; }
.cd-review-quote { font-size:.875rem; line-height:1.7; }
.cd-review-author { display:flex; align-items:center; gap:.75rem; margin-top:.85rem; }
.cd-review-avatar { width:2.5rem; height:2.5rem; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1rem; color:#fff; }
.cd-review-avatar-img { width:2.5rem; height:2.5rem; border-radius:50%; object-fit:cover; flex-shrink:0; }
.cd-review-name { font-weight:600; font-size:.875rem; }
.cd-review-role { font-size:.75rem; color:var(--muted-foreground,#64748b); }

/* ── Final CTA ── */
.cd-final-cta { border-radius:1.5rem; padding:3.5rem 2rem; text-align:center; background:var(--gradient-hero, linear-gradient(135deg,#0f2167,#1a3a8f)); color:#fff; }
.cd-cta-title { font-size:clamp(1.5rem,4vw,2.25rem); font-weight:800; }
.cd-cta-sub { color:rgba(255,255,255,.75); margin-top:.5rem; }
</style>

<?php
    include '../components/Modals.php';
    include '../components/Footer.php';
    include '../includes/footer.php';
    exit;
}

/* ══════════════════════════════════════════════════════════════════════
   LIST VIEW  ←→  colleges.index.tsx (CollegesList)
   ══════════════════════════════════════════════════════════════════════ */

$q            = trim($_GET['q']          ?? '');
$selCats      = (array)($_GET['cats']    ?? []);
$selExams     = (array)($_GET['exams']   ?? []);
$feeMin       = (int)($_GET['fee_min']   ?? 0);
$feeMax       = (int)($_GET['fee_max']   ?? 30);
$minPlacement = (int)($_GET['placement'] ?? 0);
$minRating    = (float)($_GET['rating']  ?? 0);
$sortBy       = trim($_GET['sort']       ?? 'ranking');
$perPage      = 10;
$currentPage  = max(1, (int)($_GET['page'] ?? 1));

$CATS  = ['Management','Finance','Marketing','HR','Operations','Business Analytics','International Business'];
$EXAMS = ['CAT','GMAT','IPMAT'];

/* Active filter count */
$activeCount = count($selCats) + count($selExams)
             + ($feeMin > 0 ? 1 : 0)
             + ($feeMax < 30 ? 1 : 0)
             + ($minPlacement > 0 ? 1 : 0)
             + ($minRating > 0 ? 1 : 0);

/* ── Filter logic ── */
$filtered = array_values(array_filter($COLLEGES, function($c) use ($q,$selCats,$selExams,$feeMin,$feeMax,$minPlacement,$minRating) {
  if ($q && stripos($c['name'],$q)===false && stripos($c['location'],$q)===false) return false;
  if (!empty($selCats)  && !array_intersect($selCats,  $c['category'])) return false;
  if (!empty($selExams) && !array_intersect($selExams, $c['exams']))    return false;
  if ($c['fees']      < $feeMin)       return false;
  if ($c['fees']      > $feeMax)       return false;
  if ($c['placement'] < $minPlacement) return false;
  if ($c['rating']    < $minRating)    return false;
  return true;
}));

/* ── Sort logic ── */
usort($filtered, function($a, $b) use ($sortBy) {
  switch ($sortBy) {
    case 'fees_asc':    return $a['fees']      <=> $b['fees'];
    case 'fees_desc':   return $b['fees']      <=> $a['fees'];
    case 'placement':   return $b['placement'] <=> $a['placement'];
    case 'location':    return strcmp($a['location'], $b['location']);
    default:            return ($a['ranking'] ?? 999) <=> ($b['ranking'] ?? 999);
  }
});

/* ── Pagination ── */
$totalFiltered = count($filtered);
$totalPages    = max(1, (int)ceil($totalFiltered / $perPage));
$currentPage   = min($currentPage, $totalPages);
$offset        = ($currentPage - 1) * $perPage;
$pageItems     = array_slice($filtered, $offset, $perPage);

/* Build query string helper */
function buildUrl(array $overrides): string {
  $params = array_merge([
    'q'         => $_GET['q']         ?? '',
    'cats'      => $_GET['cats']      ?? [],
    'exams'     => $_GET['exams']     ?? [],
    'fee_min'   => $_GET['fee_min']   ?? 0,
    'fee_max'   => $_GET['fee_max']   ?? 30,
    'placement' => $_GET['placement'] ?? 0,
    'rating'    => $_GET['rating']    ?? 0,
    'sort'      => $_GET['sort']      ?? 'ranking',
    'page'      => $_GET['page']      ?? 1,
  ], $overrides);
  $params = array_filter($params, fn($v) => $v !== '' && $v !== 0 && $v !== '0' && $v !== [] && $v !== null);
  return 'colleges.php?' . http_build_query($params);
}

$page_title       = 'All IIMs — Compare 14 Indian Institutes of Management';
$page_description = 'Browse all 14 IIMs by fees, placements, ranking, location and entrance exams.';
$current_page     = 'colleges';

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- =====================================================================
     COLLEGES LIST PAGE  ←→  colleges.index.tsx
     ===================================================================== -->

<div class="bs">
  <!-- HERO -->
  <section class="c-hero">
    <div class="container position-relative" style="z-index:1;">
      <h1 class="text-white fw-bold">Discover all <span>IIMs</span></h1>
      <p class="text-light">Verified data on rankings, fees, placements and reviews — all IIMs in one place.</p>
      <div class="c-hero-btns">
        <button class="c-btn-send" onclick="openApplyModal()">
          <i class="bi bi-send-fill"></i> Apply Now
        </button>
        <a href="contact.php" class="c-btn-outline">
          <i class="bi bi-chat-dots"></i> Contact Us
        </a>
      </div>
      <!-- Search bar -->
      <div class="cl-search-wrap">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="cl-search-icon" width="20" height="20">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input
          type="text"
          id="cl-search"
          value="<?= htmlspecialchars($q) ?>"
          placeholder="Search IIM by name or city"
          class="cl-search-input"
          autocomplete="off"
        />
      </div>
    </div>
  </section>
</div>

<!-- ── Layout: sidebar + grid ── -->
<section class="cl-layout-section">
  <div class="cl-container">
    <div class="cl-layout">

      <!-- ── Sidebar (desktop only) ── -->
      <aside class="cl-sidebar" id="cl-sidebar">
        <div class="cl-filter-card">
          <div class="cl-filter-header">
            <span class="cl-filter-title">
              Filters
              <?php if ($activeCount > 0): ?>
              <span class="cl-filter-badge"><?= $activeCount ?></span>
              <?php endif; ?>
            </span>
          </div>
          <?php /* Sidebar filter form — shared markup reused in mobile drawer too */ ?>
          <form method="GET" action="colleges.php" id="filter-form">
            <input type="hidden" name="q"    id="fq"    value="<?= htmlspecialchars($q) ?>">
            <input type="hidden" name="sort" id="fsort" value="<?= htmlspecialchars($sortBy) ?>">
            <input type="hidden" name="page" value="1">

            <!-- Course Type -->
            <div class="cl-fg">
              <div class="cl-fg-label">Course Type</div>
              <div class="cl-chips">
                <?php foreach ($CATS as $cat): $active = in_array($cat,$selCats); ?>
                <label class="cl-chip <?= $active?'cl-chip-active':'' ?>">
                  <input type="checkbox" name="cats[]" value="<?= htmlspecialchars($cat) ?>"
                    <?= $active?'checked':'' ?> style="display:none"
                    onchange="this.closest('label').classList.toggle('cl-chip-active',this.checked);liveFilter();">
                  <?= htmlspecialchars($cat) ?>
                </label>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Entrance Exam -->
            <div class="cl-fg">
              <div class="cl-fg-label">Entrance Exam</div>
              <div class="cl-chips">
                <?php foreach ($EXAMS as $ex): $active = in_array($ex,$selExams); ?>
                <label class="cl-chip <?= $active?'cl-chip-active':'' ?>">
                  <input type="checkbox" name="exams[]" value="<?= htmlspecialchars($ex) ?>"
                    <?= $active?'checked':'' ?> style="display:none"
                    onchange="this.closest('label').classList.toggle('cl-chip-active',this.checked);liveFilter();">
                  <?= htmlspecialchars($ex) ?>
                </label>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Budget / Fee Range -->
            <div class="cl-fg">
              <div class="cl-fg-label">
                Budget (Fees)
                <span style="font-weight:700;color:var(--accent,#f97316);">
                  ₹<span id="fee-min-lbl"><?= $feeMin ?></span>L – ₹<span id="fee-max-lbl"><?= $feeMax ?></span>L
                </span>
              </div>
              <div style="margin-bottom:.35rem;">
                <span style="font-size:.7rem;color:var(--muted-foreground,#64748b);">Min</span>
                <input type="range" name="fee_min" id="fee-min-range" min="0" max="30" value="<?= $feeMin ?>" class="cl-range"
                  oninput="
                    var mn=parseInt(this.value),mx=parseInt(document.getElementById('fee-max-range').value);
                    if(mn>mx){this.value=mx;mn=mx;}
                    document.getElementById('fee-min-lbl').textContent=mn;
                    liveFilter();">
              </div>
              <div>
                <span style="font-size:.7rem;color:var(--muted-foreground,#64748b);">Max</span>
                <input type="range" name="fee_max" id="fee-max-range" min="0" max="30" value="<?= $feeMax ?>" class="cl-range"
                  oninput="
                    var mx=parseInt(this.value),mn=parseInt(document.getElementById('fee-min-range').value);
                    if(mx<mn){this.value=mn;mx=mn;}
                    document.getElementById('fee-max-lbl').textContent=mx;
                    liveFilter();">
              </div>
              <div style="display:flex;flex-wrap:wrap;gap:.35rem;margin-top:.5rem;">
                <button type="button" class="cl-chip" style="font-size:.7rem;" onclick="setFeePreset(0,15)">Under ₹15L</button>
                <button type="button" class="cl-chip" style="font-size:.7rem;" onclick="setFeePreset(15,25)">₹15–25L</button>
                <button type="button" class="cl-chip" style="font-size:.7rem;" onclick="setFeePreset(25,30)">₹25L+</button>
              </div>
            </div>

            <a href="colleges.php" class="btn btn-outline cl-reset-btn">Reset filters</a>
          </form>
        </div>
      </aside>

      <!-- ── Main grid ── -->
      <div class="cl-main">
        <div class="cl-main-header">
          <div class="cl-count" id="cl-count">
            <?= $totalFiltered ?> IIMs found
            <?php if ($totalPages > 1): ?>
            <span style="color:var(--muted-foreground,#94a3b8);font-size:.8rem;margin-left:.4rem;">
              (Page <?= $currentPage ?> of <?= $totalPages ?>)
            </span>
            <?php endif; ?>
          </div>

          <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;">
            <!-- Sort dropdown -->
            <div class="cl-sort-wrap">
              <label for="cl-sort" class="cl-sort-label">Sort by:</label>
              <select id="cl-sort" class="cl-sort-select" onchange="applySort(this.value)">
                <option value="ranking"   <?= $sortBy==='ranking'   ?'selected':'' ?>>NIRF Ranking</option>
                <option value="fees_asc"  <?= $sortBy==='fees_asc'  ?'selected':'' ?>>Fees: Low → High</option>
                <option value="fees_desc" <?= $sortBy==='fees_desc' ?'selected':'' ?>>Fees: High → Low</option>
                <option value="placement" <?= $sortBy==='placement' ?'selected':'' ?>>Best Placement</option>
                <option value="location"  <?= $sortBy==='location'  ?'selected':'' ?>>Location (A–Z)</option>
              </select>
            </div>

            <!-- Mobile filter toggle button (attractive, mobile only) -->
            <button class="cl-mobile-filter-btn" id="cl-filter-toggle-btn" onclick="toggleMobileFilter()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                <line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/>
              </svg>
              Filters<?php if ($activeCount > 0): ?><span class="cl-mob-filter-badge"><?= $activeCount ?></span><?php endif; ?>
            </button>
          </div>
        </div>

        <!-- ── Mobile Filter Drawer (visible only on mobile, toggled by button) ── -->
        <div class="cl-mobile-filter" id="cl-mobile-filter">
          <div class="cl-mobile-filter-inner">
            <div class="cl-mobile-filter-top">
              <span class="cl-filter-title">
                Filters
                <?php if ($activeCount > 0): ?>
                <span class="cl-filter-badge"><?= $activeCount ?></span>
                <?php endif; ?>
              </span>
              <button type="button" class="cl-mobile-filter-close" onclick="toggleMobileFilter()" aria-label="Close filters">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                  <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
              </button>
            </div>

            <!-- Mobile filter form (mirrors sidebar form) -->
            <form method="GET" action="colleges.php" id="mobile-filter-form">
              <input type="hidden" name="q"    value="<?= htmlspecialchars($q) ?>">
              <input type="hidden" name="sort" value="<?= htmlspecialchars($sortBy) ?>">
              <input type="hidden" name="page" value="1">

              <!-- Course Type -->
              <div class="cl-fg">
                <div class="cl-fg-label">Course Type</div>
                <div class="cl-chips">
                  <?php foreach ($CATS as $cat): $active = in_array($cat,$selCats); ?>
                  <label class="cl-chip <?= $active?'cl-chip-active':'' ?>">
                    <input type="checkbox" name="cats[]" value="<?= htmlspecialchars($cat) ?>"
                      <?= $active?'checked':'' ?> style="display:none"
                      onchange="this.closest('label').classList.toggle('cl-chip-active',this.checked);">
                    <?= htmlspecialchars($cat) ?>
                  </label>
                  <?php endforeach; ?>
                </div>
              </div>

              <!-- Entrance Exam -->
              <div class="cl-fg">
                <div class="cl-fg-label">Entrance Exam</div>
                <div class="cl-chips">
                  <?php foreach ($EXAMS as $ex): $active = in_array($ex,$selExams); ?>
                  <label class="cl-chip <?= $active?'cl-chip-active':'' ?>">
                    <input type="checkbox" name="exams[]" value="<?= htmlspecialchars($ex) ?>"
                      <?= $active?'checked':'' ?> style="display:none"
                      onchange="this.closest('label').classList.toggle('cl-chip-active',this.checked);">
                    <?= htmlspecialchars($ex) ?>
                  </label>
                  <?php endforeach; ?>
                </div>
              </div>

              <!-- Budget / Fee Range -->
              <div class="cl-fg">
                <div class="cl-fg-label">
                  Budget (Fees)
                  <span style="font-weight:700;color:var(--accent,#f97316);">
                    ₹<span id="m-fee-min-lbl"><?= $feeMin ?></span>L – ₹<span id="m-fee-max-lbl"><?= $feeMax ?></span>L
                  </span>
                </div>
                <div style="margin-bottom:.35rem;">
                  <span style="font-size:.7rem;color:var(--muted-foreground,#64748b);">Min</span>
                  <input type="range" name="fee_min" id="m-fee-min-range" min="0" max="30" value="<?= $feeMin ?>" class="cl-range"
                    oninput="
                      var mn=parseInt(this.value),mx=parseInt(document.getElementById('m-fee-max-range').value);
                      if(mn>mx){this.value=mx;mn=mx;}
                      document.getElementById('m-fee-min-lbl').textContent=mn;">
                </div>
                <div>
                  <span style="font-size:.7rem;color:var(--muted-foreground,#64748b);">Max</span>
                  <input type="range" name="fee_max" id="m-fee-max-range" min="0" max="30" value="<?= $feeMax ?>" class="cl-range"
                    oninput="
                      var mx=parseInt(this.value),mn=parseInt(document.getElementById('m-fee-min-range').value);
                      if(mx<mn){this.value=mn;mx=mn;}
                      document.getElementById('m-fee-max-lbl').textContent=mx;">
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:.35rem;margin-top:.5rem;">
                  <button type="button" class="cl-chip" style="font-size:.7rem;" onclick="setMobileFeePreset(0,15)">Under ₹15L</button>
                  <button type="button" class="cl-chip" style="font-size:.7rem;" onclick="setMobileFeePreset(15,25)">₹15–25L</button>
                  <button type="button" class="cl-chip" style="font-size:.7rem;" onclick="setMobileFeePreset(25,30)">₹25L+</button>
                </div>
              </div>

              <div class="cl-mobile-filter-actions">
                <a href="colleges.php" class="btn btn-outline" style="flex:1;text-align:center;">Reset</a>
                <button type="submit" class="btn btn-hero" style="flex:1;">Apply Filters</button>
              </div>
            </form>
          </div>
        </div>
        <!-- ── End Mobile Filter Drawer ── -->

        <!-- Cards grid -->
        <?php if (empty($pageItems)): ?>
          <div class="cl-empty">
            <p style="color:var(--muted-foreground)">No IIMs match these filters.</p>
            <a href="colleges.php" class="btn btn-outline" style="margin-top:1rem;display:inline-flex">Reset</a>
          </div>
        <?php else: ?>
          <div class="colleges-grid" id="cl-grid">
            <?php foreach ($pageItems as $index => $college): ?>
              <div class="cl-card-wrap reveal" style="transition-delay:<?= $index * 0.06 ?>s"
                   data-name="<?= strtolower(htmlspecialchars($college['name'])) ?>"
                   data-loc="<?= strtolower(htmlspecialchars($college['location'])) ?>"
                   data-fees="<?= (int)$college['fees'] ?>"
                   data-placement="<?= (int)$college['placement'] ?>"
                   data-rating="<?= (float)$college['rating'] ?>"
                   data-cats="<?= strtolower(htmlspecialchars(implode(',', $college['category']))) ?>"
                   data-exams="<?= strtolower(htmlspecialchars(implode(',', $college['exams']))) ?>">
                <?php include '../components/CollegeCard.php'; ?>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- ── Pagination ── -->
          <?php if ($totalPages > 1): ?>
          <nav class="cl-pagination" aria-label="Colleges pagination">
            <?php
            if ($currentPage > 1):
              echo '<a href="' . htmlspecialchars(buildUrl(['page' => $currentPage - 1])) . '" class="cl-page-btn cl-page-prev" aria-label="Previous page">';
              echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="15 18 9 12 15 6"/></svg>';
              echo 'Prev</a>';
            else:
              echo '<span class="cl-page-btn cl-page-disabled"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="15 18 9 12 15 6"/></svg>Prev</span>';
            endif;

            $startP = max(1, $currentPage - 2);
            $endP   = min($totalPages, $currentPage + 2);
            if ($startP > 1) echo '<span class="cl-page-ellipsis">…</span>';
            for ($p = $startP; $p <= $endP; $p++):
              $isCur = ($p === $currentPage);
              echo '<a href="' . htmlspecialchars(buildUrl(['page' => $p])) . '" class="cl-page-btn cl-page-num' . ($isCur ? ' cl-page-active' : '') . '" aria-current="' . ($isCur ? 'page' : 'false') . '">' . $p . '</a>';
            endfor;
            if ($endP < $totalPages) echo '<span class="cl-page-ellipsis">…</span>';

            if ($currentPage < $totalPages):
              echo '<a href="' . htmlspecialchars(buildUrl(['page' => $currentPage + 1])) . '" class="cl-page-btn cl-page-next" aria-label="Next page">';
              echo 'Next<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="9 18 15 12 9 6"/></svg></a>';
            else:
              echo '<span class="cl-page-btn cl-page-disabled">Next<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="9 18 15 12 9 6"/></svg></span>';
            endif;
            ?>
          </nav>
          <?php endif; ?>

        <?php endif; ?>
      </div><!-- /cl-main -->

    </div>
  </div>
</section>

<!-- ============================================================
     FINAL CTA
     ============================================================ -->
<section class="py-3">
  <div class="container">
    <div class="cta-pro position-relative overflow-hidden rounded-5 p-4 p-lg-5">
      <div class="cta-glow"></div>
      <div class="row align-items-center g-4 position-relative" style="z-index:2;">
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
          <button class="button-cta bg-transparent px-4 py-2" onclick="openApplyModal()">Apply</button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Styles ── -->
<style>
/* ── Design variables ── */
.bs { font-family: var(--font-sans, sans-serif); }

/* ── Hero ── */
.bs .c-hero {
  background: linear-gradient(135deg, #1a2340 0%, #2d3d6b 100%);
  min-height: 30rem;
  display: flex;
  align-items: center;
  position: relative;
  padding: 6rem 0 3rem;
}
.bs .c-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  pointer-events: none;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
}
.bs .c-hero h1 span { color: #f97316; }
.bs .c-hero p { font-size: 1rem; max-width: 500px; }

/* ── Hero CTA buttons — fixed padding & sizing on all screens ── */
.c-hero-btns {
  display: flex;
  flex-wrap: wrap;
  gap: .75rem;
  margin-top: 1.5rem;
}
.c-btn-send {
  display: inline-flex;
  align-items: center;
  gap: .45rem;
  padding: .75rem 1.5rem;
  border-radius: .6rem;
  font-size: .95rem;
  font-weight: 600;
  color: #fff;
  border: none;
  cursor: pointer;
  background: linear-gradient(135deg, #f97316, #ea580c);
  box-shadow: 0 4px 16px rgba(249,115,22,.35);
  transition: transform .18s, box-shadow .18s;
  white-space: nowrap;
}
.c-btn-send:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(249,115,22,.45); }
.c-btn-outline {
  display: inline-flex;
  align-items: center;
  gap: .45rem;
  padding: .75rem 1.5rem;
  border-radius: .6rem;
  font-size: .95rem;
  font-weight: 600;
  color: #fff;
  border: 1.5px solid rgba(255,255,255,.5);
  background: rgba(255,255,255,.08);
  backdrop-filter: blur(8px);
  text-decoration: none;
  transition: background .18s, border-color .18s;
  white-space: nowrap;
}
.c-btn-outline:hover { background: rgba(255,255,255,.18); border-color: #fff; color: #fff; }

@media(max-width:480px){
  .c-btn-send, .c-btn-outline {
    padding: .7rem 1.2rem;
    font-size: .875rem;
    flex: 1;
    justify-content: center;
  }
}

/* ── Search ── */
.cl-search-wrap { position:relative; max-width:32rem; margin-top:2rem;   z-index: 50;
}
.cl-search-icon { position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none;   
  z-index: 2;}
.cl-search-input { width:100%; padding:.85rem 1rem .85rem 3rem; border-radius:.75rem; border:none; background:#fff; color:#0f172a; font-size:1rem; outline:none; box-shadow:0 4px 24px rgba(0,0,0,.18); box-sizing:border-box; }
.cl-search-input:focus { box-shadow:0 0 0 3px rgba(249,115,22,.35); }

/* ── Layout ── */
.cl-layout-section { padding:3rem 0 5rem; }
.cl-container { max-width:88rem; margin:0 auto; padding:0 1.5rem; }
.cl-layout { display:grid; grid-template-columns:1fr; gap:2rem; }
@media(min-width:1024px){ .cl-layout { grid-template-columns:280px 1fr; } }

/* ── Desktop Sidebar ── */
.cl-sidebar { display:none; }
@media(min-width:1024px){ .cl-sidebar { display:block; } }
.cl-filter-card { position:sticky; top:6rem; border:1px solid var(--border,#e5e7eb); border-radius:1rem; background:var(--card,#fff); padding:1.25rem; box-shadow:0 2px 12px rgba(0,0,0,.06); }
.cl-filter-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
.cl-filter-title { font-weight:700; font-size:1rem; display:flex; align-items:center; gap:.4rem; }
.cl-filter-badge { font-size:.65rem; font-weight:700; padding:.15rem .5rem; border-radius:9999px; background:var(--accent,#f97316); color:#fff; }
.cl-fg { margin-bottom:1.25rem; }
.cl-fg-label { font-size:.7rem; text-transform:uppercase; letter-spacing:.07em; color:var(--muted-foreground,#64748b); font-weight:600; margin-bottom:.5rem; display:flex; flex-direction:column; gap:.2rem; }
.cl-chips { display:flex; flex-wrap:wrap; gap:.4rem; }
.cl-chip { font-size:.75rem; padding:.35rem .8rem; border-radius:9999px; border:1px solid var(--border,#e5e7eb); cursor:pointer; transition:background .15s,color .15s,border-color .15s; user-select:none; background:transparent; }
.cl-chip:hover { border-color:rgba(249,115,22,.4); }
.cl-chip-active { background:var(--accent,#f97316); color:#fff; border-color:transparent; }
.cl-range { width:100%; accent-color:var(--accent,#f97316); }
.cl-reset-btn { width:100%; text-align:center; display:block; margin-top:.5rem; }

/* ── Sort dropdown ── */
.cl-sort-wrap { display:flex; align-items:center; gap:.4rem; }
.cl-sort-label { font-size:.75rem; color:var(--muted-foreground,#64748b); white-space:nowrap; }
.cl-sort-select { font-size:.8rem; padding:.4rem .65rem; border:1px solid var(--border,#e5e7eb); border-radius:.5rem; background:var(--card,#fff); color:var(--foreground,#0f172a); cursor:pointer; outline:none; }
.cl-sort-select:focus { border-color:var(--accent,#f97316); }

/* ── Main header ── */
.cl-main-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:.75rem; }
.cl-count { font-size:.875rem; color:var(--muted-foreground,#64748b); }

/* ── Mobile filter button — attractive gradient pill, hidden on desktop ── */
.cl-mobile-filter-btn {
  display: none; /* shown only on mobile via media query below */
  align-items: center;
  gap: .5rem;
  padding: .55rem 1.1rem;
  border-radius: 9999px;
  font-size: .85rem;
  font-weight: 700;
  color: #fff;
  border: none;
  cursor: pointer;
  background: linear-gradient(135deg, #1a2340 0%, #f97316 160%);
  box-shadow: 0 3px 12px rgba(249,115,22,.30);
  transition: transform .18s, box-shadow .18s;
  position: relative;
  letter-spacing: .01em;
}
.cl-mobile-filter-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(249,115,22,.40); }
.cl-mobile-filter-btn:active { transform: scale(.97); }

/* Badge on filter button */
.cl-mob-filter-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 1.1rem;
  height: 1.1rem;
  border-radius: 9999px;
  background: #fff;
  color: #f97316;
  font-size: .65rem;
  font-weight: 800;
  padding: 0 .25rem;
  margin-left: .1rem;
}

@media(max-width:1023px){ .cl-mobile-filter-btn { display: inline-flex; } }
@media(min-width:1024px){ .cl-mobile-filter-btn { display: none !important; } }

/* ── Mobile Filter Drawer (full-screen overlay + slide panel) ── */
.cl-mobile-filter {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 1050;
}
.cl-mobile-filter.is-open { display: block; }

/* Dark backdrop */
.cl-mobile-filter::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,.5);
  backdrop-filter: blur(3px);
  -webkit-backdrop-filter: blur(3px);
}

/* Slide-in panel */
.cl-mobile-filter-inner {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  width: min(88vw, 340px);
  background: var(--card,#fff);
  padding: 1.25rem 1.25rem 2rem;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  box-shadow: 6px 0 40px rgba(0,0,0,.22);
  display: flex;
  flex-direction: column;
  animation: cl-slideIn .24s cubic-bezier(.25,.8,.25,1) both;
}
@keyframes cl-slideIn {
  from { transform: translateX(-100%); }
  to   { transform: translateX(0); }
}

.cl-mobile-filter-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1.25rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid var(--border,#e5e7eb);
  flex-shrink: 0;
}
.cl-mobile-filter-close {
  width: 2rem;
  height: 2rem;
  border-radius: 50%;
  background: var(--secondary,#f1f5f9);
  border: none;
  cursor: pointer;
  color: var(--foreground,#0f172a);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: background .15s;
}
.cl-mobile-filter-close:hover { background: #e2e8f0; }

.cl-mobile-filter-actions {
  display: flex;
  gap: .75rem;
  margin-top: auto;
  padding-top: 1.25rem;
  border-top: 1px solid var(--border,#e5e7eb);
  flex-shrink: 0;
}
.cl-mobile-filter-actions .btn { flex:1; text-align:center; justify-content:center; }

/* ── Misc ── */
.cl-empty { text-align:center; padding:5rem 1rem; border:2px dashed var(--border,#e5e7eb); border-radius:1rem; }
.cl-card-wrap { display:block; transition:opacity .3s, transform .3s; }
.cl-card-wrap.cl-hidden { display:none; }

/* ── Pagination ── */
.cl-pagination { display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:.4rem; margin-top:2.5rem; padding-top:2rem; border-top:1px solid var(--border,#e5e7eb); }
.cl-page-btn { display:inline-flex; align-items:center; gap:.3rem; padding:.5rem .9rem; border-radius:.6rem; font-size:.875rem; font-weight:500; border:1px solid var(--border,#e5e7eb); background:var(--card,#fff); color:var(--foreground,#0f172a); text-decoration:none; transition:background .15s,border-color .15s,color .15s; cursor:pointer; }
.cl-page-btn:hover:not(.cl-page-disabled):not(.cl-page-active) { background:var(--secondary,#f1f5f9); border-color:rgba(249,115,22,.35); }
.cl-page-active { background:var(--accent,#f97316); border-color:var(--accent,#f97316); color:#fff; pointer-events:none; }
.cl-page-disabled { opacity:.38; cursor:not-allowed; pointer-events:none; border:1px solid var(--border,#e5e7eb); background:var(--card,#fff); color:var(--muted-foreground,#64748b); }
.cl-page-ellipsis { padding:.5rem .25rem; font-size:.875rem; color:var(--muted-foreground,#64748b); }
.cl-page-num { min-width:2.4rem; justify-content:center; }

/* ── Responsive tweaks ── */
@media(max-width:640px){
  .cl-main-header { flex-direction:column; align-items:flex-start; }
  .cl-sort-wrap { width:100%; }
  .cl-sort-select { flex:1; width:100%; }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {

  /* =========================
     MOBILE FILTER DRAWER
  ========================== */

  const drawer = document.getElementById('cl-mobile-filter');

  window.toggleMobileFilter = function () {

    if (!drawer) return;

    drawer.classList.toggle('is-open');

    if (drawer.classList.contains('is-open')) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  };

  /* Close on backdrop click */
  if (drawer) {
    drawer.addEventListener('click', function (e) {

      if (e.target === drawer) {
        toggleMobileFilter();
      }

    });
  }

  /* =========================
     SEARCH FILTER
  ========================== */

  const searchInput = document.getElementById('cl-search');

  function getCheckedValues(name) {

    let values = [];

    document.querySelectorAll('input[name="' + name + '"]:checked')
      .forEach(el => {
        values.push(el.value.toLowerCase());
      });

    return values;
  }

  window.liveFilter = function () {

    const cards = document.querySelectorAll('.cl-card-wrap');

    const query = searchInput
      ? searchInput.value.toLowerCase().trim()
      : '';

    const cats = getCheckedValues('cats[]');
    const exams = getCheckedValues('exams[]');

    const feeMin =
      Number(document.getElementById('fee-min-range')?.value || 0);

    const feeMax =
      Number(document.getElementById('fee-max-range')?.value || 30);

    let visible = 0;

    cards.forEach(card => {

      let show = true;

      const name = (card.dataset.name || '').toLowerCase();
      const loc = (card.dataset.loc || '').toLowerCase();

      const fees = Number(card.dataset.fees || 0);

      const cardCats =
        (card.dataset.cats || '').split(',');

      const cardExams =
        (card.dataset.exams || '').split(',');

      /* Search */
      if (
        query &&
        !name.includes(query) &&
        !loc.includes(query)
      ) {
        show = false;
      }

      /* Categories */
      if (
        cats.length &&
        !cats.some(c => cardCats.includes(c))
      ) {
        show = false;
      }

      /* Exams */
      if (
        exams.length &&
        !exams.some(e => cardExams.includes(e))
      ) {
        show = false;
      }

      /* Fees */
      if (fees < feeMin || fees > feeMax) {
        show = false;
      }

      card.style.display = show ? 'block' : 'none';

      if (show) visible++;
    });

    const count = document.getElementById('cl-count');

    if (count) {
      count.innerHTML = visible + ' IIMs found';
    }
  };

  /* Search input */
  if (searchInput) {
    searchInput.addEventListener('input', liveFilter);
  }

  /* Desktop filters */
  document.querySelectorAll(
    '#filter-form input[name="cats[]"], #filter-form input[name="exams[]"]'
  ).forEach(input => {

    input.addEventListener('change', liveFilter);

  });

  /* Desktop fee range */
  document.querySelectorAll('#filter-form .cl-range').forEach(range => {

    range.addEventListener('input', liveFilter);

  });

  /* =========================
     MOBILE FILTER AUTO APPLY
  ========================== */

  const mobileForm = document.getElementById('mobile-filter-form');

  function autoSubmitMobileFilter() {

    if (!mobileForm) return;

    setTimeout(() => {

      toggleMobileFilter();

      setTimeout(() => {
        mobileForm.submit();
      }, 200);

    }, 100);
  }

  /* Mobile checkbox filters */
  document.querySelectorAll(
    '#mobile-filter-form input[name="cats[]"], #mobile-filter-form input[name="exams[]"]'
  ).forEach(input => {

    input.addEventListener('change', function () {

      const label = this.closest('label');

      if (label) {
        label.classList.toggle('cl-chip-active', this.checked);
      }

      autoSubmitMobileFilter();
    });

  });

  /* Mobile fee range */
  document.querySelectorAll('#mobile-filter-form .cl-range').forEach(range => {

    range.addEventListener('change', autoSubmitMobileFilter);

  });

  /* Desktop fee preset */
  window.setFeePreset = function(min, max) {

    const minR = document.getElementById('fee-min-range');
    const maxR = document.getElementById('fee-max-range');

    if (minR) {
      minR.value = min;
      document.getElementById('fee-min-lbl').textContent = min;
    }

    if (maxR) {
      maxR.value = max;
      document.getElementById('fee-max-lbl').textContent = max;
    }

    liveFilter();
  };

  /* Mobile fee preset */
  window.setMobileFeePreset = function(min, max) {

    const minR = document.getElementById('m-fee-min-range');
    const maxR = document.getElementById('m-fee-max-range');

    if (minR) {
      minR.value = min;
      document.getElementById('m-fee-min-lbl').textContent = min;
    }

    if (maxR) {
      maxR.value = max;
      document.getElementById('m-fee-max-lbl').textContent = max;
    }

    autoSubmitMobileFilter();
  };

});
</script>
<?php
include '../components/Modals.php';
include '../components/Footer.php';
include '../includes/footer.php';
?>