<?php
/**
 * includes/functions.php
 * Shared utility / helper functions used across all pages.
 */

/**
 * Safely echo an HTML-escaped value.
 */
function e(mixed $val): string
{
    return htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
}

/**
 * Format a number with Indian-style formatting (e.g. 1,00,000).
 */
function sindian_number(int|float $n): string
{
    if ($n < 1000)
        return (string) $n;
    $last3 = $n % 1000;
    $rest = (int) ($n / 1000);
    $result = str_pad((string) $last3, 3, '0', STR_PAD_LEFT);
    while ($rest > 0) {
        $part = $rest % 100;
        $rest = (int) ($rest / 100);
        $result = ($rest > 0 ? str_pad((string) $part, 2, '0', STR_PAD_LEFT) : (string) $part) . ',' . $result;
    }
    return $result;
}

/**
 * Render star SVGs for a rating out of 5.
 */
function render_stars(float $rating): string
{
    $full = (int) floor($rating);
    $half = ($rating - $full) >= 0.5;
    $empty = 5 - $full - ($half ? 1 : 0);
    $html = '';
    $star = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="star-icon"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" fill="currentColor"/></svg>';
    for ($i = 0; $i < $full; $i++)
        $html .= "<span class=\"star filled\">$star</span>";
    if ($half)
        $html .= "<span class=\"star half\">$star</span>";
    for ($i = 0; $i < $empty; $i++)
        $html .= "<span class=\"star empty\">$star</span>";
    return $html;
}

/**
 * Truncate text to a given number of words.
 */
function truncate_words(string $text, int $words = 20): string
{
    $parts = explode(' ', strip_tags($text));
    if (count($parts) <= $words)
        return $text;
    return implode(' ', array_slice($parts, 0, $words)) . '…';
}

/**
 * Slugify a string.
 */
function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

/**
 * CSRF token helpers.
 */
function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_input(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '" />';
}

function csrf_valid(): bool
{
    return isset($_POST['_csrf']) && hash_equals(csrf_token(), $_POST['_csrf']);
}

/**
 * Session-based wishlist helpers.
 */
function wishlist_has(string $slug): bool
{
    return in_array($slug, $_SESSION['wishlist'] ?? [], true);
}

function wishlist_toggle(string $slug): void
{
    if (!isset($_SESSION['wishlist']))
        $_SESSION['wishlist'] = [];
    if (wishlist_has($slug)) {
        $_SESSION['wishlist'] = array_values(array_filter($_SESSION['wishlist'], fn($s) => $s !== $slug));
    } else {
        $_SESSION['wishlist'][] = $slug;
    }
}

/**
 * Session-based compare helpers.
 */
function compare_has(string $slug): bool
{
    return in_array($slug, $_SESSION['compare'] ?? [], true);
}

function compare_add(string $slug): bool
{
    if (!isset($_SESSION['compare']))
        $_SESSION['compare'] = [];
    if (compare_has($slug))
        return true;
    if (count($_SESSION['compare']) >= 3)
        return false;
    $_SESSION['compare'][] = $slug;
    return true;
}

function compare_remove(string $slug): void
{
    $_SESSION['compare'] = array_values(array_filter($_SESSION['compare'] ?? [], fn($s) => $s !== $slug));
}

/**
 * Redirect with flash message.
 */
function redirect(string $url, string $msg = '', string $type = 'success'): never
{
    if ($msg) {
        $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
    }
    header('Location: ' . $url);
    exit;
}

/**
 * Get & clear flash message.
 */
function flash(): ?array
{
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

/**
 * Format date string to human-readable.
 */
function format_date(string $date, string $format = 'M j, Y'): string
{
    return date($format, strtotime($date));
}
