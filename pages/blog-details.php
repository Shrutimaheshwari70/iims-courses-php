<?php
/**
 * pages/blog-details.php  ←→  src/routes/blogs.$slug.tsx  (BlogDetail)
 */
session_start();
require_once '../data/iims.php';

$slug = trim($_GET['slug'] ?? '');
$b    = getBlog($slug);

if (!$b) {
  header('HTTP/1.0 404 Not Found');
  $page_title = 'Blog Not Found';
  include '../includes/header.php';
  include '../components/Navbar.php';
  echo '<section class="section" style="padding-top:8rem;text-align:center"><h1>Blog not found.</h1><p><a href="blogs.php" class="btn btn-outline" style="display:inline-flex;margin-top:1rem">← Back to blogs</a></p></section>';
  include '../components/Footer.php';
  include '../includes/footer.php';
  exit;
}

$page_title       = $b['title'].' — IIMs Courses';
$page_description = $b['excerpt'];
$current_page     = 'blogs';

// Handle comment submission
$comments = [
  ['name'=>'Riya P.',   'text'=>'This is gold. Saved me weeks of prep!'],
  ['name'=>'Manish K.', 'text'=>'Perfectly timed for CAT 2026 aspirants.'],
];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment_name']) && !empty($_POST['comment_text'])) {
  $comments[] = ['name'=>htmlspecialchars(trim($_POST['comment_name'])), 'text'=>htmlspecialchars(trim($_POST['comment_text']))];
}

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="blog-hero">
  <img src="<?= htmlspecialchars($b['image']) ?>" alt="<?= htmlspecialchars($b['title']) ?>" class="blog-hero-img" />
  <div class="blog-hero-overlay"></div>
  <div class="blog-hero-content">
    <div class="blog-meta text-white-80"><?= htmlspecialchars($b['date']) ?> &bull; <?= htmlspecialchars($b['author']) ?></div>
    <h1 class="blog-hero-title"><?= htmlspecialchars($b['title']) ?></h1>
  </div>
</section>


<!-- ============================================================
     ARTICLE BODY
     ============================================================ -->
<article class="blog-article container">

  <p class="blog-lead"><?= htmlspecialchars($b['excerpt']) ?></p>

  <p>
    The journey to an IIM is more than entrance scores — it's about a holistic profile, clear thinking
    and the right preparation strategy. In this guide we break down what worked for converters of the
    last cohort and what hasn't aged well.
  </p>
  <p>
    Section-wise focus, mock-test discipline and case-style WAT-PI training make all the difference
    in the final composite score. Combine these with a study calendar, peer review and the right mentor
    and you'll be in great shape.
  </p>

  <!-- Actions -->
  <div class="blog-actions">
    <button class="blog-like-btn" id="like-btn" onclick="toggleLike()">
      <svg id="like-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
      </svg>
      <span id="like-count"><?= (int)($b['likes'] ?? 0) ?></span>
    </button>
    <button class="blog-share-btn" onclick="navigator.share ? navigator.share({title:document.title,url:location.href}) : showToast('Link copied!','success')">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px">
        <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
      </svg>
      Share
    </button>
    <button class="btn btn-hero btn-sm" onclick="openModal('apply-modal')">Apply for Counselling</button>
  </div>

  <hr class="blog-divider" />

  <!-- Comments -->
  <h3>Comments (<?= count($comments) ?>)</h3>

  <form method="POST" action="blog-details.php?slug=<?= urlencode($slug) ?>" class="comment-form">
    <div class="form-group">
      <input type="text" name="comment_name" class="form-input" placeholder="Your name" required />
    </div>
    <div class="form-group">
      <textarea name="comment_text" class="form-textarea" rows="3" placeholder="Add your comment" required></textarea>
    </div>
    <button type="submit" class="btn btn-hero btn-sm">Post comment</button>
  </form>

  <ul class="comments-list">
    <?php foreach ($comments as $c): ?>
    <li class="comment-item">
      <div class="comment-name"><?= htmlspecialchars($c['name']) ?></div>
      <p class="comment-text"><?= htmlspecialchars($c['text']) ?></p>
    </li>
    <?php endforeach; ?>
  </ul>

  <hr class="blog-divider" />

  <!-- Recommended reads -->
  <h3>Recommended reads</h3>
  <div class="recommended-blogs">
    <?php foreach (array_slice(array_filter($BLOGS, fn($x) => $x['slug'] !== $slug), 0, 4) as $r): ?>
    <a href="blog-details.php?slug=<?= urlencode($r['slug']) ?>" class="rec-blog-item">
      <img src="<?= htmlspecialchars($r['image']) ?>" alt="" loading="lazy" />
      <div>
        <div class="rec-blog-title"><?= htmlspecialchars($r['title']) ?></div>
        <div class="rec-blog-date"><?= htmlspecialchars($r['date']) ?></div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>

</article>

<script>
let liked = false;
let likes = <?= (int)($b['likes'] ?? 0) ?>;
function toggleLike() {
  liked = !liked;
  likes += liked ? 1 : -1;
  document.getElementById('like-count').textContent = likes;
  const btn = document.getElementById('like-btn');
  btn.classList.toggle('liked', liked);
}
</script>

<?php
include '../components/Modals.php';
include '../components/Footer.php';
include '../includes/footer.php';
?>