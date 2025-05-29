<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("images/BG.jpg");
            margin: 0;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background-color: #2471a3 ;
            position: fixed;
            top: 0;
            left: 0;
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 15px 0;
            padding: 10px;
            background: #34495e;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #1abc9c;
        }

        .main {
            margin-left: 260px;
            padding: 30px;
            position: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        iframe {
            width: 100%;
            height: 80vh;
            border: none;
            background-color: rgba(255, 255, 255, 0.30);
            z-index: -1;
            border-radius: 10px;
        }

    </style>
</head>
<body>
<div class="sidebar">
    <h2><i class="fa-solid fa-tools"></i> Admin Panel</h2>
    <a href="add_products.php" target="main_frame"><i class="fa fa-plus-circle"></i> Add Product</a>
        <a href="delete_products.php" target="main_frame"><i class="fa fa-undo"></i> delete products </a>
    <a href="products.php" target="main_frame"><i class="fa fa-undo"></i> products</a>
    <a href="stock_status.php" target="main_frame"><i class="fa fa-box"></i>Stock Status</a>
    <a href="admin_shipping_status.php" target="main_frame"><i class="fa fa-truck"></i> Shipping Status</a>
    <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
</div>
<div class="main">
    <h1>Welcome, Jenna's-hook</h1>
    <iframe name="main_frame"></iframe>
</div>

</body>
</html>
