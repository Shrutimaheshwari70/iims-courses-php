<?php
/**
 * components/ui/context-menu.php
 * PHP helper for the Context Menu UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_context_menu(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-context-menu ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
