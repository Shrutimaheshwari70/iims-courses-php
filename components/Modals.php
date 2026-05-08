<?php
/**
 * components/Modals.php
 * PHP conversion of src/components/modals.tsx
 * Include once per page (before </body>) — modals are hidden by default.
 */
?>

<!-- Apply Modal -->
<div class="modal-backdrop" id="apply-modal" onclick="closeModalOnBackdrop(event,'apply-modal')">
  <div class="modal-box" style="position:relative">
    <button class="modal-close" onclick="closeModal('apply-modal')">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>
    <div class="modal-title">Apply Now</div>
    <p class="modal-desc" id="apply-modal-desc">Tell us about you. Our counsellor will reach out within 24 hours.</p>

    <form method="post" action="actions/apply.php" id="apply-form" onsubmit="handleApplySubmit(event)">
      <div class="form-group">
        <label for="apply-name">Full Name</label>
        <input id="apply-name" name="name" required placeholder="Aman Kumar" />
      </div>
      <div class="form-row">
        <div class="form-group" style="margin-top:0">
          <label for="apply-email">Email</label>
          <input id="apply-email" name="email" type="email" required placeholder="you@email.com" />
        </div>
        <div class="form-group" style="margin-top:0">
          <label for="apply-phone">Phone</label>
          <input id="apply-phone" name="phone" required placeholder="+91 ..." />
        </div>
      </div>
      <div class="form-group">
        <label for="apply-msg">Message (optional)</label>
        <textarea id="apply-msg" name="message" rows="3" placeholder="Tell us about your goals"></textarea>
      </div>
      <button type="submit" class="btn btn-hero form-submit" id="apply-submit-btn">
        Submit Application
      </button>
    </form>
    <!-- Success message (hidden initially) -->
    <div id="apply-success" style="display:none;text-align:center;padding:2rem 0;">
      <div style="font-size:2.5rem;margin-bottom:.5rem">🎉</div>
      <div style="font-family:var(--font-display);font-size:1.2rem;font-weight:700;">Application received!</div>
      <div style="color:var(--muted-foreground);margin-top:.4rem">We'll call you within 24 hours.</div>
    </div>
  </div>
</div>

<!-- Login Modal -->
<div class="modal-backdrop" id="login-modal" onclick="closeModalOnBackdrop(event,'login-modal')">
  <div class="modal-box" style="position:relative;max-width:420px">
    <button class="modal-close" onclick="closeModal('login-modal')">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>
    <div class="modal-title" id="login-title">Welcome back</div>
    <p class="modal-desc" id="login-desc">Login to track applications and saved colleges.</p>

    <form onsubmit="handleLogin(event)" style="margin-top:1rem">
      <div id="signup-name-group" class="form-group" style="display:none">
        <label>Full Name</label>
        <input id="login-fullname" placeholder="Your name" />
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" required placeholder="you@email.com" />
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" required placeholder="••••••••" />
      </div>
      <button type="submit" class="btn btn-hero form-submit" id="login-submit-btn">Login</button>
      <div style="text-align:center;margin-top:.85rem">
        <button type="button" onclick="toggleLoginMode()" style="font-size:.85rem;color:var(--muted-foreground);background:none;border:none;cursor:pointer;" id="login-toggle-btn">
          New here? Create account
        </button>
      </div>
    </form>
  </div>
</div>