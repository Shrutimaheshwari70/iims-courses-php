<?php
/**
 * components/ui/badge.php
 *
 * Usage:
 *   $badge_text    = 'Label'
 *   $badge_variant = 'default' | 'secondary' | 'outline' | 'destructive'
 *   include 'components/ui/badge.php';
 */
$badge_text    = $badge_text    ?? '';
$badge_variant = $badge_variant ?? 'default';
?>
<span class="ui-badge ui-badge--<?= htmlspecialchars($badge_variant) ?>">
  <?= htmlspecialchars($badge_text) ?>
</span>