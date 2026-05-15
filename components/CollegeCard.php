<?php
/**
 * components/CollegeCard.php
 */

// Dynamic asset base path
$assetBase = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false)
    ? '../assets/'
    : 'assets/';

// Clean image path
$imgFile = preg_replace('#^(\.\./)*assets/images/#', '', $college['image']);
$imgSrc  = $assetBase . 'images/' . $imgFile;

// Show only 5 courses
$cats_display = array_slice($college['category'], 0, 5);

$in_wish    = in_array($college['slug'], $_SESSION['wishlist'] ?? []);
$in_compare = in_array($college['slug'], $_SESSION['compare'] ?? []);

// College details page
$detailsLink = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false)
    ? "college-details.php?slug={$college['slug']}"
    : "pages/college-details.php?slug={$college['slug']}";

// Colleges page
$allCollegeLink = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false)
    ? "colleges.php"
    : "pages/colleges.php";
?>

<div class="college-card fade-up" style="animation-delay:<?= ($index ?? 0) * 0.06 ?>s">

  <div class="college-card-img">

    <img src="<?= htmlspecialchars($imgSrc) ?>"
         alt="<?= htmlspecialchars($college['name']) ?>"
         loading="lazy"/>

    <div class="college-card-img-overlay"></div>

    <div class="college-card-rank">
      NIRF #<?= $college['ranking'] ?>
    </div>
    <div class="college-card-name">
      <h3><?= htmlspecialchars($college['name']) ?></h3>
      <div class="loc">
        <?= htmlspecialchars($college['location']) ?>
      </div>
    </div>

  </div>

  <div class="college-card-body">

    <div class="college-card-meta">
      <span><?= $college['rating'] ?> ⭐</span>
      <span>•</span>
      <span>Est. <?= $college['established'] ?></span>
    </div>

    <div class="college-stats">

      <div class="college-stat">
        <div class="college-stat-label">Total Fees</div>
        <div class="college-stat-value">₹<?= $college['fees'] ?>L</div>
      </div>

      <div class="college-stat">
        <div class="college-stat-label">Avg Placement</div>
        <div class="college-stat-value">₹<?= $college['placement'] ?>L</div>
      </div>

    </div>

    <!-- SHOW ONLY 5 COURSES -->
    <div class="college-tags">
      <?php foreach ($cats_display as $cat): ?>
        <span class="college-tag">
          <?= htmlspecialchars($cat) ?>
        </span>
      <?php endforeach; ?>
    </div>

    <div class="college-card-footer">

      <button class="btn btn-hero btn-sm" onclick="openApplyModal()">
        Apply Now
      </button>

      <!-- OPEN COLLEGE DETAILS PAGE -->
      <a href="<?= $detailsLink ?>"
         class="btn btn-outline btn-sm text-dark border">
        View Details
      </a>

    </div>

  </div>

</div>
<style>
  .card-icon-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.35);
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s ease;
    color: #fff;
    position: relative;
  }

  .card-icon-btn:hover {
    transform: translateY(-2px);
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.6);
  }

  .card-icon-btn svg {
    width: 18px;
    height: 18px;
  }

  /* Wishlist active (ORANGE) */
  .card-icon-btn.active {
    background: #ff7a00;
    border-color: #ff7a00;
    color: #fff;
  }

  /* Compare active (WHITE theme) */
  .cmp-toggle.active {
    background: #ffffff;
    border-color: #ffffff;
    color: #ff7a00;
  }

  .cmp-toggle.active svg {
    stroke: #ff7a00;
  }

  .college-card-actions {
    display: flex;
    gap: 8px;
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 3;
  }
</style>