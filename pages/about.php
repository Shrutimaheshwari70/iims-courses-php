<?php
/**
 * about.php  ←→  src/routes/about.tsx
 */
session_start();
$page_title       = 'About — IIMs Courses';
$page_description = 'India\'s most trusted IIM platform. Founded by IIM alumni to make admissions transparent and fair.';
$current_page     = 'about';

include 'includes/header.php';
include 'components/Navbar.php';
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="gradient-hero pt-32 pb-20 text-white">
  <div class="container">
    <h1 class="font-display font-bold text-5xl md:text-6xl">
      India's most trusted <span class="text-gradient-accent">IIM platform</span>
    </h1>
    <p class="text-white-80 mt-5 text-lg max-w-2xl">
      We exist to make the IIM admissions journey clear, transparent and fair for every aspirant.
    </p>
  </div>
</section>


<!-- ============================================================
     OUR STORY
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="about-story-grid">
      <div class="reveal">
        <img src="assets/images/students.jpg" alt="IIM Students" class="about-img" loading="lazy" />
      </div>
      <div class="reveal">
        <h2 class="section-title">Our story</h2>
        <p class="text-muted mt-4 leading-relaxed">
          Founded in 2024 by IIM alumni, IIMs Courses set out to fix a broken discovery experience —
          built on verified data, transparent placements and free counselling.
        </p>
        <p class="text-muted mt-3 leading-relaxed">
          Today, 50,000+ aspirants trust us each year to choose right.
        </p>
      </div>
    </div>
  </div>
</section>


<!-- ============================================================
     MISSION / VISION / VALUES
     ============================================================ -->
<section class="section section-alt">
  <div class="container">
    <div class="mvv-grid">

      <div class="mvv-card reveal">
        <div class="mvv-icon">
          <!-- Target icon -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
          </svg>
        </div>
        <div class="mvv-title">Mission</div>
        <p class="mvv-desc">Make IIM admissions transparent and fair for all.</p>
      </div>

      <div class="mvv-card reveal" style="transition-delay:.1s">
        <div class="mvv-icon">
          <!-- Heart icon -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
        </div>
        <div class="mvv-title">Vision</div>
        <p class="mvv-desc">Be the default platform for MBA aspirants in India.</p>
      </div>

      <div class="mvv-card reveal" style="transition-delay:.2s">
        <div class="mvv-icon">
          <!-- Award icon -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
          </svg>
        </div>
        <div class="mvv-title">Values</div>
        <p class="mvv-desc">Honesty, data-first, student-first, always.</p>
      </div>

    </div>
  </div>
</section>


<!-- ============================================================
     CTA BANNER
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="cta-box reveal">
      <div class="cta-inner" style="text-align:center; flex-direction:column; gap:1.5rem">
        <h3 class="cta-title">Ready to start your IIM journey?</h3>
        <a href="pages/colleges.php" class="btn btn-hero">Explore IIMs</a>
      </div>
    </div>
  </div>
</section>

<?php
include 'components/Footer.php';
include 'includes/footer.php';
?>