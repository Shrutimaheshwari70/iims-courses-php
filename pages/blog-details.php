<?php
/**
 * pages/blog-details.php  ←→  src/routes/blogs.$slug.tsx  (BlogDetail)
 */
session_start();
require_once '../data/iims.php';

$slug = trim($_GET['slug'] ?? '');
$b    = getBlog($slug);

if (!$b) {
  header('HTTP/1.0 404 Not Found');
  $page_title = 'Blog Not Found';
  include '../includes/header.php';
  include '../components/Navbar.php';
  echo '<div class="pt-32 text-center">Blog not found.</div>';
  include '../components/Footer.php';
  include '../includes/footer.php';
  exit;
}

$page_title       = $b['title'] . ' — IIMs Courses';
$page_og_image    = $b['image'];
$current_page     = 'blogs';
$comments = [
  [
    'name'   => 'Riya P.',
    'avatar' => 'R',
    'image'  => '../assets/images/courses/data-science-decision.webp',
    'date'   => '2 days ago',
    'text'   => 'This is gold. Saved me weeks of prep! The section-wise breakdown is exactly what I needed for my CAT 2026 strategy.'
  ],

  [
    'name'   => 'Manish K.',
    'avatar' => 'M',
    'image'  => '../assets/images/courses/pgp-luxury-brand.webp',
    'date'   => '5 days ago',
    'text'   => 'Perfectly timed for CAT 2026 aspirants. The WAT-PI section alone is worth bookmarking.'
  ],

  [
    'name'   => 'Priya S.',
    'avatar' => 'P',
    'image'  => '../assets/images/courses/fpm-doctoral.webp',
    'date'   => '1 week ago',
    'text'   => 'Shared this with my entire study group. The mock-test discipline tips are game changers!'
  ],
];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment_name']) && !empty($_POST['comment_text'])) {
  array_unshift($comments, [
    'name'   => htmlspecialchars(trim($_POST['comment_name'])),
    'avatar' => strtoupper(substr(trim($_POST['comment_name']), 0, 1)),
    'date'   => 'Just now',
    'text'   => htmlspecialchars(trim($_POST['comment_text'])),
  ]);
}

$read_time = max(5, round(str_word_count($b['excerpt'] ?? '') / 200)) + 6;

include '../includes/header.php';
include '../components/Navbar.php';
?>

<style>
/* ─── BLOG DETAIL PAGE STYLES ──────────────────────────────────────────────── */

/* Reading progress bar */
#reading-progress {
  position: fixed;
  top: 0;
  left: 0;
  width: 0%;
  height: 3px;
  background: linear-gradient(90deg, var(--color-accent, #e25c2a), var(--color-primary, #1a3c6e));
  z-index: 9999;
  transition: width 0.1s linear;
}

/* ── Hero ── */
.bd-hero {
  position: relative;
  min-height: 420px;
  height: 58vh;
  overflow: hidden;
}
.bd-hero__img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  filter: brightness(.6);
  transform: scale(1.06);
  transition: transform 8s ease;
}
.bd-hero__img.loaded { transform: scale(1); }
.bd-hero__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to top,
    rgba(0,0,0,.92) 0%,
    rgba(0,0,0,.55) 45%,
    rgba(0,0,0,.15) 100%
  );
}
.bd-hero__content {
  position: relative;
  z-index: 2;
  height: 100%;
  max-width: 900px;
  margin: auto;
  padding: 0 24px 52px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  color: #fff;
}
.bd-hero__tags {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  margin-bottom: 14px;
}
.bd-hero__tag {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  padding: 4px 12px;
  border-radius: 999px;
  background: rgba(255,255,255,.15);
  border: 1px solid rgba(255,255,255,.25);
  backdrop-filter: blur(8px);
  color: #fff;
}
.bd-hero__meta {
  display: flex;
  align-items: center;
  gap: 16px;
  font-size: 13px;
  color: rgba(255,255,255,.75);
  margin-bottom: 14px;
  flex-wrap: wrap;
}
.bd-hero__meta-dot { opacity: .4; }
.bd-hero__title {
  /* font-size: clamp(1.75rem, 4vw, 3.25rem); */
  font-size: 4rem
  line-height: 1.15;
  font-weight: 800;
  margin: 0 0 18px;
  letter-spacing: -.02em;
}
.bd-hero__excerpt {
  font-size: clamp(.9rem, 1.5vw, 1.1rem);
  color: rgba(255,255,255,.8);
  line-height: 1.65;
  max-width: 680px;
  margin: 0;
}

/* ── Sticky sidebar layout ── */
.bd-layout {
  max-width: 1240px;
  margin: 0 auto;
  padding: 48px 24px 80px;
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 48px;
  align-items: start;
}
@media (max-width: 960px) {
  .bd-layout { grid-template-columns: 1fr; }
}

/* ── Article body ── */
.bd-article {
  min-width: 0;
}

/* Article prose */
.bd-prose {
  line-height: 1.8;
  font-size: 1.05rem;
  color: var(--foreground);
}
.bd-prose h2 {
  font-size: 1.6rem;
  font-weight: 800;
  margin: 2.5rem 0 1rem;
  letter-spacing: -.02em;
  line-height: 1.2;
  color: var(--foreground);
}
.bd-prose h3 {
  font-size: 1.2rem;
  font-weight: 700;
  margin: 2rem 0 .75rem;
  color: var(--foreground);
}
.bd-prose p {
  margin: 0 0 1.4rem;
  color: var(--muted-foreground, #555);
}
.bd-prose ul, .bd-prose ol {
  padding-left: 1.5rem;
  margin: 0 0 1.4rem;
}
.bd-prose li {
  margin-bottom: .6rem;
  color: var(--muted-foreground, #555);
}
.bd-prose strong { color: var(--foreground); font-weight: 700; }
.bd-prose a { color: var(--color-accent, #e25c2a); text-decoration: underline; }

/* Pull quote */
.bd-pullquote {
  border-left: 4px solid var(--color-accent, #e25c2a);
  padding: 16px 24px;
  margin: 2rem 0;
  background: var(--card);
  border-radius: 0 12px 12px 0;
  font-size: 1.15rem;
  font-style: italic;
  font-weight: 600;
  line-height: 1.6;
  color: var(--foreground);
}

/* Key stats strip */
.bd-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin: 0.5rem 0;
}
@media (max-width: 600px) {
  .bd-stats { grid-template-columns: 1fr 1fr; }
}
.bd-stat-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 20px 16px;
  text-align: center;
}
.bd-stat-card__num {
  font-size: 2rem;
  font-weight: 700;
  letter-spacing: -.04em;
  color: var(--color-accent, #e25c2a);
  display: block;
}
.bd-stat-card__label {
  font-size: 12px;
  color: var(--muted-foreground);
  margin-top: 4px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: .06em;
}

/* Tip box */
.bd-tip {
  display: flex;
  gap: 14px;
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 20px;
  margin: 2rem 0;
}
.bd-tip__icon {
  flex-shrink: 0;
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: linear-gradient(135deg, #e25c2a22, #e25c2a11);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
}
.bd-tip__body { min-width: 0; }
.bd-tip__title { font-weight: 700; font-size: .9rem; margin-bottom: 4px; }
.bd-tip__text  { font-size: .875rem; color: var(--muted-foreground); line-height: 1.65; margin: 0; }

/* Checklist */
.bd-checklist {
  list-style: none;
  padding: 0;
  margin: 1.5rem 0;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.bd-checklist li {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  font-size: .95rem;
  color: var(--muted-foreground);
  line-height: 1.6;
}
.bd-checklist li::before {
  content: '';
  flex-shrink: 0;
  margin-top: 4px;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background: linear-gradient(135deg, #e25c2a, #c8401a);
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: center;
  background-size: 10px;
}

/* Timeline */
.bd-timeline {
  position: relative;
  padding-left: 28px;
  margin: 1.5rem 0;
  border-left: 2px solid var(--border);
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.bd-timeline__item {
  position: relative;
}
.bd-timeline__item::before {
  content: '';
  position: absolute;
  left: -35px;
  top: 4px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: var(--color-accent, #e25c2a);
  border: 2px solid var(--background);
  box-shadow: 0 0 0 2px var(--color-accent, #e25c2a);
}
.bd-timeline__month {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--color-accent, #e25c2a);
  margin-bottom: 4px;
}
.bd-timeline__heading {
  font-size: .95rem;
  font-weight: 700;
  margin-bottom: 4px;
  color: var(--foreground);
}
.bd-timeline__text {
  font-size: .875rem;
  color: var(--muted-foreground);
  line-height: 1.6;
  margin: 0;
}

/* Author card */
.bd-author-card {
  display: flex;
  gap: 16px;
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 24px;
  margin: 3rem 0;
}
.bd-author-card__avatar {
  flex-shrink: 0;
  width: 64px;
  height: 64px;
  border-radius: 50%;
  object-fit: cover;
  background: linear-gradient(135deg, #e25c2a, #1a3c6e);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  font-weight: 800;
  color: #fff;
}
.bd-author-card__name { font-weight: 800; font-size: 1rem; margin-bottom: 2px; }
.bd-author-card__role { font-size: .8rem; color: var(--color-accent, #e25c2a); font-weight: 600; margin-bottom: 8px; }
.bd-author-card__bio  { font-size: .875rem; color: var(--muted-foreground); line-height: 1.65; margin: 0; }

/* Tags section */
.bd-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin: 2rem 0;
}
.bd-tag {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 14px;
  border-radius: 999px;
  background: var(--muted);
  color: var(--muted-foreground);
  border: 1px solid var(--border);
  cursor: pointer;
  transition: all .2s;
  text-decoration: none;
}
.bd-tag:hover {
  background: var(--color-accent, #e25c2a);
  color: #fff;
  border-color: transparent;
}

/* Comments */
.bd-comments { margin: 3rem 0; }
.bd-comments__header {
  font-size: 1.35rem;
  font-weight: 800;
  margin-bottom: 24px;
  letter-spacing: -.02em;
}
.bd-comment-form {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 24px;
  margin-bottom: 28px;
  display: grid;
  gap: 12px;
}
.bd-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
@media (max-width: 600px) { .bd-form-row { grid-template-columns: 1fr; } }
.bd-input {
  border-radius: 10px;
  border: 1px solid var(--border);
  background: var(--background);
  padding: 10px 14px;
  font-size: .9rem;
  width: 100%;
  box-sizing: border-box;
  color: var(--foreground);
  transition: border-color .2s;
  font-family: inherit;
}
.bd-input:focus {
  outline: none;
  border-color: var(--color-accent, #e25c2a);
  box-shadow: 0 0 0 3px rgba(226,92,42,.12);
}
.bd-textarea { resize: vertical; min-height: 100px; }

.bd-comment-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
  list-style: none;
  padding: 0;
  margin: 0;
}
.bd-comment {
  display: flex;
  gap: 14px;
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 18px;
}
.bd-comment__avatar {
  flex-shrink: 0;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(135deg, #e25c2a, #1a3c6e);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  font-weight: 800;
  color: #fff;
}

.bd-comment__avatar-img{
  width:100%;
  height:100%;
  object-fit:cover;
  border-radius: 50%;
  display:block;
}
.bd-comment__header { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; }
.bd-comment__name   { font-weight: 700; font-size: .9rem; }
.bd-comment__date   { font-size: .78rem; color: var(--muted-foreground); }
.bd-comment__text   { font-size: .875rem; color: var(--muted-foreground); line-height: 1.65; margin: 0; }

/* Recommended reads */
.bd-recommended { margin: 3rem 0 0; }
.bd-recommended__header { font-size: 1.35rem; font-weight: 800; margin-bottom: 24px; letter-spacing: -.02em; }
.bd-rec-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 16px;
  list-style: none;
  padding: 0;
  margin: 0;
}
.bd-rec-card {
  display: flex;
  flex-direction: column;
  text-decoration: none;
  color: inherit;
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 14px;
  overflow: hidden;
  transition: transform .2s, box-shadow .2s;
}
.bd-rec-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 32px rgba(0,0,0,.12);
}
.bd-rec-card__img {
  width: 100%;
  height: 120px;
  object-fit: cover;
}
.bd-rec-card__body { padding: 14px; }
.bd-rec-card__title { font-weight: 600; font-size: .85rem; line-height: 1.45; margin-bottom: 6px; }
.bd-rec-card__date  { font-size: .75rem; color: var(--muted-foreground); }

/* ── Sidebar ── */
.bd-sidebar { display: flex; flex-direction: column; gap: 24px; }
.bd-sidebar-widget {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 22px;
}
.bd-sidebar-widget__title {
  font-size: .8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: var(--muted-foreground);
  margin-bottom: 16px;
}

/* TOC */
.bd-toc { display: flex; flex-direction: column; gap: 8px; }
.bd-toc__link {
  font-size: .875rem;
  color: var(--muted-foreground);
  text-decoration: none;
  padding: 6px 10px;
  border-radius: 8px;
  transition: all .2s;
  display: flex;
  align-items: center;
  gap: 8px;
  border-left: 2px solid transparent;
}
.bd-toc__link::before { content: ''; flex-shrink: 0; width: 6px; height: 6px; border-radius: 50%; background: var(--border); transition: background .2s; }
.bd-toc__link:hover, .bd-toc__link.active { color: var(--color-accent, #e25c2a); border-left-color: var(--color-accent, #e25c2a); background: rgba(226,92,42,.06); }
.bd-toc__link:hover::before, .bd-toc__link.active::before { background: var(--color-accent, #e25c2a); }

/* CTA widget */
.bd-cta-widget {
  background: linear-gradient(135deg, #1a3c6e, #0f2548);
  border: none;
  color: #fff;
  text-align: center;
}
.bd-cta-widget .bd-sidebar-widget__title { color: rgba(255,255,255,.6); }
.bd-cta-widget__heading { font-size: 1.15rem; font-weight: 800; margin: 0 0 8px; }
.bd-cta-widget__text    { font-size: .85rem; color: rgba(255,255,255,.75); margin: 0 0 18px; line-height: 1.6; }

/* Share widget */
.bd-share-btns { display: flex; flex-direction: column; gap: 8px; }
.bd-share-btn {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 14px;
  border-radius: 10px;
  border: 1px solid var(--border);
  background: transparent;
  font-size: .85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all .2s;
  color: var(--foreground);
  text-decoration: none;
}
.bd-share-btn:hover { background: var(--muted); }
.bd-share-btn--wa:hover  { background: #25d36611; border-color: #25d366; color: #25d366; }
.bd-share-btn--tw:hover  { background: #1da1f211; border-color: #1da1f2; color: #1da1f2; }
.bd-share-btn--li:hover  { background: #0a66c211; border-color: #0a66c2; color: #0a66c2; }

/* Popular posts */
.bd-popular { display: flex; flex-direction: column; gap: 12px; }
.bd-popular__item {
  display: flex;
  gap: 12px;
  text-decoration: none;
  color: inherit;
}
.bd-popular__img {
  flex-shrink: 0;
  width: 52px;
  height: 52px;
  border-radius: 10px;
  object-fit: cover;
}
.bd-popular__title { font-size: .82rem; font-weight: 600; line-height: 1.4; margin-bottom: 3px; }
.bd-popular__date  { font-size: .72rem; color: var(--muted-foreground); }
.bd-popular__item:hover .bd-popular__title { color: var(--color-accent, #e25c2a); }

/* Sticky sidebar */
@media (min-width: 961px) {
  .bd-sidebar { position: sticky; top: 90px; }
}

/* Divider */
.bd-divider { border: none; border-top: 1px solid var(--border); margin: 2.5rem 0; }

/* Back to blogs */
.bd-back {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: .875rem;
  font-weight: 600;
  color: var(--muted-foreground);
  text-decoration: none;
  padding: 8px 16px;
  border-radius: 999px;
  border: 1px solid var(--border);
  background: var(--card);
  transition: all .2s;
  margin-bottom: 20px;
  display: inline-flex;
}
.bd-back:hover { color: var(--foreground); border-color: var(--muted-foreground); }

/* Scroll to top */
#scroll-top {
  position: fixed;
  bottom: 32px;
  right: 24px;
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
  box-shadow: 0 4px 16px rgba(226,92,42,.4);
  z-index: 999;
  transition: transform .2s, opacity .2s;
}
#scroll-top.visible { display: flex; }
#scroll-top:hover { transform: translateY(-2px); }

/* Responsive tweaks */
@media (max-width: 640px) {
  .bd-hero__content { padding: 0 16px 36px; }
  .bd-layout { padding: 32px 16px 60px; }
  .bd-comment { flex-direction: column; gap: 10px; }
}
</style>

<!-- Reading progress bar -->
<div id="reading-progress"></div>

<!-- ── HERO ──────────────────────────────────────────────────────────────── -->
<section class="bd-hero">
  <img
    class="bd-hero__img"
    src="../<?= ltrim($b['image'], '/') ?>"
    alt="<?= htmlspecialchars($b['title']) ?>"
    onload="this.classList.add('loaded')"
  >
  <div class="bd-hero__overlay"></div>
  <div class="bd-hero__content">
    <div class="bd-hero__tags">
      <span class="bd-hero__tag">IIM Admissions</span>
      <span class="bd-hero__tag">CAT 2026</span>
      <span class="bd-hero__tag">Strategy</span>
    </div>
    <div class="bd-hero__meta">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      <?= htmlspecialchars($b['date']) ?>
      <span class="bd-hero__meta-dot">•</span>
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      <?= htmlspecialchars($b['author']) ?>
      <span class="bd-hero__meta-dot">•</span>
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      <?= $read_time ?> min read
    </div>
    <h1 class="bd-hero__title"><?= htmlspecialchars($b['title']) ?></h1>
    <p class="bd-hero__excerpt"><?= htmlspecialchars($b['excerpt']) ?></p>
  </div>
</section>

<!-- ── MAIN LAYOUT ────────────────────────────────────────────────────────── -->
<div class="bd-layout">

  <!-- ── LEFT: ARTICLE ───────────────────────────────────────────────────── -->
  <main class="bd-article">

    <!-- Back link -->
    <a href="blogs.php" class="bd-back">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
      Back to Blogs
    </a>

    <!-- ── ARTICLE BODY ─────────────────────────────────────────────────── -->
    <div class="bd-prose">

      <!-- Key stats -->
      <div class="bd-stats">
        <div class="bd-stat-card">
          <span class="bd-stat-card__num">21</span>
          <span class="bd-stat-card__label">IIMs in India</span>
        </div>
        <div class="bd-stat-card">
          <span class="bd-stat-card__num">3L+</span>
          <span class="bd-stat-card__label">CAT Registrations</span>
        </div>
        <div class="bd-stat-card">
          <span class="bd-stat-card__num">99%ile</span>
          <span class="bd-stat-card__label">IIM-A Cutoff</span>
        </div>
      </div>

      <h2 id="overview">Overview: What It Really Takes</h2>
      <p>
        Getting into an IIM is one of the most competitive academic pursuits in India. With over three lakh aspirants
        vying for fewer than ten thousand seats across all IIMs combined, the selection process is rigorous, multi-layered
        and rewards <strong>consistent, structured preparation</strong> over last-minute sprints.
      </p>
      <p>
        This guide synthesises insights from recent IIM converts, admission consultants and academic coaches to give you
        a battle-tested roadmap — whether you're starting from scratch twelve months out or fine-tuning in the final lap.
      </p>

      <div class="bd-pullquote">
        "The CAT score is just the entry ticket. Your profile, your story, and how you articulate your journey in the
        WAT-PI room is what closes the deal."
        <br><span style="font-size:.85rem;font-weight:500;opacity:.7;">— IIM Ahmedabad Alumnus, Batch of 2024</span>
      </div>

      <h2 id="cat-strategy">Section-Wise CAT Strategy</h2>
      <p>
        The Common Admission Test (CAT) is divided into three sections. Each demands a different mindset and preparation
        approach. Here's how top scorers tackle them:
      </p>

      <h3>1. Verbal Ability & Reading Comprehension (VARC)</h3>
      <p>
        VARC is the great differentiator at the 99th percentile. Most high scorers are strong in Quant but stumble here.
        The key is <strong>reading broadly and daily</strong> — editorials, long-form essays, academic journals.
      </p>
      <ul class="bd-checklist">
        <li>Read 2–3 long-form articles (1500+ words) every single day without exception</li>
        <li>Practise RC passages under timed conditions with a 10-minute cap per set</li>
        <li>Identify the author's tone and logical structure — CAT RC is about inference, not memory</li>
        <li>For Para-Jumbles, look for pronoun references, transitional phrases and thematic flow</li>
        <li>Attempt VA questions first in the section — they're quicker and build momentum</li>
      </ul>

      <h3>2. Data Interpretation & Logical Reasoning (DILR)</h3>
      <p>
        DILR rewards pattern recognition and calm prioritisation under time pressure. The ability to quickly
        <strong>triage sets</strong> — deciding which to solve and which to skip — is a skill in itself.
      </p>
      <div class="bd-tip">
        <div class="bd-tip__icon">💡</div>
        <div class="bd-tip__body">
          <div class="bd-tip__title">Pro Tip: The 2-Minute Rule</div>
          <p class="bd-tip__text">
            Spend no more than 2 minutes on the first question of any DILR set. If you can't establish the setup
            clearly, move on. Returning to a set with fresh eyes often unlocks it in half the time.
          </p>
        </div>
      </div>

      <h3>3. Quantitative Ability (QA)</h3>
      <p>
        QA is the most learnable section. With disciplined practice and concept mastery, a 90%ile in QA
        is achievable for anyone with Class 10 maths. The real battle is accuracy over speed.
      </p>
      <ul class="bd-checklist">
        <li>Master Arithmetic first — it contributes 40–50% of QA questions consistently</li>
        <li>Geometry and Number Theory are high-ROI if you're targeting 95%ile+</li>
        <li>Always verify answers using an alternative method or back-substitution</li>
        <li>Practise 30 questions daily under exam conditions from August onwards</li>
      </ul>

      <hr class="bd-divider">

      <h2 id="mock-tests">The Mock-Test Discipline Framework</h2>
      <p>
        Top IIM converters uniformly cite mock tests as the single biggest contributor to their score improvement —
        not the mocks themselves, but the quality of their <strong>post-mock analysis</strong>.
      </p>

      <div class="bd-tip">
        <div class="bd-tip__icon">📊</div>
        <div class="bd-tip__body">
          <div class="bd-tip__title">The 1:2 Rule of Mock Tests</div>
          <p class="bd-tip__text">
            For every hour spent taking a mock, spend two hours analysing it. Log every mistake, categorise it
            (concept gap, silly error, time mismanagement) and revisit the concept before the next mock.
          </p>
        </div>
      </div>

      <p>
        Aim for at least <strong>30–40 full-length mocks</strong> between July and November. Begin with one mock per
        week, ramp to two in September and three per week in October. Use at least three different test series
        for variety in question patterns.
      </p>

      <hr class="bd-divider">

      <h2 id="preparation-calendar">12-Month Preparation Calendar</h2>
      <p>
        Here's a month-by-month roadmap for a candidate starting in January with the CAT in November:
      </p>

      <div class="bd-timeline">
        <div class="bd-timeline__item">
          <div class="bd-timeline__month">Jan – Mar</div>
          <div class="bd-timeline__heading">Foundation Building</div>
          <p class="bd-timeline__text">Master fundamentals in all three sections. Complete one standard book per topic. Begin daily reading habit. Attempt sectional tests weekly.</p>
        </div>
        <div class="bd-timeline__item">
          <div class="bd-timeline__month">Apr – Jun</div>
          <div class="bd-timeline__heading">Concept Deepening</div>
          <p class="bd-timeline__text">Focus on weak areas identified from sectional tests. Introduce advanced problem sets. Start the first full-length mock. Maintain a 100-word daily vocabulary log.</p>
        </div>
        <div class="bd-timeline__item">
          <div class="bd-timeline__month">Jul – Sep</div>
          <div class="bd-timeline__heading">Intensive Mock Phase</div>
          <p class="bd-timeline__text">Two mocks per week with rigorous analysis. Stabilise accuracy percentages. Work on time management and question prioritisation strategy.</p>
        </div>
        <div class="bd-timeline__item">
          <div class="bd-timeline__month">Oct – Nov</div>
          <div class="bd-timeline__heading">Peak Performance Sprint</div>
          <p class="bd-timeline__text">Three mocks per week. Focus entirely on consistency and exam temperament. Avoid new topics. Sleep and health are non-negotiable during this phase.</p>
        </div>
        <div class="bd-timeline__item">
          <div class="bd-timeline__month">Dec – Jan</div>
          <div class="bd-timeline__heading">WAT-PI Preparation</div>
          <p class="bd-timeline__text">Begin GD/WAT/PI coaching. Polish your SOP and academic profile. Research your target IIMs thoroughly — panelists appreciate informed candidates.</p>
        </div>
      </div>

      <hr class="bd-divider">

      <h2 id="wat-pi">Cracking the WAT-PI Process</h2>
      <p>
        The Written Ability Test and Personal Interview together contribute significantly to final composite scores,
        especially at IIM-A, B and C where the interview weightage can be as high as 50%.
      </p>

      <h3>Written Ability Test (WAT)</h3>
      <p>
        A 200–300 word essay on a current affairs or abstract topic. Clarity of argument and crisp writing
        beat elaborate vocabulary. Structure your essay as: <strong>Context → Your stand → Arguments → Counter-argument
        → Conclusion</strong>.
      </p>

      <h3>Personal Interview (PI)</h3>
      <p>
        The PI is a structured conversation about <em>you</em> — your academics, work experience, goals and worldview.
        Common themes across IIM panels include:
      </p>
      <ul class="bd-checklist">
        <li>"Walk me through your profile" — prepare a 90-second pitch that's honest and compelling</li>
        <li>Expect deep dives into your graduation subject — engineering, commerce or humanities alike</li>
        <li>Know 2–3 current affairs topics in depth; breadth without depth will be exposed</li>
        <li>Your "Why MBA" and "Why IIM X" answers must be specific — generic answers disappoint panels</li>
        <li>Practise with mock PIs — at least 10 sessions with strangers or seniors, not just friends</li>
      </ul>

      <div class="bd-tip">
        <div class="bd-tip__icon">🎯</div>
        <div class="bd-tip__body">
          <div class="bd-tip__title">The One Question You Must Nail</div>
          <p class="bd-tip__text">
            "What makes you different from the 500 other candidates with a 99%ile we've seen today?"
            Prepare a specific, authentic answer — a genuine achievement, a unique perspective, or an unusual
            journey. This is your differentiator moment.
          </p>
        </div>
      </div>

      <hr class="bd-divider">

      <h2 id="profile-building">Profile Building Beyond Scores</h2>
      <p>
        IIMs increasingly weigh the holistic profile — work experience quality, extracurriculars, diversity of
        background and academic consistency. Here's what stands out in applications:
      </p>

      <div class="bd-stats" style="grid-template-columns:repeat(2,1fr);">
        <div class="bd-stat-card">
          <span class="bd-stat-card__num">24–30</span>
          <span class="bd-stat-card__label">Ideal Work-Ex (months)</span>
        </div>
        <div class="bd-stat-card">
          <span class="bd-stat-card__num">7+</span>
          <span class="bd-stat-card__label">Min CGPA (out of 10)</span>
        </div>
      </div>

      <p>
        Candidates with leadership roles in student bodies, published research, sports representation at state/national
        level, or meaningful social impact projects consistently receive preference in shortlisting criteria that
        considers diversity and "non-traditional" academic profiles.
      </p>

    </div>
    <!-- end .bd-prose -->

    <!-- Tags -->
    <div class="bd-tags">
      <?php foreach (['CAT 2026','IIM Admissions','MBA Preparation','Study Strategy','WAT-PI','Mock Tests','IIM Shortlist'] as $tag): ?>
        <a href="blogs.php?tag=<?= urlencode($tag) ?>" class="bd-tag">#<?= $tag ?></a>
      <?php endforeach; ?>
    </div>

    <!-- Author card -->
    <div class="bd-author-card">
      <div class="bd-author-card__avatar"><?= strtoupper(substr($b['author'] ?? 'A', 0, 1)) ?></div>
      <div>
        <div class="bd-author-card__name"><?= htmlspecialchars($b['author']) ?></div>
        <div class="bd-author-card__role">Senior Admission Strategist &amp; CAT Mentor</div>
        <p class="bd-author-card__bio">
          A seasoned educator and IIM alumnus with over 8 years of experience guiding MBA aspirants.
          He has helped 500+ students secure admits at IIM-A, B, C and other top B-schools.
          His work focuses on holistic profile building and WAT-PI excellence.
        </p>
      </div>
    </div>

    <hr class="bd-divider">

    <!-- Comments -->
    <section class="bd-comments">
      <h3 class="bd-comments__header">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:8px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        Comments (<?= count($comments) ?>)
      </h3>

      <!-- Comment form -->
      <form
        class="bd-comment-form"
        method="POST"
        action="blog-details.php?slug=<?= urlencode($slug) ?>"
      >
        <div class="bd-form-row">
          <input type="text"  name="comment_name"  class="bd-input" placeholder="Your name"  required>
          <input type="email" name="comment_email" class="bd-input" placeholder="Email (not published)">
        </div>
        <textarea name="comment_text" class="bd-input bd-textarea" placeholder="Share your thoughts, questions or experience…" required></textarea>
        <button type="submit" class="btn btn-hero btn-sm" style="width:fit-content;">Post Comment</button>
      </form>

      <!-- Comments list -->
      <ul class="bd-comment-list">
        <?php foreach ($comments as $c): ?>
        <li class="bd-comment">
          <div class="bd-comment__avatar">
  <img 
    src="<?= htmlspecialchars($c['image']) ?>" 
    alt="<?= htmlspecialchars($c['name']) ?>"
    class="bd-comment__avatar-img"
    loading="lazy"
  >
</div>
          <div style="flex:1;min-width:0;">
            <div class="bd-comment__header">
              <span class="bd-comment__name"><?= htmlspecialchars($c['name']) ?></span>
              <span class="bd-comment__date"><?= htmlspecialchars($c['date']) ?></span>
            </div>
            <p class="bd-comment__text"><?= htmlspecialchars($c['text']) ?></p>
            <button style="font-size:.78rem;color:var(--muted-foreground);background:none;border:none;cursor:pointer;padding:4px 0;margin-top:4px;" onclick="this.textContent=this.textContent==='👍 Helpful'?'Helpful (1)':'👍 Helpful'">👍 Helpful</button>
          </div>
        </li>
        <?php endforeach; ?>
      </ul>
    </section>

    <hr class="bd-divider">
<!-- Recommended reads -->
<section class="bd-recommended">
  <h3 class="bd-recommended__header">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:8px;"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
    Recommended Reads
  </h3>

  <ul class="bd-rec-grid">
    <?php
    $recommended = array_values(array_filter($BLOGS, fn($x) => $x['slug'] !== $slug));
    $recommended = array_slice($recommended, 0, 4);

    foreach ($recommended as $r):

      $imgPath = strpos($r['image'], '../') === 0
          ? $r['image']
          : '../' . ltrim($r['image'], '/');
    ?>

    <li>
      <a href="blog-details.php?slug=<?= urlencode($r['slug']) ?>" class="bd-rec-card">

        <img
          src="<?= htmlspecialchars($imgPath) ?>"
          alt="<?= htmlspecialchars($r['title']) ?>"
          class="bd-rec-card__img"
          loading="lazy"
        >

        <div class="bd-rec-card__body">
          <div class="bd-rec-card__title">
            <?= htmlspecialchars($r['title']) ?>
          </div>

          <div class="bd-rec-card__date">
            <?= htmlspecialchars($r['date']) ?>
          </div>
        </div>

      </a>
    </li>

    <?php endforeach; ?>
  </ul>
</section></a>

  </main>

  <!-- ── RIGHT: SIDEBAR ──────────────────────────────────────────────────── -->
  <aside class="bd-sidebar">

    <!-- Table of contents -->
    <div class="bd-sidebar-widget">
      <div class="bd-sidebar-widget__title">In This Article</div>
      <nav class="bd-toc">
        <a href="#overview"            class="bd-toc__link">Overview</a>
        <a href="#cat-strategy"        class="bd-toc__link">CAT Section Strategy</a>
        <a href="#mock-tests"          class="bd-toc__link">Mock-Test Framework</a>
        <a href="#preparation-calendar" class="bd-toc__link">12-Month Calendar</a>
        <a href="#wat-pi"              class="bd-toc__link">WAT-PI Process</a>
        <a href="#profile-building"    class="bd-toc__link">Profile Building</a>
      </nav>
    </div>

    <!-- CTA widget -->
    <div class="bd-sidebar-widget bd-cta-widget">
      <div class="bd-sidebar-widget__title">Get Expert Help</div>
      <div class="bd-cta-widget__heading">Free IIM Counselling Session</div>
      <p class="bd-cta-widget__text">Get personalised guidance from our IIM alumni mentors. 500+ successful admits last year.</p>
      <button class="btn btn-hero" onclick="openApplyModal()" style="width:100%;">Apply Now — It's Free</button>
    </div>

    <!-- Share widget -->
    <div class="bd-sidebar-widget">
      <div class="bd-sidebar-widget__title">Share This Article</div>
      <div class="bd-share-btns">
        <a
          class="bd-share-btn bd-share-btn--wa"
          href="https://api.whatsapp.com/send?text=<?= urlencode($b['title'] . ' — ' . 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
          target="_blank" rel="noopener"
        >
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          Share on WhatsApp
        </a>
        <a
          class="bd-share-btn bd-share-btn--tw"
          href="https://twitter.com/intent/tweet?text=<?= urlencode($b['title']) ?>&url=<?= urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
          target="_blank" rel="noopener"
        >
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          Share on X (Twitter)
        </a>
        <a
          class="bd-share-btn bd-share-btn--li"
          href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
          target="_blank" rel="noopener"
        >
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
          Share on LinkedIn
        </a>
        <button class="bd-share-btn" onclick="copyLink(this)">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
          Copy Link
        </button>
      </div>
    </div>

    <!-- Popular posts -->
    <div class="bd-sidebar-widget">
      <div class="bd-sidebar-widget__title">Popular Articles</div>
      <div class="bd-popular">
        <?php
        $popular = array_values(array_filter($BLOGS, fn($x) => $x['slug'] !== $slug));
        $popular = array_slice($popular, 0, 3);
        foreach ($popular as $p):
        ?>
        <a href="blog-details.php?slug=<?= urlencode($p['slug']) ?>" class="bd-popular__item">
          <?php
$imgPath = strpos($p['image'], '../') === 0
    ? $p['image']
    : '../' . ltrim($p['image'], '/');
?>

<img 
  src="<?= htmlspecialchars($imgPath) ?>" 
  alt="<?= htmlspecialchars($p['title']) ?>" 
  class="bd-popular__img" 
  loading="lazy"
>
          <div>
            <div class="bd-popular__title"><?= htmlspecialchars($p['title']) ?></div>
            <div class="bd-popular__date"><?= htmlspecialchars($p['date']) ?></div>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Newsletter widget -->
    <div class="bd-sidebar-widget">
      <div class="bd-sidebar-widget__title">Stay Updated</div>
      <p style="font-size:.85rem;color:var(--muted-foreground);margin:0 0 14px;line-height:1.6;">
        Get weekly IIM insights, CAT tips and admission alerts straight to your inbox.
      </p>
      <form onsubmit="return handleNewsletterSubmit(this)" style="display:flex;flex-direction:column;gap:8px;">
        <input type="email" class="bd-input" placeholder="your@email.com" required>
        <button type="submit" class="btn btn-hero btn-sm">Subscribe Free</button>
      </form>
    </div>

  </aside>

</div>

<!-- ============================================================
     FINAL CTA
     ============================================================ -->
<section class="py-3">
  <div class="container">

    <div class="cta-pro position-relative overflow-hidden rounded-5 p-4 p-lg-5">

      <!-- Glow -->
      <div class="cta-glow"></div>

      <!-- <div class="center-cta d-flex"> -->
        <div class="row align-items-center g-4 position-relative" style="z-index:2;">
          <!-- Left Content -->
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
</div>        </div>
      <!-- </div> -->

    </div>
</section>
<!-- Scroll to top button -->
<button id="scroll-top" title="Back to top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<!-- ── SCRIPTS ─────────────────────────────────────────────────────────────── -->
<script>
/* Reading progress */
(function() {
  var bar = document.getElementById('reading-progress');
  window.addEventListener('scroll', function() {
    var d = document.documentElement;
    var scrollTop = d.scrollTop || document.body.scrollTop;
    var total = d.scrollHeight - d.clientHeight;
    bar.style.width = (total > 0 ? (scrollTop / total * 100) : 0) + '%';
  }, { passive: true });
})();

/* Like toggle */
var liked = false;
var likes = <?= (int)($b['likes'] ?? 248) ?>;
function toggleLike() {
  liked = !liked;
  likes += liked ? 1 : -1;
  document.getElementById('like-count').textContent = likes;
  var btn  = document.getElementById('like-btn');
  var icon = document.getElementById('like-icon');
  if (liked) {
    btn.classList.add('liked');
    icon.setAttribute('fill', 'currentColor');
    btn.querySelector('span').textContent = likes;
  } else {
    btn.classList.remove('liked');
    icon.setAttribute('fill', 'none');
  }
}

/* Copy link */
function copyLink(el) {
  navigator.clipboard && navigator.clipboard.writeText(location.href);
  var orig = el.innerHTML;
  el.innerHTML = el.innerHTML.replace(/Copy Link|Share/, '✓ Copied!');
  setTimeout(function(){ el.innerHTML = orig; }, 2000);
}

/* Bookmark toggle */
function bookmarkToggle(btn) {
  var saved = btn.getAttribute('data-saved') === '1';
  btn.setAttribute('data-saved', saved ? '0' : '1');
  btn.querySelector('svg').setAttribute('fill', saved ? 'none' : 'currentColor');
  btn.innerHTML = btn.innerHTML.replace(/Save|Saved/, saved ? 'Save' : 'Saved');
}

/* Newsletter */
function handleNewsletterSubmit(form) {
  var btn = form.querySelector('button');
  btn.textContent = '✓ Subscribed!';
  btn.disabled = true;
  form.querySelector('input').value = '';
  return false;
}

/* Scroll to top visibility */
window.addEventListener('scroll', function() {
  var btn = document.getElementById('scroll-top');
  btn.classList.toggle('visible', window.scrollY > 400);
}, { passive: true });

/* TOC active state */
(function() {
  var headings = document.querySelectorAll('.bd-prose h2[id]');
  var links = document.querySelectorAll('.bd-toc__link');
  if (!headings.length || !links.length) return;
  var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        links.forEach(function(l) { l.classList.remove('active'); });
        var active = document.querySelector('.bd-toc__link[href="#' + entry.target.id + '"]');
        if (active) active.classList.add('active');
      }
    });
  }, { rootMargin: '-20% 0px -70% 0px' });
  headings.forEach(function(h) { observer.observe(h); });
})();
</script>

<?php
include '../components/Modals.php';
include '../components/Footer.php';
include '../includes/footer.php';
?>