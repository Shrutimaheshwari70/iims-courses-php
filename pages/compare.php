<?php
/**
 * compare.php
 * Compare up to 3 IIMs side-by-side.
 */
session_start();
require_once __DIR__ . '/../data/iims.php';

$page_title = 'Compare IIMs Side-by-Side';
$page_description = 'Compare IIMs on fees, placements, faculty, ranking and more.';
$current_page = 'compare';

/* ── session management ── */
$compareList = $_SESSION['compare'] ?? [];

if (isset($_GET['add'])) {
  $slug = trim($_GET['add']);
  if (!in_array($slug, $compareList) && count($compareList) < 3)
    $compareList[] = $slug;
  $_SESSION['compare'] = $compareList;
  header('Location: compare.php');
  exit;
}
if (isset($_GET['remove'])) {
  $compareList = array_filter($compareList, fn($s) => $s !== $_GET['remove']);
  $_SESSION['compare'] = array_values($compareList);
  header('Location: compare.php');
  exit;
}
if (isset($_GET['clear'])) {
  $_SESSION['compare'] = [];
  header('Location: compare.php');
  exit;
}

$colleges = array_values(array_filter(array_map(fn($s) => getCollege($s), $compareList)));
$count = count($colleges);

$rows = [
  'Location' => fn($c) => htmlspecialchars($c['location']),
  'Established' => fn($c) => htmlspecialchars($c['established']),
  'NIRF Ranking' => fn($c) => '#' . htmlspecialchars($c['ranking']),
  'Rating' => fn($c) => htmlspecialchars($c['rating']) . ' / 5',
  'Total Fees' => fn($c) => '₹' . htmlspecialchars($c['fees']) . 'L',
  'Avg Placement' => fn($c) => '₹' . htmlspecialchars($c['placement']) . 'L',
  'Highest Package' => fn($c) => '₹' . htmlspecialchars($c['highest']) . 'L',
  'Faculty' => fn($c) => htmlspecialchars($c['faculty']) . '+',
  'Intake' => fn($c) => htmlspecialchars($c['intake']),
  'Exams Accepted' => fn($c) => htmlspecialchars(implode(', ', $c['exams'])),
];

include '../includes/header.php';
include '../components/Navbar.php';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
  /* ──────────────────────────────────────────
    DESIGN TOKENS
    ────────────────────────────────────────── */
  :root {
    --cn: #1a2340;
    --cn2: #2d3d6b;
    --co: #f97316;
    --co-lt: rgba(249, 115, 22, .10);
    --cbg: #f4f6fb;
    --ccard: #ffffff;
    --cborder: #e8eaf0;
    --cmuted: #6b7280;
    --cfg: #0f172a;
    --cr: 1.1rem;
    --cs: 0 1px 4px rgba(15, 23, 42, .06), 0 4px 16px rgba(15, 23, 42, .06);
    --cs2: 0 2px 8px rgba(15, 23, 42, .08), 0 16px 48px rgba(15, 23, 42, .12);
  }

  /* ──────────────────────────────────────────
    HERO — completely unchanged, scoped to .bs
    ────────────────────────────────────────── */
  .bs {
    font-family: var(--font-sans, sans-serif);
  }

  .bs .c-hero {
    background: linear-gradient(135deg, #1a2340 0%, #2d3d6b 100%);
    min-height: 30rem;
    display: flex;
    align-items: center;
    position: relative;
  }

  .bs .c-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
  }

  .bs .c-hero h1 span {
    color: #f97316;
  }

  .bs .c-hero p {
    font-size: 1rem;
    max-width: 500px;
  }

  .bs .c-badge {
    background: rgba(249, 115, 22, .18);
    color: #fdba74;
    font-size: .75rem;
    letter-spacing: .1em;
  }

  .bs .c-btn-send {
    background-image: linear-gradient(135deg, #1a2340, #2d3d6b);
    cursor: pointer;
    transition: transform .18s, box-shadow .18s;
  }

  .bs .c-btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(26, 35, 64, .25);
  }

  .bs .c-btn-outline {
    transition: border-color .18s;
  }

  .bs .c-btn-outline:hover {
    border-color: #fff;
  }

  /* ──────────────────────────────────────────
    SECTION WRAPPER
    ────────────────────────────────────────── */
  .cmp-wrap {
    background: var(--cbg);
    padding: 4.5rem 0 5rem;
  }

  .cmp-box {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 1.5rem;
  }

  /* ──────────────────────────────────────────
    PAGE HEADER
    ────────────────────────────────────────── */
  .cmp-hdr {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2.75rem;
  }

  .cmp-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--co);
    margin-bottom: .45rem;
  }

  .cmp-title {
    font-weight: 800;
    font-size: clamp(1.9rem, 4vw, 2.8rem);
    line-height: 1.1;
    color: var(--cn);
    margin: 0;
    letter-spacing: -.02em;
  }

  .cmp-sub {
    color: var(--cmuted);
    margin-top: .4rem;
    font-size: .9rem;
  }

  .cmp-clear {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    font-size: .8rem;
    font-weight: 600;
    color: var(--cmuted);
    background: var(--ccard);
    border: 1px solid var(--cborder);
    border-radius: 2rem;
    padding: .45rem 1rem;
    text-decoration: none;
    transition: all .18s;
    cursor: pointer;
    white-space: nowrap;
  }

  .cmp-clear:hover {
    color: #dc2626;
    border-color: #fca5a5;
    background: #fef2f2;
  }

  /* ──────────────────────────────────────────
    CARDS GRID
    ────────────────────────────────────────── */
  /* ── CARDS GRID ── */
  .cmp-grid {
    display: flex;
    flex-wrap: wrap;
    /* justify-content: center; */
    gap: 1.25rem;
    margin-bottom: 2rem;
  }

  .cmp-grid .cmp-card {
    flex: 0 0 340px;
    /* fixed natural width per card */
    max-width: 340px;
    width: 100%;
  }

  /* 3 cards — allow slight shrink to fit on smaller screens */
  .cmp-grid.g3 .cmp-card {
    flex: 0 0 300px;
    max-width: 300px;
  }

  /* 1 card — single centered */
  .cmp-grid.g1 .cmp-card {
    flex: 0 0 380px;
    max-width: 380px;
  }

  /* Responsive */
  @media (max-width: 900px) {
    .cmp-grid.g3 .cmp-card {
      flex: 0 0 260px;
      max-width: 260px;
    }
  }

  @media (max-width: 640px) {

    .cmp-grid .cmp-card,
    .cmp-grid.g3 .cmp-card,
    .cmp-grid.g1 .cmp-card {
      flex: 0 0 100%;
      max-width: 100%;
    }
  }

  /* ──────────────────────────────────────────
    COLLEGE CARD
    ────────────────────────────────────────── */
  .cmp-card {
    background: var(--ccard);
    border: 1px solid var(--cborder);
    border-radius: var(--cr);
    overflow: hidden;
    box-shadow: var(--cs);
    display: flex;
    flex-direction: column;
    transition: box-shadow .25s, transform .25s;
  }

  .cmp-card:hover {
    box-shadow: var(--cs2);
    transform: translateY(-4px);
  }

  .cmp-img {
    position: relative;
    height: 10rem;
    overflow: hidden;
    flex-shrink: 0;
  }

  .cmp-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .5s ease;
  }

  .cmp-card:hover .cmp-img img {
    transform: scale(1.06);
  }

  .cmp-img-shade {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 35%, rgba(15, 23, 42, .62) 100%);
  }

  .cmp-img-rank {
    position: absolute;
    top: .7rem;
    left: .7rem;
    background: rgba(249, 115, 22, .92);
    color: #fff;
    font-size: .68rem;
    font-weight: 600;
    padding: .22rem .65rem;
    border-radius: 2rem;
    letter-spacing: .04em;
  }

  .cmp-body {
    padding: 1.1rem 1.15rem 1.2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .cmp-name {
    font-weight: 600;
    font-size: 1rem;
    color: var(--cfg);
    line-height: 1.35;
    margin-bottom: .2rem;
  }

  .cmp-loc {
    display: flex;
    align-items: center;
    gap: .3rem;
    font-size: .73rem;
    color: var(--cmuted);
    margin-bottom: .9rem;
  }

  .cmp-loc i {
    color: var(--co);
    font-size: .82rem;
  }

  .cmp-pills {
    display: flex;
    gap: .45rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
  }

  .cmp-pill {
    display: inline-flex;
    align-items: center;
    gap: .25rem;
    background: var(--cbg);
    border: 1px solid var(--cborder);
    border-radius: 2rem;
    padding: .22rem .7rem;
    font-size: .71rem;
    font-weight: 600;
    color: var(--cn2);
    white-space: nowrap;
  }

  .cmp-pill i {
    font-size: .8rem;
    color: var(--co);
  }

  .cmp-actions {
    display: flex;
    gap: .6rem;
    margin-top: auto;
  }

  .btn-details {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .35rem;
    padding: .58rem 1rem;
    font-size: .82rem;
    font-weight: 600;
    border-radius: .65rem;
    background: linear-gradient(135deg, var(--cn), var(--cn2));
    color: #fff;
    border: none;
    text-decoration: none;
    cursor: pointer;
    letter-spacing: .01em;
    transition: opacity .18s, transform .18s;
  }

  .btn-details:hover {
    opacity: .85;
    transform: translateY(-1px);
    color: #fff;
  }

  .btn-rm {
    width: 2.15rem;
    height: 2.15rem;
    flex-shrink: 0;
    border-radius: .65rem;
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
    font-size: .95rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: background .18s;
  }

  .btn-rm:hover {
    background: #fee2e2;
    color: #b91c1c;
  }

  /* ──────────────────────────────────────────
    COMPARISON TABLE
    ────────────────────────────────────────── */
  .cmp-tbl-wrap {
    background: var(--ccard);
    border: 1px solid var(--cborder);
    border-radius: var(--cr);
    box-shadow: var(--cs);
    overflow: hidden;
    overflow-x: auto;
  }

  .cmp-tbl {
    width: 100%;
    border-collapse: collapse;
    font-size: .875rem;
    min-width: 520px;
  }

  .cmp-tbl thead tr {
    background: linear-gradient(135deg, var(--cn) 0%, var(--cn2) 100%);
  }

  .cmp-tbl thead th {
    padding: 1.05rem 1.2rem;
    color: #fff;
    font-weight: 600;
    text-align: left;
    border: none;
    vertical-align: middle;
  }

  .cmp-tbl thead th:first-child {
    min-width: 12rem;
    font-size: .7rem;
    letter-spacing: .1em;
    text-transform: uppercase;
    opacity: .7;
    font-weight: 600;
  }

  .th-name {
    font-size: .88rem;
    font-weight: 600;
    color: #fff;
    display: block;
    line-height: 1.3;
  }

  .th-loc {
    font-size: .7rem;
    font-weight: 400;
    color: rgba(255, 255, 255, .6);
    display: block;
    margin-top: .1rem;
  }

  .cmp-tbl tbody tr:nth-child(even) {
    background: rgba(244, 246, 251, .65);
  }

  .cmp-tbl tbody tr:hover td {
    background: rgba(45, 61, 107, .05);
  }

  .cmp-tbl td {
    padding: 1rem 1.2rem;
    border-bottom: 1px solid var(--cborder);
    vertical-align: middle;
    color: var(--cfg);
  }

  .cmp-tbl tbody tr:last-child td {
    border-bottom: none;
  }

  .cmp-lbl {
    font-weight: 600;
    font-size: .8rem;
    color: var(--cn);
    min-width: 12rem;
    white-space: nowrap;
  }

  .cmp-lbl i {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 1.55rem;
    color: var(--co);
    font-size: .88rem;
    margin-right: .15rem;
  }

  .cmp-val {
    font-size: .88rem;
    font-weight: 500;
    color: var(--cfg);
  }

  /* ──────────────────────────────────────────
    ADD MORE STRIP
    ────────────────────────────────────────── */
  .cmp-more {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 1.75rem;
  }

  .btn-add {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .65rem 1.65rem;
    font-size: .85rem;
    font-weight: 600;
    border-radius: 2rem;
    border: 2px dashed rgba(45, 61, 107, .35);
    color: var(--cn2);
    background: transparent;
    text-decoration: none;
    transition: all .2s;
    letter-spacing: .01em;
  }

  .btn-add:hover {
    border-style: solid;
    border-color: var(--cn2);
    background: rgba(45, 61, 107, .06);
    color: var(--cn2);
    transform: translateY(-1px);
  }

  /* ──────────────────────────────────────────
    EMPTY STATE
    ────────────────────────────────────────── */
  .cmp-empty {
    background: var(--cbg);
    padding: 5.5rem 0 5rem;
  }

  .cmp-empty-inner {
    max-width: 760px;
    margin: 0 auto;
    padding: 0 1.5rem;
    text-align: center;
  }

  .cmp-empty-icon {
    width: 5.5rem;
    height: 5.5rem;
    margin: 0 auto 1.75rem;
    background: linear-gradient(135deg, var(--cn), var(--cn2));
    border-radius: 1.4rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 2.2rem;
    box-shadow: 0 8px 24px rgba(26, 35, 64, .2);
  }

  .cmp-empty-title {
    font-weight: 800;
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    color: var(--cn);
    margin-bottom: .6rem;
    letter-spacing: -.02em;
  }

  .cmp-empty-desc {
    color: var(--cmuted);
    font-size: 1rem;
    margin-bottom: 2rem;
    max-width: 440px;
    margin-left: auto;
    margin-right: auto;
  }

  .btn-browse {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .75rem 2rem;
    font-size: .95rem;
    font-weight: 600;
    border-radius: 2rem;
    background: linear-gradient(135deg, var(--cn), var(--cn2));
    color: #fff;
    border: none;
    text-decoration: none;
    cursor: pointer;
    transition: opacity .18s, transform .18s;
    letter-spacing: .01em;
  }

  .btn-browse:hover {
    opacity: .86;
    transform: translateY(-2px);
    color: #fff;
  }

  .cmp-steps {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(13rem, 1fr));
    gap: 1rem;
    margin-top: 3rem;
  }

  .cmp-step {
    background: var(--ccard);
    border: 1px solid var(--cborder);
    border-radius: 1rem;
    padding: 1.35rem 1.1rem;
    box-shadow: var(--cs);
    text-align: left;
  }

  .cmp-step-n {
    width: 2.1rem;
    height: 2.1rem;
    background: linear-gradient(135deg, var(--cn), var(--cn2));
    color: #fff;
    font-weight: 800;
    font-size: .85rem;
    border-radius: .55rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: .75rem;
  }

  .cmp-step-t {
    font-weight: 600;
    font-size: .9rem;
    color: var(--cfg);
    margin-bottom: .3rem;
  }

  .cmp-step-d {
    font-size: .78rem;
    color: var(--cmuted);
    line-height: 1.5;
  }

  /* ──────────────────────────────────────────
    RESPONSIVE
    ────────────────────────────────────────── */
  @media (max-width: 900px) {
    .cmp-grid.g3 {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 640px) {

    .cmp-grid.g3,
    .cmp-grid.g2 {
      grid-template-columns: minmax(0, 1fr);
    }

    .cmp-hdr {
      flex-direction: column;
      align-items: flex-start;
    }

    .cmp-lbl {
      min-width: 7.5rem;
    }

    .cmp-tbl td {
      padding: .75rem .9rem;
      font-size: .8rem;
    }

    .cmp-tbl thead th {
      padding: .85rem .9rem;
      font-size: .75rem;
    }

    .cmp-wrap {
      padding: 4rem 0 3.5rem;
    }
  }
</style>

<?php if (empty($colleges)): ?>

  <!-- ════════════════ HERO (unchanged) ════════════════ -->
  <div class="bs">
    <section class="c-hero">
      <div class="container position-relative" style="z-index:1;">
        <div class="c-badge d-inline-flex px-3 py-1 rounded align-items-center mb-2 text-uppercase gap-2">
          <i class="bi bi-mortarboard-fill"></i> Compare Top IIM Programs
        </div>
        <h1 class="text-white fw-semibold">
          Compare <span>IIM Colleges</span>
        </h1>
        <p class="text-light">
          Explore fees, placements, rankings, eligibility, and specializations across top IIMs
          to choose the right MBA program for your career goals.
        </p>
        <div class="d-flex gap-3 mt-4 flex-wrap">
          <button class="c-btn-send px-4 rounded text-white w-auto py-3 border-0" onclick="openApplyModal()">
            <i class="bi bi-bar-chart-fill"></i> Compare Now
          </button>
          <a href="colleges.php" class="c-btn-outline px-4 rounded text-white w-auto py-3 border">
            <i class="bi bi-building"></i> View Colleges
          </a>
        </div>
      </div>
    </section>
  </div>

  <!-- EMPTY STATE -->
  <section class="cmp-empty">
    <div class="cmp-empty-inner">
      <div class="cmp-empty-icon"><i class="bi bi-bar-chart-steps"></i></div>
      <h1 class="cmp-empty-title">Compare IIMs Side-by-Side</h1>
      <p class="cmp-empty-desc">Add up to 3 IIMs and instantly compare fees, placements, rankings, and more — all in one
        clean view.</p>
      <a href="colleges.php" class="btn-browse">
        <i class="bi bi-building"></i> Browse All IIMs
        <i class="bi bi-arrow-right"></i>
      </a>
      <div class="cmp-steps">
        <div class="cmp-step">
          <div class="cmp-step-n">1</div>
          <div class="cmp-step-t">Browse Colleges</div>
          <div class="cmp-step-d">Visit the listing page and explore all IIM programs available.</div>
        </div>
        <div class="cmp-step">
          <div class="cmp-step-n">2</div>
          <div class="cmp-step-t">Add to Compare</div>
          <div class="cmp-step-d">Click "Compare" on any college card — select up to 3 IIMs at once.</div>
        </div>
        <div class="cmp-step">
          <div class="cmp-step-n">3</div>
          <div class="cmp-step-t">See the Difference</div>
          <div class="cmp-step-d">Get a clear breakdown to make the most informed decision.</div>
        </div>
      </div>
    </div>
  </section>

<?php else: ?>

  <!-- ════════════════ HERO (unchanged) ════════════════ -->
  <div class="bs">
    <section class="c-hero">
      <div class="container position-relative" style="z-index:1;">
        <div class="c-badge d-inline-flex px-3 py-1 rounded align-items-center mb-2 text-uppercase gap-2">
          <i class="bi bi-mortarboard-fill"></i> Compare Top IIM Programs
        </div>
        <h1 class="text-white fw-bold">
          Compare <span>IIM Colleges</span>
        </h1>
        <p class="text-light">
          Explore fees, placements, rankings, eligibility, and specializations across top IIMs
          to choose the right MBA program for your career goals.
        </p>
        <div class="d-flex gap-3 mt-4 flex-wrap">
          <button class="c-btn-send px-4 rounded text-white w-auto py-3 border-0" onclick="openApplyModal()">
            <i class="bi bi-bar-chart-fill"></i> Compare Now
          </button>
          <a href="colleges.php" class="c-btn-outline px-4 rounded text-white w-auto py-3 border">
            <i class="bi bi-building"></i> View Colleges
          </a>
        </div>
      </div>
    </section>
  </div>

  <!-- ════════════════ COMPARE SECTION ════════════════ -->
  <section class="cmp-wrap">
    <div class="cmp-box">

      <!-- Header -->
      <div class="cmp-hdr">
        <div>
          <div class="cmp-eyebrow">
            <i class="bi bi-bar-chart-steps"></i> Side-by-side comparison
          </div>
          <h1 class="cmp-title">Compare IIMs</h1>
          <p class="cmp-sub">
            <?= $count ?> college<?= $count > 1 ? 's' : '' ?> selected &mdash;
            fees, placements, rankings &amp; more
          </p>
        </div>
        <a href="compare.php?clear=1" class="cmp-clear" aria-label="Clear all">
          <i class="bi bi-x-circle"></i> Clear all
        </a>
      </div>

      <!-- College cards -->
      <div class="cmp-grid g<?= $count ?>">
        <?php foreach ($colleges as $c): ?>
          <div class="cmp-card">
            <div class="cmp-img">
              <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>" loading="lazy" />
              <div class="cmp-img-shade"></div>
              <span class="cmp-img-rank">NIRF #<?= htmlspecialchars($c['ranking']) ?></span>

            </div>
            <div class="cmp-body">
              <div class="cmp-name"><?= htmlspecialchars($c['name']) ?></div>
              <div class="cmp-loc">
                <i class="bi bi-geo-alt-fill"></i>
                <?= htmlspecialchars($c['location']) ?>
              </div>
              <div class="cmp-pills">
                <span class="cmp-pill"><i class="bi bi-currency-rupee"></i><?= htmlspecialchars($c['fees']) ?>L Fees</span>
                <span class="cmp-pill"><i class="bi bi-graph-up-arrow"></i><?= htmlspecialchars($c['placement']) ?>L
                  Avg</span>
                <span class="cmp-pill"><i class="bi bi-star-fill"></i><?= htmlspecialchars($c['rating']) ?></span>
              </div>
              <div class="cmp-actions">
                <a href="college-details.php?slug=<?= urlencode($c['slug']) ?>" class="btn-details">
                  <i class="bi bi-eye"></i> View Details
                </a>
                <a href="compare.php?remove=<?= urlencode($c['slug']) ?>" class="btn-rm" title="Remove"
                  aria-label="Remove <?= htmlspecialchars($c['name']) ?>">
                  <i class="bi bi-x-lg"></i>
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Comparison table -->
      <?php
      $icons = [
        'Location' => 'bi-geo-alt',
        'Established' => 'bi-calendar3',
        'NIRF Ranking' => 'bi-trophy',
        'Rating' => 'bi-star',
        'Total Fees' => 'bi-cash-stack',
        'Avg Placement' => 'bi-graph-up-arrow',
        'Highest Package' => 'bi-arrow-up-circle',
        'Faculty' => 'bi-person-badge',
        'Intake' => 'bi-people',
        'Exams Accepted' => 'bi-journal-check',
      ];
      ?>
      <div class="cmp-tbl-wrap">
        <table class="cmp-tbl" aria-label="IIM comparison table">
          <thead>
            <tr>
              <th>Criteria</th>
              <?php foreach ($colleges as $c): ?>
                <th>
                  <span class="th-name"><?= htmlspecialchars($c['name']) ?></span>
                  <span class="th-loc"><?= htmlspecialchars($c['location']) ?></span>
                </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $label => $fn): ?>
              <tr>
                <td class="cmp-lbl">
                  <i class="bi <?= $icons[$label] ?? 'bi-dot' ?>"></i>
                  <?= htmlspecialchars($label) ?>
                </td>
                <?php foreach ($colleges as $c): ?>
                  <td><span class="cmp-val"><?= $fn($c) ?></span></td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Add more -->
      <?php if ($count < 3): ?>
        <div class="cmp-more">
          <a href="colleges.php" class="btn-add">
            <i class="bi bi-plus-circle"></i>
            Add <?= $count === 1 ? 'up to 2 more IIMs' : '1 more IIM' ?> to compare
          </a>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <!-- ════════════════ FINAL CTA (unchanged) ════════════════ -->
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
            <button class="button-cta bg-transparent px-4 py-2" onclick="openApplyModal()">
              Apply
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php endif; ?>

<?php
include '../components/Footer.php';
include '../components/Modals.php';
include '../includes/footer.php';
?>