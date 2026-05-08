<?php
/**
 * components/Footer.php
 * PHP conversion of src/components/Footer.tsx
 */
?>
<footer>
  <div class="container">
    <div class="footer-grid">

      <!-- Brand -->
      <div>
        <div class="footer-brand-logo">
          <div class="navbar-logo-icon" style="width:36px;height:36px;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;color:#fff">
              <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
              <path d="M6 12v5c3 3 9 3 12 0v-5"/>
            </svg>
          </div>
          <span>IIMs Courses</span>
        </div>
        <p class="footer-desc">
          India's most trusted discovery platform for Indian Institutes of Management.
          Verified data, transparent placements, free counselling.
        </p>
      </div>

      <!-- Explore -->
      <div class="footer-col">
        <h4>Explore</h4>
        <ul>
          <li><a href="pages/colleges.php">All IIMs</a></li>
          <li><a href="pages/courses.php">Courses</a></li>
          <li><a href="compare.php">Compare</a></li>
          <li><a href="pages/blogs.php">Blogs</a></li>
        </ul>
      </div>

      <!-- Company -->
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="about.php">About</a></li>
          <li><a href="careers.php">Careers</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="footer-col">
        <h4>Get in touch</h4>
        <ul class="footer-contact">
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            hello@iimscourses.com
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.16 12 19.79 19.79 0 0 1 1.11 3.4 2 2 0 0 1 3.09 1.22h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.09 9a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 21 16z"/></svg>
            +91 90000 11122
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Bengaluru, India
          </li>
        </ul>
      </div>

    </div><!-- /footer-grid -->
  </div>

  <div class="container">
    <div class="footer-bottom">
      <span>© <?= date('Y') ?> IIMs Courses. Crafted for MBA aspirants.</span>
      <span>Not affiliated with any IIM. Data compiled from public sources.</span>
    </div>
  </div>
</footer>