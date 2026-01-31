<?php
include_once("includes/header.php");
include_once("config.php");
$bookid = $_GET["index"];
$productquery = mysqli_query($conn, "SELECT books.*, category.category_name
FROM books
JOIN category ON books.book_category = category.category_id
WHERE books.book_id = $bookid
");
$product = mysqli_fetch_assoc($productquery);

// Related 

$category_id = $product['book_category'];

$relatedQuery = mysqli_query($conn, "
    SELECT books.book_id, books.book_name, books.book_image
    FROM books
    WHERE books.book_category = $category_id AND books.book_id != $bookid
    LIMIT 6
");
?>
<br><br>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Detail Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <style>
        body {
            background: #fdfdfdff;
            color: #000000ff;
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
        }

        /* ================= MAIN DETAIL CARD ================= */
        .detail-card {
            max-width: 1200px;
            margin: 50px auto 30px auto;
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            box-shadow: 0 0 35px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 40px;
        }

        .detail-card img {
            max-width: 400px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(255, 102, 0, 0.6);
        }

        .detail-info {
            flex: 1;
            min-width: 300px;
        }

        .detail-info h2 {
            color: #ff6600;
            margin-bottom: 15px;
            font-size: 2rem;
        }

        .detail-info .category {
            font-size: 16px;
            font-weight: 600;
            color: #ffa766;
            margin-bottom: 10px;
        }

        .detail-info .price {
            font-size: 28px;
            font-weight: bold;
            margin: 15px 0;
        }

        .detail-info p {
            line-height: 1.7;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .detail-actions a {
            display: inline-block;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 35px;
            margin-right: 15px;
            font-weight: 600;
            transition: 0.3s;
            font-size: 16px;
        }

        .btn-buy {
            background: linear-gradient(45deg, #ff6600, #ff8c33);
            color: #fff;
        }

        .btn-buy:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 15px rgba(255, 102, 0, 0.7);
        }

        .btn-details {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .btn-details:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* ================= BOOK DESCRIPTION ================= */
        .book-description {
            max-width: 1200px;
            margin: 30px auto;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        }

        .book-description h3 {
            color: #ff6600;
            margin-bottom: 15px;
        }

        .book-description p {
            font-size: 16px;
            line-height: 1.8;
        }

        /* ================= AUTHOR INFO ================= */
        .author-card {
            max-width: 1200px;
            margin: 30px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
        }

        .author-card img {
            width: 150px;
            border-radius: 50%;
            box-shadow: 0 0 15px rgba(255, 102, 0, 0.5);
        }

        .author-info {
            flex: 1;
        }

        .author-info h4 {
            color: #ffa766;
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .author-info p {
            line-height: 1.7;
        }

        /* ================= REVIEWS ================= */
        .reviews-card {
            max-width: 1200px;
            margin: 30px auto;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        }

        .review-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 0;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-item h5 {
            color: #ffa766;
            margin-bottom: 5px;
        }

        .review-item p {
            line-height: 1.6;
            font-size: 15px;
        }

        .related-books {
            max-width: 1200px;
            margin: 30px auto;
        }

        .related-books h3 {
            color: #ff6600;
            margin-bottom: 25px;
            font-size: 1.8rem;
            text-align: center;
        }

        .related-books-container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }

        .related-book-card {
            background: rgba(255, 102, 0, 0.05);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            overflow: hidden;
            width: 180px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(255, 102, 0, 0.3);
            transition: all 0.3s ease;
            position: relative;
        }

        .related-book-card:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 15px 40px rgba(255, 102, 0, 0.5);
        }

        .related-book-card a {
            color: #fff;
            text-decoration: none;
        }

        .related-book-card .book-image {
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 102, 0, 0.2);
        }

        .related-book-card .book-image img {
            width: 100%;
            display: block;
            border-radius: 15px 15px 0 0;
            transition: transform 0.4s ease;
        }

        .related-book-card:hover .book-image img {
            transform: scale(1.1) rotate(-1deg);
        }

        .related-book-card h6 {
            font-size: 14px;
            margin: 10px 0 15px 0;
            color: #ffa766;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .related-book-card:hover h6 {
            color: #ffcc66;
        }

        /* Responsive */
        @media(max-width: 992px) {
            .detail-card {
                flex-direction: column;
                align-items: center;
            }

            .author-card {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <!-- ================= MAIN DETAIL ================= -->
    <div class="detail-card">
        <img src="bookimages/<?php echo $product["book_image"] ?>" alt="Book Cover">
        <div class="detail-info">
            <h2><?php echo $product["book_name"] ?></h2>
            <div class="category">Category: <?php echo $product["category_name"] ?></div>
            <div class="price">$<?php echo $product["book_price"] ?></div>
            <p>
                <?php echo $product["book_desc"] ?>
            </p>
            <div class="detail-actions">
                <a href="add_to_cart.php?id=<?php echo $product["book_id"];?>" class="btn btn-buy btn-sm">Add To Cart</a>
            </div>
        </div>
    </div>

    <!-- ================= BOOK DESCRIPTION ================= -->
    <div class="book-description">
        <h3>About the Book</h3>
        <p>
            <?php echo $product["book_desc"] ?>
        </p>
        <h3 class="small">
            Category: <?php echo $product["category_name"] ?>
        </h3>
    </div>

    <!-- ================= AUTHOR INFO ================= -->
    <div class="author-card">
        <img src="https://cdn.britannica.com/51/12251-050-D5F09630/Arthur-Conan-Doyle-detail-portrait-HL-Gates-1927.jpg"
            alt="Author">
        <div class="author-info">
            <h4>Author: Sir Arthur Conan Doyle</h4>
            <p>
                Sir Arthur Conan Doyle was a British writer best known for creating the character Sherlock Holmes.
                He was also a physician and a prolific writer of historical novels, science fiction, plays, and poetry.
            </p>
        </div>
    </div>

    <!-- ================= REVIEWS ================= -->
    <div class="reviews-card">
        <h3>Reader Reviews</h3>
        <div class="review-item">
            <h5>John Doe <i class="bi bi-star-fill" style="color:#ffcc00;"></i><i class="bi bi-star-fill"
                    style="color:#ffcc00;"></i><i class="bi bi-star-fill" style="color:#ffcc00;"></i><i
                    class="bi bi-star-fill" style="color:#ffcc00;"></i><i class="bi bi-star-fill"
                    style="color:#ffcc00;"></i></h5>
            <p>A masterpiece! Every detective story enthusiast must read this collection.</p>
        </div>
        <div class="review-item">
            <h5>Jane Smith <i class="bi bi-star-fill" style="color:#ffcc00;"></i><i class="bi bi-star-fill"
                    style="color:#ffcc00;"></i><i class="bi bi-star-fill" style="color:#ffcc00;"></i><i
                    class="bi bi-star-fill" style="color:#ffcc00;"></i></h5>
            <p>Intriguing plots, clever deductions, and unforgettable characters. Highly recommend!</p>
        </div>
    </div>

    <!-- ================= RELATED BOOKS ================= -->
    <div class="related-books">
        <h3>Related Books</h3>
        <div class="row g-4">
            <?php while ($related = mysqli_fetch_assoc($relatedQuery)) { ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card related-card h-100 text-center">
                        <a href="book-detail.php?index=<?php echo $related['book_id']; ?>">
                            <img src="bookimages/<?php echo $related['book_image']; ?>" class="card-img-top"
                                alt="<?php echo $related['book_name']; ?>">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $related['book_name']; ?></h6>
                            </div>
                        </a>
                        <div class="card-footer">
                            <a href="details.php?index=<?php echo $related['book_id']; ?>"
                                class="btn btn-buy btn-sm">View Details</a>
                            <a href="add_to_cart.php?index=<?php echo $related['book_id']; ?>" class="btn btn-buy btn-sm">Add To Cart</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include_once("includes/footer.php"); ?>