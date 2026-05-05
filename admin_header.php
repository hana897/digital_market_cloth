<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>
<aside class="w-64 bg-white shadow min-h-screen p-6 fixed">
    <h1 class="font-display text-2xl font-bold text-amber-600 mb-6">Admin Panel</h1>
    <nav class="space-y-2 text-sm">
        <a href="admin.php" class="block px-4 py-2 rounded hover:bg-gray-100">Dashboard</a>
        <a href="admin_products.php" class="block px-4 py-2 rounded hover:bg-gray-100">Products</a>
        <a href="admin_orders.php" class="block px-4 py-2 rounded hover:bg-gray-100">Orders</a>
        <a href="admin_users.php" class="block px-4 py-2 rounded hover:bg-gray-100">Users</a>
        <a href="logout.php" class="block px-4 py-2 rounded text-red-600 hover:bg-red-50">Logout</a>
    </nav>
</aside>
<div class="ml-64 p-6">
<!-- Main content goes here -->





