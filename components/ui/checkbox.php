<?php
/**
 * components/ui/checkbox.php
 * PHP helper for the Checkbox UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_checkbox(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-checkbox ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
