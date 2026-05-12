<?php
/**
 * index.php  ←→  src/routes/index.tsx  (Home component)
 */

session_start();
require_once 'data/iims.php';

$page_title       = 'IIMs Courses — Discover, Compare & Apply to India\'s Top IIMs';
$page_description = 'Explore all 14 IIMs, MBA & PGDM programmes, verified placements and rankings. Apply with free counselling.';
$current_page     = 'home';

include 'includes/header.php';
include 'components/Navbar.php';
?>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="hero">
  <img src="assets/images/hero-campus.jpg" alt="IIM campus at sunset" class="hero-bg" />
  <div class="hero-overlay"></div>

  <div class="hero-inner">
    <div class="fade-up" style="color:#fff">
      <span class="hero-badge">
        <span class="hero-badge-dot animate-pulse"></span>
        Admissions Open &bull; Batch 2026
      </span>

      <h1>Your future in <span class="text-gradient-accent">India's top IIMs</span> starts here.</h1>

      <p class="hero-desc">
        Discover all 14 Indian Institutes of Management with verified rankings,
        placements, fees and alumni reviews — and get free admissions counselling.
      </p>

      <div class="hero-actions">
        <button class="btn btn-hero" onclick="openModal('apply-modal')">
          Apply Now
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
        <a href="pages/colleges.php" class="btn btn-outline">Explore IIMs</a>
      </div>

      <div class="hero-social">
        <div class="hero-avatars">
          <span></span><span></span><span></span><span></span>
        </div>
        <div>
          <div class="hero-stars">
            <?php for ($i=0;$i<5;$i++): ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            <?php endfor; ?>
            <span class="score">4.9</span>
          </div>
          <div class="hero-stars sub" style="display:block;margin-top:.1rem">Trusted by 50,000+ MBA aspirants</div>
        </div>
      </div>
    </div>

    <div class="hero-right">
      <div class="floating-stat float-0">
        <div class="floating-stat-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
          </svg>
        </div>
        <div>
          <div class="floating-stat-label">Top NIRF Ranked</div>
          <div class="floating-stat-value">14 IIMs</div>
        </div>
      </div>
      <div class="floating-stat float-1">
        <div class="floating-stat-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
          </svg>
        </div>
        <div>
          <div class="floating-stat-label">Highest Placement</div>
          <div class="floating-stat-value">₹1.15 Cr</div>
        </div>
      </div>
      <div class="floating-stat float-2">
        <div class="floating-stat-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <div>
          <div class="floating-stat-label">Alumni Network</div>
          <div class="floating-stat-value">80,000+</div>
        </div>
      </div>

      <div class="cat-card">
        <div class="cat-card-label">CAT 2026</div>
        <div class="cat-card-value">Apply by Sep 13</div>
        <div class="cat-countdown">
          <div class="cat-countdown-unit">
            <div class="num" id="cd-days">132</div>
            <div class="lbl">Days</div>
          </div>
          <div class="cat-countdown-unit">
            <div class="num" id="cd-hours">06</div>
            <div class="lbl">Hrs</div>
          </div>
          <div class="cat-countdown-unit">
            <div class="num" id="cd-mins">42</div>
            <div class="lbl">Min</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="recruiters-strip">
    <div class="recruiters-track marquee">
      <?php foreach (array_merge($RECRUITERS, $RECRUITERS) as $r): ?>
        <span><?= htmlspecialchars($r) ?></span>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ============================================================
     NEWS TICKER
     ============================================================ -->
<div class="news-ticker">
  <div class="ticker-track ticker">
    <?php
    $news = [
      '🚨 CAT 2026 registrations open until September 13',
      '🎓 IIM Bangalore announces new analytics specialisation',
      '💼 IIM Calcutta final placements: avg ₹32.5L',
      '📅 IIM Indore IPMAT applications close June 5',
      '🌟 IIM Kozhikode tops gender diversity rankings',
    ];
    foreach (array_merge($news, $news) as $item):
    ?>
      <span><?= htmlspecialchars($item) ?></span>
    <?php endforeach; ?>
  </div>
</div>


<!-- ============================================================
     TOP IIMs
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <div class="section-eyebrow">Premier institutes</div>
      <h2 class="section-title">Top <span class="text-gradient-accent">IIMs</span> in India</h2>
      <p class="section-desc">Verified rankings, fees, placements and alumni reviews — all in one place.</p>
    </div>

    <div class="colleges-grid">
      <?php foreach (array_slice($COLLEGES, 0, 6) as $index => $college): ?>
        <div class="reveal" style="transition-delay:<?= $index * 0.07 ?>s">
          <?php include 'components/CollegeCard.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="colleges-cta">
      <a href="pages/colleges.php" class="btn btn-navy">
        View all 14 IIMs
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </div>
  </div>
</section>


<!-- ============================================================
     FEATURED PROGRAMMES
     ============================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-head reveal">
      <div class="section-eyebrow">Programmes</div>
      <h2 class="section-title">Featured <span class="text-gradient-accent">programmes</span></h2>
      <p class="section-desc">Choose from full-time MBA, PGDM, Executive MBA, Business Analytics and more.</p>
    </div>

    <div class="courses-grid">
      <?php foreach (array_slice($COURSES, 0, 8) as $i => $c): ?>
      <div class="course-card reveal" style="transition-delay:<?= $i * 0.05 ?>s">
        <div class="course-img">
          <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['title']) ?>" loading="lazy" />
          <div class="course-img-overlay"></div>
          <span class="course-cat"><?= htmlspecialchars($c['category']) ?></span>
          <span class="course-meta">₹<?= $c['fees'] ?>L &bull; <?= htmlspecialchars($c['duration']) ?></span>
        </div>
        <div class="course-body">
          <h4 class="course-title"><?= htmlspecialchars($c['title']) ?></h4>
          <p class="course-desc"><?= htmlspecialchars($c['description']) ?></p>
          <div class="course-footer">
            <span class="course-iims"><?= count($c['iims']) ?> IIMs</span>
            <a href="pages/course-details.php?slug=<?= $c['slug'] ?>" class="course-link">
              Explore
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ============================================================
     ACHIEVEMENTS
     ============================================================ -->
<section class="achievements-section">
  <div class="container">
    <div class="achievements-grid">
      <?php
      $stats = [
        ['value'=>14,    'label'=>'IIMs Covered',     'suffix'=>'',  'icon'=>'graduation'],
        ['value'=>50000, 'label'=>'Aspirants Helped', 'suffix'=>'+', 'icon'=>'users'],
        ['value'=>80000, 'label'=>'Alumni Network',   'suffix'=>'+', 'icon'=>'briefcase'],
        ['value'=>98,    'label'=>'Avg Placement %',  'suffix'=>'%', 'icon'=>'target'],
      ];
      $icons = [
        'graduation' => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
        'users'      => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'briefcase'  => '<rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
        'target'     => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
      ];
      foreach ($stats as $s):
      ?>
      <div class="achievement-item reveal">
        <div class="achievement-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <?= $icons[$s['icon']] ?>
          </svg>
        </div>
        <div class="achievement-value">
          <span data-counter data-to="<?= $s['value'] ?>" data-suffix="<?= $s['suffix'] ?>">0</span>
        </div>
        <div class="achievement-label"><?= htmlspecialchars($s['label']) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ============================================================
     TIMELINE
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <div class="section-eyebrow">Your journey</div>
      <h2 class="section-title">From aspirant to IIM alumnus</h2>
      <p class="section-desc">A clear, supported path — at every milestone.</p>
    </div>

    <div class="timeline-grid">
      <?php
      $steps = [
        ['title'=>'Discover','desc'=>'Explore IIMs, programmes, placements & rankings.',
         'icon'=>'<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>'],
        ['title'=>'Compare','desc'=>'Side-by-side comparison of fees, ROI, faculty.',
         'icon'=>'<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>'],
        ['title'=>'Apply','desc'=>'Apply through our guided counselling.',
         'icon'=>'<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
        ['title'=>'Succeed','desc'=>'Crack CAT, ace WAT-PI, land your dream offer.',
         'icon'=>'<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>'],
      ];
      foreach ($steps as $i => $step):
      ?>
      <div class="timeline-item reveal" style="transition-delay:<?= $i * 0.1 ?>s">
        <div class="timeline-icon-wrap">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <?= $step['icon'] ?>
          </svg>
          <div class="timeline-num"><?= $i + 1 ?></div>
        </div>
        <h4 class="timeline-title"><?= htmlspecialchars($step['title']) ?></h4>
        <p class="timeline-desc"><?= htmlspecialchars($step['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ============================================================
     TESTIMONIALS  — FIXED (images + working slider)
     ============================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-head reveal">
      <div class="section-eyebrow">Stories</div>
      <h1 class="section-title">Loved by <span class="text-gradient-accent">aspirants &amp; alumni</span></h1>
    </div>

    <?php
    /*
     * Fallback avatar colours — used as background when no photo is available,
     * same as React (initials inside a coloured circle).
     * If your $TESTIMONIALS array has an 'image' key, the <img> is shown instead.
     */
    $avatarColors = ['#6366f1','#0ea5e9','#10b981','#f59e0b','#ef4444','#8b5cf6'];
    ?>

    <div class="testimonial-wrap" id="testimonial-wrap">

      <?php foreach ($TESTIMONIALS as $ti => $t):
        $color  = $avatarColors[$ti % count($avatarColors)];
        $initials = mb_strtoupper(mb_substr(trim($t['name']), 0, 1));
        $isFirst  = ($ti === 0);
      ?>
      <div
        class="testimonial-slide<?= $isFirst ? ' active-slide' : '' ?>"
        id="t-slide-<?= $ti ?>"
        style="display:<?= $isFirst ? 'block' : 'none' ?>;"
      >
        <div class="testimonial-card">

          <!-- Stars -->
          <div class="testimonial-stars">
            <?php for ($s = 0; $s < (int)$t['rating']; $s++): ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="1" width="18" height="18">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            <?php endfor; ?>
          </div>

          <!-- Quote -->
          <p class="testimonial-quote">"<?= htmlspecialchars($t['quote']) ?>"</p>

          <!-- Author row: photo OR initials avatar -->
          <div class="testimonial-author">

            <?php if (!empty($t['image'])): ?>
              <!-- Real photo from data -->
              <img
                src="<?= htmlspecialchars($t['image']) ?>"
                alt="<?= htmlspecialchars($t['name']) ?>"
                class="testimonial-avatar-img"
                loading="lazy"
                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
              />
              <!-- Fallback initials (hidden unless image errors) -->
              <div
                class="testimonial-avatar"
                style="display:none;background:<?= $color ?>;color:#fff;align-items:center;justify-content:center;font-weight:700;font-size:1.1rem;"
              ><?= $initials ?></div>

            <?php else: ?>
              <!-- No image in data → show initials avatar -->
              <div
                class="testimonial-avatar"
                style="background:<?= $color ?>;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.1rem;"
              ><?= $initials ?></div>
            <?php endif; ?>

            <div>
              <div class="testimonial-name"><?= htmlspecialchars($t['name']) ?></div>
              <div class="testimonial-role"><?= htmlspecialchars($t['role']) ?></div>
            </div>
          </div><!-- /author -->

        </div><!-- /card -->
      </div><!-- /slide -->
      <?php endforeach; ?>

      <!-- Navigation -->
      <div class="testimonial-nav">
        <button class="t-nav-btn" id="t-prev" aria-label="Previous testimonial">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        </button>

        <?php foreach ($TESTIMONIALS as $ti => $t): ?>
          <button class="t-dot<?= $ti === 0 ? ' active' : '' ?>" data-index="<?= $ti ?>" aria-label="Go to testimonial <?= $ti + 1 ?>"></button>
        <?php endforeach; ?>

        <button class="t-nav-btn" id="t-next" aria-label="Next testimonial">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
      </div>

    </div><!-- /testimonial-wrap -->
  </div>
</section>

<!-- Testimonial avatar image style -->
<style>
.testimonial-avatar-img {
  width: 3rem;
  height: 3rem;
  border-radius: 50%;
  object-fit: cover;
  flex-shrink: 0;
  border: 2px solid var(--border, #e5e7eb);
}
.testimonial-avatar {
  width: 3rem;
  height: 3rem;
  border-radius: 50%;
  flex-shrink: 0;
}
.testimonial-slide { display: none; }
.testimonial-slide.active-slide { display: block; }
</style>

<!-- Testimonial slider JS — fully self-contained, no dependencies -->
<script>
(function () {
  var total   = <?= count($TESTIMONIALS) ?>;
  var current = 0;
  var autoTimer;

  function showSlide(idx) {
    /* hide all */
    for (var i = 0; i < total; i++) {
      var sl = document.getElementById('t-slide-' + i);
      if (sl) { sl.style.display = 'none'; sl.classList.remove('active-slide'); }
    }
    /* show target */
    var target = document.getElementById('t-slide-' + idx);
    if (target) { target.style.display = 'block'; target.classList.add('active-slide'); }

    /* dots */
    var dots = document.querySelectorAll('.t-dot');
    dots.forEach(function (d, i) {
      d.classList.toggle('active', i === idx);
    });

    current = idx;
  }

  function next() { showSlide((current + 1) % total); }
  function prev() { showSlide((current - 1 + total) % total); }

  /* Button listeners */
  var btnNext = document.getElementById('t-next');
  var btnPrev = document.getElementById('t-prev');
  if (btnNext) btnNext.addEventListener('click', function () { clearInterval(autoTimer); next(); startAuto(); });
  if (btnPrev) btnPrev.addEventListener('click', function () { clearInterval(autoTimer); prev(); startAuto(); });

  /* Dot listeners */
  document.querySelectorAll('.t-dot').forEach(function (dot) {
    dot.addEventListener('click', function () {
      clearInterval(autoTimer);
      showSlide(parseInt(this.getAttribute('data-index'), 10));
      startAuto();
    });
  });

  /* Auto-advance every 5 s */
  function startAuto() { autoTimer = setInterval(next, 5000); }
  startAuto();

  /* Touch / swipe support */
  var wrap = document.getElementById('testimonial-wrap');
  var startX = 0;
  if (wrap) {
    wrap.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
    wrap.addEventListener('touchend', function (e) {
      var diff = startX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 50) { clearInterval(autoTimer); diff > 0 ? next() : prev(); startAuto(); }
    }, { passive: true });
  }
})();
</script>


<!-- ============================================================
     VIDEO / WEBINAR
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <div class="section-eyebrow">Watch &amp; learn</div>
      <h2 class="section-title">Live webinars and campus tours</h2>
    </div>

    <div class="vw-grid">
      <div class="vw-video reveal">
        <img src="assets/images/students.jpg" alt="Campus Tour" loading="lazy" />
        <div class="vw-video-overlay">
          <div class="vw-play">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/>
            </svg>
          </div>
        </div>
        <div class="vw-video-info">
          <div class="eyebrow">Campus Tour</div>
          <h3>A day in the life at IIM Bangalore</h3>
        </div>
      </div>

      <div class="vw-list">
        <?php
        $webinars = [
          ['title'=>'CAT 2026 Strategy: Section-wise plan','date'=>'May 12, 7:00 PM','host'=>'By IIM-A Alumni'],
          ['title'=>'WAT-PI Masterclass with IIM toppers',  'date'=>'May 18, 6:30 PM','host'=>'Live, free'],
          ['title'=>'MBA Specialisation: Choosing wisely',  'date'=>'May 24, 7:00 PM','host'=>'Panel'],
        ];
        foreach ($webinars as $i => $w):
        ?>
        <div class="vw-item reveal" style="transition-delay:<?= $i*0.1 ?>s">
          <div class="vw-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <div style="flex:1">
            <div class="vw-title"><?= htmlspecialchars($w['title']) ?></div>
            <div class="vw-meta"><?= htmlspecialchars($w['date']) ?> &bull; <?= htmlspecialchars($w['host']) ?></div>
          </div>
          <button class="btn btn-soft btn-sm" onclick="openModal('apply-modal')">Register</button>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
     FACULTY SPOTLIGHT
     ============================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-head reveal">
      <div class="section-eyebrow">World-class minds</div>
      <h2 class="section-title">Faculty spotlight</h2>
    </div>

    <div class="faculty-grid">
      <?php
      $faculty = [
        ['name'=>'Dr. Anuja Kapoor',  'role'=>'Strategy • IIM-A'],
        ['name'=>'Prof. Rajiv Menon', 'role'=>'Finance • IIM-B'],
        ['name'=>'Dr. Meera Krishnan','role'=>'Marketing • IIM-K'],
        ['name'=>'Prof. Vikram Joshi','role'=>'Analytics • IIM-C'],
      ];
      foreach ($faculty as $i => $f):
      ?>
      <div class="faculty-card reveal" style="transition-delay:<?= $i*0.08 ?>s">
        <div class="faculty-img">
          <img src="assets/images/students.jpg" alt="<?= htmlspecialchars($f['name']) ?>" loading="lazy" />
        </div>
        <div class="faculty-info">
          <div class="faculty-name"><?= htmlspecialchars($f['name']) ?></div>
          <div class="faculty-role"><?= htmlspecialchars($f['role']) ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ============================================================
     BLOGS PREVIEW
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <div class="section-eyebrow">Insights</div>
      <h2 class="section-title">Latest from our blog</h2>
    </div>

    <div class="blogs-grid">
      <?php foreach ($BLOGS as $i => $b): ?>
      <a href="pages/blog-details.php?slug=<?= $b['slug'] ?>" class="blog-card reveal" style="transition-delay:<?= $i*0.06 ?>s">
        <div class="blog-img">
          <img src="<?= htmlspecialchars($b['image']) ?>" alt="<?= htmlspecialchars($b['title']) ?>" loading="lazy" />
        </div>
        <div class="blog-body">
          <div class="blog-meta"><?= htmlspecialchars($b['date']) ?> &bull; <?= htmlspecialchars($b['author']) ?></div>
          <h4 class="blog-title"><?= htmlspecialchars($b['title']) ?></h4>
          <p class="blog-excerpt"><?= htmlspecialchars($b['excerpt']) ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ============================================================
     FAQ
     ============================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-head reveal">
      <div class="section-eyebrow">FAQ</div>
      <h2 class="section-title">Frequently asked</h2>
      <p class="section-desc">Everything you need to know — and a bit more.</p>
    </div>

    <div class="faq-wrap">
      <?php foreach ($FAQS as $i => $faq): ?>
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
  </div>
</section>


<!-- ============================================================
     FINAL CTA
     ============================================================ -->
<section class="cta-section">
  <div class="container">
    <div class="cta-box reveal">
      <div class="cta-inner">
        <div>
          <h2 class="cta-title">
            Ready to <span class="text-gradient-accent">crack CAT</span> &amp; secure your IIM seat?
          </h2>
          <p class="cta-desc">Free 1-on-1 counselling with IIM alumni. No spam, just clarity.</p>
        </div>
        <div class="cta-btn-wrap">
          <button class="btn btn-hero" style="font-size:1rem;padding:1rem 2rem" onclick="openModal('apply-modal')">
            Book Free Counselling
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
include 'components/Footer.php';
include 'components/Modals.php';
include 'includes/footer.php';
?>