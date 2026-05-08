<?php
/**
 * components/ui/textarea.php
 *
 * Usage:
 *   $textarea_name        = 'message'
 *   $textarea_id          = ''         (defaults to name)
 *   $textarea_value       = ''
 *   $textarea_placeholder = ''
 *   $textarea_rows        = 4
 *   $textarea_required    = false
 *   $textarea_class       = ''
 *   include 'components/ui/textarea.php';
 */
$textarea_name        = $textarea_name        ?? '';
$textarea_id          = $textarea_id          ?? $textarea_name;
$textarea_value       = $textarea_value       ?? '';
$textarea_placeholder = $textarea_placeholder ?? '';
$textarea_rows        = $textarea_rows        ?? 4;
$textarea_required    = $textarea_required    ?? false;
$textarea_class       = $textarea_class       ?? '';
?>
<textarea
  <?= $textarea_name ? 'name="'.htmlspecialchars($textarea_name).'"' : '' ?>
  <?= $textarea_id   ? 'id="'.htmlspecialchars($textarea_id).'"'     : '' ?>
  rows="<?= (int)$textarea_rows ?>"
  <?= $textarea_placeholder ? 'placeholder="'.htmlspecialchars($textarea_placeholder).'"' : '' ?>
  <?= $textarea_required ? 'required' : '' ?>
  class="form-textarea <?= htmlspecialchars($textarea_class) ?>"
><?= htmlspecialchars($textarea_value) ?></textarea>