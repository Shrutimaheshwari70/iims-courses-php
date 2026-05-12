<?php
/**
 * components/ui/tabs.php
 *
 * Usage:
 *   $tabs_id      = 'my-tabs'       (unique id)
 *   $tabs_default = 'tab1'          (value of default active tab)
 *   $tabs_list    = [
 *     ['value'=>'tab1', 'label'=>'Tab One',  'content'=>'<p>HTML</p>'],
 *     ['value'=>'tab2', 'label'=>'Tab Two',  'content'=>'<p>HTML</p>'],
 *   ];
 *   include 'components/ui/tabs.php';
 */
$tabs_id      = $tabs_id      ?? 'tabs-' . uniqid();
$tabs_default = $tabs_default ?? ($tabs_list[0]['value'] ?? '');
$tabs_list    = $tabs_list    ?? [];
?>
<div class="ui-tabs" id="<?= htmlspecialchars($tabs_id) ?>">

  <!-- Tab triggers -->
  <div class="ui-tabs-list" role="tablist">
    <?php foreach ($tabs_list as $tab): ?>
      <button
        role="tab"
        id="<?= $tabs_id ?>-trigger-<?= htmlspecialchars($tab['value']) ?>"
        aria-controls="<?= $tabs_id ?>-panel-<?= htmlspecialchars($tab['value']) ?>"
        aria-selected="<?= $tab['value'] === $tabs_default ? 'true' : 'false' ?>"
        class="ui-tab-trigger <?= $tab['value'] === $tabs_default ? 'active' : '' ?>"
        onclick="uiTabsSwitch('<?= $tabs_id ?>', '<?= $tab['value'] ?>')"
      >
        <?= htmlspecialchars($tab['label']) ?>
      </button>
    <?php endforeach; ?>
  </div>

  <!-- Tab panels -->
  <?php foreach ($tabs_list as $tab): ?>
    <div
      role="tabpanel"
      id="<?= $tabs_id ?>-panel-<?= htmlspecialchars($tab['value']) ?>"
      aria-labelledby="<?= $tabs_id ?>-trigger-<?= htmlspecialchars($tab['value']) ?>"
      class="ui-tab-panel <?= $tab['value'] === $tabs_default ? 'active' : '' ?>"
      <?= $tab['value'] !== $tabs_default ? 'hidden' : '' ?>
    >
      <?= $tab['content'] ?>
    </div>
  <?php endforeach; ?>

</div>

<script>
function uiTabsSwitch(tabsId, value) {
  const root = document.getElementById(tabsId);
  root.querySelectorAll('[role="tab"]').forEach(btn => {
    const active = btn.getAttribute('aria-controls') === tabsId + '-panel-' + value;
    btn.setAttribute('aria-selected', active ? 'true' : 'false');
    btn.classList.toggle('active', active);
  });
  root.querySelectorAll('[role="tabpanel"]').forEach(panel => {
    const active = panel.id === tabsId + '-panel-' + value;
    panel.hidden = !active;
    panel.classList.toggle('active', active);
  });
}
</script>s