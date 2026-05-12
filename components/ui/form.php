<?php
/**
 * components/ui/form.php
 * PHP helper for the Form UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_form(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-form ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
