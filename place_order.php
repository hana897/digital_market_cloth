<?php
session_start();

// In a real application, you would process the payment and save the order to the database here.
// For this example, we'll just clear the cart.

$_SESSION['cart'] = [];

header('Location: thank_you.php');
exit();
?>