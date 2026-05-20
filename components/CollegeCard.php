<?php
/**
 * components/CollegeCard.php
 */

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Current page slug
$slug = trim($_GET['slug'] ?? '');

// Session wishlist / compare
$wishlist = $_SESSION['wishlist'] ?? [];
$compare  = $_SESSION['compare'] ?? [];

$inWish = in_array($college['slug'], $wishlist, true);
$inCmp  = in_array($college['slug'], $compare, true);
$isFull = count($compare) >= 3;

/* ─────────────────────────────
   HANDLE WISHLIST
───────────────────────────── */
if (isset($_GET['wish'])) {

  if ($inWish) {
    $wishlist = array_values(
      array_filter($wishlist, fn($s) => $s !== $slug)
    );
  } else {
    $wishlist[] = $slug;
  }

  $_SESSION['wishlist'] = $wishlist;

  header('Location: college-details.php?slug=' . urlencode($slug));
  exit;
}

/* ─────────────────────────────
   HANDLE COMPARE
───────────────────────────── */
if (isset($_GET['cmp'])) {

  if (!isset($_SESSION['compare'])) {
    $_SESSION['compare'] = [];
  }

  if (in_array($slug, $_SESSION['compare'], true)) {

    $_SESSION['compare'] = array_values(
      array_filter(
        $_SESSION['compare'],
        fn($s) => $s !== $slug
      )
    );

  } else {

    if (count($_SESSION['compare']) < 3) {
      $_SESSION['compare'][] = $slug;
    }
  }

  header('Location: college-details.php?slug=' . urlencode($slug));
  exit;
}

/* ─────────────────────────────
   PATHS
───────────────────────────── */

$assetBase = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false)
  ? '../assets/'
  : 'assets/';

$imgFile = preg_replace(
  '#^(\.\./)*assets/images/#',
  '',
  $college['image']
);

$imgSrc = $assetBase . 'images/' . $imgFile;

$cats_display = array_slice($college['category'], 0, 5);
$detailsLink = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false)
  ? "college-details.php?slug={$college['slug']}"
  : "pages/college-details.php?slug={$college['slug']}";

$pageBase = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false)
  ? ''
  : 'pages/';
?>

<link rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="college-card h-100 overflow-hidden rounded-3 fade-up"
  style="animation-delay:<?= ($index ?? 0) * 0.06 ?>s">

  <!-- IMAGE -->
  <div class="college-card-img rounded-3 overflow-hidden">

    <img
      src="<?= htmlspecialchars($imgSrc) ?>"
      alt="<?= htmlspecialchars($college['name']) ?>"
      loading="lazy"
      class="object-fit-cover" />

    <div class="college-card-img-overlay"></div>

    <!-- ACTION BUTTONS -->
    <div class="college-card-actions">
<!-- WISHLIST -->
<a 
href="<?= $pageBase ?>wishlist.php?add=<?= urlencode($college['slug']) ?>"
   class="cd-circle-btn <?= $inWish ? 'active-wish' : '' ?>"
   title="Wishlist">

  <svg xmlns="http://www.w3.org/2000/svg"
       viewBox="0 0 24 24"
       fill="<?= $inWish ? 'currentColor' : 'none' ?>"
       stroke="currentColor"
       stroke-width="2">

    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
  </svg>
</a>

<!-- COMPARE -->
<?php if ($inCmp): ?>

  <a 
  href="<?= $pageBase ?>compare.php?remove=<?= urlencode($college['slug']) ?>"
     class="cd-circle-btn active-compare"
     title="Remove from Compare">

    <i class="bi bi-check2"></i>
  </a>

<?php elseif ($isFull): ?>

  <button class="cd-circle-btn disabled-compare"
          disabled
          title="Compare Limit Reached">

    <i class="bi bi-slash-circle"></i>
  </button>

<?php else: ?>
  
<a href="<?= $pageBase ?>compare.php?add=<?= urlencode($college['slug']) ?>"
     class="cd-circle-btn"
     title="Add to Compare">

    <svg xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2">

      <polyline points="16 3 21 3 21 8" />
      <line x1="4" y1="20" x2="21" y2="3" />
      <polyline points="21 16 21 21 16 21" />
      <line x1="15" y1="15" x2="21" y2="21" />
    </svg>
  </a>

<?php endif; ?>
    </div>

    <!-- RANK -->
    <div class="college-card-rank px-1 rounded-1 d-flex align-items-center">
      NIRF #<?= $college['ranking'] ?>
    </div>

    <!-- NAME -->
    <div class="college-card-name">
      <h3><?= htmlspecialchars($college['name']) ?></h3>

      <div class="loc">
        <?= htmlspecialchars($college['location']) ?>
      </div>
    </div>

  </div>

  <!-- BODY -->
  <div class="college-card-body">

    <div class="college-card-meta">
      <span>
        <?= $college['rating'] ?>
        <i class="bi bi-star-fill text-warning"></i>
      </span>

      <span>•</span>

      <span>
        Est. <?= $college['established'] ?>
      </span>
    </div>

    <!-- STATS -->
    <div class="college-stats">

      <div class="college-stat">
        <div class="college-stat-label">
          Total Fees
        </div>

        <div class="college-stat-value">
          ₹<?= $college['fees'] ?>L
        </div>
      </div>

      <div class="college-stat">
        <div class="college-stat-label">
          Avg Placement
        </div>

        <div class="college-stat-value">
          ₹<?= $college['placement'] ?>L
        </div>
      </div>

    </div>

    <!-- TAGS -->
    <div class="college-tags">

      <?php foreach ($cats_display as $cat): ?>

        <span class="college-tag">
          <?= htmlspecialchars($cat) ?>
        </span>

      <?php endforeach; ?>

    </div>

    <!-- FOOTER -->
    <div class="college-card-footer">

      <button
        class="btn btn-hero btn-sm"
        onclick="openApplyModal()">

        Apply Now
      </button>

      <a href="<?= $detailsLink ?>"
        class="btn btn-outline btn-sm text-dark border">

        View Details
      </a>

    </div>

  </div>

</div>

<style>

.college-card{
  background:var(--card);
  border:1px solid var(--border);
  box-shadow:var(--shadow-soft);
  transition:.3s;
  display:flex;
  flex-direction:column;
}

.college-card:hover{
  transform:translateY(-4px);
  box-shadow:var(--shadow-elegant);
}

.college-card-img{
  position:relative;
  height:192px;
  flex-shrink:0;
}

.college-card-img img{
  width:100%;
  height:100%;
  transition:.5s;
}

.college-card:hover .college-card-img img{
  transform:scale(1.05);
}

.college-card-img-overlay{
  position:absolute;
  inset:0;
  background:linear-gradient(to top,rgba(0,0,0,.7),transparent);
}

/* ACTIONS — vertical stack, top-right */
.college-card-actions{
  position:absolute;
  top:12px;
  right:12px;
  display:flex;
  flex-direction:column;
  gap:6px;
  z-index:5;
}

/* ICON BUTTON BASE */
.cd-circle-btn{
  width:34px;
  height:34px;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  background:rgba(255,255,255,.15);
  border:1.5px solid rgba(255,255,255,.35);
  backdrop-filter:blur(10px);
  -webkit-backdrop-filter:blur(10px);
  color:#fff;
  text-decoration:none;
  cursor:pointer;
  transition:background .2s, border-color .2s, transform .2s;
}

.cd-circle-btn:hover{
  transform:translateY(-1px);
  background:rgba(255,255,255,.25);
  border-color:rgba(255,255,255,.6);
  color:#fff;
}

.cd-circle-btn svg{
  width:16px;
  height:16px;
  flex-shrink:0;
}

.cd-circle-btn i{
  font-size:15px;
  line-height:1;
}

/* WISHLIST — active */
.active-wish{
  background: var(--accent);
  border-color:#ff4d6d;
  color:#fff;
}

.active-wish:hover{
  background:#e6354f;
  border-color:#e6354f;
  color:#fff;
}

/* COMPARE — active */
.active-compare{
  background:#ff7a00;
  border-color:#ff7a00;
  color:#fff;
}

.active-compare:hover{
  background:#e06c00;
  border-color:#e06c00;
  color:#fff;
}

/* COMPARE — limit reached */
.disabled-compare{
  background:rgba(255,255,255,.08);
  border-color:rgba(255,255,255,.15);
  color:rgba(255,255,255,.35);
  opacity:1;
  cursor:not-allowed;
  pointer-events:none;
}

/* RANK */
.college-card-rank{
  position:absolute;
  top:12px;
  left:12px;
  background:#fff;
  color:#111827;
  font-size:.7rem;
  font-weight:600;
  z-index:2;
}

/* NAME */
.college-card-name{
  position:absolute;
  left:12px;
  right:12px;
  bottom:12px;
  z-index:2;
}

.college-card-name h3{
  color:#fff;
  font-size:1.05rem;
  font-weight:700;
  line-height:1.25;
  margin:0;
}

.college-card-name .loc{
  color:rgba(255,255,255,.85);
  font-size:.72rem;
  margin-top:.15rem;
}

/* BODY — flex grow so footer always bottom */
.college-card-body{
  padding:1.25rem;
  display:flex;
  flex-direction:column;
  flex:1;
}

.college-card-meta{
  display:flex;
  gap:.75rem;
  font-size:.85rem;
}

/* STATS */
.college-stats{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:.75rem;
  margin-top:1rem;
}

.college-stat{
  background:var(--secondary);
  border-radius:8px;
  padding:.75rem;
}

.college-stat-label{
  font-size:.6rem;
  text-transform:uppercase;
  letter-spacing:.08em;
  color:var(--muted-foreground);
  font-weight:600;
}

.college-stat-value{
  font-size:1.1rem;
  font-weight:700;
}

/* TAGS */
.college-tags{
  display:flex;
  flex-wrap:wrap;
  gap:.3rem;
  margin-top:.75rem;
  flex:1;
  align-content:flex-start;
}

.college-tag{
  font-size:.6rem;
  padding:.2rem .6rem;
  border-radius:999px;
  background:var(--secondary);
}

/* FOOTER — always at bottom, buttons centered */
.college-card-footer{
  display:flex;
  gap:.5rem;
  margin-top:1.25rem;
  justify-content:center;
  align-items:center;
}

.college-card-footer .btn{
  flex:1;
  text-align:center;
  justify-content:center;
  display:inline-flex;
  align-items:center;
}

/* MOBILE */
@media(max-width:575px){
  .college-card-img    { height:170px; }
  .college-card-name h3{ font-size:.95rem; }
  .college-card-body   { padding:1rem; }
  .college-stat-value  { font-size:1rem; }
}

</style>