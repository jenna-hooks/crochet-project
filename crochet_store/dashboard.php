<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f5f0;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #a65f4a;
            padding: 20px;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .sidebar img {
            width: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 30px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px;
            margin: 5px 0;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #8d4f3b;
        }

        .content {
            flex-grow: 1;
            padding: 40px;
            background-image: url("images/Jennahooks logo.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            color: #333;
        }

        .contact {
            margin-top: auto;
            font-size: 14px;
        }

        .contact a {
            color: #ffd2c3;
            text-decoration: none;
            display: block;
            margin: 4px 0;
        }

        .contact a:hover {
            text-decoration: underline;
        }

        .welcome-text {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <img src="images/crochet logo.jpg" alt="Logo">
    <h2><i class="fa-solid fa-user-circle"></i> Welcome </h2>
    
    <a href="products.php"><i class="fa-solid fa-store"></i> Products</a>
    <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
    <a href="account.php"><i class="fa-solid fa-user"></i> Account</a>
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>

    <div class="contact">
        <strong>Contact Us:</strong>
        <a href="https://www.instagram.com/jennas_hook/" target="_blank"><i class="fa-brands fa-instagram"></i> Instagram</a>
        <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook"></i> Facebook</a>
        <a href="https://www.tiktok.com/foryou?lang=en" target="_blank"><i class="fa-brands fa-tiktok"></i> TikTok</a>
        <a href="https://wa.me/0783994986" target="_blank"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
        <a href="https://www.linkedin.com/in/jeniffer-murigi-62b7a5275" target="_blank"><i class="fa-brands fa-linkedin"></i> LinkedIn</a>
    </div>
</div>

<div class="content">
    <div class="welcome-text">
        <h1>Hello, <?php echo $_SESSION['username'] ?? 'User'; ?>!</h1>
        <p>Welcome to your dashboard. Use the sidebar to navigate to products, manage your cart, or update your account details.</p> <br>
        <p><i> Handcrafted treasuer for all </i></p>
    </div>
</div>

</body>
</html>
