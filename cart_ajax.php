<?php
session_start();

if (isset($_POST['id'], $_POST['action'])) {

    foreach ($_SESSION['books'] as &$item) {
        if ($item['id'] == $_POST['id']) {

            if ($_POST['action'] === 'inc') {
                $item['qty']++;
            }

            if ($_POST['action'] === 'dec' && $item['qty'] > 1) {
                $item['qty']--;
            }

            $itemTotal = $item['qty'] * $item['price'];

            // calculate cart total
            $cartTotal = 0;
            foreach ($_SESSION['books'] as $b) {
                $cartTotal += $b['qty'] * $b['price'];
            }

            echo json_encode([
                "qty" => $item['qty'],
                "itemTotal" => $itemTotal,
                "cartTotal" => $cartTotal,
                "cartCount" => array_sum(array_column($_SESSION['books'], 'qty'))

            ]);
            exit;
        }
    }
}

