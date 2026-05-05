<?php
try {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Users Table
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        name TEXT,
        email TEXT NOT NULL UNIQUE,
        password_hash TEXT NOT NULL,
        user_type TEXT DEFAULT 'user',
        balance REAL DEFAULT 0.00,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 2. Products Table (using product_off name to match code)
    $db->exec("CREATE TABLE IF NOT EXISTS product_off (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category_id INTEGER,
        name TEXT NOT NULL,
        description TEXT,
        short_description TEXT,
        material TEXT,
        price REAL NOT NULL,
        sku TEXT UNIQUE,
        stock_quantity INTEGER DEFAULT 0,
        images TEXT, -- JSON string
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 3. Cart Items
    $db->exec("CREATE TABLE IF NOT EXISTS cart_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        product_id INTEGER NOT NULL,
        quantity INTEGER NOT NULL DEFAULT 1,
        added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE(user_id, product_id)
    )");

    // 4. Custom Orders
    $db->exec("CREATE TABLE IF NOT EXISTS custom_orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        customer_id INTEGER,
        product_type TEXT,
        status TEXT,
        estimated_price REAL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Populate Products if empty
    $stmt = $db->query("SELECT COUNT(*) FROM product_off");
    if ($stmt->fetchColumn() == 0) {
        $products = [
            [
                'name' => 'Classic Habesha Kemis',
                'price' => 285.00,
                'images' => json_encode(['images/image1.webp']),
                'short_description' => 'Elegant white cotton dress with traditional tibeb embroidery',
                'description' => 'This Classic Habesha Kemis is a masterpiece of Ethiopian craftsmanship...', 
                'category_id' => 1
            ],
            [
                'name' => 'Handwoven Netela',
                'price' => 125.00,
                'images' => json_encode(['images/image3.webp']),
                'short_description' => 'Traditional cotton shawl with colorful embroidered edges',
                'description' => 'The Netela is an essential part of Ethiopian attire...', 
                'category_id' => 2
            ],
            [
                'name' => 'Contemporary Habesha',
                'price' => 340.00,
                'images' => json_encode(['images/images4.jpg']),
                'short_description' => 'Modern interpretation with traditional elements',
                'description' => 'A stunning fusion of modern design and traditional Ethiopian aesthetics...', 
                'category_id' => 1
            ],
            [
                'name' => 'Artisan Collection',
                'price' => 450.00,
                'images' => json_encode(['images/images5.jpg']),
                'short_description' => 'Premium pieces from master weavers',
                'description' => 'From our exclusive Artisan Collection, this garment represents the pinnacle...', 
                'category_id' => 3
            ]
        ];

        $insert = $db->prepare("INSERT INTO product_off (name, price, images, short_description, description, category_id) VALUES (:name, :price, :images, :short_description, :description, :category_id)");
        foreach ($products as $p) {
            $insert->execute($p);
        }
        echo "Inserted initial products.\n";
    }

    echo "SQLite database setup complete.\n";

} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>
