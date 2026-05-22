<?php
$page_title = "Privacy Policy";
$current_page = "privacy-policy";

include '../includes/header.php';
include '../components/Navbar.php';
?>

<style>
    /* =========================================================
   PRIVACY POLICY PAGE
========================================================= */

    .pp-hero {
        background:
            linear-gradient(rgba(8, 18, 35, .82), rgba(8, 18, 35, .92)),
            url('../assets/images/iim-banner.jpg') center/cover no-repeat;
        padding: 120px 0 90px;
        position: relative;
        overflow: hidden;
    }

    .pp-hero::before {
        content: '';
        position: absolute;
        width: 420px;
        height: 420px;
        background: rgba(255, 122, 0, .08);
        border-radius: 50%;
        top: -180px;
        right: -120px;
        filter: blur(10px);
    }

    .pp-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: rgba(255, 122, 0, .12);
        border: 1px solid rgba(255, 122, 0, .25);
        color: #ff7a00;
        padding: .55rem 1rem;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .04em;
        margin-bottom: 1.5rem;
    }

    .pp-title {
        font-size: 3rem;
        font-weight: 700;
        line-height: 1.05;
        color: #fff;
        margin-bottom: 1.2rem;
        letter-spacing: -.03em;
    }

    .pp-sub {
        color: rgba(255, 255, 255, .72);
        font-size: 0.9rem;
        line-height: 1.4;
        max-width: 760px;
    }

    .pp-last {
        margin-top: 1.8rem;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .08);
        padding: .8rem 1rem;
        border-radius: 14px;
        color: #fff;
        font-size: .9rem;
    }

    /* BODY */

    .pp-section {
        padding: 70px 0;
        background: #f7f9fc;
    }

    .pp-wrapper {
        max-width: 1100px;
        margin: auto;
    }

    .pp-card {
        background: #fff;
        border-radius: 28px;
        padding: 35px;
        border: 1px solid #e9edf3;
        box-shadow: 0 10px 40px rgba(15, 23, 42, .06);
    }

    .pp-intro {
        font-size: 0.9rem;
        line-height: 1.5;
        color: #5b6472;
    }

    .pp-grid {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 32px;
        margin-top: 3rem;
    }

    .pp-sidebar {
        position: sticky;
        top: 100px;
        align-self: start;
    }

    .pp-nav {
        background: #fff;
        border-radius: 22px;
        padding: 24px;
        border: 1px solid #edf1f6;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
    }

    .pp-nav h5 {
        font-size: .92rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: #0f172a;
    }

    .pp-nav a {
        display: block;
        padding: .6rem .55rem;
        text-decoration: none;
        color: #64748b;
        border-radius: 12px;
        font-size: .92rem;
        font-weight: 500;
        transition: .25s;
    }

    .pp-nav a:hover {
        background: #fff3e8;
        color: #ff7a00;
    }

    .pp-content {
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .pp-box {
        background: #fff;
        border-radius: 24px;
        padding: 36px;
        border: 1px solid #edf1f6;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
    }

    .pp-box h2 {
        font-size: 1.7rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.2rem;
    }

    .pp-box p {
        color: #5f6b7b;
        line-height: 2;
        margin-bottom: 1rem;
    }

    .pp-box ul {
        padding-left: 1.2rem;
    }

    .pp-box ul li {
        color: #5f6b7b;
        margin-bottom: .9rem;
        line-height: 1.9;
    }

    .pp-highlight {
        background: #fff5eb;
        border: 1px solid rgba(255, 122, 0, .18);
        border-left: 5px solid #ff7a00;
        padding: 1.2rem 1.3rem;
        border-radius: 16px;
        margin-top: 1.5rem;
    }

    .pp-highlight strong {
        color: #ff7a00;
    }

    .pp-contact {
        background: linear-gradient(135deg, #0f172a, #132238);
        border-radius: 28px;
        padding: 30px;
        margin-top: 2rem;
        overflow: hidden;
        position: relative;
    }

    .pp-contact::before {
        content: '';
        position: absolute;
        width: 260px;
        height: 260px;
        background: rgba(255, 122, 0, .08);
        border-radius: 50%;
        right: -90px;
        top: -80px;
    }

    .pp-contact h3 {
        color: #fff;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.7rem;
        position: relative;
        z-index: 2;
    }

    .pp-contact p {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, .7);
        line-height: 1.5;
        position: relative;
        z-index: 2;
    }

    .pp-contact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-top: 2rem;
        position: relative;
        z-index: 2;
    }

    .pp-contact-item {
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 18px;
        padding: 10px;
    }

    .pp-contact-item small {
        display: block;
        color: rgba(255, 255, 255, .45);
        margin-bottom: .35rem;
        text-transform: uppercase;
        font-size: .62rem;
        letter-spacing: .08em;
    }

    .pp-contact-item span {
        color: #fff;
        font-weight: 500;
        font-size: 0.7rem;
        word-break: break-word;
    }

    @media(max-width:991px) {

        .pp-grid {
            grid-template-columns: 1fr;
        }

        .pp-sidebar {
            position: relative;
            top: 0;
        }

        .pp-contact-grid {
            grid-template-columns: 1fr;
        }

        .pp-card,
        .pp-box,
        .pp-contact {
            padding: 28px;
        }
    }

    @media(max-width:767px) {

        .pp-hero {
            padding: 100px 0 70px;
        }

        .pp-title {
            font-size: 2.7rem;
        }

        .pp-card,
        .pp-box,
        .pp-contact {
            padding: 22px;
            border-radius: 22px;
        }
    }
</style>

<!-- =========================================================
     HERO
========================================================= -->

<section class="pp-hero">
    <div class="container position-relative" style="z-index:2;">

        <div class="pp-badge">
            Privacy & Data Protection
        </div>

        <h1 class="pp-title">
            Privacy Policy
        </h1>

        <p class="pp-sub">
            At IIMs Colleges, we are committed to protecting your privacy,
            safeguarding your personal information, and maintaining complete
            transparency regarding how your data is collected, used, stored,
            and processed while using our platform and services.
        </p>

        <div class="pp-last">
            Last Updated:
            <strong><?= date('F d, Y') ?></strong>
        </div>

    </div>
</section>

<!-- =========================================================
     BODY
========================================================= -->

<section class="pp-section">

    <div class="container">

        <div class="pp-wrapper">

            <div class="pp-card">
                <p class="pp-intro">
                    This Privacy Policy applies to all visitors, users, students,
                    aspirants, counselling applicants, and individuals accessing
                    the IIMs Colleges platform. By using our website, you consent
                    to the practices described in this Privacy Policy. We encourage
                    you to read this document carefully to understand how your
                    personal information is handled.
                </p>
            </div>

            <div class="pp-grid">

                <!-- SIDEBAR -->
                <div class="pp-sidebar">

                    <div class="pp-nav">
                        <h5>Quick Navigation</h5>

                        <a href="#info">Information Collection</a>
                        <a href="#usage">Use of Information</a>
                        <a href="#cookies">Cookies Policy</a>
                        <a href="#security">Data Security</a>
                        <a href="#sharing">Information Sharing</a>
                        <a href="#rights">User Rights</a>
                        <a href="#thirdparty">Third Party Services</a>
                        <a href="#children">Children's Privacy</a>
                        <a href="#updates">Policy Updates</a>
                        <a href="#contact">Contact Information</a>
                    </div>

                </div>

                <!-- CONTENT -->
                <div class="pp-content">

                    <div class="pp-box" id="info">
                        <h2>1. Information We Collect</h2>

                        <p>
                            We collect various types of information to improve
                            our services, provide counselling assistance, deliver
                            admission updates, and enhance your overall user experience.
                        </p>

                        <ul>
                            <li>Full Name and Contact Information</li>
                            <li>Email Address and Mobile Number</li>
                            <li>Educational Qualification Details</li>
                            <li>Preferred MBA Courses and Colleges</li>
                            <li>Exam Scores and Academic Interests</li>
                            <li>Location and Device Information</li>
                            <li>Browser Type and Website Usage Analytics</li>
                            <li>Communication Preferences and Inquiry Records</li>
                        </ul>

                        <div class="pp-highlight">
                            <strong>Important:</strong>
                            We only collect information that is relevant for
                            counselling, admission guidance, analytics, service
                            improvements, and user support purposes.
                        </div>
                    </div>

                    <div class="pp-box" id="usage">
                        <h2>2. How We Use Your Information</h2>

                        <p>
                            Information collected through our website may be used
                            for multiple operational, analytical, and service-related
                            purposes.
                        </p>

                        <ul>
                            <li>Providing MBA counselling assistance</li>
                            <li>Responding to admission-related inquiries</li>
                            <li>Sharing course recommendations and updates</li>
                            <li>Improving platform functionality and performance</li>
                            <li>Sending newsletters and admission alerts</li>
                            <li>Monitoring website security and fraud prevention</li>
                            <li>Enhancing user experience through analytics</li>
                            <li>Maintaining internal records and communication history</li>
                        </ul>

                        <p>
                            We may also use aggregated non-personal data for research,
                            reporting, and improving educational insights for MBA aspirants.
                        </p>
                    </div>

                    <div class="pp-box" id="cookies">
                        <h2>3. Cookies Policy</h2>

                        <p>
                            Cookies are small data files stored on your device that
                            help us improve your browsing experience.
                        </p>

                        <ul>
                            <li>Remembering user preferences and settings</li>
                            <li>Tracking analytics and website performance</li>
                            <li>Understanding user engagement patterns</li>
                            <li>Improving speed, functionality, and personalization</li>
                        </ul>

                        <p>
                            You can disable cookies through your browser settings,
                            although some features of the website may not function properly.
                        </p>
                    </div>

                    <div class="pp-box" id="security">
                        <h2>4. Data Security</h2>

                        <p>
                            We implement industry-standard technical and organizational
                            measures to safeguard your personal information from
                            unauthorized access, misuse, disclosure, alteration,
                            or destruction.
                        </p>

                        <ul>
                            <li>Secure server infrastructure</li>
                            <li>Encrypted communication channels</li>
                            <li>Restricted administrative access</li>
                            <li>Regular monitoring and security practices</li>
                            <li>Data access limitations and authentication</li>
                        </ul>

                        <div class="pp-highlight">
                            <strong>Security Notice:</strong>
                            Although we take strong security measures, no digital
                            transmission or online storage system can be guaranteed
                            to be 100% secure.
                        </div>
                    </div>

                    <div class="pp-box" id="sharing">
                        <h2>5. Sharing of Information</h2>

                        <p>
                            We do not sell or rent your personal information to third parties.
                        </p>

                        <p>
                            Information may only be shared under limited situations:
                        </p>

                        <ul>
                            <li>With counselling partners for admission support</li>
                            <li>When required by law or legal obligations</li>
                            <li>For fraud prevention or security investigations</li>
                            <li>With trusted service providers assisting our operations</li>
                        </ul>
                    </div>

                    <div class="pp-box" id="rights">
                        <h2>6. Your Rights & Choices</h2>

                        <p>
                            As a user of our platform, you have certain rights
                            regarding your personal information.
                        </p>

                        <ul>
                            <li>Request access to your personal information</li>
                            <li>Request correction of inaccurate data</li>
                            <li>Request deletion of your information</li>
                            <li>Opt out of marketing communications</li>
                            <li>Withdraw consent where applicable</li>
                        </ul>
                    </div>

                    <div class="pp-box" id="thirdparty">
                        <h2>7. Third-Party Services</h2>

                        <p>
                            Our website may contain links to external websites,
                            services, or platforms. These third-party websites
                            operate independently and may have separate privacy policies.
                        </p>

                        <p>
                            We are not responsible for the content, policies,
                            or practices of external websites linked through our platform.
                        </p>
                    </div>

                    <div class="pp-box" id="children">
                        <h2>8. Children's Privacy</h2>

                        <p>
                            Our services are intended for students, aspirants,
                            professionals, and users above the applicable legal age.
                        </p>

                        <p>
                            We do not knowingly collect personal information from
                            children without parental or guardian consent.
                        </p>
                    </div>

                    <div class="pp-box" id="updates">
                        <h2>9. Changes to This Policy</h2>

                        <p>
                            We reserve the right to update or modify this Privacy
                            Policy at any time without prior notice.
                        </p>

                        <p>
                            Any changes made to this Privacy Policy will be reflected
                            on this page along with the updated revision date.
                        </p>
                    </div>

                    <!-- CONTACT -->
                    <div class="pp-contact" id="contact">

                        <h3>Contact Information</h3>

                        <p>
                            If you have any questions, concerns, or requests related
                            to this Privacy Policy or your personal data, please
                            contact our support team.
                        </p>

                        <div class="pp-contact-grid">

                            <div class="pp-contact-item">
                                <small>Email Address</small>
                                <span>hello@iimscolleges.com</span>
                            </div>

                            <div class="pp-contact-item">
                                <small>Website</small>
                                <span>www.iimscolleges.com</span>
                            </div>

                            <div class="pp-contact-item">
                                <small>Support</small>
                                <span>Monday - Saturday | 10 AM - 6 PM</span>
                            </div>

                        </div>

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