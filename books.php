<?php
include_once("config.php");
include_once("includes/header.php");

// get categories
$categorydata = mysqli_query($conn, "SELECT * FROM category");

// get filter values
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// build SQL
$query = "
    SELECT * FROM books 
    INNER JOIN category ON books.book_category = category.category_id
    WHERE 1
";

if ($search != "") {
    $query .= " AND books.book_name LIKE '%$search%' ";
}

if ($category != "") {
    $query .= " AND books.book_category = '$category' ";
}

if ($sort == "az") {
    $query .= " ORDER BY books.book_name ASC";
} elseif ($sort == "za") {
    $query .= " ORDER BY books.book_name DESC";
} elseif ($sort == "price_low") {
    $query .= " ORDER BY books.book_price ASC";
} elseif ($sort == "price_high") {
    $query .= " ORDER BY books.book_price DESC";
}

$booksdata = mysqli_query($conn, $query);
?>
<br><br>

<!-- FILTER & BOOKS -->
<section class="page-section" style="padding:50px 8%;">

    <!-- FILTER BAR -->
    <form class="filter-box" method="GET"
        style="background:white;padding:18px;display:flex;gap:12px;align-items:center;border:2px solid #ffb67a;border-radius:10px;margin-bottom:25px;flex-wrap:wrap;">
        <input type="text" name="search" placeholder="🔍 Search books..." value="<?php echo $search ?>"
            style="padding:11px;border-radius:7px;border:1px solid #ff9a4b;flex:1;">

        <select name="category" style="padding:11px;border-radius:7px;border:1px solid #ff9a4b;">
            <option value="">All Categories</option>
            <?php foreach ($categorydata as $cat): ?>
                <option value="<?php echo $cat["category_id"]; ?>" <?php if ($category == $cat["category_id"])
                       echo "selected"; ?>>
                    <?php echo $cat["category_name"]; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="sort" style="padding:11px;border-radius:7px;border:1px solid #ff9a4b;">
            <option value="">Sort by</option>
            <option value="az" <?php if ($sort == "az")
                echo "selected"; ?>>A → Z</option>
            <option value="za" <?php if ($sort == "za")
                echo "selected"; ?>>Z → A</option>
            <option value="price_low" <?php if ($sort == "price_low")
                echo "selected"; ?>>Price: Low → High</option>
            <option value="price_high" <?php if ($sort == "price_high")
                echo "selected"; ?>>Price: High → Low</option>
        </select>

        <button type="submit" class="filter-btn"
            style="background:#ff7a00;color:white;padding:11px 16px;border:none;border-radius:7px;">Apply</button>
    </form>

    <!-- BOOK GRID -->
    <div class="book-container" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(270px,1fr));gap:35px;">
        <?php
        if (mysqli_num_rows($booksdata) == 0) {
            echo "<div class='no-result' style='font-size:24px;color:#888;text-align:center;padding:70px 0;width:100%'>❗ No Books Found — Try different filters</div>";
        } else {
            foreach ($booksdata as $books):
                $descWords = explode(' ', $books["book_desc"]);
                $shortDesc = count($descWords) > 20 ? implode(' ', array_slice($descWords, 0, 20)) . '...' : $books["book_desc"];
                ?>
                <div class="book-card"
                    style="background:white;border-radius:14px;padding:14px;box-shadow:0 6px 25px rgba(255,122,0,0.14);transition:0.28s;">
                    <img src="bookimages/<?php echo $books["book_image"]; ?>"
                        style="width:100%;height:260px;border-radius:12px;object-fit:cover;">
                    <h3 style="color:#ff7a00;margin:12px 0;font-size:20px;"><?php echo $books["book_name"]; ?></h3>
                    <small><?php echo $books["category_name"]; ?></small>
                    <p><?php echo $shortDesc; ?></p>
                    <div class="book-price" style="font-weight:bold;color:#ff7a00;font-size:19px;margin-top:10px;">
                        $<?php echo $books["book_price"]; ?></div>
                    <a class="btn-orange" href="details.php?index=<?php echo $books["book_id"]; ?>"
                        style="background:#ff7a00;padding:5px 10px;display:inline-block;border-radius:7px;color:white;text-decoration:none;margin-top:10px;">View
                        Details</a>
                    <a href="add_to_cart.php?id=<?php echo $books['book_id']; ?>" class="cart"
                        style="background:transparent;padding:4px 8px;border: 2px solid #ff7a00;display:inline-block;border-radius:7px;color:orange;text-decoration:none;margin-top:10px;">Add
                        to Cart</a>
                    <?php if (!empty($books['book_pdf'])): ?>
                        <a class="btn-orange" href="bookpdfs/<?php echo $books['book_pdf']; ?>" download
                            style="background:#ff7a00;padding:5px 10px;display:inline-block;border-radius:7px;color:white;text-decoration:none;margin-top:10px;">Download
                            PDF</a>
                    <?php endif; ?>
                </div>
            <?php endforeach;
        } ?>
    </div>

</section>

<?php include_once("includes/footer.php"); ?>