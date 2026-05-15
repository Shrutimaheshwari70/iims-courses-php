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

<!-- Bootstrap Icons only (no full Bootstrap CSS globally) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Bootstrap CSS scoped ONLY inside .bs via a style tag trick -->
<style id="bs-scope-style"></style>


<!-- ============================================================
     HERO  — gradient-hero dark banner (same as TSX)
     ============================================================ -->
<div class="bs">
  <!-- HERO -->
  <section class="c-hero">
    <div class="container position-relative" style="z-index:1;">
      <div class="c-badge d-inline-flex px-3 py-1 rounded align-items-center mb-2 text-uppercase gap-2">
        <i class="bi bi-mortarboard-fill"></i>Connect Our Counselling
      </div>
      <h1 class="text-white fw-bold ">India's most trusted  <span>IIM platform</span></h1>
      <p class="text-light">      We exist to make the IIM admissions journey clear, transparent and fair for every aspirant.
</p>
      <div class="d-flex gap-3 mt-4 flex-wrap">
        <button class="c-btn-send px-4 rounded text-white w-auto py-3 border-0" onclick="openApplyModal()">
          <i class="bi bi-send-fill"></i> Apply Now
        </button>
        <a href="contact.php" class="c-btn-outline px-4 rounded text-white w-auto py-3 border ">
          <i class="bi bi-chat-dots "></i> Contact Us
        </a>
      </div>
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

<style>
/* ===== ABOUT PAGE STYLES ===== */
  .bs {
    font-family: var(--font-sans, sans-serif);
  }

  /* Hero */
  .bs .c-hero {
    background: linear-gradient(135deg, #1a2340 0%, #2d3d6b 100%);
    min-height: 30rem;
    display: flex;
    align-items: center;
    position: relative;
  }

  .bs .c-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
  }

  .bs .c-hero h1 span {
    color: #f97316;
  }

  .bs .c-hero p {
    font-size: 1rem;
    max-width: 500px;
  }

  .bs .c-badge {
    background: rgba(249, 115, 22, .18);
    color: #fdba74;
    font-size: .75rem;
    letter-spacing: .1em;
  }

  /* Cards */
  .bs .c-card {
    transition: box-shadow .2s;
  }

  .bs .c-card:hover {
    box-shadow: 0 8px 32px rgba(0, 0, 0, .10);
  }

  .bs .icon-box {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #1a2340, #2d3d6b);
    flex-shrink: 0;
  }

  .bs .info-label {
    font-size: .65rem;
    letter-spacing: .12em;
    color: var(--c-muted);
  }

  .bs .info-value {
    font-size: .90rem;
  }

  .bs .info-link {
    font-size: .82rem;
    color: #f97316;
  }

  .bs .info-link:hover {
    text-decoration: underline;
  }

  /* Form */
  .bs .c-label {
    display: block;
    font-size: .82rem;
    font-weight: 500;
  }

  .bs .c-input {
    width: 100%;
    font-size: .9rem;
    color: var(--foreground, #111);
    outline: none;
    transition: border-color .18s, box-shadow .18s;
  }

  .bs .c-input:focus {
    border-color: #2d3d6b;
    box-shadow: 0 0 0 3px rgba(45, 61, 107, .12);
  }

  .bs .c-btn-send {
    background-image: var(--gradient-accent, linear-gradient(135deg, #1a2340, #2d3d6b));
    cursor: pointer;
    transition: transform .18s, box-shadow .18s;
  }

  .bs .c-btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(26, 35, 64, .25);
  }

  /* Outline hero btn */
  .bs .c-btn-outline {
    transition: border-color .18s;
  }

  .bs .c-btn-outline:hover {
    border-color: #fff;
  }

  /* Map */
  .bs .map-wrap {
    box-shadow: var(--c-shadow);
    border: 1px solid var(--c-border);
  }

  .bs .map-wrap iframe {
    display: block;
    width: 100%;
    height: 380px;
    border: 0;
  }

  /* Toast */
  .c-toast {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    z-index: 9999;
    padding: .75rem 1.35rem;
    border-radius: 12px;
    font-size: .9rem;
    font-weight: 500;
    color: #fff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, .15);
    animation: cToastIn .3s ease;
  }

  @keyframes cToastIn {
    from {
      transform: translateY(20px);
      opacity: 0
    }

    to {
      transform: translateY(0);
      opacity: 1
    }
  }

  @media(max-width:767px) {
    .bs .c-hero {
      /* padding: 10rem 0 3rem; */
    }

    .bs .c-strip .d-flex {
      flex-direction: column;
      gap: .75rem;
      text-align: center;
    }

    .bs .map-wrap iframe {
      height: 260px;
    }
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
include '../components/Modals.php';

include '../includes/footer.php';
?>