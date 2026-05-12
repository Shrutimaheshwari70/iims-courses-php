<?php
/**
 * components/ui/command.php
 * PHP helper for the Command UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_command(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-command ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
