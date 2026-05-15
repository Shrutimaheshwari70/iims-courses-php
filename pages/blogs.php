<?php
/**
 * pages/blogs.php  ←→  src/routes/blogs.index.tsx  (BlogsList)
 * Exact same UI as TypeScript version
 */
session_start();
require_once '../data/iims.php';

$page_title       = 'Blogs — CAT, MBA & IIM Insights';
$page_description = 'CAT prep, MBA strategy, placements and IIM stories — written by alumni & experts.';
$current_page     = 'blogs';

include '../includes/header.php';
include '../components/Navbar.php';
?>
<!-- Bootstrap Icons only (no full Bootstrap CSS globally) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Bootstrap CSS scoped ONLY inside .bs via a style tag trick -->
<style id="bs-scope-style"></style>

<!-- ============================================================
     HERO
     ============================================================ -->

<div class="bs">
  <!-- HERO -->
  <section class="c-hero">
    <div class="container position-relative" style="z-index:1;">
      <div class="c-badge d-inline-flex px-3 py-1 rounded align-items-center mb-2 text-uppercase gap-2">
        <i class="bi bi-mortarboard-fill"></i> Blogs
      </div>
      <h1 class="text-white fw-bold ">Blogs <span>insights</span></h1>
      <p class="text-light">      CAT prep, MBA strategy, placements and IIM stories — written by alumni &amp; experts.
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
</div>


<!-- ============================================================
     BLOG GRID  —  md:grid-cols-2 lg:grid-cols-3  (same as TSX)
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="blogs-page-grid">

      <?php foreach ($BLOGS as $i => $b): ?>
        <a
          href="blog-details.php?slug=<?= urlencode($b['slug']) ?>"
          class="blog-page-card reveal"
          style="transition-delay:<?= $i * 0.06 ?>s"
        >
          <!-- Image -->
          <div class="blog-page-img">
  <img
    src="../<?= htmlspecialchars($b['image']) ?>"
    alt="<?= htmlspecialchars($b['title']) ?>"
    loading="lazy"
  >
</div>

          <!-- Body -->
          <div class="blog-page-body">
            <div class="blog-page-meta">
              <?= htmlspecialchars($b['date']) ?> &bull; <?= htmlspecialchars($b['author']) ?>
            </div>

            <h3 class="blog-page-title"><?= htmlspecialchars($b['title']) ?></h3>

            <p class="blog-page-excerpt"><?= htmlspecialchars($b['excerpt']) ?></p>

            <div class="blog-page-footer">
              <span class="blog-page-likes">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <?= (int)($b['likes'] ?? 0) ?>
              </span>
              <span class="blog-page-read">Read latest →</span>
            </div>
          </div>
        </a>
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

<style>
/* ===== BLOGS PAGE STYLES ===== */

 /* ── Design variables ── */
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
/* Grid — 3 cols on desktop, 2 on tablet, 1 on mobile (same as lg:grid-cols-3) */
.blogs-page-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}
@media (max-width: 1024px) {
  .blogs-page-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
  .blogs-page-grid { grid-template-columns: 1fr; }
}

/* Card — same as TSX: rounded bg-card border shadow-soft */
.blog-page-card {
  border-radius: 1rem;
  background: var(--card);
  border: 1px solid var(--border);
  box-shadow: var(--shadow-soft);
  overflow: hidden;
  text-decoration: none;
  color: var(--foreground);
  display: flex;
  flex-direction: column;
  transition: box-shadow .25s, transform .25s;
}
.blog-page-card:hover {
  box-shadow: var(--shadow-card);
  transform: translateY(-4px);
}

/* Image — aspect-ratio 16/10, hover scale */
.blog-page-img {
  aspect-ratio: 16 / 10;
  overflow: hidden;
}
.blog-page-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform .5s ease;
  display: block;
}
.blog-page-card:hover .blog-page-img img {
  transform: scale(1.05);
}

/* Body */
.blog-page-body {
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  flex: 1;
}

/* Meta — date • author */
.blog-page-meta {
  font-size: .72rem;
  color: var(--muted-foreground);
}

/* Title — font-display, semibold, line-clamp 2 */
.blog-page-title {
  font-family: var(--font-display);
  font-weight: 600;
  font-size: 1.05rem;
  line-height: 1.35;
  margin-top: .5rem;
  color: var(--foreground);
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Excerpt — line-clamp 2 */
.blog-page-excerpt {
  font-size: .82rem;
  color: var(--muted-foreground);
  margin-top: .5rem;
  line-height: 1.6;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Footer row — likes left, read-more right */
.blog-page-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 1rem;
  font-size: .82rem;
}
.blog-page-likes {
  display: inline-flex;
  align-items: center;
  gap: .3rem;
  color: var(--muted-foreground);
}
.blog-page-likes svg {
  width: 15px;
  height: 15px;
  stroke: var(--accent);
  flex-shrink: 0;
}
.blog-page-read {
  color: var(--accent);
  font-weight: 600;
}

/* Fade-up for hero */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
.fade-up { animation: fadeUp .6s ease both; }
</style>


<?php
include '../components/Footer.php';
include '../components/Modals.php';

include '../includes/footer.php';
?>