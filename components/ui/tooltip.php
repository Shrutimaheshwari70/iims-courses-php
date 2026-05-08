<?php
/**
 * components/ui/tooltip.php
 *
 * Usage:
 *   $tooltip_text    = 'Tooltip message'
 *   $tooltip_content = '<button>Hover me</button>'  (HTML of the trigger)
 *   $tooltip_side    = 'top' | 'bottom' | 'left' | 'right'
 *   include 'components/ui/tooltip.php';
 */
$tooltip_text    = $tooltip_text    ?? '';
$tooltip_content = $tooltip_content ?? '';
$tooltip_side    = $tooltip_side    ?? 'top';
?>
<span class="ui-tooltip-wrap" data-tooltip-side="<?= htmlspecialchars($tooltip_side) ?>">
  <?= $tooltip_content ?>
  <span class="ui-tooltip-bubble ui-tooltip-<?= htmlspecialchars($tooltip_side) ?>" role="tooltip">
    <?= htmlspecialchars($tooltip_text) ?>
  </span>
</span>