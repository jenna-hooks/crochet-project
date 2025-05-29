<?php
include 'db_connect.php';
session_start();

// Ensure admin is logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

// Handle stock status update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'], $_POST['stock_status'])) {
    $product_id = intval($_POST['product_id']);
    $new_status = $_POST['stock_status'] === 'in_stock' ? 'out_of_stock' : 'in_stock';

    $stmt = $conn->prepare("UPDATE products SET stock_status = ? WHERE product_id = ?");
    $stmt->bind_param("si", $new_status, $product_id);
    $stmt->execute();
}

// Fetch products with stock status
$result = $conn->query("SELECT product_id, name, price, stock_status FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Stock Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background: #f7f7f7;
        }

        h2 {
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 16px;
            border: 1px solid #ccc;
        }

        th {
            background: #f0f0f0;
        }

        .btn-toggle {
            background: #3498db;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-toggle:hover {
            background: #2980b9;
        }

        .in-stock {
            color: green;
            font-weight: bold;
        }

        .out-of-stock {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Manage Product Stock Status</h2>

<table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Price (Ksh)</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= number_format($row['price'], 2) ?></td>
            <td class="<?= $row['stock_status'] === 'in_stock' ? 'in-stock' : 'out-of-stock' ?>">
                <?= $row['stock_status'] === 'in_stock' ? 'In Stock' : 'Out of Stock' ?>
            </td>
            <td>
                <form method="POST">
                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                    <input type="hidden" name="stock_status" value="<?= $row['stock_status'] ?>">
                    <button type="submit" class="btn-toggle">
                        Set <?= $row['stock_status'] === 'in_stock' ? 'Out of Stock' : 'In Stock' ?>
                    </button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
