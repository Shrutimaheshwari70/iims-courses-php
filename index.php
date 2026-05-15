<?php
/**
 * index.php  ←→  src/routes/index.tsx  (Home component)
 */

session_start();
require_once 'data/iims.php';

$page_title = 'IIMs Courses — Discover, Compare & Apply to India\'s Top IIMs';
$page_description = 'Explore all 14 IIMs, MBA & PGDM programmes, verified placements and rankings. Apply with free counselling.';
$current_page = 'home';

include 'includes/header.php';
include 'components/Navbar.php';
?>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="hero d-flex align-items-center overflow-hidden">
  <img src="assets/images/hero-campus.jpg" alt="IIM campus at sunset" class="hero-bg" />
  <div class="hero-overlay"></div>

  <div class="hero-inner">
    <div class="fade-up" style="color:#fff">
      <span class="hero-badge">
        <span class="hero-badge-dot animate-pulse"></span>
        Admissions Open &bull; Batch 2026
      </span>

      <h1 class="fw-semibold mt-4">Your future in <span class="text-gradient-accent">India's top IIMs</span> starts
        here.</h1>

      <p class="hero-desc">
        Discover all 14 Indian Institutes of Management with verified rankings,
        placements, fees and alumni reviews — and get free admissions counselling.
      </p>

      <div class="hero-actions d-flex flex-wrap gap-2 mt-5">
        <button class="btn btn-hero" onclick="openApplyModal()">
          Apply Now
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12" />
            <polyline points="12 5 19 12 12 19" />
          </svg>
        </button>
        <a href="pages/colleges.php" class="btn btn-outline border text-white">Explore IIMs</a>
      </div>

      <div class="hero-social d-flex align-items-center gap-5 mt-4">

        <div class="hero-avatars d-flex">
          <img class="rounded-5 border object-fit-cover" src="assets/images/student1.webp" alt="user"
            class="rounded-circle" />
          <img class="rounded-5 border object-fit-cover" src="assets/images/student2.webp" alt="user"
            class="rounded-circle" />
          <img class="rounded-5 border object-fit-cover" src="assets/images/student3.webp" alt="user"
            class="rounded-circle" />
          <img class="rounded-5 border object-fit-cover" src="assets/images/student5.webp" alt="user"
            class="rounded-circle" />
        </div>
        <div>
          <div class="hero-stars d-flex align-items-center gap-0">
            <?php for ($i = 0; $i < 5; $i++): ?>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <polygon
                  points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
              </svg>
            <?php endfor; ?>
            <span class="score fw-semibold">4.9</span>
          </div>
          <div class="hero-stars sub" style="display:block;margin-top:.1rem">Trusted by 50,000+ MBA aspirants</div>
        </div>
      </div>
    </div>

    <div class="hero-right d-flex flex-column gap-2">
      <div class="floating-stat float-0   border-amber-50 py-4 px-3 rounded d-flex align-items-center gap-4 shadow">
        <div class="floating-stat-icon d-flex align-items-center justify-content-center text-white rounded-xl">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <circle cx="12" cy="8" r="6" />
            <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11" />
          </svg>
        </div>
        <div>
          <div class="floating-stat-label fw-semibold text-uppercase ls-4">Top NIRF Ranked</div>
          <div class="floating-stat-value text-white fw-bold fs-4">14 IIMs</div>
        </div>
      </div>
      <div class="floating-stat float-1 border-amber-50 py-4 px-3 rounded d-flex align-items-center gap-4 shadow">
        <div class="floating-stat-icon d-flex align-items-center justify-content-center text-white rounded-xl">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
            <polyline points="17 6 23 6 23 12" />
          </svg>
        </div>
        <div>
          <div class="floating-stat-label fw-semibold text-uppercase ls-4">Highest Placement</div>
          <div class="floating-stat-value text-white fw-bold fs-4">₹1.15 Cr</div>
        </div>
      </div>
      <div class="floating-stat float-2 border-amber-50 py-4 px-3 rounded d-flex align-items-center gap-4 shadow">
        <div class="floating-stat-icon d-flex align-items-center justify-content-center text-white rounded-xl">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
          </svg>
        </div>
        <div>
          <div class="floating-stat-label fw-semibold text-uppercase ls-4">Alumni Network</div>
          <div class="floating-stat-value text-white fw-bold ">80,000+</div>
        </div>
      </div>

      <div class="cat-card">
        <div class="cat-card-label">CAT 2026</div>
        <div class="cat-card-value fs-4 fw-bold text-white">Apply by Sep 13</div>
        <div class="cat-countdown gap-3 mt-3">
          <div class="cat-countdown-unit">
            <div class="num text-uppercase text-white" id="cd-days">132</div>
            <div class="lbl text-uppercase fs-5 fw-bold text-white">Days</div>
          </div>
          <div class="cat-countdown-unit">
            <div class="num text-uppercase text-white" id="cd-hours">06</div>
            <div class="lbl text-uppercase fs-5 fw-bold text-white">Hrs</div>
          </div>
          <div class="cat-countdown-unit">
            <div class="num text-uppercase text-white" id="cd-mins">42</div>
            <div class="lbl text-uppercase fs-5 fw-bold text-white">Min</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="recruiters-strip position-absolute left-0 right-0 bottom-0 border-top py-2 px-2">
    <div class="recruiters-track marquee d-flex gap-5 text-nowrap">
      <?php foreach (array_merge($RECRUITERS, $RECRUITERS) as $r): ?>
        <span class="fw-semibold"><?= htmlspecialchars($r) ?></span>
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
        View all IIMs
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12" />
          <polyline points="12 5 19 12 12 19" />
        </svg>
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
      <?php
      // Dynamic asset base — root (index.php) vs /pages/
      $assetBase = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) ? '../assets/' : 'assets/';

      foreach (array_slice($COURSES, 0, 8) as $i => $c):
        // Strip any stored ../assets/images/ or assets/images/ prefix and rebuild
        $cImgFile = preg_replace('#^(\.\./)*assets/images/#', '', $c['image']);
        $cImgSrc = $assetBase . 'images/' . $cImgFile;
        ?>
        <div class="course-card reveal" style="transition-delay:<?= $i * 0.05 ?>s">
          <div class="course-img">
            <img src="<?= htmlspecialchars($cImgSrc) ?>" alt="<?= htmlspecialchars($c['title']) ?>" loading="lazy"
              style="display:block;width:100%;height:100%;object-fit:cover;margin:0;padding:0;border:none;" />
            <div class="course-img-overlay"></div>
            <span class="course-cat"><?= htmlspecialchars($c['category']) ?></span>
            <span class="course-meta">₹<?= $c['fees'] ?>L &bull; <?= htmlspecialchars($c['duration']) ?></span>
          </div>
          <div class="course-body">
            <h4 class="course-title"><?= htmlspecialchars($c['title']) ?></h4>
            <p class="course-desc"><?= htmlspecialchars($c['description']) ?></p>
            <div class="course-footer">
              <span class="course-iims"><?= count($c['iims']) ?> IIMs</span>
              <a href="<?= (strpos($_SERVER['PHP_SELF'], '/pages/') !== false ? '' : 'pages/') ?>course-details.php?slug=<?= $c['slug'] ?>"
                class="course-link">
                Explore
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="2">
                  <line x1="5" y1="12" x2="19" y2="12" />
                  <polyline points="12 5 19 12 12 19" />
                </svg>
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
        ['value' => 14, 'label' => 'IIMs Covered', 'suffix' => '', 'icon' => 'graduation'],
        ['value' => 50000, 'label' => 'Aspirants Helped', 'suffix' => '+', 'icon' => 'users'],
        ['value' => 80000, 'label' => 'Alumni Network', 'suffix' => '+', 'icon' => 'briefcase'],
        ['value' => 98, 'label' => 'Avg Placement %', 'suffix' => '%', 'icon' => 'target'],
      ];
      $icons = [
        'graduation' => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
        'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'briefcase' => '<rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
        'target' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
      ];
      foreach ($stats as $s):
        ?>
        <div class="achievement-item reveal">
          <div class="achievement-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2">
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
        [
          'title' => 'Discover',
          'desc' => 'Explore IIMs, programmes, placements & rankings.',
          'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>'
        ],
        [
          'title' => 'Compare',
          'desc' => 'Side-by-side comparison of fees, ROI, faculty.',
          'icon' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>'
        ],
        [
          'title' => 'Apply',
          'desc' => 'Apply through our guided counselling.',
          'icon' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'
        ],
        [
          'title' => 'Succeed',
          'desc' => 'Crack CAT, ace WAT-PI, land your dream offer.',
          'icon' => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>'
        ],
      ];
      foreach ($steps as $i => $step):
        ?>
        <div class="timeline-item reveal" style="transition-delay:<?= $i * 0.1 ?>s">
          <div class="timeline-icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2">
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
    $avatarColors = ['#6366f1', '#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'];
    ?>

    <div class="testimonial-wrap" id="testimonial-wrap">

      <?php foreach ($TESTIMONIALS as $ti => $t):
        $color = $avatarColors[$ti % count($avatarColors)];
        $initials = mb_strtoupper(mb_substr(trim($t['name']), 0, 1));
        $isFirst = ($ti === 0);
        ?>
        <div class="testimonial-slide<?= $isFirst ? ' active-slide' : '' ?>" id="t-slide-<?= $ti ?>"
          style="display:<?= $isFirst ? 'block' : 'none' ?>;">
          <div class="testimonial-card">

            <!-- Stars -->
            <div class="testimonial-stars">
              <?php for ($s = 0; $s < (int) $t['rating']; $s++): ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="1"
                  width="18" height="18">
                  <polygon
                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                </svg>
              <?php endfor; ?>
            </div>

            <!-- Quote -->
            <p class="testimonial-quote">"<?= htmlspecialchars($t['quote']) ?>"</p>

            <!-- Author row: photo OR initials avatar -->
            <div class="testimonial-author">

              <?php if (!empty($t['image'])): ?>
                <!-- Real photo from data -->
                <img src="<?= htmlspecialchars($t['image']) ?>" alt="<?= htmlspecialchars($t['name']) ?>"
                  class="testimonial-avatar     -img" loading="lazy"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                <!-- Fallback initials (hidden unless image errors) -->
                <div class="testimonial-avatar"
                  style="display:none;background:<?= $color ?>;color:#fff;align-items:center;justify-content:center;font-weight:700;font-size:1.1rem;">
                  <?= $initials ?></div>

              <?php else: ?>
                <!-- No image in data → show initials avatar -->
                <div class="testimonial-avatar"
                  style="background:<?= $color ?>;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.1rem;">
                  <?= $initials ?></div>
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
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <polyline points="15 18 9 12 15 6" />
          </svg>
        </button>

        <?php foreach ($TESTIMONIALS as $ti => $t): ?>
          <button class="t-dot<?= $ti === 0 ? ' active' : '' ?>" data-index="<?= $ti ?>"
            aria-label="Go to testimonial <?= $ti + 1 ?>"></button>
        <?php endforeach; ?>

        <button class="t-nav-btn" id="t-next" aria-label="Next testimonial">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <polyline points="9 18 15 12 9 6" />
          </svg>
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

  .testimonial-slide {
    display: none;
  }

  .testimonial-slide.active-slide {
    display: block;
  }
</style>

<!-- Testimonial slider JS — fully self-contained, no dependencies -->
<script>
  (function () {
    var total = <?= count($TESTIMONIALS) ?>;
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
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2">
              <circle cx="12" cy="12" r="10" />
              <polygon points="10 8 16 12 10 16 10 8" />
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
          ['title' => 'CAT 2026 Strategy: Section-wise plan', 'date' => 'May 12, 7:00 PM', 'host' => 'By IIM-A Alumni'],
          ['title' => 'WAT-PI Masterclass with IIM toppers', 'date' => 'May 18, 6:30 PM', 'host' => 'Live, free'],
          ['title' => 'MBA Specialisation: Choosing wisely', 'date' => 'May 24, 7:00 PM', 'host' => 'Panel'],
        ];
        foreach ($webinars as $i => $w):
          ?>
          <div class="vw-item reveal" style="transition-delay:<?= $i * 0.1 ?>s">
            <div class="vw-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
              </svg>
            </div>
            <div style="flex:1">
              <div class="vw-title"><?= htmlspecialchars($w['title']) ?></div>
              <div class="vw-meta"><?= htmlspecialchars($w['date']) ?> &bull; <?= htmlspecialchars($w['host']) ?></div>
            </div>
            <button class="btn btn-soft btn-sm" onclick="openApplyModal()">Register</button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
     FACULTY SPOTLIGHT
     ============================================================ -->
<section class="section section-alt faculty-spotlight-section">
  <div class="container">
    <div class="section-head reveal">
      <div class="section-eyebrow">World-class minds</div>
      <h2 class="section-title">Faculty spotlight</h2>
    </div>

    <div class="faculty-grid">
      <?php
      $faculty = [
        [
          'name' => 'Dr. Anuja Kapoor',
          'role' => 'Strategy',
          'image' => 'assets/images/dr-anuja.webp',

          'institute' => 'IIM Ahmedabad',
          'short' => 'IIM-A',
          'exp' => '18 Yrs',
          'papers' => '42 Papers',
          'quote' => 'Strategy is not a plan. It\'s a perspective.',
          'color' => '#e07b39',
          'initials' => 'AK',
          'bg' => 'linear-gradient(135deg, #f9f4ef 0%, #f3e7db 100%)',
          'pattern' => 'circles',
        ],
        [
          'name' => 'Prof. Rajiv Menon',
          'role' => 'Finance',
          'image' => 'assets/images/prof-rajeev.webp',

          'institute' => 'IIM Bangalore',
          'short' => 'IIM-B',
          'exp' => '22 Yrs',
          'papers' => '61 Papers',
          'quote' => 'Numbers tell the story markets are afraid to.',
          'color' => '#2d6be4',
          'initials' => 'RM',
          'bg' => 'linear-gradient(135deg, #f7f9fe 0%, #dde7fa 100%)',
          'pattern' => 'lines',
        ],
        [
          'name' => 'Dr. Meera Krishnan',
          'role' => 'Marketing',
          'image' => 'assets/images/dr-meera.webp',

          'institute' => 'IIM Kozhikode',
          'short' => 'IIM-K',
          'exp' => '15 Yrs',
          'papers' => '38 Papers',
          'quote' => 'Brands are promises. Great brands keep them.',
          'color' => '#0d9e72',
          'initials' => 'MK',
          'bg' => 'linear-gradient(135deg, #f4fcf8 0%, #d9f2e7 100%)',
          'pattern' => 'dots',
        ],
        [
          'name' => 'Prof. Vikram Joshi',
          'role' => 'Analytics',
          'image' => 'assets/images/prof-vikram.webp',

          'institute' => 'IIM Calcutta',
          'short' => 'IIM-C',
          'exp' => '20 Yrs',
          'papers' => '55 Papers',
          'quote' => 'Data without context is just noise.',
          'color' => '#7c3aed',
          'initials' => 'VJ',
          'bg' => 'linear-gradient(135deg, #faf7fe 0%, #e7dcfb 100%)',
          'pattern' => 'grid',
        ],
      ];
      foreach ($faculty as $i => $f):
        ?>
        <div class="faculty-card-pro reveal" style="transition-delay:<?= $i * 0.1 ?>s">

          <!-- Top visual area -->
          <div class="fcp-visual" style="background:<?= $f['bg'] ?>;">

            <!-- Decorative SVG pattern -->
            <div class="fcp-pattern fcp-pattern--<?= $f['pattern'] ?>"></div>

            <!-- Institute badge -->
            <div class="fcp-badge"><?= $f['short'] ?></div>

            <!-- Avatar -->
            <div class="fcp-avatar">
              <img src="<?= $f['image'] ?>" alt="<?= htmlspecialchars($f['name']) ?>">
            </div>
            <!-- Hover quote overlay -->
            <div class="fcp-quote-overlay">
              <svg class="fcp-quote-icon" viewBox="0 0 24 24" fill="currentColor">
                <path
                  d="M11.192 15.757c0-.88-.23-1.618-.69-2.217-.326-.412-.768-.683-1.327-.812-.55-.128-1.07-.137-1.54-.028-.16-.95.1-1.956.76-3.022.66-1.065 1.515-1.867 2.558-2.403L9.373 5c-.8.396-1.56.898-2.26 1.505-.71.607-1.34 1.305-1.9 2.094s-.98 1.68-1.25 2.69-.346 2.04-.217 3.1c.168 1.4.62 2.52 1.356 3.35.735.84 1.652 1.26 2.748 1.26.965 0 1.766-.29 2.4-.878.628-.576.94-1.365.94-2.368l.002.003zm9.124 0c0-.88-.23-1.618-.69-2.217-.326-.42-.77-.692-1.327-.817-.56-.124-1.074-.13-1.54-.022-.16-.94.09-1.95.75-3.02.66-1.06 1.514-1.86 2.557-2.4L18.49 5c-.8.396-1.555.898-2.26 1.505-.708.607-1.34 1.305-1.894 2.094-.556.79-.97 1.68-1.24 2.69-.273 1.01-.345 2.04-.217 3.1.168 1.4.62 2.52 1.356 3.35.735.84 1.652 1.26 2.748 1.26.965 0 1.766-.29 2.4-.878.628-.576.94-1.365.94-2.368l.002.003z" />
              </svg>
              <p class="fcp-quote-text">"<?= htmlspecialchars($f['quote']) ?>"</p>
            </div>

          </div>

          <!-- Info area -->
          <div class="fcp-info">
            <div class="fcp-name"><?= htmlspecialchars($f['name']) ?></div>
            <div class="fcp-role" style="color:<?= $f['color'] ?>"><?= htmlspecialchars($f['role']) ?> &bull;
              <?= htmlspecialchars($f['institute']) ?></div>

            <div class="fcp-stats">
              <div class="fcp-stat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10" />
                  <polyline points="12 6 12 12 16 14" />
                </svg>
                <?= $f['exp'] ?>
              </div>
              <div class="fcp-stat-divider"></div>
              <div class="fcp-stat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                  <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                </svg>
                <?= $f['papers'] ?>
              </div>
            </div>
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
        <a href="pages/blog-details.php?slug=<?= $b['slug'] ?>" class="blog-card reveal"
          style="transition-delay:<?= $i * 0.06 ?>s">
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
            <svg class="faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9" />
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
<?php
include 'components/Footer.php';
include 'components/Modals.php';
include 'includes/footer.php';
?>