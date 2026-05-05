<?php
require_once __DIR__ . '/db.php';

// Connect to database
$db = get_db_connection();

// SQL to create cart_items table (SQLite compatible)
$sql = "
CREATE TABLE IF NOT EXISTS cart_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL DEFAULT 1,
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, product_id)
);
";

try {
    $db->exec($sql);
    // echo "Table 'cart_items' created successfully!"; // Silence output to avoid cluttering headers
} catch (PDOException $e) {
    // Fail silently or log, don't die on page load if possible, but for now matching original behavior
    die("Error creating table: " . $e->getMessage());
}
?>
