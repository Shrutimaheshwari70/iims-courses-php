<?php
/**
 * components/ui/input-otp.php
 * PHP helper for the Input Otp UI primitive.
 * Renders plain HTML matching the design system CSS classes.
 */

function ui_input_otp(array $props = []): string {
    $class = $props['class'] ?? '';
    $id    = isset($props['id']) ? ' id="' . htmlspecialchars($props['id']) . '"' : '';
    $slot  = $props['slot']  ?? '';
    return '<div class="ui-input-otp ' . htmlspecialchars($class) . '"' . $id . '>' . $slot . '</div>';
}
