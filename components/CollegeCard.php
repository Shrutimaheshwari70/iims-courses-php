<?php
/**
 * components/CollegeCard.php
 * PHP conversion of src/components/CollegeCard.tsx
 */

$cats_display = array_slice($college['category'], 0, 3);

$in_wish    = in_array($college['slug'], $_SESSION['wishlist'] ?? []);
$in_compare = in_array($college['slug'], $_SESSION['compare'] ?? []);

/* Dynamic details link */
$detailsLink = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false)
    ? "colleges.php?slug={$college['slug']}"
    : "pages/colleges.php?slug={$college['slug']}";
?>

<div class="college-card fade-up" style="animation-delay:<?= $index * 0.06 ?>s">

  <!-- Image area -->
  <div class="college-card-img">

    <img
      src="<?= htmlspecialchars($college['image']) ?>"
      alt="<?= htmlspecialchars($college['name']) ?>"
      loading="lazy"
    />

    <div class="college-card-img-overlay"></div>

    <!-- Rank -->
    <div class="college-card-rank">
      <svg xmlns="http://www.w3.org/2000/svg"
           viewBox="0 0 24 24"
           fill="none"
           stroke="currentColor"
           stroke-width="2">
        <circle cx="12" cy="8" r="6"/>
        <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
      </svg>

      NIRF #<?= $college['ranking'] ?>
    </div>

    <!-- Actions -->
    <div class="college-card-actions">

      <!-- Wishlist -->
      <form method="post" action="pages/wishlist.php" style="display:contents">

        <input type="hidden" name="slug" value="<?= $college['slug'] ?>">

        <input
          type="hidden"
          name="redirect"
          value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>"
        >

        <button
          type="submit"
          class="card-icon-btn <?= $in_wish ? 'active' : '' ?>"
          title="<?= $in_wish ? 'Remove from wishlist' : 'Add to wishlist' ?>"
        >

          <svg xmlns="http://www.w3.org/2000/svg"
               viewBox="0 0 24 24"
               fill="<?= $in_wish ? 'currentColor' : 'none' ?>"
               stroke="currentColor"
               stroke-width="2">

            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>

        </button>
      </form>

      <!-- Compare -->
      <form method="post" action="pages/compare.php" style="display:contents">

        <input type="hidden" name="slug" value="<?= $college['slug'] ?>">

        <input
          type="hidden"
          name="redirect"
          value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>"
        >

        <button
          type="submit"
          class="card-icon-btn <?= $in_compare ? 'active' : '' ?>"
          title="<?= $in_compare ? 'Remove from compare' : 'Add to compare' ?>"
        >

          <svg xmlns="http://www.w3.org/2000/svg"
               viewBox="0 0 24 24"
               fill="none"
               stroke="currentColor"
               stroke-width="2">

            <polyline points="16 3 21 3 21 8"/>
            <line x1="4" y1="20" x2="21" y2="3"/>
            <polyline points="21 16 21 21 16 21"/>
            <line x1="15" y1="15" x2="21" y2="21"/>
          </svg>

        </button>
      </form>
    </div>

    <!-- Name -->
    <div class="college-card-name">

      <h3><?= htmlspecialchars($college['name']) ?></h3>

      <div class="loc">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2">

          <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>
          <circle cx="12" cy="10" r="3"/>
        </svg>

        <?= htmlspecialchars($college['location']) ?>
      </div>
    </div>

  </div>

  <!-- Body -->
  <div class="college-card-body">

    <div class="college-card-meta">

      <div class="college-rating">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>

        <span class="score"><?= $college['rating'] ?></span>

        <span class="count">
          (<?= number_format($college['reviews']) ?>)
        </span>
      </div>

      <span class="college-meta-dot">•</span>

      <span class="college-est">
        Est. <?= $college['established'] ?>
      </span>

    </div>

    <!-- Stats -->
    <div class="college-stats">

      <div class="college-stat">
        <div class="college-stat-label">Total Fees</div>
        <div class="college-stat-value">
          ₹<?= $college['fees'] ?>L
        </div>
      </div>

      <div class="college-stat">
        <div class="college-stat-label">Avg Placement</div>
        <div class="college-stat-value accent">
          ₹<?= $college['placement'] ?>L
        </div>
      </div>

    </div>

    <!-- Tags -->
    <div class="college-tags">

      <?php foreach ($cats_display as $cat): ?>

        <span class="college-tag">
          <?= htmlspecialchars($cat) ?>
        </span>

      <?php endforeach; ?>

    </div>

    <!-- Footer -->
    <div class="college-card-footer">

      <button
        class="btn btn-hero btn-sm"
        onclick="openModal('apply-modal', '<?= htmlspecialchars($college['name']) ?>')"
      >
        Apply Now
      </button>

      <a href="<?= $detailsLink ?>" class="btn btn-outline btn-sm">
        View Details
      </a>

    </div>

  </div>

</div>