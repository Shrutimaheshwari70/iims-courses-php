<?php
/**
 * pages/course-details.php  ←→  src/routes/courses.$slug.tsx  (CourseDetail)
 */
session_start();
require_once '../data/iims.php';

$slug = trim($_GET['slug'] ?? '');
$c    = getCourse($slug);

if (!$c) {
  header('HTTP/1.0 404 Not Found');
  $page_title = 'Course Not Found';
  include '../includes/header.php';
  include '../components/Navbar.php';
  echo '<section class="section" style="padding-top:8rem;text-align:center"><h1>Course not found.</h1><p><a href="courses.php" class="btn btn-outline" style="display:inline-flex;margin-top:1rem">← Back to courses</a></p></section>';
  include '../components/Footer.php';
  include '../includes/footer.php';
  exit;
}

$page_title       = $c['title'].' — IIMs';
$page_description = $c['description'];
$current_page     = 'courses';

$iims = array_values(array_filter(array_map(fn($s) => getCollege($s), $c['iims'])));

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="cd-hero">
  <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['title']) ?>" class="cd-hero-img" />
  <div class="cd-hero-overlay"></div>
  <div class="cd-hero-content">
    <span class="cd-rank-badge"><?= htmlspecialchars($c['category']) ?></span>
    <h1 class="cd-hero-title" style="max-width:900px"><?= htmlspecialchars($c['title']) ?></h1>
    <div class="cd-hero-meta">
      <span><?= htmlspecialchars($c['duration']) ?></span>
      <span>₹<?= $c['fees'] ?>L</span>
      <span><?= htmlspecialchars($c['mode']) ?></span>
    </div>
    <div class="cd-hero-actions">
      <button class="btn btn-hero" onclick="openModal('apply-modal')">
        Apply Now
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </button>
      <button class="btn btn-outline-white" onclick="alert('Brochure download coming soon!')">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Brochure
      </button>
    </div>
  </div>
</section>


<!-- ============================================================
     MAIN CONTENT + SIDEBAR
     ============================================================ -->
<div class="container course-detail-layout">

  <!-- Left column -->
  <div class="course-detail-main">

    <!-- Overview -->
    <section class="cd-section reveal">
      <h2 class="cd-section-title">Overview</h2>
      <p class="text-muted leading-relaxed"><?= htmlspecialchars($c['description']) ?></p>
      <p class="text-muted leading-relaxed mt-3"><strong>Eligibility:</strong> <?= htmlspecialchars($c['eligibility']) ?></p>
    </section>

    <!-- Curriculum -->
    <section class="cd-section reveal">
      <h2 class="cd-section-title">Curriculum</h2>
      <div class="curriculum-list">
        <?php foreach ($c['curriculum'] as $sem): ?>
        <div class="curriculum-item">
          <div class="curriculum-sem"><?= htmlspecialchars($sem['sem']) ?></div>
          <div class="curriculum-topics">
            <?php foreach ($sem['topics'] as $t): ?>
              <span class="topic-chip"><?= htmlspecialchars($t) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Offered at IIMs -->
    <section class="cd-section reveal">
      <h2 class="cd-section-title">Offered at IIMs</h2>
      <div class="iim-links-grid">
        <?php foreach ($iims as $iim): ?>
        <a href="college-details.php?slug=<?= urlencode($iim['slug']) ?>" class="iim-link-card">
          <img src="<?= htmlspecialchars($iim['image']) ?>" alt="" loading="lazy" />
          <div>
            <div class="iim-link-name"><?= htmlspecialchars($iim['name']) ?></div>
            <div class="iim-link-meta"><?= htmlspecialchars($iim['location']) ?></div>
            <div class="iim-link-fees">★ <?= $iim['rating'] ?> &bull; ₹<?= $iim['fees'] ?>L</div>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- FAQs -->
    <section class="cd-section reveal">
      <h2 class="cd-section-title">FAQs</h2>
      <div class="faq-wrap">
        <?php foreach ($FAQS as $faq): ?>
        <div class="faq-item">
          <div class="faq-question">
            <?= htmlspecialchars($faq['q']) ?>
            <svg class="faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </div>
          <div class="faq-answer"><?= htmlspecialchars($faq['a']) ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

  </div><!-- /course-detail-main -->

  <!-- Sidebar -->
  <aside class="course-detail-sidebar">
    <div class="sidebar-callback-card">
      <h3 class="sidebar-title">Get a free callback</h3>
      <form onsubmit="event.preventDefault();openModal('apply-modal')" class="sidebar-form">
        <div class="form-group">
          <label class="form-label">Name</label>
          <input type="text" class="form-input" required />
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" class="form-input" required />
        </div>
        <div class="form-group">
          <label class="form-label">Phone</label>
          <input type="tel" class="form-input" required />
        </div>
        <button type="submit" class="btn btn-hero" style="width:100%">Request Callback</button>
      </form>
    </div>
  </aside>

</div><!-- /course-detail-layout -->


<!-- ============================================================
     RECOMMENDED PROGRAMMES
     ============================================================ -->
<section class="section">
  <div class="container">
    <h3 class="cd-section-title" style="font-size:1.75rem;margin-bottom:1.5rem">Recommended Programmes</h3>
    <div class="courses-grid" style="grid-template-columns:repeat(3,1fr)">
      <?php foreach (array_slice(array_filter($COURSES, fn($x)=>$x['slug']!==$slug), 0, 3) as $r): ?>
      <a href="course-details.php?slug=<?= urlencode($r['slug']) ?>" class="rec-course-card reveal">
        <div class="rec-course-cat"><?= htmlspecialchars($r['category']) ?></div>
        <div class="rec-course-title"><?= htmlspecialchars($r['title']) ?></div>
        <div class="rec-course-meta"><?= htmlspecialchars($r['duration']) ?> &bull; ₹<?= $r['fees'] ?>L</div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
include '../components/Modals.php';
include '../components/Footer.php';
include '../includes/footer.php';
?>ss