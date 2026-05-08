/**
 * app.js — IIMs Courses PHP
 * Vanilla JS equivalent of React state / hooks / framer-motion behaviours
 */

/* ============================================================
   THEME (Dark / Light)
   ============================================================ */
function applyTheme(dark) {
  document.body.classList.toggle('dark', dark);
  document.getElementById('icon-sun')  && (document.getElementById('icon-sun').style.display  = dark ? 'block' : 'none');
  document.getElementById('icon-moon') && (document.getElementById('icon-moon').style.display = dark ? 'none'  : 'block');
  localStorage.setItem('iims-theme', dark ? 'dark' : 'light');
}
function toggleTheme() { applyTheme(!document.body.classList.contains('dark')); }

/* ============================================================
   NAVBAR SCROLL
   ============================================================ */
function initNavbar() {
  const navbar = document.getElementById('navbar');
  if (!navbar) return;
  const isHome = ['/', '/index.php', ''].some(p => location.pathname.endsWith(p));

  function update() {
    const scrolled = window.scrollY > 30;
    navbar.classList.toggle('scrolled', scrolled);
    navbar.classList.toggle('transparent', isHome && !scrolled);
  }
  window.addEventListener('scroll', update, { passive: true });
  update();
}

/* ============================================================
   MOBILE MENU
   ============================================================ */
function toggleMobileMenu() {
  const menu = document.getElementById('mobile-menu');
  if (!menu) return;
  menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

/* ============================================================
   NAV DROPDOWN
   ============================================================ */
function toggleDropdown(id) {
  const el = document.getElementById(id);
  if (!el) return;
  el.classList.toggle('open');
}
// Close dropdowns on outside click
document.addEventListener('click', (e) => {
  document.querySelectorAll('.nav-dropdown-wrap.open').forEach(dd => {
    if (!dd.contains(e.target)) dd.classList.remove('open');
  });
});

/* ============================================================
   MODALS
   ============================================================ */
function openModal(id, context) {
  const modal = document.getElementById(id);
  if (!modal) return;
  // Reset apply modal form if re-opening
  if (id === 'apply-modal') {
    const form    = document.getElementById('apply-form');
    const success = document.getElementById('apply-success');
    const btn     = document.getElementById('apply-submit-btn');
    if (form)    { form.style.display    = 'grid'; form.reset(); }
    if (success) { success.style.display = 'none'; }
    if (btn)     { btn.disabled = false; btn.textContent = 'Submit Application'; }
    if (context) {
      const desc = document.getElementById('apply-modal-desc');
      if (desc) desc.textContent = 'Get personalised counselling for ' + context + '.';
    }
  }
  modal.classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeModal(id) {
  const modal = document.getElementById(id);
  if (!modal) return;
  modal.classList.remove('open');
  document.body.style.overflow = '';
}
function closeModalOnBackdrop(event, id) {
  if (event.target === document.getElementById(id)) closeModal(id);
}
// Escape key
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') document.querySelectorAll('.modal-backdrop.open').forEach(m => closeModal(m.id));
});

/* ============================================================
   APPLY FORM SUBMIT (client-side demo; replace with real AJAX)
   ============================================================ */
function handleApplySubmit(event) {
  event.preventDefault();
  const btn = document.getElementById('apply-submit-btn');
  if (btn) { btn.disabled = true; btn.textContent = 'Submitting…'; }
  setTimeout(() => {
    const form    = document.getElementById('apply-form');
    const success = document.getElementById('apply-success');
    if (form)    form.style.display    = 'none';
    if (success) success.style.display = 'block';
    // Auto-close after 2.5s
    setTimeout(() => closeModal('apply-modal'), 2500);
  }, 900);
}

/* ============================================================
   LOGIN MODAL TOGGLE
   ============================================================ */
let _loginMode = 'login';
function toggleLoginMode() {
  _loginMode = _loginMode === 'login' ? 'signup' : 'login';
  const isSignup = _loginMode === 'signup';
  const title     = document.getElementById('login-title');
  const desc      = document.getElementById('login-desc');
  const nameGroup = document.getElementById('signup-name-group');
  const submitBtn = document.getElementById('login-submit-btn');
  const toggleBtn = document.getElementById('login-toggle-btn');
  if (title)     title.textContent     = isSignup ? 'Create account' : 'Welcome back';
  if (desc)      desc.textContent      = isSignup ? 'Join thousands of MBA aspirants.' : 'Login to track applications and saved colleges.';
  if (nameGroup) nameGroup.style.display = isSignup ? 'flex' : 'none';
  if (submitBtn) submitBtn.textContent = isSignup ? 'Sign Up' : 'Login';
  if (toggleBtn) toggleBtn.textContent = isSignup ? 'Already have an account? Login' : 'New here? Create account';
}
function handleLogin(event) {
  event.preventDefault();
  closeModal('login-modal');
  showToast(_loginMode === 'login' ? 'Logged in!' : 'Account created!');
}

/* ============================================================
   TESTIMONIALS SLIDER
   ============================================================ */
function initTestimonials() {
  const cards = document.querySelectorAll('.testimonial-slide');
  if (!cards.length) return;
  let current = 0;

  function show(i) {
    cards.forEach((c, idx) => c.classList.toggle('active-slide', idx === i));
    document.querySelectorAll('.t-dot').forEach((d, idx) => d.classList.toggle('active', idx === i));
    current = i;
  }

  document.getElementById('t-prev')?.addEventListener('click', () => show((current - 1 + cards.length) % cards.length));
  document.getElementById('t-next')?.addEventListener('click', () => show((current + 1) % cards.length));
  document.querySelectorAll('.t-dot').forEach((d, i) => d.addEventListener('click', () => show(i)));
  show(0);
}

/* ============================================================
   COUNTER (number animate on scroll)
   ============================================================ */
function animateCounter(el) {
  const to     = parseFloat(el.dataset.to);
  const suffix = el.dataset.suffix || '';
  const dur    = 1400;
  const t0     = performance.now();
  function tick(t) {
    const p  = Math.min((t - t0) / dur, 1);
    const val = Math.round(to * (1 - Math.pow(1 - p, 3)));
    el.textContent = val.toLocaleString('en-IN') + suffix;
    if (p < 1) requestAnimationFrame(tick);
  }
  requestAnimationFrame(tick);
}
function initCounters() {
  const counters = document.querySelectorAll('[data-counter]');
  if (!counters.length) return;
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        obs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });
  counters.forEach(c => obs.observe(c));
}

/* ============================================================
   FAQ ACCORDION
   ============================================================ */
function initFaq() {
  document.querySelectorAll('.faq-question').forEach(q => {
    q.addEventListener('click', () => {
      const item = q.closest('.faq-item');
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
      if (!isOpen) item.classList.add('open');
    });
  });
}

/* ============================================================
   SCROLL REVEAL (fade-up)
   ============================================================ */
function initScrollReveal() {
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.style.opacity = '1';
        e.target.style.transform = 'translateY(0)';
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.reveal').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(24px)';
    el.style.transition = 'opacity .5s ease, transform .5s ease';
    obs.observe(el);
  });
}

/* ============================================================
   TOAST NOTIFICATION
   ============================================================ */
let _toastTimeout;
function showToast(msg, type = 'success') {
  let toast = document.getElementById('iims-toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'iims-toast';
    toast.style.cssText = `position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;
      padding:.75rem 1.25rem;border-radius:12px;font-size:.9rem;font-weight:600;
      box-shadow:0 8px 24px rgba(0,0,0,.18);transition:opacity .3s,transform .3s;
      opacity:0;transform:translateY(8px);pointer-events:none;`;
    document.body.appendChild(toast);
  }
  toast.textContent = msg;
  toast.style.background = type === 'success' ? '#3ab07b' : '#e07b39';
  toast.style.color = '#fff';
  toast.style.opacity = '1';
  toast.style.transform = 'translateY(0)';
  clearTimeout(_toastTimeout);
  _toastTimeout = setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(8px)';
  }, 3000);
}

/* ============================================================
   COUNTDOWN TIMER (CAT 2026 deadline: Sep 13 2026)
   ============================================================ */
function initCountdown() {
  const target = new Date('2026-09-13T23:59:59');
  const els = {
    d: document.getElementById('cd-days'),
    h: document.getElementById('cd-hours'),
    m: document.getElementById('cd-mins'),
  };
  if (!els.d) return;
  function update() {
    const diff = target - new Date();
    if (diff <= 0) { els.d.textContent = '0'; els.h.textContent = '0'; els.m.textContent = '0'; return; }
    els.d.textContent = Math.floor(diff / 86400000);
    els.h.textContent = Math.floor((diff % 86400000) / 3600000);
    els.m.textContent = Math.floor((diff % 3600000)  / 60000);
  }
  update();
  setInterval(update, 60000);
}

/* ============================================================
   INIT
   ============================================================ */
document.addEventListener('DOMContentLoaded', () => {
  // Theme
  const saved = localStorage.getItem('iims-theme');
  applyTheme(saved === 'dark');

  initNavbar();
  initFaq();
  initCounters();
  initTestimonials();
  initScrollReveal();
  initCountdown();
});