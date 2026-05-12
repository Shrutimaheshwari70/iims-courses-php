<?php
session_start();
require_once '../data/iims.php';
$current_page = 'contact';
$toast_message = '';
$toast_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
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

<!-- Hero -->
<section style="background: linear-gradient(135deg, #1a2340 0%, #2d3d6b 100%); padding: 7rem 0 4rem;">
  <div style="max-width:1100px; margin:0 auto; padding:0 2rem;">
    <h1 style="font-family:var(--font-display); font-weight:800; font-size:clamp(2.5rem,5vw,4rem); color:#fff; line-height:1.1;">
      Get in <span style="color:var(--orange);">touch</span>
    </h1>
    <p style="color:rgba(255,255,255,0.8); margin-top:1rem; font-size:1.1rem;">
      Free 1-on-1 counselling with IIM alumni.
    </p>
  </div>
</section>

<!-- Contact Grid -->
<section style=" padding:4rem 0; min-height:60vh;">
  <div style="max-width:1100px; margin:0 auto; padding:0 2rem; display:grid; grid-template-columns:1fr 1fr; gap:2rem; align-items:start;">
    
    <!-- Left: Contact Info -->
    <div style=" border-radius:16px; border:1px solid var(--border); padding:2rem; box-shadow:var(--shadow-soft);">
      
      <!-- Email -->
      <div style="display:flex; gap:1rem; align-items:flex-start; margin-bottom:1.75rem;">
        <div style="width:48px; height:48px; border-radius:12px; background:var(--gradient-accent); background-image:var(--gradient-accent); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-10 7L2 7"/></svg>
        </div>
        <div>
          <div style="font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.12em; color:var(--muted-foreground);">Email</div>
          <div style="font-weight:600; margin-top:.2rem; font-size:.95rem;">hello@iimscourses.com</div>
        </div>
      </div>

      <!-- Phone -->
      <div style="display:flex; gap:1rem; align-items:flex-start; margin-bottom:1.75rem;">
        <div style="width:48px; height:48px; border-radius:12px; background-image:var(--gradient-accent); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </div>
        <div>
          <div style="font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.12em; color:var(--muted-foreground);">Phone</div>
          <div style="font-weight:600; margin-top:.2rem; font-size:.95rem;">+91 90000 11122</div>
        </div>
      </div>

      <!-- Office -->
      <div style="display:flex; gap:1rem; align-items:flex-start;">
        <div style="width:48px; height:48px; border-radius:12px; background-image:var(--gradient-accent); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div>
          <div style="font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.12em; color:var(--muted-foreground);">Office</div>
          <div style="font-weight:600; margin-top:.2rem; font-size:.95rem;">Indiranagar, Bengaluru, India</div>
        </div>
      </div>

    </div>

    <!-- Right: Form -->
    <div style=" border-radius:16px; border:1px solid var(--border); padding:2rem; box-shadow:var(--shadow-soft);">
      <form method="POST" action="">
        
        <div style="margin-bottom:1.25rem;">
          <label style="display:block; font-size:.82rem; font-weight:500; margin-bottom:.4rem;">Name</label>
          <input type="text" name="name" placeholder="Your full name" required
            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
            style="width:100%; border:1px solid var(--input); border-radius:8px; padding:.65rem .9rem; font-size:.9rem; font-family:var(--font-sans); background:var(--background); color:var(--foreground); outline:none;">
        </div>

        <div style="margin-bottom:1.25rem;">
          <label style="display:block; font-size:.82rem; font-weight:500; margin-bottom:.4rem;">Email</label>
          <input type="email" name="email" placeholder="you@example.com" required
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            style="width:100%; border:1px solid var(--input); border-radius:8px; padding:.65rem .9rem; font-size:.9rem; font-family:var(--font-sans); background:var(--background); color:var(--foreground); outline:none;">
        </div>

        <div style="margin-bottom:1.5rem;">
          <label style="display:block; font-size:.82rem; font-weight:500; margin-bottom:.4rem;">Message</label>
          <textarea name="message" placeholder="How can we help you?" required rows="5"
            style="width:100%; border:1px solid var(--input); border-radius:8px; padding:.65rem .9rem; font-size:.9rem; font-family:var(--font-sans); background:var(--background); color:var(--foreground); outline:none; resize:vertical;"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </div>

        <button type="submit"
          style="width:100%; padding:.9rem; border:none; border-radius:10px; background-image:var(--gradient-accent); color:#fff; font-size:1rem; font-weight:600; font-family:var(--font-sans); cursor:pointer; display:flex; align-items:center; justify-content:center; gap:.5rem;">
          Send Message
          <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>

      </form>
    </div>

  </div>
</section>

<!-- Toast -->
<?php if ($toast_message): ?>
<div id="toast" style="position:fixed; bottom:1.5rem; right:1.5rem; z-index:999; padding:.75rem 1.25rem; border-radius:10px; font-size:.9rem; font-weight:500; color:#fff; background:<?= $toast_type === 'success' ? '#3ab07b' : '#e05050' ?>; box-shadow:0 4px 20px rgba(0,0,0,.15);">
  <?= $toast_type === 'success' ? '✅' : '⚠️' ?> <?= htmlspecialchars($toast_message) ?>
</div>
<script>setTimeout(() => { const t = document.getElementById('toast'); if(t) t.remove(); }, 3000);</script>
<?php endif; ?>

<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>