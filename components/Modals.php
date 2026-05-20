<?php
/**
 * components/Modals.php
 * Include once per page (before </body>) — modals are hidden by default.
 * NOTE: loginModal lives here — Navbar.php's initModal() connects to it via IDs.
 */
?>

<!-- ══════════════════════════════════════════
     APPLY MODAL
══════════════════════════════════════════ -->
<div id="apply-modal"
  style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.55);
         align-items:center; justify-content:center; padding:1rem;">

  <!-- Backdrop click-catcher -->
  <div onclick="closeApplyModal()"
    style="position:absolute; inset:0; z-index:0;"></div>

  <div style="position:relative; z-index:1; background:#fff; border-radius:16px; width:100%;
              max-width:460px; padding:1.3rem; box-shadow:0 20px 60px rgba(0,0,0,.25);
              max-height:90vh; overflow-y:auto;">

    <!-- Close -->
    <button onclick="closeApplyModal()"
      style="position:absolute; top:1rem; right:1rem; background:none; border:none;
             cursor:pointer; color:#6b7280; width:2rem; height:2rem;
             display:flex; align-items:center; justify-content:center;
             border-radius:50%; font-size:1.2rem; z-index:2; line-height:1;">
      &#x2715;
    </button>

    <div style="font-family:var(--font-display,sans-serif); font-weight:500; font-size:1.3rem; margin-bottom:.3rem;">
      Apply Now
    </div>
    <p style="color:#6b7280; font-size:.8rem; margin-bottom:0.8rem;">
      Tell us about you. Our counsellor will reach out within 24 hours.
    </p>

    <!-- Form -->
    <form method="post" action="actions/apply.php" id="apply-form" onsubmit="handleApplySubmit(event)">

      <div style="margin-bottom:1rem;">
        <label for="apply-name" style="display:block; font-size:.82rem; font-weight:500; margin-bottom:.35rem;">Full Name</label>
        <input id="apply-name" name="name" required placeholder="Enter your name..."
          style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:.40rem .9rem;
                 font-size:.8rem; outline:none; box-sizing:border-box; font-family:inherit;
                 transition:border-color .18s;"
          onfocus="this.style.borderColor='#2d3d6b'" onblur="this.style.borderColor='#e5e7eb'" />
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
        <div>
          <label for="apply-email" style="display:block; font-size:.82rem; font-weight:500; margin-bottom:.35rem;">Email</label>
          <input id="apply-email" name="email" type="email" required placeholder="you@email.com"
            style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:.40rem .9rem;
                   font-size:.8rem; outline:none; box-sizing:border-box; font-family:inherit;
                   transition:border-color .18s;"
            onfocus="this.style.borderColor='#2d3d6b'" onblur="this.style.borderColor='#e5e7eb'" />
        </div>
        <div>
          <label for="apply-phone" style="display:block; font-size:.82rem; font-weight:500; margin-bottom:.35rem;">Phone</label>
          <input id="apply-phone" name="phone" required placeholder="+91 ..."
            style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:.40rem .9rem;
                   font-size:.8rem; outline:none; box-sizing:border-box; font-family:inherit;
                   transition:border-color .18s;"
            onfocus="this.style.borderColor='#2d3d6b'" onblur="this.style.borderColor='#e5e7eb'" />
        </div>
      </div>

      <div style="margin-bottom:1.5rem;">
        <label for="apply-msg" style="display:block; font-size:.82rem; font-weight:500; margin-bottom:.35rem;">Message (optional)</label>
        <textarea id="apply-msg" name="message" rows="3" placeholder="Tell us about your goals"
          style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:.40rem .9rem;
                 font-size:.8rem; outline:none; box-sizing:border-box; font-family:inherit;
                 resize:vertical; transition:border-color .18s;"
          onfocus="this.style.borderColor='#2d3d6b'" onblur="this.style.borderColor='#e5e7eb'"></textarea>
      </div>

      <button type="submit" class="btn btn-hero" id="apply-submit-btn"
        style="width:100%; padding:.65rem; border:none; border-radius:10px; cursor:pointer;
               font-size:0.9rem; font-weight:500; font-family:inherit; display:flex;
               align-items:center; justify-content:center; gap:.5rem;">
        Submit Application &rarr;
      </button>

    </form>

    <!-- Success message (hidden initially) -->
    <div id="apply-success" style="display:none; text-align:center; padding:2rem 0;">
      <div style="font-size:2.5rem; margin-bottom:.5rem;">🎉</div>
      <div style="font-family:var(--font-display,sans-serif); font-size:1.2rem; font-weight:700;">Application received!</div>
      <div style="color:#6b7280; margin-top:.4rem;">We'll call you within 24 hours.</div>
    </div>

  </div>
</div>


<!-- ══════════════════════════════════════════
     LOGIN / SIGNUP MODAL
     Navbar.php's initModal() connects loginBtn +
     mobileLoginBtn + closeModalBtn to this modal.
══════════════════════════════════════════ -->
<div id="loginModal" class="modal" style="background:rgba(0,0,0,0.55);">

  <div class="modal-content">

    <!-- Header -->
    <div class="modal-header">
      <h3>Welcome back</h3>
      <button class="modal-close" id="closeModalBtn">&#x2715;</button>
    </div>

    <!-- Body -->
    <div class="modal-body">
      <p class="modal-subtitle">Login to track applications and saved colleges.</p>
      <!-- ── LOGIN FIELDS ── -->
      <div id="loginFields">
        <div class="form-group">
          <label for="loginEmail">Email</label>
          <input id="loginEmail" name="email" type="email" placeholder="you@email.com" />
        </div>
        <div class="form-group">
          <label for="loginPassword">Password</label>
          <input id="loginPassword" name="password" type="password" placeholder="••••••••" />
        </div>
        <div style="text-align:right; margin-top:-.4rem; margin-bottom:1rem;">
          <a href="#" style="font-size:.78rem; color:var(--accent,#3b82f6); text-decoration:none;">
            Forgot password?
          </a>
        </div>
        <button class="btn-primary full-width" onclick="handleLoginSubmit(event)">
          Login &rarr;
        </button>
        <p class="modal-footer-text">
          Don't have an account?
          <a href="#" onclick="switchLoginTab('signup'); return false;"
            style="color:var(--accent,#3b82f6); text-decoration:none; font-weight:500;">
            Sign up
          </a>
        </p>
      </div>

      <!-- ── SIGNUP FIELDS ── -->
      <div id="signupFields" style="display:none;">
        <div class="form-group">
          <label for="signupName">Full Name</label>
          <input id="signupName" name="name" type="text" placeholder="Enter your name..." />
        </div>
        <div class="form-group">
          <label for="signupEmail">Email</label>
          <input id="signupEmail" name="email" type="email" placeholder="you@email.com" />
        </div>
        <div class="form-group">
          <label for="signupPassword">Password</label>
          <input id="signupPassword" name="password" type="password" placeholder="••••••••" />
        </div>
        <button class="btn-primary full-width" onclick="handleSignupSubmit(event)">
          Create Account &rarr;
        </button>
        <p class="modal-footer-text">
          Already have an account?
          <a href="#" onclick="switchLoginTab('login'); return false;"
            style="color:var(--accent,#3b82f6); text-decoration:none; font-weight:500;">
            Login
          </a>
        </p>
      </div>

    </div><!-- /.modal-body -->
  </div><!-- /.modal-content -->
</div><!-- /#loginModal -->


<!-- ══════════════════════════════════════════
     MODAL JAVASCRIPT
══════════════════════════════════════════ -->
<script>
  /* ─────────────────────────────────────────
     APPLY MODAL
  ───────────────────────────────────────── */
  function openApplyModal() {
    var modal = document.getElementById('apply-modal');
    if (!modal) return;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }

  function closeApplyModal() {
    var modal = document.getElementById('apply-modal');
    if (!modal) return;
    modal.style.display = 'none';
    document.body.style.overflow = '';
    var form    = document.getElementById('apply-form');
    var success = document.getElementById('apply-success');
    var btn     = document.getElementById('apply-submit-btn');
    if (form)    { form.style.display = 'block'; form.reset(); }
    if (success) { success.style.display = 'none'; }
    if (btn)     { btn.disabled = false; btn.innerHTML = 'Submit Application &rarr;'; }
  }

  function handleApplySubmit(e) {
    e.preventDefault();
    var form    = document.getElementById('apply-form');
    var success = document.getElementById('apply-success');
    var btn     = document.getElementById('apply-submit-btn');
    if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }
    setTimeout(function () {
      if (form)    form.style.display    = 'none';
      if (success) success.style.display = 'block';
      setTimeout(function () { closeApplyModal(); }, 2500);
    }, 800);
  }

  /* ─────────────────────────────────────────
     LOGIN / SIGNUP MODAL — tab switcher
     (open/close is handled by Navbar.php's initModal())
  ───────────────────────────────────────── */
  function switchLoginTab(tab) {
    var lf = document.getElementById('loginFields');
    var sf = document.getElementById('signupFields');
    var tl = document.getElementById('tabLoginBtn');
    var ts = document.getElementById('tabSignupBtn');
    if (!lf || !sf || !tl || !ts) return;

    if (tab === 'login') {
      lf.style.display = 'block';  sf.style.display = 'none';
      tl.style.background  = '#ffffff'; tl.style.color      = '#0f172a';
      tl.style.boxShadow   = '0 1px 3px rgba(0,0,0,.08)';
      ts.style.background  = 'transparent'; ts.style.color  = '#64748b';
      ts.style.boxShadow   = 'none';
    } else {
      sf.style.display = 'block';  lf.style.display = 'none';
      ts.style.background  = '#ffffff'; ts.style.color      = '#0f172a';
      ts.style.boxShadow   = '0 1px 3px rgba(0,0,0,.08)';
      tl.style.background  = 'transparent'; tl.style.color  = '#64748b';
      tl.style.boxShadow   = 'none';
    }
  }

  /* ─────────────────────────────────────────
     LOGIN SUBMIT (replace with real AJAX/fetch)
  ───────────────────────────────────────── */
  function handleLoginSubmit(e) {
    e.preventDefault();
    var email    = document.getElementById('loginEmail').value.trim();
    var password = document.getElementById('loginPassword').value;
    if (!email || !password) { alert('Please fill in all fields.'); return; }

    /* ── TODO: replace with your real login fetch/AJAX ── */
    /*
    fetch('actions/login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: email, password: password })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      if (data.success) { window.location.reload(); }
      else { alert(data.message || 'Login failed.'); }
    });
    */
    alert('Login submitted! Connect actions/login.php to handle.');
  }

  /* ─────────────────────────────────────────
     SIGNUP SUBMIT (replace with real AJAX/fetch)
  ───────────────────────────────────────── */
  function handleSignupSubmit(e) {
    e.preventDefault();
    var name     = document.getElementById('signupName').value.trim();
    var email    = document.getElementById('signupEmail').value.trim();
    var password = document.getElementById('signupPassword').value;
    if (!name || !email || !password) { alert('Please fill in all fields.'); return; }

    /* ── TODO: replace with your real signup fetch/AJAX ── */
    /*
    fetch('actions/signup.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name: name, email: email, password: password })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      if (data.success) { window.location.reload(); }
      else { alert(data.message || 'Signup failed.'); }
    });
    */
    alert('Signup submitted! Connect actions/signup.php to handle.');
  }

  /* ─────────────────────────────────────────
     ESC key — closes whichever modal is open
  ───────────────────────────────────────── */
  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;

    /* Apply modal */
    var applyM = document.getElementById('apply-modal');
    if (applyM && applyM.style.display === 'flex') { closeApplyModal(); return; }

    /* Login modal (Navbar's closeModal function) */
    var loginM = document.getElementById('loginModal');
    if (loginM && loginM.classList.contains('open')) {
      if (typeof window.closeModal === 'function') window.closeModal();
    }
  });
</script>
