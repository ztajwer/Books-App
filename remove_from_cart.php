<?php
session_start();

// Check if item ID is provided
if (isset($_GET['id']) && isset($_SESSION['books'])) {
    $id = $_GET['id'];

    // Loop through cart and remove the matching item
    foreach ($_SESSION['books'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['books'][$key]);
            break; // stop after removing
        }
    }

    // Re-index array after removal
    $_SESSION['books'] = array_values($_SESSION['books']);
}

// Redirect back to cart page
header("Location: cart.php");
exit;
?>
