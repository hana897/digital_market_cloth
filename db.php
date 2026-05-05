<?php
function get_db_connection() {
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

function initialize_database() {
    $db = get_db_connection();
    $db->exec("CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        price REAL NOT NULL,
        image TEXT NOT NULL,
        description TEXT,
        category TEXT
    )");

    // Add sample data if the table is empty
    $stmt = $db->query("SELECT COUNT(*) FROM products");
    if ($stmt->fetchColumn() == 0) {
        $products = [
            ['name' => 'Classic Habesha Kemis', 'price' => 285.00, 'image' => 'https://kimi-web-img.moonshot.cn/img/i.pinimg.com/972bdd66c32abe31961e4c4bc849adf2bce4c262.jpg', 'description' => 'Elegant white cotton dress with traditional tibeb embroidery.', 'category' => 'habesha-kemis'],
            ['name' => 'Handwoven Netela', 'price' => 125.00, 'image' => 'https://kimi-web-img.moonshot.cn/img/i.pinimg.com/119f8329ffae58818048bc3e6832fefee9c9b625.jpg', 'description' => 'Traditional cotton shawl with colorful embroidered edges.', 'category' => 'netela'],
            ['name' => 'Contemporary Habesha', 'price' => 340.00, 'image' => 'https://kimi-web-img.moonshot.cn/img/www.ethiopian.store/26ba4f011011cf6ab2f1c27998a0ef3a387234ab.jpg', 'description' => 'Modern interpretation with traditional elements.', 'category' => 'habesha-kemis'],
            ['name' => 'Artisan Gabi', 'price' => 180.00, 'image' => 'https://kimi-web-img.moonshot.cn/img/albiongould.com/b1e0796bc264ae69310f07ae42741d817100c478.jpg', 'description' => 'A thick, handwoven cotton blanket for warmth and comfort.', 'category' => 'gabi'],
            ['name' => 'Beaded Necklace', 'price' => 65.00, 'image' => 'https://kimi-web-img.moonshot.cn/img/i.pinimg.com/5b8f04c6af701047602330a5508a8a3a2468e219.jpg', 'description' => 'Handcrafted beaded necklace with traditional Ethiopian colors.', 'category' => 'accessories'],
            ['name' => 'Embroidered Scarf', 'price' => 85.00, 'image' => 'https://kimi-web-img.moonshot.cn/img/i.pinimg.com/20b6164227f2a40e11894a434d6159f8164d1f56.jpg', 'description' => 'A beautiful scarf with intricate Ethiopian embroidery.', 'category' => 'accessories'],
        ];

        $stmt = $db->prepare("INSERT INTO products (name, price, image, description, category) VALUES (:name, :price, :image, :description, :category)");
        foreach ($products as $product) {
            $stmt->execute($product);
        }
    }
}

initialize_database();
?>