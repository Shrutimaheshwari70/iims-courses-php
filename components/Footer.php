<?php
/**
 * components/Footer.php
 * PHP conversion of src/components/Footer.tsx
 *
 * FIX: All hrefs use $__assetBase (set in header.php) so links work
 * from both root pages AND pages/ subfolder pages.
 */

// Re-detect base in case header wasn't included
if (!isset($__assetBase)) {
  $__script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
  $__parts = explode('/', trim($__script, '/'));
  $__assetBase = '/' . $__parts[0] . '/';
}
$b = $__assetBase; // shorthand
?>
<style>
  /* ---------- FOOTER ---------- */

  /* ── Footer shell ────────────────────────────────────────── */
  footer.site-footer {
    background: var(--navy-footer);
    color: var(--text-muted-footer);
    font-size: .875rem;
  }


  /* ── Main grid area ──────────────────────────────────────── */
  .footer-main {
    padding: 3.5rem 0 2.5rem;
  }

  /* ── Brand ───────────────────────────────────────────────── */
  .footer-brand-logo {
    display: inline-flex;
    align-items: center;
    gap: .65rem;
    text-decoration: none;
    margin-bottom: 1rem;
  }

  .footer-logo-icon img {
    width: 42px;
    height: 42px;
    object-fit: contain;
    border-radius: 8px;
  }

  .footer-logo-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
    color: var(--text-bright-footer);
  }

  .logo-title {
    font-weight: 800;
    font-size: 1.05rem;
    letter-spacing: -.2px;
  }

  .logo-sub {
    font-size: .6rem;
    text-transform: uppercase;
    letter-spacing: .1em;
    color: var(--text-muted-footer);
  }

  .footer-desc {
    font-size: .84rem;
    color: var(--text-muted-footer);
    line-height: 1.75;
    max-width: 310px;
  }

  /* ── Social icons ────────────────────────────────────────── */
  .footer-socials {
    display: flex;
    gap: .5rem;
    margin-top: 1.25rem;
  }

  .footer-socials a {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1px solid var(--navy-border-footer);
    background: var(--navy-light-footer);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted-footer);
    text-decoration: none;
    transition: background .2s, color .2s, border-color .2s, transform .18s;
  }

  .footer-socials a:hover {
    background: var(--accent-foreground);
    border-color: var(--accent-foreground);
    color: #fff;
    transform: translateY(-2px);
  }

  /* ── Newsletter box ──────────────────────────────────────── */
  .footer-newsletter {
    background: var(--navy-light-footer);
    border: 1px solid var(--navy-border-footer);
    border-radius: 12px;
    padding: 1.1rem 1.25rem;
    margin-top: 1.5rem;
  }

  .footer-newsletter p {
    font-size: .78rem;
    margin-bottom: .6rem;
    color: var(--text-muted-footer);
  }

  .footer-newsletter .input-group input {
    background: var(--navy-footer);
    border: 1px solid var(--navy-border-footer);
    color: #fff;
    font-size: .8rem;
    border-radius: 7px 0 0 7px !important;
  }

  .footer-newsletter .input-group input::placeholder {
    color: var(--text-muted-footer);
  }

  .footer-newsletter .input-group input:focus {
    background: var(--navy-footer);
    box-shadow: 0 0 0 2px var(--accent-soft-footer);
    border-color: var(--accent-footer);
    color: #fff;
  }

  .footer-newsletter .input-group button {
    font-size: .78rem;
    background: var(--accent-footer);
    border: none;
    color: #fff;
    border-radius: 0 7px 7px 0 !important;
    padding: 0 .9rem;
    transition: opacity .2s;
  }

  .footer-newsletter .input-group button:hover {
    opacity: .88;
  }

  /* ── Column headings ─────────────────────────────────────── */
  .footer-col h5 {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--text-bright-footer);
    padding-bottom: .65rem;
    border-bottom: 1px solid var(--navy-border-footer);
    margin-bottom: 1rem;
  }

  /* ── Nav links ───────────────────────────────────────────── */
  .footer-col ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .footer-col ul li {
    margin-bottom: .55rem;
  }

  .footer-col ul li a {
    color: var(--text-muted-footer);
    text-decoration: none;
    font-size: .84rem;
    display: inline-flex;
    align-items: center;
    gap: 0;
    transition: color .2s, gap .2s;
  }

  .footer-col ul li a::before {
    content: '›';
    font-size: 1rem;
    line-height: 1;
    color: var(--accent-footer);
    opacity: 0;
    width: 0;
    overflow: hidden;
    transition: opacity .2s, width .2s;
    display: inline-block;
  }

  .footer-col ul li a:hover {
    color: var(--text-bright-footer);
    gap: .35rem;
  }

  .footer-col ul li a:hover::before {
    opacity: 1;
    width: .75rem;
  }

  /* ── Contact list ────────────────────────────────────────── */
  .footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .footer-contact li {
    display: flex;
    align-items: flex-start;
    gap: .6rem;
    margin-bottom: .8rem;
    font-size: .84rem;
    color: var(--text-muted-footer);
    line-height: 1.5;
  }

  .footer-contact li svg {
    width: 15px;
    height: 15px;
    color: var(--accent-footer);
    flex-shrink: 0;
    margin-top: .15rem;
  }

  .footer-contact li a {
    color: var(--text-muted-footer);
    text-decoration: none;
    transition: color .2s;
  }

  .footer-contact li a:hover {
    color: var(--text-bright-footer);
  }

  /* ── Divider ─────────────────────────────────────────────── */
  hr.footer-hr {
    border-color: var(--navy-border-footer);
    margin: 0;
  }

  /* ── Bottom bar ──────────────────────────────────────────── */
  .footer-bottom {
    padding: 1.15rem 0;
    font-size: .76rem;
    color: rgba(255, 255, 255, .38);
  }

  .footer-bottom a {
    color: rgba(255, 255, 255, .45);
    text-decoration: none;
    transition: color .2s;
  }

  .footer-bottom a:hover {
    color: rgba(255, 255, 255, .75);
  }

  /* ── Responsive ──────────────────────────────────────────── */
  @media (max-width: 575.98px) {
    .footer-main {
      padding: 2.5rem 0 1.75rem;
    }

    .footer-desc {
      max-width: 100%;
    }

    .footer-bottom .text-md-end {
      text-align: left !important;
      margin-top: .35rem;
    }
  }
</style>
<!-- ============================================================
     FOOTER HTML
     ============================================================ -->

<footer class="site-footer">
  <!-- ── Main footer body ───────────────────────────────── -->
  <div class="footer-main">
    <div class="container">
      <div class="row g-4 g-xl-5">

        <!-- Brand + Newsletter -->
        <div class="col-12 col-lg-4">

          <a href="<?= $b ?>index.php" class="footer-brand-logo">
            <div class="footer-logo-icon">
              <img src="<?= $asset_base ?>assets/images/logo.webp" alt="IIMs Colleges Logo">
            </div>
            <div class="footer-logo-text">
              <span class="logo-title">IIMs Colleges</span>
              <span class="logo-sub">India's MBA Discovery</span>
            </div>
          </a>

          <p class="footer-desc">
            India's most trusted discovery platform for Indian Institutes of Management.
            Verified data, transparent placements, free counselling.
          </p>

          <!-- Social icons -->
          <div class="footer-socials">
            <a href="#" aria-label="LinkedIn">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                <rect x="2" y="9" width="4" height="12" />
                <circle cx="4" cy="4" r="2" />
              </svg>
            </a>
            <a href="#" aria-label="Twitter / X">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
              </svg>
            </a>
            <a href="#" aria-label="Instagram">
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                <circle cx="12" cy="12" r="4" />
                <circle cx="17.5" cy="6.5" r=".5" fill="currentColor" stroke="none" />
              </svg>
            </a>
            <a href="#" aria-label="YouTube">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.96C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z" />
                <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="var(--navy)" />
              </svg>
            </a>
            <a href="#" aria-label="Telegram">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
              </svg>
            </a>
          </div>

          <!-- Newsletter -->
          <div class="footer-newsletter">
            <p class="fw-semibold text-white mb-1" style="font-size:.82rem;">Get MBA updates in your inbox</p>
            <p>Admission alerts, cutoffs & placement reports — free.</p>
            <div class="input-group">
              <input type="email" class="form-control" placeholder="you@email.com">
              <button type="button">Subscribe</button>
            </div>
          </div>

        </div>
        <!-- /Brand -->

        <!-- Explore -->
        <div class="col-6 col-sm-4 col-lg-2 footer-col">
          <h5>Explore</h5>
          <ul>
            <li><a href="<?= $b ?>pages/colleges.php">All IIMs</a></li>
            <li><a href="<?= $b ?>pages/courses.php">Courses</a></li>
            <li><a href="<?= $b ?>pages/compare.php">Compare</a></li>
            <li><a href="<?= $b ?>pages/blogs.php">Blogs</a></li>
          </ul>
        </div>

        <!-- Company -->
        <div class="col-6 col-sm-4 col-lg-2 footer-col">
          <h5>Company</h5>
          <ul>
            <li><a href="<?= $b ?>pages/about.php">About Us</a></li>
            <li><a href="<?= $b ?>pages/careers.php">Careers</a></li>
            <li><a href="<?= $b ?>pages/contact.php">Contact</a></li>
            <li><a href="<?= $b ?>pages/privacy-policy.php">Privacy Policy</a></li>
            <li><a href="<?= $b ?>pages/terms-conditions.php">Terms of Use</a></li>
          </ul>
        </div>

        <!-- Contact -->
        <div class="col-12 col-sm-4 col-lg-4 footer-col">
          <h5>Get in touch</h5>
          <ul class="footer-contact">
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                <polyline points="22,6 12,13 2,6" />
              </svg>
              <a href="mailto:hello@iimscourses.com">hello@iimscourses.com</a>
            </li>
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path
                  d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.16 12 19.79 19.79 0 0 1 1.11 3.4 2 2 0 0 1 3.09 1.22h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.09 9a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 21 16z" />
              </svg>
              <a href="tel:+919000011122">+91 90000 11122</a>
            </li>
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                <circle cx="12" cy="10" r="3" />
              </svg>
              Bengaluru, Karnataka, India
            </li>
          </ul>

          <!-- Counselling CTA -->
          <a onclick="openApplyModal()"
            class="d-inline-flex align-items-center gap-2 mt-3 px-3 py-2 rounded-3 text-white text-decoration-none"
            style="background:var(--accent-soft);border:1px solid rgba(59,130,246,.35);font-size:.8rem;transition:background .2s;"
            onmouseover="this.style.background='rgba(59,130,246,.3)'"
            onmouseout="this.style.background='var(--accent-soft)'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
            Book a Free Counselling Session
          </a>
        </div>

      </div><!-- /row -->
    </div>
  </div>
  <hr class="footer-hr m-0">

  <!-- ── Bottom bar ─────────────────────────────────────── -->
  <div class="footer-bottom">
    <div class="container">
      <div class="row align-items-center gy-1">

        <div class="col-12 col-md-5">
          <span>© <?= date('Y') ?> IIMs Colleges. Crafted for MBA aspirants.</span>
        </div>

        <div class="col-12 col-md-4 text-md-center">
          <span>
            <a href="<?= $b ?>pages/privacy-policy.php">Privacy Policy</a>
          </span>
        </div>

        <div class="col-12 col-md-3 text-md-end">
          <span>Not affiliated with any IIM. Data from public sources.</span>
        </div>

      </div>
    </div>
  </div>
  <!-- /footer-bottom -->

</footer>




<?php
function tooltip(string $label, string $tooltipText, string $onclick = ''): string
{
  $label = htmlspecialchars($label, ENT_QUOTES);
  $tooltipText = htmlspecialchars($tooltipText, ENT_QUOTES);
  $onclick = $onclick ? 'onclick="' . htmlspecialchars($onclick, ENT_QUOTES) . '"' : '';

  return "
    <button class='uiverse' $onclick>
        <span class='tooltip'>$tooltipText</span>
        <span>$label</span>
    </button>";
}
?>
<?php include __DIR__ . '/CompareBar.php'; ?>
<?php include __DIR__ . '/Modals.php'; ?>
<?php include __DIR__ . '/floating-tooltip-button.php'; ?>