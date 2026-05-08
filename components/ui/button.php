<?php
/**
 * components/ui/button.php
 *
 * Usage:
 *   $btn_label   = 'Click Me'
 *   $btn_variant = 'hero' | 'outline' | 'secondary' | 'ghost' | 'destructive'
 *   $btn_size    = 'sm' | 'md' | 'lg' | 'xl'
 *   $btn_href    = null (renders <button>) or 'url' (renders <a>)
 *   $btn_onclick = 'jsFunction()'
 *   $btn_type    = 'button' | 'submit' | 'reset'
 *   $btn_class   = '' (extra CSS classes)
 *   include 'components/ui/button.php';
 */
$btn_label   = $btn_label   ?? 'Button';
$btn_variant = $btn_variant ?? 'hero';
$btn_size    = $btn_size    ?? 'md';
$btn_href    = $btn_href    ?? null;
$btn_onclick = $btn_onclick ?? '';
$btn_type    = $btn_type    ?? 'button';
$btn_class   = $btn_class   ?? '';

$classes = 'btn btn-' . $btn_variant . ' btn-' . $btn_size . ($btn_class ? ' ' . $btn_class : '');
?>
<?php if ($btn_href): ?>
  <a href="<?= htmlspecialchars($btn_href) ?>" class="<?= $classes ?>">
    <?= htmlspecialchars($btn_label) ?>
  </a>
<?php else: ?>
  <button
    type="<?= htmlspecialchars($btn_type) ?>"
    class="<?= $classes ?>"
    <?= $btn_onclick ? 'onclick="'.htmlspecialchars($btn_onclick).'"' : '' ?>
  >
    <?= htmlspecialchars($btn_label) ?>
  </button>
<?php endif; ?>