
<?php
/**
 * course-details.php
 * PHP conversion of: courses/$slug.tsx (CourseDetail)
 * URL: course-details.php?slug=mba-finance
 */

session_start();
require_once '../data/iims.php';

$slug = trim($_GET['slug'] ?? '');
$c = $slug !== '' ? getCourse($slug) : null;

if (!$c) {
  header('HTTP/1.0 404 Not Found');
  $page_title = 'Course Not Found';
  include '../includes/header.php';
  include '../components/Navbar.php';
  echo '<section style="padding-top:8rem;text-align:center;max-width:600px;margin:auto;">
            <h1 style="font-size:2rem;font-weight:800;margin-bottom:1rem;">Course Not Found</h1>
            <p style="color:var(--muted-foreground);">The course you are looking for does not exist or may have been moved.</p>
            <a href="courses.php" class="btn btn-hero" style="display:inline-flex;margin-top:1.5rem">← Back to Courses</a>
          </section>';
  include '../components/Footer.php';
  include '../includes/footer.php';
  exit;
}

$page_title = htmlspecialchars($c['title']) . ' — IIMs Courses';
$page_description = htmlspecialchars(mb_substr($c['description'] ?? '', 0, 155));
$current_page = 'courses';

$iims = array_values(array_filter(array_map(fn($s) => getCollege($s), $c['iims'] ?? [])));
$recommended = array_values(array_slice(
  array_filter($COURSES, fn($x) => $x['slug'] !== $slug),
  0,
  3
));

include '../includes/header.php';
include '../components/Navbar.php';
?>
<?php
require_once '../data/iims.php';

$slug = $_GET['slug'] ?? '';

$course = null;

foreach ($COURSES as $c) {
    if ($c['slug'] === $slug) {
        $course = $c;
        break;
    }
}

if (!$course) {
    echo "Course not found";
    exit;
}
?>
<!-- Tabler Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
  /* ══════════════════════════════════════════════════════
   COURSE DETAIL PAGE — FULL STYLES
══════════════════════════════════════════════════════ */
  *,
  *::before,
  *::after {
    box-sizing: border-box
  }

  /* ── Reading progress ── */
  #ccd-progress {
    position: fixed;
    top: 0;
    left: 0;
    height: 3px;
    width: 0%;
    background: linear-gradient(90deg, var(--color-accent, #e25c2a), var(--color-primary, #1a3c6e));
    z-index: 9999;
    transition: width .1s linear;
  }

  /* ══ HERO ══════════════════════════════════════════ */
     #ccd-toast {
      position: fixed;
      bottom: 1.5rem;
      left: 50%;
      transform: translateX(-50%) translateY(120%);
      background: #1e293b;
      color: #fff;
      padding: .65rem 1.4rem;
      border-radius: 9999px;
      font-size: .82rem;
      font-weight: 600;
      box-shadow: 0 8px 32px rgba(0,0,0,.35);
      transition: transform .35s cubic-bezier(.34,1.56,.64,1);
      z-index: 9999;
      white-space: nowrap;
    }
    #ccd-toast.show { transform: translateX(-50%) translateY(0); }
 
    /* ─── Modal ────────────────────────────────── */
    #ccd-modal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,.6);
      backdrop-filter: blur(6px);
      z-index: 999;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }
    #ccd-modal.open { display: flex; }
    .ccd-modal-box {
      background: #fff;
      border-radius: 1.25rem;
      padding: 2.5rem 2rem;
      width: 100%;
      max-width: 440px;
      position: relative;
      box-shadow: 0 24px 64px rgba(0,0,0,.3);
    }
    .ccd-modal-box h2 { font-size: 1.35rem; font-weight: 700; color: #0f2167; margin-bottom: 1.25rem; }
    .ccd-modal-close {
      position: absolute;
      top: 1rem; right: 1rem;
      background: none; border: none;
      cursor: pointer; font-size: 1.3rem; color: #64748b;
    }
    .ccd-modal-close:hover { color: #0f2167; }
    .ccd-form-group { margin-bottom: 1rem; }
    .ccd-form-group label { display: block; font-size: .8rem; font-weight: 600; color: #334155; margin-bottom: .35rem; }
    .ccd-form-group input, .ccd-form-group select {
      width: 100%;
      padding: .65rem .9rem;
      border: 1.5px solid #e2e8f0;
      border-radius: .6rem;
      font-size: .875rem;
      font-family: inherit;
      color: #0f172a;
      outline: none;
      transition: border-color .2s;
    }
    .ccd-form-group input:focus, .ccd-form-group select:focus { border-color: #0f2167; }
    .ccd-form-submit {
      width: 100%;
      padding: .75rem;
      background: #0f2167;
      color: #fff;
      border: none;
      border-radius: .7rem;
      font-size: .9rem;
      font-weight: 700;
      cursor: pointer;
      font-family: inherit;
      margin-top: .5rem;
      transition: background .2s;
    }
    .ccd-form-submit:hover { background: #1a35a8; }
 
    /* ─── Hero ─────────────────────────────────── */
    .ccd-hero {
      position: relative;
      height: 62vh;
      min-height: 400px;
      overflow: hidden;
    }
 
    .ccd-hero-img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(.55);
      transform: scale(1.06);
      transition: transform 8s ease;
    }
    .ccd-hero-img.loaded { transform: scale(1); }
 
    .ccd-hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(
        to top,
        rgba(0,0,0,.92) 0%,
        rgba(0,0,0,.55) 45%,
        rgba(0,0,0,.10) 100%
      );
    }
 
    .ccd-hero-inner {
      position: relative;
      z-index: 2;
      height: 100%;
      max-width: 82rem;
      margin: 0 auto;
      padding: 0 1.5rem 3.5rem;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      color: #fff;
    }
 
    .ccd-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      background: rgba(255,255,255,.15);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,.22);
      border-radius: 9999px;
      padding: .28rem .9rem;
      font-size: .68rem;
      font-weight: 700;
      letter-spacing: .1em;
      text-transform: uppercase;
      color: #fff;
      margin-bottom: .85rem;
      width: fit-content;
    }
 
    .ccd-hero-title {
      font-size: 3rem;
      font-weight: 700;
      line-height: 1.1;
      letter-spacing: -.025em;
      max-width: 54rem;
      margin: 0 0 .85rem;
    }
 
    .ccd-hero-sub {
      color: rgba(255,255,255,.78);
      font-size: clamp(.875rem, 1.5vw, 1.05rem);
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: .6rem .5rem;
      margin-bottom: 1.6rem;
    }
 
    .ccd-hero-sub-pill {
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      background: rgba(255,255,255,.12);
      border: 1px solid rgba(255,255,255,.2);
      border-radius: 999px;
      padding: .22rem .75rem;
      font-size: .78rem;
      font-weight: 600;
    }
    .ccd-hero-sub-pill i { font-size: 13px; }
 
    .ccd-hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: .75rem;
      align-items: center;
    }
 
    /* Brochure */
    .ccd-btn-brochure {
      display: inline-flex;
      align-items: center;
      gap: .45rem;
      padding: .7rem 1.4rem;
      border-radius: .65rem;
      background: rgba(255,255,255,.12);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,.3);
      color: #fff;
      font-size: .875rem;
      font-weight: 600;
      cursor: pointer;
      transition: background .2s, color .2s;
      font-family: inherit;
    }
    /* ─── Responsive ────────────────────────────── */
    @media (max-width: 768px) {
      .ccd-hero {
        height: auto;
        min-height: unset;
        padding-bottom: 0;
      }
      .ccd-hero-inner {
        padding: 5rem 1.25rem 2.5rem;
        justify-content: flex-end;
        min-height: 60vw;
      }
      .ccd-hero-title {
        font-size: clamp(1.5rem, 6vw, 2.4rem);
      }
      .ccd-hero-sub {
        gap: .45rem .4rem;
      }
      .ccd-hero-sub-pill {
        font-size: .72rem;
        padding: .2rem .6rem;
      }
      .btn-hero,
      .ccd-btn-brochure {
        font-size: .82rem;
        padding: .65rem 1.1rem;
      }
    }
 
    @media (max-width: 480px) {
      .ccd-hero-inner {
        padding: 4rem 1rem 2rem;
        min-height: 72vw;
      }
      .ccd-hero-title {
        font-size: clamp(1.35rem, 7vw, 2rem);
      }
      .ccd-hero-actions {
        flex-direction: column;
        align-items: flex-start;
        gap: .55rem;
      }
      .btn-hero,
      .ccd-btn-brochure {
        width: 100%;
        justify-content: center;
      }
      .ccd-modal-box {
        padding: 2rem 1.25rem 1.5rem;
      }
    }
  /* ── Quick-stat bar ── */
  .ccd-statbar {
    background: var(--card);
    border-bottom: 1px solid var(--border);
  }

  .ccd-statbar-inner {
    max-width: 82rem;
    margin: 0 auto;
    padding: .85rem 1.5rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0;
    align-items: stretch;
  }

  .ccd-statbar-item {
    flex: 1 1 160px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: .6rem 1rem;
    border-right: 1px solid var(--border);
    text-align: center;
  }

  .ccd-statbar-item:last-child {
    border-right: none
  }

  .ccd-statbar-num {
    font-size: 1.35rem;
    font-weight: 900;
    letter-spacing: -.03em;
    color: var(--color-accent, #e25c2a);
  }

  .ccd-statbar-label {
    font-size: .7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--muted-foreground);
    margin-top: 2px;
  }

  @media(max-width:600px) {
    .ccd-statbar-item {
      border-right: none;
      border-bottom: 1px solid var(--border)
    }

    .ccd-statbar-item:last-child {
      border-bottom: none
    }
  }

  /* ── BODY LAYOUT ── */
  .ccd-body {
    max-width: 82rem;
    margin: 0 auto;
    padding: 3rem 1.5rem 5rem;
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 2.75rem;
    align-items: start;
  }

  @media(max-width:1023px) {
    .ccd-body {
      grid-template-columns: 1fr
    }
  }

  /* ── LEFT COLUMN ── */
  .ccd-left {
    display: flex;
    flex-direction: column;
    gap: 3rem;
    min-width: 0
  }

  /* Section title */
  .ccd-section-title {
    font-size: clamp(1.35rem, 3vw, 1.75rem);
    font-weight: 800;
    margin: 0 0 1rem;
    letter-spacing: -.02em;
    line-height: 1.2;
  }

  .ccd-section-title span {
    display: inline-block;
    border-bottom: 3px solid var(--color-accent, #e25c2a);
    padding-bottom: 2px;
  }

  .ccd-lead {
    color: var(--muted-foreground);
    line-height: 1.8;
    font-size: 1rem;
    margin: 0 0 .9rem;
  }

  .ccd-lead:last-child {
    margin-bottom: 0
  }

  /* Highlights grid */
  .ccd-highlights {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1.25rem;
  }

  .ccd-highlight-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.1rem 1rem;
    display: flex;
    align-items: flex-start;
    gap: .75rem;
  }

  .ccd-highlight-icon {
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(226, 92, 42, .15), rgba(226, 92, 42, .05));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-accent, #e25c2a);
    font-size: 20px;
  }

  .ccd-highlight-label {
    font-size: .78rem;
    font-weight: 600;
    color: var(--muted-foreground);
    margin-bottom: 2px;
  }

  .ccd-highlight-val {
    font-size: .95rem;
    font-weight: 700;
  }

  /* Outcomes */
  .ccd-outcomes {
    display: flex;
    flex-direction: column;
    gap: .65rem;
    margin-top: 1rem;
  }

  .ccd-outcome-item {
    display: flex;
    align-items: flex-start;
    gap: .75rem;
    font-size: .95rem;
    color: var(--muted-foreground);
    line-height: 1.65;
  }

  .ccd-outcome-item .outcome-check {
    flex-shrink: 0;
    margin-top: 2px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e25c2a, #c8401a);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 11px;
  }

  /* Eligibility table */
  .ccd-eligibility-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
    font-size: .9rem;
  }

  .ccd-eligibility-table th {
    text-align: left;
    padding: .75rem 1rem;
    background: var(--muted);
    font-size: .75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--muted-foreground);
    border-bottom: 2px solid var(--border);
  }

  .ccd-eligibility-table td {
    padding: .75rem 1rem;
    border-bottom: 1px solid var(--border);
    color: var(--foreground);
    vertical-align: top;
    line-height: 1.6;
  }

  .ccd-eligibility-table tr:last-child td {
    border-bottom: none
  }

  .ccd-eligibility-table tr:hover td {
    background: var(--muted)
  }

  /* Curriculum */
  .ccd-curriculum {
    display: flex;
    flex-direction: column;
    gap: .75rem
  }

  .ccd-sem {
    border: 1px solid var(--border);
    border-radius: 14px;
    background: var(--card);
    overflow: hidden;
  }

  .ccd-sem-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.25rem;
    cursor: pointer;
    user-select: none;
    transition: background .2s;
  }

  .ccd-sem-header:hover {
    background: var(--muted)
  }

  .ccd-sem-label {
    font-weight: 700;
    font-size: .95rem
  }

  .ccd-sem-arrow {
    flex-shrink: 0;
    transition: transform .3s;
    color: var(--muted-foreground);
    font-size: 18px;
  }

  .ccd-sem.open .ccd-sem-arrow {
    transform: rotate(180deg)
  }

  .ccd-sem-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height .35s ease, padding .35s ease;
    padding: 0 1.25rem;
  }

  .ccd-sem.open .ccd-sem-body {
    max-height: 400px;
    padding: .25rem 1.25rem 1.25rem
  }

  .ccd-topics {
    display: flex;
    flex-wrap: wrap;
    gap: .45rem
  }

  .ccd-topic {
    font-size: .75rem;
    padding: .32rem .8rem;
    border-radius: 9999px;
    background: var(--secondary, #f1f5f9);
    color: var(--foreground);
    font-weight: 500;
    border: 1px solid var(--border);
  }

  /* Career paths */
  .ccd-careers {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
  }

  .ccd-career-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.1rem;
    text-align: center;
    transition: transform .2s, box-shadow .2s;
  }

  .ccd-career-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(0, 0, 0, .1)
  }

  .ccd-career-icon {
    font-size: 28px;
    margin-bottom: .5rem;
    color: var(--color-accent, #e25c2a);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .ccd-career-title {
    font-size: .875rem;
    font-weight: 700;
    margin-bottom: .2rem
  }

  .ccd-career-sal {
    font-size: .75rem;
    color: var(--color-accent, #e25c2a);
    font-weight: 600
  }

  /* Placement stats */
  .ccd-placement-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 1rem;
    margin-top: 1.25rem;
  }

  .ccd-placement-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.25rem 1rem;
    text-align: center;
  }

  .ccd-placement-num {
    font-size: 1.8rem;
    font-weight: 900;
    letter-spacing: -.04em;
    color: var(--color-accent, #e25c2a);
  }

  .ccd-placement-label {
    font-size: .72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--muted-foreground);
    margin-top: 4px;
  }

  /* Recruiters */
  .ccd-recruiters {
    display: flex;
    flex-wrap: wrap;
    gap: .75rem;
    margin-top: 1rem;
  }

  .ccd-recruiter-chip {
    font-size: .8rem;
    font-weight: 700;
    padding: .4rem 1rem;
    border-radius: 999px;
    background: var(--muted);
    border: 1px solid var(--border);
    color: var(--foreground);
  }

  /* Testimonial */
  .ccd-testimonials {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 1rem;
  }

  .ccd-testimonial {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.4rem;
    position: relative;
  }

  .ccd-testimonial::before {
    content: '"';
    position: absolute;
    top: .5rem;
    left: 1.1rem;
    font-size: 4rem;
    line-height: 1;
    color: var(--color-accent, #e25c2a);
    opacity: .2;
    font-family: Georgia, serif;
  }

  .ccd-testimonial__text {
    font-size: .925rem;
    color: var(--muted-foreground);
    line-height: 1.75;
    font-style: italic;
    margin: 0 0 .85rem;
  }

  .ccd-testimonial__author {
    display: flex;
    align-items: center;
    gap: .75rem
  }

  .ccd-testimonial__avatar {
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e25c2a, #1a3c6e);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .9rem;
    font-weight: 800;
    color: #fff;
  }

  .ccd-testimonial__name {
    font-weight: 700;
    font-size: .875rem
  }

  .ccd-testimonial__role {
    font-size: .75rem;
    color: var(--muted-foreground)
  }

  /* IIMs offering */
  .ccd-iims-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1rem;
  }

  .ccd-iim-card {
    display: flex;
    gap: .85rem;
    border: 1px solid var(--border);
    border-radius: 14px;
    background: var(--card);
    padding: 1rem;
    text-decoration: none;
    color: inherit;
    transition: box-shadow .25s, transform .25s;
  }

  .ccd-iim-card:hover {
    box-shadow: 0 10px 32px rgba(0, 0, 0, .1);
    transform: translateY(-2px)
  }

  .ccd-iim-thumb {
    width: 4.5rem;
    height: 4.5rem;
    border-radius: .65rem;
    object-fit: cover;
    flex-shrink: 0;
  }

  .ccd-iim-name {
    font-weight: 700;
    font-size: .95rem;
    margin-bottom: .15rem
  }

  .ccd-iim-loc {
    font-size: .75rem;
    color: var(--muted-foreground);
    display: flex;
    align-items: center;
    gap: .25rem
  }

  .ccd-iim-loc i {
    font-size: 12px
  }

  .ccd-iim-meta {
    display: flex;
    flex-wrap: wrap;
    gap: .4rem;
    margin-top: .45rem
  }

  .ccd-iim-badge {
    font-size: .68rem;
    font-weight: 600;
    padding: .18rem .55rem;
    border-radius: 999px;
    background: var(--muted);
    border: 1px solid var(--border);
    color: var(--muted-foreground);
  }

  /* Compare table */
  .ccd-compare-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .875rem;
    margin-top: 1rem;
  }

  .ccd-compare-table th {
    background: var(--color-primary, #1a3c6e);
    color: #fff;
    padding: .85rem 1rem;
    text-align: left;
    font-weight: 700;
    font-size: .78rem;
    text-transform: uppercase;
    letter-spacing: .07em;
  }

  .ccd-compare-table th:first-child {
    border-radius: 12px 0 0 0
  }

  .ccd-compare-table th:last-child {
    border-radius: 0 12px 0 0
  }

  .ccd-compare-table td {
    padding: .8rem 1rem;
    border-bottom: 1px solid var(--border);
    color: var(--foreground);
    line-height: 1.55;
  }

  .ccd-compare-table tr:last-child td:first-child {
    border-radius: 0 0 0 12px
  }

  .ccd-compare-table tr:last-child td:last-child {
    border-radius: 0 0 12px 0
  }

  .ccd-compare-table tr:hover td {
    background: var(--muted)
  }

  .ccd-compare-table .highlight {
    font-weight: 700;
    color: var(--color-accent, #e25c2a);
  }

  /* ── SIDEBAR ── */
  .ccd-sidebar {
    width: 100%
  }

  .ccd-sidebar-card {
    position: sticky;
    top: 88px;
    border: 1px solid var(--border);
    border-radius: 16px;
    background: var(--card);
    box-shadow: 0 4px 32px rgba(0, 0, 0, .08);
    padding: 1.5rem;
  }

  .ccd-sidebar-title {
    font-size: 1.15rem;
    font-weight: 800;
    margin-bottom: .25rem
  }

  .ccd-sidebar-sub {
    font-size: .8rem;
    color: var(--muted-foreground);
    margin-bottom: 1rem;
    line-height: 1.55
  }

  .ccd-form {
    display: flex;
    flex-direction: column;
    gap: .85rem
  }

  .ccd-field {
    display: flex;
    flex-direction: column;
    gap: .3rem
  }

  .ccd-label {
    font-size: .75rem;
    font-weight: 700;
    color: var(--muted-foreground);
    text-transform: uppercase;
    letter-spacing: .05em
  }

  .ccd-input {
    width: 100%;
    padding: .68rem .9rem;
    border: 1px solid var(--border);
    border-radius: .65rem;
    background: var(--background);
    color: var(--foreground);
    font-size: .9rem;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    font-family: inherit;
  }

  .ccd-input:focus {
    border-color: var(--color-accent, #e25c2a);
    box-shadow: 0 0 0 3px rgba(226, 92, 42, .14);
  }

  .ccd-select {
    width: 100%;
    padding: .68rem .9rem;
    border: 1px solid var(--border);
    border-radius: .65rem;
    background: var(--background);
    color: var(--foreground);
    font-size: .9rem;
    outline: none;
    font-family: inherit;
    cursor: pointer;
  }

  /* Sidebar info list */
  .ccd-info-list {
    display: flex;
    flex-direction: column;
    gap: .6rem;
    margin-top: 1.25rem
  }

  .ccd-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: .85rem;
    padding: .5rem 0;
    border-bottom: 1px solid var(--border);
  }

  .ccd-info-row:last-child {
    border-bottom: none
  }

  .ccd-info-key {
    color: var(--muted-foreground);
    font-weight: 500
  }

  .ccd-info-val {
    font-weight: 700;
    color: var(--foreground)
  }

  /* Sidebar trust signals */
  .ccd-trust {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid var(--border);
  }

  .ccd-trust-item {
    display: flex;
    align-items: center;
    gap: .4rem;
    font-size: .72rem;
    color: var(--muted-foreground);
    font-weight: 600;
  }

  .ccd-trust-item i {
    font-size: 13px
  }

  /* ── RECOMMENDED ── */
  .ccd-rec-wrap {
    max-width: 82rem;
    margin: 0 auto;
    padding: 0 1.5rem 5rem;
  }

  .ccd-rec-title {
    font-size: 1.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem
  }

  .ccd-rec-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.25rem;
  }

  .ccd-rec-card {
    border: 1px solid var(--border);
    border-radius: 16px;
    background: var(--card);
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: box-shadow .25s, transform .25s;
  }

  .ccd-rec-card:hover {
    box-shadow: 0 10px 32px rgba(0, 0, 0, .1);
    transform: translateY(-3px)
  }

  .ccd-rec-img {
    width: 100%;
    height: 130px;
    object-fit: cover
  }

  .ccd-rec-body {
    padding: 1.1rem
  }

  .ccd-rec-cat {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--color-accent, #e25c2a);
    margin-bottom: .3rem;
  }

  .ccd-rec-name {
    font-weight: 700;
    font-size: .95rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: .5rem;
  }

  .ccd-rec-meta {
    font-size: .75rem;
    color: var(--muted-foreground)
  }

  /* ── Modal ── */
  .ccd-modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 1000;
    background: rgba(0, 0, 0, .55);
    backdrop-filter: blur(5px);
    align-items: center;
    justify-content: center;
    padding: 1rem;
  }

  .ccd-modal-backdrop.open {
    display: flex
  }

  .ccd-modal-box {
    background: var(--card);
    border-radius: 18px;
    padding: 2rem;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 24px 64px rgba(0, 0, 0, .22);
    position: relative;
    animation: ccdModalIn .25s ease;
  }

  @keyframes ccdModalIn {
    from {
      opacity: 0;
      transform: translateY(16px)
    }

    to {
      opacity: 1;
      transform: none
    }
  }

  .ccd-modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.3rem;
    color: var(--muted-foreground);
    line-height: 1;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
  }

  .ccd-modal-close:hover {
    background: var(--muted)
  }

  .ccd-modal-h {
    font-size: 1.3rem;
    font-weight: 800;
    margin-bottom: .3rem
  }

  .ccd-modal-sub {
    font-size: .875rem;
    color: var(--muted-foreground);
    margin-bottom: 1.5rem;
    line-height: 1.55
  }

  /* ── Toast ── */
  .ccd-toast {
    position: fixed;
    bottom: 2rem;
    right: 1.5rem;
    z-index: 9999;
    background: #111827;
    color: #fff;
    padding: .8rem 1.3rem;
    border-radius: 12px;
    font-size: .875rem;
    font-weight: 600;
    box-shadow: 0 8px 32px rgba(0, 0, 0, .25);
    opacity: 0;
    transform: translateY(12px);
    transition: opacity .3s, transform .3s;
    pointer-events: none;
    display: flex;
    align-items: center;
    gap: .5rem;
  }

  .ccd-toast.show {
    opacity: 1;
    transform: none
  }

  /* ── Scroll to top ── */
  #ccd-scroll-top {
    position: fixed;
    bottom: 2rem;
    right: 1.5rem;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e25c2a, #c8401a);
    color: #fff;
    border: none;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(226, 92, 42, .4);
    z-index: 900;
    transition: transform .2s;
    font-size: 18px;
  }

  #ccd-scroll-top.visible {
    display: flex
  }

  #ccd-scroll-top:hover {
    transform: translateY(-2px)
  }

  /* ── Reveal animation ── */
  .reveal {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity .45s ease, transform .45s ease
  }

  .reveal.visible {
    opacity: 1;
    transform: none
  }

  /* ── Responsive ── */
  @media(max-width:640px) {
    .ccd-hero {
      height: 70vh
    }

    .ccd-body {
      padding: 2rem 1rem 4rem
    }

    .ccd-left {
      gap: 2rem
    }

    .ccd-rec-wrap {
      padding: 0 1rem 4rem
    }

    .ccd-sidebar-card {
      position: static
    }
  }
</style>

<!-- Reading progress -->
<div id="ccd-progress"></div>

<!-- ══════════════ HERO ══════════════ -->
<section class="ccd-hero">
  <img class="ccd-hero-img" src="<?= htmlspecialchars($c['image'] ?? '../assets/images/default-course.jpg') ?>"
    alt="<?= htmlspecialchars($c['title']) ?>" onload="this.classList.add('loaded')">
  <div class="ccd-hero-overlay"></div>
  <div class="ccd-hero-inner">

    <span class="ccd-eyebrow">
      <i class="ti ti-school" style="font-size:11px"></i>
      <?= htmlspecialchars($c['category']) ?>
    </span>

    <h1 class="ccd-hero-title"><?= htmlspecialchars($c['title']) ?></h1>

    <div class="ccd-hero-sub">
      <span class="ccd-hero-sub-pill">
        <i class="ti ti-clock"></i>
        <?= htmlspecialchars($c['duration'] ?? '2 Years') ?>
      </span>
      <span class="ccd-hero-sub-pill">
        <i class="ti ti-currency-rupee"></i>
        ₹<?= htmlspecialchars((string) ($c['fees'] ?? '')) ?>L Total Fees
      </span>
      <span class="ccd-hero-sub-pill">
        <i class="ti ti-layout-grid"></i>
        <?= htmlspecialchars($c['mode'] ?? 'Full Time') ?>
      </span>
      <span class="ccd-hero-sub-pill">
        <i class="ti ti-users"></i>
        <?= count($iims) ?> IIMs Offering
      </span>
    </div>

    <div class="ccd-hero-actions">
      <button class="btn btn-hero" style="font-size:.9rem"
        onclick="document.getElementById('ccd-modal').classList.add('open')">
        Apply Now
        <i class="ti ti-arrow-right" style="font-size:15px"></i>
      </button>
      <button class="ccd-btn-brochure" onclick="ccdToast('Brochure download started!')">
        <i class="ti ti-download" style="font-size:15px"></i>
        Download Brochure
      </button>
    </div>

  </div>
</section>

<!-- ══ QUICK-STAT BAR ══ -->
<div class="ccd-statbar">
  <div class="ccd-statbar-inner">
    <div class="ccd-statbar-item">
      <div class="ccd-statbar-num">₹28L</div>
      <div class="ccd-statbar-label">Avg. Package</div>
    </div>
    <div class="ccd-statbar-item">
      <div class="ccd-statbar-num">98%</div>
      <div class="ccd-statbar-label">Placement Rate</div>
    </div>
    <div class="ccd-statbar-item">
      <div class="ccd-statbar-num">500+</div>
      <div class="ccd-statbar-label">Recruiters</div>
    </div>
    <div class="ccd-statbar-item">
      <div class="ccd-statbar-num"><?= count($iims) ?></div>
      <div class="ccd-statbar-label">IIMs Offering</div>
    </div>
    <div class="ccd-statbar-item">
      <div class="ccd-statbar-num">4.8<i class="ti ti-star-filled"
          style="font-size:1rem;color:var(--color-accent,#e25c2a)"></i></div>
      <div class="ccd-statbar-label">Student Rating</div>
    </div>
  </div>
</div>

<!-- ══════════════ BODY ══════════════ -->
<div class="ccd-body">

  <!-- ── LEFT COLUMN ── -->
  <div class="ccd-left">

    <!-- OVERVIEW -->
    <section class="reveal">
      <h2 class="ccd-section-title"><span>Overview</span></h2>
      <p class="ccd-lead"><?= htmlspecialchars($c['description'] ?? '') ?></p>
      <p class="ccd-lead">
        This programme is designed for motivated professionals and fresh graduates who want to build expertise in
        <?= htmlspecialchars($c['category'] ?? 'management') ?>. Delivered by world-class faculty across India's
        premier IIMs, it blends rigorous academics with industry exposure, live projects and global immersion
        programmes.
      </p>

      <!-- Highlight cards -->
      <div class="ccd-highlights">
        <div class="ccd-highlight-card">
          <div class="ccd-highlight-icon"><i class="ti ti-certificate"></i></div>
          <div>
            <div class="ccd-highlight-label">Degree Type</div>
            <div class="ccd-highlight-val">Post Graduate Diploma</div>
          </div>
        </div>
        <div class="ccd-highlight-card">
          <div class="ccd-highlight-icon"><i class="ti ti-clock"></i></div>
          <div>
            <div class="ccd-highlight-label">Duration</div>
            <div class="ccd-highlight-val"><?= htmlspecialchars($c['duration'] ?? '2 Years') ?></div>
          </div>
        </div>
        <div class="ccd-highlight-card">
          <div class="ccd-highlight-icon"><i class="ti ti-map-pin"></i></div>
          <div>
            <div class="ccd-highlight-label">Mode</div>
            <div class="ccd-highlight-val"><?= htmlspecialchars($c['mode'] ?? 'Full Time') ?></div>
          </div>
        </div>
        <div class="ccd-highlight-card">
          <div class="ccd-highlight-icon"><i class="ti ti-currency-rupee"></i></div>
          <div>
            <div class="ccd-highlight-label">Total Fees</div>
            <div class="ccd-highlight-val">₹<?= htmlspecialchars((string) ($c['fees'] ?? '')) ?>L</div>
          </div>
        </div>
        <div class="ccd-highlight-card">
          <div class="ccd-highlight-icon"><i class="ti ti-calendar"></i></div>
          <div>
            <div class="ccd-highlight-label">Next Intake</div>
            <div class="ccd-highlight-val">June 2026</div>
          </div>
        </div>
        <div class="ccd-highlight-card">
          <div class="ccd-highlight-icon"><i class="ti ti-world"></i></div>
          <div>
            <div class="ccd-highlight-label">Global Exposure</div>
            <div class="ccd-highlight-val">International Module</div>
          </div>
        </div>
      </div>
    </section>

    <!-- WHAT YOU WILL LEARN -->
    <section class="reveal">
      <h2 class="ccd-section-title"><span>What You Will Learn</span></h2>
      <p class="ccd-lead">
        The programme curriculum is crafted to give you both functional depth and cross-domain breadth.
        By the end of this course you will be equipped to:
      </p>
      <div class="ccd-outcomes">
        <div class="ccd-outcome-item">
          <span class="outcome-check"><i class="ti ti-check" style="font-size:11px"></i></span>
          Lead and manage cross-functional teams with confidence in diverse, fast-paced business environments
        </div>
        <div class="ccd-outcome-item">
          <span class="outcome-check"><i class="ti ti-check" style="font-size:11px"></i></span>
          Apply advanced analytical frameworks to real-world business problems and strategic decision-making
        </div>
        <div class="ccd-outcome-item">
          <span class="outcome-check"><i class="ti ti-check" style="font-size:11px"></i></span>
          Design and execute go-to-market strategies, financial models and operational roadmaps
        </div>
        <div class="ccd-outcome-item">
          <span class="outcome-check"><i class="ti ti-check" style="font-size:11px"></i></span>
          Navigate the global business landscape including international trade, cross-border negotiations and cultural
          intelligence
        </div>
        <div class="ccd-outcome-item">
          <span class="outcome-check"><i class="ti ti-check" style="font-size:11px"></i></span>
          Build a leadership brand and professional network through alumni mentorship, industry immersion and live
          consulting projects
        </div>
        <div class="ccd-outcome-item">
          <span class="outcome-check"><i class="ti ti-check" style="font-size:11px"></i></span>
          Communicate compelling business narratives to stakeholders, boards and investors
        </div>
      </div>
    </section>

    <!-- ELIGIBILITY & ADMISSION -->
    <section class="reveal">
      <h2 class="ccd-section-title"><span>Eligibility &amp; Admission</span></h2>
      <p class="ccd-lead">
        <?php if (!empty($c['eligibility'])): ?>
          <?= htmlspecialchars($c['eligibility']) ?>
        <?php else: ?>
          Candidates must hold a recognised Bachelor's degree with minimum 50% aggregate (45% for SC/ST/PwD).
          Admission is based on CAT / GMAT / GRE scores followed by WAT-PI rounds.
        <?php endif; ?>
      </p>
      <table class="ccd-eligibility-table">
        <thead>
          <tr>
            <th>Criteria</th>
            <th>Requirement</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>Entrance Exam</strong></td>
            <td>CAT 2025 / GMAT / GRE (Valid Score)</td>
          </tr>
          <tr>
            <td><strong>Minimum Percentile</strong></td>
            <td>85th percentile overall (IIM-A, B, C require 90th+)</td>
          </tr>
          <tr>
            <td><strong>Academic Qualification</strong></td>
            <td>Any Bachelor's degree — minimum 50% aggregate</td>
          </tr>
          <tr>
            <td><strong>Work Experience</strong></td>
            <td>Preferred (0–5 years); mandatory for Executive MBA tracks</td>
          </tr>
          <tr>
            <td><strong>Application Window</strong></td>
            <td>August – November 2025</td>
          </tr>
          <tr>
            <td><strong>WAT-PI Rounds</strong></td>
            <td>January – March 2026 (at respective IIM campuses)</td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- CURRICULUM -->
    <?php if (!empty($c['curriculum'])): ?>
      <section class="reveal">
        <h2 class="ccd-section-title"><span>Curriculum</span></h2>
        <p class="ccd-lead">Click any term to expand its subjects and electives.</p>
        <div class="ccd-curriculum">
          <?php foreach ($c['curriculum'] as $i => $sem): ?>
            <div class="ccd-sem <?= $i === 0 ? 'open' : '' ?>">
              <div class="ccd-sem-header" onclick="ccdToggleSem(this)">
                <div class="ccd-sem-label"><?= htmlspecialchars($sem['sem']) ?></div>
                <i class="ti ti-chevron-down ccd-sem-arrow"></i>
              </div>
              <div class="ccd-sem-body">
                <div class="ccd-topics">
                  <?php foreach ($sem['topics'] as $topic): ?>
                    <span class="ccd-topic"><?= htmlspecialchars($topic) ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <!-- CAREER PATHS -->
    <section class="reveal">
      <h2 class="ccd-section-title"><span>Career Paths &amp; Roles</span></h2>
      <p class="ccd-lead">
        Graduates of this programme are placed across top MNCs, startups and government organisations in the following
        roles:
      </p>
      <div class="ccd-careers">
        <div class="ccd-career-card">
          <div class="ccd-career-icon"><i class="ti ti-chart-bar"></i></div>
          <div class="ccd-career-title">Strategy Consultant</div>
          <div class="ccd-career-sal">₹18–32 LPA</div>
        </div>
        <div class="ccd-career-card">
          <div class="ccd-career-icon"><i class="ti ti-briefcase"></i></div>
          <div class="ccd-career-title">Product Manager</div>
          <div class="ccd-career-sal">₹20–38 LPA</div>
        </div>
        <div class="ccd-career-card">
          <div class="ccd-career-icon"><i class="ti ti-trending-up"></i></div>
          <div class="ccd-career-title">Investment Analyst</div>
          <div class="ccd-career-sal">₹16–30 LPA</div>
        </div>
        <div class="ccd-career-card">
          <div class="ccd-career-icon"><i class="ti ti-building-bank"></i></div>
          <div class="ccd-career-title">Finance Manager</div>
          <div class="ccd-career-sal">₹14–28 LPA</div>
        </div>
        <div class="ccd-career-card">
          <div class="ccd-career-icon"><i class="ti ti-rocket"></i></div>
          <div class="ccd-career-title">Entrepreneur / Founder</div>
          <div class="ccd-career-sal">Unlimited</div>
        </div>
        <div class="ccd-career-card">
          <div class="ccd-career-icon"><i class="ti ti-world"></i></div>
          <div class="ccd-career-title">Business Development</div>
          <div class="ccd-career-sal">₹12–24 LPA</div>
        </div>
      </div>
    </section>

    <!-- PLACEMENT STATS -->
    <section class="reveal">
      <h2 class="ccd-section-title"><span>Placement Statistics</span></h2>
      <p class="ccd-lead">Latest placement data across IIMs offering this programme (Class of 2024):</p>
      <div class="ccd-placement-grid">
        <div class="ccd-placement-card">
          <div class="ccd-placement-num">₹28L</div>
          <div class="ccd-placement-label">Average CTC</div>
        </div>
        <div class="ccd-placement-card">
          <div class="ccd-placement-num">₹54L</div>
          <div class="ccd-placement-label">Highest CTC</div>
        </div>
        <div class="ccd-placement-card">
          <div class="ccd-placement-num">98%</div>
          <div class="ccd-placement-label">Placement Rate</div>
        </div>
        <div class="ccd-placement-card">
          <div class="ccd-placement-num">500+</div>
          <div class="ccd-placement-label">Recruiting Companies</div>
        </div>
        <div class="ccd-placement-card">
          <div class="ccd-placement-num">42%</div>
          <div class="ccd-placement-label">International Offers</div>
        </div>
        <div class="ccd-placement-card">
          <div class="ccd-placement-num">30+</div>
          <div class="ccd-placement-label">Countries Represented</div>
        </div>
      </div>

      <!-- Top Recruiters -->
      <h3 style="font-size:1rem;font-weight:700;margin:1.5rem 0 .75rem;">Top Recruiting Companies</h3>
      <div class="ccd-recruiters">
        <?php foreach (['McKinsey & Co.', 'Goldman Sachs', 'Google', 'Deloitte', 'KPMG', 'Amazon', 'Bain & Co.', 'BCG', 'JPMorgan', 'Infosys', 'Tata Group', 'Hindustan Unilever', 'Reliance Industries', 'Microsoft', 'Accenture', 'EY'] as $r): ?>
          <span class="ccd-recruiter-chip"><?= $r ?></span>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- COMPARE WITH OTHER PROGRAMMES -->
    <section class="reveal">
      <h2 class="ccd-section-title"><span>How It Compares</span></h2>
      <p class="ccd-lead">Wondering how this stacks up against similar programmes? Here's a side-by-side view:</p>
      <div style="overflow-x:auto;border-radius:14px;border:1px solid var(--border);">
        <table class="ccd-compare-table">
          <thead>
            <tr>
              <th>Feature</th>
              <th><?= htmlspecialchars($c['title']) ?></th>
              <th>General MBA</th>
              <th>Executive MBA</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Duration</strong></td>
              <td class="highlight"><?= htmlspecialchars($c['duration'] ?? '2 Years') ?></td>
              <td>2 Years</td>
              <td>1 Year</td>
            </tr>
            <tr>
              <td><strong>Focus Area</strong></td>
              <td class="highlight"><?= htmlspecialchars($c['category'] ?? 'Specialised') ?></td>
              <td>Broad Management</td>
              <td>Leadership &amp; Strategy</td>
            </tr>
            <tr>
              <td><strong>Work-Ex Required</strong></td>
              <td class="highlight">Optional (0–5 yrs)</td>
              <td>Not Required</td>
              <td>5+ Years</td>
            </tr>
            <tr>
              <td><strong>Avg. Package</strong></td>
              <td class="highlight">₹28 LPA</td>
              <td>₹20 LPA</td>
              <td>₹38 LPA</td>
            </tr>
            <tr>
              <td><strong>Mode</strong></td>
              <td class="highlight"><?= htmlspecialchars($c['mode'] ?? 'Full Time') ?></td>
              <td>Full Time</td>
              <td>Weekend / Blended</td>
            </tr>
            <tr>
              <td><strong>Total Fees</strong></td>
              <td class="highlight">₹<?= htmlspecialchars((string) ($c['fees'] ?? '')) ?>L</td>
              <td>₹20–25L</td>
              <td>₹25–35L</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- IIMs OFFERING -->
    <?php if (!empty($iims)): ?>
      <section class="reveal">
        <h2 class="ccd-section-title"><span>Offered at IIMs</span></h2>
        <p class="ccd-lead">Choose from <?= count($iims) ?> IIMs offering this programme — each with its own unique campus
          culture, faculty strength and placement network.</p>
        <div class="ccd-iims-grid">
          <?php foreach ($iims as $iim): ?>
            <a href="college-details.php?slug=<?= urlencode($iim['slug']) ?>" class="ccd-iim-card">
              <img src="<?= htmlspecialchars($iim['image']) ?>" alt="<?= htmlspecialchars($iim['name']) ?>"
                class="ccd-iim-thumb" loading="lazy">
              <div>
                <div class="ccd-iim-name"><?= htmlspecialchars($iim['name']) ?></div>
                <div class="ccd-iim-loc"><i class="ti ti-map-pin"></i><?= htmlspecialchars($iim['location']) ?></div>
                <div class="ccd-iim-meta">
                  <span class="ccd-iim-badge"><i class="ti ti-star-filled" style="font-size:10px;color:#e25c2a"></i>
                    <?= htmlspecialchars((string) ($iim['rating'] ?? '')) ?></span>
                  <span class="ccd-iim-badge">₹<?= htmlspecialchars((string) ($iim['fees'] ?? '')) ?>L</span>
                  <span class="ccd-iim-badge">NIRF Ranked</span>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <!-- STUDENT TESTIMONIALS -->
    <section class="reveal">
      <h2 class="ccd-section-title"><span>Student Experiences</span></h2>
      <p class="ccd-lead">Hear from our alumni about how this programme shaped their careers:</p>
      <div class="ccd-testimonials">
        <div class="ccd-testimonial">
          <p class="ccd-testimonial__text">
            The curriculum goes far beyond textbooks. Live consulting projects with Fortune 500 companies in the
            second year gave me the confidence to walk into any boardroom. The peer cohort is exceptional.
          </p>
          <div class="ccd-testimonial__author">
            <div class="ccd-testimonial__avatar">A</div>
            <div>
              <div class="ccd-testimonial__name">Arjun Mehta</div>
              <div class="ccd-testimonial__role">Strategy Associate, McKinsey &amp; Co. | IIM Ahmedabad, 2024</div>
            </div>
          </div>
        </div>
        <div class="ccd-testimonial">
          <p class="ccd-testimonial__text">
            I switched from engineering to finance through this programme. The faculty mentorship and the
            career services team were instrumental in helping me land my dream role at Goldman Sachs.
          </p>
          <div class="ccd-testimonial__author">
            <div class="ccd-testimonial__avatar">P</div>
            <div>
              <div class="ccd-testimonial__name">Priya Srinivasan</div>
              <div class="ccd-testimonial__role">Analyst, Goldman Sachs | IIM Bangalore, 2024</div>
            </div>
          </div>
        </div>
        <div class="ccd-testimonial">
          <p class="ccd-testimonial__text">
            The international module in Singapore exposed me to global business practices that no classroom
            can replicate. Two years here transformed not just my career but my entire perspective on leadership.
          </p>
          <div class="ccd-testimonial__author">
            <div class="ccd-testimonial__avatar">R</div>
            <div>
              <div class="ccd-testimonial__name">Rohan Kapoor</div>
              <div class="ccd-testimonial__role">Product Manager, Google | IIM Calcutta, 2023</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQs -->
 <?php
$courseFaqs = $COURSE_FAQS[$course['slug']] ?? [];
?>

<!-- ── FAQ ── -->
<?php if (!empty($courseFaqs)): ?>
<section id="cd-FAQ" class="cd-section reveal">
    <h2 class="cd-section-heading">Frequently Asked</h2>

    <div class="faq-wrap" style="max-width:100%">

        <?php foreach ($courseFaqs as $faq): ?>
            <div class="faq-item">

                <div class="faq-question">
                    <?= htmlspecialchars($faq['q']) ?>

                    <svg class="faq-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </div>

                <div class="faq-answer">
                    <?= htmlspecialchars($faq['a']) ?>
                </div>

            </div>
        <?php endforeach; ?>

    </div>
</section>
<?php endif; ?>
  </div><!-- /ccd-left -->

  <!-- ── SIDEBAR ── -->
  <aside class="ccd-sidebar">
    <div class="ccd-sidebar-card">

      <div class="ccd-sidebar-title">Get a Free Callback</div>
      <p class="ccd-sidebar-sub">Our IIM alumni counsellors respond within 2 hours on working days.</p>

      <form class="ccd-form" onsubmit="return ccdHandleCallback(event)" novalidate>
        <input type="hidden" name="course" value="<?= htmlspecialchars($c['title']) ?>">

        <div class="ccd-field">
          <label class="ccd-label">Full Name</label>
          <input type="text" class="ccd-input" name="name" placeholder="Your full name" required>
        </div>
        <div class="ccd-field">
          <label class="ccd-label">Email Address</label>
          <input type="email" class="ccd-input" name="email" placeholder="you@example.com" required>
        </div>
        <div class="ccd-field">
          <label class="ccd-label">Mobile Number</label>
          <input type="tel" class="ccd-input" name="phone" placeholder="+91 98765 43210" required>
        </div>
        <div class="ccd-field">
          <label class="ccd-label">Current Education / Profession</label>
          <select class="ccd-select ccd-input" name="profile">
            <option value="">Select your profile</option>
            <option>Final Year Student</option>
            <option>Fresh Graduate</option>
            <option>Working Professional (0–2 yrs)</option>
            <option>Working Professional (2–5 yrs)</option>
            <option>Working Professional (5+ yrs)</option>
          </select>
        </div>
        <div class="ccd-field">
          <label class="ccd-label">Preferred Time to Call</label>
          <select class="ccd-select ccd-input" name="time">
            <option value="">Any time is fine</option>
            <option>Morning (9am – 12pm)</option>
            <option>Afternoon (12pm – 4pm)</option>
            <option>Evening (4pm – 7pm)</option>
          </select>
        </div>

        <button type="submit" class="btn btn-hero" style="width:100%;justify-content:center;margin-top:.1rem">
          Request Callback
          <i class="ti ti-arrow-right" style="font-size:15px"></i>
        </button>
      </form>

      <!-- Course quick info -->
      <div class="ccd-info-list">
        <div class="ccd-info-row">
          <span class="ccd-info-key">Programme</span>
          <span class="ccd-info-val"><?= htmlspecialchars($c['category'] ?? 'MBA') ?></span>
        </div>
        <div class="ccd-info-row">
          <span class="ccd-info-key">Duration</span>
          <span class="ccd-info-val"><?= htmlspecialchars($c['duration'] ?? '2 Years') ?></span>
        </div>
        <div class="ccd-info-row">
          <span class="ccd-info-key">Total Fees</span>
          <span class="ccd-info-val">₹<?= htmlspecialchars((string) ($c['fees'] ?? '')) ?>L</span>
        </div>
        <div class="ccd-info-row">
          <span class="ccd-info-key">Avg. Package</span>
          <span class="ccd-info-val" style="color:var(--color-accent,#e25c2a)">₹28 LPA</span>
        </div>
        <div class="ccd-info-row">
          <span class="ccd-info-key">Next Batch</span>
          <span class="ccd-info-val">June 2026</span>
        </div>
      </div>

      <!-- Trust signals -->
      <div class="ccd-trust">
        <div class="ccd-trust-item">
          <i class="ti ti-shield-check"></i>
          100% Secure Data
        </div>
        <div class="ccd-trust-item">
          <i class="ti ti-clock"></i>
          Response in 2 hrs
        </div>
        <div class="ccd-trust-item">
          <i class="ti ti-phone"></i>
          Free Consultation
        </div>
        <div class="ccd-trust-item">
          <i class="ti ti-check"></i>
          No Spam Guarantee
        </div>
      </div>

    </div>
  </aside>

</div><!-- /ccd-body -->

<!-- ══════════════ RECOMMENDED ══════════════ -->
<?php if (!empty($recommended)): ?>
  <div class="ccd-rec-wrap">
    <h3 class="ccd-rec-title">Explore More Programmes</h3>
    <div class="ccd-rec-grid">
      <?php foreach ($recommended as $r): ?>
        <a href="course-details.php?slug=<?= urlencode($r['slug']) ?>" class="ccd-rec-card reveal">
          <img src="<?= htmlspecialchars($r['image'] ?? '../assets/images/default-course.jpg') ?>"
            alt="<?= htmlspecialchars($r['title']) ?>" class="ccd-rec-img" loading="lazy">
          <div class="ccd-rec-body">
            <div class="ccd-rec-cat"><?= htmlspecialchars($r['category']) ?></div>
            <div class="ccd-rec-name"><?= htmlspecialchars($r['title']) ?></div>
            <div class="ccd-rec-meta">
              <?= htmlspecialchars($r['duration'] ?? '') ?>
              &nbsp;•&nbsp; ₹<?= htmlspecialchars((string) ($r['fees'] ?? '')) ?>L
              &nbsp;•&nbsp; ₹28 LPA Avg
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>

<!-- ══════════════ APPLY MODAL ══════════════ -->
<div id="ccd-modal" class="ccd-modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
  <div class="ccd-modal-box">
    <button class="ccd-modal-close" onclick="document.getElementById('ccd-modal').classList.remove('open')">
      <i class="ti ti-x"></i>
    </button>
    <div class="ccd-modal-h">Apply for <?= htmlspecialchars($c['title']) ?></div>
    <p class="ccd-modal-sub">Fill in your details — our counsellor will reach out within 24 hours with the next steps.
    </p>
    <form class="ccd-form" onsubmit="return ccdHandleApply(event)" novalidate>
      <input type="hidden" name="course" value="<?= htmlspecialchars($c['title']) ?>">
      <div class="ccd-field">
        <label class="ccd-label">Full Name</label>
        <input type="text" class="ccd-input" name="name" placeholder="Full name" required>
      </div>
      <div class="ccd-field">
        <label class="ccd-label">Email Address</label>
        <input type="email" class="ccd-input" name="email" placeholder="you@example.com" required>
      </div>
      <div class="ccd-field">
        <label class="ccd-label">Phone Number</label>
        <input type="tel" class="ccd-input" name="phone" placeholder="+91 98765 43210" required>
      </div>
      <div class="ccd-field">
        <label class="ccd-label">Current CAT Percentile (if attempted)</label>
        <input type="text" class="ccd-input" name="cat" placeholder="e.g. 92.5 or Not yet attempted">
      </div>
      <button type="submit" class="btn btn-hero" style="width:100%;justify-content:center;margin-top:.1rem">
        Submit Application
        <i class="ti ti-arrow-right" style="font-size:15px"></i>
      </button>
    </form>
  </div>
</div>

<!-- TOAST -->
<div class="ccd-toast" id="ccd-toast"></div>

<!-- Scroll to top -->
<button id="ccd-scroll-top" title="Back to top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
  <i class="ti ti-arrow-up"></i>
</button>

<!-- ══════════════ SCRIPTS ══════════════ -->
<script>
  /* Reading progress */
  (function () {
    var bar = document.getElementById('ccd-progress');
    window.addEventListener('scroll', function () {
      var d = document.documentElement;
      var pct = (d.scrollTop || document.body.scrollTop) / (d.scrollHeight - d.clientHeight) * 100;
      bar.style.width = (pct || 0) + '%';
    }, { passive: true });
  })();

  /* Curriculum accordion */
  function ccdToggleSem(btn) {
    var item = btn.closest('.ccd-sem');
    var wasOpen = item.classList.contains('open');
    document.querySelectorAll('.ccd-sem.open').forEach(function (el) { el.classList.remove('open'); });
    if (!wasOpen) item.classList.add('open');
  }


  /* Toast */
  function ccdToast(msg) {
    var el = document.getElementById('ccd-toast');
    el.textContent = msg;
    el.classList.add('show');
    setTimeout(function () { el.classList.remove('show'); }, 3000);
  }

  /* Callback form */
  function ccdHandleCallback(e) {
    e.preventDefault();
    var btn = e.target.querySelector('[type=submit]');
    btn.innerHTML = '<i class="ti ti-check"></i> Callback Requested!';
    btn.disabled = true;
    ccdToast('Callback request received! We\'ll call you shortly.');
    setTimeout(function () {
      btn.innerHTML = 'Request Callback <i class="ti ti-arrow-right" style="font-size:15px"></i>';
      btn.disabled = false;
      e.target.reset();
    }, 3500);
    return false;
  }

  /* Apply modal form */
  function ccdHandleApply(e) {
    e.preventDefault();
    document.getElementById('ccd-modal').classList.remove('open');
    ccdToast('Application submitted! We\'ll reach out within 24 hours.');
    e.target.reset();
    return false;
  }

  /* Scroll-to-top visibility */
  window.addEventListener('scroll', function () {
    document.getElementById('ccd-scroll-top').classList.toggle('visible', window.scrollY > 500);
  }, { passive: true });

  /* Reveal on scroll */
  (function () {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
      });
    }, { threshold: 0.07 });
    document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
  })();
</script>

<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>