<?php
/**
 * components/ui/alert.php
 *
 * Usage:
 *   $alert_variant = 'default' | 'success' | 'warning' | 'destructive'
 *   $alert_title   = 'Title text'
 *   $alert_desc    = 'Description text'
 *   include 'components/ui/alert.php';
 */
$alert_variant = $alert_variant ?? 'default';
$alert_title   = $alert_title   ?? '';
$alert_desc    = $alert_desc    ?? '';
?>
<div class="ui-alert ui-alert--<?= htmlspecialchars($alert_variant) ?>" role="alert">
  <?php if ($alert_title): ?>
    <div class="ui-alert-title"><?= htmlspecialchars($alert_title) ?></div>
  <?php endif; ?>
  <?php if ($alert_desc): ?>
    <div class="ui-alert-desc"><?= htmlspecialchars($alert_desc) ?></div>
  <?php endif; ?>
</div>ss