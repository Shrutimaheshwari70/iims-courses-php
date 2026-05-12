<?php
/**
 * components/ui/popover.php
 * PHP helper for the Popover UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_popover(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-popover ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
