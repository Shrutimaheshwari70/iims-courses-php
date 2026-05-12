<?php
/**
 * data/iims.php
 * PHP equivalent of src/data/iims.ts
 * All colleges, courses, testimonials, recruiters, blogs, FAQs
 */

$COLLEGES = [
  [
    'slug'        => 'iim-ahmedabad',
    'name'        => 'IIM Ahmedabad',
    'short'       => 'IIM-A',
    'location'    => 'Ahmedabad, Gujarat',
    'established' => 1961,
    'rating'      => 4.9,
    'reviews'     => 2840,
    'image'       => 'assets/images/iim-a.jpg',
    'fees'        => 24.5,
    'placement'   => 34.2,
    'highest'     => 115,
    'ranking'     => 1,
    'category'    => ['Management','Finance','Marketing','HR'],
    'mode'        => 'Full-time',
    'exams'       => ['CAT','GMAT'],
    'about'       => 'IIM Ahmedabad is the premier business school in India, established in 1961 in collaboration with Harvard Business School. Known for its rigorous case-based pedagogy, it consistently ranks #1 in NIRF Management rankings.',
    'recruiters'  => ['McKinsey','BCG','Bain','Goldman Sachs','JP Morgan','Amazon','Google','Microsoft'],
    'scholarships'=> ['Need-based','Merit-cum-means','Aditya Birla Scholarship'],
    'faculty'     => 110,
    'intake'      => 395,
  ],
  [
    'slug'        => 'iim-bangalore',
    'name'        => 'IIM Bangalore',
    'short'       => 'IIM-B',
    'location'    => 'Bengaluru, Karnataka',
    'established' => 1973,
    'rating'      => 4.8,
    'reviews'     => 2410,
    'image'       => 'assets/images/iim-b.jpg',
    'fees'        => 24.0,
    'placement'   => 33.8,
    'highest'     => 110,
    'ranking'     => 2,
    'category'    => ['Management','Finance','Business Analytics','Marketing'],
    'mode'        => 'Full-time',
    'exams'       => ['CAT','GMAT'],
    'about'       => 'IIM Bangalore, established 1973, is renowned for entrepreneurship, analytics and innovation. Located in India\'s tech capital, it produces top consulting and product leaders.',
    'recruiters'  => ['BCG','McKinsey','Accenture Strategy','Flipkart','Microsoft','Adobe','Deloitte'],
    'scholarships'=> ['Need-based','Merit','OBC/SC/ST'],
    'faculty'     => 105,
    'intake'      => 480,
  ],
  [
    'slug'        => 'iim-calcutta',
    'name'        => 'IIM Calcutta',
    'short'       => 'IIM-C',
    'location'    => 'Kolkata, West Bengal',
    'established' => 1961,
    'rating'      => 4.8,
    'reviews'     => 2180,
    'image'       => 'assets/images/iim-c.jpg',
    'fees'        => 23.0,
    'placement'   => 32.5,
    'highest'     => 115,
    'ranking'     => 3,
    'category'    => ['Management','Finance'],
    'mode'        => 'Full-time',
    'exams'       => ['CAT','GMAT'],
    'about'       => 'IIM Calcutta, the first IIM, is internationally recognized for finance and is the only triple-accredited (AACSB, AMBA, EQUIS) IIM.',
    'recruiters'  => ['Goldman Sachs','Morgan Stanley','JP Morgan','Bain','ITC','Reliance'],
    'scholarships'=> ['Need-based','Aditya Birla','OP Jindal'],
    'faculty'     => 95,
    'intake'      => 462,
  ],
  [
    'slug'        => 'iim-lucknow',
    'name'        => 'IIM Lucknow',
    'short'       => 'IIM-L',
    'location'    => 'Lucknow, Uttar Pradesh',
    'established' => 1984,
    'rating'      => 4.7,
    'reviews'     => 1620,
    'image'       => 'assets/images/iim-l.jpg',
    'fees'        => 19.25,
    'placement'   => 26.8,
    'highest'     => 75,
    'ranking'     => 4,
    'category'    => ['Management','HR','Marketing'],
    'mode'        => 'Full-time',
    'exams'       => ['CAT'],
    'about'       => 'IIM Lucknow is a top-tier IIM celebrated for HR, agribusiness and a serene 200-acre campus.',
    'recruiters'  => ['HUL','ITC','Tata Steel','Accenture','Deloitte','Amazon'],
    'scholarships'=> ['Merit','Need-based'],
    'faculty'     => 90,
    'intake'      => 560,
  ],
  [
    'slug'        => 'iim-kozhikode',
    'name'        => 'IIM Kozhikode',
    'short'       => 'IIM-K',
    'location'    => 'Kozhikode, Kerala',
    'established' => 1996,
    'rating'      => 4.7,
    'reviews'     => 1480,
    'image'       => 'assets/images/iim-k.jpg',
    'fees'        => 21.0,
    'placement'   => 28.3,
    'highest'     => 67,
    'ranking'     => 5,
    'category'    => ['Management','Marketing','International Business'],
    'mode'        => 'Full-time',
    'exams'       => ['CAT'],
    'about'       => 'IIM Kozhikode is famous for its hilltop campus, gender diversity leadership and global focus.',
    'recruiters'  => ['Accenture','BCG','EY','Reliance','ITC','Tata'],
    'scholarships'=> ['Merit','Need-based'],
    'faculty'     => 88,
    'intake'      => 420,
  ],
  [
    'slug'        => 'iim-indore',
    'name'        => 'IIM Indore',
    'short'       => 'IIM-I',
    'location'    => 'Indore, Madhya Pradesh',
    'established' => 1996,
    'rating'      => 4.6,
    'reviews'     => 1380,
    'image'       => 'assets/images/iim-i.jpg',
    'fees'        => 18.5,
    'placement'   => 24.7,
    'highest'     => 62,
    'ranking'     => 6,
    'category'    => ['Management','Operations','Finance'],
    'mode'        => 'Full-time',
    'exams'       => ['CAT','GMAT'],
    'about'       => 'IIM Indore is known for its IPMAT programme and strong consulting placements from its scenic hilltop campus.',
    'recruiters'  => ['Deloitte','KPMG','Amazon','P&G','Mahindra'],
    'scholarships'=> ['Merit','SC/ST/OBC'],
    'faculty'     => 84,
    'intake'      => 585,
  ],
];

$COURSES = [
  [
    'slug'        => 'pgp-mba',
    'title'       => 'Post Graduate Programme in Management (MBA)',
    'category'    => 'MBA',
    'duration'    => '2 Years',
    'fees'        => 24,
    'mode'        => 'Full-time',
    'description' => 'The flagship MBA programme across all IIMs, combining rigorous case-based learning with global immersion, internships and capstone consulting projects.',
    'iims'        => ['iim-ahmedabad','iim-bangalore','iim-calcutta','iim-lucknow','iim-kozhikode','iim-indore'],
    'image'       => 'assets/images/iim-a.jpg',
    'eligibility' => "Bachelor's degree with 50% + valid CAT score",
  ],
  [
    'slug'        => 'pgdm',
    'title'       => 'Post Graduate Diploma in Management',
    'category'    => 'PGDM',
    'duration'    => '2 Years',
    'fees'        => 22,
    'mode'        => 'Full-time',
    'description' => 'AICTE-approved PGDM with strong industry interface, internship and consulting projects.',
    'iims'        => ['iim-shillong','iim-rohtak','iim-trichy','iim-udaipur'],
    'image'       => 'assets/images/iim-c.jpg',
    'eligibility' => "Bachelor's degree with 50% + CAT/GMAT",
  ],
  [
    'slug'        => 'executive-mba',
    'title'       => 'Executive MBA (PGPX / EPGP)',
    'category'    => 'Executive MBA',
    'duration'    => '1 Year',
    'fees'        => 31,
    'mode'        => 'Full-time',
    'description' => 'One-year residential MBA for working professionals with 5+ years of experience.',
    'iims'        => ['iim-ahmedabad','iim-bangalore','iim-calcutta','iim-indore'],
    'image'       => 'assets/images/iim-b.jpg',
    'eligibility' => "Bachelor's + 5 yrs work-ex + GMAT/GRE",
  ],
  [
    'slug'        => 'business-analytics',
    'title'       => 'PG Programme in Business Analytics',
    'category'    => 'Business Analytics',
    'duration'    => '2 Years',
    'fees'        => 19,
    'mode'        => 'Full-time / Hybrid',
    'description' => 'Combines management with data science, ML and decision sciences.',
    'iims'        => ['iim-bangalore','iim-calcutta','iim-udaipur'],
    'image'       => 'assets/images/iim-l.jpg',
    'eligibility' => "Bachelor's + CAT/GMAT",
  ],
  [
    'slug'        => 'finance',
    'title'       => 'MBA in Finance',
    'category'    => 'Finance',
    'duration'    => '2 Years',
    'fees'        => 23,
    'mode'        => 'Full-time',
    'description' => 'Specialization in corporate finance, investment banking, derivatives and FinTech.',
    'iims'        => ['iim-calcutta','iim-ahmedabad','iim-lucknow'],
    'image'       => 'assets/images/iim-c.jpg',
    'eligibility' => "Bachelor's + CAT",
  ],
  [
    'slug'        => 'marketing',
    'title'       => 'MBA in Marketing',
    'category'    => 'Marketing',
    'duration'    => '2 Years',
    'fees'        => 22,
    'mode'        => 'Full-time',
    'description' => 'Brand strategy, consumer insights, digital marketing and product management.',
    'iims'        => ['iim-ahmedabad','iim-lucknow','iim-kozhikode'],
    'image'       => 'assets/images/iim-k.jpg',
    'eligibility' => "Bachelor's + CAT",
  ],
  [
    'slug'        => 'hr',
    'title'       => 'PG Programme in Human Resources',
    'category'    => 'HR',
    'duration'    => '2 Years',
    'fees'        => 18,
    'mode'        => 'Full-time',
    'description' => 'Specialized HR programme — talent, OD, compensation, labour laws.',
    'iims'        => ['iim-ranchi','iim-lucknow'],
    'image'       => 'assets/images/iim-l.jpg',
    'eligibility' => "Bachelor's + CAT",
  ],
  [
    'slug'        => 'operations',
    'title'       => 'MBA in Operations & Supply Chain',
    'category'    => 'Operations',
    'duration'    => '2 Years',
    'fees'        => 20,
    'mode'        => 'Full-time',
    'description' => 'Operations research, supply chain, logistics and manufacturing strategy.',
    'iims'        => ['iim-indore','iim-trichy','iim-kashipur'],
    'image'       => 'assets/images/iim-i.jpg',
    'eligibility' => "Bachelor's + CAT",
  ],
];

$TESTIMONIALS = [
  [
    'name'   => 'Ananya Sharma',
    'role'   => 'PGP 2024, IIM Ahmedabad',
    'quote'  => 'IIMs Courses gave me clarity I couldn\'t find anywhere else. The detailed placement data and alumni reviews helped me pick the right fit.',
    'rating' => 5,
  ],
  [
    'name'   => 'Rohan Mehta',
    'role'   => 'PGDM 2023, IIM Indore',
    'quote'  => 'From CAT prep to final placements, this platform was my single source of truth. The compare tool is genuinely useful.',
    'rating' => 5,
  ],
  [
    'name'   => 'Priya Iyer',
    'role'   => 'EPGP 2024, IIM Bangalore',
    'quote'  => 'I\'m a working professional and the executive MBA filters saved me weeks of research. Highly recommend.',
    'rating' => 5,
  ],
  [
    'name'   => 'Karan Singh',
    'role'   => 'PGP 2025, IIM Calcutta',
    'quote'  => 'The mentorship articles and webinars are top-class. The team genuinely cares about student outcomes.',
    'rating' => 5,
  ],
];

$RECRUITERS = [
  'McKinsey','BCG','Bain','Goldman Sachs','JP Morgan','Morgan Stanley',
  'Amazon','Google','Microsoft','Adobe','Accenture','Deloitte',
  'EY','PwC','ITC','HUL','Reliance','Tata','Mahindra','Flipkart',
];

$BLOGS = [
  [
    'slug'    => 'cat-2025-strategy',
    'title'   => 'CAT 2025: A Section-wise Strategy from IIM Toppers',
    'excerpt' => 'Decode VARC, DILR and QA with first-hand strategies, mocks plan and study calendar from converters of IIM-A/B/C.',
    'author'  => 'Editorial Team',
    'date'    => 'Apr 28, 2026',
    'likes'   => 1284,
    'image'   => 'assets/images/iim-a.jpg',
  ],
  [
    'slug'    => 'iim-vs-isb',
    'title'   => 'IIM PGP vs ISB PGP: A No-Nonsense 2026 Comparison',
    'excerpt' => 'Cost, ROI, placements, alumni network and culture — we break down which programme suits which kind of profile.',
    'author'  => 'Sneha R.',
    'date'    => 'Apr 12, 2026',
    'likes'   => 942,
    'image'   => 'assets/images/iim-b.jpg',
  ],
  [
    'slug'    => 'wat-pi-prep',
    'title'   => 'WAT-PI 2026: 30-day Prep Sprint with Real Questions',
    'excerpt' => 'From current affairs to behavioural questions, the playbook used by 200+ IIM converts.',
    'author'  => 'Editorial Team',
    'date'    => 'Mar 30, 2026',
    'likes'   => 712,
    'image'   => 'assets/images/iim-c.jpg',
  ],
  [
    'slug'    => 'specialisations-roi',
    'title'   => 'Which MBA Specialisation has the Best ROI in 2026?',
    'excerpt' => 'Finance vs Marketing vs Analytics vs Ops — placement data, growth and salary trajectories explained.',
    'author'  => 'Aditya P.',
    'date'    => 'Mar 18, 2026',
    'likes'   => 633,
    'image'   => 'assets/images/iim-l.jpg',
  ],
];

$FAQS = [
  [
    'q' => 'What is the eligibility for IIM MBA programmes?',
    'a' => "Bachelor's degree with at least 50% (45% for SC/ST/PwD) plus a valid CAT score. Some IIMs accept GMAT for executive programmes.",
  ],
  [
    'q' => 'How is IIMs Courses different from other discovery platforms?',
    'a' => 'We focus exclusively on IIMs with verified placement data, alumni reviews, side-by-side comparisons and free counselling.',
  ],
  [
    'q' => 'Can I apply to multiple IIMs together?',
    'a' => 'Yes. CAT is the common gateway. You can apply to multiple IIMs through their respective admission portals using your CAT score.',
  ],
  [
    'q' => 'Is dark mode supported?',
    'a' => 'Yes — toggle from the navbar. Full design tokens are tuned for both modes.',
  ],
  [
    'q' => 'Are the brochures free to download?',
    'a' => 'Yes, every college and course detail page has a free brochure download CTA.',
  ],
  [
    'q' => 'How does the compare feature work?',
    'a' => 'Click the compare icon on any college card. Add up to 3 colleges, then visit the compare page for a detailed table.',
  ],
];
/* =========================================================
   FUNCTIONS
========================================================= */

/**
 * Get single college by slug
 */


function getCollege($slug) {
    global $COLLEGES;

    foreach ($COLLEGES as $college) {
        if ($college['slug'] === $slug) {
            return $college;
        }
    }

    return null;
}

/**
 * Get single course by slug
 */
function getCourse($slug) {
    global $COURSES;

    foreach ($COURSES as $course) {
        if ($course['slug'] === $slug) {
            return $course;
        }
    }

    return null;
}

/**
 * Get single blog by slug
 */
function getBlog($slug) {
    global $BLOGS;

    foreach ($BLOGS as $blog) {
        if ($blog['slug'] === $slug) {
            return $blog;
        }
    }

    return null;
}?>
