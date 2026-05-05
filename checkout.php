<?php
session_start();
require 'data.php'; 

// 1. Check Login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect=checkout.php');
    exit;
}

$db = get_db_connection();
$userId = $_SESSION['user_id'];

// 2. Fetch User Data
$stmt = $db->prepare("SELECT balance, address, phone, name FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$userBalance = (float)$user['balance'];

// 3. Calculate Total
$cartItems = $_SESSION['cart'] ?? [];
if (empty($cartItems)) {
    header('Location: products.php');
    exit;
}

$cartTotal = 0;
foreach ($cartItems as $productId => $quantity) {
    if (isset($products[$productId])) {
        $cartTotal += $products[$productId]['price'] * $quantity;
    }
}

$message = '';
$error = '';

// 4. Handle Payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (logic remains same as before) ...
    // Capture Shipping Info
    $shippingName = $_POST['shipping_name'] ?? $user['name'];
    $shippingPhone = $_POST['shipping_phone'] ?? $user['phone'];
    $shippingAddress = $_POST['shipping_address'] ?? $user['address'];
    $shippingCity = $_POST['shipping_city'] ?? '';
    
    $fullShippingInfo = "Name: $shippingName, Phone: $shippingPhone, Addr: $shippingAddress, City: $shippingCity";

    try { $upd = $db->prepare("UPDATE users SET phone = ?, address = ? WHERE id = ?"); $upd->execute([$shippingPhone, $shippingAddress, $userId]); } catch (PDOException $e) {}

    if (isset($_POST['pay_balance'])) {
        if ($userBalance >= $cartTotal) {
            try {
                $db->beginTransaction();
                $newBalance = $userBalance - $cartTotal;
                $stmt = $db->prepare("UPDATE users SET balance = ? WHERE id = ?");
                $stmt->execute([$newBalance, $userId]);
                foreach ($cartItems as $productId => $quantity) {
                    if (!isset($products[$productId])) continue;
                    $product = $products[$productId];
                    $itemTotal = $product['price'] * $quantity;
                    $stmt = $db->prepare("INSERT INTO custom_orders (customer_id, product_type, status, estimated_price, shipping_info, created_at) VALUES (?, ?, 'paid', ?, ?, DATETIME('now'))");
                    $stmt->execute([$userId, $product['name'] . " (Qty: $quantity)", $itemTotal, $fullShippingInfo]);
                }
                $db->commit();
                unset($_SESSION['cart']);
                header('Location: thank_you.php');
                exit;
            } catch (Exception $e) {
                $db->rollBack();
                $error = "Transaction failed: " . $e->getMessage();
            }
        } else {
            $error = "Insufficient balance. Please deposit funds or use another method.";
        }
    }

    if (isset($_POST['pay_external'])) {
        foreach ($cartItems as $productId => $quantity) {
            if (!isset($products[$productId])) continue;
            $product = $products[$productId];
            $itemTotal = $product['price'] * $quantity;
            $stmt = $db->prepare("INSERT INTO custom_orders (customer_id, product_type, status, estimated_price, shipping_info, created_at) VALUES (?, ?, 'paid', ?, ?, DATETIME('now'))");
            $stmt->execute([$userId, $product['name'] . " (Qty: $quantity)", $itemTotal, $fullShippingInfo]);
        }
        unset($_SESSION['cart']);
        header('Location: thank_you.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Ethiopian Heritage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        @import url('style.css');
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen pt-20 pb-12">
    <?php include 'header.php'; ?>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-display text-4xl lg:text-5xl font-bold text-center mb-12 cultural-gradient">Secure Checkout</h1>
        
        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl relative mb-8 text-center max-w-2xl mx-auto">
                <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" class="grid lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- LEFT: Shipping & Summary (7/12 width) -->
            <div class="lg:col-span-7 space-y-8">
                <!-- Shipping Info -->
                <div class="glass p-8 rounded-3xl shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/></svg>
                    </div>
                    
                    <h2 class="font-display text-2xl font-bold mb-6 text-[--text-color] border-b border-[--border-color] pb-4">Shipping Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-[--text-color] mb-2">Full Name</label>
                            <input type="text" name="shipping_name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-[--terracotta] transition bg-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[--text-color] mb-2">Phone Number</label>
                            <input type="tel" name="shipping_phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-[--terracotta] transition bg-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[--text-color] mb-2">City</label>
                            <input type="text" name="shipping_city" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-[--terracotta] transition bg-transparent" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-[--text-color] mb-2">Delivery Address</label>
                            <textarea name="shipping_address" rows="3" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-[--terracotta] transition bg-transparent" required><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="glass p-8 rounded-3xl shadow-lg">
                    <h2 class="font-display text-2xl font-bold mb-6 text-[--text-color]">Items in Cart</h2>
                    <div class="space-y-6">
                        <?php foreach ($cartItems as $productId => $quantity): 
                            if (!isset($products[$productId])) continue;
                            $p = $products[$productId];
                        ?>
                        <div class="flex items-center gap-6 p-4 rounded-2xl hover:bg-[--border-color] transition-colors border border-transparent hover:border-[--border-color]">
                            <img src="<?= htmlspecialchars($p['image']) ?>" class="w-20 h-20 object-cover rounded-xl shadow-sm">
                            <div class="flex-grow">
                                <p class="font-bold text-lg text-[--text-color]"><?= htmlspecialchars($p['name']) ?></p>
                                <p class="text-sm text-gray-500">Qty: <?= $quantity ?></p>
                            </div>
                            <p class="font-bold text-lg text-[--terracotta]">ETB <?= number_format($p['price'] * $quantity, 2) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="flex justify-between items-center text-xl font-bold mt-8 pt-6 border-t border-[--border-color]">
                        <span class="text-[--text-color]">Total Amount</span>
                        <span class="text-[--terracotta] text-2xl">ETB <?= number_format($cartTotal, 2) ?></span>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Payment Options (5/12 width) -->
            <div class="lg:col-span-5 space-y-8">
                
                <!-- Wallet Balance -->
                <div class="glass p-8 rounded-3xl shadow-xl border-2 border-[--terracotta] relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-[--terracotta] to-transparent opacity-5 pointer-events-none"></div>
                    
                    <h2 class="font-display text-2xl font-bold mb-2 text-[--text-color]">Wallet Pay</h2>
                    <p class="text-gray-500 mb-6">Fast & secure payment from your balance.</p>
                    
                    <div class="flex flex-col gap-1 mb-8">
                        <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Current Balance</span>
                        <span class="text-4xl font-bold text-[--text-color]">ETB <?= number_format($userBalance, 2) ?></span>
                    </div>

                    <?php if ($userBalance >= $cartTotal): ?>
                        <button type="submit" name="pay_balance" class="w-full btn-primary py-4 px-6 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all transform active:scale-95 flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Confirm Payment
                        </button>
                    <?php else: ?>
                        <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-4 px-6 rounded-xl cursor-not-allowed mb-3 border border-gray-300">
                            Insufficient Balance
                        </button>
                        <a href="settings.php" class="flex items-center justify-center gap-2 w-full py-3 border-2 border-[--terracotta] text-[--terracotta] font-bold rounded-xl hover:bg-[--terracotta] hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Deposit Funds
                        </a>
                        <p class="text-xs text-center text-red-500 mt-2">You need ETB <?= number_format($cartTotal - $userBalance, 2) ?> more.</p>
                    <?php endif; ?>
                </div>

                <!-- External Payment -->
                <div class="glass p-8 rounded-3xl shadow-lg">
                    <h2 class="font-display text-2xl font-bold mb-6 text-[--text-color]">Other Methods</h2>
                    
                    <div class="space-y-4 mb-8">
                        <label class="flex items-center gap-4 p-4 border border-[--border-color] rounded-xl cursor-pointer hover:bg-[--border-color] transition bg-transparent group">
                            <input type="radio" name="payment_method" value="telebirr" class="w-5 h-5 text-[--terracotta] focus:ring-[--terracotta]">
                            <div class="h-8 w-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-[8px] font-black shadow-md">TELE</div>
                            <span class="font-bold text-[--text-color]">Telebirr</span>
                        </label>
                        <label class="flex items-center gap-4 p-4 border border-[--border-color] rounded-xl cursor-pointer hover:bg-[--border-color] transition bg-transparent group">
                            <input type="radio" name="payment_method" value="cbe" class="w-5 h-5 text-[--terracotta] focus:ring-[--terracotta]">
                            <div class="h-8 w-8 bg-purple-700 rounded-full flex items-center justify-center text-white text-[8px] font-black shadow-md">CBE</div>
                            <span class="font-bold text-[--text-color]">CBE Birr</span>
                        </label>
                    </div>
                    
                    <button type="submit" name="pay_external" class="w-full glass border border-[--terracotta] text-[--terracotta] font-bold py-4 px-6 rounded-xl hover:bg-[--terracotta] hover:text-white transition-all transform active:scale-95 shadow-sm">
                        Pay with Selected Method
                    </button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>