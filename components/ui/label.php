<?php
/**
 * components/ui/label.php
 * PHP helper for the Label UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_label(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-label ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
