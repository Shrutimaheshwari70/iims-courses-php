<?php
/**
 * course-details.php
 * ─────────────────────────────────────────────────────────────────
 * PHP conversion of:  courses/$slug.tsx  (CourseDetail)
 * URL:  course-details.php?slug=mba-finance
 * Requires: ../data/iims.php
 *   Provides: $COLLEGES, $FAQS, $COURSES, getCourse($slug), getCollege($slug)
 * ─────────────────────────────────────────────────────────────────
 */

session_start();
require_once '../data/iims.php';

$slug = trim($_GET['slug'] ?? '');
$c    = $slug !== '' ? getCourse($slug) : null;

/* ── 404 ── */
if (!$c) {
    header('HTTP/1.0 404 Not Found');
    $page_title = 'Course Not Found';
    include '../includes/header.php';
    include '../components/Navbar.php';
    echo '<section class="section" style="padding-top:8rem;text-align:center">
            <h1>Course not found.</h1>
            <p><a href="courses.php" class="btn btn-outline" style="display:inline-flex;margin-top:1rem">← Back to courses</a></p>
          </section>';
    include '../components/Footer.php';
    include '../includes/footer.php';
    exit;
}

$page_title       = htmlspecialchars($c['title']) . ' — IIMs';
$page_description = htmlspecialchars(mb_substr($c['description'] ?? '', 0, 150));
$current_page     = 'courses';

/* ── IIMs offering this course ── */
$iims = array_values(array_filter(array_map(fn($s) => getCollege($s), $c['iims'] ?? [])));

/* ── Recommended (other courses, max 3) ── */
$recommended = array_values(array_slice(
    array_filter($COURSES, fn($x) => $x['slug'] !== $slug),
    0, 3
));

include '../includes/header.php';
include '../components/Navbar.php';
?>

<!-- ═══════════════════════════════════════════════════════════════
     STYLES  —  mirrors every Tailwind class from the TSX exactly
════════════════════════════════════════════════════════════════ -->
<style>
*,*::before,*::after{box-sizing:border-box}

/* ── HERO  (h-[55vh] min-h-[380px] overflow-hidden) ── */
.ccd-hero{
    position:relative;
    height:65vh;
    min-height:380px;
    overflow:hidden;
}
.ccd-hero-img{
    position:absolute;inset:0;
    width:100%;height:100%;object-fit:cover;
}
.ccd-hero-overlay{
    position:absolute;inset:0;
    background:linear-gradient(to top,rgba(0,0,0,.82) 0%,rgba(0,0,0,.42) 55%,transparent 100%);
}
/* relative h-full mx-auto max-w-7xl px-6 flex flex-col justify-end pb-12 text-white */
.ccd-hero-inner{
    position:relative;height:100%;
    max-width:80rem;margin:0 auto;
    padding:0 1.5rem 3rem;
    display:flex;flex-direction:column;justify-content:flex-end;
    color:#fff;
}
/* inline-flex w-fit … rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-widest */
.ccd-eyebrow{
    display:inline-flex;width:fit-content;
    align-items:center;gap:.4rem;
    background:rgba(255,255,255,.15);
    backdrop-filter:blur(8px);
    border:1px solid rgba(255,255,255,.2);
    border-radius:9999px;
    padding:.28rem .9rem;
    font-size:.7rem;font-weight:700;
    letter-spacing:.08em;text-transform:uppercase;
}
/* font-display font-bold text-4xl md:text-6xl mt-4 max-w-4xl */
.ccd-hero-title{
font-size:3rem;
    font-weight:800;margin-top:1rem;
    line-height:1.1;max-width:56rem;
}
.ccd-hero-sub{color:rgba(255,255,255,.8);margin-top:.75rem;font-size:1rem}
.ccd-hero-actions{display:flex;flex-wrap:wrap;gap:.75rem;margin-top:1.5rem;align-items:center}

/* bg-white/10 backdrop-blur border-white/30 text-white hover:bg-white hover:text-navy */
.ccd-btn-brochure{
    display:inline-flex;align-items:center;gap:.45rem;
    padding:.7rem 1.4rem;border-radius:.6rem;
    background:rgba(255,255,255,.12);
    backdrop-filter:blur(8px);
    border:1px solid rgba(255,255,255,.3);
    color:#fff;font-size:.875rem;font-weight:600;
    cursor:pointer;transition:background .2s,color .2s;
}
.ccd-btn-brochure:hover{background:#fff;color:#0f2167}

/* ── BODY  mx-auto max-w-7xl px-6 py-12 grid lg:grid-cols-3 gap-10 ── */
.ccd-body{
    max-width:80rem;margin:0 auto;
    padding:3rem 1.5rem 5rem;
    display:grid;grid-template-columns:1fr;gap:2.5rem;
}
@media(min-width:1024px){.ccd-body{grid-template-columns:1fr 340px}}

/* ── LEFT  lg:col-span-2 space-y-12 ── */
.ccd-left{display:flex;flex-direction:column;gap:3rem;min-width:0}

/* font-display font-bold text-3xl mb-3 */
.ccd-section-title{
    font-size:clamp(1.5rem,4vw,1.875rem);
    font-weight:800;margin-bottom:.85rem;line-height:1.15;
}
.ccd-lead{color:var(--muted-foreground,#64748b);line-height:1.8;font-size:1rem}

/* ── CURRICULUM ── */
.ccd-curriculum{display:flex;flex-direction:column;gap:.75rem}
/* rounded-2xl border bg-card p-5 */
.ccd-sem{border:1px solid var(--border,#e5e7eb);border-radius:1rem;background:var(--card,#fff);padding:1.25rem}
.ccd-sem-label{font-weight:700;margin-bottom:.6rem;font-size:.95rem}
.ccd-topics{display:flex;flex-wrap:wrap;gap:.45rem}
/* text-xs px-3 py-1 rounded-full bg-secondary */
.ccd-topic{
    font-size:.75rem;padding:.3rem .75rem;
    border-radius:9999px;
    background:var(--secondary,#f1f5f9);
    color:var(--foreground,#0f172a);font-weight:500;
}

/* ── IIMs  grid sm:grid-cols-2 gap-4 ── */
.ccd-iims-grid{display:grid;grid-template-columns:1fr;gap:1rem}
@media(min-width:640px){.ccd-iims-grid{grid-template-columns:repeat(2,1fr)}}

/* rounded-2xl border bg-card p-4 flex gap-3 hover:shadow-card */
.ccd-iim-card{
    display:flex;gap:.75rem;
    border:1px solid var(--border,#e5e7eb);
    border-radius:1rem;background:var(--card,#fff);padding:1rem;
    text-decoration:none;color:inherit;
    transition:box-shadow .25s,transform .25s;
}
.ccd-iim-card:hover{box-shadow:0 8px 32px rgba(0,0,0,.1);transform:translateY(-2px)}
/* size-16 rounded-lg object-cover */
.ccd-iim-thumb{width:4rem;height:4rem;border-radius:.5rem;object-fit:cover;flex-shrink:0}
.ccd-iim-name{font-weight:700;font-size:.95rem;margin-bottom:.15rem}
.ccd-iim-loc{font-size:.75rem;color:var(--muted-foreground,#64748b)}
.ccd-iim-meta{font-size:.75rem;margin-top:.25rem;color:var(--muted-foreground,#64748b)}

/* ── FAQ Accordion ── */
.faq-wrap{display:flex;flex-direction:column;gap:.75rem}
/* rounded-xl border bg-card px-5 */
.faq-item{border:1px solid var(--border,#e5e7eb);border-radius:.85rem;background:var(--card,#fff);overflow:hidden}
.faq-question{
    display:flex;justify-content:space-between;align-items:center;
    gap:1rem;padding:1.1rem 1.25rem;
    font-weight:700;font-size:.95rem;cursor:pointer;user-select:none;transition:color .2s;
}
.faq-question:hover{color:var(--accent,#f97316)}
.faq-arrow{width:18px;height:18px;flex-shrink:0;transition:transform .3s;color:var(--muted-foreground,#64748b)}
.faq-item.open .faq-arrow{transform:rotate(180deg)}
.faq-answer{
    max-height:0;overflow:hidden;
    transition:max-height .35s ease,padding .35s ease;
    font-size:.9rem;color:var(--muted-foreground,#64748b);
    line-height:1.75;padding:0 1.25rem;
}
.faq-item.open .faq-answer{max-height:600px;padding:0 1.25rem 1.1rem}

/* ── SIDEBAR  lg:col-span-1 ── */
.ccd-sidebar{width:100%}
/* sticky top-24 rounded-2xl border bg-card shadow-card p-6 */
.ccd-sidebar-card{
    position:sticky;top:6rem;
    border:1px solid var(--border,#e5e7eb);
    border-radius:1.25rem;background:var(--card,#fff);
    box-shadow:0 4px 32px rgba(0,0,0,.07);padding:1.5rem;
}
.ccd-sidebar-title{font-size:1.2rem;font-weight:800;margin-bottom:1rem}
/* grid gap-3 mt-4 */
.ccd-form{display:flex;flex-direction:column;gap:.75rem;margin-top:1rem}
.ccd-field{display:flex;flex-direction:column;gap:.3rem}
.ccd-label{font-size:.78rem;font-weight:600;color:var(--muted-foreground,#64748b)}
.ccd-input{
    width:100%;padding:.65rem .9rem;
    border:1px solid var(--border,#e5e7eb);border-radius:.6rem;
    background:var(--background,#fff);color:var(--foreground,#0f172a);
    font-size:.9rem;outline:none;transition:border-color .2s,box-shadow .2s;
}
.ccd-input:focus{border-color:var(--accent,#f97316);box-shadow:0 0 0 3px rgba(249,115,22,.18)}

/* ── RECOMMENDED  mx-auto max-w-7xl px-6 pb-16 ── */
.ccd-rec-wrap{max-width:80rem;margin:0 auto;padding:0 1.5rem 5rem}
.ccd-rec-title{font-size:1.5rem;font-weight:800;margin-bottom:1.5rem}
/* grid md:grid-cols-3 gap-5 */
.ccd-rec-grid{display:grid;grid-template-columns:1fr;gap:1.25rem}
@media(min-width:768px){.ccd-rec-grid{grid-template-columns:repeat(3,1fr)}}
/* rounded-2xl border bg-card p-5 hover:shadow-card */
.ccd-rec-card{
    border:1px solid var(--border,#e5e7eb);border-radius:1.25rem;
    background:var(--card,#fff);padding:1.25rem;
    text-decoration:none;color:inherit;display:block;
    transition:box-shadow .25s,transform .25s;
}
.ccd-rec-card:hover{box-shadow:0 8px 32px rgba(0,0,0,.1);transform:translateY(-2px)}
/* text-[10px] uppercase font-bold text-accent */
.ccd-rec-cat{font-size:.65rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--accent,#f97316)}
/* font-display font-semibold mt-1 line-clamp-2 */
.ccd-rec-name{
    font-weight:700;margin-top:.3rem;font-size:1rem;line-height:1.35;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
.ccd-rec-meta{font-size:.75rem;color:var(--muted-foreground,#64748b);margin-top:.5rem}

/* ── Apply Modal ── */
.ccd-modal-backdrop{
    display:none;position:fixed;inset:0;z-index:1000;
    background:rgba(0,0,0,.55);backdrop-filter:blur(4px);
    align-items:center;justify-content:center;padding:1rem;
}
.ccd-modal-backdrop.open{display:flex}
.ccd-modal-box{
    background:var(--card,#fff);border-radius:1.25rem;
    padding:2rem;width:100%;max-width:480px;
    box-shadow:0 20px 60px rgba(0,0,0,.2);position:relative;
}
.ccd-modal-close{
    position:absolute;top:1rem;right:1rem;
    background:none;border:none;cursor:pointer;
    font-size:1.3rem;color:var(--muted-foreground);line-height:1;
}
.ccd-modal-h{font-size:1.3rem;font-weight:800;margin-bottom:.35rem}
.ccd-modal-sub{font-size:.875rem;color:var(--muted-foreground,#64748b);margin-bottom:1.5rem}

/* ── Toast ── */
.ccd-toast{
    position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;
    background:#111827;color:#fff;
    padding:.75rem 1.25rem;border-radius:.75rem;
    font-size:.875rem;font-weight:500;
    box-shadow:0 8px 32px rgba(0,0,0,.25);
    opacity:0;transform:translateY(12px);
    transition:opacity .3s,transform .3s;pointer-events:none;
}
.ccd-toast.show{opacity:1;transform:none}

/* ── Reveal animation ── */
.reveal{opacity:0;transform:translateY(22px);transition:opacity .45s ease,transform .45s ease}
.reveal.visible{opacity:1;transform:none}
</style>

<!-- ═══════════════════ HERO ═══════════════════ -->
<!-- mirrors: <section className="relative h-[55vh] min-h-[380px] overflow-hidden"> -->
<section class="ccd-hero">
  <img
  src="<?= htmlspecialchars($c['image'] ?? '../assets/images/default-course.jpg') ?>"
    class="ccd-hero-img"
/>
    <div class="ccd-hero-overlay"></div>

    <div class="ccd-hero-inner">

        <!-- mirrors: <span className="inline-flex w-fit … rounded-full …">{c.category}</span> -->
        <span class="ccd-eyebrow"><?= htmlspecialchars($c['category']) ?></span>

        <!-- mirrors: <h1 className="font-display font-bold text-4xl md:text-6xl mt-4 max-w-4xl"> -->
        <h1 class="ccd-hero-title"><?= htmlspecialchars($c['title']) ?></h1>

        <!-- mirrors: <div className="text-white/80 mt-3">{c.duration} • ₹{c.fees}L • {c.mode}</div> -->
        <div class="ccd-hero-sub">
            <?= htmlspecialchars($c['duration']) ?> &nbsp;•&nbsp;
            ₹<?= htmlspecialchars((string)($c['fees'] ?? '')) ?>L &nbsp;•&nbsp;
            <?= htmlspecialchars($c['mode'] ?? '') ?>
        </div>

        <!-- mirrors: <div className="flex gap-3 mt-6"> -->
        <div class="ccd-hero-actions">

            <!-- mirrors: <Button variant="hero" onClick={() => setApply(true)}>Apply Now</Button> -->
            <button
                class="btn btn-hero"
                style="font-size:.9rem"
                onclick="document.getElementById('ccd-modal').classList.add('open')"
            >
                Apply Now
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" width="16" height="16">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </button>

            <!-- mirrors: <Button variant="outline" … bg-white/10 backdrop-blur …>Brochure</Button> -->
            <button class="ccd-btn-brochure">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" width="16" height="16">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Brochure
            </button>

        </div>
    </div>
</section>

<!-- ═══════════════════ BODY  (mx-auto max-w-7xl px-6 py-12 grid lg:grid-cols-3 gap-10) ═══ -->
<div class="ccd-body">

    <!-- ── LEFT COLUMN  lg:col-span-2 space-y-12 ── -->
    <div class="ccd-left">

        <!-- ── OVERVIEW ── -->
        <section class="reveal">
            <h2 class="ccd-section-title">Overview</h2>
            <p class="ccd-lead"><?= htmlspecialchars($c['description'] ?? '') ?></p>
            <?php if (!empty($c['eligibility'])): ?>
            <p class="ccd-lead" style="margin-top:.75rem">
                <strong>Eligibility:</strong> <?= htmlspecialchars($c['eligibility']) ?>
            </p>
            <?php endif; ?>
        </section>

        <!-- ── CURRICULUM ── -->
        <!-- mirrors: <section><h2>Curriculum</h2><div className="space-y-3">{c.curriculum.map…}</div></section> -->
        <?php if (!empty($c['curriculum'])): ?>
        <section class="reveal">
            <h2 class="ccd-section-title">Curriculum</h2>
            <div class="ccd-curriculum">
                <?php foreach ($c['curriculum'] as $sem): ?>
                <!-- mirrors: <div className="rounded-2xl border bg-card p-5"> -->
                <div class="ccd-sem">
                    <!-- mirrors: <div className="font-display font-semibold mb-2">{s.sem}</div> -->
                    <div class="ccd-sem-label"><?= htmlspecialchars($sem['sem']) ?></div>
                    <!-- mirrors: <div className="flex flex-wrap gap-2"> -->
                    <div class="ccd-topics">
                        <?php foreach ($sem['topics'] as $topic): ?>
                        <!-- mirrors: <span className="text-xs px-3 py-1 rounded-full bg-secondary">{t}</span> -->
                        <span class="ccd-topic"><?= htmlspecialchars($topic) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ── OFFERED AT IIMs ── -->
        <!-- mirrors: <section><h2>Offered at IIMs</h2><div className="grid sm:grid-cols-2 gap-4">… -->
        <?php if (!empty($iims)): ?>
        <section class="reveal">
            <h2 class="ccd-section-title">Offered at IIMs</h2>
            <div class="ccd-iims-grid">
                <?php foreach ($iims as $iim): ?>
                <!-- mirrors: <Link … className="rounded-2xl border bg-card p-4 flex gap-3 hover:shadow-card"> -->
                <a href="college-details.php?slug=<?= urlencode($iim['slug']) ?>" class="ccd-iim-card">
                    <!-- mirrors: <img … className="size-16 rounded-lg object-cover" /> -->
                    <img
                        src="<?= htmlspecialchars($iim['image']) ?>"
                        alt="<?= htmlspecialchars($iim['name']) ?>"
                        class="ccd-iim-thumb"
                        loading="lazy"
                    />
                    <div>
                        <div class="ccd-iim-name"><?= htmlspecialchars($iim['name']) ?></div>
                        <div class="ccd-iim-loc"><?= htmlspecialchars($iim['location']) ?></div>
                        <div class="ccd-iim-meta">
                            ★ <?= htmlspecialchars((string)($iim['rating'] ?? '')) ?>
                            &nbsp;•&nbsp; ₹<?= htmlspecialchars((string)($iim['fees'] ?? '')) ?>L
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ── FAQs ── -->
        <!-- mirrors: <Accordion type="single" collapsible className="space-y-3"> -->
        <?php if (!empty($FAQS)): ?>
        <section class="reveal">
            <h2 class="ccd-section-title">FAQs</h2>
            <div class="faq-wrap">
                <?php foreach ($FAQS as $faq): ?>
                <!-- mirrors: <AccordionItem … className="rounded-xl border bg-card px-5"> -->
                <div class="faq-item">
                    <!-- mirrors: <AccordionTrigger className="font-display font-semibold text-left"> -->
                    <div class="faq-question" onclick="ccdToggleFaq(this)">
                        <?= htmlspecialchars($faq['q']) ?>
                        <svg class="faq-arrow" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                    <!-- mirrors: <AccordionContent className="text-muted-foreground"> -->
                    <div class="faq-answer"><?= htmlspecialchars($faq['a']) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

    </div><!-- /ccd-left -->

    <!-- ── SIDEBAR  lg:col-span-1 ── -->
    <!-- mirrors: <aside className="lg:col-span-1"> -->
    <aside class="ccd-sidebar">

        <!-- mirrors: <div className="sticky top-24 rounded-2xl border bg-card shadow-card p-6"> -->
        <div class="ccd-sidebar-card">

            <!-- mirrors: <h3 className="font-display font-bold text-xl">Get a free callback</h3> -->
            <div class="ccd-sidebar-title">Get a free callback</div>

            <!-- mirrors: <form className="grid gap-3 mt-4" onSubmit={(e)=>{e.preventDefault();setApply(true)}}> -->
            <form class="ccd-form" onsubmit="return ccdHandleCallback(event)" novalidate>
                <input type="hidden" name="course" value="<?= htmlspecialchars($c['title']) ?>">

                <!-- mirrors: <div className="grid gap-1.5"><Label>Name</Label><Input required /></div> -->
                <div class="ccd-field">
                    <label class="ccd-label">Name</label>
                    <input type="text" class="ccd-input" name="name" placeholder="Your full name" required />
                </div>

                <!-- mirrors: <div className="grid gap-1.5"><Label>Email</Label><Input type="email" required /></div> -->
                <div class="ccd-field">
                    <label class="ccd-label">Email</label>
                    <input type="email" class="ccd-input" name="email" placeholder="you@example.com" required />
                </div>

                <!-- mirrors: <div className="grid gap-1.5"><Label>Phone</Label><Input required /></div> -->
                <div class="ccd-field">
                    <label class="ccd-label">Phone</label>
                    <input type="tel" class="ccd-input" name="phone" placeholder="+91 98765 43210" required />
                </div>

                <!-- mirrors: <Button type="submit" variant="hero" size="lg">Request Callback</Button> -->
                <button type="submit" class="btn btn-hero" style="width:100%;justify-content:center;margin-top:.25rem">
                    Request Callback
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" width="16" height="16">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </button>
            </form>

        </div>
    </aside>

</div><!-- /ccd-body -->

<!-- ═══════════════════ RECOMMENDED PROGRAMMES ═══════════════════ -->
<!-- mirrors: <section className="mx-auto max-w-7xl px-6 pb-16"> -->
<?php if (!empty($recommended)): ?>
<div class="ccd-rec-wrap">

    <!-- mirrors: <h3 className="font-display font-bold text-2xl mb-6">Recommended Programmes</h3> -->
    <h3 class="ccd-rec-title">Recommended Programmes</h3>

    <!-- mirrors: <div className="grid md:grid-cols-3 gap-5"> -->
    <div class="ccd-rec-grid">
        <?php foreach ($recommended as $r): ?>
        <!-- mirrors: <Link … className="rounded-2xl border bg-card p-5 hover:shadow-card"> -->
        <a href="course-details.php?slug=<?= urlencode($r['slug']) ?>" class="ccd-rec-card reveal">

            <!-- mirrors: <div className="text-[10px] uppercase font-bold text-accent">{r.category}</div> -->
            <div class="ccd-rec-cat"><?= htmlspecialchars($r['category']) ?></div>

            <!-- mirrors: <div className="font-display font-semibold mt-1 line-clamp-2">{r.title}</div> -->
            <div class="ccd-rec-name"><?= htmlspecialchars($r['title']) ?></div>

            <!-- mirrors: <div className="text-xs text-muted-foreground mt-2">{r.duration} • ₹{r.fees}L</div> -->
            <div class="ccd-rec-meta">
                <?= htmlspecialchars($r['duration'] ?? '') ?>
                &nbsp;•&nbsp; ₹<?= htmlspecialchars((string)($r['fees'] ?? '')) ?>L
            </div>

        </a>
        <?php endforeach; ?>
    </div>

</div>
<?php endif; ?>

<!-- ═══════════════════ APPLY MODAL  (mirrors <ApplyModal open={apply} onOpenChange={setApply}>) ══ -->
<div
    id="ccd-modal"
    class="ccd-modal-backdrop"
    onclick="if(event.target===this)this.classList.remove('open')"
>
    <div class="ccd-modal-box">

        <button
            class="ccd-modal-close"
            onclick="document.getElementById('ccd-modal').classList.remove('open')"
        >✕</button>

        <div class="ccd-modal-h">Apply for <?= htmlspecialchars($c['title']) ?></div>
        <p class="ccd-modal-sub">Our team will reach out within 24 hours.</p>

        <form class="ccd-form" onsubmit="return ccdHandleApply(event)" novalidate>
            <input type="hidden" name="course" value="<?= htmlspecialchars($c['title']) ?>">

            <div class="ccd-field">
                <label class="ccd-label">Name</label>
                <input type="text" class="ccd-input" name="name" placeholder="Full name" required />
            </div>
            <div class="ccd-field">
                <label class="ccd-label">Email</label>
                <input type="email" class="ccd-input" name="email" placeholder="you@example.com" required />
            </div>
            <div class="ccd-field">
                <label class="ccd-label">Phone</label>
                <input type="tel" class="ccd-input" name="phone" placeholder="+91 98765 43210" required />
            </div>

            <button type="submit" class="btn btn-hero" style="width:100%;justify-content:center;margin-top:.25rem">
                Submit Application
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" width="16" height="16">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </button>
        </form>

    </div>
</div>

<!-- ═══════════════════ TOAST ═══════════════════ -->
<div class="ccd-toast" id="ccd-toast"></div>

<!-- ═══════════════════ JS ═══════════════════ -->
<script>
/* FAQ accordion — mirrors shadcn <Accordion type="single" collapsible> */
function ccdToggleFaq(btn) {
    var item    = btn.closest('.faq-item');
    var wasOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(function(el){ el.classList.remove('open'); });
    if (!wasOpen) item.classList.add('open');
}

/* Toast */
function ccdToast(msg) {
    var el = document.getElementById('ccd-toast');
    el.textContent = msg;
    el.classList.add('show');
    setTimeout(function(){ el.classList.remove('show'); }, 2800);
}

/* Callback form — mirrors onSubmit={(e)=>{ e.preventDefault(); setApply(true); }} */
function ccdHandleCallback(e) {
    e.preventDefault();
    ccdToast("Callback requested! We'll be in touch soon.");
    e.target.reset();
    return false;
}

/* Apply modal form */
function ccdHandleApply(e) {
    e.preventDefault();
    document.getElementById('ccd-modal').classList.remove('open');
    ccdToast('Application submitted! ✓');
    e.target.reset();
    return false;
}

/* Scroll-triggered reveal — mirrors framer-motion whileInView + viewport:{once:true} */
(function(){
    var io = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){ e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    },{threshold:0.08});
    document.querySelectorAll('.reveal').forEach(function(el){ io.observe(el); });
})();
</script>

<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>