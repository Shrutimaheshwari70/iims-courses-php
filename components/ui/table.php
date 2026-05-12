<?php
/**
 * components/ui/table.php
 * PHP helper for the Table UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_table(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-table ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
