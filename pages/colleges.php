<?php
/**
 * pages/colleges.php  ←→  src/routes/colleges.index.tsx  (CollegesList)
 */
session_start();
require_once '../data/iims.php';

$page_title       = 'All IIMs — Compare 14 Indian Institutes of Management';
$page_description = 'Browse all 14 IIMs by fees, placements, ranking, location and entrance exams.';
$current_page     = 'colleges';

// Filter parameters
$q            = trim($_GET['q']           ?? '');
$selCats      = (array)($_GET['cats']     ?? []);
$selExams     = (array)($_GET['exams']    ?? []);
$feeRange     = (int)($_GET['fee']        ?? 30);
$minPlacement = (int)($_GET['placement']  ?? 0);
$minRating    = (float)($_GET['rating']   ?? 0);

$CATS  = ['Management','Finance','Marketing','HR','Operations','Business Analytics','International Business'];
$EXAMS = ['CAT','GMAT','IPMAT'];

// Filter logic (mirrors React useMemo)
$filtered = array_values(array_filter($COLLEGES, function($c) use ($q,$selCats,$selExams,$feeRange,$minPlacement,$minRating) {
  if ($q && stripos($c['name'],$q)===false && stripos($c['location'],$q)===false) return false;
  if (!empty($selCats) && !array_intersect($selCats, $c['category'])) return false;
  if (!empty($selExams) && !array_intersect($selExams, $c['exams'])) return false;
  if ($c['fees'] > $feeRange) return false;
  if ($c['placement'] < $minPlacement) return false;
  if ($c['rating'] < $minRating) return false;
  return true;
}));

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ============================================================
     HERO + SEARCH BAR
     ============================================================ -->
<section class="gradient-hero pt-32 pb-20 text-white">
  <div class="container">
    <h1 class="font-display text-5xl md:text-6xl font-bold reveal">
      Discover all <span class="text-gradient-accent">14 IIMs</span>
    </h1>
    <p class="text-white-80 mt-4 text-lg max-w-2xl">
      Verified data on rankings, fees, placements and reviews — all IIMs in one place.
    </p>

    <form method="GET" action="colleges.php" class="college-search-form">
      <!-- Preserve other filters -->
      <?php foreach ($selCats  as $v): ?><input type="hidden" name="cats[]"  value="<?= htmlspecialchars($v) ?>"><?php endforeach; ?>
      <?php foreach ($selExams as $v): ?><input type="hidden" name="exams[]" value="<?= htmlspecialchars($v) ?>"><?php endforeach; ?>
      <input type="hidden" name="fee"       value="<?= $feeRange ?>">
      <input type="hidden" name="placement" value="<?= $minPlacement ?>">
      <input type="hidden" name="rating"    value="<?= $minRating ?>">

      <div class="college-search-wrap">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="search-icon">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search IIM by name or city" class="college-search-input" />
      </div>
    </form>
  </div>
</section>


<!-- ============================================================
     FILTER + GRID
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="colleges-layout">

      <!-- Sidebar filters -->
      <aside class="colleges-sidebar">
        <form method="GET" action="colleges.php" id="filter-form">
          <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">

          <div class="filter-section">
            <div class="filter-label">Course Type</div>
            <div class="filter-chips">
              <?php foreach ($CATS as $cat): ?>
                <label class="filter-chip-label">
                  <input type="checkbox" name="cats[]" value="<?= htmlspecialchars($cat) ?>"
                    <?= in_array($cat,$selCats)?'checked':'' ?> onchange="document.getElementById('filter-form').submit()">
                  <?= htmlspecialchars($cat) ?>
                </label>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="filter-section">
            <div class="filter-label">Entrance Exam</div>
            <div class="filter-chips">
              <?php foreach ($EXAMS as $ex): ?>
                <label class="filter-chip-label">
                  <input type="checkbox" name="exams[]" value="<?= htmlspecialchars($ex) ?>"
                    <?= in_array($ex,$selExams)?'checked':'' ?> onchange="document.getElementById('filter-form').submit()">
                  <?= htmlspecialchars($ex) ?>
                </label>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="filter-section">
            <div class="filter-label">Max Fees: ₹<?= $feeRange ?>L</div>
            <input type="range" name="fee" min="10" max="30" value="<?= $feeRange ?>" class="filter-range" onchange="document.getElementById('filter-form').submit()">
          </div>

          <div class="filter-section">
            <div class="filter-label">Min Placement: ₹<?= $minPlacement ?>L</div>
            <input type="range" name="placement" min="0" max="35" value="<?= $minPlacement ?>" class="filter-range" onchange="document.getElementById('filter-form').submit()">
          </div>

          <div class="filter-section">
            <div class="filter-label">Min Rating: <?= $minRating ?>★</div>
            <input type="range" name="rating" min="0" max="5" step="0.1" value="<?= $minRating ?>" class="filter-range" onchange="document.getElementById('filter-form').submit()">
          </div>

          <a href="colleges.php" class="btn btn-outline" style="width:100%;text-align:center">Reset filters</a>
        </form>
      </aside>

      <!-- Main area -->
      <div class="colleges-main">
        <div class="colleges-count"><?= count($filtered) ?> IIMs found</div>

        <?php if (empty($filtered)): ?>
          <div class="empty-state">
            <p class="text-muted">No IIMs match these filters.</p>
            <a href="colleges.php" class="btn btn-outline" style="margin-top:1rem;display:inline-flex">Reset</a>
          </div>
        <?php else: ?>
          <div class="colleges-grid">
            <?php foreach ($filtered as $index => $college): ?>
              <div class="reveal" style="transition-delay:<?= $index * 0.06 ?>s">
                <?php include '../components/CollegeCard.php'; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>