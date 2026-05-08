<?php
/**
 * careers.php  ←→  src/routes/careers.tsx
 */
session_start();
$page_title       = 'Careers at IIMs Courses';
$page_description = 'Join a team helping 50,000+ aspirants find their dream IIM.';
$current_page     = 'careers';

$JOBS = [
  ['id'=>1, 'title'=>'Senior Frontend Engineer',  'dept'=>'Engineering', 'loc'=>'Bengaluru / Remote', 'type'=>'Full-time', 'desc'=>'React + TanStack experience to build delightful experiences.'],
  ['id'=>2, 'title'=>'Content Strategist (MBA)',  'dept'=>'Content',     'loc'=>'Bengaluru',          'type'=>'Full-time', 'desc'=>'MBA grad with strong writing chops to lead our editorial.'],
  ['id'=>3, 'title'=>'Admissions Counsellor',     'dept'=>'Counselling', 'loc'=>'Remote',             'type'=>'Full-time', 'desc'=>'Guide aspirants through CAT, applications and interviews.'],
  ['id'=>4, 'title'=>'Product Designer',           'dept'=>'Design',      'loc'=>'Bengaluru',          'type'=>'Full-time', 'desc'=>'Lead end-to-end design for student-facing products.'],
];

include 'includes/header.php';
include 'components/Navbar.php';
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="gradient-hero pt-32 pb-16 text-white">
  <div class="container">
    <h1 class="font-display text-5xl md:text-6xl font-bold">
      Build the future of <span class="text-gradient-accent">MBA discovery</span>
    </h1>
    <p class="text-white-80 mt-4 text-lg max-w-2xl">Join a team helping 50,000+ aspirants find their dream IIM.</p>
  </div>
</section>


<!-- ============================================================
     JOB LISTINGS
     ============================================================ -->
<section class="section">
  <div class="container" style="max-width:900px">

    <!-- Department filter tabs -->
    <?php
    $depts = array_unique(array_column($JOBS, 'dept'));
    $filter = $_GET['dept'] ?? 'All';
    ?>
    <div class="careers-filter">
      <a href="careers.php" class="filter-chip <?= $filter==='All'?'active':'' ?>">All</a>
      <?php foreach ($depts as $d): ?>
        <a href="careers.php?dept=<?= urlencode($d) ?>" class="filter-chip <?= $filter===$d?'active':'' ?>">
          <?= htmlspecialchars($d) ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Job cards -->
    <div class="jobs-list">
      <?php foreach ($JOBS as $j):
        if ($filter !== 'All' && $j['dept'] !== $filter) continue;
      ?>
      <div class="job-card reveal">
        <div class="job-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
          </svg>
        </div>
        <div class="job-info">
          <div class="job-title"><?= htmlspecialchars($j['title']) ?></div>
          <div class="job-meta">
            <span><?= htmlspecialchars($j['dept']) ?></span>
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;display:inline">
                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
              </svg>
              <?= htmlspecialchars($j['loc']) ?>
            </span>
            <span><?= htmlspecialchars($j['type']) ?></span>
          </div>
          <p class="job-desc"><?= htmlspecialchars($j['desc']) ?></p>
        </div>
        <button class="btn btn-hero btn-sm" onclick="openJobModal(<?= $j['id'] ?>, '<?= addslashes($j['title']) ?>', '<?= addslashes($j['desc']) ?>')">
          Apply
        </button>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>


<!-- ============================================================
     APPLY MODAL
     ============================================================ -->
<div id="job-modal" class="modal-overlay" style="display:none" onclick="if(event.target===this)closeJobModal()">
  <div class="modal-box">
    <div class="modal-head">
      <h3 class="modal-title" id="jm-title"></h3>
      <button class="modal-close" onclick="closeJobModal()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <p class="text-muted text-sm" id="jm-desc" style="margin-bottom:1rem"></p>
    <form onsubmit="submitJob(event)">
      <input type="hidden" id="jm-id" />
      <div class="form-group">
        <label class="form-label">Name</label>
        <input type="text" class="form-input" required />
      </div>
      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" class="form-input" required />
      </div>
      <div class="form-group">
        <label class="form-label">Resume URL</label>
        <input type="url" class="form-input" required placeholder="LinkedIn / Drive link" />
      </div>
      <button type="submit" class="btn btn-hero" style="width:100%">Submit Application</button>
    </form>
  </div>
</div>

<script>
function openJobModal(id, title, desc) {
  document.getElementById('jm-id').value   = id;
  document.getElementById('jm-title').textContent = title;
  document.getElementById('jm-desc').textContent  = desc;
  document.getElementById('job-modal').style.display = 'flex';
}
function closeJobModal() {
  document.getElementById('job-modal').style.display = 'none';
}
function submitJob(e) {
  e.preventDefault();
  closeJobModal();
  showToast('Application submitted!', 'success');
}
</script>

<?php
include 'components/Footer.php';
include 'includes/footer.php';
?>