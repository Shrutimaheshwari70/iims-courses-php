<?php
/**
 * components/ui/progress.php
 * PHP helper for the Progress UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_progress(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-progress ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
