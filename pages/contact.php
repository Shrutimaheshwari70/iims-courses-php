<?php
session_start();
require_once '../data/iims.php';
$current_page = 'contact';
$toast_message = '';
$toast_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $message = trim($_POST['message'] ?? '');
  if ($name && $email && $message) {
    $toast_message = "Message sent! We'll respond within 24 hours.";
    $toast_type = 'success';
    $_POST = [];
  } else {
    $toast_message = "Please fill in all fields before sending.";
    $toast_type = 'error';
  }
}

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- Bootstrap Icons only (no full Bootstrap CSS globally) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Bootstrap CSS scoped ONLY inside .bs via a style tag trick -->
<style id="bs-scope-style"></style>

<style>
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

  /* ── Design variables ── */
  .bs {
    font-family: var(--font-sans, sans-serif);
  }

  /* Hero */
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

  /* Cards */
  .bs .c-card {
    transition: box-shadow .2s;
  }

  .bs .c-card:hover {
    box-shadow: 0 8px 32px rgba(0, 0, 0, .10);
  }

  .bs .icon-box {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #1a2340, #2d3d6b);
    flex-shrink: 0;
  }

  .bs .info-label {
    font-size: .65rem;
    letter-spacing: .12em;
    color: var(--c-muted);
  }

  .bs .info-value {
    font-size: .90rem;
  }

  .bs .info-link {
    font-size: .82rem;
    color: #f97316;
  }

  .bs .info-link:hover {
    text-decoration: underline;
  }

  /* Form */
  .bs .c-label {
    display: block;
    font-size: .82rem;
    font-weight: 500;
  }

  .bs .c-input {
    width: 100%;
    font-size: .9rem;
    color: var(--foreground, #111);
    outline: none;
    transition: border-color .18s, box-shadow .18s;
  }

  .bs .c-input:focus {
    border-color: #2d3d6b;
    box-shadow: 0 0 0 3px rgba(45, 61, 107, .12);
  }

  .bs .c-btn-send {
    background-image: var(--gradient-accent, linear-gradient(135deg, #1a2340, #2d3d6b));
    cursor: pointer;
    transition: transform .18s, box-shadow .18s;
  }

  .bs .c-btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(26, 35, 64, .25);
  }

  /* Outline hero btn */
  .bs .c-btn-outline {
    transition: border-color .18s;
  }

  .bs .c-btn-outline:hover {
    border-color: #fff;
  }

  /* Map */
  .bs .map-wrap {
    box-shadow: var(--c-shadow);
    border: 1px solid var(--c-border);
  }

  .bs .map-wrap iframe {
    display: block;
    width: 100%;
    height: 380px;
    border: 0;
  }

  /* Toast */
  .c-toast {
    position: fixed;
    bottom: 1.5rem;
    right: 1.5rem;
    z-index: 9999;
    padding: .75rem 1.35rem;
    border-radius: 12px;
    font-size: .9rem;
    font-weight: 500;
    color: #fff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, .15);
    animation: cToastIn .3s ease;
  }

  @keyframes cToastIn {
    from {
      transform: translateY(20px);
      opacity: 0
    }

    to {
      transform: translateY(0);
      opacity: 1
    }
  }

  @media(max-width:767px) {
    .bs .c-hero {
      /* padding: 10rem 0 3rem; */
    }

    .bs .c-strip .d-flex {
      flex-direction: column;
      gap: .75rem;
      text-align: center;
    }

    .bs .map-wrap iframe {
      height: 260px;
    }
  }
</style>
<!-- Reading progress bar -->
<div id="reading-progress"></div></div>
<div class="bs">
  <!-- HERO -->
  <section class="c-hero">
    <div class="container position-relative" style="z-index:1;">
      <div class="c-badge d-inline-flex px-3 py-1 rounded align-items-center mb-2 text-uppercase gap-2">
        <i class="bi bi-mortarboard-fill"></i> IIM Alumni Counselling
      </div>
      <h1 class="text-white fw-bold ">Get in <span>touch</span></h1>
      <p class="text-light">Free 1-on-1 counselling with IIM alumni. We're here to guide your MBA journey.</p>
      <div class="d-flex gap-3 mt-4 flex-wrap">
        <button class="c-btn-send px-4 rounded text-white w-auto py-3 border-0" onclick="openApplyModal()">
          <i class="bi bi-send-fill"></i> Apply Now
        </button>
        <a href="#contact-section" class="c-btn-outline px-4 rounded text-white w-auto py-3 border ">
          <i class="bi bi-chat-dots "></i> Contact Us
        </a>
      </div>
    </div>
  </section>
  <!-- CONTACT SECTION -->
  <section id="contact-section" style="padding:4.5rem 0; background:#f8f9fc;">
    <div class="container">

      <div class="text-center mb-5">
        <h2 style="font-family:var(--font-display,sans-serif); font-weight:800; font-size:clamp(1.8rem,3.5vw,2.6rem);">
          Reach <span style="color:#f97316;">out to us</span>
        </h2>
        <p style="color:var(--c-muted); max-width:500px; margin:0 auto;">
          Whether you have a question, a goal, or just want to explore — we're one message away.
        </p>
      </div>

      <div class="row g-4">

        <!-- Info Cards -->
        <div class="col-lg-5">
          <div class="d-flex flex-column gap-3 h-100">

            <div class="c-card bg-white px-4 py-4 rounded-2xl shadow">
              <div class="d-flex gap-3 align-items-start">
                <div class="icon-box d-flex align-items-center justify-content-center rounded">
                  <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                    <rect width="20" height="16" x="2" y="4" rx="2" />
                    <path d="m22 7-10 7L2 7" />
                  </svg>
                </div>
                <div>
                  <div class="info-label text-uppercase fw-semibold">Email</div>
                  <div class="info-value fw-semibold mt-1">hello@iimscourses.com</div>
                  <a href="mailto:hello@iimscourses.com" class="info-link">Send email →</a>
                </div>
              </div>
            </div>

            <div class="c-card bg-white px-4 py-4 rounded-2xl shadow">
              <div class="d-flex gap-3 align-items-start">
                <div class="icon-box d-flex align-items-center justify-content-center rounded">
                  <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                    <path
                      d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                  </svg>
                </div>
                <div>
                  <div class="info-label text-uppercase fw-semibold">Phone</div>
                  <div class="info-value fw-semibold mt-1">+91 90000 11122</div>
                  <a href="tel:+919000011122" class="info-link">Call now →</a>
                </div>
              </div>
            </div>

            <div class="c-card bg-white px-4 py-4 rounded-2xl shadow">
              <div class="d-flex gap-3 align-items-start">
                <div class="icon-box d-flex align-items-center justify-content-center rounded">
                  <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                    <circle cx="12" cy="10" r="3" />
                  </svg>
                </div>
                <div>
                  <div class="info-label text-uppercase fw-semibold">Office</div>
                  <div class="info-value fw-semibold mt-1">Indiranagar, Bengaluru, India</div>
                  <a href="#map-section" class="info-link">View on map →</a>
                </div>
              </div>
            </div>

            <div class="c-card bg-white px-4 py-4 rounded-2xl shadow">
              <div class="d-flex gap-3 align-items-start">
                <div class="icon-box d-flex align-items-center justify-content-center rounded">
                  <i class="bi bi-clock-fill" style="color:#fff; font-size:1.1rem;"></i>
                </div>
                <div>
                  <div class="info-label text-uppercase fw-semibold">Office Hours</div>
                  <div class="info-value fw-semibold mt-1">Mon – Sat: 9:00 AM – 7:00 PM</div>
                  <div style="font-size:.82rem; color:var(--c-muted);">Sunday: Closed</div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Form -->
        <div class="col-lg-7">
          <div class="c-form-card bg-white px-4 py-4 shadow rounded-2xl border-secondary">
            <h5
              style="font-family:var(--font-display,sans-serif); font-weight:600; font-size:1.25rem; margin-bottom:1.5rem;">
              Send us a message
            </h5>
            <form method="POST" action="" id="contactForm">

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="c-label mb-2">Name</label>
                  <input type="text" name="name" class="c-input border rounded-xl px-2 py-2"
                    placeholder="Enter your name..." required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                  <label class="c-label mb-2">Email</label>
                  <input type="email" name="email" class="c-input border rounded-xl px-2 py-2"
                    placeholder="you@example.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
              </div>

              <div class="mb-3">
                <label class="c-label mb-2">Phone (Optional)</label>
                <input type="tel" name="phone" class="c-input border rounded-xl px-2 py-2"
                  placeholder="+91 00000 00000">
              </div>

              <div class="mb-3">
                <label class="c-label mb-2">Program of Interest</label>
                <select name="program" class="c-input border rounded-xl px-2 py-2"
                  style="appearance:auto; cursor:pointer;">
                  <option value="">Select a program…</option>
                  <option>MBA – Full Time</option>
                  <option>PGDM</option>
                  <option>Executive MBA</option>
                  <option>Online MBA</option>
                </select>
              </div>

              <div class="mb-4">
                <label class="c-label mb-2">Message</label>
                <textarea name="message" class="c-input border rounded-xl px-2 py-2" placeholder="How can we help you?"
                  required rows="4" style="resize:vertical;"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
              </div>

              <button type="submit"
                class="c-btn-send d-flex align-items-center justify-content-center w-100 py-2 rounded gap-2 border-0 text-white fw-semibold">
                Send Message
                <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                  <line x1="5" y1="12" x2="19" y2="12" />
                  <polyline points="12 5 19 12 12 19" />
                </svg>
              </button>

            </form>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- MAP SECTION -->
  <section id="map-section" style="padding:4rem 0; background:#fff;">
    <div class="container">

      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div>
          <h2
            style="font-family:var(--font-display,sans-serif); font-weight:800; font-size:clamp(1.6rem,3vw,2.2rem); margin-bottom:.25rem;">
            Find our <span style="color:#f97316;">Office</span>
          </h2>
          <p style="color:var(--c-muted); margin:0;">We'd love to meet you at our Bengaluru campus.</p>
        </div>
        <a href="https://maps.google.com/?q=Indiranagar,Bengaluru" target="_blank" style="background:#1a2340; color:#fff; font-weight:600; border-radius:10px;
                 padding:.6rem 1.4rem; text-decoration:none; display:inline-flex;
                 align-items:center; gap:.5rem; font-size:.9rem; transition:opacity .18s;"
          onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
          <i class="bi bi-box-arrow-up-right"></i> Open in Maps
        </a>
      </div>

      <div class="map-wrap overflow-hidden rounded">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3887.9873059660586!2d77.63705!3d12.97854!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae16848d2b0eef%3A0x98be89d6daefd84!2sIndiranagar%2C%20Bengaluru%2C%20Karnataka!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin"
          allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          title="IIMS Office – Indiranagar, Bengaluru">
        </iframe>
      </div>


    </div>
  </section>

</div>
<!-- Toast (PHP) -->
<?php if ($toast_message): ?>
  <div id="toast" class="c-toast" style="background:<?= $toast_type === 'success' ? '#3ab07b' : '#e05050' ?>;">
    <?= $toast_type === 'success' ? '✅' : '⚠️' ?>   <?= htmlspecialchars($toast_message) ?>
  </div>
  <script>
    setTimeout(() => {
      const t = document.getElementById('toast');
      if (t) { t.style.opacity = '0'; t.style.transition = 'opacity .3s'; setTimeout(() => t?.remove(), 300); }
    }, 3500);
  </script>
<?php endif; ?>

<script>
  function submitApply() {
    const form = document.getElementById('applyForm');
    const required = form.querySelectorAll('[required]');
    let valid = true;
    required.forEach(f => {
      if (!f.value.trim()) { f.style.borderColor = '#e05050'; valid = false; }
      else { f.style.borderColor = '#e5e7eb'; }
    });
    if (!valid) return;
    closeModal();
    const toast = document.createElement('div');
    toast.className = 'c-toast';
    toast.style.background = '#3ab07b';
    toast.innerHTML = "✅ Application submitted! We'll reach out within 24 hours.";
    document.body.appendChild(toast);
    setTimeout(() => {
      toast.style.opacity = '0'; toast.style.transition = 'opacity .3s';
      setTimeout(() => toast.remove(), 300);
    }, 4000);
  }
</script>
<!-- ----------------reading progress  -->
<script>
  (function() {
  var bar = document.getElementById('reading-progress');
  window.addEventListener('scroll', function() {
    var d = document.documentElement;
    var scrollTop = d.scrollTop || document.body.scrollTop;
    var total = d.scrollHeight - d.clientHeight;
    bar.style.width = (total > 0 ? (scrollTop / total * 100) : 0) + '%';
  }, { passive: true });
})();

</script>
<script>
  document.getElementById('contactForm')?.addEventListener('submit', function (e) {

    const name = document.querySelector('[name="name"]');
    const email = document.querySelector('[name="email"]');
    const phone = document.querySelector('[name="phone"]');
    const message = document.querySelector('[name="message"]');

    let valid = true;

    // Reset
    document.querySelectorAll('.c-input').forEach(input => {
      input.style.borderColor = '#dee2e6';
    });

    // Name validation
    if (name.value.trim().length < 3) {
      name.style.borderColor = '#e05050';
      valid = false;
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email.value.trim())) {
      email.style.borderColor = '#e05050';
      valid = false;
    }

    // Phone validation (optional)
    if (phone.value.trim() !== '') {
      const phoneRegex = /^[0-9]{10}$/;

      if (!phoneRegex.test(phone.value.trim())) {
        phone.style.borderColor = '#e05050';
        valid = false;
      }
    }

    // Message validation
    if (message.value.trim().length < 10) {
      message.style.borderColor = '#e05050';
      valid = false;
    }

    // Stop submit
    if (!valid) {
      e.preventDefault();

      const oldToast = document.getElementById('jsValidationToast');
      if (oldToast) oldToast.remove();

      const toast = document.createElement('div');
      toast.id = 'jsValidationToast';
      toast.className = 'c-toast';
      toast.style.background = '#e05050';
      toast.innerHTML = '⚠️ Please fill all fields correctly';

      document.body.appendChild(toast);

      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity .3s';

        setTimeout(() => toast.remove(), 300);
      }, 3000);
    }
  });
</script>

<?php
include '../components/Footer.php';
include '../components/Modals.php';
include '../includes/footer.php';
?>