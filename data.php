<?php
require_once __DIR__ . '/database/db.php';

// Initial hardcoded products
$products = [
    1 => [
        'id' => 1,
        'name' => 'Classic Habesha Kemis',
        'price' => 8500.00,
        'image' => 'images/image1.webp',
        'short_desc' => 'Elegant white cotton dress with traditional tibeb embroidery',
        'long_desc' => 'This Classic Habesha Kemis is a masterpiece of Ethiopian craftsmanship. Made from pure, handwoven cotton, it feels soft and breathable against the skin. The dress features intricate "tibeb" embroidery along the neckline, cuffs, and hem, showcasing patterns that have been passed down through generations. Perfect for weddings, holidays, and cultural celebrations, this dress is a timeless symbol of elegance and heritage.',
        'category' => 'habesha-kemis',
        'region' => 'New'
    ],
    2 => [
        'id' => 2,
        'name' => 'Handwoven Netela',
        'price' => 6200.00,
        'image' => 'images/image3.webp',
        'short_desc' => 'Traditional cotton shawl with colorful embroidered edges',
        'long_desc' => 'The Netela is an essential part of Ethiopian attire. This beautiful shawl is handwoven from fine cotton, making it lightweight and versatile. It is adorned with a colorful "tibeb" border, adding a touch of vibrancy. It can be draped in various styles for different occasions, from casual outings to formal events.',
        'category' => 'netela',
        'region' => 'New'
    ],
    3 => [
        'id' => 3,
        'name' => 'Contemporary Habesha',
        'price' => 12500.00,
        'image' => 'images/images4.jpg',
        'short_desc' => 'Modern interpretation with traditional elements',
        'long_desc' => 'A stunning fusion of modern design and traditional Ethiopian aesthetics. This contemporary Habesha dress features a sleek, modern silhouette while incorporating classic "tibeb" patterns. It\'s the perfect choice for those who appreciate heritage but desire a modern look. Made with a blend of cotton and silk for a luxurious feel.',
        'category' => 'habesha-kemis',
        'region' => 'New'
    ],
    4 => [
        'id' => 4,
        'name' => 'Artisan Collection',
        'price' => 14800.00,
        'image' => 'images/images5.jpg',
        'short_desc' => 'Premium pieces from master weavers',
        'long_desc' => 'From our exclusive Artisan Collection, this garment represents the pinnacle of Ethiopian weaving. Crafted by a master artisan, it features exceptionally detailed embroidery and the highest quality hand-spun cotton ("dor"). This is more than a dress; it\'s a collectible piece of wearable art that celebrates the deep-rooted skills of Ethiopian weavers.',
        'category' => 'gabi',
        'region' => 'New'
    ],
];

// Map category IDs to slugs used in filters
$categoryMap = [
    1 => 'habesha-kemis',
    2 => 'netela',
    3 => 'gabi',
    4 => 'accessories'
];

// Fetch products from database
try {
    $db = get_db_connection();
    $stmt = $db->query("SELECT * FROM product_off ORDER BY id DESC");
    
    $dbProducts = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Decode images JSON
        $images = json_decode($row['images'], true);
        $imagePath = !empty($images) ? $images[0] : 'images/placeholder.jpg';
        
        // Determine category
        $catId = $row['category_id'] ?? 0;
        $category = $categoryMap[$catId] ?? 'custom';

        // Map DB fields to array structure
        // Use ID as key to preserve uniqueness if needed, or just append
        $dbProducts[$row['id']] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => (float)$row['price'],
            'image' => $imagePath,
            'short_desc' => $row['short_description'] ?? substr($row['description'] ?? '', 0, 100) . '...',
            'long_desc' => $row['description'] ?? '',
            'category' => $category, 
            'region' => 'New'
        ];
    }

    // If database has products, use them instead of hardcoded ones to ensure sync
    if (!empty($dbProducts)) {
        $products = $dbProducts;
    }

} catch (PDOException $e) {
    // Fail silently or log error, so the site still works with hardcoded data
    error_log("Failed to fetch products from DB: " . $e->getMessage());
}
?>