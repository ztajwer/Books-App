<?php include_once("includes/header.php");?>

<?php
include_once("config.php");

// Get search query from URL or form
$search = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

$booksdata = [];
if ($search != '') {
    $query = "
    SELECT books.*, category.category_name 
    FROM books 
    INNER JOIN category ON books.book_category = category.category_id
    WHERE books.book_name LIKE '%$search%' 
       OR category.category_name LIKE '%$search%'
";

    $booksdata = mysqli_query($conn, $query);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #ff6600;
            /* Orange theme */
        }

        .search-bar {
            text-align: center;
            margin-bottom: 40px;
        }

        .search-bar input[type="text"] {
            width: 60%;
            padding: 10px 15px;
            font-size: 16px;
            border: 2px solid #ff6600;
            border-radius: 5px;
        }

        .search-bar button {
            padding: 10px 20px;
            background: #ff6600;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-left: 10px;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
        }

        .book-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .book-card:hover {
            transform: translateY(-5px);
        }

        .book-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .book-card .content {
            padding: 15px;
        }

        .book-card h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .book-card p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #777;
        }

        .no-results {
            text-align: center;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<br><br><br><br>
<body>
    <div class="container">
        <h1>Search Results for "<?php echo htmlspecialchars($search); ?>"</h1>

        <div class="search-bar">
            <form action="" method="GET">
                <input type="text" name="q" placeholder="Search books, authors, categories..."
                    value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php if ($booksdata && mysqli_num_rows($booksdata) > 0): ?>
            <div class="book-grid">
                <?php while ($book = mysqli_fetch_assoc($booksdata)): ?>
                    <div class="book-card">
                        <img src="admin/bookimages/<?php echo $book['book_image']; ?>"
                            alt="<?php echo htmlspecialchars($book['book_name']); ?>">
                        <div class="content">
                            <h3><?php echo htmlspecialchars($book['book_name']); ?></h3>
                            <p>Category: <?php echo htmlspecialchars($book['category_name']); ?></p>
                            <p><a href="details.php?index=<?php echo $book['book_id']; ?>" style="color:#ff6600;">View
                                    Details</a></p>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="no-results">No books found matching your search.</p>
        <?php endif; ?>
    </div>

</body>

</html>
