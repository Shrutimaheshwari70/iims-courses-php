<?php
/**
 * index.php  ←→  src/routes/index.tsx  (Home component)
 */

session_start();
require_once 'data/iims.php';
$page_title = 'IIMs Colleges — Discover, Compare & Apply to India\'s Top IIMs';
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
            stroke-width="2">c
            <line x1="5" y1="12" x2="19" y2="12" />
            <polyline points="12 5 19 12 12 19" />
          </svg>
        </button>
        <a href="pages/colleges.php" class="btn btn-outline border text-white">Explore IIMs</a>
      </div>

      <div class="hero-social d-flex align-items-center gap-5 mt-4">
        <div class="hero-avatars d-flex">
          <img class="rounded-5 border object-fit-cover" src="assets/images/student1.webp" alt="user" />
          <img class="rounded-5 border object-fit-cover" src="assets/images/student2.webp" alt="user" />
          <img class="rounded-5 border object-fit-cover" src="assets/images/student3.webp" alt="user" />
          <img class="rounded-5 border object-fit-cover" src="assets/images/student5.webp" alt="user" />
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
      <div class="floating-stat float-0 border-amber-50 py-4 px-3 rounded d-flex align-items-center gap-4 shadow">
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
          <div class="floating-stat-value text-white fw-bold fs-4">80,000+</div>
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
</section>


<!-- ============================================================
     NEWS TICKER
     ============================================================ -->
<div class="news-ticker text-white d-flex overflow-hidden gap-5 py-1 text-nowrap">
  <div class="ticker-track ticker">
    <?php
    $news = [
      '🚨 CAT 2026 registrations open until September 13',
      '🎓 IIM Bangalore announces new analytics specialisation',
      '💼 IIM Calcutta final placements: avg ₹32.5L',
      '📅 IIM Indore IPMAT applications close June 5',
      '🌟 IIM Kozhikode tops gender diversity rankings',
    ];
    foreach (array_merge($news, $news) as $item): ?>
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

    <div class="colleges-grid d-grid gap-4">
      <?php foreach (array_slice($COLLEGES, 0, 6) as $index => $college): ?>
        <div class="reveal" style="transition-delay:<?= $index * 0.07 ?>s">
          <?php include 'components/CollegeCard.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="colleges-cta d-flex align-items-center justify-content-center mt-5">
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
    <div class="text-center mb-4 reveal">
      <div class="section-eyebrow">Programmes</div>
      <h2 class="section-title">Featured <span class="text-gradient-accent">programmes</span></h2>
      <p class="section-desc">Choose from full-time MBA, PGDM, Executive MBA, Business Analytics and more.</p>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-3">
      <?php foreach (array_slice($COURSES, 0, 8) as $i => $c):
        $cImgFile = preg_replace('#^(\.\./)*assets/images/#', '', $c['image']);
        $cImgSrc = $assetBase . 'images/' . $cImgFile;
        $pagePrefix = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) ? '' : 'pages/';
        $totalIims = count($c['iims']);
        $visibleIims = array_slice($c['iims'], 0, 2);
        ?>
        <div class="col">
          <div class="course-card d-flex flex-column h-100 reveal rounded-3 overflow-hidden"
            style="transition-delay:<?= $i * 0.05 ?>s">

            <div class="course-img overflow-hidden">
              <img src="<?= htmlspecialchars($cImgSrc) ?>" alt="<?= htmlspecialchars($c['title']) ?>" loading="lazy"
                class="d-block object-fit-cover rounded-3" />
              <div class="course-img-overlay"></div>
              <span
                class="course-cat fw-bold text-uppercase px-2 py-1 rounded-4"><?= htmlspecialchars($c['category']) ?></span>
              <span class="course-meta text-white fw-semibold">₹<?= $c['fees'] ?>L &bull;
                <?= htmlspecialchars($c['duration']) ?></span>
            </div>

            <div class="course-body d-flex flex-column py-2 px-1">
              <h4 class="course-title overflow-hidden fw-semibold"><?= htmlspecialchars($c['title']) ?></h4>
              <p class="course-desc overflow-hidden"><?= htmlspecialchars($c['description']) ?></p>

              <div class="course-iims-list d-flex align-items-center gap-2 flex-nowrap overflow-hidden">
                <?php foreach ($visibleIims as $iimSlug):
                  $iim = getCollege($iimSlug);
                  if ($iim): ?>
                    <span class="course-iim-chip"><?= htmlspecialchars($iim['name']) ?></span>
                  <?php endif; endforeach; ?>
                <?php if ($totalIims > 3): ?>
                  <a href="<?= $pagePrefix ?>course-details.php?slug=<?= $c['slug'] ?>" class="course-iim-viewall">
                    +<?= $totalIims - 3 ?> View All
                  </a>
                <?php endif; ?>
              </div>

              <div class="course-footer d-flex align-items-center pt-3">
                <a href="<?= $pagePrefix ?>course-details.php?slug=<?= $c['slug'] ?>"
                  class="course-link d-flex align-items-center text-decoration-0 fw-semibold">
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
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="featured-btn mt-4 fw-semibold d-flex align-items-center justify-content-center ">
    <a href="pages/courses.php" class="py-2 px-3 rounded-2">View all</a>
  </div>
</section>


<!-- ============================================================
     ACHIEVEMENTS
     ============================================================ -->
<section class="achievements-section overflow-hidden py-5">
  <div class="container">
    <div class="achievements-grid d-grid gap-3">
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
      foreach ($stats as $s): ?>
        <div class="achievement-item text-center text-white reveal">
          <div class="achievement-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2">
              <?= $icons[$s['icon']] ?>
            </svg>
          </div>
          <div class="achievement-value fs-1 fw-semibold">
            <span data-counter data-to="<?= $s['value'] ?>" data-suffix="<?= $s['suffix'] ?>">0</span>
          </div>
          <div class="achievement-label text-uppercase fw-semibold mt-2"><?= htmlspecialchars($s['label']) ?></div>
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

    <div class="timeline-grid d-grid gap-5">
      <?php
      $steps = [
        ['title' => 'Discover', 'desc' => 'Explore IIMs, programmes, placements & rankings.', 'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>'],
        ['title' => 'Compare', 'desc' => 'Side-by-side comparison of fees, ROI, faculty.', 'icon' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>'],
        ['title' => 'Apply', 'desc' => 'Apply through our guided counselling.', 'icon' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
        ['title' => 'Succeed', 'desc' => 'Crack CAT, ace WAT-PI, land your dream offer.', 'icon' => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>'],
      ];
      foreach ($steps as $i => $step): ?>
        <div class="timeline-item text-center reveal" style="transition-delay:<?= $i * 0.1 ?>s">
          <div class="timeline-icon-wrap rounded-2 d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2">
              <?= $step['icon'] ?>
            </svg>
            <div class="timeline-num d-flex align-items-center justify-content-center fw-semibold"><?= $i + 1 ?></div>
          </div>
          <h6 class="timeline-title fw-semibold mt-2"><?= htmlspecialchars($step['title']) ?></h6>
          <p class="timeline-desc mt-2"><?= htmlspecialchars($step['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ==================================s==========================
     TOP RECRUITERS  ← NEW SECTION (added before testimonials)
     ============================================================ -->
<?php
$assetBase = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false)
  ? '../assets/images/'
  : 'assets/images/';

$RECRUITERS = [
  ['name' => 'Google', 'logo' => $assetBase . 'Google.webp'],
  ['name' => 'Adobe', 'logo' => $assetBase . 'Adobe.webp'],
  ['name' => 'Apple', 'logo' => $assetBase . 'Apple.webp'],
  ['name' => 'Axis', 'logo' => $assetBase . 'Axis.webp'],
  ['name' => 'CocoCola', 'logo' => $assetBase . 'CocoCola.webp'],
  ['name' => 'Cognizant', 'logo' => $assetBase . 'Cognizant.webp'],
  ['name' => 'ICICI', 'logo' => $assetBase . 'ICICI.webp'],
  ['name' => 'Mahindra', 'logo' => $assetBase . 'Mahindra.webp'],
  ['name' => 'Microsoft', 'logo' => $assetBase . 'Microsoft.webp'],
  ['name' => 'Amazon', 'logo' => $assetBase . 'Amazon.webp'],
  ['name' => 'McKinsey', 'logo' => $assetBase . 'McKinsey.webp'],
  ['name' => 'Deloitte', 'logo' => $assetBase . 'Deloitte.webp'],
  ['name' => 'Accenture', 'logo' => $assetBase . 'Accenture.webp'],
  ['name' => 'Infosys', 'logo' => $assetBase . 'Infosys.webp'],
  ['name' => 'Wipro', 'logo' => $assetBase . 'Wipro.webp'],
  ['name' => 'KPMG', 'logo' => $assetBase . 'KPMG.webp'],
  ['name' => 'BCG', 'logo' => $assetBase . 'BCG.webp'],
  ['name' => 'Bain & Co', 'logo' => $assetBase . 'Bain.webp'],
  ['name' => 'Flipkart', 'logo' => $assetBase . 'Flipkart.webp'],
  ['name' => 'Tata Group', 'logo' => $assetBase . 'Tcs.webp'],
  ['name' => 'Hindustan Unilever', 'logo' => $assetBase . 'Hul.webp'],
  ['name' => 'HDFC Bank', 'logo' => $assetBase . 'HDFC.webp'],
];

?>

<section class="section section-alt recruiters-section border-bottom">
  <div class="container">

    <!-- HEAD -->
    <div class="section-head reveal text-center">
      <div class="section-eyebrow">Placements</div>
      <h2 class="section-title">Our <span class="text-gradient-accent">Top Recruiters</span></h2>
      <p class="section-desc">500+ leading global and Indian companies hire from our IIM network every year.</p>
    </div>

    <!-- STAT PILLS -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
      <div class="recruiter-stat-pill"><span>500+</span> Recruiters</div>
      <div class="recruiter-stat-pill"><span>₹1.15Cr</span> Highest CTC</div>
      <div class="recruiter-stat-pill"><span>₹24L</span> Avg CTC</div>
      <div class="recruiter-stat-pill"><span>98%</span> Placement Rate</div>
    </div>

  </div>

  <!-- MARQUEE ROW 1 — left to right -->
  <div class="recruiters-marquee-outer">
    <div class="recruiters-track recruiters-track--fwd">
      <?php foreach (array_merge($RECRUITERS, $RECRUITERS) as $r): ?>
        <div class="recruiter-chip">
          <img src="<?= htmlspecialchars($r['logo']) ?>" alt="<?= htmlspecialchars($r['name']) ?>" loading="lazy"
            onerror="this.style.display='none'" />
          <span><?= htmlspecialchars($r['name']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- MARQUEE ROW 2 — right to left (offset) -->
  <div class="recruiters-marquee-outer mt-3">
    <div class="recruiters-track recruiters-track--rev">
      <?php
      $shifted = array_merge(array_slice($RECRUITERS, 5), array_slice($RECRUITERS, 0, 5));
      foreach (array_merge($shifted, $shifted) as $r): ?>
        <div class="recruiter-chip">
          <img src="<?= htmlspecialchars($r['logo']) ?>" alt="<?= htmlspecialchars($r['name']) ?>" loading="lazy"
            onerror="this.style.display='none'" />
          <span><?= htmlspecialchars($r['name']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</section>

<!-- ============================================================
     TESTIMONIALS
     ============================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="section-head reveal">
      <div class="section-eyebrow">Stories</div>
      <h1 class="section-title">Loved by <span class="text-gradient-accent">aspirants &amp; alumni</span></h1>
    </div>

    <?php $avatarColors = ['#6366f1', '#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6']; ?>

    <div class="testimonial-wrap" id="testimonial-wrap">
      <?php foreach ($TESTIMONIALS as $ti => $t):
        $color = $avatarColors[$ti % count($avatarColors)];
        $initials = mb_strtoupper(mb_substr(trim($t['name']), 0, 1));
        $isFirst = ($ti === 0);
        ?>
        <div class="testimonial-slide<?= $isFirst ? ' active-slide' : '' ?>" id="t-slide-<?= $ti ?>"
          style="display:<?= $isFirst ? 'block' : 'none' ?>;">
          <div class="testimonial-card">
            <div class="testimonial-stars">
              <?php for ($s = 0; $s < (int) $t['rating']; $s++): ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="1"
                  width="18" height="18">
                  <polygon
                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                </svg>
              <?php endfor; ?>
            </div>
            <p class="testimonial-quote">"<?= htmlspecialchars($t['quote']) ?>"</p>
            <div class="testimonial-author">
              <?php if (!empty($t['image'])): ?>
                <img src="<?= htmlspecialchars($t['image']) ?>" alt="<?= htmlspecialchars($t['name']) ?>"
                  class="testimonial-avatar-img" loading="lazy"
                  onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                <div class="testimonial-avatar"
                  style="display:none;background:<?= $color ?>;color:#fff;align-items:center;justify-content:center;font-weight:700;font-size:1.1rem;">
                  <?= $initials ?>
                </div>
              <?php else: ?>
                <div class="testimonial-avatar"
                  style="background:<?= $color ?>;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.1rem;">
                  <?= $initials ?>
                </div>
              <?php endif; ?>
              <div>
                <div class="testimonial-name"><?= htmlspecialchars($t['name']) ?></div>
                <div class="testimonial-role"><?= htmlspecialchars($t['role']) ?></div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="testimonial-nav d-flex align-items-center justify-content-center mt-3">
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
        <a href="pages/blog-details.php?slug=<?= $b['slug'] ?>" class="blog-card reveal border"
          style="transition-delay:<?= $i * 0.06 ?>s">
          <div class="blog-img">
            <img src="<?= htmlspecialchars($b['image']) ?>" alt="<?= htmlspecialchars($b['title']) ?>" loading="lazy" />
          </div>
          <div class="blog-body d-flex flex-column py-3 px-2">
            <div class="blog-meta mb-1"><?= htmlspecialchars($b['date']) ?> &bull; <?= htmlspecialchars($b['author']) ?>
            </div>
            <h4 class="blog-title"><?= htmlspecialchars($b['title']) ?></h4>
            <p class="blog-excerpt"><?= htmlspecialchars($b['excerpt']) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <div class="btn-blog mt-4 d-flex align-items-center justify-content-center">
      <a href="pages/blogs.php" class="border-0 py-1 px-3 rounded-3 text-white">View all</a>
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


<!-- Testimonial slider JS -->
<script>
  (function () {
    var total = <?= count($TESTIMONIALS) ?>;
    var current = 0;
    var autoTimer;

    function showSlide(idx) {
      for (var i = 0; i < total; i++) {
        var sl = document.getElementById('t-slide-' + i);
        if (sl) { sl.style.display = 'none'; sl.classList.remove('active-slide'); }
      }
      var target = document.getElementById('t-slide-' + idx);
      if (target) { target.style.display = 'block'; target.classList.add('active-slide'); }
      document.querySelectorAll('.t-dot').forEach(function (d, i) {
        d.classList.toggle('active', i === idx);
      });
      current = idx;
    }

    function next() { showSlide((current + 1) % total); }
    function prev() { showSlide((current - 1 + total) % total); }

    var btnNext = document.getElementById('t-next');
    var btnPrev = document.getElementById('t-prev');
    if (btnNext) btnNext.addEventListener('click', function () { clearInterval(autoTimer); next(); startAuto(); });
    if (btnPrev) btnPrev.addEventListener('click', function () { clearInterval(autoTimer); prev(); startAuto(); });

    document.querySelectorAll('.t-dot').forEach(function (dot) {
      dot.addEventListener('click', function () {
        clearInterval(autoTimer);
        showSlide(parseInt(this.getAttribute('data-index'), 10));
        startAuto();
      });
    });

    function startAuto() { autoTimer = setInterval(next, 5000); }
    startAuto();

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
<script>
document.querySelectorAll('.faq-question').forEach(q => {
  q.addEventListener('click', () => {
    const item = q.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  });
});
</script>
<script>
function animateCounter(el) {
  const target = +el.getAttribute("data-to");
  const suffix = el.getAttribute("data-suffix") || "";
  let count = 0;

  const step = Math.ceil(target / 100);

  function update() {
    count += step;
    if (count >= target) {
      el.innerText = target + suffix;
    } else {
      el.innerText = count + suffix;
      requestAnimationFrame(update);
    }
  }

  update();
}

const counters = document.querySelectorAll("[data-counter]");

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      animateCounter(entry.target);
      observer.unobserve(entry.target);
    }
  });
});

counters.forEach(c => observer.observe(c));
</script>
<?php
include 'components/Footer.php';
include 'components/Modals.php';
include 'includes/footer.php';

?>
