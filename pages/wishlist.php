<?php
/**
 * wishlist.php  ←→  src/routes/wishlist.tsx
 * Wishlist slugs stored in PHP session.
 */
session_start();
require_once 'data/iims.php';

$page_title   = 'Your Wishlist — IIMs Courses';
$page_description = 'Your saved IIMs.';
$current_page = 'wishlist';

// Handle add / remove
$wishlist = $_SESSION['wishlist'] ?? [];

if (isset($_GET['add'])) {
  $slug = $_GET['add'];
  if (!in_array($slug, $wishlist)) $wishlist[] = $slug;
  $_SESSION['wishlist'] = $wishlist;
  header('Location: '.$_SERVER['HTTP_REFERER']); exit;
}
if (isset($_GET['remove'])) {
  $wishlist = array_values(array_filter($wishlist, fn($s) => $s !== $_GET['remove']));
  $_SESSION['wishlist'] = $wishlist;
  header('Location: wishlist.php'); exit;
}

$savedColleges = array_values(array_filter(array_map(fn($s) => getCollege($s), $wishlist)));

include 'includes/header.php';
include 'components/Navbar.php';
?>

<section class="section" style="padding-top:7rem">
  <div class="container">

    <h1 class="section-title">Your Wishlist</h1>
    <p class="text-muted mt-2"><?= count($savedColleges) ?> saved IIMs.</p>

    <?php if (empty($savedColleges)): ?>
      <div class="empty-state reveal">
        <p class="text-muted">No saved IIMs yet. Tap the heart icon on any college.</p>
        <a href="pages/colleges.php" class="btn btn-hero" style="margin-top:1rem; display:inline-flex">Browse IIMs</a>
      </div>

    <?php else: ?>
      <div class="colleges-grid" style="margin-top:2rem">
        <?php foreach ($savedColleges as $index => $college): ?>
          <div class="reveal" style="transition-delay:<?= $index * 0.07 ?>s">
            <?php include 'components/CollegeCard.php'; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php
include 'components/Footer.php';
include 'includes/footer.php';
?>