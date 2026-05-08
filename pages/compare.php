<?php
/**
 * compare.php  ←→  src/routes/compare.tsx
 * Compare up to 3 IIMs side-by-side.
 * Selected slugs are stored in the PHP session.
 */
session_start();
require_once 'data/iims.php';

$page_title   = 'Compare IIMs Side-by-Side';
$page_description = 'Compare IIMs on fees, placements, faculty, ranking and more.';
$current_page = 'compare';

// Handle add / remove / clear via GET params
$compareList = $_SESSION['compare'] ?? [];

if (isset($_GET['add'])) {
  $slug = $_GET['add'];
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

// Resolve college objects
$colleges = array_values(array_filter(array_map(fn($s) => getCollege($s), $compareList)));

include 'includes/header.php';
include 'components/Navbar.php';
?>

<?php if (empty($colleges)): ?>
<!-- ============================================================
     EMPTY STATE
     ============================================================ -->
<section class="section" style="text-align:center; padding-top:8rem">
  <div class="container" style="max-width:700px">
    <h1 class="section-title">Compare IIMs</h1>
    <p class="text-muted mt-3">Add up to 3 IIMs to compare side-by-side.</p>
    <a href="pages/colleges.php" class="btn btn-hero" style="margin-top:1.5rem; display:inline-flex">
      Browse IIMs
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
    </a>
  </div>
</section>

<?php else: ?>
<!-- ============================================================
     COMPARE PAGE
     ============================================================ -->
<section class="section" style="padding-top:7rem">
  <div class="container">

    <!-- Header -->
    <div class="compare-header">
      <div>
        <h1 class="section-title">Compare IIMs</h1>
        <p class="text-muted mt-2">Side-by-side: fees, placements, faculty and more.</p>
      </div>
      <a href="compare.php?clear=1" class="compare-clear">Clear all</a>
    </div>

    <!-- College preview cards -->
    <div class="compare-cards" style="grid-template-columns: repeat(<?= count($colleges) ?>, 1fr)">
      <?php foreach ($colleges as $c): ?>
      <div class="cmp-card">
        <div class="cmp-card-img">
          <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>" />
        </div>
        <div class="cmp-card-body">
          <div class="cmp-card-name"><?= htmlspecialchars($c['name']) ?></div>
          <div class="cmp-card-loc"><?= htmlspecialchars($c['location']) ?></div>
          <div class="cmp-card-actions">
            <a href="pages/college-details.php?slug=<?= $c['slug'] ?>" class="btn btn-hero btn-sm" style="flex:1">View</a>
            <a href="compare.php?remove=<?= $c['slug'] ?>" class="btn btn-outline btn-sm btn-icon" title="Remove">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Comparison table -->
    <?php
    $rows = [
      'Location'        => fn($c) => $c['location'],
      'Established'     => fn($c) => $c['established'],
      'NIRF Ranking'    => fn($c) => '#'.$c['ranking'],
      'Rating'          => fn($c) => '★ '.$c['rating'],
      'Total Fees'      => fn($c) => '₹'.$c['fees'].'L',
      'Avg Placement'   => fn($c) => '₹'.$c['placement'].'L',
      'Highest Package' => fn($c) => '₹'.$c['highest'].'L',
      'Faculty'         => fn($c) => $c['faculty'].'+',
      'Intake'          => fn($c) => $c['intake'],
      'Exams'           => fn($c) => implode(', ', $c['exams']),
    ];
    ?>
    <div class="compare-table-wrap">
      <table class="compare-table">
        <tbody>
          <?php $i=0; foreach ($rows as $label => $fn): ?>
          <tr class="<?= $i%2===0?'row-alt':'' ?>">
            <td class="cmp-label"><?= htmlspecialchars($label) ?></td>
            <?php foreach ($colleges as $c): ?>
              <td class="cmp-cell"><?= htmlspecialchars($fn($c)) ?></td>
            <?php endforeach; ?>
          </tr>
          <?php $i++; endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if (count($colleges) < 3): ?>
    <div style="text-align:center; margin-top:1.5rem">
      <a href="pages/colleges.php" class="btn btn-outline">+ Add more IIMs to compare</a>
    </div>
    <?php endif; ?>

  </div>
</section>
<?php endif; ?>

<?php
include 'components/Footer.php';
include 'includes/footer.php';
?>