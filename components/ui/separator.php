<?php
/**
 * components/ui/separator.php
 * PHP helper for the Separator UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_separator(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-separator ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
