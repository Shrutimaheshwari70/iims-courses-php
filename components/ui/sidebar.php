<?php
/**
 * components/ui/sidebar.php
 * PHP helper for the Sidebar UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_sidebar(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-sidebar ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
