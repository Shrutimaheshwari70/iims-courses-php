<?php
/**
 * components/ui/menubar.php
 * PHP helper for the Menubar UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_menubar(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-menubar ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
s