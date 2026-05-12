<?php
/**
 * components/ui/carousel.php
 * PHP helper for the Carousel UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_carousel(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-carousel ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
