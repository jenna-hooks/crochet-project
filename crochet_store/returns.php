<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Update return status if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_id'], $_POST['status'])) {
    $return_id = intval($_POST['return_id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE returns SET status = ? WHERE return_id = ?");
    $stmt->bind_param("si", $status, $return_id);
    $stmt->execute();
}

// Fetch returns
$returns = $conn->query("
    SELECT r.*, p.name AS product_name
    FROM returns r
    JOIN products p ON r.product_id = p.product_id
    ORDER BY r.return_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Returns</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
            background-color: #f7f5f0;
        }

        h2 {
            color: #a63c3c;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #a63c3c;
            color: #fff;
        }

        form select, form button {
            padding: 6px 10px;
            margin: 0;
            border-radius: 6px;
        }

        form button {
            background: #27ae60;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background: #219150;
        }
    </style>
</head>
<body>

<h2><i class="fa-solid fa-rotate-left"></i> Manage Product Returns</h2>

<table>
    <tr>
        <th>Return ID</th>
        <th>Order ID</th>
        <th>Product</th>
        <th>Reason</th>
        <th>Status</th>
        <th>Update Status</th>
        <th>Return Date</th>
    </tr>
    <?php while ($row = $returns->fetch_assoc()): ?>
        <tr>
            <td><?= $row['return_id']; ?></td>
            <td><?= $row['order_id']; ?></td>
            <td><?= htmlspecialchars($row['product_name']); ?></td>
            <td><?= htmlspecialchars($row['reason']); ?></td>
            <td><?= $row['status']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="return_id" value="<?= $row['return_id']; ?>">
                    <select name="status">
                        <option <?= $row['status'] == 'Requested' ? 'selected' : '' ?>>Requested</option>
                        <option <?= $row['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                        <option <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                        <option <?= $row['status'] == 'Refunded' ? 'selected' : '' ?>>Refunded</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
            <td><?= $row['return_date']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
