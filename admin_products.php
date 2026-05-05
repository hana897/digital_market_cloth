<?php
require_once __DIR__ . '/database/db.php';

$db = get_db_connection();

/* ================= DELETE PRODUCT ================= */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM product_off WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin_products.php");
    exit;
}

/* ================= ADD PRODUCT ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'] ?? 1;

    // ✅ FIXED SKU
    $skuInput = trim($_POST['sku'] ?? '');
    $sku = $skuInput !== '' ? $skuInput : uniqid('SKU_');

    $stock = $_POST['stock'] ?? 0;

    /* Upload directory */
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    /* Validate image */
    if (!empty($_FILES['image']['name'])) {

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            die('Invalid image type');
        }

        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;
        $dbPath = 'uploads/' . $fileName;

        move_uploaded_file($_FILES['image']['tmp_name'], $filePath);

        $images_json = json_encode([$dbPath]);

        $stmt = $db->prepare("
            INSERT INTO product_off (category_id, name, price, sku, stock_quantity, images)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $category_id,
            $name,
            $price,
            $sku,
            $stock,
            $images_json
        ]);
    }
}

/* ================= FETCH PRODUCTS ================= */
$products = $db->query("SELECT * FROM product_off ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Products</title>

<style>
body {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    margin: 0;
    padding: 20px;
}
h2 {
    color: #111827;
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 20px;
    position: relative;
}
h2::after {
    content: "";
    display: block;
    width: 70px;
    height: 4px;
    background: linear-gradient(90deg, #2563eb, #4f46e5);
    margin-top: 8px;
    border-radius: 999px;
}

/* Form Styling */
form {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}
form input, form button {
    font-size: 14px;
}
form button {
    cursor: pointer;
}

/* Table Container */
.bg-white {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    padding: 20px;
}

/* Table Styling */
table {
    border-collapse: collapse;
    width: 100%;
}
thead tr {
    background: linear-gradient(90deg, #2563eb, #4f46e5);
}
thead th {
    color: #ffffff;
    font-weight: 600;
    padding: 12px;
    text-transform: uppercase;
    font-size: 12px;
}
tbody tr {
    transition: background-color 0.2s ease;
}
tbody tr:hover {
    background-color: #f9fafb;
}
td {
    padding: 12px;
    vertical-align: middle;
    color: #374151;
}

/* Product Image: FIXED SIZE */
td img {
    height: 60px;       /* fixed height */
    width: 60px;        /* fixed width */
    object-fit: contain; /* preserves aspect ratio */
    border-radius: 6px;
}

/* Action Link */
a {
    text-decoration: none;
    transition: color 0.2s ease;
}
a:hover {
    color: #b91c1c;
}

/* Responsive Table */
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }
    thead tr {
        display: none;
    }
    tbody tr {
        margin-bottom: 15px;
        background: #ffffff;
        padding: 10px;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    }
    tbody td {
        display: flex;
        justify-content: space-between;
        padding: 10px 14px;
    }
}
</style>

</head>
<body>

<h2>Manage Products</h2>

<!-- Add Product Form -->
<form method="POST" enctype="multipart/form-data">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="name" placeholder="Product Name" class="border rounded px-3 py-2" required>
        <input type="number" step="0.01" name="price" placeholder="Price" class="border rounded px-3 py-2" required>
        <input type="file" name="image" class="border rounded px-3 py-2" required>
    </div>
    <input type="text" name="sku" placeholder="SKU (optional)" class="border rounded px-3 py-2 mt-2">
    <input type="number" name="stock" placeholder="Stock quantity" class="border rounded px-3 py-2 mt-2">
    <button class="bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded mt-2">
        Add Product
    </button>
</form>

<!-- Products Table -->
<div class="bg-white shadow rounded p-6">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b">
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>SKU</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($p = $products->fetch(PDO::FETCH_ASSOC)):
            $images = json_decode($p['images'], true);
            $firstImage = $images[0] ?? 'placeholder.jpg';
        ?>
            <tr class="border-b hover:bg-gray-50">
                <td>
                    <img src="<?= htmlspecialchars($firstImage) ?>">
                </td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td>ETB <?= number_format($p['price'], 2) ?></td>
                <td><?= htmlspecialchars($p['sku']) ?></td>
                <td><?= $p['stock_quantity'] ?></td>
                <td>
                    <a href="?delete=<?= $p['id'] ?>"
                       onclick="return confirm('Delete this product?')"
                       class="text-red-600 hover:underline">
                       Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
