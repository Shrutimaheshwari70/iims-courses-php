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

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="blogs-hero">
  <div class="container">
    <h1 class="blogs-hero-title fade-up">
      Blogs &amp; <span class="text-gradient-accent">insights</span>
    </h1>
    <p class="blogs-hero-desc fade-up" style="animation-delay:.1s">
      CAT prep, MBA strategy, placements and IIM stories — written by alumni &amp; experts.
    </p>
  </div>
</section>


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
              src="<?= htmlspecialchars($b['image']) ?>"
              alt="<?= htmlspecialchars($b['title']) ?>"
              loading="lazy"
            />
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


<style>
/* ===== BLOGS PAGE STYLES ===== */

/* Hero */
.blogs-hero {
  background-image: var(--gradient-hero);
  padding: 8rem 0 4rem;
  color: #fff;
}
.blogs-hero-title {
  font-family: var(--font-display);
  font-weight: 800;
  font-size: clamp(2.2rem, 5vw, 3.75rem);
  line-height: 1.1;
  letter-spacing: -0.02em;
}
.blogs-hero-desc {
  color: rgba(255,255,255,.80);
  margin-top: 1rem;
  font-size: 1.1rem;
  max-width: 600px;
  line-height: 1.7;
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

/* Card — same as TSX: rounded-2xl bg-card border shadow-soft */
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
include '../includes/footer.php';
?>