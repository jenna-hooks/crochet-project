<?php
session_start();
include 'db_connect.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Update Shipping Status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 14px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #d76e4b;
            color: white;
        }

        select, button {
            padding: 5px 8px;
            border-radius: 4px;
            border: 1px solid #999;
        }

        button {
            background: #27ae60;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #1e8449;
        }
    </style>
</head>
<body>

<h2><i class="fa-solid fa-truck-fast"></i> Manage Shipping Status</h2>

<table>
    <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Total</th>
        <th>Current Status</th>
        <th>Update Status</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['order_id'] ?></td>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td>ksh<?= number_format($row['total_price'], 2) ?></td>
            <td><?= htmlspecialchars($row['shipping_status']) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                    <select name="shipping_status">
                        <?php
                        $statuses = ['warehouse', 'packed', 'in transit', 'pickup station', 'signed'];
                        foreach ($statuses as $status) {
                            $selected = ($status === $row['shipping_status']) ? 'selected' : '';
                            echo "<option value='$status' $selected>" . ucfirst($status) . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
