<?php
include_once("db.php");
$idtobedeleted = $_GET["index"];

// Delete all books in this category first
mysqli_query($con, "DELETE FROM books WHERE book_category = $idtobedeleted");

// Now delete the category
$res = mysqli_query($con, "DELETE FROM category WHERE category_id = $idtobedeleted");

if ($res) {
    echo "<script>
            alert('Category and its books deleted successfully');
            window.location.href='show_category.php';
          </script>";
} else {
    echo "<script>
            alert('Something went wrong');
            window.location.href='show_category.php';
          </script>";
}
?>
