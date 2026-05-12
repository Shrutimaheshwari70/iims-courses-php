<?php
/**
 * components/ui/navbar.php
 * PHP helper for the Navbar UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_navbar(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-navbar ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
