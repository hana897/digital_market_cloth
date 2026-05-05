<?php
session_start();

/* ===== SECURITY CHECK ===== */
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once 'database/db.php';
$db = get_db_connection();

/* ===== DELETE PRODUCT ===== */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM product_off WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php"); // Stay on dashboard
    exit;
}

/* ===== ADD PRODUCT ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $desc  = $_POST['description'];
    $cat_id = 1; // Default category for now

    // Image upload
    $imageName = $_FILES['image']['name'];
    $tmpName   = $_FILES['image']['tmp_name'];
    $path = "uploads/" . time() . "_" . $imageName;
    
    // Ensure uploads dir exists
    if (!is_dir('uploads')) mkdir('uploads');
    
    move_uploaded_file($tmpName, $path);

    // Store as JSON array
    $imagesJson = json_encode([$path]);

    $stmt = $db->prepare(
        "INSERT INTO product_off (category_id, name, price, description, images) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([$cat_id, $name, $price, $desc, $imagesJson]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow hidden md:block">
        <div class="p-6 border-b">
            <h1 class="font-display text-2xl font-bold text-amber-600">Admin Panel</h1>
        </div>
        <nav class="p-4 space-y-2 text-sm">
            <a href="admin.php" class="block px-4 py-2 rounded bg-amber-100 text-amber-700 font-semibold">Dashboard</a>
            <a href="logout.php" class="block px-4 py-2 rounded text-red-600 hover:bg-red-50">Logout</a>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-6">

        <h2 class="font-display text-3xl font-bold mb-6">Manage Products</h2>

        <!-- ADD PRODUCT -->
        <div class="bg-white rounded-2xl shadow p-6 mb-8">
            <h3 class="font-semibold mb-4">Add New Product</h3>
            <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="name" placeholder="Product name" class="border rounded px-3 py-2" required>
                <input type="number" step="0.01" name="price" placeholder="Price" class="border rounded px-3 py-2" required>
                <input type="file" name="image" class="border rounded px-3 py-2" required>
                <input type="text" name="description" placeholder="Description" class="border rounded px-3 py-2" required>
                <button class="md:col-span-4 bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg">
                    Add Product
                </button>
            </form>
        </div>

        <!-- PRODUCT LIST -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-semibold mb-4">Product List</h3>

            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $products = $db->query("SELECT * FROM product_off ORDER BY id DESC");
                while ($p = $products->fetch(PDO::FETCH_ASSOC)):
                    $images = json_decode($p['images'], true);
                    $img = $images[0] ?? 'images/placeholder.jpg';
                ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">
                            <img src="<?= htmlspecialchars($img) ?>" class="h-12 w-12 object-cover rounded">
                        </td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td>ETB <?= number_format($p['price'],2) ?></td>
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

    </main>
</div>

</body>
</html>
