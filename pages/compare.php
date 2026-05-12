<?php
/**
 * compare.php
 * Compare up to 3 IIMs side-by-side.
 * Full PHP conversion of src/routes/compare.tsx
 */
session_start();
require_once __DIR__ . '/../data/iims.php';

$page_title       = 'Compare IIMs Side-by-Side';
$page_description = 'Compare IIMs on fees, placements, faculty, ranking and more.';
$current_page     = 'compare';

/* ── session management ── */
$compareList = $_SESSION['compare'] ?? [];

if (isset($_GET['add'])) {
    $slug = trim($_GET['add']);
    if (!in_array($slug, $compareList) && count($compareList) < 3)
        $compareList[] = $slug;
    $_SESSION['compare'] = $compareList;
    header('Location: compare.php'); exit;
}
if (isset($_GET['remove'])) {
    $compareList = array_filter($compareList, fn($s) => $s !== $_GET['remove']);
    $_SESSION['compare'] = array_values($compareList);
    header('Location: compare.php'); exit;
}
if (isset($_GET['clear'])) {
    $_SESSION['compare'] = [];
    header('Location: compare.php'); exit;
}

$colleges = array_values(array_filter(array_map(fn($s) => getCollege($s), $compareList)));

$rows = [
    'Location'        => fn($c) => htmlspecialchars($c['location']),
    'Established'     => fn($c) => htmlspecialchars($c['established']),
    'NIRF Ranking'    => fn($c) => '#' . htmlspecialchars($c['ranking']),
    'Rating'          => fn($c) => '★ ' . htmlspecialchars($c['rating']),
    'Total Fees'      => fn($c) => '₹' . htmlspecialchars($c['fees']) . 'L',
    'Avg Placement'   => fn($c) => '₹' . htmlspecialchars($c['placement']) . 'L',
    'Highest Package' => fn($c) => '₹' . htmlspecialchars($c['highest']) . 'L',
    'Faculty'         => fn($c) => htmlspecialchars($c['faculty']) . '+',
    'Intake'          => fn($c) => htmlspecialchars($c['intake']),
    'Exams'           => fn($c) => htmlspecialchars(implode(', ', $c['exams'])),
];

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ════════════════════════════════════════════════════════════
     PAGE-SCOPED STYLES  (keep below Navbar, above content)
     ════════════════════════════════════════════════════════════ -->
<style>
/* ── tokens ── */
:root {
  --cmp-bg:          var(--background, #ffffff);
  --cmp-card-bg:     var(--card, #ffffff);
  --cmp-border:      var(--border, #e5e7eb);
  --cmp-muted:       var(--muted-foreground, #6b7280);
  --cmp-secondary:   var(--secondary, #f3f4f6);
  --cmp-hero-bg:     var(--hero-bg, #111827);
  --cmp-hero-fg:     var(--hero-fg, #ffffff);
  --cmp-outline-fg:  var(--foreground, #111827);
  --cmp-radius:      1rem;
  --cmp-shadow:      0 2px 12px rgba(0,0,0,.08);
  --cmp-transition:  .2s ease;
}

/* ── layout wrappers ── */
.cmp-section        { padding-top: 7rem; padding-bottom: 5rem; }
.cmp-container      { max-width: 80rem; margin: 0 auto; padding: 0 1.5rem; }

/* ── page header ── */
.cmp-page-header    { display: flex; align-items: center; justify-content: space-between;
                       flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; }
.cmp-page-title     { font-weight: 700; font-size: clamp(1.75rem, 4vw, 3rem);
                       line-height: 1.15; margin: 0; }
.cmp-page-sub       { color: var(--cmp-muted); margin-top: .5rem; font-size: .95rem; }
.cmp-clear-btn      { font-size: .875rem; color: var(--cmp-muted); background: none;
                       border: none; cursor: pointer; padding: .25rem .5rem;
                       border-radius: .375rem; transition: color var(--cmp-transition); }
.cmp-clear-btn:hover{ color: var(--cmp-outline-fg); }

/* ── cards grid ── */
.cmp-cards-grid {
  display: grid;
  gap: 1.25rem;
  margin-bottom: 2rem;
}
/* column counts set inline via style; breakpoints below override */

.cmp-card {
  border: 1px solid var(--cmp-border);
  background: var(--cmp-card-bg);
  border-radius: var(--cmp-radius);
  overflow: hidden;
  box-shadow: var(--cmp-shadow);
  transition: box-shadow var(--cmp-transition), transform var(--cmp-transition);
}
.cmp-card:hover      { box-shadow: 0 6px 24px rgba(0,0,0,.13); transform: translateY(-2px); }

.cmp-card-img        { position: relative; height: 8rem; overflow: hidden; }
.cmp-card-img img    { width: 100%; height: 100%; object-fit: cover;
                        display: block; transition: transform .4s ease; }
.cmp-card:hover .cmp-card-img img { transform: scale(1.04); }

.cmp-card-body       { padding: 1rem; }
.cmp-card-name       { font-weight: 600; font-size: 1rem; line-height: 1.3; }
.cmp-card-loc        { font-size: .75rem; color: var(--cmp-muted); margin-top: .2rem; }
.cmp-card-actions    { display: flex; gap: .5rem; margin-top: .75rem; align-items: center; }

/* ── buttons ── */
.btn-hero {
  display: inline-flex; align-items: center; justify-content: center;
  gap: .4rem; padding: .55rem 1.1rem; font-size: .85rem; font-weight: 600;
  border-radius: .6rem; background: var(--cmp-hero-bg); color: var(--cmp-hero-fg);
  border: none; cursor: pointer; text-decoration: none;
  transition: opacity var(--cmp-transition), transform var(--cmp-transition);
  white-space: nowrap;
}
.btn-hero:hover      { opacity: .85; transform: translateY(-1px); }
.btn-hero.flex-1     { flex: 1; }

.btn-outline {
  display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
  padding: .55rem 1.2rem; font-size: .85rem; font-weight: 600; border-radius: .6rem;
  background: transparent; color: var(--cmp-outline-fg);
  border: 1.5px solid var(--cmp-border); cursor: pointer; text-decoration: none;
  transition: background var(--cmp-transition), border-color var(--cmp-transition);
  white-space: nowrap;
}
.btn-outline:hover   { background: var(--cmp-secondary); border-color: #9ca3af; }

.btn-icon {
  width: 2rem; height: 2rem; padding: 0; flex-shrink: 0;
  border-radius: .5rem; background: none; border: none; cursor: pointer;
  display: inline-flex; align-items: center; justify-content: center;
  color: var(--cmp-muted); transition: background var(--cmp-transition), color var(--cmp-transition);
}
.btn-icon:hover      { background: var(--cmp-secondary); color: var(--cmp-outline-fg); }
.btn-icon svg        { width: 1rem; height: 1rem; }

/* ── table ── */
.cmp-table-wrap {
  border: 1px solid var(--cmp-border);
  background: var(--cmp-card-bg);
  border-radius: var(--cmp-radius);
  overflow: hidden;
  box-shadow: var(--cmp-shadow);
  overflow-x: auto;          /* scroll on very small screens */
}
.cmp-table           { width: 100%; border-collapse: collapse; font-size: .875rem; }
.cmp-table tr.row-alt{ background: rgba(243,244,246,.6); }
.cmp-table td        { padding: 1rem; border-bottom: 1px solid var(--cmp-border); vertical-align: middle; }
.cmp-table tbody tr:last-child td { border-bottom: none; }
.cmp-label           { font-weight: 600; min-width: 11rem; white-space: nowrap;
                        color: var(--cmp-outline-fg); }
.cmp-cell            { color: var(--cmp-outline-fg); }

/* ── add-more CTA ── */
.cmp-add-more        { text-align: center; margin-top: 1.5rem; }

/* ── empty state ── */
.cmp-empty           { padding-top: 8rem; padding-bottom: 5rem; text-align: center; }
.cmp-empty .cmp-container { max-width: 44rem; }
.cmp-empty-title     { font-weight: 700; font-size: clamp(1.75rem, 4vw, 2.5rem); }
.cmp-empty-sub       { color: var(--cmp-muted); margin-top: .75rem; }
.cmp-empty .btn-hero { margin-top: 1.5rem; font-size: .95rem; padding: .7rem 1.8rem; }
.cmp-empty .btn-hero svg { width: 1.1rem; height: 1.1rem; }

/* ── responsive ── */
@media (max-width: 900px) {
  .cmp-label { min-width: 8rem; }
}
@media (max-width: 640px) {
  .cmp-cards-grid      { grid-template-columns: 1fr !important; }
  .cmp-page-header     { flex-direction: column; align-items: flex-start; }
  .cmp-label           { min-width: 7rem; font-size: .8rem; }
  .cmp-table td        { padding: .65rem .75rem; font-size: .8rem; }
  .cmp-card-img        { height: 6rem; }
}
@media (min-width: 641px) and (max-width: 1023px) {
  /* 2-col grid stays as set by inline style; ensure readable labels */
  .cmp-label { min-width: 9rem; }
}
</style>

<?php if (empty($colleges)): ?>
<!-- ═══════════════════  EMPTY STATE  ═══════════════════ -->
<section class="cmp-empty">
  <div class="cmp-container">
    <h1 class="cmp-empty-title">Compare IIMs</h1>
    <p class="cmp-empty-sub">Add up to 3 IIMs to compare side-by-side.</p>
    <a href="colleges.php" class="btn-hero" style="display:inline-flex">
      Browse IIMs
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
           stroke="currentColor" stroke-width="2" aria-hidden="true">
        <line x1="5" y1="12" x2="19" y2="12"/>
        <polyline points="12 5 19 12 12 19"/>
      </svg>
    </a>
  </div>
</section>

<?php else: ?>
<!-- ═══════════════════  COMPARE PAGE  ═══════════════════ -->
<section class="cmp-section">
  <div class="cmp-container">

    <!-- Page header -->
    <div class="cmp-page-header">
      <div>
        <h1 class="cmp-page-title">Compare IIMs</h1>
        <p class="cmp-page-sub">Side-by-side: fees, placements, faculty and more.</p>
      </div>
      <a href="compare.php?clear=1" class="cmp-clear-btn" aria-label="Clear all comparisons">Clear all</a>
    </div>

    <!-- College cards -->
    <div class="cmp-cards-grid"
         style="grid-template-columns: repeat(<?= count($colleges) ?>, minmax(0, 1fr))">
      <?php foreach ($colleges as $c): ?>
      <div class="cmp-card">
        <div class="cmp-card-img">
          <img src="<?= htmlspecialchars($c['image']) ?>"
               alt="<?= htmlspecialchars($c['name']) ?>" loading="lazy" />
        </div>
        <div class="cmp-card-body">
          <div class="cmp-card-name"><?= htmlspecialchars($c['name']) ?></div>
          <div class="cmp-card-loc"><?= htmlspecialchars($c['location']) ?></div>
          <div class="cmp-card-actions">
            <a href="colleges.php?slug=<?= urlencode($c['slug']) ?>"
   class="btn-hero flex-1">View</a>
            <a href="compare.php?remove=<?= urlencode($c['slug']) ?>"
               class="btn-icon" title="Remove <?= htmlspecialchars($c['name']) ?>" aria-label="Remove">
              <!-- X icon -->
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                   stroke="currentColor" stroke-width="2" aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Comparison table -->
    <div class="cmp-table-wrap">
      <table class="cmp-table" aria-label="IIM comparison table">
        <tbody>
          <?php $i = 0; foreach ($rows as $label => $fn): ?>
          <tr class="<?= $i % 2 === 0 ? 'row-alt' : '' ?>">
            <td class="cmp-label"><?= htmlspecialchars($label) ?></td>
            <?php foreach ($colleges as $c): ?>
              <td class="cmp-cell"><?= $fn($c) ?></td>
            <?php endforeach; ?>
          </tr>
          <?php $i++; endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Add-more CTA -->
    <?php if (count($colleges) < 3): ?>
    <div class="cmp-add-more">
      <a href="colleges.php" class="btn-outline">+ Add more IIMs to compare</a>
    </div>
    <?php endif; ?>

  </div>
</section>
<?php endif; ?>

<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>