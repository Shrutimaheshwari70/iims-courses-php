<?php
/**
 * components/ui/alert-dialog.php
 * PHP helper for the Alert Dialog UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_alert_dialog(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-alert-dialog ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
