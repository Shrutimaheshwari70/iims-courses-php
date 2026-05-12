<?php
/**
 * components/CollegeCard.php
 */

$cats_display = array_slice($college['category'], 0, 3);

$in_wish    = in_array($college['slug'], $_SESSION['wishlist'] ?? []);
$in_compare = in_array($college['slug'], $_SESSION['compare'] ?? []);

$detailsLink = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false)
    ? "colleges.php?slug={$college['slug']}"
    : "pages/colleges.php?slug={$college['slug']}";
?>

<style>
/* ── Wishlist heart ─────────────────────────────────────────────── */
.card-icon-btn.wl-toggle { transition: transform 0.2s ease, background 0.2s ease; }
.card-icon-btn.wl-toggle.active                { color:#e94560!important; background:rgba(233,69,96,.15)!important; border-color:rgba(233,69,96,.45)!important; }
.card-icon-btn.wl-toggle.active svg            { fill:#e94560!important; stroke:#e94560!important; }
.card-icon-btn.wl-toggle:hover                 { transform:scale(1.18); background:rgba(233,69,96,.18)!important; color:#e94560!important; }
.card-icon-btn.wl-toggle:not(.active):hover svg{ fill:none; stroke:#e94560!important; }

/* ── Compare icon ───────────────────────────────────────────────── */
.card-icon-btn.cmp-toggle { transition: transform 0.2s ease, background 0.2s ease; }
.card-icon-btn.cmp-toggle.active                { color:#2563eb!important; background:rgba(37,99,235,.13)!important; border-color:rgba(37,99,235,.4)!important; }
.card-icon-btn.cmp-toggle.active svg            { stroke:#2563eb!important; }
.card-icon-btn.cmp-toggle:hover                 { transform:scale(1.18); background:rgba(37,99,235,.13)!important; color:#2563eb!important; }
.card-icon-btn.cmp-toggle:not(.active):hover svg{ stroke:#2563eb!important; }

/* ── Pop animation ──────────────────────────────────────────────── */
@keyframes iconPop { 0%{transform:scale(1)} 40%{transform:scale(1.42)} 70%{transform:scale(.88)} 100%{transform:scale(1)} }
.card-icon-btn.pop { animation: iconPop .38s cubic-bezier(.4,0,.2,1); }
</style>

<div class="college-card fade-up" style="animation-delay:<?= $index * 0.06 ?>s">

  <div class="college-card-img">
    <img src="<?= htmlspecialchars($college['image']) ?>" alt="<?= htmlspecialchars($college['name']) ?>" loading="lazy"/>
    <div class="college-card-img-overlay"></div>

    <div class="college-card-rank">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
      </svg>
      NIRF #<?= $college['ranking'] ?>
    </div>

    <div class="college-card-actions">

      <!-- ✅ Wishlist AJAX toggle -->
      <button
        type="button"
        class="card-icon-btn wl-toggle <?= $in_wish ? 'active' : '' ?>"
        data-slug="<?= htmlspecialchars($college['slug']) ?>"
        title="<?= $in_wish ? 'Remove from wishlist' : 'Add to wishlist' ?>"
        aria-pressed="<?= $in_wish ? 'true' : 'false' ?>"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
             fill="<?= $in_wish ? '#e94560' : 'none' ?>"
             stroke="<?= $in_wish ? '#e94560' : 'currentColor' ?>"
             stroke-width="2" style="transition:fill .2s,stroke .2s;">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
      </button>

      <!-- ✅ Compare AJAX toggle (replaces old form POST) -->
      <button
        type="button"
        class="card-icon-btn cmp-toggle <?= $in_compare ? 'active' : '' ?>"
        data-slug="<?= htmlspecialchars($college['slug']) ?>"
        data-name="<?= htmlspecialchars($college['name']) ?>"
        data-image="<?= htmlspecialchars($college['image']) ?>"
        data-location="<?= htmlspecialchars($college['location']) ?>"
        title="<?= $in_compare ? 'Remove from compare' : 'Add to compare' ?>"
        aria-pressed="<?= $in_compare ? 'true' : 'false' ?>"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="<?= $in_compare ? '#2563eb' : 'currentColor' ?>"
             stroke-width="2" style="transition:stroke .2s;">
          <polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/>
          <polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/>
        </svg>
      </button>

    </div>

    <div class="college-card-name">
      <h3><?= htmlspecialchars($college['name']) ?></h3>
      <div class="loc">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
        </svg>
        <?= htmlspecialchars($college['location']) ?>
      </div>
    </div>
  </div>

  <div class="college-card-body">
    <div class="college-card-meta">
      <div class="college-rating">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
        <span class="score"><?= $college['rating'] ?></span>
        <span class="count">(<?= number_format($college['reviews']) ?>)</span>
      </div>
      <span class="college-meta-dot">•</span>
      <span class="college-est">Est. <?= $college['established'] ?></span>
    </div>

    <div class="college-stats">
      <div class="college-stat">
        <div class="college-stat-label">Total Fees</div>
        <div class="college-stat-value">₹<?= $college['fees'] ?>L</div>
      </div>
      <div class="college-stat">
        <div class="college-stat-label">Avg Placement</div>
        <div class="college-stat-value accent">₹<?= $college['placement'] ?>L</div>
      </div>
    </div>

    <div class="college-tags">
      <?php foreach ($cats_display as $cat): ?>
        <span class="college-tag"><?= htmlspecialchars($cat) ?></span>
      <?php endforeach; ?>
    </div>

    <div class="college-card-footer">
      <button class="btn btn-hero btn-sm" onclick="openModal('apply-modal', '<?= htmlspecialchars($college['name']) ?>')">
        Apply Now
      </button>
      <a href="<?= $detailsLink ?>" class="btn btn-outline btn-sm">View Details</a>
    </div>
  </div>

</div>