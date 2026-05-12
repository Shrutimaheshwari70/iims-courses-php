<?php
/**
 * components/ui/drawer.php
 * PHP helper for the Drawer UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_drawer(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-drawer ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
