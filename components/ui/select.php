<?php
/**
 * components/ui/select.php
 *
 * Usage:
 *   $select_name     = 'sort'
 *   $select_id       = ''
 *   $select_options  = [['value'=>'a','label'=>'A'], ...]
 *   $select_selected = 'a'
 *   $select_class    = ''
 *   $select_onchange = 'this.form.submit()'
 *   include 'components/ui/select.php';
 */
$select_name     = $select_name     ?? '';
$select_id       = $select_id       ?? $select_name;
$select_options  = $select_options  ?? [];
$select_selected = $select_selected ?? '';
$select_class    = $select_class    ?? '';
$select_onchange = $select_onchange ?? '';
?>
<div class="ui-select-wrap">
  <select
    <?= $select_name ? 'name="'.htmlspecialchars($select_name).'"' : '' ?>
    <?= $select_id   ? 'id="'.htmlspecialchars($select_id).'"'     : '' ?>
    class="ui-select <?= htmlspecialchars($select_class) ?>"
    <?= $select_onchange ? 'onchange="'.htmlspecialchars($select_onchange).'"' : '' ?>
  >
    <?php foreach ($select_options as $opt): ?>
      <option value="<?= htmlspecialchars($opt['value']) ?>" <?= $opt['value'] === $select_selected ? 'selected' : '' ?>>
        <?= htmlspecialchars($opt['label']) ?>
      </option>
    <?php endforeach; ?>
  </select>
  <svg class="ui-select-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <polyline points="6 9 12 15 18 9"/>
  </svg>
</div>