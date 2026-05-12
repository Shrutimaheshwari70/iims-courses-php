<?php
/**
 * components/ui/collapsible.php
 * PHP helper for the Collapsible UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_collapsible(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-collapsible ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
