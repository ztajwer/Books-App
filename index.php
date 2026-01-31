<?php
include_once("config.php");

$booksdata = mysqli_query($conn, "SELECT * FROM books INNER JOIN category ON  books.book_category = category.category_id;
");

$now = date('Y-m-d H:i:s');

$competitionData = mysqli_query($conn, "
    SELECT * FROM competition
    WHERE start_time > '$now'
       OR (start_time <= '$now' AND end_time >= '$now')
    ORDER BY start_time ASC
");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - BookLanding Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
</head>

<body class="index-page">
    <?php include_once "includes/header.php" ?>
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-5">
                        <div class="book-hero-content" data-aos="fade-up" data-aos-delay="200">
                            <span class="book-genre">Science Fiction</span>
                            <h1>Beyond the Quantum Horizon</h1>
                            <p class="book-subtitle">A journey through time and space that will transform your
                                perception</p>
                            <div class="author">
                                <span>By</span>
                                <h3>Zimal Tajwer</h3>
                            </div>
                            <p class="book-description">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac diam sit amet
                                quam vehicula elementum sed sit amet dui. Donec rutrum congue leo eget malesuada.
                            </p>
                            <div class="hero-cta">
                                <a href="#purchase" class="btn-primary">Get Your Copy</a>
                                <a href="#excerpt" class="btn-outline">Read Preview</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 d-flex justify-content-center justify-content-lg-end" data-aos="zoom-out"
                        data-aos-delay="300">
                        <div class="book-cover">
                            <img src="assets/img/book/book-1.webp" alt="Book Cover" class="img-fluid">
                            <div class="book-shadow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Hero Section -->
        <!-- winner section  -->


        <?php

        // Check if winner_id is set
        if (isset($_SESSION['winner_id'])) {
            $winner_id = $_SESSION['winner_id'];

            // Fetch winner details from part + answers
            $query = "
        SELECT part.id, part.part_name, part.part_email, part.part_num, part.part_age, answers.answer
        FROM part
        INNER JOIN answers ON part.id = answers.id
        WHERE part.id = '$winner_id'
        LIMIT 1
    ";

            $winner_result = mysqli_query($conn, $query);

            if ($winner_result && mysqli_num_rows($winner_result) > 0) {
                $winner = mysqli_fetch_assoc($winner_result);
                ?>

                <!-- Winner Section -->
                <div
                    style="background: #fff; padding: 50px 20px; text-align: center; font-family: Arial, sans-serif; color: #000;">
                    <h1 style="color: #ff6600; font-size: 2.5rem; margin-bottom: 10px;">🏆 Competition Winner 🏆</h1>
                    <p style="font-size: 1.1rem; margin-bottom: 30px;">Congratulations to our winner!</p>

                    <!-- Winner Name -->
                    <h2 style="color: #000; font-size: 2rem; margin-bottom: 20px;"><?php echo $winner['part_name']; ?></h2>

                    <div style="display:flex; justify-content: center; align-items: center; gap: 50px; margin: 50px;">
                        <!-- Participant Info -->
                        <div
                            style="background: #fff; padding: 20px; border-radius: 10px; max-width: 600px; text-align: left; border: 1px solid #ff6600;">
                            <p><strong style="color:#ff6600;">Email:</strong> <?php echo $winner['part_email']; ?></p>
                            <p><strong style="color:#ff6600;">Phone:</strong> <?php echo $winner['part_num']; ?></p>
                            <p><strong style="color:#ff6600;">Age:</strong> <?php echo $winner['part_age']; ?></p>
                        </div>

                        <!-- Winner Answer -->
                        <div
                            style="background: #fff; padding: 20px; border-radius: 10px; max-width: 600px; text-align: left; border: 1px solid #ff6600;">
                            <h5 style="color: #ff6600; margin-bottom: 10px;">Answer:</h5>
                            <p style="color: #000;"><?php echo nl2br($winner['answer']); ?></p>
                        </div>
                    </div>

                    <!-- Position & Prize -->
                    <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                        <div
                            style="background: #ff6600; padding: 12px 20px; border-radius: 8px; color: #fff; font-weight: bold;">
                            Position: 1<sup>st</sup></div>
                        <div
                            style="background: #ff6600; padding: 12px 20px; border-radius: 8px; color: #ffffffff; font-weight: bold;">
                            Prize: $500</div>
                    </div>
                </div>

                <?php
            }
        }
        ?>
        <!-- About Section -->
        <section id="about" class="about light-background">

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center gy-5 gx-lg-5">
                    <div class="col-lg-6">
                        <div class="about-book-img" data-aos="fade-right" data-aos-delay="200">
                            <img src="assets/img/book/book-square-5.webp" alt="Book Title" class="img-fluid">
                            <div class="book-details">
                                <div class="detail-item">
                                    <i class="bi bi-journal"></i>
                                    <div>
                                        <span>Pages</span>
                                        <p>384</p>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="bi bi-translate"></i>
                                    <div>
                                        <span>Language</span>
                                        <p>English</p>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="bi bi-calendar3"></i>
                                    <div>
                                        <span>Published</span>
                                        <p>12/15/2024</p>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="bi bi-star"></i>
                                    <div>
                                        <span>Rating</span>
                                        <p>4.8/5</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="about-book-content" data-aos="fade-left" data-aos-delay="300">
                            <h2>About The Book</h2>
                            <div class="book-category">
                                <span><i class="bi bi-bookmark"></i> Science Fiction</span>
                                <span><i class="bi bi-people"></i> Young Adult</span>
                            </div>
                            <p>
                                This book is carefully written to make learning simple, clear, and enjoyable for every
                                student.
                                With easy language, smooth explanations, and well-organized chapters, it helps readers
                                understand
                                even difficult concepts without stress. Each topic is explained step by step so you can
                                learn confidently.
                            </p>
                            <p>
                                Following the latest curriculum, the book includes examples, activities, and summaries
                                that
                                strengthen your understanding. Whether you are preparing for exams or revising your
                                basics,
                                this book ensures a meaningful and smooth learning experience from start to finish.
                            </p>

                            <div class="highlights">
                                <h3>What You'll Discover:</h3>
                                <ul>
                                    <li>
                                        <i class="bi bi-check-circle"></i>
                                        <span>Clear explanations of every concept in simple language</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-check-circle"></i>
                                        <span>Well-structured chapters that follow the latest syllabus</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-check-circle"></i>
                                        <span>Examples, summaries, and activities for deeper understanding</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-check-circle"></i>
                                        <span>A smooth, enjoyable learning experience for all levels</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Features Section -->
        <section id="features" class="features">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>What Makes Our Books Special</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="feature-icon">
                                <i class="bi bi-lightbulb"></i>
                            </div>
                            <h3>Innovative Concepts</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur non nulla sit amet
                                nisl tempus convallis quis ac lectus.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                            <div class="feature-icon">
                                <i class="bi bi-chat-left-quote"></i>
                            </div>
                            <h3>Engaging Dialogue</h3>
                            <p>Nulla porttitor accumsan tincidunt. Curabitur aliquet quam id dui posuere blandit. Mauris
                                blandit aliquet elit.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                            <div class="feature-icon">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                            <h3>Character Development</h3>
                            <p>Pellentesque in ipsum id orci porta dapibus. Donec rutrum congue leo eget malesuada.
                                Proin eget tortor risus.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                            <div class="feature-icon">
                                <i class="bi bi-compass"></i>
                            </div>
                            <h3>Immersive World</h3>
                            <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                Donec velit neque, auctor sit amet aliquam vel.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
                            <div class="feature-icon">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <h3>Time Travel Elements</h3>
                            <p>Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed
                                magna dictum porta. Praesent sapien massa.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card" data-aos="fade-up" data-aos-delay="600">
                            <div class="feature-icon">
                                <i class="bi bi-heart"></i>
                            </div>
                            <h3>Emotional Journey</h3>
                            <p>Quisque velit nisi, pretium ut lacinia in, elementum id enim. Curabitur arcu erat,
                                accumsan id imperdiet et, porttitor at sem.</p>
                        </div>
                    </div>
                </div>

                <!-- Related Books Section -->
                <section id="related-books" class="related-books light-background">
                    <!-- Section Title -->
                    <div class="container section-title" data-aos="fade-up">
                        <h2>More Books</h2>
                        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
                    </div><!-- End Section Title -->
                    <div class="container" data-aos="fade-up" data-aos-delay="100">
                        <div class="row justify-content-center g-3">
                            <?php foreach ($booksdata as $books) {
                                // Truncate description to 15 words
                                $descWords = explode(' ', $books["book_desc"]);
                                $shortDesc = count($descWords) > 15 ? implode(' ', array_slice($descWords, 0, 15)) . '...' : $books["book_desc"];
                                ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="related-book-card">
                                        <div class="book-image">
                                            <img height="200px" src="bookimages/<?php echo $books["book_image"]; ?>"
                                                alt="Book Cover" class="img-fluid">
                                        </div>
                                        <div class="book-info">
                                            <h3><?php echo $books["book_name"]; ?></h3>
                                            <div class="book-meta">
                                                <span><i class="bi bi-calendar3"></i> 2021</span>
                                                <span><i class="bi bi-star-fill"></i> 4.9</span>
                                            </div>
                                            <h6>Category: <?php echo $books["category_name"]; ?></h6>
                                            <p><?php echo $shortDesc; ?></p>
                                            <p class="fw-bold mt-0">$<?php echo $books["book_price"]; ?></p>
                                            <div class="book-actions">
                                                <a href="details.php?index=<?php echo $books["book_id"]; ?>"
                                                    class="btn-purchase" style="font-size: 20px;">View Details</a>
                                                <?php if (!empty($books['book_pdf'])) { ?>
                                                    <a href="bookpdfs/<?php echo $books['book_pdf']; ?>" download
                                                        class="btn btn-details" style="font-size: 20px;">Download PDF</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

            </div>
            </div>

        </section>
        <!-- /Related Books Section -->

        </div>
        </section><!-- /Features Section -->
        <!-- About Author Section -->
        <section id="about-author" class="about-author light-background">

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
                        <div class="author-image">
                            <img src="assets\img\person\person-f-1.webp" alt="Author Name" class="img-fluid">
                            <div class="author-signature">
                                <img src="assets/img/misc/signature-1.webp" alt="Author Signature" class="img-fluid">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
                        <div class="author-info">
                            <h2>About the Author</h2>
                            <h3>Zimal Tajwer</h3>
                            <div class="author-credentials">Bestselling Author of Science Fiction &amp; Fantasy</div>

                            <div class="author-bio">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eget tortor risus.
                                    Nulla quis lorem ut libero malesuada feugiat. Vestibulum ac diam sit amet quam
                                    vehicula elementum sed sit amet dui. Curabitur non nulla sit amet nisl tempus
                                    convallis quis ac lectus.
                                </p>
                                <p>
                                    Quisque velit nisi, pretium ut lacinia in, elementum id enim. Cras ultricies ligula
                                    sed magna dictum porta. Donec rutrum congue leo eget malesuada. Vestibulum ante
                                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit
                                    neque, auctor sit amet aliquam vel.
                                </p>
                                <p>
                                    Pellentesque in ipsum id orci porta dapibus. Mauris blandit aliquet elit, eget
                                    tincidunt nibh pulvinar a. Nulla porttitor accumsan tincidunt. Donec rutrum congue
                                    leo eget malesuada.
                                </p>
                            </div>

                            <div class="author-awards">
                                <h4>Awards &amp; Recognition</h4>
                                <ul>
                                    <li><i class="bi bi-award"></i> <span>Lorem Ipsum Award for Outstanding Fiction
                                            (2023)</span></li>
                                    <li><i class="bi bi-award"></i> <span>Dolor Sit Literary Prize (2021)</span></li>
                                    <li><i class="bi bi-award"></i> <span>Consectetur Adipiscing Medal (2019)</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="author-social">
                                <h4>Connect with the Author</h4>
                                <div class="social-links">
                                    <a href="#"><i class="bi bi-twitter"></i></a>
                                    <a href="#"><i class="bi bi-facebook"></i></a>
                                    <a href="#"><i class="bi bi-instagram"></i></a>
                                    <a href="#"><i class="bi bi-linkedin"></i></a>
                                    <a href="#"><i class="bi bi-globe"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /About Author Section -->

        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Testimonials</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row">
                    <div class="col-12">
                        <div class="critic-reviews" data-aos="fade-up" data-aos-delay="300">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="critic-review">
                                        <div class="review-quote">"</div>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                        <p>Pellentesque in ipsum id orci porta dapibus. Vivamus magna justo, lacinia
                                            eget consectetur sed, convallis at tellus.</p>
                                        <div class="critic-info">
                                            <div class="critic-name">The New York Times</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="critic-review">
                                        <div class="review-quote">"</div>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                        </div>
                                        <p>Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Nulla quis
                                            lorem ut libero malesuada feugiat.</p>
                                        <div class="critic-info">
                                            <div class="critic-name">Washington Post</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="critic-review">
                                        <div class="review-quote">"</div>
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                        <p>Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vivamus suscipit
                                            tortor eget felis porttitor volutpat.</p>
                                        <div class="critic-info">
                                            <div class="critic-name">The Guardian</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="testimonials-container">
                            <div class="swiper testimonials-slider init-swiper" data-aos="fade-up" data-aos-delay="400">
                                <script type="application/json" class="swiper-config">
                  {
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                      "delay": 5000
                    },
                    "slidesPerView": 1,
                    "spaceBetween": 30,
                    "pagination": {
                      "el": ".swiper-pagination",
                      "type": "bullets",
                      "clickable": true
                    },
                    "breakpoints": {
                      "768": {
                        "slidesPerView": 2
                      },
                      "992": {
                        "slidesPerView": 3
                      }
                    }
                  }
                </script>

                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <p>
                                                Proin eget tortor risus. Vestibulum ac diam sit amet quam vehicula
                                                elementum sed sit amet dui. Nulla quis lorem ut libero malesuada
                                                feugiat.
                                            </p>
                                            <div class="testimonial-profile">
                                                <img src="assets/img/person/person-f-1.webp" alt="Reviewer"
                                                    class="img-fluid rounded-circle">
                                                <div>
                                                    <h3>Jane Smith</h3>
                                                    <h4>Book Enthusiast</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End testimonial item -->

                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <p>
                                                Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Cras
                                                ultricies ligula sed magna dictum porta. Vestibulum ante ipsum primis in
                                                faucibus orci luctus.
                                            </p>
                                            <div class="testimonial-profile">
                                                <img src="assets/img/person/person-m-2.webp" alt="Reviewer"
                                                    class="img-fluid rounded-circle">
                                                <div>
                                                    <h3>Michael Johnson</h3>
                                                    <h4>Sci-Fi Blogger</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End testimonial item -->

                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </div>
                                            <p>
                                                Quisque velit nisi, pretium ut lacinia in, elementum id enim. Cras
                                                ultricies ligula sed magna dictum porta. Donec sollicitudin molestie
                                                malesuada.
                                            </p>
                                            <div class="testimonial-profile">
                                                <img src="assets/img/person/person-f-3.webp" alt="Reviewer"
                                                    class="img-fluid rounded-circle">
                                                <div>
                                                    <h3>Emily Davis</h3>
                                                    <h4>Book Club President</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End testimonial item -->

                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <p>
                                                Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur
                                                aliquet quam id dui posuere blandit. Lorem ipsum dolor sit amet,
                                                consectetur adipiscing elit.
                                            </p>
                                            <div class="testimonial-profile">
                                                <img src="assets/img/person/person-m-4.webp" alt="Reviewer"
                                                    class="img-fluid rounded-circle">
                                                <div>
                                                    <h3>Robert Wilson</h3>
                                                    <h4>Literary Reviewer</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End testimonial item -->

                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center" data-aos="fade-up">
                        <div class="overall-rating">
                            <div class="rating-number">4.8</div>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <p>Based on 230+ reviews</p>
                            <div class="rating-platforms">
                                <span>Goodreads</span>
                                <span>Amazon</span>
                                <span>Barnes &amp; Noble</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Testimonials Section -->
        <!-- Faq Section -->
        <section class="faq-9 faq light-background" id="faq">

            <div class="container">
                <div class="row">

                    <div class="col-lg-5" data-aos="fade-up">
                        <h2 class="faq-title">Have a question? Check out the F.A.Q.</h2>
                        <p class="faq-description">Maecenas tempus tellus eget condimentum rhoncus sem quam semper
                            libero sit amet adipiscing sem neque sed ipsum.</p>
                        <div class="faq-arrow d-none d-lg-block" data-aos="fade-up" data-aos-delay="200">
                            <svg class="faq-arrow" width="200" height="211" viewBox="0 0 200 211" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M198.804 194.488C189.279 189.596 179.529 185.52 169.407 182.07L169.384 182.049C169.227 181.994 169.07 181.939 168.912 181.884C166.669 181.139 165.906 184.546 167.669 185.615C174.053 189.473 182.761 191.837 189.146 195.695C156.603 195.912 119.781 196.591 91.266 179.049C62.5221 161.368 48.1094 130.695 56.934 98.891C84.5539 98.7247 112.556 84.0176 129.508 62.667C136.396 53.9724 146.193 35.1448 129.773 30.2717C114.292 25.6624 93.7109 41.8875 83.1971 51.3147C70.1109 63.039 59.63 78.433 54.2039 95.0087C52.1221 94.9842 50.0776 94.8683 48.0703 94.6608C30.1803 92.8027 11.2197 83.6338 5.44902 65.1074C-1.88449 41.5699 14.4994 19.0183 27.9202 1.56641C28.6411 0.625793 27.2862 -0.561638 26.5419 0.358501C13.4588 16.4098 -0.221091 34.5242 0.896608 56.5659C1.8218 74.6941 14.221 87.9401 30.4121 94.2058C37.7076 97.0203 45.3454 98.5003 53.0334 98.8449C47.8679 117.532 49.2961 137.487 60.7729 155.283C87.7615 197.081 139.616 201.147 184.786 201.155L174.332 206.827C172.119 208.033 174.345 211.287 176.537 210.105C182.06 207.125 187.582 204.122 193.084 201.144C193.346 201.147 195.161 199.887 195.423 199.868C197.08 198.548 193.084 201.144 195.528 199.81C196.688 199.192 197.846 198.552 199.006 197.935C200.397 197.167 200.007 195.087 198.804 194.488ZM60.8213 88.0427C67.6894 72.648 78.8538 59.1566 92.1207 49.0388C98.8475 43.9065 106.334 39.2953 114.188 36.1439C117.295 34.8947 120.798 33.6609 124.168 33.635C134.365 33.5511 136.354 42.9911 132.638 51.031C120.47 77.4222 86.8639 93.9837 58.0983 94.9666C58.8971 92.6666 59.783 90.3603 60.8213 88.0427Z"
                                    fill="currentColor"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="col-lg-7" data-aos="fade-up" data-aos-delay="300">
                        <div class="faq-container">

                            <div class="faq-item faq-active">
                                <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                                <div class="faq-content">
                                    <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus
                                        laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor
                                        rhoncus dolor purus non.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Feugiat scelerisque varius morbi enim nunc faucibus?</h3>
                                <div class="faq-content">
                                    <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                        interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus
                                        scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim.
                                        Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                                <div class="faq-content">
                                    <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci.
                                        Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl
                                        suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis
                                        convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                                <div class="faq-content">
                                    <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                        interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus
                                        scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim.
                                        Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Tempus quam pellentesque nec nam aliquam sem et tortor?</h3>
                                <div class="faq-content">
                                    <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse
                                        in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl
                                        suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Perspiciatis quod quo quos nulla quo illum ullam?</h3>
                                <div class="faq-content">
                                    <p>Enim ea facilis quaerat voluptas quidem et dolorem. Quis et consequatur non sed
                                        in suscipit sequi. Distinctio ipsam dolore et.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>
                    </div>

                </div>
            </div>
        </section><!-- /Faq Section -->


        <!-- Call To Action Section -->
        <section id="call-to-action" class="call-to-action">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="cta-wrapper" data-aos="zoom-in" data-aos-delay="200">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="cta-book-image">
                                        <img src="assets/img/book/book-3.webp" alt="Book Cover" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="cta-content">
                                        <span class="badge">Limited Time Offer</span>
                                        <h2>Start Your Journey Today</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna justo,
                                            lacinia eget consectetur sed, convallis at tellus. Order now and get
                                            exclusive bonus content and 25% off.</p>

                                        <div class="cta-features">
                                            <div class="feature-item">
                                                <i class="bi bi-gift"></i>
                                                <span>Exclusive Digital Extras</span>
                                            </div>
                                            <div class="feature-item">
                                                <i class="bi bi-currency-dollar"></i>
                                                <span>Money-Back Guarantee</span>
                                            </div>
                                            <div class="feature-item">
                                                <i class="bi bi-truck"></i>
                                                <span>Free Shipping</span>
                                            </div>
                                        </div>

                                        <div class="countdown-timer">
                                            <p>Offer ends in:</p>
                                            <div class="countdown d-flex justify-content-center" data-count="2025/12/3">
                                                <div>
                                                    <h3 class="count-days"></h3>
                                                    <h4>Days</h4>
                                                </div>
                                                <div>
                                                    <h3 class="count-hours"></h3>
                                                    <h4>Hours</h4>
                                                </div>
                                                <div>
                                                    <h3 class="count-minutes"></h3>
                                                    <h4>Minutes</h4>
                                                </div>
                                                <div>
                                                    <h3 class="count-seconds"></h3>
                                                    <h4>Seconds</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Call To Action Section -->

        <?php include_once "contact.php" ?>
    </main>
    <?php include_once "includes/footer.php" ?>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>