<?php
/**
 * components/ui/skeleton.php
 * PHP helper for the Skeleton UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_skeleton(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-skeleton ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
