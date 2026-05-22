<?php
/**
 * pages/wishlist.php
 */
session_start();
require_once '../data/iims.php';

// ✅ AJAX wishlist toggle handler — wl_action GET request
if (isset($_GET['wl_action']) && isset($_GET['wl_slug'])) {
  $wl_slug = trim($_GET['wl_slug']);
  $wl_action = trim($_GET['wl_action']);
  $wishlist = $_SESSION['wishlist'] ?? [];

  if ($wl_action === 'add' && !in_array($wl_slug, $wishlist)) {
    $wishlist[] = $wl_slug;
  } elseif ($wl_action === 'remove') {
    $wishlist = array_values(array_filter($wishlist, fn($s) => $s !== $wl_slug));
  }

  $_SESSION['wishlist'] = $wishlist;
  header('Content-Type: application/json');
  echo json_encode(['count' => count($wishlist), 'action' => $wl_action]);
  exit;
}

$page_title = 'Your Wishlist — IIMs Courses';
$page_description = 'Your saved IIMs.';
$current_page = 'wishlist';

$wishlist = $_SESSION['wishlist'] ?? [];

// GET add/remove fallback (agar JS na chale)
if (isset($_GET['add'])) {
  $slug = trim($_GET['add']);
  if ($slug && !in_array($slug, $wishlist)) {
    $wishlist[] = $slug;
  }
  $_SESSION['wishlist'] = $wishlist;
  header('Location: wishlist.php');
  exit;
}
if (isset($_GET['remove'])) {
  $remove = trim($_GET['remove']);
  $wishlist = array_values(array_filter($wishlist, fn($s) => $s !== $remove));
  $_SESSION['wishlist'] = $wishlist;
  header('Location: wishlist.php');
  exit;
}

$savedColleges = array_values(
  array_filter(array_map(fn($s) => getCollege($s), $wishlist))
);

include '../includes/header.php';
include '../components/Navbar.php';
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

  :root {
    --accent-2: #f5a623;
    --dark: #0d1117;
    --hero-grad: linear-gradient(135deg, #0d1117 0%, #1a1f35 45%, #0f3460 100%);
    --tr: .3s cubic-bezier(.4, 0, .2, 1);
    --radius: 1.1rem;
  }

  body {
    font-family: 'DM Sans', sans-serif;
  }

  /* ── Hero ── */
  .wl-hero {
    background: var(--hero-grad);
    position: relative;
    overflow: hidden;
    padding: 110px 0 80px;
  }

  .wl-hero::before,
  .wl-hero::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    filter: blur(90px);
    pointer-events: none;
  }

  .wl-hero::before {
    width: 420px;
    height: 420px;
    background: rgba(233, 69, 96, .18);
    top: -110px;
    right: -70px;
  }

  .wl-hero::after {
    width: 320px;
    height: 320px;
    background: rgba(15, 52, 96, .5);
    bottom: -80px;
    left: 10%;
  }

  /* Eyebrow badge */
  .wl-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--accent);
    background: rgba(233, 69, 96, .12);
    border: 1px solid rgba(233, 69, 96, .28);
    padding: .35rem .95rem;
    border-radius: 999px;
    margin-bottom: 22px;
  }

  .wl-eyebrow-dot {
    width: 6px;
    height: 6px;
    background: var(--accent);
    border-radius: 50%;
    animation: wlBlink 1.7s ease infinite;
    flex-shrink: 0;
  }

  @keyframes wlBlink {

    0%,
    100% {
      opacity: 1;
      transform: scale(1)
    }

    50% {
      opacity: .4;
      transform: scale(1.6)
    }
  }

  /* Hero heading */
  .wl-hero h1 {
    font-size: clamp(2.2rem, 4.5vw, 3.6rem);
    font-weight: 600;
    color: #fff;
    line-height: 1.16;
  }

  .wl-hero h1 em {
    font-style: normal;
    background: linear-gradient(90deg, var(--accent), var(--accent-2));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  /* Hero count pill */
  .wl-hero-count {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 28px;
    font-size: .82rem;
    font-weight: 600;
    color: rgba(255, 255, 255, .7);
    background: rgba(255, 255, 255, .08);
    border: 1px solid rgba(255, 255, 255, .14);
    padding: .4rem 1rem;
    border-radius: 999px;
  }

  .wl-hero-count svg {
    width: 14px;
    height: 14px;
    stroke: var(--accent);
  }

  /* Wave divider */
  .wl-wave {
    display: block;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    background: var(--hero-grad);
  }

  .wl-wave svg {
    display: block;
    width: 100%;
    height: 48px;
  }

  /* Section bg */
  .wl-section {
    background: #f5f7fb;
  }

  /* Section header badge */
  .wl-sh-badge {
    font-size: .75rem;
    font-weight: 600;
    color: #6c757d;
    background: #e8eaf0;
    border: 1px solid rgba(0, 0, 0, .06);
    padding: .3rem .85rem;
    border-radius: 999px;
  }

  /* Empty state */
  .wl-empty {
    border: 2px dashed #d8dce6;
    border-radius: var(--radius);
    background: #fff;
  }

  .wl-empty-icon {
    width: 64px;
    height: 64px;
    background: rgba(233, 69, 96, .08);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
  }

  .wl-empty-icon svg {
    width: 30px;
    height: 30px;
    stroke: var(--accent);
    fill: none;
  }

  /* Primary button */
  .wl-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: .85rem;
    font-weight: 700;
    color: #fff !important;
    background: linear-gradient(135deg, var(--accent), #c73652);
    border: none;
    padding: .7rem 1.5rem;
    border-radius: 999px;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(233, 69, 96, .35);
    transition: transform var(--tr), box-shadow var(--tr);
    text-decoration: none;

    white-space: nowrap;
  }

  .wl-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(233, 69, 96, .45);
  }

  /* Card */
  .wl-card {
    background: #fff;
    border-radius: var(--radius);
    border: 1px solid rgba(0, 0, 0, .07);
    box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    opacity: 0;
    transform: translateY(28px);
    transition: opacity .52s ease, transform .52s ease, box-shadow var(--tr);
  }

  .wl-card.is-visible {
    opacity: 1;
    transform: translateY(0);
  }

  .wl-card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 20px 48px rgba(0, 0, 0, .16);
  }

  /* Card image */
  .wl-ci {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
    flex-shrink: 0;
  }

  .wl-ci img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .52s ease;
  }

  .wl-card:hover .wl-ci img {
    transform: scale(1.07);
  }

  .wl-ci-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 35%, rgba(13, 17, 23, .6) 100%);
  }

  .wl-ci-badge {
    position: absolute;
    top: 11px;
    left: 11px;
    font-size: .58rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #fff;
    background: var(--accent);
    padding: .27rem .68rem;
    border-radius: 999px;
  }

  .wl-ci-rank {
    position: absolute;
    bottom: 11px;
    right: 11px;
    font-size: .68rem;
    font-weight: 700;
    color: #fff;
    background: rgba(0, 0, 0, .45);
    backdrop-filter: blur(6px);
    padding: .25rem .65rem;
    border-radius: 6px;
  }

  /* Card body */
  .wl-cb {
    padding: 1.1rem 1.2rem 1.3rem;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .wl-cb-name {
    font-size: .97rem;
    font-weight: 700;
    color: #1a1a2e;
    line-height: 1.38;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin: 0;
  }

  /* Remove / toggle button */
  .wl-remove {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1.5px solid rgba(233, 69, 96, .25);
    background: rgba(233, 69, 96, .06);
    color: var(--accent);
    cursor: pointer;
    flex-shrink: 0;
    transition: background var(--tr), border-color var(--tr), transform var(--tr);
    text-decoration: none;
  }

  .wl-remove:hover {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
    transform: scale(1.12);
  }

  .wl-remove svg {
    width: 14px;
    height: 14px;
    fill: currentColor;
  }

  /* Location */
  .wl-cb-location {
    font-size: .78rem;
    color: #6c757d;
  }

  .wl-cb-location svg {
    width: 11px;
    height: 11px;
    stroke: #6c757d;
    fill: none;
    flex-shrink: 0;
  }

  /* Stats */
  .wl-cb-stat-val {
    font-size: .82rem;
    font-weight: 700;
    color: #1a1a2e;
    line-height: 1;
  }

  .wl-cb-stat-key {
    font-size: .62rem;
    color: #6c757d;
    margin-top: 3px;
    white-space: nowrap;
  }

  /* Chips */
  .wl-chip {
    font-size: .58rem;
    font-weight: 600;
    padding: .2rem .58rem;
    border-radius: 999px;
    background: #f0f2f5;
    color: #495057;
    border: 1px solid rgba(0, 0, 0, .06);
    transition: background var(--tr), color var(--tr);
  }

  .wl-card:hover .wl-chip {
    background: rgba(233, 69, 96, .09);
    color: var(--accent);
  }

  /* View details link */
  .wl-cb-link {
    font-size: .78rem;
    font-weight: 700;
    color: var(--accent);
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: gap var(--tr);
    text-decoration: none;
  }

  .wl-card:hover .wl-cb-link {
    gap: 8px;
  }

  .wl-cb-link svg {
    width: 12px;
    height: 12px;
    transition: transform var(--tr);
  }

  .wl-card:hover .wl-cb-link svg {
    transform: translateX(3px);
  }

  @media (max-width:768px) {
    .wl-hero {
      padding: 90px 0 60px;
    }
  }
</style>

<!-- ══════════════════════════ HERO ══════════════════════════ -->
<section class="wl-hero">
  <div class="container position-relative" style="z-index:1;">
    <div class="wl-eyebrow"><span class="wl-eyebrow-dot"></span> My Saved Colleges</div>
    <h1 class="mb-3">Your <em>Wishlist</em></h1>
    <p class="text-white-50 lh-lg" style="max-width:460px; font-size:1rem; margin:0;">
      All your saved IIM colleges in one place. Compare and apply with ease.
    </p>
    <div class="wl-hero-count">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2">
        <path
          d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
      </svg>
      <span
        id="wlHeroCount"><?= count($savedColleges) ?></span>&nbsp;college<?= count($savedColleges) !== 1 ? 's' : '' ?>
      saved
    </div>
  </div>
</section>

<div class="wl-wave">
  <svg viewBox="0 0 1440 48" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,32 C360,0 1080,64 1440,16 L1440,0 L0,0 Z" fill="#f5f7fb" />
  </svg>
</div>

<!-- ══════════════════════════ MAIN ══════════════════════════ -->
<section class="wl-section py-5">
  <div class="container py-3" id="wlMain">

    <?php if (empty($savedColleges)): ?>

      <!-- Empty state -->
      <div class="wl-empty text-center py-5 px-4" id="wlEmptyState">
        <div class="wl-empty-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5">
            <path
              d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
          </svg>
        </div>
        <h2 class="fw-bold mb-2" style="font-size:1.35rem; color:#1a1a2e;">Nothing saved yet</h2>
        <p class="text-muted mb-4 mx-auto" style="max-width:340px; font-size:.9rem; line-height:1.6;">
          No saved IIMs yet. Tap the heart icon on any college card to add it here.
        </p>
        <a href="colleges.php" class="wl-btn">
          Browse IIMs
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2.5">
            <line x1="5" y1="12" x2="19" y2="12" />
            <polyline points="12 5 19 12 12 19" />
          </svg>
        </a>
      </div>

    <?php else: ?>

      <!-- Section header -->
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4" id="wlSh">
        <h2 class="fw-bold mb-0" style="font-size:1.6rem; color:#1a1a2e;">Saved colleges</h2>
        <span class="wl-sh-badge" id="wlGridBadge"><?= count($savedColleges) ?> saved</span>
      </div>

      <!-- Grid -->
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="wlGrid">
        <?php foreach ($savedColleges as $index => $college): ?>

          <div class="col">
            <div class="wl-card h-100" data-slug="<?= htmlspecialchars($college['slug']) ?>"
              style="transition-delay:<?= min($index * 0.06, 0.48) ?>s" data-reveal>

              <!-- Image -->
              <div class="wl-ci">
                <img src="<?= htmlspecialchars($college['image'] ?? '') ?>"
                  alt="<?= htmlspecialchars($college['name'] ?? '') ?>" loading="lazy" />
                <div class="wl-ci-overlay"></div>
                <?php if (!empty($college['type'])): ?>
                  <span class="wl-ci-badge"><?= htmlspecialchars($college['type']) ?></span>
                <?php endif; ?>
                <?php if (!empty($college['rank'])): ?>
                  <span class="wl-ci-rank">#<?= htmlspecialchars($college['rank']) ?> Rank</span>
                <?php endif; ?>
              </div>

              <!-- Body -->
              <div class="wl-cb">

                <!-- Name + remove -->
                <div class="d-flex align-items-start justify-content-between gap-2">
                  <h3 class="wl-cb-name"><?= htmlspecialchars($college['name'] ?? '') ?></h3>
                  <button type="button" class="wl-remove wl-toggle active"
                    data-slug="<?= htmlspecialchars($college['slug']) ?>" title="Remove from wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                      <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                  </button>
                </div>

                <?php if (!empty($college['location'])): ?>
                  <p class="wl-cb-location d-flex align-items-center gap-1 mt-1 mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2">
                      <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                      <circle cx="12" cy="10" r="3" />
                    </svg>
                    <?= htmlspecialchars($college['location']) ?>
                  </p>
                <?php endif; ?>

                <hr class="my-3" style="border-color:#eef0f3;">

                <!-- Stats -->
                <div class="d-flex gap-3 flex-wrap">
                  <?php if (!empty($college['fees'])): ?>
                    <div class="wl-cb-stat">
                      <span class="wl-cb-stat-val">₹<?= htmlspecialchars($college['fees']) ?>L</span>
                      <span class="wl-cb-stat-key">Total Fees</span>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($college['avg_package'])): ?>
                    <div class="wl-cb-stat">
                      <span class="wl-cb-stat-val">₹<?= htmlspecialchars($college['avg_package']) ?>L</span>
                      <span class="wl-cb-stat-key">Avg Package</span>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($college['intake'])): ?>
                    <div class="wl-cb-stat">
                      <span class="wl-cb-stat-val"><?= htmlspecialchars($college['intake']) ?></span>
                      <span class="wl-cb-stat-key">Intake</span>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- Footer: chips + link -->
                <div class="d-flex align-items-center justify-content-between mt-auto pt-3">
                  <div class="d-flex flex-wrap gap-1">
                    <?php if (!empty($college['short'])): ?>
                      <span class="wl-chip"><?= htmlspecialchars($college['short']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($college['established'])): ?>
                      <span class="wl-chip">Est. <?= htmlspecialchars($college['established']) ?></span>
                    <?php endif; ?>
                  </div>
                  <a href="college-details.php?slug=<?= urlencode($college['slug']) ?>" class="wl-cb-link">
                    View details
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2.5">
                      <line x1="5" y1="12" x2="19" y2="12" />
                      <polyline points="12 5 19 12 12 19" />
                    </svg>
                  </a>
                </div>

              </div><!-- /wl-cb -->
            </div><!-- /wl-card -->
          </div><!-- /col -->

        <?php endforeach; ?>
      </div><!-- /row -->

    <?php endif; ?>

  </div>
</section>

<!-- ══════════════════════════ FINAL CTA ══════════════════════════ -->
<section class="py-3">
  <div class="container">
    <div class="cta-pro position-relative overflow-hidden rounded-5 p-4 p-lg-5">
      <div class="cta-glow"></div>
      <div class="row align-items-center g-4 position-relative" style="z-index:2;">
        <div class="col-lg-7 text-center mx-auto">
          <span class="cta-badge mb-3 d-inline-flex align-items-center">
            <i class="bi bi-stars me-2"></i>
            Trusted by CAT Aspirants Across India
          </span>
          <h4 class="cta-content display-5 fw-bold text-white mb-2 lh-sm">
            Start Your Journey Towards
            <span class="cta-highlight">Top IIM Admissions</span>
          </h4>
          <p class="cta-text mb-4">
            Get personalised guidance from experienced mentors, IIM alumni, and CAT experts.
            From profile evaluation to final admission strategy — we help you at every step.
          </p>
        </div>
        <div class="text-center">
          <button class="button-cta bg-transparent px-4 py-2" onclick="openApplyModal()">Apply</button>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // ─── Scroll reveal ───────────────────────────────────────────────────────────
  (function () {
    var items = document.querySelectorAll('[data-reveal]');
    if (!items.length || !('IntersectionObserver' in window)) {
      items.forEach(function (el) { el.classList.add('is-visible'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
      });
    }, { threshold: 0.08 });
    items.forEach(function (el) { io.observe(el); });
  })();

  // ─── Empty state HTML helper ─────────────────────────────────────────────────
  function getEmptyHTML() {
    return '<div class="wl-empty text-center py-5 px-4">'
      + '<div class="wl-empty-icon">'
      + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke="currentColor">'
      + '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>'
      + '</svg></div>'
      + '<h2 class="fw-bold mb-2" style="font-size:1.35rem;color:#1a1a2e;">Nothing saved yet</h2>'
      + '<p class="text-muted mb-4 mx-auto" style="max-width:340px;font-size:.9rem;line-height:1.6;">Koi bhi college card ke heart icon pe click karke yahan save karein.</p>'
      + '<a href="colleges.php" class="wl-btn">Browse IIMs '
      + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">'
      + '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>'
      + '</svg></a></div>';
  }

  // ─── Update counts in hero + badge ───────────────────────────────────────────
  function updateCounts(remaining) {
    var heroCount = document.getElementById('wlHeroCount');
    var gridBadge = document.getElementById('wlGridBadge');
    if (heroCount) heroCount.textContent = remaining;
    if (gridBadge) gridBadge.textContent = remaining + ' saved';
  }

  // ─── Show empty state if no cards left ───────────────────────────────────────
  function checkEmpty() {
    var grid = document.getElementById('wlGrid');
    var sh = document.getElementById('wlSh');
    if (!grid) return;
    var remaining = grid.querySelectorAll('.wl-card').length;
    updateCounts(remaining);
    if (remaining === 0) {
      if (sh) sh.remove();
      grid.outerHTML = getEmptyHTML();
      updateCounts(0);
    }
  }

  // ─── Remove card with animation ──────────────────────────────────────────────
  function removeCardBySlug(slug) {
    var card = document.querySelector('.wl-card[data-slug="' + slug + '"]');
    if (!card) return;
    card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    card.style.opacity = '0';
    card.style.transform = 'scale(0.94)';
    setTimeout(function () {
      // Remove the wrapping .col div too so grid doesn't leave a gap
      var col = card.closest('.col') || card;
      col.remove();
      checkEmpty();
    }, 320);
  }
</script>
<script>
  // Wishlist toggle remove
  document.addEventListener('click', function (e) {

    var btn = e.target.closest('.wl-toggle');
    if (!btn) return;

    e.preventDefault();

    var slug = btn.dataset.slug;
    if (!slug) return;

    fetch(
      'wishlist.php?wl_action=remove&wl_slug=' + encodeURIComponent(slug),
      {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }
    )
      .then(function (res) {
        return res.json();
      })
      .then(function (data) {

        if (data.action === 'remove') {
          removeCardBySlug(slug);
        }

      })
      .catch(function (err) {
        console.error(err);
      });

  });
</script>
<?php
include '../components/Footer.php';
include '../components/Modals.php';
include '../includes/footer.php';
?>