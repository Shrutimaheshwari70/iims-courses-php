<?php
/**
 * components/ui/sonner.php
 * PHP helper for the Sonner UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_sonner(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-sonner ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
