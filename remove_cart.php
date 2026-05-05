<?php
session_start();
require_once __DIR__ . '/database/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

if (isset($_GET['id'])) {
    $cart_id = (int)$_GET['id'];
    $db = get_db_connection();

    $stmt = $db->prepare("DELETE FROM cart_items WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $cart_id, 'user_id' => $_SESSION['user_id']]);
}

header('Location: cart.php');
exit();
?>
