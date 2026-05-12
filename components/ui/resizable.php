<?php
/**
 * components/ui/resizable.php
 * PHP helper for the Resizable UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_resizable(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-resizable ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
