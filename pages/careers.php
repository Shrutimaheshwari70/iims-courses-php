<?php
/**
 * pages/careers.php  ←→  src/routes/careers.tsx
 * Exact same UI as TypeScript version
 */
session_start();
$page_title       = 'Careers at IIMs Courses';
$page_description = 'Join a team helping 50,000+ aspirants find their dream IIM.';
$current_page     = 'careers';

$JOBS = [
  ['id'=>1,'title'=>'Senior Frontend Engineer', 'dept'=>'Engineering','loc'=>'Bengaluru / Remote','type'=>'Full-time','desc'=>'React + TanStack experience to build delightful experiences.'],
  ['id'=>2,'title'=>'Content Strategist (MBA)', 'dept'=>'Content',    'loc'=>'Bengaluru',         'type'=>'Full-time','desc'=>'MBA grad with strong writing chops to lead our editorial.'],
  ['id'=>3,'title'=>'Admissions Counsellor',    'dept'=>'Counselling','loc'=>'Remote',             'type'=>'Full-time','desc'=>'Guide aspirants through CAT, applications and interviews.'],
  ['id'=>4,'title'=>'Product Designer',         'dept'=>'Design',     'loc'=>'Bengaluru',          'type'=>'Full-time','desc'=>'Lead end-to-end design for student-facing products.'],
];

$depts  = array_unique(array_column($JOBS, 'dept'));
$filter = $_GET['dept'] ?? 'All';

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="careers-hero">
  <div class="container">
    <h1 class="careers-hero-title fade-up">
      Build the future of <span class="text-gradient-accent">MBA discovery</span>
    </h1>
    <p class="careers-hero-desc fade-up" style="animation-delay:.1s">
      Join a team helping 50,000+ aspirants find their dream IIM.
    </p>
  </div>
</section>


<!-- ============================================================
     FILTER TABS + JOB CARDS
     ============================================================ -->
<section class="section">
  <div class="container careers-wrap">

    <!-- Filter chips — "All" + each dept (same as TSX flex-wrap gap-2 mb-8) -->
    <div class="careers-filter">
      <a href="careers.php"
         class="careers-chip <?= $filter==='All' ? 'active' : '' ?>">
        All
      </a>
      <?php foreach ($depts as $d): ?>
        <a href="careers.php?dept=<?= urlencode($d) ?>"
           class="careers-chip <?= $filter===$d ? 'active' : '' ?>">
          <?= htmlspecialchars($d) ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Job cards — rounded-2xl border bg-card flex items-center -->
    <div class="jobs-list">
      <?php foreach ($JOBS as $j):
        if ($filter !== 'All' && $j['dept'] !== $filter) continue;
      ?>
        <div class="job-card reveal">

          <!-- Icon box — size-12 gradient-accent rounded-xl (same as TSX) -->
          <div class="job-icon-box">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
              <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </svg>
          </div>

          <!-- Info -->
          <div class="job-info">
            <div class="job-title"><?= htmlspecialchars($j['title']) ?></div>
            <div class="job-meta">
              <span><?= htmlspecialchars($j['dept']) ?></span>
              <span class="job-loc">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>
                  <circle cx="12" cy="10" r="3"/>
                </svg>
                <?= htmlspecialchars($j['loc']) ?>
              </span>
              <span><?= htmlspecialchars($j['type']) ?></span>
            </div>
          </div>

          <!-- Apply button -->
          <button
            class="btn btn-hero btn-sm job-apply-btn"
            onclick="openJobModal(<?= $j['id'] ?>, <?= json_encode($j['title']) ?>, <?= json_encode($j['desc']) ?>)"
          >
            Apply
          </button>

        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>


<!-- ============================================================
     APPLY MODAL  — Dialog (same as TSX DialogContent)
     ============================================================ -->
<div class="careers-modal-backdrop" id="jobModal" onclick="if(event.target===this)closeJobModal()">
  <div class="careers-modal-box">

    <!-- Header -->
    <div class="careers-modal-header">
      <h3 class="careers-modal-title" id="jmTitle">Apply</h3>
      <button class="modal-close" onclick="closeJobModal()" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>

    <!-- Job desc -->
    <p class="careers-modal-desc" id="jmDesc"></p>

    <!-- Form -->
    <form onsubmit="submitJobApp(event)" style="margin-top:.5rem">
      <input type="hidden" id="jmId" />

      <div class="form-group">
        <label>Name</label>
        <input type="text" required placeholder="Your full name" />
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" required placeholder="you@example.com" />
      </div>
      <div class="form-group">
        <label>Resume URL</label>
        <input type="url" required placeholder="LinkedIn / Drive link" />
      </div>

      <button type="submit" class="btn btn-hero form-submit" style="margin-top:1.25rem">
        Submit Application
      </button>
    </form>

  </div>
</div>


<style>
/* ===== CAREERS PAGE STYLES ===== */

/* Hero */
.careers-hero {
  background-image: var(--gradient-hero);
  padding: 8rem 0 4rem;
  color: #fff;
}
.careers-hero-title {
  font-family: var(--font-display);
  font-weight: 800;
  font-size: clamp(2.2rem, 5vw, 3.75rem);
  line-height: 1.1;
  letter-spacing: -0.02em;
  max-width: 800px;
}
.careers-hero-desc {
  color: rgba(255,255,255,.80);
  margin-top: 1rem;
  font-size: 1.1rem;
  max-width: 600px;
  line-height: 1.7;
}

/* Section wrapper — max-width 900px (same as TSX max-w-5xl) */
.careers-wrap { max-width: 900px; }

/* Filter chips */
.careers-filter {
  display: flex;
  flex-wrap: wrap;
  gap: .5rem;
  margin-bottom: 2rem;
}
.careers-chip {
  padding: .45rem 1.1rem;
  border-radius: 999px;
  font-size: .82rem;
  font-weight: 500;
  border: 1px solid var(--border);
  color: var(--foreground);
  text-decoration: none;
  transition: border-color .2s, background .2s, color .2s;
  background: none;
}
.careers-chip:hover {
  border-color: var(--accent);
}
.careers-chip.active {
  background-image: var(--gradient-accent);
  color: #fff;
  border-color: transparent;
}

/* Job cards list — grid gap-4 (same as TSX) */
.jobs-list {
  display: grid;
  gap: 1rem;
}

/* Job card — rounded-2xl border bg-card p-5 flex items-center gap-4 */
.job-card {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1rem;
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 1rem;
  padding: 1.25rem;
  transition: box-shadow .2s;
}
.job-card:hover { box-shadow: var(--shadow-card); }

/* Icon box — size-12 gradient-accent rounded-xl */
.job-icon-box {
  width: 48px;
  height: 48px;
  flex-shrink: 0;
  border-radius: .75rem;
  background-image: var(--gradient-accent);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
}
.job-icon-box svg { width: 20px; height: 20px; }

/* Info */
.job-info { flex: 1; min-width: 220px; }
.job-title {
  font-family: var(--font-display);
  font-weight: 600;
  font-size: 1.05rem;
  color: var(--foreground);
}
.job-meta {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: .75rem;
  margin-top: .3rem;
  font-size: .72rem;
  color: var(--muted-foreground);
}
.job-loc {
  display: inline-flex;
  align-items: center;
  gap: .2rem;
}
.job-loc svg { width: 11px; height: 11px; }

/* Apply button stays right */
.job-apply-btn { flex-shrink: 0; }

/* Modal backdrop */
.careers-modal-backdrop {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.55);
  z-index: 300;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}
.careers-modal-backdrop.open {
  display: flex;
}

/* Modal box — same as DialogContent */
.careers-modal-box {
  background: var(--card);
  border-radius: 1.25rem;
  padding: 2rem;
  width: 100%;
  max-width: 500px;
  box-shadow: var(--shadow-elegant);
  position: relative;
  animation: modalIn .25s ease;
}
@keyframes modalIn {
  from { opacity:0; transform:translateY(16px); }
  to   { opacity:1; transform:translateY(0); }
}

/* Modal header */
.careers-modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: .75rem;
}
.careers-modal-title {
  font-family: var(--font-display);
  font-weight: 700;
  font-size: 1.35rem;
  color: var(--foreground);
  margin: 0;
}
.careers-modal-desc {
  font-size: .875rem;
  color: var(--muted-foreground);
  line-height: 1.6;
}

/* Reuse modal-close from style.css but override positioning */
.careers-modal-box .modal-close {
  position: static;
  flex-shrink: 0;
}

/* fade-up */
@keyframes fadeUp {
  from { opacity:0; transform:translateY(20px); }
  to   { opacity:1; transform:translateY(0); }
}
.fade-up { animation: fadeUp .6s ease both; }
</style>


<script>
function openJobModal(id, title, desc) {
  document.getElementById('jmId').value           = id;
  document.getElementById('jmTitle').textContent  = title;
  document.getElementById('jmDesc').textContent   = desc;
  document.getElementById('jobModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeJobModal() {
  document.getElementById('jobModal').classList.remove('open');
  document.body.style.overflow = '';
}
function submitJobApp(e) {
  e.preventDefault();
  // Save to localStorage (same as TSX iims:applications)
  try {
    var apps = JSON.parse(localStorage.getItem('iims:applications') || '[]');
    apps.push({ jobId: document.getElementById('jmId').value, ts: Date.now() });
    localStorage.setItem('iims:applications', JSON.stringify(apps));
  } catch(err) {}
  closeJobModal();
  if (typeof showToast === 'function') {
    showToast('Application submitted!', 'success');
  } else {
    alert('Application submitted!');
  }
}
// Close on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeJobModal();
});
</script>


<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>