<!-- ====== PREMIUM FOOTER (ONE FILE) ====== -->
<style>
  .premium-footer {
    position: relative;
    background-image: url("bg.png");
    backdrop-filter: blur(12px);
    border-top: 1px solid rgba(255, 122, 0, 0.25);
    color: #aaaaaa;
    margin-top: 80px;
  }

  .footer-overlay {
    background-image: url("bg.png");
    opacity: 0.15;
    position: absolute;
    inset: 0;
    z-index: 0;
  }

  .premium-footer * {
    position: relative;
    z-index: 2;
  }

  .footer-logo {
    font-size: 1.7rem;
    font-weight: 700;
    background: linear-gradient(90deg, #ff9d00, #ff6a00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .footer-title {
    color: #ff6a00;
    font-weight: 600;
    margin-bottom: 12px;
  }

  .footer-links {
    list-style: none;
    padding: 0;
  }

  .footer-links li {
    margin-bottom: 6px;
  }

  .footer-links a {
    color: #aaaaaa;
    text-decoration: none;
    transition: 0.3s ease;
  }

  .footer-links a:hover {
    color: #ff6a00;
  }

  .footer-text {
    color: #aaaaaa;
    margin-bottom: 6px;
    font-size: 0.95rem;
  }

  .footer-line {
    border-color: rgba(255, 122, 0, 0.2);
  }

  .footer-bottom-text {
    font-size: 0.9rem;
    color: #aaaaaa;
    padding-top: 10px;
  }
</style>

<footer class="premium-footer">
  <div class="footer-overlay"></div>

  <div class="container py-5">

    <div class="row">

      <!-- Brand -->
      <div class="col-md-4 mb-4">
        <h3 class="footer-logo">E-BOOK PANEL</h3>
        <p class="footer-text">
          Manage your books, categories and users easily inside this elegant dashboard.
        </p>
      </div>

      <!-- Useful Links -->
      <div class="col-md-4 mb-4">
        <h5 class="footer-title">Quick Links</h5>
        <ul class="footer-links">
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="book_show.php">Books</a></li>
          <li><a href="category_show.php">Categories</a></li>
          <li><a href="user_show.php">Users</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-md-4 mb-4">
        <h5 class="footer-title">Contact</h5>
        <p class="footer-text"><i class="bi bi-envelope"></i> support@ebookpanel.com</p>
        <p class="footer-text"><i class="bi bi-geo-alt"></i> Karachi, Pakistan</p>
      </div>

    </div>

    <hr class="footer-line">

    <div class="text-center footer-bottom-text">
      © <?= date("Y") ?> E-Book Panel — All Rights Reserved.
    </div>

  </div>
</footer>


<!-- Scroll Top -->
<a href="#" id="scroll-top" style="padding:30px;" class="scroll-top d-flex align-items-center justify-content-center"><i style="font-size:44px;"
    class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>
