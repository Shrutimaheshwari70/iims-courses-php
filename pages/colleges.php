<?php
/**
 * pages/colleges.php
 * Single file — handles BOTH the list view AND the detail view.
 * ?slug=iim-ahmedabad  → college detail page
 * (no slug)            → colleges list page
 */

session_start();
require_once '../data/iims.php';

$slug = trim($_GET['slug'] ?? '');

/* ── route decision ────────────────────────────────────────────── */
if ($slug !== '') {
  /* ── DETAIL VIEW ── */
  $c = getCollege($slug);
  if (!$c) {
    header('HTTP/1.0 404 Not Found');
    $page_title = 'College Not Found';
    include '../includes/header.php';
    include '../components/Navbar.php';
    echo '<div style="padding-top:8rem;text-align:center;font-size:1.1rem;">College not found.</div>';
    include '../components/Footer.php';
    include '../includes/footer.php';
    exit;
  }
  $page_title = htmlspecialchars($c['name']) . ' — Fees, Placements, Admissions';
  $page_description = htmlspecialchars(mb_substr($c['about'] ?? '', 0, 150));
  $current_page = 'colleges';

  $SECTIONS = ['Overview', 'Courses', 'Admissions', 'Placements', 'Fees', 'Reviews', 'Faculty', 'FAQ'];
  $recommended = array_values(array_slice(array_filter($COLLEGES, fn($x) => $x['slug'] !== $slug), 0, 3));

  include '../includes/header.php';
  include '../components/Navbar.php';
  ?>

  <!-- Bootstrap Icons only -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <?php
  include '../components/Modals.php';
  include '../components/Footer.php';
  include '../includes/footer.php';
  exit;
}

/* ══════════════════════════════════════════════════════════════════════
   LIST VIEW
   ══════════════════════════════════════════════════════════════════════ */

$q = trim($_GET['q'] ?? '');
$selCats = (array) ($_GET['cats'] ?? []);
$selExams = (array) ($_GET['exams'] ?? []);
$feeMin = (int) ($_GET['fee_min'] ?? 0);
$feeMax = (int) ($_GET['fee_max'] ?? 30);
$minPlacement = (int) ($_GET['placement'] ?? 0);
$minRating = (float) ($_GET['rating'] ?? 0);
$sortBy = trim($_GET['sort'] ?? 'ranking');
$perPage = 10;
$currentPage = max(1, (int) ($_GET['page'] ?? 1));

$CATS = ['Management', 'Finance', 'Marketing', 'HR', 'Operations', 'Business Analytics', 'International Business'];
$EXAMS = ['CAT', 'GMAT', 'IPMAT'];

$activeCount = count($selCats) + count($selExams)
  + ($feeMin > 0 ? 1 : 0)
  + ($feeMax < 30 ? 1 : 0)
  + ($minPlacement > 0 ? 1 : 0)
  + ($minRating > 0 ? 1 : 0);

/* ── Filter logic ── */
$filtered = array_values(array_filter($COLLEGES, function ($c) use ($q, $selCats, $selExams, $feeMin, $feeMax, $minPlacement, $minRating) {
  if ($q && stripos($c['name'], $q) === false && stripos($c['location'], $q) === false)
    return false;
  if (!empty($selCats) && !array_intersect($selCats, $c['category']))
    return false;
  if (!empty($selExams) && !array_intersect($selExams, $c['exams']))
    return false;
  if ($c['fees'] < $feeMin || $c['fees'] > $feeMax)
    return false;
  if ($c['placement'] < $minPlacement)
    return false;
  if ($c['rating'] < $minRating)
    return false;
  return true;
}));

/* ── Sort ── */
usort($filtered, function ($a, $b) use ($sortBy) {
  switch ($sortBy) {
    case 'fees_asc':
      return $a['fees'] <=> $b['fees'];
    case 'fees_desc':
      return $b['fees'] <=> $a['fees'];
    case 'placement':
      return $b['placement'] <=> $a['placement'];
    case 'location':
      return strcmp($a['location'], $b['location']);
    default:
      return ($a['ranking'] ?? 999) <=> ($b['ranking'] ?? 999);
  }
});

/* ── Pagination ── */
$totalFiltered = count($filtered);
$totalPages = max(1, (int) ceil($totalFiltered / $perPage));
$currentPage = min($currentPage, $totalPages);
$offset = ($currentPage - 1) * $perPage;
$pageItems = array_slice($filtered, $offset, $perPage);

function buildUrl(array $overrides): string
{
  $params = array_merge([
    'q' => $_GET['q'] ?? '',
    'cats' => $_GET['cats'] ?? [],
    'exams' => $_GET['exams'] ?? [],
    'fee_min' => $_GET['fee_min'] ?? 0,
    'fee_max' => $_GET['fee_max'] ?? 30,
    'placement' => $_GET['placement'] ?? 0,
    'rating' => $_GET['rating'] ?? 0,
    'sort' => $_GET['sort'] ?? 'ranking',
    'page' => $_GET['page'] ?? 1,
  ], $overrides);
  $params = array_filter($params, fn($v) => $v !== '' && $v !== 0 && $v !== '0' && $v !== [] && $v !== null);
  return 'colleges.php?' . http_build_query($params);
}

$page_title = 'All IIMs — Compare 14 Indian Institutes of Management';
$page_description = 'Browse all 14 IIMs by fees, placements, ranking, location and entrance exams.';
$current_page = 'colleges';

include '../includes/header.php';
include '../components/Navbar.php';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- =====================================================================
     COLLEGES LIST PAGE
===================================================================== -->

<!-- HERO -->
<section class="c-hero">
  <div class="container position-relative" style="z-index:1;">
    <h1 class="text-white fw-bold">Discover all <span>IIMs</span></h1>
    <p class="text-light">Verified data on rankings, fees, placements and reviews — all IIMs in one place.</p>
    <div class="c-hero-btns">
      <button class="c-btn-send" onclick="openApplyModal()">
        <i class="bi bi-send-fill"></i> Apply Now
      </button>
      <a href="contact.php" class="c-btn-outline">
        <i class="bi bi-chat-dots"></i> Contact Us
      </a>
    </div>
    <!-- Search bar -->
    <div class="cl-search-wrap">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        class="cl-search-icon" width="20" height="20">
        <circle cx="11" cy="11" r="8" />
        <line x1="21" y1="21" x2="16.65" y2="16.65" />
      </svg>
      <input type="text" id="cl-search" value="<?= htmlspecialchars($q) ?>" placeholder="Search IIM by name or city"
        class="cl-search-input" autocomplete="off" />
    </div>
  </div>
</section>

<!-- ── Layout: sidebar + grid ── -->
<section class="cl-layout-section">
  <div class="cl-container">
    <div class="cl-layout">

      <!-- ── Sidebar (desktop only) ── -->
      <aside class="cl-sidebar" id="cl-sidebar">
        <div class="cl-filter-card">
          <div class="cl-filter-header">
            <span class="cl-filter-title">
              Filters
              <?php if ($activeCount > 0): ?>
                <span class="cl-filter-badge"><?= $activeCount ?></span>
              <?php endif; ?>
            </span>
          </div>
          <form method="GET" action="colleges.php" id="filter-form">
            <input type="hidden" name="q" id="fq" value="<?= htmlspecialchars($q) ?>">
            <input type="hidden" name="sort" id="fsort" value="<?= htmlspecialchars($sortBy) ?>">
            <input type="hidden" name="page" value="1">

            <!-- Course Type -->
            <div class="cl-fg">
              <div class="cl-fg-label">Course Type</div>
              <div class="cl-chips">
                <?php foreach ($CATS as $cat):
                  $active = in_array($cat, $selCats); ?>
                  <label class="cl-chip <?= $active ? 'cl-chip-active' : '' ?>">
                    <input type="checkbox" name="cats[]" value="<?= htmlspecialchars($cat) ?>" <?= $active ? 'checked' : '' ?> style="display:none"
                      onchange="this.closest('label').classList.toggle('cl-chip-active',this.checked);liveFilter();">
                    <?= htmlspecialchars($cat) ?>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Entrance Exam -->
            <div class="cl-fg">
              <div class="cl-fg-label">Entrance Exam</div>
              <div class="cl-chips">
                <?php foreach ($EXAMS as $ex):
                  $active = in_array($ex, $selExams); ?>
                  <label class="cl-chip <?= $active ? 'cl-chip-active' : '' ?>">
                    <input type="checkbox" name="exams[]" value="<?= htmlspecialchars($ex) ?>" <?= $active ? 'checked' : '' ?> style="display:none"
                      onchange="this.closest('label').classList.toggle('cl-chip-active',this.checked);liveFilter();">
                    <?= htmlspecialchars($ex) ?>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Budget / Fee Range -->
            <div class="cl-fg">
              <div class="cl-fg-label">
                Budget (Fees)
                <span style="font-weight:700;color:var(--accent,#f97316);">
                  ₹<span id="fee-min-lbl"><?= $feeMin ?></span>L – ₹<span id="fee-max-lbl"><?= $feeMax ?></span>L
                </span>
              </div>
              <div style="margin-bottom:.35rem;">
                <span style="font-size:.7rem;color:var(--muted-foreground,#64748b);">Min</span>
                <input type="range" name="fee_min" id="fee-min-range" min="0" max="30" value="<?= $feeMin ?>"
                  class="cl-range"
                  oninput="var mn=parseInt(this.value),mx=parseInt(document.getElementById('fee-max-range').value);if(mn>mx){this.value=mx;mn=mx;}document.getElementById('fee-min-lbl').textContent=mn;liveFilter();">
              </div>
              <div>
                <span style="font-size:.7rem;color:var(--muted-foreground,#64748b);">Max</span>
                <input type="range" name="fee_max" id="fee-max-range" min="0" max="30" value="<?= $feeMax ?>"
                  class="cl-range"
                  oninput="var mx=parseInt(this.value),mn=parseInt(document.getElementById('fee-min-range').value);if(mx<mn){this.value=mn;mx=mn;}document.getElementById('fee-max-lbl').textContent=mx;liveFilter();">
              </div>
              <div style="display:flex;flex-wrap:wrap;gap:.35rem;margin-top:.5rem;">
                <button type="button" class="cl-chip" style="font-size:.7rem;" onclick="setFeePreset(0,15)">Under
                  ₹15L</button>
                <button type="button" class="cl-chip" style="font-size:.7rem;"
                  onclick="setFeePreset(15,25)">₹15–25L</button>
                <button type="button" class="cl-chip" style="font-size:.7rem;"
                  onclick="setFeePreset(25,30)">₹25L+</button>
              </div>
            </div>

            <a href="colleges.php" class="btn btn-outline cl-reset-btn">Reset filters</a>
          </form>
        </div>
      </aside>

      <!-- ── Main grid ── -->
      <div class="cl-main">
        <div class="cl-main-header">
          <div class="cl-count" id="cl-count">
            <?= $totalFiltered ?> IIMs found
            <?php if ($totalPages > 1): ?>
              <span style="color:var(--muted-foreground,#94a3b8);font-size:.8rem;margin-left:.4rem;">(Page
                <?= $currentPage ?> of <?= $totalPages ?>)</span>
            <?php endif; ?>
          </div>

          <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;">
            <!-- Sort dropdown -->
            <div class="cl-sort-wrap">
              <label for="cl-sort" class="cl-sort-label">Sort by:</label>
              <select id="cl-sort" class="cl-sort-select" onchange="applySort(this.value)">
                <option value="ranking" <?= $sortBy === 'ranking' ? 'selected' : '' ?>>NIRF Ranking</option>
                <option value="fees_asc" <?= $sortBy === 'fees_asc' ? 'selected' : '' ?>>Fees: Low → High</option>
                <option value="fees_desc" <?= $sortBy === 'fees_desc' ? 'selected' : '' ?>>Fees: High → Low</option>
                <option value="placement" <?= $sortBy === 'placement' ? 'selected' : '' ?>>Best Placement</option>
                <option value="location" <?= $sortBy === 'location' ? 'selected' : '' ?>>Location (A–Z)</option>
              </select>
            </div>

            <!-- Mobile filter toggle -->
            <button class="cl-mobile-filter-btn" id="cl-filter-toggle-btn" onclick="toggleMobileFilter()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" width="15" height="15">
                <line x1="4" y1="6" x2="20" y2="6" />
                <line x1="8" y1="12" x2="16" y2="12" />
                <line x1="11" y1="18" x2="13" y2="18" />
              </svg>
              Filters<?php if ($activeCount > 0): ?><span
                  class="cl-mob-filter-badge"><?= $activeCount ?></span><?php endif; ?>
            </button>
          </div>
        </div>

        <!-- ── Mobile Filter Drawer ── -->
        <div class="cl-mobile-filter" id="cl-mobile-filter">
          <div class="cl-mobile-filter-inner">
            <div class="cl-mobile-filter-top">
              <span class="cl-filter-title">
                Filters
                <?php if ($activeCount > 0): ?><span class="cl-filter-badge"><?= $activeCount ?></span><?php endif; ?>
              </span>
              <button type="button" class="cl-mobile-filter-close" onclick="toggleMobileFilter()"
                aria-label="Close filters">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="2" width="20" height="20">
                  <line x1="18" y1="6" x2="6" y2="18" />
                  <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
              </button>
            </div>

            <form method="GET" action="colleges.php" id="mobile-filter-form">
              <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
              <input type="hidden" name="sort" value="<?= htmlspecialchars($sortBy) ?>">
              <input type="hidden" name="page" value="1">

              <div class="cl-fg">
                <div class="cl-fg-label">Course Type</div>
                <div class="cl-chips">
                  <?php foreach ($CATS as $cat):
                    $active = in_array($cat, $selCats); ?>
                    <label class="cl-chip <?= $active ? 'cl-chip-active' : '' ?>">
                      <input type="checkbox" name="cats[]" value="<?= htmlspecialchars($cat) ?>" <?= $active ? 'checked' : '' ?> style="display:none"
                        onchange="this.closest('label').classList.toggle('cl-chip-active',this.checked);">
                      <?= htmlspecialchars($cat) ?>
                    </label>
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="cl-fg">
                <div class="cl-fg-label">Entrance Exam</div>
                <div class="cl-chips">
                  <?php foreach ($EXAMS as $ex):
                    $active = in_array($ex, $selExams); ?>
                    <label class="cl-chip <?= $active ? 'cl-chip-active' : '' ?>">
                      <input type="checkbox" name="exams[]" value="<?= htmlspecialchars($ex) ?>" <?= $active ? 'checked' : '' ?> style="display:none"
                        onchange="this.closest('label').classList.toggle('cl-chip-active',this.checked);">
                      <?= htmlspecialchars($ex) ?>
                    </label>
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="cl-fg">
                <div class="cl-fg-label">
                  Budget (Fees)
                  <span style="font-weight:700;color:var(--accent,#f97316);">
                    ₹<span id="m-fee-min-lbl"><?= $feeMin ?></span>L – ₹<span id="m-fee-max-lbl"><?= $feeMax ?></span>L
                  </span>
                </div>
                <div style="margin-bottom:.35rem;">
                  <span style="font-size:.7rem;color:var(--muted-foreground,#64748b);">Min</span>
                  <input type="range" name="fee_min" id="m-fee-min-range" min="0" max="30" value="<?= $feeMin ?>"
                    class="cl-range"
                    oninput="var mn=parseInt(this.value),mx=parseInt(document.getElementById('m-fee-max-range').value);if(mn>mx){this.value=mx;mn=mx;}document.getElementById('m-fee-min-lbl').textContent=mn;">
                </div>
                <div>
                  <span style="font-size:.7rem;color:var(--muted-foreground,#64748b);">Max</span>
                  <input type="range" name="fee_max" id="m-fee-max-range" min="0" max="30" value="<?= $feeMax ?>"
                    class="cl-range"
                    oninput="var mx=parseInt(this.value),mn=parseInt(document.getElementById('m-fee-min-range').value);if(mx<mn){this.value=mn;mx=mn;}document.getElementById('m-fee-max-lbl').textContent=mx;">
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:.35rem;margin-top:.5rem;">
                  <button type="button" class="cl-chip" style="font-size:.7rem;"
                    onclick="setMobileFeePreset(0,15)">Under ₹15L</button>
                  <button type="button" class="cl-chip" style="font-size:.7rem;"
                    onclick="setMobileFeePreset(15,25)">₹15–25L</button>
                  <button type="button" class="cl-chip" style="font-size:.7rem;"
                    onclick="setMobileFeePreset(25,30)">₹25L+</button>
                </div>
              </div>

              <div class="cl-mobile-filter-actions">
                <a href="colleges.php" class="btn btn-outline" style="flex:1;text-align:center;">Reset</a>
                <button type="submit" class="btn btn-hero" style="flex:1;">Apply Filters</button>
              </div>
            </form>
          </div>
        </div>
        <!-- ── End Mobile Filter Drawer ── -->

        <!-- Cards grid -->
        <?php if (empty($pageItems)): ?>
          <div class="cl-empty">
            <p style="color:var(--muted-foreground)">No IIMs match these filters.</p>
            <a href="colleges.php" class="btn btn-outline" style="margin-top:1rem;display:inline-flex">Reset</a>
          </div>
        <?php else: ?>
          <div class="colleges-grid" id="cl-grid">
            <?php foreach ($pageItems as $index => $college): ?>
              <div class="cl-card-wrap reveal" style="transition-delay:<?= $index * 0.06 ?>s"
                data-name="<?= strtolower(htmlspecialchars($college['name'])) ?>"
                data-loc="<?= strtolower(htmlspecialchars($college['location'])) ?>"
                data-fees="<?= (int) $college['fees'] ?>" data-placement="<?= (int) $college['placement'] ?>"
                data-rating="<?= (float) $college['rating'] ?>"
                data-cats="<?= strtolower(htmlspecialchars(implode(',', $college['category']))) ?>"
                data-exams="<?= strtolower(htmlspecialchars(implode(',', $college['exams']))) ?>">
                <?php include '../components/CollegeCard.php'; ?>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- ── Pagination ── -->
          <?php if ($totalPages > 1): ?>
            <nav class="cl-pagination" aria-label="Colleges pagination">
              <?php
              if ($currentPage > 1):
                echo '<a href="' . htmlspecialchars(buildUrl(['page' => $currentPage - 1])) . '" class="cl-page-btn cl-page-prev" aria-label="Previous page">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="15 18 9 12 15 6"/></svg>';
                echo 'Prev</a>';
              else:
                echo '<span class="cl-page-btn cl-page-disabled"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="15 18 9 12 15 6"/></svg>Prev</span>';
              endif;
              $startP = max(1, $currentPage - 2);
              $endP = min($totalPages, $currentPage + 2);
              if ($startP > 1)
                echo '<span class="cl-page-ellipsis">…</span>';
              for ($p = $startP; $p <= $endP; $p++) {
                $isCur = ($p === $currentPage);
                echo '<a href="' . htmlspecialchars(buildUrl(['page' => $p])) . '" class="cl-page-btn cl-page-num' . ($isCur ? ' cl-page-active' : '') . '" aria-current="' . ($isCur ? 'page' : 'false') . '">' . $p . '</a>';
              }
              if ($endP < $totalPages)
                echo '<span class="cl-page-ellipsis">…</span>';
              if ($currentPage < $totalPages):
                echo '<a href="' . htmlspecialchars(buildUrl(['page' => $currentPage + 1])) . '" class="cl-page-btn cl-page-next" aria-label="Next page">';
                echo 'Next<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="9 18 15 12 9 6"/></svg></a>';
              else:
                echo '<span class="cl-page-btn cl-page-disabled">Next<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="9 18 15 12 9 6"/></svg></span>';
              endif;
              ?>
            </nav>
          <?php endif; ?>

        <?php endif; ?>
      </div><!-- /cl-main -->

    </div>
  </div>
</section>

<!-- ============================================================
     FINAL CTA
============================================================ -->
<section class="py-3 py-md-4">
  <div class="container">
    <div class="cta-pro position-relative overflow-hidden rounded-5 p-4 p-lg-5">
      <div class="cta-glow"></div>
      <div class="row align-items-center g-4 position-relative" style="z-index:2;">
        <div class="col-12 col-lg-7 text-center mx-auto">
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
        <div class="col-12 text-center">
          <button class="button-cta bg-transparent px-4 py-2" onclick="openApplyModal()">Apply</button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Colleges Grid ── -->
<style>
  /* ── College Detail Hero ── */
  .cd-hero {
    position: relative;
    height: 60vh;
    min-height: 320px;
    overflow: hidden;
  }

  .cd-hero-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  .cd-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, .75) 0%, rgba(0, 0, 0, .35) 60%, transparent 100%);
  }

  .cd-hero-content {
    position: relative;
    height: 100%;
    max-width: 88rem;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding-bottom: 2rem;
    color: #fff;
  }

  @media (min-width: 768px) {
    .cd-hero-content {
      padding: 0 3rem 2.5rem;
    }
  }

  @media (min-width: 1200px) {
    .cd-hero-content {
      padding: 0 4.5rem 3rem;
    }

    .cd-hero {
      min-height: 420px;
    }
  }

  .cd-rank-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(255, 255, 255, .15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, .2);
    border-radius: 9999px;
    padding: .3rem .85rem;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    width: fit-content;
  }

  .cd-rank-badge svg {
    color: #ea580c;
  }

  .cd-hero-title {
    font-size: clamp(1.4rem, 4vw, 3rem);
    font-weight: 600;
    margin-top: .75rem;
    line-height: 1.1;
  }

  .cd-hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: .75rem;
    margin-top: .15rem;
    color: rgba(255, 255, 255, .85);
    font-size: .85rem;
  }

  .cd-hero-meta span {
    display: flex;
    align-items: center;
    gap: .3rem;
  }

  .cd-hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
    margin-top: 1.25rem;
    align-items: center;
  }

  .cd-outline-btn {
    background: rgba(255, 255, 255, .12);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, .3);
    color: #fff;
    display: inline-flex;
    align-items: center;
    gap: .45rem;
  }

  .cd-outline-btn:hover {
    background: #fff;
    color: var(--navy, #0f2167);
  }

  .cd-icon-btn {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    background: rgba(255, 255, 255, .12);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, .3);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background .2s, color .2s, border-color .2s;
  }

  .cd-icon-btn:hover {
    background: #fff;
    color: var(--navy, #0f2167);
  }

  /* ── Sticky Tabs ── */
  .cd-tabs-bar {
    position: sticky;
    top: 4rem;
    z-index: 30;
    background: rgba(var(--background-rgb, 255, 255, 255), .95);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border, #e5e7eb);
  }

  .cd-tabs-inner {
    max-width: 88rem;
    margin: 0 auto;
    padding: 0 1rem;
    display: flex;
    gap: .1rem;
    overflow-x: auto;
    scrollbar-width: none;
  }

  .cd-tabs-inner::-webkit-scrollbar {
    display: none;
  }

  .cd-tab {
    padding: .85rem .75rem;
    font-size: .8rem;
    font-weight: 500;
    white-space: nowrap;
    border-bottom: 2px solid transparent;
    color: var(--muted-foreground, #64748b);
    text-decoration: none;
    transition: color .2s, border-color .2s;
    flex-shrink: 0;
  }

  @media (min-width: 768px) {
    .cd-tab {
      padding: 1rem;
      font-size: .875rem;
    }
  }

  .cd-tab:hover {
    color: var(--foreground, #0f172a);
  }

  .cd-tab.active {
    border-bottom-color: var(--accent, #f97316);
    color: var(--accent, #f97316);
  }

  /* ── Main layout ── */
  .cd-main {
    max-width: 88rem;
    margin: 0 auto;
    padding: 2rem 1rem;
    display: flex;
    flex-direction: column;
    gap: 3rem;
  }

  @media (min-width: 768px) {
    .cd-main {
      padding: 2.5rem 1.5rem;
      gap: 3.5rem;
    }
  }

  @media (min-width: 1200px) {
    .cd-main {
      padding: 3rem 1.5rem;
      gap: 4rem;
    }
  }

  .cd-section {
    scroll-margin-top: 8rem;
  }

  .cd-section-title {
    font-size: clamp(1.3rem, 3.5vw, 2.25rem);
    font-weight: 800;
    margin-bottom: 1.25rem;
  }

  .cd-lead {
    font-size: clamp(.9rem, 1.5vw, 1.05rem);
    color: var(--muted-foreground, #64748b);
    line-height: 1.8;
  }

  /* ── Stats grid ── */
  .cd-stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: .75rem;
    margin-top: 1.5rem;
  }

  @media (min-width: 576px) {
    .cd-stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 768px) {
    .cd-stats-grid {
      grid-template-columns: repeat(4, 1fr);
      gap: 1rem;
    }
  }

  .cd-stat-card {
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 1rem;
    padding: 1rem;
    background: var(--card, #fff);
  }

  @media (min-width: 768px) {
    .cd-stat-card {
      padding: 1.25rem;
    }
  }

  .cd-stat-label {
    font-size: .65rem;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--muted-foreground, #64748b);
    font-weight: 600;
  }

  .cd-stat-value {
    font-size: clamp(1.2rem, 2.5vw, 1.5rem);
    font-weight: 800;
    margin-top: .25rem;
  }

  /* ── Courses grid ── */
  .cd-courses-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: .75rem;
  }

  @media (min-width: 576px) {
    .cd-courses-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 992px) {
    .cd-courses-grid {
      grid-template-columns: repeat(3, 1fr);
      gap: 1rem;
    }
  }

  .cd-course-card {
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 1rem;
    padding: 1.1rem;
    background: var(--card, #fff);
  }

  @media (min-width: 768px) {
    .cd-course-card {
      padding: 1.25rem;
    }
  }

  .cd-course-name {
    font-weight: 700;
    font-size: clamp(.9rem, 1.5vw, 1.05rem);
    margin-bottom: .75rem;
  }

  .cd-course-meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .75rem;
    font-size: .875rem;
  }

  .cd-meta-label {
    font-size: .65rem;
    color: var(--muted-foreground, #64748b);
    margin-bottom: .1rem;
  }

  .cd-meta-val {
    font-weight: 600;
    font-size: .85rem;
  }

  /* ── Admissions ── */
  .cd-admit-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: .75rem;
  }

  @media (min-width: 576px) {
    .cd-admit-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 992px) {
    .cd-admit-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  .cd-admit-card {
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 1rem;
    padding: 1.1rem;
    background: var(--card, #fff);
  }

  @media (min-width: 768px) {
    .cd-admit-card {
      padding: 1.25rem;
    }
  }

  .cd-admit-step-title {
    font-weight: 700;
    margin-bottom: .5rem;
    font-size: .9rem;
  }

  .cd-admit-desc {
    font-size: .875rem;
    color: var(--muted-foreground, #64748b);
    margin: 0;
  }

  /* ── Charts ── */
  .cd-charts-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  @media (min-width: 768px) {
    .cd-charts-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }
  }

  .cd-chart-card {
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 1rem;
    padding: 1.1rem;
    background: var(--card, #fff);
  }

  @media (min-width: 768px) {
    .cd-chart-card {
      padding: 1.25rem;
    }
  }

  .cd-chart-title {
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: .875rem;
  }

  @media (min-width: 768px) {
    .cd-chart-title {
      font-size: .95rem;
    }
  }

  .cd-chart-wrap {
    height: 220px;
    position: relative;
  }

  @media (min-width: 768px) {
    .cd-chart-wrap {
      height: 260px;
    }
  }

  .cd-sub-title {
    font-weight: 700;
    margin-bottom: .75rem;
    font-size: .95rem;
  }

  .cd-recruiters {
    margin-top: 1.25rem;
  }

  .cd-recruiter-chips {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
  }

  .cd-chip {
    background: var(--secondary, #f1f5f9);
    border-radius: 9999px;
    padding: .3rem .75rem;
    font-size: .75rem;
    font-weight: 500;
  }

  /* ── Fees ── */
  .cd-fees-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
  }

  @media (min-width: 768px) {
    .cd-fees-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }
  }

  .cd-fees-card {
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 1rem;
    padding: 1.25rem;
    background: var(--card, #fff);
  }

  @media (min-width: 768px) {
    .cd-fees-card {
      padding: 1.5rem;
    }
  }

  .cd-fee-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: .6rem;
    font-size: .875rem;
  }

  .cd-fee-row {
    display: flex;
    justify-content: space-between;
  }

  .cd-fee-amt {
    font-weight: 600;
  }

  .cd-scholarship-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: .5rem;
    font-size: .875rem;
    color: var(--muted-foreground, #64748b);
  }

  /* ── Reviews ── */
  .cd-reviews-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: .75rem;
  }

  @media (min-width: 576px) {
    .cd-reviews-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 1200px) {
    .cd-reviews-grid {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  .cd-review-card {
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 1rem;
    padding: 1.1rem;
    background: var(--card, #fff);
  }

  @media (min-width: 768px) {
    .cd-review-card {
      padding: 1.25rem;
    }
  }

  .cd-review-stars {
    display: flex;
    align-items: center;
    gap: .2rem;
    margin-bottom: .6rem;
  }

  .cd-verified-badge {
    font-size: .65rem;
    font-weight: 700;
    padding: .15rem .5rem;
    border-radius: 9999px;
    background: rgba(16, 185, 129, .1);
    color: #10b981;
    margin-left: .5rem;
  }

  .cd-review-quote {
    font-size: .875rem;
    line-height: 1.7;
  }

  .cd-review-author {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-top: .85rem;
  }

  .cd-review-avatar {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    color: #fff;
  }

  .cd-review-avatar-img {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
  }

  .cd-review-name {
    font-weight: 600;
    font-size: .875rem;
  }

  .cd-review-role {
    font-size: .75rem;
    color: var(--muted-foreground, #64748b);
  }

  /* ── Final CTA ── */
  .cd-final-cta {
    border-radius: 1.25rem;
    padding: 2.5rem 1.25rem;
    text-align: center;
    background: var(--gradient-hero, linear-gradient(135deg, #0f2167, #1a3a8f));
    color: #fff;
  }

  @media (min-width: 768px) {
    .cd-final-cta {
      border-radius: 1.5rem;
      padding: 3.5rem 2rem;
    }
  }

  .cd-cta-title {
    font-size: clamp(1.3rem, 3.5vw, 2.25rem);
    font-weight: 800;
  }

  .cd-cta-sub {
    color: rgba(255, 255, 255, .75);
    margin-top: .5rem;
  }

  /* ── colleges-grid in recommended section ── */
  .colleges-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
  }

  @media (min-width: 576px) {
    .colleges-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 992px) {
    .colleges-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  /* ── colleges grid (list page) ── */
  .colleges-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
  }

  @media (min-width: 480px) {
    .colleges-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 992px) {
    .colleges-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 1200px) {
    .colleges-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  /* ── Design variables ── */
  /* ── Hero ── */
  .c-hero {
    background: linear-gradient(135deg, #1a2340 0%, #2d3d6b 100%);
    min-height: 28rem;
    display: flex;
    align-items: center;
    position: relative;
    padding: 5rem 0 3rem;
  }

  @media (min-width: 768px) {
    .c-hero {
      min-height: 30rem;
      padding: 6rem 0 3rem;
    }
  }

  .c-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
  }

  .c-hero h1 span {
    color: #f97316;
  }

  .c-hero p {
    font-size: clamp(.9rem, 2vw, 1rem);
    max-width: 500px;
  }

  /* ── Hero CTA buttons ── */
  .c-hero-btns {
    display: flex;
    flex-wrap: wrap;
    gap: .75rem;
    margin-top: 1.5rem;
  }

  .c-btn-send {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .75rem 1.5rem;
    border-radius: .6rem;
    font-size: clamp(.8rem, 2vw, .95rem);
    font-weight: 600;
    color: #fff;
    border: none;
    cursor: pointer;
    background: linear-gradient(135deg, #f97316, #ea580c);
    transition: transform .18s, box-shadow .18s;
    white-space: nowrap;
  }

  .c-btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(249, 115, 22, .45);
  }

  .c-btn-outline {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .75rem 1.5rem;
    border-radius: .6rem;
    font-size: clamp(.8rem, 2vw, .95rem);
    font-weight: 600;
    color: #fff;
    border: 1.5px solid rgba(255, 255, 255, .5);
    background: rgba(255, 255, 255, .08);
    backdrop-filter: blur(8px);
    text-decoration: none;
    transition: background .18s, border-color .18s;
    white-space: nowrap;
  }

  .c-btn-outline:hover {
    background: rgba(255, 255, 255, .18);
    border-color: #fff;
    color: #fff;
  }

  @media(max-width:400px) {

    .c-btn-send,
    .c-btn-outline {
      padding: .65rem 1rem;
      flex: 1;
      justify-content: center;
    }
  }

  /* ── Search ── */
  .cl-search-wrap {
    position: relative;
    max-width: 32rem;
    margin-top: 1.75rem;
    z-index: 50;
    width: 100%;
  }

  .cl-search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    pointer-events: none;
    z-index: 2;
  }

  .cl-search-input {
    width: 100%;
    padding: .8rem 1rem .8rem 3rem;
    border-radius: .75rem;
    border: none;
    background: #fff;
    color: #0f172a;
    font-size: clamp(.875rem, 2vw, 1rem);
    outline: none;
    box-shadow: 0 4px 24px rgba(0, 0, 0, .18);
    box-sizing: border-box;
  }

  .cl-search-input:focus {
    box-shadow: 0 0 0 3px rgba(249, 115, 22, .35);
  }

  /* ── Layout ── */
  .cl-layout-section {
    padding: 2rem 0 4rem;
  }

  @media (min-width: 768px) {
    .cl-layout-section {
      padding: 3rem 0 5rem;
    }
  }

  .cl-container {
    max-width: 88rem;
    margin: 0 auto;
    padding: 0 1rem;
  }

  @media (min-width: 576px) {
    .cl-container {
      padding: 0 1.25rem;
    }
  }

  @media (min-width: 992px) {
    .cl-container {
      padding: 0 1.5rem;
    }
  }

  .cl-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }

  @media(min-width:1024px) {
    .cl-layout {
      grid-template-columns: 260px 1fr;
      gap: 2rem;
    }
  }

  @media(min-width:1280px) {
    .cl-layout {
      grid-template-columns: 280px 1fr;
    }
  }

  /* ── Desktop Sidebar ── */
  .cl-sidebar {
    display: none;
  }

  @media(min-width:1024px) {
    .cl-sidebar {
      display: block;
    }
  }

  .cl-filter-card {
    position: sticky;
    top: 6rem;
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 1rem;
    background: var(--card, #fff);
    padding: 1.1rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
  }

  @media (min-width: 1200px) {
    .cl-filter-card {
      padding: 1.25rem;
    }
  }

  .cl-filter-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
  }

  .cl-filter-title {
    font-weight: 700;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: .4rem;
  }

  .cl-filter-badge {
    font-size: .65rem;
    font-weight: 700;
    padding: .15rem .5rem;
    border-radius: 9999px;
    background: var(--accent, #f97316);
    color: #fff;
  }

  .cl-fg {
    margin-bottom: 1.1rem;
  }

  .cl-fg-label {
    font-size: .7rem;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--muted-foreground, #64748b);
    font-weight: 600;
    margin-bottom: .5rem;
    display: flex;
    flex-direction: column;
    gap: .2rem;
  }

  .cl-chips {
    display: flex;
    flex-wrap: wrap;
    gap: .35rem;
  }

  .cl-chip {
    font-size: .72rem;
    padding: .3rem .7rem;
    border-radius: 9999px;
    border: 1px solid var(--border, #e5e7eb);
    cursor: pointer;
    transition: background .15s, color .15s, border-color .15s;
    user-select: none;
    background: transparent;
  }

  .cl-chip:hover {
    border-color: rgba(249, 115, 22, .4);
  }

  .cl-chip-active {
    background: var(--accent, #f97316);
    color: #fff;
    border-color: transparent;
  }

  .cl-range {
    width: 100%;
    accent-color: var(--accent, #f97316);
  }

  .cl-reset-btn {
    width: 100%;
    text-align: center;
    display: block;
    margin-top: .5rem;
  }

  /* ── Sort dropdown ── */
  .cl-sort-wrap {
    display: flex;
    align-items: center;
    gap: .4rem;
  }

  .cl-sort-label {
    font-size: .75rem;
    color: var(--muted-foreground, #64748b);
    white-space: nowrap;
  }

  .cl-sort-select {
    font-size: .8rem;
    padding: .4rem .65rem;
    border: 1px solid var(--border, #e5e7eb);
    border-radius: .5rem;
    background: var(--card, #fff);
    color: var(--foreground, #0f172a);
    cursor: pointer;
    outline: none;
    max-width: 160px;
  }

  .cl-sort-select:focus {
    border-color: var(--accent, #f97316);
  }

  /* ── Main header ── */
  .cl-main-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
    gap: .75rem;
  }

  .cl-count {
    font-size: .875rem;
    color: var(--muted-foreground, #64748b);
  }

  @media(max-width:480px) {
    .cl-main-header {
      flex-direction: column;
      align-items: flex-start;
    }

    .cl-sort-wrap {
      width: 100%;
    }

    .cl-sort-select {
      flex: 1;
      max-width: 100%;
      width: 100%;
    }
  }

  /* ── Mobile filter button ── */
  .cl-mobile-filter-btn {
    display: none;
    align-items: center;
    gap: .5rem;
    padding: .5rem 1rem;
    border-radius: 9999px;
    font-size: .82rem;
    font-weight: 700;
    color: #fff;
    border: none;
    cursor: pointer;
    background: linear-gradient(135deg, #1a2340 0%, #f97316 160%);
    box-shadow: 0 3px 12px rgba(249, 115, 22, .30);
    transition: transform .18s, box-shadow .18s;
    position: relative;
    letter-spacing: .01em;
  }

  .cl-mobile-filter-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(249, 115, 22, .40);
  }

  .cl-mobile-filter-btn:active {
    transform: scale(.97);
  }

  .cl-mob-filter-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 1.1rem;
    height: 1.1rem;
    border-radius: 9999px;
    background: #fff;
    color: #f97316;
    font-size: .65rem;
    font-weight: 800;
    padding: 0 .25rem;
    margin-left: .1rem;
  }

  @media(max-width:1023px) {
    .cl-mobile-filter-btn {
      display: inline-flex;
    }
  }

  @media(min-width:1024px) {
    .cl-mobile-filter-btn {
      display: none !important;
    }
  }

  /* ── Mobile Filter Drawer ── */
  .cl-mobile-filter {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 1050;
  }

  .cl-mobile-filter.is-open {
    display: block;
  }

  .cl-mobile-filter::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, .5);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
  }

  .cl-mobile-filter-inner {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    width: min(88vw, 340px);
    background: var(--card, #fff);
    padding: 1.1rem 1.1rem 1.5rem;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    box-shadow: 6px 0 40px rgba(0, 0, 0, .22);
    display: flex;
    flex-direction: column;
    animation: cl-slideIn .24s cubic-bezier(.25, .8, .25, 1) both;
  }

  @keyframes cl-slideIn {
    from {
      transform: translateX(-100%);
    }

    to {
      transform: translateX(0);
    }
  }

  .cl-mobile-filter-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.1rem;
    padding-bottom: .9rem;
    border-bottom: 1px solid var(--border, #e5e7eb);
    flex-shrink: 0;
  }

  .cl-mobile-filter-close {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: var(--secondary, #f1f5f9);
    border: none;
    cursor: pointer;
    color: var(--foreground, #0f172a);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background .15s;
  }

  .cl-mobile-filter-close:hover {
    background: #e2e8f0;
  }

  .cl-mobile-filter-actions {
    display: flex;
    gap: .75rem;
    margin-top: auto;
    padding-top: 1.1rem;
    border-top: 1px solid var(--border, #e5e7eb);
    flex-shrink: 0;
  }

  .cl-mobile-filter-actions .btn {
    flex: 1;
    text-align: center;
    justify-content: center;
  }

  /* ── Misc ── */
  .cl-empty {
    text-align: center;
    padding: 4rem 1rem;
    border: 2px dashed var(--border, #e5e7eb);
    border-radius: 1rem;
  }

  .cl-card-wrap {
    display: block;
    transition: opacity .3s, transform .3s;
  }

  .cl-card-wrap.cl-hidden {
    display: none;
  }

  /* ── Pagination ── */
  .cl-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: .35rem;
    margin-top: 2rem;
    padding-top: 1.75rem;
    border-top: 1px solid var(--border, #e5e7eb);
  }

  @media (min-width: 768px) {
    .cl-pagination {
      gap: .4rem;
      margin-top: 2.5rem;
    }
  }

  .cl-page-btn {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .45rem .75rem;
    border-radius: .6rem;
    font-size: .8rem;
    font-weight: 500;
    border: 1px solid var(--border, #e5e7eb);
    background: var(--card, #fff);
    color: var(--foreground, #0f172a);
    text-decoration: none;
    transition: background .15s, border-color .15s, color .15s;
    cursor: pointer;
  }

  @media (min-width: 576px) {
    .cl-page-btn {
      padding: .5rem .9rem;
      font-size: .875rem;
    }
  }

  .cl-page-btn:hover:not(.cl-page-disabled):not(.cl-page-active) {
    background: var(--secondary, #f1f5f9);
    border-color: rgba(249, 115, 22, .35);
  }

  .cl-page-active {
    background: var(--accent, #f97316);
    border-color: var(--accent, #f97316);
    color: #fff;
    pointer-events: none;
  }

  .cl-page-disabled {
    opacity: .38;
    cursor: not-allowed;
    pointer-events: none;
    border: 1px solid var(--border, #e5e7eb);
    background: var(--card, #fff);
    color: var(--muted-foreground, #64748b);
  }

  .cl-page-ellipsis {
    padding: .5rem .2rem;
    font-size: .875rem;
    color: var(--muted-foreground, #64748b);
  }

  .cl-page-num {
    min-width: 2.2rem;
    justify-content: center;
  }

  @media (min-width: 576px) {
    .cl-page-num {
      min-width: 2.4rem;
    }
  }
</style>

<script>
  /* Sort dropdown */
  window.applySort = function (value) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', value);
    url.searchParams.set('page', '1');
    window.location.href = url.toString();
  };
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {

    /* Mobile Filter Drawer */
    const drawer = document.getElementById('cl-mobile-filter');
    window.toggleMobileFilter = function () {
      if (!drawer) return;
      drawer.classList.toggle('is-open');
      document.body.style.overflow = drawer.classList.contains('is-open') ? 'hidden' : '';
    };
    if (drawer) {
      drawer.addEventListener('click', function (e) { if (e.target === drawer) toggleMobileFilter(); });
    }

    /* Search Filter */
    const searchInput = document.getElementById('cl-search');
    function getCheckedValues(name) {
      let values = [];
      document.querySelectorAll('input[name="' + name + '"]:checked').forEach(el => { values.push(el.value.toLowerCase()); });
      return values;
    }
    window.liveFilter = function () {
      const cards = document.querySelectorAll('.cl-card-wrap');
      const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
      const cats = getCheckedValues('cats[]');
      const exams = getCheckedValues('exams[]');
      const feeMin = Number(document.getElementById('fee-min-range')?.value || 0);
      const feeMax = Number(document.getElementById('fee-max-range')?.value || 30);
      let visible = 0;
      cards.forEach(card => {
        let show = true;
        const name = (card.dataset.name || '').toLowerCase();
        const loc = (card.dataset.loc || '').toLowerCase();
        const fees = Number(card.dataset.fees || 0);
        const cardCats = (card.dataset.cats || '').split(',');
        const cardExams = (card.dataset.exams || '').split(',');
        if (query && !name.includes(query) && !loc.includes(query)) show = false;
        if (cats.length && !cats.some(c => cardCats.includes(c))) show = false;
        if (exams.length && !exams.some(e => cardExams.includes(e))) show = false;
        if (fees < feeMin || fees > feeMax) show = false;
        card.style.display = show ? 'block' : 'none';
        if (show) visible++;
      });
      const count = document.getElementById('cl-count');
      if (count) count.innerHTML = visible + ' IIMs found';
    };
    if (searchInput) searchInput.addEventListener('input', liveFilter);
    document.querySelectorAll('#filter-form input[name="cats[]"], #filter-form input[name="exams[]"]').forEach(input => { input.addEventListener('change', liveFilter); });
    document.querySelectorAll('#filter-form .cl-range').forEach(range => { range.addEventListener('input', liveFilter); });

    /* Mobile Filter Auto Apply */
    const mobileForm = document.getElementById('mobile-filter-form');
    function autoSubmitMobileFilter() {
      if (!mobileForm) return;
      setTimeout(() => { toggleMobileFilter(); setTimeout(() => { mobileForm.submit(); }, 200); }, 100);
    }
    document.querySelectorAll('#mobile-filter-form input[name="cats[]"], #mobile-filter-form input[name="exams[]"]').forEach(input => {
      input.addEventListener('change', function () {
        const label = this.closest('label');
        if (label) label.classList.toggle('cl-chip-active', this.checked);
        autoSubmitMobileFilter();
      });
    });
    document.querySelectorAll('#mobile-filter-form .cl-range').forEach(range => { range.addEventListener('change', autoSubmitMobileFilter); });

    /* Desktop fee preset */
    window.setFeePreset = function (min, max) {
      const minR = document.getElementById('fee-min-range');
      const maxR = document.getElementById('fee-max-range');
      if (minR) { minR.value = min; document.getElementById('fee-min-lbl').textContent = min; }
      if (maxR) { maxR.value = max; document.getElementById('fee-max-lbl').textContent = max; }
      liveFilter();
    };
    /* Mobile fee preset */
    window.setMobileFeePreset = function (min, max) {
      const minR = document.getElementById('m-fee-min-range');
      const maxR = document.getElementById('m-fee-max-range');
      if (minR) { minR.value = min; document.getElementById('m-fee-min-lbl').textContent = min; }
      if (maxR) { maxR.value = max; document.getElementById('m-fee-max-lbl').textContent = max; }
      autoSubmitMobileFilter();
    };
  });
</script>

<?php
include '../components/Modals.php';
include '../components/Footer.php';
include '../includes/footer.php';
?>