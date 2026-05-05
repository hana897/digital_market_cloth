<?php
session_start();
require 'database/cart_items.php';

$db = get_db_connection();
$user_id = $_SESSION['user_id'] ?? null;

if (!isset($_POST['product_id'])) {
    header("Location: products.php");
    exit;
}

$product_id = (int)$_POST['product_id'];

// ---------- SESSION CART ----------
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]++;
} else {
    $_SESSION['cart'][$product_id] = 1;
}

// ---------- DATABASE CART ----------
if ($user_id) {
    $stmt = $db->prepare("
        SELECT id, quantity 
        FROM cart_items 
        WHERE user_id = ? AND product_id = ?
    ");
    $stmt->execute([$user_id, $product_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        // Update quantity
        $stmt = $db->prepare("
            UPDATE cart_items 
            SET quantity = quantity + 1 
            WHERE id = ?
        ");
        $stmt->execute([$item['id']]);
    } else {
        // Insert new row
        $stmt = $db->prepare("
            INSERT INTO cart_items (user_id, product_id, quantity)
            VALUES (?, ?, 1)
        ");
        $stmt->execute([$user_id, $product_id]);
    }
}

header("Location: cart.php");
exit;