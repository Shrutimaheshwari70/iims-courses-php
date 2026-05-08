<?php
/**
 * contact.php  ←→  src/routes/contact.tsx
 */
session_start();
$page_title       = 'Contact IIMs Courses';
$page_description = 'Free 1-on-1 counselling with IIM alumni. Reach us at hello@iimscourses.com';
$current_page     = 'contact';

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name    = trim($_POST['name']    ?? '');
  $email   = trim($_POST['email']   ?? '');
  $message = trim($_POST['message'] ?? '');
  // In production: send email / save to DB
  if ($name && $email && $message) $success = true;
}

include 'includes/header.php';
include 'components/Navbar.php';
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="gradient-hero pt-32 pb-16 text-white">
  <div class="container">
    <h1 class="font-display text-5xl md:text-6xl font-bold">
      Get in <span class="text-gradient-accent">touch</span>
    </h1>
    <p class="text-white-80 mt-4 text-lg max-w-2xl">Free 1-on-1 counselling with IIM alumni.</p>
  </div>
</section>


<!-- ============================================================
     CONTACT GRID
     ============================================================ -->
<section class="section">
  <div class="container" style="max-width:900px">
    <div class="contact-grid">

      <!-- Contact info -->
      <div class="contact-info-card reveal">

        <div class="contact-info-item">
          <div class="contact-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
            </svg>
          </div>
          <div>
            <div class="contact-label">Email</div>
            <div class="contact-value">hello@iimscourses.com</div>
          </div>
        </div>

        <div class="contact-info-item">
          <div class="contact-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.38 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6 6l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.72 16.92z"/>
            </svg>
          </div>
          <div>
            <div class="contact-label">Phone</div>
            <div class="contact-value">+91 90000 11122</div>
          </div>
        </div>

        <div class="contact-info-item">
          <div class="contact-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
            </svg>
          </div>
          <div>
            <div class="contact-label">Office</div>
            <div class="contact-value">Indiranagar, Bengaluru, India</div>
          </div>
        </div>

      </div>

      <!-- Contact form -->
      <div class="contact-form-card reveal">
        <?php if ($success): ?>
          <div class="alert-success">
            ✅ Message sent! We'll respond within 24 hours.
          </div>
        <?php endif; ?>

        <form method="POST" action="contact.php" class="contact-form">
          <div class="form-group">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-input" required placeholder="Your full name" />
          </div>
          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" required placeholder="you@example.com" />
          </div>
          <div class="form-group">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-textarea" rows="4" required placeholder="How can we help you?"></textarea>
          </div>
          <button type="submit" class="btn btn-hero" style="width:100%">Send Message</button>
        </form>
      </div>

    </div>
  </div>
</section>

<?php
include 'components/Footer.php';
include 'includes/footer.php';
?>