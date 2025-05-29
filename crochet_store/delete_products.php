<?php
include 'db_connect.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

// Handle product deletion
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        $message = "✅ Product deleted successfully.";
    } else {
        $message = "❌ Error deleting product: " . $conn->error;
    }
}

// Fetch all products
$result = $conn->query("SELECT product_id, name, price FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Product</title>
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

        form {
            display: inline;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .message {
            margin-bottom: 20px;
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Delete Crochet Product</h2>

<?php if (isset($message)) echo "<div class='message'>$message</div>"; ?>

<table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Price (Ksh)</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= number_format($row['price'], 2) ?></td>
            <td>
                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                    <button type="submit" class="btn-delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
