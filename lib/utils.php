<?php
/**
 * lib/utils.php
 * Equivalent to src/lib/utils.ts (cn() helper + misc utilities)
 * In PHP we don't need Tailwind class merging — just CSS class helpers.
 */

/**
 * Merge CSS class strings, filtering out empty/null values.
 * Equivalent to the cn() / clsx() helper in the TS project.
 *
 * Usage: cn('base-class', $condition ? 'active' : '', 'other-class')
 */
function cn(string ...$classes): string {
    return implode(' ', array_filter(array_map('trim', $classes)));
}

/**
 * Return a CSS class string based on a condition.
 */
function cx(bool $condition, string $when_true, string $when_false = ''): string {
    return $condition ? $when_true : $when_false;
}

/**
 * Safely get a nested array value with a default.
 */
function arr_get(array $arr, string $key, mixed $default = null): mixed {
    return $arr[$key] ?? $default;
}

/**
 * Generate a URL-safe slug from a string.
 */
function to_slug(string $text): string {
    $text = mb_strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

/**
 * Format a fee in Lakhs with ₹ symbol.
 */
function fmt_fee(int|float $lakhs): string {
    return '₹' . number_format($lakhs, 0) . 'L';
}

/**
 * Clamp a value between min and max.
 */
function clamp(float $value, float $min, float $max): float {
    return max($min, min($max, $value));
}
