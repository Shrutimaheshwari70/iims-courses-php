<?php
/**
 * components/ui/slider.php
 * PHP helper for the Slider UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_slider(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-slider ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
