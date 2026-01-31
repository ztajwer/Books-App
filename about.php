<?php include_once("includes/header.php") ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>About Us — E-Book Platform</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --orange: #ff6f00;
      --orange-light: #ff8b3d;
      --white: #ffffff;
      --muted: #555;
      --soft: #fff7ef;
      --card-border: rgba(255, 111, 0, 0.18);
    }

    body {
      margin: 0;
      font-family: 'Poppins';
      background: #ffffff;
      color: #222;
      overflow-x: hidden;
    }

    .page-wrap {
      padding: 60px 0 120px;
    }

    /* TITLES */
    .section-title {
      text-align: center;
      font-size: 36px;
      font-weight: 800;
      color: var(--orange);
    }

    .section-sub {
      text-align: center;
      color: var(--muted);
      max-width: 900px;
      margin: auto;
    }

    /* GLASS CARD — White Version */
    .glass {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(12px);
      border: 1px solid var(--card-border);
      border-radius: 14px;
      box-shadow: 0 8px 30px rgba(255, 150, 50, .18);
    }

    /* INTRO */
    .intro {
      padding: 30px;
      display: flex;
      gap: 24px;
      flex-wrap: wrap;
      align-items: center;
    }

    .intro h1 {
      font-size: 40px;
      font-weight: 800;
      color: var(--orange);
    }

    .intro p {
      color: #666;
    }

    .btn-cta {
      background: linear-gradient(45deg, var(--orange), var(--orange-light));
      border: none;
      color: white;
      padding: 10px 18px;
      border-radius: 8px;
      font-weight: 600;
    }

    /* Floating Book */
    .floating-book {
      height: 250px;
      background: var(--soft);
      border-radius: 16px;
      display: flex;
      justify-content: center;
      align-items: center;
      border: 1px solid var(--card-border);
    }

    .floating-book img {
      width: 230px;
      transition: .4s;
      border-radius: 12px;
    }

    .floating-book:hover img {
      transform: translateY(-10px) scale(1.04);
    }

    /* FEATURES */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 18px;
    }

    .feature .icon {
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      border-radius: 12px;
      background: var(--soft);
      color: var(--orange);
      margin-bottom: 10px;
    }

    .feature p {
      color: #666;
    }

    /* BOOKS SLIDER */
    .book-slider {
      display: flex;
      gap: 18px;
      overflow-x: auto;
      padding-bottom: 10px;
      justify-content: center;
      align-items: center;
    }

    .book {
      min-width: 200px;
      border: 1px solid var(--card-border);
      border-radius: 12px;
      padding: 10px;
      background: white;
      box-shadow: 0 4px 18px rgba(255, 150, 50, 0.15);
    }

    .book img {
      width: 100%;
      height: 260px;
      object-fit: cover;
      border-radius: 10px;
    }

    .text-orange {
      color: var(--orange);
    }

    /* TIMELINE */
    .timeline-row {
      margin: 20px;
    }

    .timeline-year {
      font-weight: 700;
      font-size: 20px;
      color: var(--orange);
      min-width: 80px;
    }

    .timeline-card {
      background: var(--soft);
      padding: 16px;
      border-radius: 12px;
      border: 1px solid var(--card-border);
    }

    .df {
      display: flex;
      margin: 0;
    }

    /* TEAM */
    .team-grid {
      display: grid;
      gap: 20px;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    }

    .team-card {
      text-align: center;
      padding: 16px;
      background: white;
      border-radius: 14px;
      border: 1px solid var(--card-border);
      box-shadow: 0 4px 18px rgba(255, 150, 50, 0.2);
    }

    .team-card img {
      width: 110px;
      height: 110px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid var(--orange-light);
    }

    .team-card p {
      color: #777;
    }

    /* TESTIMONIAL */
    .testimonial {
      background: var(--soft);
      padding: 18px;
      border-radius: 12px;
      border: 1px solid var(--card-border);
    }

    /* FAQ */
    .faq-btn {
      width: 100%;
      padding: 16px;
      border: none;
      background: var(--soft);
      display: flex;
      justify-content: space-between;
      border-bottom: 1px solid var(--card-border);
      font-weight: 600;
    }

    .faq-content {
      padding: 14px;
      background: white;
      display: none;
      color: #555;
    }

    /* CTA */
    .cta {
      background: linear-gradient(45deg, #fff3e0, #ffe4c4);
      border: 1px solid var(--card-border);
      border-radius: 14px;
      padding: 28px;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 20px;
    }
  </style>
</head>

<body>
  <br><br>
  <div class="container page-wrap">

    <!-- INTRO -->
    <section class="glass intro" data-aos="fade-up">
      <div style="flex:1;min-width:300px">
        <h1>About Our Platform</h1>
        <p>
          We are a modern e-book community where readers, students and writers come together.
          We focus on discovery, competitions, and publishing — built with performance,
          accessibility, and a beautiful orange-white design.
        </p>
        <div class="d-flex gap-3 mt-3">
          <a href="books.php" class="btn-cta">Explore Books</a>
        </div>
      </div>

      <div style="flex:1;max-width:420px">
        <div class="floating-book">
          <img src="assets/img/book/book-square-5.webp">
        </div>
      </div>
    </section>

    <!-- FEATURES -->
    <section class="glass p-4 mt-4" data-aos="fade-up">
      <h2 class="section-title">What Makes Us Different</h2>
      <div class="features-grid">
        <div class="feature">
          <div class="icon">📚</div>
          <h5>Massive Library</h5>
          <p>Thousands of curated books.</p>
        </div>
        <div class="feature">
          <div class="icon">🏆</div>
          <h5>Competitions</h5>
          <p>Win prizes & improve skills.</p>
        </div>
        <div class="feature">
          <div class="icon">⚡</div>
          <h5>Fast Experience</h5>
          <p>Smooth and optimized reading.</p>
        </div>
        <div class="feature">
          <div class="icon">🔒</div>
          <h5>Security</h5>
          <p>Safe for writers & readers.</p>
        </div>
      </div>
    </section>

    <!-- BOOK SLIDER -->
    <section class="mt-5" data-aos="fade-up">
      <h2 class="section-title">Featured Books</h2>
      <div class="book-slider">
        <div class="book"><img src="assets/img/book/book-1.webp">
          <h6 class="mt-2 text-orange">Book One</h6>
        </div>
        <div class="book"><img src="assets/img/book/book-5.webp">
          <h6 class="mt-2 text-orange">Book Two</h6>
        </div>
        <div class="book"><img src="assets/img/book/book-3.webp">
          <h6 class="mt-2 text-orange">Book Three</h6>
        </div>
        <div class="book"><img src="assets/img/book/book-4.webp">
          <h6 class="mt-2 text-orange">Book Four</h6>
        </div>
      </div>
    </section>

    <!-- TIMELINE -->
    <section class="glass p-4 mt-5" data-aos="fade-up">
      <h2 class="section-title">Milestones</h2>
      <div class="df">
        <div class="timeline-row">
          <div class="timeline-year">2019</div>
          <div class="timeline-card">Launched MVP version.</div>
        </div>

        <div class="timeline-row">
          <div class="timeline-year">2021</div>
          <div class="timeline-card">Introduced reader community.</div>
        </div>

        <div class="timeline-row">
          <div class="timeline-year">2023</div>
          <div class="timeline-card">Global expansion started.</div>
        </div>

        <div class="timeline-row">
          <div class="timeline-year">2024</div>
          <div class="timeline-card">Premium redesign launched.</div>
        </div>
      </div>
    </section>

    <!-- TEAM -->
    <section class="mt-5" data-aos="fade-up">
      <h2 class="section-title">Team Members</h2>
      <p class="section-sub">People who keep everything running.</p>

      <div class="team-grid">
        <div class="team-card"><img src="https://i.pravatar.cc/110?img=47">
          <h6>Sarah Khan</h6>
          <p>Founder</p>
        </div>
        <div class="team-card"><img src="https://i.pravatar.cc/110?img=12">
          <h6>Ahmad Ali</h6>
          <p>Lead Engineer</p>
        </div>
        <div class="team-card"><img src="https://i.pravatar.cc/110?img=64">
          <h6>Ayesha Noor</h6>
          <p>Creative Director</p>
        </div>
        <div class="team-card"><img src="https://i.pravatar.cc/110?img=33">
          <h6>Michael Ray</h6>
          <p>Operations</p>
        </div>
      </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="glass p-4 mt-5" data-aos="fade-up">
      <h2 class="section-title">What Readers Say</h2>

      <div class="row g-3">
        <div class="col-md-4">
          <div class="testimonial">
            <p>“Amazing platform, I love the competitions.”</p><b>— Junaid</b>
          </div>
        </div>
        <div class="col-md-4">
          <div class="testimonial">
            <p>“Beautiful UI and great book collection.”</p><b>— Mariam</b>
          </div>
        </div>
        <div class="col-md-4">
          <div class="testimonial">
            <p>“Best place for students and writers.”</p><b>— Usama</b>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="glass p-4 mt-5" data-aos="zoom-in">
      <div class="cta">
        <div>
          <h3 style="color:var(--orange);font-weight:800;">Start reading thousands of books today!</h3>
          <p class="text-muted">Join thousands of readers & writers — it's free.</p>
        </div>
      </div>
    </section>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>AOS.init();</script>

</body>
<?php include_once "contact.php" ?>
</html>
<?php include_once("includes/footer.php") ?>