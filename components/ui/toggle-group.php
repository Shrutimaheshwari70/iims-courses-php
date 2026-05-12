<?php
/**
 * components/ui/toggle-group.php
 * PHP helper for the Toggle Group UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_toggle_group(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-toggle-group ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
