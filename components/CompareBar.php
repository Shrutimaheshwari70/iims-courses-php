<?php
$compareList = $_SESSION['compare'] ?? [];
if (empty($compareList))
  return; // nothing to render

$colleges = array_values(array_filter(array_map(fn($s) => getCollege($s), $compareList)));
?>

<div class="compare-bar" id="compare-bar">
  <div class="compare-bar-inner">

    <!-- Slots -->
    <div class="compare-bar-slots">
      <?php for ($i = 0; $i < 3; $i++): ?>
        <?php if (isset($colleges[$i])):
          $c = $colleges[$i]; ?>
          <div class="compare-slot filled">
            <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>"
              class="compare-slot-img" />
            <span class="compare-slot-name"><?= htmlspecialchars($c['short'] ?? $c['name']) ?></span>
            <a href="compare.php?remove=<?= urlencode($c['slug']) ?>" class="compare-slot-remove" title="Remove">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="width:12px;height:12px">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
              </svg>
            </a>
          </div>
        <?php else: ?>
          <div class="compare-slot empty">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              style="width:20px;height:20px;opacity:.4">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
              <line x1="12" y1="8" x2="12" y2="16" />
              <line x1="8" y1="12" x2="16" y2="12" />
            </svg>
            <span class="compare-slot-label">Add IIM</span>
          </div>
        <?php endif; ?>
      <?php endfor; ?>
    </div>

    <!-- Actions -->
    <div class="compare-bar-actions">
      <a href="compare.php" class="btn btn-hero btn-sm">
        Compare Now
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          style="width:14px;height:14px">
          <line x1="5" y1="12" x2="19" y2="12" />
          <polyline points="12 5 19 12 12 19" />
        </svg>
      </a>
      <a href="compare.php?clear=1" class="compare-bar-clear">Clear all</a>
    </div>

  </div>
</div>