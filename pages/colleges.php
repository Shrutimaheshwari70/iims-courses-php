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
      <button class="btn btn-hero btn-lg" onclick="openModal('apply-modal')">
        Apply Now
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </button>
      <button class="btn cd-outline-btn btn-lg" onclick="showToast('Brochure download started!','success')">
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
.cd-hero-img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
.cd-hero-overlay { position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,.75) 0%, rgba(0,0,0,.35) 60%, transparent 100%); }
.cd-hero-content { position:relative; height:100%; max-width:88rem; margin:0 auto; padding:0 1.5rem; display:flex; flex-direction:column; justify-content:flex-end; padding-bottom:3rem; color:#fff; }
.cd-rank-badge { display:inline-flex; align-items:center; gap:.4rem; background:rgba(255,255,255,.15); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,.2); border-radius:9999px; padding:.3rem .85rem; font-size:.7rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; width:fit-content; }
.cd-hero-title { font-size:clamp(2rem,6vw,3.75rem); font-weight:800; margin-top:1rem; line-height:1.1; }
.cd-hero-meta { display:flex; flex-wrap:wrap; gap:1rem; margin-top:.75rem; color:rgba(255,255,255,.85); font-size:.95rem; }
.cd-hero-meta span { display:flex; align-items:center; gap:.3rem; }
.cd-hero-actions { display:flex; flex-wrap:wrap; gap:.75rem; margin-top:1.5rem; align-items:center; }
.cd-outline-btn { background:rgba(255,255,255,.12); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,.3); color:#fff; display:inline-flex; align-items:center; gap:.45rem; }
.cd-outline-btn:hover { background:#fff; color:var(--navy,#0f2167); }
.cd-icon-btn { width:2.75rem; height:2.75rem; border-radius:50%; background:rgba(255,255,255,.12); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,.3); color:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background .2s,color .2s,border-color .2s; }
.cd-icon-btn:hover { background:#fff; color:var(--navy,#0f2167); }

/* ── Sticky Tabs ── */
.cd-tabs-bar { position:sticky; top:4rem; z-index:30; background:rgba(var(--background-rgb,255,255,255),.95); backdrop-filter:blur(12px); border-bottom:1px solid var(--border,#e5e7eb); }
.cd-tabs-inner { max-width:88rem; margin:0 auto; padding:0 1.5rem; display:flex; gap:.25rem; overflow-x:auto; scrollbar-width:none; }
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
$feeRange     = (int)($_GET['fee']       ?? 30);
$minPlacement = (int)($_GET['placement'] ?? 0);
$minRating    = (float)($_GET['rating']  ?? 0);

$CATS  = ['Management','Finance','Marketing','HR','Operations','Business Analytics','International Business'];
$EXAMS = ['CAT','GMAT','IPMAT'];

/* Active filter count (mirrors React `active` variable) */
$activeCount = count($selCats) + count($selExams)
             + ($feeRange < 30 ? 1 : 0)
             + ($minPlacement > 0 ? 1 : 0)
             + ($minRating > 0 ? 1 : 0);

/* Filter logic (mirrors React useMemo) */
$filtered = array_values(array_filter($COLLEGES, function($c) use ($q,$selCats,$selExams,$feeRange,$minPlacement,$minRating) {
  if ($q && stripos($c['name'],$q)===false && stripos($c['location'],$q)===false) return false;
  if (!empty($selCats)  && !array_intersect($selCats,  $c['category'])) return false;
  if (!empty($selExams) && !array_intersect($selExams, $c['exams']))    return false;
  if ($c['fees']      > $feeRange)     return false;
  if ($c['placement'] < $minPlacement) return false;
  if ($c['rating']    < $minRating)    return false;
  return true;
}));

$page_title       = 'All IIMs — Compare 14 Indian Institutes of Management';
$page_description = 'Browse all 14 IIMs by fees, placements, ranking, location and entrance exams.';
$current_page     = 'colleges';

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- =====================================================================
     COLLEGES LIST PAGE  ←→  colleges.index.tsx
     ===================================================================== -->

<!-- ── Hero + Search ── -->
<section class="cl-hero">
  <div class="cl-hero-inner">
    <h1 class="cl-hero-title reveal">
      Discover all <span class="text-gradient-accent">14 IIMs</span>
    </h1>
    <p class="cl-hero-sub">Verified data on rankings, fees, placements and reviews — all IIMs in one place.</p>

    <!-- Search bar (live JS, mirrors React Input onChange) -->
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

<!-- ── Layout: sidebar + grid ── -->
<section class="cl-layout-section">
  <div class="cl-container">
    <div class="cl-layout">

      <!-- ── Sidebar (desktop) ── -->
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

          <!-- We use a hidden form that JS submits for server-side filtering,
               AND live JS filtering mirrors the React behaviour for instant UX. -->
          <form method="GET" action="colleges.php" id="filter-form">
            <input type="hidden" name="q" id="fq" value="<?= htmlspecialchars($q) ?>">

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

            <!-- Fee range -->
            <div class="cl-fg">
              <div class="cl-fg-label">Max Fees: ₹<span id="fee-lbl"><?= $feeRange ?></span>L</div>
              <input type="range" name="fee" id="fee-range" min="10" max="30" value="<?= $feeRange ?>" class="cl-range"
                oninput="document.getElementById('fee-lbl').textContent=this.value;liveFilter();">
            </div>

            <!-- Placement -->
            <div class="cl-fg">
              <div class="cl-fg-label">Min Placement: ₹<span id="pl-lbl"><?= $minPlacement ?></span>L</div>
              <input type="range" name="placement" id="pl-range" min="0" max="35" value="<?= $minPlacement ?>" class="cl-range"
                oninput="document.getElementById('pl-lbl').textContent=this.value;liveFilter();">
            </div>

            <!-- Rating -->
            <div class="cl-fg">
              <div class="cl-fg-label">Min Rating: <span id="rt-lbl"><?= $minRating ?></span>★</div>
              <input type="range" name="rating" id="rt-range" min="0" max="5" step="0.1" value="<?= $minRating ?>" class="cl-range"
                oninput="document.getElementById('rt-lbl').textContent=parseFloat(this.value).toFixed(1);liveFilter();">
            </div>

            <a href="colleges.php" class="btn btn-outline cl-reset-btn">Reset filters</a>
          </form>
        </div>
      </aside>

      <!-- ── Main grid ── -->
      <div class="cl-main">
        <div class="cl-main-header">
          <div class="cl-count" id="cl-count"><?= count($filtered) ?> IIMs found</div>
          <!-- Mobile filter toggle -->
          <button class="btn btn-outline btn-sm cl-mobile-filter-btn" onclick="toggleMobileFilter()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
              <line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/>
            </svg>
            Filters<?= $activeCount > 0 ? " ({$activeCount})" : '' ?>
          </button>
        </div>

        <!-- Mobile filter panel (hidden by default) -->
        <div class="cl-mobile-filter" id="cl-mobile-filter" style="display:none;">
          <!-- shares the same filter-form above via JS submit -->
          <div style="padding:1.25rem;">
            <a href="colleges.php" class="btn btn-outline btn-sm" style="display:inline-flex;margin-bottom:1rem;">Reset</a>
            <p style="font-size:.85rem;color:var(--muted-foreground);">Use the sidebar filters on desktop, or adjust below and hit <strong>Apply</strong>.</p>
            <button class="btn btn-hero btn-sm" style="margin-top:.75rem;width:100%;" onclick="document.getElementById('filter-form').submit()">Apply Filters</button>
          </div>
        </div>

        <!-- Cards grid -->
        <?php if (empty($filtered)): ?>
          <div class="cl-empty">
            <p style="color:var(--muted-foreground)">No IIMs match these filters.</p>
            <a href="colleges.php" class="btn btn-outline" style="margin-top:1rem;display:inline-flex">Reset</a>
          </div>
        <?php else: ?>
          <div class="colleges-grid" id="cl-grid">
            <?php foreach ($filtered as $index => $college): ?>
              <div class="cl-card-wrap reveal" style="transition-delay:<?= $index * 0.06 ?>s" data-name="<?= strtolower(htmlspecialchars($college['name'])) ?>" data-loc="<?= strtolower(htmlspecialchars($college['location'])) ?>" data-fees="<?= (int)$college['fees'] ?>" data-placement="<?= (int)$college['placement'] ?>" data-rating="<?= (float)$college['rating'] ?>" data-cats="<?= strtolower(htmlspecialchars(implode(',', $college['category']))) ?>" data-exams="<?= strtolower(htmlspecialchars(implode(',', $college['exams']))) ?>">
                <?php include '../components/CollegeCard.php'; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<!-- ── List Page Styles ── -->
<style>
/* Hero */
.cl-hero { background:var(--gradient-hero, linear-gradient(135deg,#0f2167 0%,#1a3a8f 100%)); padding-top:8rem; padding-bottom:5rem; }
.cl-hero-inner { max-width:88rem; margin:0 auto; padding:0 1.5rem; color:#fff; }
.cl-hero-title { font-size:clamp(2rem,6vw,3.75rem); font-weight:800; line-height:1.1; }
.cl-hero-sub { color:rgba(255,255,255,.8); margin-top:1rem; font-size:1.1rem; max-width:40rem; }
.cl-search-wrap { position:relative; max-width:32rem; margin-top:2rem; }
.cl-search-icon { position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; }
.cl-search-input { width:100%; padding:.85rem 1rem .85rem 3rem; border-radius:.75rem; border:none; background:#fff; color:#0f172a; font-size:1rem; outline:none; box-shadow:0 4px 24px rgba(0,0,0,.18); box-sizing:border-box; }
.cl-search-input:focus { box-shadow:0 0 0 3px rgba(249,115,22,.35); }

/* Layout */
.cl-layout-section { padding:3rem 0 5rem; }
.cl-container { max-width:88rem; margin:0 auto; padding:0 1.5rem; }
.cl-layout { display:grid; grid-template-columns:1fr; gap:2rem; }
@media(min-width:1024px){ .cl-layout { grid-template-columns:280px 1fr; } }

/* Sidebar */
.cl-sidebar { display:none; }
@media(min-width:1024px){ .cl-sidebar { display:block; } }
.cl-filter-card { position:sticky; top:6rem; border:1px solid var(--border,#e5e7eb); border-radius:1rem; background:var(--card,#fff); padding:1.25rem; box-shadow:0 2px 12px rgba(0,0,0,.06); }
.cl-filter-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
.cl-filter-title { font-weight:700; font-size:1rem; display:flex; align-items:center; gap:.4rem; }
.cl-filter-badge { font-size:.65rem; font-weight:700; padding:.15rem .5rem; border-radius:9999px; background:var(--accent,#f97316); color:#fff; }
.cl-fg { margin-bottom:1.25rem; }
.cl-fg-label { font-size:.7rem; text-transform:uppercase; letter-spacing:.07em; color:var(--muted-foreground,#64748b); font-weight:600; margin-bottom:.5rem; }
.cl-chips { display:flex; flex-wrap:wrap; gap:.4rem; }
.cl-chip { font-size:.75rem; padding:.35rem .8rem; border-radius:9999px; border:1px solid var(--border,#e5e7eb); cursor:pointer; transition:background .15s,color .15s,border-color .15s; user-select:none; }
.cl-chip:hover { border-color:rgba(249,115,22,.4); }
.cl-chip-active { background:var(--accent,#f97316); color:#fff; border-color:transparent; }
.cl-range { width:100%; accent-color:var(--accent,#f97316); }
.cl-reset-btn { width:100%; text-align:center; display:block; margin-top:.5rem; }

/* Main */
.cl-main-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; }
.cl-count { font-size:.875rem; color:var(--muted-foreground,#64748b); }
.cl-mobile-filter-btn { display:flex; align-items:center; gap:.4rem; }
@media(min-width:1024px){ .cl-mobile-filter-btn { display:none; } }
.cl-mobile-filter { border:1px solid var(--border,#e5e7eb); border-radius:1rem; background:var(--card,#fff); margin-bottom:1.5rem; }
.cl-empty { text-align:center; padding:5rem 1rem; border:2px dashed var(--border,#e5e7eb); border-radius:1rem; }
.cl-card-wrap { transition:opacity .3s, transform .3s; }
.cl-card-wrap.cl-hidden { display:none; }
</style>

<!-- ── Live filter JS (mirrors React useMemo) ── -->
<script>
(function () {
  var searchInput = document.getElementById('cl-search');
  var grid = document.getElementById('cl-grid');

  function getChecked(name) {
    return Array.from(document.querySelectorAll('input[name="' + name + '"]:checked')).map(function(el){ return el.value.toLowerCase(); });
  }

  window.liveFilter = function () {
    if (!grid) return;
    var q   = (searchInput ? searchInput.value : '').toLowerCase();
    var cats  = getChecked('cats[]');
    var exams = getChecked('exams[]');
    var fee   = parseInt(document.getElementById('fee-range').value, 10);
    var pl    = parseInt(document.getElementById('pl-range').value,  10);
    var rt    = parseFloat(document.getElementById('rt-range').value);

    var cards = grid.querySelectorAll('.cl-card-wrap');
    var visible = 0;
    cards.forEach(function(card) {
      var name  = card.dataset.name  || '';
      var loc   = card.dataset.loc   || '';
      var fees  = parseInt(card.dataset.fees, 10);
      var plmnt = parseInt(card.dataset.placement, 10);
      var rating = parseFloat(card.dataset.rating);
      var catsD  = card.dataset.cats  || '';
      var examsD = card.dataset.exams || '';

      var ok = true;
      if (q && name.indexOf(q) === -1 && loc.indexOf(q) === -1) ok = false;
      if (cats.length  && !cats.some(function(c){ return catsD.indexOf(c) !== -1; }))  ok = false;
      if (exams.length && !exams.some(function(e){ return examsD.indexOf(e) !== -1; })) ok = false;
      if (fees  > fee)  ok = false;
      if (plmnt < pl)   ok = false;
      if (rating < rt)  ok = false;

      card.classList.toggle('cl-hidden', !ok);
      if (ok) visible++;
    });

    var countEl = document.getElementById('cl-count');
    if (countEl) countEl.textContent = visible + ' IIMs found';
  };

  /* Sync search input → hidden form field + live filter */
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      var fq = document.getElementById('fq');
      if (fq) fq.value = this.value;
      liveFilter();
    });
  }

  /* Mobile filter toggle */
  window.toggleMobileFilter = function () {
    var panel = document.getElementById('cl-mobile-filter');
    if (panel) panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
  };
})();
window.addToCompare = function(slug) {

  fetch('../ajax/add-compare.php?slug=' + encodeURIComponent(slug))

    .then(function(res) {
      return res.json();
    })

    .then(function(data) {

      if (typeof showToast === 'function') {

        showToast(
          data.message,
          data.success ? 'success' : 'error'
        );
      }

      var badge = document.getElementById('compare-count');

      if (badge) {

        badge.innerText = data.count;

        if (data.count > 0) {
          badge.style.display = 'flex';
        }
      }

    });

};
</script>

<?php
include '../components/Modals.php';
include '../components/Footer.php';
include '../includes/footer.php';
?>