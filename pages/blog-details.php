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
  echo '<div class="pt-32 text-center">Blog not found.</div>';
  include '../components/Footer.php';
  include '../includes/footer.php';
  exit;
}

$page_title       = $b['title'] . ' — IIMs Courses';
$page_og_image    = $b['image'];
$current_page     = 'blogs';s

// Handle comment submission
$comments = [
  ['name' => 'Riya P.',   'text' => 'This is gold. Saved me weeks of prep!'],
  ['name' => 'Manish K.', 'text' => 'Perfectly timed for CAT 2026 aspirants.'],
];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment_name']) && !empty($_POST['comment_text'])) {
  array_unshift($comments, [
    'name' => htmlspecialchars(trim($_POST['comment_name'])),
    'text' => htmlspecialchars(trim($_POST['comment_text'])),
  ]);
}

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ============================================================
     HERO  (h-[50vh] min-h-[340px] overflow-hidden)
     ============================================================ -->
<section class="relative h-[50vh] min-h-[340px] overflow-hidden" style="position:relative;min-height:340px;height:50vh;overflow:hidden;">
  <img
    src="../assets/images/iim-a.jpg"
    alt="<?= htmlspecialchars($b['title']) ?>"
    style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;"
/>
  <div class="gradient-overlay" style="position:absolute;inset:0;"></div>
  <div style="position:relative;height:100%;margin-left:auto;margin-right:auto;max-width:56rem;padding-left:1.5rem;padding-right:1.5rem;display:flex;flex-direction:column;justify-content:flex-end;padding-bottom:3rem;color:#fff;">
    <div style="font-size:0.875rem;color:rgba(255,255,255,0.8);">
      <?= htmlspecialchars($b['date']) ?> &bull; <?= htmlspecialchars($b['author']) ?>
    </div>
    <h1 class="font-display font-bold" style="margin-top:0.75rem;font-size:clamp(1.875rem,5vw,3rem);font-weight:700;">
      <?= htmlspecialchars($b['title']) ?>
    </h1>
  </div>
</section>


<!-- ============================================================
     ARTICLE BODY  (max-w-3xl prose prose-lg)
     ============================================================ -->
<article style="margin-left:auto;margin-right:auto;max-width:1300px;padding:3rem 1.5rem;" class="prose prose-lg dark:prose-invert">

  <p style="font-size:1.125rem;color:var(--muted-foreground);line-height:1.75rem;">
    <?= htmlspecialchars($b['excerpt']) ?>
  </p>
  <p style="line-height:1.75rem;">
    The journey to an IIM is more than entrance scores — it's about a holistic profile, clear thinking
    and the right preparation strategy. In this guide we break down what worked for converters of the
    last cohort and what hasn't aged well.
  </p>
  <p style="line-height:1.75rem;">
    Section-wise focus, mock-test discipline and case-style WAT-PI training make all the difference
    in the final composite score. Combine these with a study calendar, peer review and the right mentor
    and you'll be in great shape.
  </p>

  <!-- ── Like / Share / Apply actions ── -->
  <div style="display:flex;align-items:center;gap:0.75rem;margin-top:2rem;">

    <!-- Like button -->
    <button
      id="like-btn"
      onclick="toggleLike()"
      style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;border-radius:9999px;border:1px solid var(--border);transition:color .2s,background .2s;cursor:pointer;background:transparent;"
    >
      <!-- Heart icon (lucide Heart) -->
      <svg id="like-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
           fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
      </svg>
      <span id="like-count"><?= (int)($b['likes'] ?? 0) ?></span>
    </button>

    <!-- Share button -->
    <button
      onclick="if(navigator.share){navigator.share({title:document.title,url:location.href});}else{navigator.clipboard&&navigator.clipboard.writeText(location.href);}"
      style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;border-radius:9999px;border:1px solid var(--border);background:transparent;cursor:pointer;transition:border-color .2s;"
    >
      <!-- Share2 icon (lucide Share2) -->
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
           fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
      </svg>
      Share
    </button>

    <!-- Apply for Counselling (Button variant="hero" size="sm") -->
    <button
      class="btn btn-hero btn-sm"
      onclick="openModal('apply-modal')"
    >
      Apply for Counselling
    </button>

  </div>

  <hr style="margin:2.5rem 0;" />

  <!-- ── Comments ── -->
  <h3 class="font-display">Comments (<?= count($comments) ?>)</h3>

  <!-- Comment form (maps to the React <form onSubmit=...>) -->
  <form
    method="POST"
    action="blog-details.php?slug=<?= urlencode($slug) ?>"
    style="display:grid;gap:0.75rem;margin-bottom:1.5rem;"
  >
    <!-- Input placeholder="Your name" -->
    <input
      type="text"
      name="comment_name"
      class="form-input"
      placeholder="Your name"
      style="border-radius:0.375rem;border:1px solid var(--border);background:var(--background);padding:0.5rem 0.75rem;font-size:0.875rem;width:100%;box-sizing:border-box;"
      required
    />
    <!-- textarea rows=3 placeholder="Add your comment" -->
    <textarea
      name="comment_text"
      rows="3"
      placeholder="Add your comment"
      style="border-radius:0.375rem;border:1px solid var(--border);background:var(--background);padding:0.5rem 0.75rem;font-size:0.875rem;width:100%;box-sizing:border-box;"
      required
    ></textarea>
    <!-- Button type="submit" variant="hero" size="sm" className="w-fit" -->
    <button type="submit" class="btn btn-hero btn-sm" style="width:fit-content;">Post comment</button>
  </form>

  <!-- Comments list -->
  <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0.75rem;">
    <?php foreach ($comments as $c): ?>
    <li style="border-radius:0.75rem;border:1px solid var(--border);padding:1rem;background:var(--card);">
      <div style="font-weight:600;font-size:0.875rem;"><?= htmlspecialchars($c['name']) ?></div>
      <p style="font-size:0.875rem;color:var(--muted-foreground);margin-top:0.25rem;"><?= htmlspecialchars($c['text']) ?></p>
    </li>
    <?php endforeach; ?>
  </ul>

  <hr style="margin:2.5rem 0;" />

  <!-- ── Recommended reads ── -->
  <h3 class="font-display">Recommended reads</h3>

  <!--
    BLOGS.filter(x => x.slug !== b.slug).slice(0,4)
    grid sm:grid-cols-2 gap-4
  -->
  <ul style="list-style:none;padding:0;margin:0;display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1rem;">
    <?php
    $recommended = array_values(array_filter($BLOGS, fn($x) => $x['slug'] !== $slug));
    $recommended = array_slice($recommended, 0, 4);
    foreach ($recommended as $r):
    ?>
    <li>
      <a
        href="blog-details.php?slug=<?= urlencode($r['slug']) ?>"
        style="border-radius:0.75rem;border:1px solid var(--border);padding:1rem;background:var(--card);display:flex;gap:0.75rem;text-decoration:none;color:inherit;transition:box-shadow .2s;"
        onmouseover="this.style.boxShadow='var(--shadow-card, 0 4px 16px rgba(0,0,0,.12))';"
        onmouseout="this.style.boxShadow='none';"
      >
        <img
    src="../assets/images/iim-b.jpg"
        
    alt="<?= htmlspecialchars($b['title']) ?>"
          loading="lazy"
          style="width:4rem;height:4rem;border-radius:0.375rem;object-fit:cover;flex-shrink:0;"
        />
        <div>
          <div style="font-weight:500;font-size:0.7rem;"><?= htmlspecialchars($r['title']) ?></div>
          <div style="font-size:0.75rem;color:var(--muted-foreground);margin-top:0.25rem;"><?= htmlspecialchars($r['date']) ?></div>
        </div>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>

</article>


<!-- ============================================================
     LIKE TOGGLE SCRIPT  (mirrors React useState toggleLike logic)
     ============================================================ -->
<script>
var liked = false;
var likes = <?= (int)($b['likes'] ?? 0) ?>;

function toggleLike() {
  liked = !liked;
  likes += liked ? 1 : -1;
  document.getElementById('like-count').textContent = likes;

  var btn  = document.getElementById('like-btn');
  var icon = document.getElementById('like-icon');

  if (liked) {
    // gradient-accent text-white border-transparent  (active state)
    btn.classList.add('gradient-accent');
    btn.style.color            = '#fff';
    btn.style.borderColor      = 'transparent';
    icon.setAttribute('fill', 'currentColor');
  } else {
    btn.classList.remove('gradient-accent');
    btn.style.color            = '';
    btn.style.borderColor      = '';
    icon.setAttribute('fill', 'none');
  }
}
</script>

<?php
include '../components/Modals.php';   // renders <div id="apply-modal">…</div>  (ApplyModal)
include '../components/Footer.php';
include '../includes/footer.php';
?>