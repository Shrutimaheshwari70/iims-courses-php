<?php
/**
 * about.php  ←→  src/routes/about.tsx
 * Exact same UI as TypeScript version — same layout, same sections, same styles
 */
session_start();
$page_title       = 'About — IIMs Courses';
$page_description = 'India\'s most trusted IIM platform. Founded by IIM alumni to make admissions transparent and fair.';
$current_page     = 'about';

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ============================================================
     HERO  — gradient-hero dark banner (same as TSX)
     ============================================================ -->
<section class="about-hero">
  <div class="container">
    <h1 class="about-hero-title fade-up">
      India's most trusted <span class="text-gradient-accent">IIM platform</span>
    </h1>
    <p class="about-hero-desc fade-up" style="animation-delay:.1s">
      We exist to make the IIM admissions journey clear, transparent and fair for every aspirant.
    </p>
  </div>
</section>


<!-- ============================================================
     OUR STORY  — image left, text right (same as TSX grid)
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="about-story-grid">

      <div class="reveal">
        <img
          src="../assets/images/students.jpg"
          alt="IIM Students"
          class="about-story-img"
          loading="lazy"
        />
      </div>

      <div class="reveal" style="transition-delay:.1s">
        <h2 class="section-title">Our story</h2>
        <p class="about-text" style="margin-top:1rem">
          Founded in 2024 by IIM alumni, IIMs Courses set out to fix a broken discovery experience —
          built on verified data, transparent placements and free counselling.
        </p>
        <p class="about-text" style="margin-top:.75rem">
          Today, 50,000+ aspirants trust us each year to choose right.
        </p>
      </div>

    </div>
  </div>
</section>


<!-- ============================================================
     MISSION / VISION / VALUES  — 3-col card grid (same as TSX)
     ============================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="mvv-grid">

      <?php
      $mvv = [
        [
          'title' => 'Mission',
          'desc'  => 'Make IIM admissions transparent and fair for all.',
          'delay' => '0s',
          'icon'  => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
        ],
        [
          'title' => 'Vision',
          'desc'  => 'Be the default platform for MBA aspirants in India.',
          'delay' => '.1s',
          'icon'  => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
        ],
        [
          'title' => 'Values',
          'desc'  => 'Honesty, data-first, student-first, always.',
          'delay' => '.2s',
          'icon'  => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>',
        ],
      ];
      foreach ($mvv as $card): ?>
        <div class="mvv-card reveal" style="transition-delay:<?= $card['delay'] ?>">
          <div class="mvv-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <?= $card['icon'] ?>
            </svg>
          </div>
          <div class="mvv-title"><?= $card['title'] ?></div>
          <p class="mvv-desc"><?= $card['desc'] ?></p>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>


<!-- ============================================================
     CTA BANNER  — same gradient-hero dark box as TSX
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="cta-box reveal">
      <div class="about-cta-inner">
        <h3 class="cta-title">Ready to start your IIM journey?</h3>
        <a href="../pages/colleges.php" class="btn btn-hero about-cta-btn">
          Explore IIMs
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>


<style>
/* ===== ABOUT PAGE STYLES ===== */

/* Hero */
.about-hero {
  background-image: var(--gradient-hero);
  padding: 8rem 0 5rem;
  color: #fff;
}
.about-hero-title {
  font-family: var(--font-display);
  font-weight: 800;
  font-size: clamp(2.2rem, 5vw, 3.75rem);
  line-height: 1.1;
  letter-spacing: -0.02em;
  max-width: 800px;
}
.about-hero-desc {
  color: rgba(255,255,255,.80);
  margin-top: 1.25rem;
  font-size: 1.1rem;
  max-width: 600px;
  line-height: 1.7;
}

/* Story grid — image left, text right */
.about-story-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3.5rem;
  align-items: center;
}
@media (max-width: 768px) {
  .about-story-grid { grid-template-columns: 1fr; gap: 2rem; }
}
.about-story-img {
  width: 100%;
  border-radius: 1.5rem;
  box-shadow: var(--shadow-elegant);
  object-fit: cover;
  aspect-ratio: 4/3;
  display: block;
}
.about-text {
  color: var(--muted-foreground);
  line-height: 1.75;
  font-size: .97rem;
}

/* MVV — 3 col cards */
.mvv-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.25rem;
}
@media (max-width: 768px) {
  .mvv-grid { grid-template-columns: 1fr; }
}
.mvv-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 1rem;
  padding: 1.75rem;
  box-shadow: var(--shadow-soft);
  transition: box-shadow .2s, transform .2s;
}
.mvv-card:hover {
  box-shadow: var(--shadow-card);
  transform: translateY(-3px);
}
.mvv-icon {
  width: 40px;
  height: 40px;
  color: var(--accent);
}
.mvv-icon svg {
  width: 100%;
  height: 100%;
}
.mvv-title {
  font-family: var(--font-display);
  font-weight: 600;
  font-size: 1.2rem;
  margin-top: 1rem;
  color: var(--foreground);
}
.mvv-desc {
  font-size: .875rem;
  color: var(--muted-foreground);
  margin-top: .5rem;
  line-height: 1.6;
}

/* CTA inner — centred column layout */
.about-cta-inner {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  text-align: center;
}
.about-cta-btn {
  display: inline-flex;
  align-items: center;
  gap: .5rem;
  font-size: 1rem;
  padding: .9rem 2rem;
}
.about-cta-btn svg {
  width: 18px;
  height: 18px;
}

/* fade-up for hero (since app.js scroll-reveal targets .reveal only) */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
.fade-up {
  animation: fadeUp .6s ease both;
}
</style>

<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>