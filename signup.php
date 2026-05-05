<?php
session_start();
require_once 'database/db.php';
$pdo = get_db_connection();

$errors = [];
$username = '';
$email = '';
$user_type = 'user';
$password = '';
$password2 = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    $user_type = ($_POST['user_type'] ?? 'user') === 'admin' ? 'admin' : 'user';

    // Validation
    if ($username === '') $errors[] = 'Username is required.';
    elseif (strlen($username) < 3) $errors[] = 'Username must be at least 3 characters.';

    if ($email === '') $errors[] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';

    if ($password === '') $errors[] = 'Password is required.';
    else {
        // Simplified password requirements for better UX
        if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters long.';
    }

    if ($password2 === '') $errors[] = 'Please confirm your password.';
    elseif ($password !== $password2) $errors[] = 'Passwords do not match.';

    // Database insert
    if (empty($errors)) {
        // Check existence
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->execute([':username'=>$username, ':email'=>$email]);

        if ($stmt->fetch()) {
            $errors[] = 'Username or email already exists.';
        } else {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO users (username, name, email, password_hash, user_type)
                    VALUES (:username, :name, :email, :password_hash, :user_type)
                ");
                $stmt->execute([
                    ':username'      => $username,
                    ':name'          => $username,
                    ':email'         => $email,
                    ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
                    ':user_type'     => $user_type
                ]);

                // Auto-login after signup
                $userId = $pdo->lastInsertId();
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $username;
                $_SESSION['user_type'] = $user_type;

                if ($user_type === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: products.php");
                }
                exit;

            } catch (PDOException $e) {
                $errors[] = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Ethiopian Heritage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
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
                    <h2 class="font-display text-3xl font-bold mb-2">Join the Heritage</h2>
                    <p class="text-white/90 text-sm">Create an account to explore and preserve Ethiopian culture through fashion.</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="w-full lg:w-1/2 p-8 md:p-12">
            <div class="text-center mb-8">
                <h1 class="font-display text-3xl font-bold text-gray-900">Create Account</h1>
                <p class="text-sm text-gray-500 mt-2">Already have an account? <a href="login.php" class="text-amber-600 font-semibold hover:underline">Log in</a></p>
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

            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition" placeholder="Choose a username" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition" placeholder="you@example.com" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Account Type</label>
                    <select name="user_type" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition bg-white">
                        <option value="user" <?= $user_type==='user'?'selected':'' ?>>User (Shopper)</option>
                        <option value="admin" <?= $user_type==='admin'?'selected':'' ?>>Admin (Seller)</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition" placeholder="Min 6 chars" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="password2" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition" placeholder="Re-enter" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-amber-600 text-white font-bold py-3 rounded-xl hover:bg-amber-700 transition transform active:scale-95 shadow-lg mt-2">
                    Sign Up
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <a href="index.php" class="text-xs text-gray-400 hover:text-gray-600">Back to Home</a>
            </div>
        </div>
    </div>

</body>
</html>
