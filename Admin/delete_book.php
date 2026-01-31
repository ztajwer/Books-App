<?php
include_once "db.php";
$idtobedeleted = $_GET["index"];
$bookimagedata = mysqli_query($con, "Select book_image from books where book_id = $idtobedeleted");
$bookimagedata = mysqli_fetch_assoc($bookimagedata);
$filepath = "../bookimages/" . $bookimagedata["book_image"];

if (file_exists($filepath)) {
    unlink($filepath);
    $query = mysqli_query($con, "Delete from books where book_id = $idtobedeleted");
    if ($query) {
        echo "<script>alert('Book Deleted Success'); window.location.href = 'show_book.php'</script>";
    } else {
        echo "<script>alert('Book Deleted Error'); window.location.href = 'show_book.php'</script>";
    }
} else {
    echo "<script>alert('File Image Doesnot Exist'); window.location.href = 'show_book.php'</script>";
}
?>