<?php
/**
 * components/ui/scroll-area.php
 * PHP helper for the Scroll Area UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_scroll_area(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-scroll-area ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
