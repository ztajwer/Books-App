<?php
session_start();
include_once("config.php");

if (isset($_GET['id'])) {
    $bookid = $_GET['id'];

    $query = mysqli_query($conn, "SELECT books.*, category.category_name
        FROM books
        JOIN category ON books.book_category = category.category_id
        WHERE books.book_id = $bookid");

    $product = mysqli_fetch_assoc($query);

    if (!isset($_SESSION['books'])) {
        $_SESSION['books'] = [];
    }

    $_SESSION['books'][] = [
        "id"       => $product['book_id'],
        "name"     => $product['book_name'],
        "price"    => $product['book_price'],
        "image"    => $product['book_image'],
        "category" => $product['category_name']
    ];
}

// Redirect back to product page
header("Location: cart.php?index=$bookid");
exit;
?>
