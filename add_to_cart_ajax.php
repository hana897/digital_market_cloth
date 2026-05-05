<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($quantity > 0) {
        // Initialize cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add or update quantity in cart session
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + $quantity;
    }

    // Return the total number of items in the cart
    $totalItems = array_sum($_SESSION['cart'] ?? []);
    echo json_encode(['success' => true, 'totalItems' => $totalItems]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>