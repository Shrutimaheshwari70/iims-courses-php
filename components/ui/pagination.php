<!-- <?php
/**
 * components/ui/pagination.php
 *
 * Usage:
 *   $pagination_total   = 14   (total items)
 *   $pagination_per     = 6    (items per page)
 *   $pagination_current = 1    (current page, 1-indexed)
 *   $pagination_url     = 'colleges.php?page={page}'  ({page} placeholder)
 *   include 'components/ui/pagination.php';
 */
$pagination_total   = (int)($pagination_total   ?? 1);
$pagination_per     = (int)($pagination_per     ?? 10);
$pagination_current = (int)($pagination_current ?? 1);
$pagination_url     = $pagination_url           ?? '?page={page}';

$total_pages = (int)ceil($pagination_total / $pagination_per);
if ($total_pages <= 1) return; // nothing to render

$prev = max(1, $pagination_current - 1);
$next = min($total_pages, $pagination_current + 1);

function paginationUrl($tpl, $p) {
  return str_replace('{page}', $p, $tpl);
}
?>
<nav class="ui-pagination" aria-label="Pagination">

  <!-- Prev -->
  <?php if ($pagination_current > 1): ?>
    <a href="<?= htmlspecialchars(paginationUrl($pagination_url, $prev)) ?>" class="ui-page-btn" aria-label="Previous page">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    </a>
  <?php else: ?>
    <span class="ui-page-btn disabled" aria-disabled="true">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    </span>
  <?php endif; ?>

  <!-- Page numbers -->
  <?php for ($p = 1; $p <= $total_pages; $p++):
    if ($p === $pagination_current):
  ?>
      <span class="ui-page-num active" aria-current="page"><?= $p ?></span>
    <?php elseif ($p === 1 || $p === $total_pages || abs($p - $pagination_current) <= 1): ?>
      <a href="<?= htmlspecialchars(paginationUrl($pagination_url, $p)) ?>" class="ui-page-num"><?= $p ?></a>
    <?php elseif (abs($p - $pagination_current) === 2): ?>
      <span class="ui-page-ellipsis">…</span>
    <?php endif; ?>
  <?php endfor; ?>

  <!-- Next -->
  <?php if ($pagination_current < $total_pages): ?>
    <a href="<?= htmlspecialchars(paginationUrl($pagination_url, $next)) ?>" class="ui-page-btn" aria-label="Next page">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
  <?php else: ?>
    <span class="ui-page-btn disabled" aria-disabled="true">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
    </span>
  <?php endif; ?>

</nav> -->