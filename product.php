<?php
session_start();
require 'data.php';

$productId = $_GET['id'] ?? null;
if (!$productId || !isset($products[$productId])) { header('Location: index.php'); exit; }
$product = $products[$productId];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = (int)$_POST['quantity'];
    if ($quantity > 0) {
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + $quantity;
        if (isset($_POST['buy_now'])) {
            if (!isset($_SESSION['user_id'])) { header('Location: login.php?redirect=checkout.php'); } else { header('Location: checkout.php'); }
            exit;
        } else { header('Location: cart.php'); exit; }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> - Ethiopian Heritage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style> @import url('style.css'); body { font-family: 'Inter', sans-serif; } .font-display { font-family: 'Playfair Display', serif; } </style>
</head>
<body class="bg-gray-50 transition-colors duration-300 pt-20">
    <?php include 'header.php'; ?>
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8 text-sm text-gray-500 glass p-4 rounded-xl inline-flex backdrop-blur-sm">
            <a href="index.php" class="hover:text-[--terracotta] transition-colors"><?= __('home') ?></a>
            <span class="mx-3 text-gray-300">/</span>
            <a href="products.php" class="hover:text-[--terracotta] transition-colors"><?= __('products') ?></a>
            <span class="mx-3 text-gray-300">/</span>
            <span class="text-[--text-color] font-medium"><?= htmlspecialchars($product['name']) ?></span>
        </nav>

        <div class="grid md:grid-cols-2 gap-12 items-start mb-24">
            <div class="glass p-2 rounded-[2.5rem] shadow-2xl overflow-hidden relative group">
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-auto object-cover rounded-[2rem] transform group-hover:scale-105 transition-transform duration-700">
            </div>
            <div class="glass p-8 md:p-12 rounded-[2.5rem] shadow-xl space-y-8 sticky top-24">
                <div>
                    <h1 class="font-display text-4xl lg:text-5xl font-bold text-[--text-color] mb-2"><?= htmlspecialchars($product['name']) ?></h1>
                    <p class="text-sm font-bold text-[--terracotta] tracking-widest uppercase opacity-80"><?= htmlspecialchars($product['category']) ?></p>
                </div>
                <div class="flex items-center justify-between border-b border-[--border-color] pb-8">
                    <p class="text-5xl font-bold text-[--text-color] tracking-tight">ETB <?= number_format($product['price']) ?></p>
                    <div class="flex flex-col items-end">
                        <div class="flex items-center gap-2 mb-1"><div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div><span class="text-xs font-bold text-green-600 uppercase tracking-wider"><?= __('in_stock') ?></span></div>
                        <span class="text-[10px] text-gray-400 uppercase tracking-widest"><?= __('ships_worldwide') ?></span>
                    </div>
                </div>
                <div class="prose prose-lg text-gray-500 leading-relaxed"><p><?= nl2br(htmlspecialchars($product['long_desc'])) ?></p></div>
                <form method="POST" class="space-y-8 pt-4">
                    <div class="flex items-center gap-6">
                        <label class="font-bold text-[--text-color] uppercase tracking-wider text-xs"><?= __('quantity') ?></label>
                        <div class="flex items-center border-2 border-[--border-color] rounded-2xl overflow-hidden">
                            <button type="button" onclick="document.getElementById('quantity').stepDown()" class="px-5 py-3 hover:bg-[--border-color] transition text-xl font-bold">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" class="w-16 text-center border-none focus:ring-0 p-2 bg-transparent font-bold text-lg" readonly>
                            <button type="button" onclick="document.getElementById('quantity').stepUp()" class="px-5 py-3 hover:bg-[--border-color] transition text-xl font-bold">+</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button type="submit" name="add_to_cart" class="flex items-center justify-center gap-3 px-8 py-5 border-2 border-[--terracotta] text-[--terracotta] font-bold rounded-2xl hover:bg-[--terracotta] hover:text-white transition-all transform active:scale-95 text-sm uppercase tracking-wider"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg><?= __('add_to_cart') ?></button>
                        <button type="submit" name="buy_now" class="btn-primary px-8 py-5 rounded-2xl font-bold text-sm uppercase tracking-wider shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all active:scale-95"><?= __('buy_now') ?></button>
                    </div>
                </form>
                <div class="grid grid-cols-2 gap-6 pt-8 border-t border-[--border-color]">
                    <div class="flex items-center gap-3 opacity-70"><svg class="w-6 h-6 text-[--terracotta]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span class="text-xs font-bold uppercase tracking-wider"><?= __('auth_quality') ?></span></div>
                    <div class="flex items-center gap-3 opacity-70"><svg class="w-6 h-6 text-[--terracotta]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg><span class="text-xs font-bold uppercase tracking-wider"><?= __('secure_payment') ?></span></div>
                </div>
            </div>
        </div>
        <div class="glass p-10 rounded-[3rem]">
            <h2 class="font-display text-3xl font-bold mb-8 text-center text-[--text-color]"><?= __('also_like') ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php $related = array_filter($products, fn($p) => $p['id'] != $productId); shuffle($related); $related = array_slice($related, 0, 3); foreach($related as $rel): ?>
                <a href="product.php?id=<?= $rel['id'] ?>" class="group block">
                    <div class="glass rounded-3xl overflow-hidden mb-4 relative aspect-[4/5]"><img src="<?= htmlspecialchars($rel['image']) ?>" alt="<?= htmlspecialchars($rel['name']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></div>
                    <h3 class="font-bold text-lg text-[--text-color] group-hover:text-[--terracotta] transition-colors text-center"><?= htmlspecialchars($rel['name']) ?></h3>
                    <p class="text-[--terracotta] font-bold text-center mt-1">ETB <?= number_format($rel['price']) ?></p>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>