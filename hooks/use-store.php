<?php
/**
 * hooks/use-store.php
 * Server-side session-backed stores for wishlist, compare, and theme.
 * Equivalent to src/hooks/use-store.ts (which uses localStorage + React state).
 *
 * In PHP we persist state in $_SESSION. JS in assets/js/app.js keeps
 * localStorage in sync so state survives client-side navigation too.
 */

// ── Wishlist ──────────────────────────────────────────────────────────────────

function wishlist_get(): array {
    return $_SESSION['wishlist'] ?? [];
}

function wishlist_has(string $slug): bool {
    return in_array($slug, wishlist_get(), true);
}

function wishlist_toggle(string $slug): void {
    $list = wishlist_get();
    if (in_array($slug, $list, true)) {
        $_SESSION['wishlist'] = array_values(array_filter($list, fn($s) => $s !== $slug));
    } else {
        $_SESSION['wishlist'] = [...$list, $slug];
    }
}

function wishlist_clear(): void {
    $_SESSION['wishlist'] = [];
}

function wishlist_count(): int {
    return count(wishlist_get());
}

// ── Compare ───────────────────────────────────────────────────────────────────

function compare_get(): array {
    return $_SESSION['compare'] ?? [];
}

function compare_has(string $slug): bool {
    return in_array($slug, compare_get(), true);
}

/**
 * Returns ['ok' => true] on success or ['ok' => false, 'reason' => '…'] when full.
 */
function compare_add(string $slug): array {
    $list = compare_get();
    if (in_array($slug, $list, true))  return ['ok' => true];
    if (count($list) >= 3)             return ['ok' => false, 'reason' => 'Max 3 items in compare'];
    $_SESSION['compare'] = [...$list, $slug];
    return ['ok' => true];
}

function compare_remove(string $slug): void {
    $_SESSION['compare'] = array_values(array_filter(compare_get(), fn($s) => $s !== $slug));
}

function compare_clear(): void {
    $_SESSION['compare'] = [];
}

function compare_count(): int {
    return count(compare_get());
}

// ── Theme ─────────────────────────────────────────────────────────────────────

function theme_get(): string {
    // Prefer cookie (set by JS) so it persists across sessions
    return $_COOKIE['iims_theme'] ?? ($_SESSION['theme'] ?? 'light');
}

function theme_is_dark(): bool {
    return theme_get() === 'dark';
}

/**
 * Return the <html> class attribute value for the current theme.
 */
function theme_html_class(): string {
    return theme_is_dark() ? 'dark' : '';
}
