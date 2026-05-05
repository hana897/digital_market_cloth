<?php
require_once __DIR__ . '/db.php';

try {
    $pdo = get_db_connection();
    $db_status = true;

    // 2️⃣ Create users table if it doesn't exist (SQLite compatible)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            user_type TEXT DEFAULT 'user', -- ENUM not supported in SQLite, use TEXT
            balance REAL DEFAULT 0.00,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $table_status = true;

} catch (PDOException $e) {
    die("❌ Database setup failed: " . $e->getMessage());
}

// ================= OPTIONAL STATUS OUTPUT =================
if (basename($_SERVER['PHP_SELF']) === 'login table.php') {
    echo "<div style='font-family:Arial;font-size:12px;text-align:center;margin-top:20px'>";
    echo $db_status
        ? "✅ Database connected<br>"
        : "❌ Database connection failed<br>";

    echo $table_status
        ? "✅ Users table ready"
        : "❌ Users table error";
    echo "</div>";
}
?>
