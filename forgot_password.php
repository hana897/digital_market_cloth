<?php
session_start();
require_once __DIR__ . '/database/db.php';

$step = 1;
$error = '';
$success = '';
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = get_db_connection();

    if (isset($_POST['verify_user'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);

        $stmt = $db->prepare("SELECT id FROM users WHERE username = ? AND email = ?");
        $stmt->execute([$username, $email]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['reset_user_id'] = $user['id'];
            $step = 2;
        } else {
            $error = "No account found with that username and email.";
        }
    } elseif (isset($_POST['reset_password'])) {
        $step = 2; // Stay on step 2 if error
        $pass1 = $_POST['password'];
        $pass2 = $_POST['confirm_password'];

        if ($pass1 !== $pass2) {
            $error = "Passwords do not match.";
        } elseif (strlen($pass1) < 4) {
            $error = "Password must be at least 4 characters.";
        } else {
            $userId = $_SESSION['reset_user_id'] ?? null;
            if ($userId) {
                $hash = password_hash($pass1, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $stmt->execute([$hash, $userId]);
                
                unset($_SESSION['reset_user_id']);
                $success = "Password successfully reset. You can now login.";
                $step = 3;
            } else {
                $error = "Session expired. Please start over.";
                $step = 1;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Ethiopian Heritage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-slate-100 px-8 py-10">
        <div class="text-center mb-8">
            <h1 class="font-display text-3xl font-bold text-slate-900 mb-2">Account Recovery</h1>
            <p class="text-sm text-slate-500">Reset your password to regain access.</p>
        </div>

        <?php if ($error): ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                <?= htmlspecialchars($success) ?>
            </div>
            <a href="login.php" class="block w-full text-center bg-amber-500 text-white font-semibold py-3 rounded-xl hover:bg-amber-600 transition">
                Go to Login
            </a>
        <?php elseif ($step === 1): ?>
            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Username</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-amber-400 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-amber-400 outline-none" required>
                </div>
                <button type="submit" name="verify_user" class="w-full bg-amber-500 text-white font-semibold py-3 rounded-xl hover:bg-amber-600 transition shadow-md">
                    Verify Account
                </button>
            </form>
            <div class="text-center mt-6">
                <a href="login.php" class="text-sm text-slate-500 hover:text-amber-600">Cancel and Return to Login</a>
            </div>

        <?php elseif ($step === 2): ?>
            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">New Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-amber-400 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-amber-400 outline-none" required>
                </div>
                <button type="submit" name="reset_password" class="w-full bg-amber-500 text-white font-semibold py-3 rounded-xl hover:bg-amber-600 transition shadow-md">
                    Reset Password
                </button>
            </form>
        <?php endif; ?>
    </div>

</body>
</html>