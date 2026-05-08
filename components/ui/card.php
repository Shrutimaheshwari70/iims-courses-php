<?php
/**
 * components/ui/card.php
 *
 * Usage:
 *   $card_title   = 'Card title'
 *   $card_desc    = 'Card description'
 *   $card_content = '<p>Arbitrary HTML</p>'
 *   $card_footer  = '<button>Action</button>'
 *   $card_class   = '' (extra CSS classes)
 *   include 'components/ui/card.php';
 */
$card_title   = $card_title   ?? '';
$card_desc    = $card_desc    ?? '';
$card_content = $card_content ?? '';
$card_footer  = $card_footer  ?? '';
$card_class   = $card_class   ?? '';
?>
<div class="ui-card <?= htmlspecialchars($card_class) ?>">
  <?php if ($card_title || $card_desc): ?>
  <div class="ui-card-header">
    <?php if ($card_title): ?>
      <div class="ui-card-title"><?= htmlspecialchars($card_title) ?></div>
    <?php endif; ?>
    <?php if ($card_desc): ?>
      <div class="ui-card-desc"><?= htmlspecialchars($card_desc) ?></div>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <?php if ($card_content): ?>
  <div class="ui-card-content">
    <?= $card_content ?>
  </div>
  <?php endif; ?>

  <?php if ($card_footer): ?>
  <div class="ui-card-footer">
    <?= $card_footer ?>
  </div>
  <?php endif; ?>
</div>