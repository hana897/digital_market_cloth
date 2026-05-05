<?php
session_start();
require 'database/new product.php'; // Make sure this file returns get_db_connection() function

// Connect to database
$db = get_db_connection(); // Correct variable name

// Get product ID
$productId = $_GET['id'] ?? null;
if (!$productId) {
    header('Location: index.php');
    exit;
}

// Fetch product from database
$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: index.php');
    exit;
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $quantity = (int)$_POST['quantity'];
    if ($quantity > 0) {
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + $quantity;
    }
    header('Location: cart.php');
    exit;
}

// Decode images JSON
$images = json_decode($product['images'], true);
$firstImage = $images[0] ?? 'placeholder.jpg';
?>
