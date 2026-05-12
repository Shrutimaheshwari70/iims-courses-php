<?php
/**
 * components/ui/toggle.php
 * PHP helper for the Toggle UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_toggle(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-toggle ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
