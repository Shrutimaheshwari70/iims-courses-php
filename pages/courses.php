<?php
/**
 * pages/courses.php  ←→  src/routes/courses.index.tsx  (CoursesList)
 */
session_start();
require_once '../data/iims.php';

$page_title       = 'MBA & PGDM Courses at IIMs';
$page_description = 'Explore MBA, PGDM, Executive MBA, Business Analytics and more programmes at India\'s top IIMs.';
$current_page     = 'courses';

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="gradient-hero pt-32 pb-20 text-white">
  <div class="container">
    <h1 class="font-display text-5xl md:text-6xl font-bold reveal">
      All <span class="text-gradient-accent">programmes</span> at IIMs
    </h1>
    <p class="text-white-80 mt-4 text-lg max-w-2xl">
      From flagship MBA to executive education and analytics.
    </p>
  </div>
</section>


<!-- ============================================================
     COURSES GRID
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="courses-grid">
      <?php foreach ($COURSES as $i => $c): ?>
        <div class="course-card reveal" style="transition-delay:<?= $i * 0.05 ?>s">
          <a href="course-details.php?slug=<?= urlencode($c['slug']) ?>">
            <div class="course-img">
              <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['title']) ?>" loading="lazy" />
              <div class="course-img-overlay"></div>
              <span class="course-cat"><?= htmlspecialchars($c['category']) ?></span>
            </div>
            <div class="course-body">
              <h3 class="course-title"><?= htmlspecialchars($c['title']) ?></h3>
              <p class="course-desc"><?= htmlspecialchars($c['description']) ?></p>
              <div class="course-footer">
                <span class="course-price">₹<?= $c['fees'] ?>L &bull; <?= htmlspecialchars($c['duration']) ?></span>
                <span class="course-link">
                  View
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </span>
              </div>
              <div class="course-iim-chips">
                <?php foreach (array_slice($c['iims'],0,4) as $s):
                  $iim = getCollege($s);
                  if ($iim):
                ?>
                  <span class="course-iim-chip"><?= htmlspecialchars($iim['short']) ?></span>
                <?php endif; endforeach; ?>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>