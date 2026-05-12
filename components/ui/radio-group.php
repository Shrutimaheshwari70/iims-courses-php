<?php
/**
 * components/ui/radio-group.php
 * PHP helper for the Radio Group UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_radio_group(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-radio-group ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
