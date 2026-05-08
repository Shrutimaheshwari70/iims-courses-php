<?php
/**
 * pages/blogs.php  ←→  src/routes/blogs.index.tsx  (BlogsList)
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
<section class="gradient-hero pt-32 pb-16 text-white">
  <div class="container">
    <h1 class="font-display text-5xl md:text-6xl font-bold">
      Blogs &amp; <span class="text-gradient-accent">insights</span>
    </h1>
    <p class="text-white-80 mt-4 text-lg max-w-2xl">
      CAT prep, MBA strategy, placements and IIM stories — written by alumni &amp; experts.
    </p>
  </div>
</section>


<!-- ============================================================
     BLOG GRID
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="blogs-grid">
      <?php foreach ($BLOGS as $i => $b): ?>
        <a href="blog-details.php?slug=<?= urlencode($b['slug']) ?>" class="blog-card reveal" style="transition-delay:<?= $i * 0.06 ?>s">
          <div class="blog-img">
            <img src="<?= htmlspecialchars($b['image']) ?>" alt="<?= htmlspecialchars($b['title']) ?>" loading="lazy" />
          </div>
          <div class="blog-body">
            <div class="blog-meta"><?= htmlspecialchars($b['date']) ?> &bull; <?= htmlspecialchars($b['author']) ?></div>
            <h3 class="blog-title"><?= htmlspecialchars($b['title']) ?></h3>
            <p class="blog-excerpt"><?= htmlspecialchars($b['excerpt']) ?></p>
            <div class="blog-footer">
              <span class="blog-likes">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <?= (int)($b['likes'] ?? 0) ?>
              </span>
              <span class="blog-read-more">Read latest →</span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>