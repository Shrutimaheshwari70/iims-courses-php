<?php
/**
 * components/ui/navigation-menu.php
 * PHP helper for the Navigation Menu UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_navigation_menu(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-navigation-menu ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
