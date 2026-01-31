<?php
session_start();
include_once "../config.php";

// ─────────────────────────────
// VALIDATE USER ID
// ─────────────────────────────
if (!isset($_GET['index'])) {
    $_SESSION['msg'] = "No user selected!";
    header("Location: show_users.php");
    exit;
}

$user_id = intval($_GET['index']); // safer

// ─────────────────────────────
// CHECK IF USER EXISTS
// ─────────────────────────────
$checkUser = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");

if (mysqli_num_rows($checkUser) == 0) {
    $_SESSION['msg'] = "User does not exist!";
    header("Location: show_users.php");
    exit;
}

$user = mysqli_fetch_assoc($checkUser);
$user_image = $user['user_image']; // column name must match your DB

// ─────────────────────────────
// DELETE IMAGE FROM FOLDER
// ─────────────────────────────
if (!empty($user_image)) {
    $imagePath = "forms/useruploads/" . $user_image;

    if (file_exists($imagePath)) {
        unlink($imagePath);  // delete image file
    }
}

// ─────────────────────────────
// DELETE USER RECORD
// ─────────────────────────────
$delete = mysqli_query($conn, "DELETE FROM users WHERE user_id = $user_id");

if ($delete) {
    $_SESSION['msg'] = "User deleted successfully!";
} else {
    $_SESSION['msg'] = "Failed to delete user!";
}

header("Location: show_users.php");
exit;

?>
