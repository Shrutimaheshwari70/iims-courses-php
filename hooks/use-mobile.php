<?php
/**
 * hooks/use-mobile.php
 * Server-side user-agent detection.
 * Equivalent to src/hooks/use-mobile.tsx
 *
 * In React the hook watches window width. On the server we use the UA string.
 * The real responsive behaviour is still handled in CSS / JS.
 */

/**
 * Returns true when the request likely comes from a mobile device.
 */
function is_mobile(): bool
{
    $ua = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
    return (bool) preg_match(
        '/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini|mobile/i',
        $ua
    );
}

/**
 * Returns the breakpoint hint for server-side rendering.
 * Values: 'mobile' | 'tablet' | 'desktop'
 */
function device_hint(): string
{
    $ua = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
    if (preg_match('/ipad|tablet|android(?!.*mobile)/i', $ua))
        return 'tablet';
    if (preg_match('/mobile|iphone|ipod|android.*mobile/i', $ua))
        return 'mobile';
    return 'desktop';
}
