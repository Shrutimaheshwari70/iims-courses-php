<?php
/**
 * pages/careers.php  ←→  src/routes/careers.tsx
 * Exact same UI as TypeScript version
 */
session_start();
$page_title = 'Careers at IIMs Courses';
$page_description = 'Join a team helping 50,000+ aspirants find their dream IIM.';
$current_page = 'careers';

$JOBS = [
  ['id' => 1, 'title' => 'Senior Frontend Engineer', 'dept' => 'Engineering', 'loc' => 'Bengaluru / Remote', 'type' => 'Full-time', 'desc' => 'React + TanStack experience to build delightful experiences.'],
  ['id' => 2, 'title' => 'Content Strategist (MBA)', 'dept' => 'Content', 'loc' => 'Bengaluru', 'type' => 'Full-time', 'desc' => 'MBA grad with strong writing chops to lead our editorial.'],
  ['id' => 3, 'title' => 'Admissions Counsellor', 'dept' => 'Counselling', 'loc' => 'Remote', 'type' => 'Full-time', 'desc' => 'Guide aspirants through CAT, applications and interviews.'],
  ['id' => 4, 'title' => 'Product Designer', 'dept' => 'Design', 'loc' => 'Bengaluru', 'type' => 'Full-time', 'desc' => 'Lead end-to-end design for student-facing products.'],
];

$depts = array_unique(array_column($JOBS, 'dept'));
$filter = $_GET['dept'] ?? 'All';

include '../includes/header.php';
include '../components/Navbar.php';
?>
<?php
$JOBS = [
  ['id' => 1, 'title' => 'Senior Frontend Engineer', 'dept' => 'Engineering', 'loc' => 'Bengaluru / Remote', 'type' => 'Full-time', 'exp' => '4–7 yrs', 'salary' => '₹18–28 LPA', 'desc' => 'React + TanStack experience to build delightful student-facing experiences. You\'ll own performance, accessibility and the core product UI.', 'skills' => ['React', 'TypeScript', 'TanStack', 'Vite', 'CSS-in-JS']],
  ['id' => 2, 'title' => 'Content Strategist (MBA)', 'dept' => 'Content', 'loc' => 'Bengaluru', 'type' => 'Full-time', 'exp' => '2–5 yrs', 'salary' => '₹10–16 LPA', 'desc' => 'MBA grad with strong writing chops to lead our editorial calendar, produce CAT/MBA prep content, and manage a team of writers.', 'skills' => ['SEO', 'Editorial', 'MBA Knowledge', 'Analytics', 'CMS']],
  ['id' => 3, 'title' => 'Admissions Counsellor', 'dept' => 'Counselling', 'loc' => 'Remote', 'type' => 'Full-time', 'exp' => '1–3 yrs', 'salary' => '₹7–12 LPA', 'desc' => 'Guide aspirants through CAT prep, IIM applications, WAT-PI preparation and final admission strategy with expert mentorship.', 'skills' => ['Communication', 'CAT/MBA', 'Counselling', 'CRM', 'Hindi/English']],
  ['id' => 4, 'title' => 'Product Designer', 'dept' => 'Design', 'loc' => 'Bengaluru', 'type' => 'Full-time', 'exp' => '3–6 yrs', 'salary' => '₹14–22 LPA', 'desc' => 'Lead end-to-end product design for student-facing apps. Drive UX research, wireframes, prototypes and design system.', 'skills' => ['Figma', 'UX Research', 'Design Systems', 'Prototyping', 'Accessibility']],
  ['id' => 5, 'title' => 'Backend Engineer (Node.js)', 'dept' => 'Engineering', 'loc' => 'Bengaluru / Remote', 'type' => 'Full-time', 'exp' => '3–6 yrs', 'salary' => '₹16–26 LPA', 'desc' => 'Design and build scalable APIs, microservices and data pipelines powering our recommendation and analytics engines.', 'skills' => ['Node.js', 'PostgreSQL', 'Redis', 'AWS', 'GraphQL']],
  ['id' => 6, 'title' => 'Growth Marketing Manager', 'dept' => 'Marketing', 'loc' => 'Bengaluru', 'type' => 'Full-time', 'exp' => '3–5 yrs', 'salary' => '₹12–18 LPA', 'desc' => 'Own acquisition and retention across paid, organic, and partnership channels. Drive 2x growth in CAT aspirant sign-ups.', 'skills' => ['Performance Marketing', 'SEO', 'Meta Ads', 'Analytics', 'A/B Testing']],
  ['id' => 7, 'title' => 'Data Analyst', 'dept' => 'Analytics', 'loc' => 'Remote', 'type' => 'Full-time', 'exp' => '2–4 yrs', 'salary' => '₹9–15 LPA', 'desc' => 'Translate complex student journey data into actionable insights that drive product and counselling outcomes.', 'skills' => ['SQL', 'Python', 'Tableau', 'GA4', 'Data Modeling']],
  ['id' => 8, 'title' => 'CAT Faculty – Quantitative', 'dept' => 'Academics', 'loc' => 'Remote / Bengaluru', 'type' => 'Part-time', 'exp' => '3+ yrs', 'salary' => '₹1,500–3,000/hr', 'desc' => 'Deliver high-quality live and recorded sessions on Quant and DI/LR for CAT aspirants targeting top IIMs.', 'skills' => ['CAT QA', 'DI/LR', 'Live Teaching', 'Problem Design', 'Mentoring']],
];

$PERKS = [
  // ['icon'=>'bi-shield-heart','title'=>'Health & Wellness','desc'=>'Full family medical cover, monthly mental wellness sessions, and ₹5,000 gym allowance.'],
  ['icon' => 'bi-laptop', 'title' => 'Remote-First', 'desc' => 'Work from anywhere in India. ₹25,000 home-office setup stipend for all new joiners.'],
  ['icon' => 'bi-mortarboard', 'title' => '₹50K Learning Budget', 'desc' => 'Attend conferences, buy courses, or pursue certifications — fully sponsored annually.'],
  ['icon' => 'bi-graph-up-arrow', 'title' => 'ESOPs for Everyone', 'desc' => 'Every team member from intern to lead gets stock. Build wealth as the company grows.'],
  ['icon' => 'bi-airplane', 'title' => 'Retreats & Offsites', 'desc' => 'Two all-hands retreats yearly to destinations across India, plus monthly team events.'],
  ['icon' => 'bi-clock-history', 'title' => 'Flexible Hours', 'desc' => 'No 9-to-5. Own your schedule. Results matter, not hours logged. No-meeting Wednesdays.'],
];

$PROCESS = [
  ['num' => '01', 'icon' => 'bi-file-earmark-person', 'title' => 'Apply Online', 'desc' => 'Submit resume + a short note. Takes 5 minutes. Every application is read by a human.'],
  ['num' => '02', 'icon' => 'bi-telephone', 'title' => 'Screening Call', 'desc' => '30-min call with HR — your background, motivation and culture fit. Relaxed, no tricks.'],
  ['num' => '03', 'icon' => 'bi-code-slash', 'title' => 'Technical / Task Round', 'desc' => 'Role-specific assignment or live interview with your future team leads. Fair and practical.'],
  ['num' => '04', 'icon' => 'bi-people', 'title' => 'Culture Interview', 'desc' => 'Meet founders and senior leadership. Ask us anything — we mean it.'],
  ['num' => '05', 'icon' => 'bi-patch-check', 'title' => 'Offer in 48 hrs', 'desc' => 'Receive your offer within 48 hours of the final round. We move fast.'],
];

$TESTIMONIALS = [
  ['name' => 'Priya Sharma', 'role' => 'Senior Engineer', 'college' => 'IIT Bombay, 2019', 'quote' => 'The ownership I get here is unmatched. I shipped a feature used by 30,000 students in my first month. No other company moves this fast.', 'initials' => 'PS', 'clr' => '#1a2d50'],
  ['name' => 'Arjun Mehta', 'role' => 'Admissions Counsellor', 'college' => 'IIM Calcutta, 2021', 'quote' => 'Every day I help someone crack their dream college. The mission is real, the team is extraordinary, and I have never felt more purposeful at work.', 'initials' => 'AM', 'clr' => '#c2410c'],
  ['name' => 'Sneha Iyer', 'role' => 'Product Designer', 'college' => 'NID Ahmedabad, 2020', 'quote' => 'The design culture here is exceptional. We ship fast, iterate on real student feedback, and the team genuinely cares about craft and quality.', 'initials' => 'SI', 'clr' => '#065f46'],
];

$LIFE = [
  ['icon' => 'bi-broadcast', 'title' => 'Weekly All-Hands', 'desc' => 'Every Friday the full team syncs on what shipped, what\'s coming, and what we learned. Complete transparency always.'],
  ['icon' => 'bi-emoji-smile', 'title' => 'Peer Recognition', 'desc' => 'Nominate teammates publicly each month. Recognised and rewarded with bonus credits.'],
  ['icon' => 'bi-moon-stars', 'title' => 'No-Meeting Wednesdays', 'desc' => 'Deep-work time is protected. Every Wednesday is meeting-free for focus and flow.'],
  ['icon' => 'bi-trophy', 'title' => 'Top EdTech Employer 2024', 'desc' => 'Awarded by Great Place to Work India. 4.8★ on Glassdoor from 200+ real reviews.'],
  ['icon' => 'bi-gender-ambiguous', 'title' => '45% Women in Leadership', 'desc' => 'Diversity isn\'t a metric for us — it\'s core to who we are and how we make decisions.'],
  ['icon' => 'bi-lightning-charge', 'title' => 'Ship Fast, Learn Faster', 'desc' => '3 major product releases per month on average. Ideas go from Notion doc to prod in days.'],
];

$depts = ['All'];
foreach ($JOBS as $j) {
  if (!in_array($j['dept'], $depts))
    $depts[] = $j['dept'];
}
$filter = $_GET['dept'] ?? 'All';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Careers</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Bootstrap Icons only (no full Bootstrap CSS globally) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Bootstrap CSS scoped ONLY inside .bs via a style tag trick -->
  <style id="bs-scope-style"></style>

  <style>
    /* ===== CAREERS PAGE STYLES ===== */
    :root {
      --cc-navy: #0f1d3a;
      --cc-navy2: #1a2d50;
      --cc-navy3: #243660;
      --cc-orange: #f97316;
      --cc-orange2: #ea6c0d;
      --cc-orange-bg: #fff7ed;
      --cc-text: #111827;
      --cc-text2: #374151;
      --cc-muted: #6b7280;
      --cc-border: #e5e7eb;
      --cc-bg: #f8fafc;
      --cc-card: #ffffff;
      --cc-green: #059669;
      --cc-radius: 14px;
      --cc-radius-lg: 20px;
      --cc-shadow: 0 2px 16px rgba(0, 0, 0, .07);
      --cc-shadow-lg: 0 8px 40px rgba(0, 0, 0, .13);
    }

    /* ── Base wrappers ── */
    .cc-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1.5rem
    }

    /* ── Section Label / Title / Desc ── */
    .cc-label {
      background: var(--cc-orange-bg);
      color: var(--cc-orange);
      font-size: .72rem;
      letter-spacing: .1em;
      border-color: #fed7aa !important;
    }

    .cc-title {
      letter-spacing: -.025em;
      color: var(--cc-navy);
    }

    .cc-desc {
      color: var(--cc-muted);
      max-width: 580px;
    }

    /* .cc-center .cc-desc{margin:0 auto} */

    /* ── Divider ── */
    .cc-divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--cc-border), transparent);
      margin: 0
    }

    /* ================================================================
   1. WHY JOIN US
   ================================================================ */
.cc-why { background: var(--cc-bg); }
.cc-why-card {
  background: var(--cc-card);
  border: 1.5px solid var(--cc-border);
  position: relative;
  transition: all .9s cubic-bezier(.34,1.56,.64,1);
  height: 100%;
}
.cc-why-card::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--cc-orange), #ef4444);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform .35s ease;
}
.cc-why-card:hover { transform: translateY(-5px); box-shadow: var(--cc-shadow-lg); border-color: transparent; }
.cc-why-card:hover::after { transform: scaleX(1); }
.cc-why-icon {
  width: 52px; height: 52px;
  background: var(--cc-orange-bg);
 color: var(--cc-orange);
  transition: all .3s;
}
.cc-why-card:hover .cc-why-icon { background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2)); color: #fff; }
.cc-why-title {  color: var(--cc-navy);  }
.cc-why-body { color: var(--cc-muted); font-size: .875rem; line-height: 1.75; margin: 0; }
 

    /* ================================================================
   2. QUICK STATS STRIP
   ================================================================ */
    .cc-stats-strip {
      background: linear-gradient(135deg, var(--cc-navy) 0%, var(--cc-navy2) 100%);
    }
    .cc-stats-inner {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0
    }

    .cc-stat-item {
      border-right: 1px solid rgba(255, 255, 255, .1);
      position: relative
    }

    .cc-stat-item:last-child {
      border-right: none
    }

    .cc-stat-val {
      color: var(--cc-orange);
      line-height: 1;
      letter-spacing: -.02em
    }

    .cc-stat-lbl {
      display: block;
      color: rgba(255, 255, 255, .65);
      font-size: .8rem;
      letter-spacing: .02em
    }

    /* ================================================================
   3. JOB LISTINGS
   ================================================================ */
    .cc-chip {
      font-size: .8rem;
      border: 1.5px solid var(--cc-border);
      color: var(--cc-text2);
      transition: all .22s;
      cursor: pointer
    }

    .cc-chip:hover {
      border-color: var(--cc-orange);
      color: var(--cc-orange);
      background: var(--cc-orange-bg)
    }

    .cc-chip.active {
      background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2));
      color: #fff;
      border-color: transparent;
      box-shadow: 0 4px 16px rgba(15, 29, 58, .25)
    }

    .cc-chip .cc-cnt {
      background: rgba(255, 255, 255, .18);
      border-radius: 999px;
      padding: .08rem .45rem;
      font-size: .7rem
    }

    .cc-chip:not(.active) .cc-cnt {
      background: var(--cc-bg);
      color: var(--cc-muted)
    }
    .cc-job-card {
      border: 1.5px solid var(--cc-border);
      transition: all .25s;
      cursor: default
    }

    .cc-job-card:hover {
      border-color: #fdba74;
      box-shadow: 0 4px 28px rgba(249, 115, 22, .13);
      transform: translateX(5px)
    }

    .cc-job-icon {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2));
      flex-shrink: 0;
      transition: all .25s
    }

    .cc-job-card:hover .cc-job-icon {
      background: linear-gradient(135deg, var(--cc-orange), #ef4444)
    }

    .cc-job-body {
      flex: 1;
      min-width: 0
    }

    .cc-job-title-text {
      color: var(--cc-navy);
    }

    .cc-tag {
      font-size: .59rem;
      letter-spacing: .01em
    }

    .cc-tag-dept {
      background: #eff6ff;
      color: #1d4ed8
    }

    .cc-tag-loc {
      background: #f0fdf4;
      color: #15803d
    }

    .cc-tag-type {
      background: var(--cc-orange-bg);
      color: var(--cc-orange)
    }

    .cc-tag-exp {
      background: #fdf4ff;
      color: #7e22ce
    }

    .cc-job-right {
      align-items: flex-end;
      flex-shrink: 0
    }

    .cc-salary {
      font-size: .7rem;
      color: var(--cc-navy);
      white-space: nowrap
    }

    .cc-btn-apply {
      background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2));
      font-size: .78rem;
      cursor: pointer;
      transition: all .22s;
      letter-spacing: .01em
    }

    .cc-btn-apply:hover {
      background: linear-gradient(135deg, var(--cc-orange), #ef4444);
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(249, 115, 22, .32)
    }

    .cc-no-jobs {
      padding: 4rem;
      color: var(--cc-muted);
      border: 1.5px dashed var(--cc-border);
      border-radius: var(--cc-radius-lg)
    }

    .cc-no-jobs i {
      font-size: 2.5rem;  
      display: block;
      margin-bottom: 1rem;
      color: var(--cc-border)
    }

    /* Speculative CTA strip */
    .cc-speculative {
      background: linear-gradient(135deg, #fff7ed, #fff);
      border: 1.5px solid #fed7aa;
    }

    .cc-speculative p {
      color: var(--cc-text2);
      font-size: .88rem;
      margin: 0
    }

    .cc-speculative strong {
      color: var(--cc-navy)
    }

    .cc-btn-solid {
      background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2));
      font-size: .85rem;
      cursor: pointer;
      transition: all .22s;
    }
    .cc-btn-solid:hover {
      background: linear-gradient(135deg, var(--cc-orange), #ef4444);
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(249, 115, 22, .3)
    }

    /* ================================================================
   4. HIRING PROCESS
   ================================================================ */
    .cc-process {
      background: var(--cc-bg)
    }
    .cc-process-grid {
      grid-template-columns: repeat(5, 1fr);
      position: relative
    }
    .cc-process-grid::before {
      content: '';
      position: absolute;
      top: 37px;
      left: 8%;
      right: 8%;
      height: 2px;
      background: linear-gradient(90deg, rgba(249, 115, 22, .2), var(--cc-orange), rgba(249, 115, 22, .2));
      z-index: 0;
      pointer-events: none
    }

    .cc-pstep {
      position: relative;
      z-index: 1
    }

    .cc-pnum {
      width: 74px;
      height: 74px;
      border-radius: 50%;
      border: 2.5px solid var(--cc-border);
      margin: 0 auto 1.25rem;
      color: var(--cc-muted);
      transition: all .3s cubic-bezier(.34, 1.56, .64, 1);
      position: relative
    }

    .cc-pnum .cc-pnum-val {
      font-weight: 900;
      font-size: .78rem;
      position: absolute;
      bottom: -2px;
      right: -2px;
      background: var(--cc-orange-bg);
      color: var(--cc-orange);
      border-radius: 999px;
      width: 22px;
      height: 22px;
      font-size: .6rem;
      border: 2px solid #fff
    }

    .cc-pstep:hover .cc-pnum {
      background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2));
      border-color: var(--cc-navy);
      color: #fff;
      transform: scale(1.08) translateY(-3px);
      box-shadow: 0 8px 24px rgba(15, 29, 58, .25)
    }

    .cc-pstep:hover .cc-pnum .cc-pnum-val {
      background: var(--cc-orange);
      color: #fff
    }
    .cc-ptitle {
      font-size: .9rem;
      color: var(--cc-navy);
    }
    .cc-pdesc {
      color: var(--cc-muted);
      font-size: .78rem;
      line-height: 1.65
    }

    /* ================================================================
   5. PERKS
   ================================================================ */
.cc-perks {
  background: #fff;
}

.cc-perk-card {
  background: var(--cc-bg);
  border: 1.5px solid var(--cc-border);
  border-radius: var(--cc-radius-lg);
  padding: 1.75rem;
  transition: all .3s ease;
}

.cc-perk-card:hover {
  background: #fff;
  box-shadow: var(--cc-shadow-lg);
  transform: translateY(-3px);
  border-color: var(--cc-orange);
}

.cc-perk-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2));
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 1.15rem;
  transition: all .3s ease;
}

.cc-perk-card:hover .cc-perk-icon {
  background: linear-gradient(135deg, var(--cc-orange), #ef4444);
}

.cc-perk-title {
  font-weight: 600;
  font-size: .92rem;
  color: var(--cc-navy);
  margin-bottom: .35rem;
}

.cc-perk-body {
  color: var(--cc-muted);
  font-size: .84rem;
  line-height: 1.7;
}
    /* ================================================================
   6. LIFE AT COMPANY
   ================================================================ */
   .cc-life {
  background: var(--cc-bg);
}

.cc-life-card {
  background: #fff;
  border: 1.5px solid var(--cc-border);
  border-radius: var(--cc-radius);
  padding: 1.25rem 1.5rem;
  transition: all .3s ease;
}

.cc-life-card:hover {
  border-color: #fdba74;
  box-shadow: var(--cc-shadow);
  transform: translateX(4px);
}

.cc-life-icon {
  width: 42px;
  height: 42px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.05rem;
  transition: all .3s ease;
}

.cc-life-icon.ora {
  background: var(--cc-orange-bg);
  color: var(--cc-orange);
}

.cc-life-icon.nvy {
  background: #eff6ff;
  color: #1d4ed8;
}

.cc-life-icon.grn {
  background: #f0fdf4;
  color: #15803d;
}

.cc-life-card:hover .cc-life-icon {
  background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2));
  color: #fff;
}

.cc-life-title {
  font-weight: 600;
  font-size: .9rem;
  color: var(--cc-navy);
  margin-bottom: .2rem;
}

.cc-life-body {
  color: var(--cc-muted);
  font-size: .82rem;
  line-height: 1.65;
}

/* Stats */
.cc-lstat {
  background: #fff;
  border: 1.5px solid var(--cc-border);
  border-radius: var(--cc-radius-lg);
  padding: 1.75rem;
  text-align: center;
  position: relative;
  overflow: hidden;
  transition: all .3s ease;
}

.cc-lstat::before {
  content: '';
  position: absolute;
  inset: 0 0 auto 0;
  height: 3px;
  background: linear-gradient(90deg, var(--cc-orange), #ef4444);
}

.cc-lstat:hover {
  box-shadow: var(--cc-shadow-lg);
  transform: translateY(-3px);
}

.cc-lstat-val {
  font-size: 2rem;
  font-weight: 900;
  color: var(--cc-navy);
  display: block;
  line-height: 1;
  letter-spacing: -.02em;
}

.cc-lstat-lbl {
  color: var(--cc-muted);
  font-size: .78rem;
  margin-top: .4rem;
  display: block;
  line-height: 1.5;
}

.cc-lstat-icon {
  font-size: 1.5rem;
  margin-bottom: .6rem;
  display: block;
}
@media (max-width: 576px) {
  .cc-lstat {
    padding: 1.2rem;
  }

  .cc-lstat-val {
    font-size: 1.45rem;
  }

  .cc-lstat-lbl {
    font-size: .72rem;
    line-height: 1.4;
  }

  .cc-lstat-icon {
    font-size: 1.2rem;
    margin-bottom: .45rem;
  }
}
    /* ================================================================
   7. TESTIMONIALS
   ================================================================ */
.cc-testi {
  background: #fff;
}

.cc-tcard {
  background: var(--cc-bg);
  border: 1.5px solid var(--cc-border);
  border-radius: var(--cc-radius-lg);
  padding: 1.85rem;
  transition: all .3s ease;
  overflow: hidden;
}

.cc-tcard::before {
  content: "\201C";
  position: absolute;
  top: 1.25rem;
  right: 1.5rem;
  font-size: 4rem;
  color: var(--cc-border);
  line-height: 1;
  font-weight: 900;
  pointer-events: none;
}

.cc-tcard:hover {
  background: #fff;
  box-shadow: var(--cc-shadow-lg);
  transform: translateY(-4px);
  border-color: #fdba74;
}

.cc-tquote {
  font-size: .88rem;
  color: var(--cc-text2);
  line-height: 1.8;
  font-style: italic;
  position: relative;
  z-index: 2;
}

.cc-tauthor {
  position: relative;
  z-index: 2;
}

.cc-tavatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: .82rem;
  color: #fff;
}

.cc-tname {
  font-weight: 600;
  font-size: .88rem;
  color: var(--cc-navy);
}

.cc-trole {
  font-size: .75rem;
  color: var(--cc-muted);
}

@media (max-width: 576px) {
  .cc-tcard {
    padding: 1.4rem;
  }

  .cc-tquote {
    font-size: .82rem;
    line-height: 1.7;
  }

  .cc-tcard::before {
    font-size: 3rem;
    top: 1rem;
    right: 1rem;
  }
}
    /* ================================================================
   8. CONTACT / ENQUIRY FORM
   ================================================================ */
    .cc-contact {
      background: var(--cc-bg)
    }

    .cc-contact-inner {
      display: grid;
      grid-template-columns: 1fr 1.2fr;
      gap: 4rem;
      align-items: start;
      margin-top: 3.5rem
    }

    .cc-info-list {
      display: flex;
      flex-direction: column;
      gap: 1.35rem
    }

    .cc-info-item {
      display: flex;
      gap: 1rem;
      align-items: flex-start
    }

    .cc-info-icon-box {
      width: 46px;
      height: 46px;
      border-radius: 12px;
      background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2));
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.05rem;
      flex-shrink: 0
    }

    .cc-info-title {
      font-weight: 600;
      font-size: .9rem;
      color: var(--cc-navy);
      margin-bottom: .2rem
    }

    .cc-info-text {
      color: var(--cc-muted);
      font-size: .84rem;
      line-height: 1.6
    }

    .cc-info-link {
      color: var(--cc-orange);
      font-weight: 600;
      font-size: .84rem
    }

    .cc-referral-box {
      background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2));
      border-radius: var(--cc-radius-lg);
      padding: 1.5rem;
      margin-top: 1.5rem;
      position: relative;
      overflow: hidden
    }

    .cc-referral-box::after {
      content: '';
      position: absolute;
      bottom: -30px;
      right: -30px;
      width: 100px;
      height: 100px;
      background: rgba(249, 115, 22, .2);
      border-radius: 50%
    }

    .cc-referral-title {
      font-weight: 600;
      font-size: .95rem;
      color: #fff;
      margin-bottom: .4rem;
      display: flex;
      align-items: center;
      gap: .4rem
    }

    .cc-referral-body {
      color: rgba(255, 255, 255, .65);
      font-size: .83rem;
      line-height: 1.65
    }

    .cc-referral-amount {
      color: var(--cc-orange);
      font-weight: 900
    }

    .cc-form-card {
      background: #fff;
      border: 1.5px solid var(--cc-border);
      border-radius: var(--cc-radius-lg);
      padding: 2.25rem;
      box-shadow: var(--cc-shadow)
    }

    .cc-form-title {
      font-weight: 600;
      font-size: 1.1rem;
      color: var(--cc-navy);
      margin-bottom: 1.6rem
    }

    .cc-form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem
    }

    .cc-form-group {
      margin-bottom: 1.15rem
    }

    .cc-form-group label {
      display: block;
      font-weight: 600;
      font-size: .8rem;
      color: var(--cc-text2);
      margin-bottom: .4rem;
      letter-spacing: .01em
    }

    .cc-form-group input,
    .cc-form-group textarea,
    .cc-form-group select {
      width: 100%;
      padding: .75rem 1rem;
      border: 1.5px solid var(--cc-border);
      border-radius: 10px;
      font-size: .875rem;
      color: var(--cc-text);
      transition: border-color .2s, box-shadow .2s;
      background: #fff;
      font-family: inherit
    }

    .cc-form-group input:focus,
    .cc-form-group textarea:focus,
    .cc-form-group select:focus {
      outline: none;
      border-color: var(--cc-navy);
      box-shadow: 0 0 0 3px rgba(15, 29, 58, .08)
    }

    .cc-form-group textarea {
      resize: vertical;
      min-height: 105px
    }

    .cc-btn-submit {
      width: 100%;
      padding: .9rem;
      background: linear-gradient(135deg, var(--cc-navy), var(--cc-navy2));
      color: #fff;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      font-size: .93rem;
      cursor: pointer;
      transition: all .22s;
      letter-spacing: .01em;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .5rem
    }

    .cc-btn-submit:hover {
      background: linear-gradient(135deg, var(--cc-orange), #ef4444);
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(249, 115, 22, .32)
    }

    /* ================================================================
   JOB DETAIL MODAL
   ================================================================ */
    .cc-modal-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .6);
      z-index: 2000;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      backdrop-filter: blur(6px)
    }

    .cc-modal-backdrop.open {
      display: flex
    }

    .cc-modal-box {
      background: #fff;
      border-radius: 1.5rem;
      padding: 2.25rem;
      width: 100%;
      max-width: 550px;
      max-height: 92vh;
      overflow-y: auto;
      position: relative;
      animation: ccModalIn .3s cubic-bezier(.34, 1.56, .64, 1)
    }

    @keyframes ccModalIn {
      from {
        opacity: 0;
        transform: translateY(28px) scale(.96)
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1)
      }
    }

    .cc-modal-hdr {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      margin-bottom: 1rem
    }

    .cc-modal-title-wrap {}

    .cc-modal-badge {
      display: inline-flex;
      align-items: center;
      gap: .3rem;
      background: var(--cc-orange-bg);
      color: var(--cc-orange);
      font-size: .68rem;
      font-weight: 600;
      padding: .2rem .6rem;
      border-radius: 999px;
      margin-bottom: .4rem;
      letter-spacing: .05em;
      text-transform: uppercase
    }

    .cc-modal-title {
      font-weight: 900;
      font-size: 1.25rem;
      color: var(--cc-navy);
      margin: 0;
      line-height: 1.2
    }

    .cc-modal-close {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--cc-bg);
      border: 1.5px solid var(--cc-border);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      color: var(--cc-muted);
      flex-shrink: 0;
      transition: all .2s
    }

    .cc-modal-close:hover {
      background: var(--cc-border);
      color: var(--cc-text)
    }

    .cc-modal-meta {
      display: flex;
      flex-wrap: wrap;
      gap: .4rem;
      margin-bottom: 1.1rem
    }

    .cc-modal-desc {
      font-size: .875rem;
      color: var(--cc-text2);
      line-height: 1.75;
      padding: .9rem 1rem;
      background: var(--cc-bg);
      border-radius: 10px;
      margin-bottom: 1.1rem;
      border-left: 3px solid var(--cc-orange)
    }

    .cc-modal-skills-wrap {
      margin-bottom: 1.35rem
    }

    .cc-modal-skills-lbl {
      font-size: .72rem;
      font-weight: 600;
      color: var(--cc-muted);
      letter-spacing: .08em;
      text-transform: uppercase;
      margin-bottom: .5rem
    }

    .cc-modal-skills {
      display: flex;
      flex-wrap: wrap;
      gap: .4rem
    }

    .cc-skill {
      background: var(--cc-orange-bg);
      color: var(--cc-orange);
      font-size: .72rem;
      font-weight: 600;
      padding: .25rem .65rem;
      border-radius: 7px;
      border: 1px solid #fed7aa
    }

    /* General Apply Modal */
    .cc-gmodal-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .6);
      z-index: 2000;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      backdrop-filter: blur(6px)
    }

    .cc-gmodal-backdrop.open {
      display: flex
    }

    /* Toast */
    .cc-toast {
      position: fixed;
      bottom: 1.75rem;
      right: 1.75rem;
      z-index: 9999;
      padding: .85rem 1.5rem;
      border-radius: 12px;
      font-size: .88rem;
      font-weight: 600;
      color: #fff;
      box-shadow: 0 4px 24px rgba(0, 0, 0, .22);
      animation: ccToast .3s ease;
      display: flex;
      align-items: center;
      gap: .5rem;
      max-width: 320px
    }

    .cc-toast.success {
      background: linear-gradient(135deg, #059669, #047857)
    }

    .cc-toast.error {
      background: linear-gradient(135deg, #dc2626, #b91c1c)
    }

    @keyframes ccToast {
      from {
        transform: translateY(16px);
        opacity: 0
      }

      to {
        transform: translateY(0);
        opacity: 1
      }
    }

    /* ── Scroll Reveal ── */
    .cc-reveal {
      opacity: 0;
      transform: translateY(22px);
      transition: opacity .6s ease, transform .6s ease
    }

    .cc-reveal.cc-visible {
      opacity: 1;
      transform: translateY(0)
    }

    /* ================================================================
   RESPONSIVE
   ================================================================ */
    @media(max-width:1024px) {
      .cc-why-grid {
        grid-template-columns: repeat(2, 1fr)
      }

      .cc-stats-inner {
        grid-template-columns: repeat(2, 1fr)
      }

      .cc-stat-item:nth-child(2) {
        border-right: none
      }

      .cc-stat-item:nth-child(3) {
        border-right: 1px solid rgba(255, 255, 255, .1)
      }

      .cc-stat-item:nth-child(3),
      .cc-stat-item:nth-child(4) {
        border-top: 1px solid rgba(255, 255, 255, .1)
      }

      .cc-process-grid {
        grid-template-columns: repeat(3, 1fr)
      }

      .cc-process-grid::before {
        display: none
      }

      .cc-perks-grid {
        grid-template-columns: repeat(2, 1fr)
      }

      .cc-testi-grid {
        grid-template-columns: 1fr 1fr
      }

      .cc-life-inner {
        grid-template-columns: 1fr
      }

      .cc-contact-inner {
        grid-template-columns: 1fr
      }
    }

    @media(max-width:768px) {
      .cc-section {
        padding: 3.5rem 0
      }

      .cc-why-grid {
        grid-template-columns: 1fr
      }

      .cc-stats-inner {
        grid-template-columns: 1fr 1fr
      }

      .cc-stat-item {
        border-right: none !important;
        border-top: none !important;
        border-bottom: 1px solid rgba(255, 255, 255, .08)
      }

      .cc-stat-item:last-child {
        border-bottom: none
      }

      .cc-process-grid {
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem
      }

      .cc-perks-grid {
        grid-template-columns: 1fr
      }

      .cc-testi-grid {
        grid-template-columns: 1fr
      }

      .cc-life-stats {
        grid-template-columns: 1fr 1fr
      }

      .cc-form-row {
        grid-template-columns: 1fr
      }

      .cc-job-card {
        flex-wrap: wrap
      }

      .cc-job-right {
        flex-direction: row;
        align-items: center;
        width: 100%;
        justify-content: space-between
      }

      .cc-speculative {
        flex-direction: column;
        text-align: center
      }

      .cc-contact-inner {
        gap: 2.5rem
      }
    }

    @media(max-width:480px) {
      .cc-stats-inner {
        grid-template-columns: 1fr 1fr
      }

      .cc-process-grid {
        grid-template-columns: 1fr
      }

      .cc-life-stats {
        grid-template-columns: 1fr
      }

      .cc-modal-box {
        padding: 1.5rem
      }
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

    /* Section wrapper — max-width 900px (same as TSX max-w-5xl) */
    .careers-wrap {
      max-width: 900px;
    }

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

    /* Job card — rounded border bg-card p-5 flex items-center gap-4 */
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

    .job-card:hover {
      box-shadow: var(--shadow-card);
    }

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

    .job-icon-box svg {
      width: 20px;
      height: 20px;
    }

    /* Info */
    .job-info {
      flex: 1;
      min-width: 220px;
    }

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

    .job-loc svg {
      width: 11px;
      height: 11px;
    }

    /* Apply button stays right */
    .job-apply-btn {
      flex-shrink: 0;
    }

    /* Modal backdrop */
    .careers-modal-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .55);
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
      from {
        opacity: 0;
        transform: translateY(16px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
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
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-up {
      animation: fadeUp .6s ease both;
    }
  </style>

</head>

<body>

  <div class="bs">
    <!-- HERO -->
    <section class="c-hero">
      <div class="container position-relative" style="z-index:1;">
        <div class="c-badge d-inline-flex px-3 py-1 rounded align-items-center mb-2 text-uppercase gap-2">
          <i class="bi bi-mortarboard-fill"></i> Career Counselling
        </div>
        <h1 class="text-white fw-bold ">Build the future of <span>Master's Degree</span></h1>
        <p class="text-light"> Join a team helping 50,000+ aspirants find their dream IIM.</p>
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
  </div>

  <div class="cc-divider"></div>
  <section class="cc-why py-5">
  <div class="container">
    <div class="text-center d-flex align-items-center justify-content-center flex-column">
      <div class="cc-label d-inline-flex align-items-center gap-2 text-uppercase fw-semibold rounded-pill px-3 py-2 mb-3 border">
        <i class="bi bi-heart-fill"></i> Why IIMsCourses
      </div>
      <h2 class="cc-title fw-semibold fs-1">More than just a job</h2>
      <p class="cc-desc">We believe great work comes from people who feel trusted, supported, and genuinely connected to the mission.</p>
    </div>
 
    <div class="row g-3 mt-4">
      <div class="col-md-6 col-lg-4">
        <div class="cc-why-card overflow-hidden py-4 px-4 rounded-4 cc-reveal">
          <div class="cc-why-icon rounded-3 d-flex align-items-center justify-content-center fs-5 mb-3"><i class="bi bi-bullseye"></i></div>
          <div class="cc-why-title fw-semibold fs-6 mb-2">Mission-Driven Work</div>
          <p class="cc-why-body">Every line of code, every article, every counselling session directly impacts a student's future. Your work matters here — measurably, every single day.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="cc-why-card overflow-hidden py-4 px-4 rounded-4 cc-reveal">
          <div class="cc-why-icon rounded-3 d-flex align-items-center justify-content-center fs-5 mb-3"><i class="bi bi-rocket-takeoff-fill"></i></div>
          <div class="cc-why-title fw-semibold fs-6 mb-2">Real Ownership</div>
          <p class="cc-why-body">No bureaucracy. Engineers ship features. Designers own flows. Counsellors shape strategy. We hand you a problem and trust you completely to solve it.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="cc-why-card overflow-hidden py-4 px-4 rounded-4 cc-reveal">
          <div class="cc-why-icon rounded-3 d-flex align-items-center justify-content-center fs-5 mb-3"><i class="bi bi-people-fill"></i></div>
          <div class="cc-why-title fw-semibold fs-6 mb-2">Exceptional Team</div>
          <p class="cc-why-body">Work alongside IIM alumni, IIT engineers, and ed-tech veterans who are among the best in their fields. You will raise your game every single day.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="cc-why-card overflow-hidden py-4 px-4 rounded-4 cc-reveal">
          <div class="cc-why-icon rounded-3 d-flex align-items-center justify-content-center fs-5 mb-3"><i class="bi bi-graph-up-arrow"></i></div>
          <div class="cc-why-title fw-semibold fs-6 mb-2">ESOPs for Everyone</div>
          <p class="cc-why-body">Every team member — from interns to leads — gets stock options. When the company wins, you win. Shared success is not just a tagline here.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="cc-why-card overflow-hidden py-4 px-4 rounded-4 cc-reveal">
          <div class="cc-why-icon rounded-3 d-flex align-items-center justify-content-center fs-5 mb-3"><i class="bi bi-geo-alt-fill"></i></div>
          <div class="cc-why-title fw-semibold fs-6 mb-2">Flexible &amp; Remote-First</div>
          <p class="cc-why-body">Work from Bengaluru, Pune, or your hometown in Rajasthan. We judge you by output, not presence. Results over optics — always, without exception.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="cc-why-card overflow-hidden py-4 px-4 rounded-4 cc-reveal">
          <div class="cc-why-icon rounded-3 d-flex align-items-center justify-content-center fs-5 mb-3"><i class="bi bi-award-fill"></i></div>
          <div class="cc-why-title fw-semibold fs-6 mb-2">Fast Career Growth</div>
          <p class="cc-why-body">In 18 months you can go from engineer to tech lead. Our growth is your growth. Promotions are based purely on impact and ownership, never tenure.</p>
        </div>
      </div>
    </div>
  </div>
</section>
 

  <!-- ══════════════════════════════════════════════════
     QUICK STATS STRIP
     ══════════════════════════════════════════════════ -->
  <div class="cc-stats-strip py-4">
    <div class="cc-container ">
      <div class="cc-stats-inner">
        <div class="cc-stat-item text-center py-4 cc-reveal">
          <span class="cc-stat-val fs-2 d-block fw-bold">50,000+</span>
          <span class="cc-stat-lbl mt-3">Students Helped Every Year</span>
        </div>
        <div class="cc-stat-item text-center py-4 cc-reveal">
          <span class="cc-stat-val fs-2 d-block fw-bold">200+</span>
          <span class="cc-stat-lbl mt-3">IIM Converts Annually</span>
        </div>
        <div class="cc-stat-item text-center py-4 cc-reveal">
          <span class="cc-stat-val fs-2 d-block fw-bold">4.8 ★</span>
          <span class="cc-stat-lbl mt-3">Glassdoor Employee Rating</span>
        </div>
        <div class="cc-stat-item text-center py-4 cc-reveal">
          <span class="cc-stat-val fs-2 d-block fw-bold">94%</span>
          <span class="cc-stat-lbl mt-3">Employee Retention Rate</span>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════════
     SECTION 2 — OPEN ROLES
     ══════════════════════════════════════════════════ -->
  <div class="cc-divider"></div>
  <section class="cc-section py-5 bg-whtie cc-jobs" id="cc-openings">
    <div class="cc-container ">
    <div class="text-center d-flex flex-column align-items-center justify-content-center">
  <div
    class="cc-label d-inline-flex align-items-center gap-2 text-uppercase fw-semibold rounded-pill px-3 py-2 mb-3 border">
    <i class="bi bi-briefcase-fill"></i> Open Positions
  </div>

  <h2 class="cc-title fw-semibold fs-1">Find your role</h2>

  <p class="cc-desc">
    We're building across engineering, content, design, counselling, marketing, and more.
  </p>
</div>

      <!-- Filter chips -->
      <div class="cc-filter-wrap d-flex flex-wrap gap-3 my-4">
        <?php
        $dept_counts = array_count_values(array_column($JOBS, 'dept'));
        foreach ($depts as $d):
          $cnt = ($d === 'All') ? count($JOBS) : ($dept_counts[$d] ?? 0);
          ?>
          <a href="?dept=<?= urlencode($d) ?>#cc-openings" class="cc-chip d-inline-flex py-1 px-2 rounded-3 text-center text-decoration-none fw-semibold bg-white gap-2 <?= $filter === $d ? 'active' : '' ?>">
            <?= htmlspecialchars($d) ?>
            <span class="cc-cnt"><?= $cnt ?></span>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Job cards -->
      <div class="cc-jobs-grid d-grid  gap-3">
        <?php
        $shown = 0;
        $icons = ['Engineering' => 'bi-code-slash', 'Content' => 'bi-pen-fill', 'Counselling' => 'bi-chat-heart-fill', 'Design' => 'bi-palette-fill', 'Marketing' => 'bi-megaphone-fill', 'Analytics' => 'bi-bar-chart-fill', 'Academics' => 'bi-mortarboard-fill'];
        foreach ($JOBS as $j):
          if ($filter !== 'All' && $j['dept'] !== $filter)
            continue;
          $shown++;
          $icon = $icons[$j['dept']] ?? 'bi-briefcase-fill';
          ?>
          <div class="cc-job-card d-flex align-items-center  py-4 px-3 rounded-4 gap-3 cc-reveal">
            <div class="cc-job-icon text-white d-flex align-items-center justify-content-center rounded-3"><i class="bi <?= $icon ?>"></i></div>
            <div class="cc-job-body">
              <div class="cc-job-title-text fw-semibold mb-2"><?= htmlspecialchars($j['title']) ?></div>
              <div class="cc-tags  d-flex flex-wrap gap-2">
                <span class="cc-tag py-1 px-1 rounded-1 fw-semibold cc-tag-dept"><?= htmlspecialchars($j['dept']) ?></span>
                <span class="cc-tag py-1 px-1 rounded-1 fw-semibold cc-tag-loc"><i class="bi bi-geo-alt-fill"></i>
                  <?= htmlspecialchars($j['loc']) ?></span>
                <span class="cc-tag py-1 px-1 rounded-1 fw-semibold cc-tag-type"><?= htmlspecialchars($j['type']) ?></span>
                <span class="cc-tag py-1 px-1 rounded-1 fw-semibold cc-tag-exp"><i class="bi bi-clock-fill"></i> <?= htmlspecialchars($j['exp']) ?></span>
              </div>
            </div>
            <div class="cc-job-right d-flex flex-column gap-2">
              <span class="cc-salary fw-semibold"><?= htmlspecialchars($j['salary']) ?></span>
              <button class="cc-btn-apply text-white py-1 px-2 border-0 rounded-2" onclick="openApplyModal()">
                Apply Now
              </button>
            </div>
          </div>
        <?php endforeach; ?>
        <?php if ($shown === 0): ?>
          <div class="cc-no-jobs text-center">
            <i class="bi bi-search"></i>
            No open roles in this department right now.<br>
            <span style="font-size:.85rem">Check back soon, or drop a general application below.</span>
          </div>
        <?php endif; ?>
      </div>

      <!-- Speculative application strip -->
      <div class="cc-speculative cc-reveal py-4 px-3 mt-4 d-flex align-items-center justify-content-between gap-5 flex-wrap rounded-4">
        <p><strong>Don't see a perfect fit?</strong> We love exceptional people even when there's no exact opening for
          them.</p>
        <button class="cc-btn-solid text-white border-0 gap-2 d-inline-flex align-items-center py-2 px-2 rounded-2 fw-semibold" onclick="ccOpenGeneralModal()">
          <i class="bi bi-send-fill"></i> Drop a General Application
        </button>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════
     SECTION 3 — HIRING PROCESS
     ══════════════════════════════════════════════════ -->
  <div class="cc-divider"></div>
  <section class="cc-section py-5 cc-process">
    <div class="cc-container ">
      <div class="cc-center text-center d-flex flex-column align-items-center justify-content-center">
        <div
          class="cc-label d-inline-flex align-items-center gap-2 text-uppercase fw-semibold rounded-pill px-3 py-2 mb-3 border">
          <i class="bi bi-diagram-3-fill"></i> Hiring Process
        </div>
        <h2 class="cc-title fw-semibold fs-1">Simple, fast &amp; respectful</h2>
        <p class="cc-desc">We respect your time. Most hires complete the entire process in under 2 weeks, with no
          surprise rounds.</p>
      </div>
      <div class="cc-process-grid d-grid gap-2 mt-3">
        <?php foreach ($PROCESS as $p): ?>
          <div class="cc-pstep text-center cc-reveal">
            <div class="cc-pnum d-flex align-items-center justify-content-center bg-white fs-5">
              <i class="bi <?= $p['icon'] ?>"></i>
              <span class="cc-pnum-val d-flex align-items-center justify-content-center fw-semibold"><?= $p['num'] ?></span>
            </div>
            <div class="cc-ptitle fw-semibold mb-1"><?= htmlspecialchars($p['title']) ?></div>
            <p class="cc-pdesc"><?= htmlspecialchars($p['desc']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════
     SECTION 4 — PERKS & BENEFITS
     ══════════════════════════════════════════════════ -->
  <div class="cc-divider"></div>
<section class="cc-section py-5 bg-white cc-perks">
  <div class="container">

    <!-- Heading -->
    <div class="cc-center text-center d-flex flex-column align-items-center justify-content-center">
      <div class="cc-label d-inline-flex align-items-center gap-2 text-uppercase fw-semibold rounded-pill px-3 py-2 mb-3 border">
        <i class="bi bi-gift-fill"></i>
        Perks &amp; Benefits
      </div>

      <h2 class="cc-title fw-semibold display-5">
        We take care of our people
      </h2>

      <p class="cc-desc text-secondary">
        Comprehensive benefits designed for the way modern professionals actually work and live.
      </p>
    </div>

    <!-- Bootstrap Grid -->
    <div class="row g-4 mt-4">

      <?php foreach ($PERKS as $pk): ?>
        <div class="col-lg-4 col-md-6">

          <div class="cc-perk-card h-100 d-flex align-items-start gap-3">

            <!-- Icon -->
            <div class="cc-perk-icon flex-shrink-0">
              <i class="bi <?= $pk['icon'] ?>"></i>
            </div>

            <!-- Content -->
            <div>
              <div class="cc-perk-title">
                <?= htmlspecialchars($pk['title']) ?>
              </div>

              <p class="cc-perk-body mb-0">
                <?= htmlspecialchars($pk['desc']) ?>
              </p>
            </div>

          </div>

        </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>
  <!-- ══════════════════════════════════════════════════
     SECTION 5 — LIFE AT THE COMPANY
     ══════════════════════════════════════════════════ -->
  <div class="cc-divider"></div>
  <section class="cc-section py-5 cc-life">
  <div class="container">

    <!-- Heading -->
    <div class="text-center d-flex flex-column align-items-center justify-content-center">

      <div
        class="cc-label d-inline-flex align-items-center gap-2 text-uppercase fw-semibold rounded-pill px-3 py-2 mb-3 border">
        <i class="bi bi-camera-fill"></i>
        Life at IIMsCourses
      </div>

      <h2 class="cc-title fw-semibold display-5">
        Culture built on trust &amp; impact
      </h2>

      <p class="cc-desc text-secondary">
        We're educators, technologists, and dreamers. We work hard, celebrate wins,
        and genuinely care for each other.
      </p>

    </div>

    <!-- Main Layout -->
    <div class="row g-4 align-items-start mt-4">

      <!-- Left Side -->
      <div class="col-lg-6">

        <div class="row g-3">

          <?php foreach ($LIFE as $i => $lc):
            $colors = ['ora', 'nvy', 'grn', 'ora', 'nvy', 'grn'];
            $clr = $colors[$i % 3];
          ?>

            <div class="col-12">

              <div class="cc-life-card d-flex align-items-start gap-3 h-100">

                <!-- Icon -->
                <div class="cc-life-icon <?= $clr ?> flex-shrink-0">
                  <i class="bi <?= $lc['icon'] ?>"></i>
                </div>

                <!-- Content -->
                <div>
                  <div class="cc-life-title">
                    <?= htmlspecialchars($lc['title']) ?>
                  </div>

                  <p class="cc-life-body mb-0">
                    <?= htmlspecialchars($lc['desc']) ?>
                  </p>
                </div>

              </div>

            </div>

          <?php endforeach; ?>

        </div>

      </div>

      <!-- Right Side -->
      <div class="col-lg-6">

        <!-- Stats -->
    <div class="row g-3">

  <div class="col-6 col-md-6">
    <div class="cc-lstat h-100">
      <span class="cc-lstat-icon" style="color:var(--cc-orange)">
        <i class="bi bi-people-fill"></i>
      </span>

      <span class="cc-lstat-val">85+</span>

      <span class="cc-lstat-lbl">
        Team Members across India
      </span>
    </div>
  </div>

  <div class="col-6 col-md-6">
    <div class="cc-lstat h-100">
      <span class="cc-lstat-icon" style="color:#1d4ed8">
        <i class="bi bi-mortarboard-fill"></i>
      </span>

      <span class="cc-lstat-val">40%</span>

      <span class="cc-lstat-lbl">
        IIM / IIT Alumni on Team
      </span>
    </div>
  </div>

  <div class="col-6 col-md-6">
    <div class="cc-lstat h-100">
      <span class="cc-lstat-icon" style="color:#059669">
        <i class="bi bi-gender-ambiguous"></i>
      </span>

      <span class="cc-lstat-val">45%</span>

      <span class="cc-lstat-lbl">
        Women in Leadership Roles
      </span>
    </div>
  </div>

  <div class="col-6 col-md-6">
    <div class="cc-lstat h-100">
      <span class="cc-lstat-icon" style="color:var(--cc-orange)">
        <i class="bi bi-lightning-charge-fill"></i>
      </span>

      <span class="cc-lstat-val">3x</span>

      <span class="cc-lstat-lbl">
        Major Product Releases / Month
      </span>
    </div>
  </div>

</div>
        <!-- Awards Box -->
        <div class="bg-white border rounded-4 p-4 mt-4">

          <div
            class="fw-semibold small mb-3 d-flex align-items-center gap-2"
            style="color:var(--cc-navy)">
            <i class="bi bi-trophy-fill" style="color:var(--cc-orange)"></i>
            Recognition &amp; Awards
          </div>

          <ul class="list-unstyled d-flex flex-column gap-3 mb-0">

            <li class="d-flex align-items-start gap-2 small text-secondary">
              <i class="bi bi-check-circle-fill flex-shrink-0"
                style="color:var(--cc-green)"></i>
              Great Place to Work Certified 2024
            </li>

            <li class="d-flex align-items-start gap-2 small text-secondary">
              <i class="bi bi-check-circle-fill flex-shrink-0"
                style="color:var(--cc-green)"></i>
              Top 10 EdTech Startups to Watch — Inc42
            </li>

            <li class="d-flex align-items-start gap-2 small text-secondary">
              <i class="bi bi-check-circle-fill flex-shrink-0"
                style="color:var(--cc-green)"></i>
              Best Student Experience Platform — EduTech Awards
            </li>

            <li class="d-flex align-items-start gap-2 small text-secondary">
              <i class="bi bi-check-circle-fill flex-shrink-0"
                style="color:var(--cc-green)"></i>
              4.8★ on Glassdoor from 200+ verified reviews
            </li>

          </ul>

        </div>

      </div>

    </div>
  </div>
</section>
  <!-- ══════════════════════════════════════════════════
     SECTION 6 — TESTIMONIALS
     ══════════════════════════════════════════════════ -->
  <div class="cc-divider"></div>
<section class="cc-section py-5 cc-testi">
  <div class="container">

    <!-- Heading -->
    <div class="text-center d-flex flex-column align-items-center justify-content-center">

      <div
        class="cc-label d-inline-flex align-items-center gap-2 text-uppercase fw-semibold rounded-pill px-3 py-2 mb-3 border">
        <i class="bi bi-chat-quote-fill"></i>
        Team Stories
      </div>

      <h2 class="cc-title fw-semibold display-5">
        Hear from our people
      </h2>

      <p class="cc-desc text-secondary">
        Real words from the team — no PR polish, no filters, no corporate speak.
      </p>

    </div>

    <!-- Testimonials -->
    <div class="row g-4 mt-4">

      <?php foreach ($TESTIMONIALS as $t): ?>

        <div class="col-lg-4 col-md-6">

          <div class="cc-tcard h-100 position-relative d-flex flex-column">

            <!-- Quote -->
            <p class="cc-tquote mb-0">
              <?= htmlspecialchars($t['quote']) ?>
            </p>

            <!-- Author -->
            <div class="cc-tauthor d-flex align-items-center gap-3 mt-auto">

              <div class="cc-tavatar flex-shrink-0"
                style="background:<?= $t['clr'] ?>">
                <?= $t['initials'] ?>
              </div>

              <div>
                <div class="cc-tname">
                  <?= htmlspecialchars($t['name']) ?>
                </div>

                <div class="cc-trole">
                  <?= htmlspecialchars($t['role']) ?>
                  &middot;
                  <?= htmlspecialchars($t['college']) ?>
                </div>
              </div>

            </div>

          </div>

        </div>

      <?php endforeach; ?>

    </div>
  </div>
</section>
  <!-- ══════════════════════════════════════════════════
     SECTION 7 — CONTACT / ENQUIRY
     ══════════════════════════════════════════════════ -->
  <div class="cc-divider"></div>
  <section class="cc-section py-5 cc-contact" id="contact-section">
    <div class="cc-container ">
      <div class="cc-center text-center d-fl">
        <div
          class="cc-label d-inline-flex align-items-center gap-2 text-uppercase fw-semibold rounded-pill px-3 py-2 mb-3 border">
          <i class="bi bi-envelope-fill"></i> Contact &amp; Enquiry
        </div>
        <h2 class="cc-title fw-semibold fs-1">Get in touch with our team</h2>
        <p class="cc-desc">Questions about roles, culture, or working here? We respond to every enquiry within 24
          business hours.</p>
      </div>
      <div class="cc-contact-inner">
        <!-- Left — info -->
        <div>
          <div class="cc-info-list">
            <div class="cc-info-item cc-reveal">
              <div class="cc-info-icon-box"><i class="bi bi-envelope-fill"></i></div>
              <div>
                <div class="cc-info-title">Careers Email</div>
                <div class="cc-info-text">careers@iimscourses.com</div>
              </div>
            </div>
            <div class="cc-info-item cc-reveal">
              <div class="cc-info-icon-box"><i class="bi bi-telephone-fill"></i></div>
              <div>
                <div class="cc-info-title">HR Helpline</div>
                <div class="cc-info-text">+91 98765 43210<br><span style="font-size:.78rem">Mon–Fri, 10am–6pm IST</span>
                </div>
              </div>
            </div>
            <div class="cc-info-item cc-reveal">
              <div class="cc-info-icon-box"><i class="bi bi-geo-alt-fill"></i></div>
              <div>
                <div class="cc-info-title">Head Office</div>
                <div class="cc-info-text">WeWork Prestige Central,<br>Bengaluru – 560001, Karnataka</div>
              </div>
            </div>
            <div class="cc-info-item cc-reveal">
              <div class="cc-info-icon-box"><i class="bi bi-linkedin"></i></div>
              <div>
                <div class="cc-info-title">LinkedIn</div>
                <a href="#" class="cc-info-link">linkedin.com/company/iimscourses</a>
              </div>
            </div>
          </div>
          <!-- Referral box -->
          <div class="cc-referral-box cc-reveal">
            <div class="cc-referral-title"><i class="bi bi-gift-fill" style="color:var(--cc-orange)"></i> Referral
              Programme</div>
            <p class="cc-referral-body">Know someone great? Refer them and earn a <span
                class="cc-referral-amount">₹25,000 bonus</span> when they join and complete 3 months. Write to us with
              their profile — we'll take it from there.</p>
          </div>
        </div>
        <!-- Right — form -->
        <div class="cc-form-card cc-reveal">
          <div class="cc-form-title">Send us a message</div>
          <form onsubmit="ccSubmitContact(event)">
            <div class="cc-form-row">
              <div class="cc-form-group">
                <label>First Name *</label>
                <input type="text" required placeholder="Enter you Name...">
              </div>
              <div class="cc-form-group">
                <label>Last Name *</label>
                <input type="text" required placeholder="Enter you Lastname...">
              </div>
            </div>
            <div class="cc-form-group">
              <label>Email Address *</label>
              <input type="email" required placeholder="mail@example.com">
            </div>
            <div class="cc-form-group">
              <label>Phone Number</label>
              <input type="tel" placeholder="+91 ">
            </div>
            <div class="cc-form-group">
              <label>I'm interested in</label>
              <select>
                <option value="">— Select department —</option>
                <option>Engineering / Tech</option>
                <option>Design / UX</option>
                <option>Content / Editing</option>
                <option>MBA Counselling</option>
                <option>Marketing / Growth</option>
                <option>Data / Analytics</option>
                <option>Teaching / Academics</option>
                <option>General Enquiry</option>
              </select>
            </div>
            <div class="cc-form-group">
              <label>Your Message</label>
              <textarea
                placeholder="Tell us a bit about yourself, your background, and what excites you about IIMsCourses..."></textarea>
            </div>
            <button type="submit" class="cc-btn-submit">
              <i class="bi bi-send-fill"></i> Send Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════
     JOB APPLY MODAL
     ══════════════════════════════════════════════════ -->
  <div class="cc-modal-backdrop" id="ccJobModal" onclick="if(event.target===this)ccCloseJobModal()">
    <div class="cc-modal-box">
      <div class="cc-modal-hdr">
        <div class="cc-modal-title-wrap">
          <div class="cc-modal-badge"><i class="bi bi-briefcase-fill"></i> <span id="ccMDept"></span></div>
          <h3 class="cc-modal-title" id="ccMTitle">Apply</h3>
        </div>
        <button class="cc-modal-close" onclick="ccCloseJobModal()"><i class="bi bi-x-lg"></i></button>
      </div>
      <!-- Meta tags -->
      <div class="cc-modal-meta" id="ccMMeta"></div>
      <!-- Description -->
      <div class="cc-modal-desc" id="ccMDesc"></div>
      <!-- Skills -->
      <div class="cc-modal-skills-wrap">
        <div class="cc-modal-skills-lbl">Skills & Requirements</div>
        <div class="cc-modal-skills" id="ccMSkills"></div>
      </div>
      <!-- Form -->
      <form onsubmit="ccSubmitJobApp(event)" style="margin-top:.25rem">
        <input type="hidden" id="ccMId">
        <div class="cc-form-row">
          <div class="cc-form-group">
            <label>Full Name *</label>
            <input type="text" required placeholder="Rahul Sharma">
          </div>
          <div class="cc-form-group">
            <label>Email *</label>
            <input type="email" required placeholder="you@example.com">
          </div>
        </div>
        <div class="cc-form-group">
          <label>Phone Number</label>
          <input type="tel" placeholder="+91 9876543210">
        </div>
        <div class="cc-form-group">
          <label>Current Company / College</label>
          <input type="text" placeholder="Google / IIT Delhi / Fresher">
        </div>
        <div class="cc-form-group">
          <label>Years of Experience</label>
          <select>
            <option>Fresher (0–1 yr)</option>
            <option>1–3 years</option>
            <option>3–5 years</option>
            <option>5–8 years</option>
            <option>8+ years</option>
          </select>
        </div>
        <div class="cc-form-group">
          <label>Resume / LinkedIn / Portfolio URL *</label>
          <input type="url" required placeholder="https://linkedin.com/in/yourprofile">
        </div>
        <div class="cc-form-group">
          <label>Why IIMsCourses?</label>
          <textarea placeholder="What excites you about this role and our mission?" style="min-height:85px"></textarea>
        </div>
        <button type="submit" class="cc-btn-submit"><i class="bi bi-send-fill"></i> Submit Application</button>
      </form>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════════
     GENERAL APPLICATION MODAL
     ══════════════════════════════════════════════════ -->
  <div class="cc-gmodal-backdrop" id="ccGeneralModal" onclick="if(event.target===this)ccCloseGeneralModal()">
    <div class="cc-modal-box">
      <div class="cc-modal-hdr">
        <div class="cc-modal-title-wrap">
          <div class="cc-modal-badge"><i class="bi bi-person-plus-fill"></i> General Application</div>
          <h3 class="cc-modal-title">Tell us who you are</h3>
        </div>
        <button class="cc-modal-close" onclick="ccCloseGeneralModal()"><i class="bi bi-x-lg"></i></button>
      </div>
      <div class="cc-modal-desc">We review every general application and reach out when the right opportunity opens up.
        Don't be shy.</div>
      <form onsubmit="ccSubmitGeneralApp(event)">
        <div class="cc-form-row">
          <div class="cc-form-group">
            <label>Full Name *</label>
            <input type="text" required placeholder="Enter your name...">
          </div>
          <div class="cc-form-group">
            <label>Email *</label>
            <input type="email" required placeholder="you@example.com">
          </div>
        </div>
        <div class="cc-form-group">
          <label>Phone Number</label>
          <input type="tel" placeholder="+91 ">
        </div>
        <div class="cc-form-group">
          <label>Area of Expertise *</label>
          <select required>
            <option value="">— Select domain —</option>
            <option>Engineering / Tech</option>
            <option>Design / UX</option>
            <option>Content / Editing</option>
            <option>MBA Counselling</option>
            <option>Marketing / Growth</option>
            <option>Data / Analytics</option>
            <option>Teaching / Academics</option>
            <option>Operations / HR</option>
            <option>Other</option>
          </select>
        </div>
        <div class="cc-form-group">
          <label>Resume / Portfolio URL *</label>
          <input type="url" required placeholder="LinkedIn, portfolio or Google Drive link">
        </div>
        <div class="cc-form-group">
          <label>About You</label>
          <textarea placeholder="Background, key achievements, why you'd love IIMsCourses..."
            style="min-height:95px"></textarea>
        </div>
        <button type="submit" class="cc-btn-submit"><i class="bi bi-send-fill"></i> Send Application</button>
      </form>
    </div>
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
          </div>
        </div>
        <!-- </div> -->

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
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
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



  <script>
    function openJobModal(id, title, desc) {
      document.getElementById('jmId').value = id;
      document.getElementById('jmTitle').textContent = title;
      document.getElementById('jmDesc').textContent = desc;
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
      } catch (err) { }
      closeJobModal();
      if (typeof showToast === 'function') {
        showToast('Application submitted!', 'success');
      } else {
        alert('Application submitted!');
      }
    }
    // Close on Escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeJobModal();
    });
  </script>

  <script>
    /* ── Job Modal ── */
    function ccOpenJobModal(id, title, dept, loc, type, exp, salary, desc, skills) {
      document.getElementById('ccMId').value = id;
      document.getElementById('ccMTitle').textContent = title;
      document.getElementById('ccMDept').textContent = dept;
      document.getElementById('ccMDesc').textContent = desc;
      // Meta tags
      var meta = document.getElementById('ccMMeta');
      meta.innerHTML = '';
      [{ cls: 'cc-tag-loc', icon: 'bi-geo-alt-fill', val: loc }, { cls: 'cc-tag-type', icon: 'bi-clock-fill', val: type }, { cls: 'cc-tag-exp', icon: 'bi-briefcase', val: exp }, { cls: 'cc-tag-dept', icon: 'bi-currency-rupee', val: salary }].forEach(function (t) {
        var s = document.createElement('span');
        s.className = 'cc-tag ' + t.cls;
        s.innerHTML = '<i class="bi ' + t.icon + '"></i> ' + t.val;
        meta.appendChild(s);
      });
      // Skills
      var sk = document.getElementById('ccMSkills');
      sk.innerHTML = '';
      if (skills && skills.length) skills.forEach(function (s) {
        var el = document.createElement('span');
        el.className = 'cc-skill';
        el.textContent = s;
        sk.appendChild(el);
      });
      document.getElementById('ccJobModal').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function ccCloseJobModal() {
      document.getElementById('ccJobModal').classList.remove('open');
      document.body.style.overflow = '';
    }
    function ccSubmitJobApp(e) {
      e.preventDefault();
      try {
        var apps = JSON.parse(localStorage.getItem('iims:applications') || '[]');
        apps.push({ jobId: document.getElementById('ccMId').value, ts: Date.now() });
        localStorage.setItem('iims:applications', JSON.stringify(apps));
      } catch (err) { }
      ccCloseJobModal();
      ccShowToast('Application submitted! We\'ll be in touch soon. 🎉', 'success');
    }

    /* ── General Modal ── */
    function ccOpenGeneralModal() {
      document.getElementById('ccGeneralModal').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function ccCloseGeneralModal() {
      document.getElementById('ccGeneralModal').classList.remove('open');
      document.body.style.overflow = '';
    }
    function ccSubmitGeneralApp(e) {
      e.preventDefault();
      ccCloseGeneralModal();
      ccShowToast('Application received! We\'ll review and get back to you soon.', 'success');
    }

    /* ── Contact ── */
    function ccSubmitContact(e) {
      e.preventDefault();
      ccShowToast('Message sent! HR team will respond within 24 hours.', 'success');
      e.target.reset();
    }

    /* ── Toast ── */
    function ccShowToast(msg, type) {
      var el = document.createElement('div');
      el.className = 'cc-toast ' + (type || 'success');
      el.innerHTML = '<i class="bi bi-' + (type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill') + '"></i> ' + msg;
      document.body.appendChild(el);
      setTimeout(function () { el.remove(); }, 4500);
    }

    /* ── Escape key ── */
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { ccCloseJobModal(); ccCloseGeneralModal(); }
    });

    /* ── Scroll reveal ── */
    (function () {
      var els = document.querySelectorAll('.cc-reveal');
      if (!els.length) return;
      var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) { en.target.classList.add('cc-visible'); obs.unobserve(en.target); }
        });
      }, { threshold: .1, rootMargin: '0px 0px -30px 0px' });
      els.forEach(function (el) { obs.observe(el); });
    })();
  </script>
</body>
</html>
<?php
include '../components/Footer.php';
include '../includes/footer.php';
include '../components/Modals.php';

?>