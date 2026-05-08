<?php
/**
 * components/ui/input.php
 *
 * Usage:
 *   $input_type        = 'text'        (any HTML input type)
 *   $input_name        = 'field_name'
 *   $input_id          = ''            (defaults to name)
 *   $input_value       = ''
 *   $input_placeholder = ''
 *   $input_required    = false
 *   $input_class       = ''
 *   include 'components/ui/input.php';
 */
$input_type        = $input_type        ?? 'text';
$input_name        = $input_name        ?? '';
$input_id          = $input_id          ?? $input_name;
$input_value       = $input_value       ?? '';
$input_placeholder = $input_placeholder ?? '';
$input_required    = $input_required    ?? false;
$input_class       = $input_class       ?? '';
?>
<input
  type="<?= htmlspecialchars($input_type) ?>"
  <?= $input_name ? 'name="'.htmlspecialchars($input_name).'"' : '' ?>
  <?= $input_id   ? 'id="'.htmlspecialchars($input_id).'"'     : '' ?>
  value="<?= htmlspecialchars($input_value) ?>"
  <?= $input_placeholder ? 'placeholder="'.htmlspecialchars($input_placeholder).'"' : '' ?>
  <?= $input_required ? 'required' : '' ?>
  class="form-input <?= htmlspecialchars($input_class) ?>"
/>