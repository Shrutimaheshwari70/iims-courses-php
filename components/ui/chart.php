<?php
/**
 * components/ui/chart.php
 * PHP helper for the Chart UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_chart(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-chart ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
