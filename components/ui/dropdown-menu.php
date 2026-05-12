<?php
/**
 * components/ui/dropdown-menu.php
 * PHP helper for the Dropdown Menu UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_dropdown_menu(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-dropdown-menu ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
