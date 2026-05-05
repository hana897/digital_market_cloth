<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - Ethiopian Heritage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        @import url('style.css');
        :root { --terracotta: #C65D07; }
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <div class="container mx-auto mt-24 px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg text-center p-12">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h1 class="font-display text-4xl font-bold mb-4">Thank You!</h1>
            <p class="text-xl text-gray-600 mb-8">Your order has been successfully placed. We have received your payment and your items will be prepared for shipment.</p>
            <a href="index.php" class="btn btn-primary inline-block">
                Continue Shopping
            </a>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    <script src="main.js"></script>
</body>
</html>