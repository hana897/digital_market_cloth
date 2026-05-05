<?php
session_start();
require 'data.php'; // $products array and db connection
require 'database/cart_items.php'; // DB connection

// Handle cart updates (remove or change quantity)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Remove item
    if (isset($_POST['remove_item'])) {
        $productId = $_POST['product_id'];
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }
    // Update quantity
    if (isset($_POST['update_quantity'])) {
        $productId = $_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        if ($quantity > 0) {
            $_SESSION['cart'][$productId] = $quantity;
        } else {
            unset($_SESSION['cart'][$productId]);
        }
    }
    header('Location: cart.php');
    exit;
}

$cartItems = $_SESSION['cart'] ?? [];
$cartTotal = 0;
foreach ($cartItems as $productId => $quantity) {
    if (!isset($products[$productId])) continue;
    $cartTotal += $products[$productId]['price'] * $quantity;
}

$title = "Your Shopping Cart - Ethiopian Heritage";
include 'header.php';
?>

<div class="min-h-screen pt-24 pb-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="font-display text-4xl lg:text-5xl font-bold text-center mb-12 cultural-gradient">Your Shopping Cart</h1>

        <?php if (empty($cartItems)): ?>
            <div class="text-center py-24 glass rounded-[3rem] max-w-2xl mx-auto">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <p class="text-2xl text-gray-500 mb-8 font-light">Your cart is currently empty.</p>
                <a href="products.php" class="btn-primary px-8 py-4 rounded-2xl font-bold text-lg shadow-xl hover:-translate-y-1 transition-transform inline-block">
                    Start Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items List -->
                <div class="lg:col-span-2 space-y-6">
                    <?php foreach ($cartItems as $productId => $quantity):
                        if (!isset($products[$productId])) continue;
                        $product = $products[$productId];
                        $itemTotal = $product['price'] * $quantity;
                    ?>
                    <div class="glass p-4 rounded-3xl flex flex-col sm:flex-row items-center gap-6 group hover:shadow-lg transition-all duration-300">
                        <a href="product.php?id=<?= $productId ?>" class="shrink-0">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-32 h-32 object-cover rounded-2xl shadow-md group-hover:scale-105 transition-transform">
                        </a>
                        
                        <div class="flex-grow text-center sm:text-left w-full">
                            <div class="flex justify-between items-start mb-2">
                                <a href="product.php?id=<?= $productId ?>">
                                    <h3 class="font-display text-xl font-bold text-[--text-color] hover:text-[--terracotta] transition-colors"><?= htmlspecialchars($product['name']) ?></h3>
                                </a>
                                <form method="post" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?= $productId ?>">
                                    <button type="submit" name="remove_item" class="text-gray-400 hover:text-red-500 transition-colors p-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-4">
                                <div class="flex items-center border border-[--border-color] rounded-xl overflow-hidden">
                                    <form method="post" action="cart.php" class="contents">
                                        <input type="hidden" name="product_id" value="<?= $productId ?>">
                                        <input type="hidden" name="update_quantity" value="true">
                                        <button type="submit" name="quantity" value="<?= $quantity - 1 ?>" class="px-3 py-1 hover:bg-[--bg-color] transition text-gray-500 font-bold">-</button>
                                        <span class="px-3 py-1 font-bold text-[--text-color] border-x border-[--border-color] min-w-[3rem] text-center block"><?= $quantity ?></span>
                                        <button type="submit" name="quantity" value="<?= $quantity + 1 ?>" class="px-3 py-1 hover:bg-[--bg-color] transition text-gray-500 font-bold">+</button>
                                    </form>
                                </div>
                                <p class="text-xl font-bold text-[--text-color]">ETB <?= number_format($itemTotal, 2) ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Cart Summary -->
                <div class="lg:col-span-1">
                    <div class="glass p-8 rounded-[2.5rem] sticky top-24">
                        <h2 class="font-display text-2xl font-bold mb-6 text-[--text-color]">Order Summary</h2>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal</span>
                                <span>ETB <?= number_format($cartTotal, 2) ?></span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Shipping</span>
                                <span class="text-green-600 font-medium">Free</span>
                            </div>
                            <div class="border-t border-[--border-color] pt-4 flex justify-between items-center">
                                <span class="font-bold text-lg text-[--text-color]">Total</span>
                                <span class="font-bold text-2xl text-[--terracotta]">ETB <?= number_format($cartTotal, 2) ?></span>
                            </div>
                        </div>

                        <a href="checkout.php" class="btn-primary w-full py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all block text-center flex items-center justify-center gap-2">
                            <span>Proceed to Checkout</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        
                        <div class="mt-6 flex items-center justify-center gap-4 opacity-50">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Telebirr_Logo.svg/1200px-Telebirr_Logo.svg.png" class="h-6 grayscale">
                            <div class="h-6 w-10 bg-gray-300 rounded flex items-center justify-center text-[10px] font-bold text-gray-600">VISA</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>