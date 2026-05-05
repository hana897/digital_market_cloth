<?php
require_once __DIR__ . '/database/db.php';
include 'admin_header.php';
$db = get_db_connection();

$users = $db->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users</title>

<style>
/* Page background */
body {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Page title */
h2 {
    color: #111827;
    letter-spacing: -0.025em;
    position: relative;
}

h2::after {
    content: "";
    display: block;
    width: 70px;
    height: 4px;
    background: linear-gradient(90deg, #2563eb, #4f46e5);
    margin-top: 10px;
    border-radius: 999px;
}

/* Card container */
.bg-white {
    background: #ffffff;
    border-radius: 16px;
    box-shadow:
        0 10px 25px rgba(0, 0, 0, 0.08),
        0 4px 10px rgba(0, 0, 0, 0.04);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.bg-white:hover {
    transform: translateY(-2px);
    box-shadow:
        0 16px 35px rgba(0, 0, 0, 0.12),
        0 6px 15px rgba(0, 0, 0, 0.06);
}

/* Table */
table {
    border-collapse: collapse;
    width: 100%;
}

/* Table header */
thead tr {
    background: linear-gradient(90deg, #2563eb, #4f46e5);
}

thead th {
    color: #ffffff;
    font-weight: 600;
    padding: 14px 12px;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.08em;
}

/* Table rows */
tbody tr {
    transition: background-color 0.2s ease;
}

tbody tr:hover {
    background-color: #f9fafb;
}

/* Table cells */
td {
    padding: 14px 12px;
    color: #374151;
    vertical-align: middle;
}

/* ID column */
td:first-child {
    font-weight: 600;
    color: #111827;
}

/* User type column */
td:nth-child(4) {
    font-weight: 600;
    text-transform: capitalize;
    color: #2563eb;
}

/* Borders */
tr.border-b {
    border-bottom: 1px solid #e5e7eb;
}

/* Responsive */
@media (max-width: 768px) {
    table {
        font-size: 13px;
    }

    thead {
        display: none;
    }

    tbody tr {
        display: block;
        margin-bottom: 15px;
        border-radius: 12px;
        background: #ffffff;
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

<h2 class="font-display text-3xl font-bold mb-6">Manage Users</h2>

<div class="bg-white shadow rounded p-6">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b">
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($u = $users->fetch(PDO::FETCH_ASSOC)): ?>
            <tr class="border-b hover:bg-gray-50">
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['user_type']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
