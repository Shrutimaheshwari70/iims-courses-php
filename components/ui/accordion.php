<?php
/**
 * components/ui/accordion.php
 *
 * Usage:
 *   $accordion_items = [
 *     ['trigger' => 'Question?', 'content' => 'Answer.'],
 *     ...
 *   ];
 *   include 'components/ui/accordion.php';
 *
 * Optional:
 *   $accordion_id   – unique id prefix (default: 'acc')
 *   $accordion_type – 'single' (default) | 'multiple'
 */
$accordion_id   = $accordion_id   ?? 'acc';
$accordion_type = $accordion_type ?? 'single';
?>
<div class="ui-accordion" id="<?= htmlspecialchars($accordion_id) ?>" data-type="<?= $accordion_type ?>">
  <?php foreach (($accordion_items ?? []) as $i => $item): ?>
  <div class="ui-accordion-item" id="<?= $accordion_id ?>-item-<?= $i ?>">
    <button
      class="ui-accordion-trigger"
      aria-expanded="false"
      aria-controls="<?= $accordion_id ?>-content-<?= $i ?>"
      onclick="uiAccordionToggle(this, '<?= $accordion_id ?>', '<?= $accordion_type ?>')"
    >
      <?= htmlspecialchars($item['trigger']) ?>
      <svg class="ui-accordion-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="6 9 12 15 18 9"/>
      </svg>
    </button>
    <div class="ui-accordion-content" id="<?= $accordion_id ?>-content-<?= $i ?>" role="region" hidden>
      <div class="ui-accordion-body">
        <?= $item['content'] /* Allow HTML in content */ ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<script>
function uiAccordionToggle(btn, id, type) {
  const expanded = btn.getAttribute('aria-expanded') === 'true';
  if (type === 'single') {
    document.querySelectorAll('#' + id + ' .ui-accordion-trigger').forEach(b => {
      b.setAttribute('aria-expanded', 'false');
      b.closest('.ui-accordion-item').querySelector('.ui-accordion-content').hidden = true;
    });
  }
  if (!expanded) {
    btn.setAttribute('aria-expanded', 'true');
    btn.closest('.ui-accordion-item').querySelector('.ui-accordion-content').hidden = false;
  }
}
</script>