<?php
/**
 * components/ui/aspect-ratio.php
 * PHP helper for the Aspect Ratio UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_aspect_ratio(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-aspect-ratio ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
