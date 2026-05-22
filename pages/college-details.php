<?php
// ── Session shuru karo agar nahi hui ──
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Include your main data file
require_once '../data/iims.php';

// Get slug from URL
$slug = trim($_GET['slug'] ?? '');

// Fetch college using your existing getCollege() function
$c = getCollege($slug);

if (!$c) {
  header('HTTP/1.0 404 Not Found');
  $page_title = 'College Not Found';
  include '../includes/header.php';
  include '../components/Navbar.php';
  echo '<section class="section" style="padding-top:8rem;text-align:center"><h1>College not found.</h1><p><a href="colleges.php" class="btn btn-navy" style="display:inline-flex;margin-top:1rem">← Back to IIMs</a></p></section>';
  include '../components/Footer.php';
  include '../includes/footer.php';
  exit;
}

$college = $c;

$page_title = $c['name'] . ' — Fees, Placements, Admissions';
$page_description = substr($c['about'] ?? '', 0, 150);
$current_page = 'colleges';

// Session wishlist / compare
$wishlist = $_SESSION['wishlist'] ?? [];
$compare = $_SESSION['compare'] ?? [];
$inWish = in_array($slug, $wishlist);
$inCmp = in_array($slug, $compare);

if (isset($_GET['wish'])) {
  if ($inWish)
    $wishlist = array_values(array_filter($wishlist, fn($s) => $s !== $slug));
  else
    $wishlist[] = $slug;
  $_SESSION['wishlist'] = $wishlist;
  header('Location: college-details.php?slug=' . urlencode($slug));
  exit;
}

if (isset($_GET['cmp'])) {
  if (!isset($_SESSION['compare']))
    $_SESSION['compare'] = [];
  if (in_array($slug, $_SESSION['compare'], true)) {
    $_SESSION['compare'] = array_values(
      array_filter($_SESSION['compare'], fn($s) => $s !== $slug)
    );
  } else {
    if (count($_SESSION['compare']) < 3)
      $_SESSION['compare'][] = $slug;
  }
  header('Location: college-details.php?slug=' . urlencode($slug));
  exit;
}

$recruiters = $c['recruiters'] ?? [];
$recruiters = is_array($recruiters) ? $recruiters : [];

$college['scholarships'] = $college['scholarships'] ?? [
  'Education loans up to ₹40L from leading banks',
  'Flexible EMI options post-placement',
];

// Courses offered at THIS college
$collegeCourses = array_values(array_filter(
  $COURSES ?? [],
  fn($course) => in_array($slug, $course['iims'] ?? [])
));

$SECTIONS = ['Overview', 'Courses', 'Admissions', 'Placements', 'Fees', 'Reviews', 'FAQs'];
$recommended = array_slice(array_filter($COLLEGES, fn($x) => $x['slug'] !== $slug), 0, 3);

include '../includes/header.php';
include '../components/Navbar.php';
?>
<style>
  /* ================================================================
     COLLEGE DETAILS PAGE — STYLES
     ================================================================ */

  /* ── Hero ── */
  .cd-hero {
    position: relative;
    height: 60vh;
    min-height: 420px;
    overflow: hidden;
  }

  .cd-hero-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .cd-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(26, 35, 64, .4) 0%, rgba(20, 26, 50, .88) 100%);
  }

  .cd-hero-content {
    position: relative;
    height: 100%;
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    color: #fff;
  }

  .cd-rank-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(255, 255, 255, .15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, .2);
    border-radius: 999px;
    padding: .3rem .85rem;
    font-size: .7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .08em;
    width: fit-content;
    margin-bottom: 1rem;
  }

  .cd-rank-badge svg {
    width: 12px;
    height: 12px;
  }

  .cd-hero-title {
    font-family: var(--font-display);
    font-weight: 800;
    font-size: clamp(1.8rem, 5vw, 3.75rem);
    line-height: 1.1;
    letter-spacing: -0.02em;
    margin: 0 0 .75rem;
  }

  .cd-hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: .9rem;
    color: rgba(255, 255, 255, .9);
    margin-bottom: .6rem;
  }

  .cd-hero-meta-item {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
  }

  .cd-hero-meta-item svg {
    width: 15px;
    height: 15px;
    flex-shrink: 0;
  }

  .cd-hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: .75rem;
    align-items: center;
  }


  /* ICON BUTTON BASE */
  .cd-circle-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, .15);
    border: 1.5px solid rgba(255, 255, 255, .35);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: #fff;
    text-decoration: none;
    cursor: pointer;
    transition: background .2s, border-color .2s, transform .2s;
  }

  .cd-circle-btn:hover {
    transform: translateY(-1px);
    background: rgba(255, 255, 255, .25);
    border-color: rgba(255, 255, 255, .6);
    color: #fff;
  }

  .cd-circle-btn svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
  }

  .cd-circle-btn i {
    font-size: 15px;
    line-height: 1;
  }

  /* WISHLIST — active */
  .active-wish {
    background: var(--accent);
    border-color: #ff4d6d;
    color: #fff;
  }

  .active-wish:hover {
    background: #e6354f;
    border-color: #e6354f;
    color: #fff;
  }

  /* COMPARE — active */
  .active-compare {
    background: #ff7a00;
    border-color: #ff7a00;
    color: #fff;
  }

  .active-compare:hover {
    background: #e06c00;
    border-color: #e06c00;
    color: #fff;
  }

  /* COMPARE — limit reached */
  .disabled-compare {
    background: rgba(255, 255, 255, .08);
    border-color: rgba(255, 255, 255, .15);
    color: rgba(255, 255, 255, .35);
    opacity: 1;
    cursor: not-allowed;
    pointer-events: none;
  }


  /* ── Sticky tabs ── */
  .cd-tabs-bar {
    position: sticky;
    top: 72px;
    z-index: 30;
    background: rgba(var(--background-rgb, 255, 255, 255), .95);
    backdrop-filter: blur(8px);
    border-bottom: 1px solid var(--border);
    border-top: 1px solid grey;
  }

  body.dark .cd-tabs-bar {
    background: rgba(15, 23, 42, .95);
  }

  .cd-tabs {
    display: flex;
    gap: .25rem;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  .cd-tabs::-webkit-scrollbar {
    display: none;
  }

  .cd-tab {
    padding: 1rem;
    font-size: .82rem;
    font-weight: 500;
    white-space: nowrap;
    text-decoration: none;
    color: white;
    border-bottom: 2px solid transparent;
    transition: color .2s, border-color .2s;
    flex-shrink: 0;
  }

  .cd-tab:hover {
    color: orangered;
  }

  .cd-tab.active {
    color: var(--accent);
    border-bottom-color: var(--accent);
  }

  /* ── Body ── */
  .cd-body {
    padding-top: 2rem;
    padding-bottom: 3rem;
  }

  .cd-section {
    margin-bottom: 4rem;
    scroll-margin-top: 130px;
  }

  .cd-section-heading {
    font-family: var(--font-display);
    font-weight: 600;
    font-size: clamp(1.6rem, 3vw, 2.5rem);
    letter-spacing: -0.02em;
    margin-bottom: .6rem;
    color: var(--foreground);
  }

  .cd-muted {
    color: var(--muted-foreground);
    line-height: 1.75;
  }

  .cd-text-lg {
    font-size: .9rem;
  }

  .cd-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 1rem;
    padding: 1.5rem;
  }

  /* ── Stat grid ── */
  .cd-stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-top: 2rem;
  }

  @media(max-width:768px) {
    .cd-stat-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  .cd-stat-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 1rem;
    padding: 1.25rem;
  }

  .cd-stat-label {
    font-size: .65rem;
    text-transform: uppercase;
    letter-spacing: .1em;
    font-weight: 600;
    color: var(--muted-foreground);
  }

  .cd-stat-value {
    font-family: var(--font-display);
    font-weight: 600;
    font-size: 1.5rem;
    margin-top: .25rem;
    color: var(--foreground);
  }

  /* ── Courses fallback ── */
  .cd-courses-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }

  @media(max-width:640px) {
    .cd-courses-grid {
      grid-template-columns: 1fr;
    }
  }

  .cd-card-title {
    font-family: var(--font-display);
    font-weight: 600;
    font-size: 1.05rem;
    color: var(--foreground);
  }

  .cd-course-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .75rem;
    margin-top: .75rem;
    font-size: .85rem;
  }

  .cd-meta-label {
    font-size: .7rem;
    color: var(--muted-foreground);
  }

  .cd-meta-val {
    font-weight: 600;
    color: var(--foreground);
  }

  /* ── Admissions ── */
  /* ── Admissions timeline ── */
  .cd-adm-timeline {
    display: flex;
    flex-direction: column;
    gap: 0;
  }

  .cd-adm-step {
    display: flex;
    gap: 1.25rem;
    align-items: flex-start;
  }

  /* Spine column */
  .cd-adm-spine-col {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
    width: 44px;
  }

  .cd-adm-node {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 1px solid var(--border);
    background: var(--card);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: .875rem;
    flex-shrink: 0;
  }

  .cd-adm-spine-line {
    width: 1px;
    flex: 1;
    min-height: 1.5rem;
    background: var(--border);
    margin: .35rem 0;
  }

  /* Card */
  .cd-adm-card {
    flex: 1;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 1rem 1.1rem;
    background: var(--card);
    border-left: 4px solid var(--step-color, #888);
    margin-bottom: 1.25rem;
  }

  .cd-adm-card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: .55rem;
    gap: .75rem;
  }

  .cd-adm-card-title {
    font-weight: 700;
    font-size: .975rem;
  }

  .cd-adm-tag {
    font-size: .7rem;
    font-weight: 600;
    padding: .22rem .7rem;
    border-radius: 9999px;
    border: 1px solid;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .cd-adm-line {
    font-size: .875rem;
    color: var(--muted-foreground);
    line-height: 1.65;
    margin: 0;
  }

  /* Mobile */
  @media (max-width: 480px) {
    .cd-adm-card-top {
      flex-wrap: wrap;
    }

    .cd-adm-tag {
      font-size: .68rem;
    }
  }

  /* ── Placement charts ── */
  .cd-placement-charts {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
  }

  @media(max-width:768px) {
    .cd-placement-charts {
      grid-template-columns: 1fr;
    }
  }

  .cd-sub-title {
    font-family: var(--font-display);
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 1rem;
    color: var(--foreground);
  }

  .cd-bar-chart {
    display: flex;
    align-items: flex-end;
    gap: .6rem;
    height: 200px;
    padding-top: 1.5rem;
  }

  .cd-bar-col {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    height: 100%;
  }

  .cd-bar-top {
    font-size: .6rem;
    font-weight: 600;
    color: var(--muted-foreground);
    margin-bottom: .25rem;
    text-align: center;
    flex-shrink: 0;
  }

  .cd-bar-track {
    flex: 1;
    width: 100%;
    display: flex;
    align-items: flex-end;
    border-radius: 6px 6px 0 0;
    overflow: hidden;
  }

  .cd-bar-fill {
    width: 100%;
    background: var(--accent);
    border-radius: 6px 6px 0 0;
    transition: height .6s ease;
    min-height: 4px;
  }

  .cd-bar-lbl {
    font-size: .65rem;
    color: var(--muted-foreground);
    margin-top: .3rem;
    text-align: center;
    flex-shrink: 0;
  }

  /* Chips */
  .cd-chips {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
  }

  .cd-chip {
    padding: .35rem .85rem;
    border-radius: 999px;
    background: var(--secondary);
    font-size: .8rem;
    font-weight: 500;
    color: var(--foreground);
  }

  /* ── Fees ── */
  .cd-fees-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
  }

  @media(max-width:640px) {
    .cd-fees-grid {
      grid-template-columns: 1fr;
    }
  }

  .cd-fees-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: .6rem;
    font-size: .875rem;
  }

  .cd-fees-list li {
    display: flex;
    justify-content: space-between;
    padding-bottom: .6rem;
    border-bottom: 1px solid var(--border);
  }

  .cd-fees-list li:last-child {
    border-bottom: none;
  }

  .cd-fees-list li span:last-child {
    font-weight: 600;
    color: var(--foreground);
  }

  .cd-schol-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: .5rem;
    font-size: .875rem;
    color: var(--muted-foreground);
  }

  /* ── Reviews ── */
  .cd-reviews-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }

  @media(max-width:640px) {
    .cd-reviews-grid {
      grid-template-columns: 1fr;
    }
  }

  .cd-review-stars {
    display: flex;
    align-items: center;
    gap: .15rem;
    margin-bottom: .6rem;
  }

  .cd-review-stars svg {
    width: 14px;
    height: 14px;
  }

  .cd-verified-badge {
    font-size: .65rem;
    font-weight: 600;
    color: #3ab07b;
    background: rgba(58, 176, 123, .1);
    padding: .15rem .5rem;
    border-radius: 999px;
    margin-left: .35rem;
  }

  .cd-review-text {
    font-size: .875rem;
    line-height: 1.65;
    color: var(--foreground);
  }

  .cd-review-author {
    font-size: .72rem;
    color: var(--muted-foreground);
    margin-top: .75rem;
  }

  /* ── Recommended Grid ── */
  .rec-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
  }

  @media(max-width:1024px) {
    .rec-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media(max-width:600px) {
    .rec-grid {
      grid-template-columns: 1fr;
    }
  }

  /* ── Courses section ── */
  .crs-section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
  }

  .crs-view-all {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .78rem;
    font-weight: 600;
    color: var(--accent);
    text-decoration: none;
    border: 1.5px solid var(--accent);
    padding: .4rem 1rem;
    border-radius: 999px;
    transition: background .2s, color .2s;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .crs-view-all:hover {
    background: var(--accent);
    color: #fff;
  }

  .crs-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
  }

  @media(max-width:1024px) {
    .crs-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media(max-width:560px) {
    .crs-grid {
      grid-template-columns: 1fr;
    }
  }

  .crs-card {
    display: flex;
    flex-direction: column;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 1.1rem;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
    transition: transform .28s cubic-bezier(.4, 0, .2, 1), box-shadow .28s cubic-bezier(.4, 0, .2, 1), border-color .2s;
    opacity: 0;
    transform: translateY(20px);
    animation: crsCardIn .5s ease forwards;
  }

  @keyframes crsCardIn {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .crs-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(0, 0, 0, .12);
    border-color: var(--accent);
  }

  .crs-card-img {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
    flex-shrink: 0;
  }

  .crs-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .45s ease;
  }

  .crs-card:hover .crs-card-img img {
    transform: scale(1.06);
  }

  .crs-card-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 30%, rgba(10, 15, 40, .58) 100%);
  }

  .crs-cat-pill {
    position: absolute;
    top: .65rem;
    left: .65rem;
    font-size: .6rem;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #fff;
    background: var(--accent);
    padding: .22rem .65rem;
    border-radius: 999px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .25);
  }

  .crs-fee-tag {
    position: absolute;
    bottom: .65rem;
    right: .65rem;
    font-size: .7rem;
    font-weight: 600;
    color: #fff;
    background: rgba(0, 0, 0, .48);
    backdrop-filter: blur(6px);
    padding: .22rem .65rem;
    border-radius: .45rem;
    border: 1px solid rgba(255, 255, 255, .15);
  }

  .crs-card-body {
    padding: 1.1rem 1.15rem 1.2rem;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .crs-card-title {
    font-family: var(--font-display);
    font-weight: 600;
    font-size: .97rem;
    line-height: 1.35;
    color: var(--foreground);
    margin: 0 0 .4rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .crs-card-desc {
    font-size: .8rem;
    color: var(--muted-foreground);
    line-height: 1.6;
    margin: 0;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .crs-card-divider {
    height: 1px;
    background: var(--border);
    margin: .9rem 0;
  }

  .crs-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: .6rem .9rem;
    margin-bottom: .85rem;
  }

  .crs-meta-item {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    font-size: .72rem;
    font-weight: 500;
    color: var(--muted-foreground);
  }

  .crs-meta-item svg {
    width: 12px;
    height: 12px;
    flex-shrink: 0;
    color: var(--accent);
  }

  .crs-card-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .5rem;
  }

  .crs-eligibility {
    font-size: .68rem;
    font-weight: 600;
    padding: .25rem .65rem;
    border-radius: 999px;
    background: var(--secondary);
    color: var(--muted-foreground);
  }

  .crs-explore-link {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    font-size: .75rem;
    font-weight: 600;
    color: var(--accent);
    transition: gap .2s;
  }

  .crs-card:hover .crs-explore-link {
    gap: .5rem;
  }

  /* ── Mobile misc ── */
  @media(max-width:480px) {
    .cd-hero-actions .btn {
      font-size: .8rem;
      padding: .6rem 1rem;
    }

    .cd-hero-actions .cd-circle-btn {
      width: 38px;
      height: 38px;
    }
  }
</style>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="cd-hero">
  <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>" class="cd-hero-img" />
  <div class="cd-hero-overlay"></div>
  <div class="cd-hero-content">

    <span class="cd-rank-badge">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="8" r="6" />
        <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11" />
      </svg>
      NIRF Rank #<?= (int) $c['ranking'] ?>
    </span>

    <h1 class="cd-hero-title"><?= htmlspecialchars($c['name']) ?></h1>

    <div class="cd-hero-meta">
      <span class="cd-hero-meta-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z" />
          <circle cx="12" cy="10" r="3" />
        </svg>
        <?= htmlspecialchars($c['location']) ?>
      </span>
      <span class="cd-hero-meta-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="2">
          <polygon
            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
        </svg>
        <?= $c['rating'] ?> (<?= $c['reviews'] ?>)
      </span>
      <span>Est. <?= $c['established'] ?></span>
    </div>

    <div class="cd-hero-actions">
      <button class="btn btn-hero btn-sm" onclick="openApplyModal()">
        Apply Now
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12" />
          <polyline points="12 5 19 12 12 19" />
        </svg>
      </button>
      <div id="brochure-content">

        <button class="btn btn-outline border text-white" onclick="downloadPDF()" id="brochure-content">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
            <polyline points="7 10 12 15 17 10" />
            <line x1="12" y1="15" x2="12" y2="3" />
          </svg>
          Download Brochure
        </button>
      </div>


      <a href="college-details.php?slug=<?= urlencode($slug) ?>&wish=1"
        class="cd-circle-btn <?= $inWish ? 'active-wish' : '' ?>" title="Wishlist">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="<?= $inWish ? 'currentColor' : 'none' ?>"
          stroke="currentColor" stroke-width="2">
          <path
            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
        </svg></a>
      <?php $isFull = count($compare) >= 3; ?>

      <?php if ($inCmp): ?>

        <a href="college-details.php?slug=<?= urlencode($slug) ?>&cmp=1" class="cd-circle-btn active-compare"
          title="Remove from Compare">

          <i class="bi bi-check2"></i>
        </a>

      <?php elseif ($isFull && !$inCmp): ?>

        <button class="cd-circle-btn disabled-compare" disabled title="Compare Limit Reached">
          <i class="bi bi-slash-circle"></i>
        </button>

      <?php else: ?>

        <a href="college-details.php?slug=<?= urlencode($slug) ?>&cmp=1" class="cd-circle-btn" title="Add to Compare">

          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

            <polyline points="16 3 21 3 21 8" />
            <line x1="4" y1="20" x2="21" y2="3" />
            <polyline points="21 16 21 21 16 21" />
            <line x1="15" y1="15" x2="21" y2="21" />
          </svg>
        </a>

      <?php endif; ?>
    </div>

  </div>
</section>


<!-- ============================================================
     STICKY TABS
     ============================================================ -->
<div class="cd-tabs-bar" id="cdTabsBar">
  <div class="container">
    <div class="cd-tabs" id="cdTabs">
      <?php foreach ($SECTIONS as $s): ?>
        <a href="#cd-<?= $s ?>" class="cd-tab" data-section="<?= $s ?>"><?= $s ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</div>


<!-- ============================================================
     CONTENT
     ============================================================ -->
<div class="container cd-body">

  <!-- ── OVERVIEW ── -->
  <section id="cd-Overview" class="cd-section reveal">
    <h2 class="cd-section-heading">Overview</h2>
    <p class="cd-muted cd-text-lg"><?= htmlspecialchars($c['about'] ?? '') ?></p>
    <div class="cd-stat-grid">
      <div class="cd-stat-card">
        <div class="cd-stat-label">Total Fees</div>
        <div class="cd-stat-value">₹<?= $c['fees'] ?>L</div>
      </div>
      <div class="cd-stat-card">
        <div class="cd-stat-label">Avg Placement</div>
        <div class="cd-stat-value">₹<?= $c['placement'] ?>L</div>
      </div>
      <div class="cd-stat-card">
        <div class="cd-stat-label">Highest</div>
        <div class="cd-stat-value">₹<?= $c['highest'] ?>L</div>
      </div>
      <div class="cd-stat-card">
        <div class="cd-stat-label">Faculty</div>
        <div class="cd-stat-value"><?= $c['faculty'] ?>+</div>
      </div>
    </div>
  </section>

  <!-- ── COURSES ── -->
  <section id="cd-Courses" class="cd-section reveal">
    <div class="crs-section-header">
      <div>
        <h2 class="cd-section-heading" style="margin-bottom:.4rem">Courses Offered</h2>
        <p class="cd-muted" style="font-size:.9rem;margin:0">
          <?= count($collegeCourses) ?> programme<?= count($collegeCourses) !== 1 ? 's' : '' ?> available at
          <?= htmlspecialchars($c['short'] ?? $c['name']) ?>
        </p>
      </div>
      <?php if (!empty($collegeCourses)): ?>
        <a href="courses.php" class="crs-view-all">
          View all courses
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            width="13" height="13">
            <line x1="5" y1="12" x2="19" y2="12" />
            <polyline points="12 5 19 12 12 19" />
          </svg>
        </a>
      <?php endif; ?>
    </div>

    <?php if (!empty($collegeCourses)): ?>
      <div class="crs-grid">
        <?php foreach ($collegeCourses as $idx => $course): ?>
          <a href="course-details.php?slug=<?= urlencode($course['slug']) ?>" class="crs-card"
            style="animation-delay:<?= $idx * 0.07 ?>s">
            <div class="crs-card-img">
              <img src="<?= htmlspecialchars($course['image'] ?? '') ?>" alt="<?= htmlspecialchars($course['title']) ?>"
                loading="lazy" />
              <div class="crs-card-img-overlay"></div>
              <span class="crs-cat-pill"><?= htmlspecialchars($course['category'] ?? '') ?></span>
              <span class="crs-fee-tag">₹<?= htmlspecialchars((string) ($course['fees'] ?? '')) ?>L</span>
            </div>
            <div class="crs-card-body">
              <h4 class="crs-card-title"><?= htmlspecialchars($course['title']) ?></h4>
              <p class="crs-card-desc"><?= htmlspecialchars(mb_substr($course['description'] ?? '', 0, 90)) ?>…</p>
              <div class="crs-card-divider"></div>
              <div class="crs-card-meta">
                <div class="crs-meta-item">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                  </svg>
                  <?= htmlspecialchars($course['duration'] ?? '2 Years') ?>
                </div>
                <div class="crs-meta-item">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                  </svg>
                  Intake <?= htmlspecialchars((string) ($c['intake'] ?? '')) ?>
                </div>
                <?php if (!empty($course['mode'])): ?>
                  <div class="crs-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2">
                      <rect x="2" y="3" width="20" height="14" rx="2" />
                      <line x1="8" y1="21" x2="16" y2="21" />
                      <line x1="12" y1="17" x2="12" y2="21" />
                    </svg>
                    <?= htmlspecialchars($course['mode']) ?>
                  </div>
                <?php endif; ?>
              </div>
              <div class="crs-card-cta">
                <span class="crs-eligibility">CAT + Bachelor's</span>
                <span class="crs-explore-link">
                  Explore
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" width="12" height="12">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                  </svg>
                </span>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <div class="cd-courses-grid">
        <?php foreach ($c['category'] as $cat): ?>
          <div class="cd-card">
            <h4 class="cd-card-title">MBA in <?= htmlspecialchars($cat) ?></h4>
            <div class="cd-course-meta">
              <div>
                <div class="cd-meta-label">Duration</div>
                <div class="cd-meta-val">2 Years</div>
              </div>
              <div>
                <div class="cd-meta-label">Fees</div>
                <div class="cd-meta-val">₹<?= $c['fees'] ?>L</div>
              </div>
              <div>
                <div class="cd-meta-label">Intake</div>
                <div class="cd-meta-val"><?= $c['intake'] ?></div>
              </div>
              <div>
                <div class="cd-meta-label">Eligibility</div>
                <div class="cd-meta-val">CAT + Bachelor's</div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>

  <!-- ── ADMISSIONS ── -->
  <!-- ── ADMISSIONS PROCESS ── -->
  <section id="cd-Admissions" class="cd-section reveal">
    <h2 class="cd-section-heading">Admissions Process</h2>

    <div class="cd-adm-timeline">

      <?php
      $steps = [
        [
          'num' => '01',
          'color' => '#3B8BD4',
          'tag' => ['label' => 'Required', 'bg' => '#E6F1FB', 'border' => '#B5D4F4', 'text' => '#185FA5'],
          'title' => 'Entrance exam',
          'lines' => [
            'Qualify ' . htmlspecialchars(implode(' / ', $c['exams'])) . ' with the required cutoff percentile.',
            'IIM-A, B, C typically require 90th percentile or above.',
          ],
        ],
        [
          'num' => '02',
          'color' => '#0F6E56',
          'tag' => ['label' => 'On campus', 'bg' => '#E1F5EE', 'border' => '#9FE1CB', 'text' => '#0F6E56'],
          'title' => 'WAT &amp; PI round',
          'lines' => [
            'Written Ability Test followed by Personal Interview at the IIM campus.',
            'Held January – March 2026 at respective IIM campuses.',
          ],
        ],
        [
          'num' => '03',
          'color' => '#BA7517',
          'tag' => ['label' => 'Merit-based', 'bg' => '#FAEEDA', 'border' => '#FAC775', 'text' => '#854F0B'],
          'title' => 'Final selection',
          'lines' => [
            'Composite score: CAT percentile, academics, work experience,',
            'gender diversity factor, and WAT-PI performance.',
          ],
        ],
      ];
      foreach ($steps as $i => $step):
        $is_last = $i === count($steps) - 1;
        ?>
        <div class="cd-adm-step">

          <!-- Left: number node + spine -->
          <div class="cd-adm-spine-col">
            <div class="cd-adm-node"><?= $step['num'] ?></div>
            <?php if (!$is_last): ?>
              <div class="cd-adm-spine-line"></div>
            <?php endif; ?>
          </div>

          <!-- Right: card -->
          <div class="cd-adm-card" style="--step-color: <?= $step['color'] ?>">
            <div class="cd-adm-card-top">
              <span class="cd-adm-card-title"><?= $step['title'] ?></span>
              <span class="cd-adm-tag"
                style="background:<?= $step['tag']['bg'] ?>;border-color:<?= $step['tag']['border'] ?>;color:<?= $step['tag']['text'] ?>">
                <?= $step['tag']['label'] ?>
              </span>
            </div>
            <?php foreach ($step['lines'] as $line): ?>
              <p class="cd-adm-line"><?= $line ?></p>
            <?php endforeach; ?>
          </div>

        </div>
      <?php endforeach; ?>

    </div>
  </section>

  <!-- ── PLACEMENTS ── -->
  <section id="cd-Placements" class="cd-section reveal">
    <h2 class="cd-section-heading">Placements</h2>
    <p class="cd-muted" style="margin-bottom:1.5rem">
      <?= htmlspecialchars($c['name']) ?> consistently delivers top-tier placements with an average package of
      ₹<?= $c['placement'] ?>L and the highest reaching ₹<?= $c['highest'] ?>L in the latest cohort.
      Recruiters span consulting, banking, tech and FMCG — including
      <?= htmlspecialchars(implode(', ', array_slice($recruiters, 0, 4))) ?>.
    </p>

    <div class="cd-placement-charts">
      <?php if (!empty($c['placementsByYear'])): ?>
        <div class="cd-card">
          <h4 class="cd-sub-title">Avg &amp; Highest (₹L) — Last 5 Years</h4>
          <div class="cd-bar-chart">
            <?php
            $maxAvg = max(array_column($c['placementsByYear'], 'avg'));
            foreach ($c['placementsByYear'] as $row):
              $pct = $maxAvg ? round(($row['avg'] / $maxAvg) * 100) : 0; ?>
              <div class="cd-bar-col">
                <div class="cd-bar-top">₹<?= $row['avg'] ?>L</div>
                <div class="cd-bar-track">
                  <div class="cd-bar-fill" style="height:<?= $pct ?>%"></div>
                </div>
                <div class="cd-bar-lbl"><?= $row['year'] ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($c['salaryDist'])): ?>
        <div class="cd-card">
          <h4 class="cd-sub-title">Salary Distribution (%)</h4>
          <div class="cd-bar-chart">
            <?php
            $sdColors = ['#1e3a6e', '#2d5a9e', '#e07b39', '#e8954d'];
            foreach ($c['salaryDist'] as $idx => $row):
              $color = $sdColors[$idx % count($sdColors)]; ?>
              <div class="cd-bar-col">
                <div class="cd-bar-top"><?= $row['pct'] ?>%</div>
                <div class="cd-bar-track">
                  <div class="cd-bar-fill" style="height:<?= $row['pct'] ?>%;background:<?= $color ?>"></div>
                </div>
                <div class="cd-bar-lbl" style="font-size:.6rem"><?= htmlspecialchars($row['range']) ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div style="margin-top:1.5rem">
      <h4 class="cd-sub-title">Top Recruiters</h4>
      <?php if (!empty($recruiters)): ?>
        <div class="cd-chips">
          <?php foreach ($recruiters as $r): ?>
            <span class="cd-chip"><?= htmlspecialchars($r) ?></span>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="cd-muted">Recruiter data coming soon.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- ── FEES ── -->
  <section id="cd-Fees" class="cd-section reveal">
    <h2 class="cd-section-heading">Fees &amp; Scholarships</h2>
    <div class="cd-fees-grid">
      <div class="cd-card">
        <h4 class="cd-sub-title">Fee Breakdown (Total ₹<?= $c['fees'] ?>L)</h4>
        <ul class="cd-fees-list">
          <li><span>Tuition fee</span><span>₹<?= number_format($c['fees'] * 0.7, 1) ?>L</span></li>
          <li><span>Hostel &amp; Mess</span><span>₹<?= number_format($c['fees'] * 0.18, 1) ?>L</span></li>
          <li><span>Library &amp; Tech</span><span>₹<?= number_format($c['fees'] * 0.07, 1) ?>L</span></li>
          <li><span>Misc</span><span>₹<?= number_format($c['fees'] * 0.05, 1) ?>L</span></li>
        </ul>
      </div>
      <div class="cd-card">
        <h4 class="cd-sub-title">Scholarships &amp; EMI</h4>
        <ul class="cd-schol-list">
          <?php foreach ($college['scholarships'] as $item): ?>
            <li>• <?= htmlspecialchars($item) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </section>

  <!-- ── REVIEWS ── -->
  <section id="cd-Reviews" class="cd-section reveal">
    <h2 class="cd-section-heading">Student Reviews</h2>
    <div class="cd-reviews-grid">
      <?php foreach (array_slice($TESTIMONIALS, 0, 4) as $t): ?>
        <div class="cd-card">
          <div class="cd-review-stars">
            <?php for ($k = 0; $k < $t['rating']; $k++): ?>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="1">
                <polygon
                  points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
              </svg>
            <?php endfor; ?>
            <span class="cd-verified-badge">Verified</span>
          </div>
          <p class="cd-review-text">"<?= htmlspecialchars($t['quote']) ?>"</p>
          <div class="cd-review-author">— <?= htmlspecialchars($t['name']) ?>, <?= htmlspecialchars($t['role']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ── FAQ ── -->
  <?php $faqs = $COLLEGE_FAQS[$college['slug']] ?? []; ?>
  <?php if (!empty($faqs)): ?>
    <section id="cd-FAQs" class="cd-section reveal">
      <h2 class="cd-section-heading">Frequently Asked Questions</h2>
      <div class="faq-wrap" style="max-width:100%">
        <?php foreach ($faqs as $faq): ?>
          <div class="faq-item">
            <div class="faq-question">
              <?= htmlspecialchars($faq['q']) ?>
              <svg class="faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9" />
              </svg>
            </div>
            <div class="faq-answer"><?= htmlspecialchars($faq['a']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- ── RECOMMENDED ── -->
  <section class="cd-section">
    <h3 class="cd-section-heading" style="font-size:clamp(1.5rem,3vw,2rem)">Recommended IIMs</h3>
    <div class="rec-grid">
      <?php foreach (array_values($recommended) as $index => $college): ?>
        <div class="reveal" style="transition-delay:<?= $index * 0.07 ?>s">
          <?php include '../components/CollegeCard.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ── CTA ── -->
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

</div><!-- /cd-body -->




<script>
  (function () {
    const tabs = document.querySelectorAll('.cd-tab');
    const sections = document.querySelectorAll('.cd-section[id]');
    function onScroll() {
      let current = '';
      sections.forEach(sec => {
        if (window.scrollY >= sec.offsetTop - 160) current = sec.id.replace('cd-', '');
      });
      tabs.forEach(t => t.classList.toggle('active', t.dataset.section === current));
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  })();
</script>

<script>
  document.querySelectorAll('.faq-question').forEach(q => {
    q.addEventListener('click', () => {
      const item = q.closest('.faq-item');
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
      if (!isOpen) item.classList.add('open');
    });
  });
</script>
<script>
  function downloadPDF() {
    const element = document.querySelector('.cd-body');  // captures all the main content

    const opt = {
      margin: [10, 10, 10, 10],
      filename: '<?= htmlspecialchars(addslashes($c['name'])) ?>-brochure.pdf',
      image: {
        type: 'jpeg',
        quality: 0.98
      },
      html2canvas: {
        scale: 2,
        useCORS: true,
        scrollY: 0
      },
      jsPDF: {
        unit: 'mm',
        format: 'a4',
        orientation: 'portrait'
      }
    };

    html2pdf().set(opt).from(element).save();
  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<?php
include '../components/Modals.php';
include '../components/Footer.php';
include '../includes/footer.php';
?>