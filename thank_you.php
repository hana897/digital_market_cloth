<?php
$title = "Thank You - Ethiopian Heritage";
include 'header.php'; 
?>

<main class="min-h-screen flex flex-col items-center justify-center pt-20 pb-12 px-4 bg-gray-50">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl p-8 md:p-12 text-center transform transition-all hover:scale-105 duration-500">
        
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-8 animate-bounce">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>

        <h1 class="font-display text-4xl font-bold mb-4 cultural-gradient">Thank You!</h1>
        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
            Your order has been placed successfully. We are preparing your authentic pieces with care.
        </p>
        
        <div class="space-y-4">
            <a href="products.php" class="block w-full bg-[--terracotta] text-white font-bold py-3 px-8 rounded-xl hover:opacity-90 transition shadow-lg">
                Continue Shopping
            </a>
            <a href="index.php" class="block w-full bg-white border border-gray-200 text-gray-700 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition">
                Back to Home
            </a>
        </div>
        
        <p class="mt-8 text-sm text-gray-400">Order confirmation has been sent to your email.</p>
    </div>
</main>

<?php include 'footer.php'; ?>
