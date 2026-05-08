<?php
/**
 * components/ui/dialog.php
 *
 * Usage:
 *   $dialog_id      = 'my-dialog'  (unique ID)
 *   $dialog_title   = 'Dialog Title'
 *   $dialog_content = '<p>HTML content</p>'
 *   $dialog_footer  = '<button class="btn btn-hero">OK</button>'
 *   include 'components/ui/dialog.php';
 *
 * Open via JS:  openDialog('my-dialog')
 * Close via JS: closeDialog('my-dialog')
 */
$dialog_id      = $dialog_id      ?? 'dialog-' . uniqid();
$dialog_title   = $dialog_title   ?? '';
$dialog_content = $dialog_content ?? '';
$dialog_footer  = $dialog_footer  ?? '';
?>
<div id="<?= htmlspecialchars($dialog_id) ?>" class="ui-dialog-overlay" role="dialog" aria-modal="true" aria-labelledby="<?= $dialog_id ?>-title" hidden onclick="if(event.target===this)closeDialog('<?= $dialog_id ?>')">
  <div class="ui-dialog-box">
    <div class="ui-dialog-header">
      <h3 class="ui-dialog-title" id="<?= $dialog_id ?>-title"><?= htmlspecialchars($dialog_title) ?></h3>
      <button class="ui-dialog-close" aria-label="Close" onclick="closeDialog('<?= htmlspecialchars($dialog_id) ?>')">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <?php if ($dialog_content): ?>
    <div class="ui-dialog-content"><?= $dialog_content ?></div>
    <?php endif; ?>
    <?php if ($dialog_footer): ?>
    <div class="ui-dialog-footer"><?= $dialog_footer ?></div>
    <?php endif; ?>
  </div>
</div>

<script>
function openDialog(id)  { document.getElementById(id).hidden = false; document.body.style.overflow='hidden'; }
function closeDialog(id) { document.getElementById(id).hidden = true;  document.body.style.overflow=''; }
</script>