<?php
session_start();
require_once 'database/db.php';
$pdo = get_db_connection();

$identifier = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($identifier === '') $errors[] = 'Please enter your username or email.';
    if ($password === '') $errors[] = 'Please enter your password.';

    if (empty($errors)) {
        // Query by username OR email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :id OR email = :id LIMIT 1");
        $stmt->execute([':id' => $identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];

            // Redirect logic
            $redirect = $_GET['redirect'] ?? ($user['user_type'] === 'admin' ? 'admin.php' : 'products.php');
            header("Location: " . $redirect);
            exit;
        } else {
            $errors[] = 'Invalid username/email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Ethiopian Heritage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row">
        
        <!-- Image Section -->
        <div class="hidden lg:block lg:w-1/2 relative">
            <img src="images/images5.jpg" alt="Ethiopian Cloth" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40 flex items-end p-8">
                <div class="text-white">
                    <h2 class="font-display text-3xl font-bold mb-2">Welcome Back</h2>
                    <p class="text-white/90 text-sm">Log in to access your collection and continue your journey.</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="w-full lg:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="text-center mb-8">
                <h1 class="font-display text-3xl font-bold text-gray-900">Login</h1>
                <p class="text-sm text-gray-500 mt-2">New here? <a href="signup.php" class="text-amber-600 font-semibold hover:underline">Create an account</a></p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                    <ul class="list-disc pl-5">
                        <?php foreach($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username or Email</label>
                    <input type="text" name="identifier" value="<?= htmlspecialchars($identifier) ?>" class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition bg-gray-50 focus:bg-white" placeholder="Enter username or email" required>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="forgot_password.php" class="text-xs text-amber-600 hover:text-amber-700 font-medium">Forgot Password?</a>
                    </div>
                    <input type="password" name="password" class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition bg-gray-50 focus:bg-white" placeholder="Enter password" required>
                </div>

                <button type="submit" class="w-full bg-amber-600 text-white font-bold py-3 rounded-xl hover:bg-amber-700 transition transform active:scale-95 shadow-lg">
                    Log In
                </button>
            </form>
            
            <div class="mt-8 text-center">
                <a href="index.php" class="text-xs text-gray-400 hover:text-gray-600">Back to Home</a>
            </div>
        </div>
    </div>

</body>
</html>