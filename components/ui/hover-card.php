<?php
/**
 * components/ui/hover-card.php
 * PHP helper for the Hover Card UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_hover_card(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-hover-card ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
