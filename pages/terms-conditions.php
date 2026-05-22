<?php
$page_title = "Terms & Conditions";
$current_page = "terms-conditions";

include '../includes/header.php';
include '../components/Navbar.php';
?>

<style>
    :root {
        --navy: #0b1220;
        --navy-light: #172033;
        --orange: #ff7a00;
        --orange-light: #ffb366;
        --cream: #fffaf5;
        --border: #e9e2d8;
        --text: #5b6475;
        --shadow: 0 10px 40px rgba(0, 0, 0, .06);
    }

    .terms-hero {
        background:
            linear-gradient(rgba(11, 18, 32, .88), rgba(11, 18, 32, .9)),
            url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1400&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        padding: 120px 0 90px;
        position: relative;
        overflow: hidden;
    }

    .terms-hero::after {
        content: "";
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255, 122, 0, .12);
        border-radius: 50%;
        right: -120px;
        top: -120px;
        filter: blur(10px);
    }

    .terms-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .14);
        color: #fff;
        padding: 10px 18px;
        border-radius: 100px;
        font-size: .9rem;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
    }

    .terms-title {
        color: #fff;
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 18px;
    }

    .terms-title span {
        color: var(--orange);
    }

    .terms-sub {
        color: rgba(255, 255, 255, .78);
        max-width: 850px;
        line-height: 1.9;
        font-size: 1.02rem;
    }

    .terms-wrapper {
        margin-top: -60px;
        position: relative;
        z-index: 10;
    }

    .terms-card {
        background: #fff;
        border-radius: 28px;
        padding: 45px;
        box-shadow: var(--shadow);
        border: 1px solid rgba(0, 0, 0, .05);
    }

    .terms-card+.terms-card {
        margin-top: 28px;
    }

    .terms-section {
        padding-bottom: 35px;
        margin-bottom: 35px;
        border-bottom: 1px solid #edf1f5;
    }

    .terms-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .terms-section h2 {
        font-size: 1.7rem;
        font-weight: 800;
        margin-bottom: 20px;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .terms-number {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: rgba(255, 122, 0, .12);
        color: var(--orange);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1rem;
    }

    .terms-section p {
        color: var(--text);
        line-height: 2;
        margin-bottom: 18px;
        font-size: 1rem;
    }

    .terms-section ul {
        padding-left: 20px;
    }

    .terms-section ul li {
        color: var(--text);
        margin-bottom: 14px;
        line-height: 1.9;
    }

    .highlight-box {
        background: var(--cream);
        border: 1px solid #ffe2c4;
        border-left: 5px solid var(--orange);
        padding: 25px;
        border-radius: 18px;
        margin-top: 25px;
    }

    .highlight-box h5 {
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--navy);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 25px;
    }

    .info-card {
        border: 1px solid #edf1f5;
        border-radius: 18px;
        padding: 25px;
        background: #fff;
    }

    .info-card h4 {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--navy);
    }

    .info-card p {
        margin: 0;
        color: var(--text);
        line-height: 1.8;
    }

    .contact-box {
        background: linear-gradient(135deg, var(--navy), #101827);
        border-radius: 24px;
        padding: 40px;
        color: #fff;
        overflow: hidden;
        position: relative;
    }

    .contact-box::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        background: rgba(255, 122, 0, .12);
        border-radius: 50%;
        right: -80px;
        top: -80px;
    }

    .contact-box h3 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 15px;
        position: relative;
        z-index: 2;
    }

    .contact-box p {
        color: rgba(255, 255, 255, .75);
        line-height: 1.9;
        position: relative;
        z-index: 2;
    }

    .contact-list {
        margin-top: 30px;
        position: relative;
        z-index: 2;
    }

    .contact-list div {
        margin-bottom: 14px;
        font-size: 1rem;
    }

    .last-update {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #fff4ea;
        border: 1px solid #ffd7b0;
        color: #d56600;
        padding: 10px 18px;
        border-radius: 100px;
        font-weight: 600;
        margin-top: 22px;
    }

    @media(max-width:991px) {

        .terms-title {
            font-size: 2.5rem;
        }

        .terms-card {
            padding: 28px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width:767px) {

        .terms-hero {
            padding: 100px 0 80px;
        }

        .terms-title {
            font-size: 2rem;
        }

        .terms-card {
            padding: 22px;
            border-radius: 22px;
        }

        .terms-section h2 {
            font-size: 1.3rem;
        }

    }
</style>

<section class="terms-hero">
    <div class="container position-relative" style="z-index:2;">
        <div class="row">
            <div class="col-lg-10">

                <div class="terms-badge">
                    <span>⚖</span>
                    Terms of Service & Website Usage Policy
                </div>

                <h1 class="terms-title">
                    Terms <span>&</span> Conditions
                </h1>

                <p class="terms-sub">
                    Welcome to IIMs Colleges. These Terms & Conditions govern your use
                    of our platform, services, counselling resources, admission tools,
                    college comparison features, MBA information content, and all
                    digital experiences provided through our website. By accessing or
                    using this website, you acknowledge that you have read, understood,
                    and agreed to comply with these terms.
                </p>

                <div class="last-update">
                    Last Updated: <?= date('F d, Y') ?>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container terms-wrapper">

        <!-- Intro -->
        <div class="terms-card">

            <div class="terms-section">
                <h2>
                    <span class="terms-number">1</span>
                    Acceptance of Terms
                </h2>

                <p>
                    By accessing, browsing, or using the IIMs Colleges website,
                    you confirm that you agree to these Terms & Conditions,
                    our Privacy Policy, and all applicable laws and regulations.
                    If you do not agree with any part of these terms,
                    you should discontinue the use of this website immediately.
                </p>

                <p>
                    These terms apply to all users including students,
                    MBA aspirants, counselling applicants, institutions,
                    visitors, content contributors, and any person accessing
                    our website through desktop, mobile, tablet, or other devices.
                </p>

                <div class="highlight-box">
                    <h5>Important Notice</h5>

                    <p class="mb-0">
                        IIMs Colleges is an independent educational information
                        platform and is not officially affiliated with any
                        Indian Institute of Management (IIM) unless explicitly stated.
                        All college logos, names, trademarks, and institutional
                        references belong to their respective owners.
                    </p>
                </div>
            </div>

            <!-- Eligibility -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">2</span>
                    Eligibility to Use
                </h2>

                <p>
                    You must be at least 18 years of age or accessing the website
                    under the supervision of a parent or legal guardian.
                    By using this platform, you represent that the information
                    submitted by you is accurate, complete, and up to date.
                </p>

                <ul>
                    <li>You agree not to use the platform for fraudulent purposes.</li>
                    <li>You agree not to misuse counselling or admission services.</li>
                    <li>You shall not impersonate another individual or organization.</li>
                    <li>You must provide authentic educational and contact information.</li>
                    <li>You are responsible for maintaining the confidentiality of your data.</li>
                </ul>
            </div>

            <!-- Services -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">3</span>
                    Scope of Services
                </h2>

                <p>
                    IIMs Colleges provides educational content, MBA guidance,
                    admission updates, college discovery tools, entrance exam
                    information, placement insights, counselling assistance,
                    comparison tools, and informational resources related to
                    management education in India.
                </p>

                <p>
                    While we strive to keep all information accurate and updated,
                    admission policies, fee structures, cutoffs, placements,
                    rankings, scholarships, hostel fees, and eligibility criteria
                    may change without prior notice by the respective institutions.
                </p>

                <div class="info-grid">

                    <div class="info-card">
                        <h4>What We Provide</h4>
                        <p>
                            MBA guidance, admission support,
                            educational blogs, college comparisons,
                            counselling services, notifications,
                            and informational tools for students.
                        </p>
                    </div>

                    <div class="info-card">
                        <h4>What We Do Not Guarantee</h4>
                        <p>
                            Admission confirmation, placement guarantees,
                            scholarship approvals, rank predictions,
                            or official institutional representation.
                        </p>
                    </div>

                </div>
            </div>

            <!-- User Conduct -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">4</span>
                    User Responsibilities & Conduct
                </h2>

                <p>
                    Users are expected to use the website responsibly and ethically.
                    Any misuse of the platform may result in suspension,
                    restricted access, or legal action where applicable.
                </p>

                <ul>
                    <li>Do not upload malicious code, spam, or harmful software.</li>
                    <li>Do not attempt unauthorized access to our systems.</li>
                    <li>Do not copy or reproduce content without permission.</li>
                    <li>Do not misuse enquiry forms or counselling systems.</li>
                    <li>Do not engage in abusive, offensive, or misleading behavior.</li>
                    <li>Do not interfere with the operation or security of the website.</li>
                </ul>
            </div>

            <!-- Intellectual -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">5</span>
                    Intellectual Property Rights
                </h2>

                <p>
                    All website content including text, graphics, layouts,
                    design systems, UI elements, logos, articles,
                    illustrations, branding assets, downloadable resources,
                    and digital materials are protected under applicable
                    intellectual property laws.
                </p>

                <p>
                    Unauthorized reproduction, resale, distribution,
                    republication, or commercial use of website content
                    without written permission is strictly prohibited.
                </p>

                <div class="highlight-box">
                    <h5>Trademark Disclaimer</h5>

                    <p class="mb-0">
                        Institutional names and trademarks referenced on this
                        platform remain the property of their respective institutions
                        and are used solely for informational and educational purposes.
                    </p>
                </div>
            </div>

            <!-- Accuracy -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">6</span>
                    Accuracy of Information
                </h2>

                <p>
                    We make reasonable efforts to ensure that all information
                    available on the platform is accurate and updated.
                    However, we do not warrant or guarantee the completeness,
                    reliability, or accuracy of educational content,
                    admission data, placement reports, rankings,
                    or institutional statistics.
                </p>

                <p>
                    Users are encouraged to verify official information directly
                    from the concerned institution before making educational,
                    financial, or career decisions.
                </p>
            </div>

            <!-- Third Party -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">7</span>
                    Third-Party Links & Resources
                </h2>

                <p>
                    Our website may include links to external websites,
                    educational institutions, payment gateways,
                    social media platforms, or third-party resources.
                    We do not control or endorse the content,
                    security, or practices of third-party platforms.
                </p>

                <p>
                    Visiting external links from our website is entirely
                    at your own discretion and risk.
                </p>
            </div>

            <!-- Disclaimer -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">8</span>
                    Disclaimer of Warranties
                </h2>

                <p>
                    The website and all related services are provided
                    on an “as is” and “as available” basis without warranties
                    of any kind, either express or implied.
                </p>

                <ul>
                    <li>We do not guarantee uninterrupted website availability.</li>
                    <li>We do not guarantee admission outcomes.</li>
                    <li>We do not guarantee placement opportunities.</li>
                    <li>We are not responsible for technical interruptions.</li>
                    <li>We are not liable for user-generated inaccuracies.</li>
                </ul>
            </div>

            <!-- Limitation -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">9</span>
                    Limitation of Liability
                </h2>

                <p>
                    IIMs Colleges shall not be held liable for any direct,
                    indirect, incidental, consequential, or special damages
                    arising from the use of this website or reliance on
                    educational information provided through the platform.
                </p>

                <p>
                    This includes but is not limited to admission decisions,
                    academic losses, financial losses, counselling outcomes,
                    technical failures, or third-party actions.
                </p>
            </div>

            <!-- Privacy -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">10</span>
                    Privacy & Data Usage
                </h2>

                <p>
                    By using this website, you consent to the collection
                    and usage of information as described in our Privacy Policy.
                    Personal information submitted through forms,
                    counselling requests, or newsletter subscriptions
                    may be used to improve services and communicate updates.
                </p>

                <p>
                    We implement reasonable security measures to protect
                    user data; however, no internet-based platform can
                    guarantee absolute security.
                </p>
            </div>

            <!-- Modifications -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">11</span>
                    Changes to Terms
                </h2>

                <p>
                    We reserve the right to update, revise,
                    or modify these Terms & Conditions at any time
                    without prior notice.
                </p>

                <p>
                    Continued use of the platform after updates
                    constitutes acceptance of the revised terms.
                </p>
            </div>

            <!-- Governing -->
            <div class="terms-section">
                <h2>
                    <span class="terms-number">12</span>
                    Governing Law
                </h2>

                <p>
                    These Terms & Conditions shall be governed
                    and interpreted in accordance with the laws of India.
                    Any disputes arising from the use of this website
                    shall fall under the jurisdiction of Indian courts.
                </p>
            </div>

        </div>

        <!-- Contact -->
        <div class="terms-card">

            <div class="contact-box">

                <h3>
                    Contact Information
                </h3>

                <p>
                    If you have any questions, concerns,
                    legal notices, or requests related to these
                    Terms & Conditions, feel free to contact us.
                </p>

                <div class="contact-list">
                    <div>
                        <strong>Email:</strong>
                        hello@iimscourses.com
                    </div>

                    <div>
                        <strong>Website:</strong>
                        www.iimscourses.com
                    </div>

                    <div>
                        <strong>Support:</strong>
                        Monday to Saturday — 10:00 AM to 6:00 PM
                    </div>

                    <div>
                        <strong>Location:</strong>
                        Bengaluru, Karnataka, India
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<?php
include '../components/Footer.php';
include '../includes/footer.php';
?>