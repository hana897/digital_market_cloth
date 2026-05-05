<?php
require_once __DIR__ . '/db.php';

try {
    $pdo = get_db_connection();

    // Categories table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            description TEXT,
            slug TEXT UNIQUE,
            parent_id INTEGER DEFAULT NULL,
            FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
        )
    ");

    // Products table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS product_off (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            category_id INTEGER NOT NULL,
            name TEXT NOT NULL,
            description TEXT,
            short_description TEXT,
            material TEXT,
            price REAL NOT NULL,
            sku TEXT UNIQUE,
            stock_quantity INTEGER DEFAULT 0,
            images TEXT, -- JSON stored as text
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
        )
    ");

    // Insert categories safely
    $categories = [
        ['Hābesha Kemis', 'Traditional Ethiopian/Eritrean dress', 'habesha-kemis'],
        ['Netela Shawls', 'Traditional cotton shawls', 'netela-shawls'],
        ['Gabi Blankets', 'Handwoven blankets', 'gabi-blankets'],
        ['Accessories', 'Traditional jewelry', 'accessories']
    ];

    $stmt = $pdo->prepare("INSERT OR IGNORE INTO categories (name, description, slug) VALUES (?, ?, ?)");
    foreach ($categories as $cat) {
        $stmt->execute($cat);
    }

    echo "Database and tables created successfully!";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
