<?php
/**
 * components/ui/switch.php
 * PHP helper for the Switch UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_switch(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-switch ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
