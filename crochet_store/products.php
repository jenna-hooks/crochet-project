<?php
include 'db_connect.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crochet Products</title>
    <!-- Optional: Link to Google Fonts & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
body {
    font-family: 'Poppins', sans-serif;
    background-image: url("images/Jennahooks logo.jpg");
    background-repeat: no-repeat;
    background-position: center top;
    background-size: cover;
    margin: 0;
    padding: 30px;
    position: relative;
    z-index: 0;
}

/* Overlay to dim the background */
body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.30); /* Light dimming layer */
    z-index: -1; /* Put behind content */
}


        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 60px;
            border-radius: 50%;
        }

        .logo h1 {
            font-size: 24px;
            color: #b97a57;
        }

        .dashboard-link a {
            color: #fff;
            background: #b97a57;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .dashboard-link a:hover {
            background: #a06244;
        }

        .product {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .product img {
            max-width: 150px;
            border-radius: 8px;
        }

        .product h3 {
            margin: 0 0 10px;
            color: #d76e4b;
        }

        .product p {
            font-size: 14px;
            color: #555;
        }

        .product strong {
            color: #000;
        }

        .product form {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .product input[type="number"] {
            width: 60px;
            padding: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .product button {
            background-color: #d76e4b;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .product button:hover {
            background-color: #c55d3f;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logos">
        <img src="images/crochet logo.jpg" alt="Logo" class="logo"width="200"height="200">
        <h1><i class="fa-solid fa-yarn"></i>Crochet shop</h1>
    </div>
    <div class="dashboard-link">
        <a href="dashboard.php"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
    </div>
</div>

<?php
$result = $conn->query("SELECT * FROM products");

if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
?>
    <div class="product">
        <?php if ($row['image_url']): ?>
            <img src="<?php echo $row['image_url']; ?>" alt="Product Image">
        <?php endif; ?>
        <div style="flex-grow: 1;">
            <h3><i class="fa-solid fa-hat-wizard"></i> <?php echo htmlspecialchars($row['name']); ?></h3>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <strong>Price: ksh<?php echo number_format($row['price'], 2); ?></strong>
        </div>

        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
        </form>
        <p><a href="add_to_cart.php"></a></p>
   </div>
<?php endwhile;
else: ?>
    <p>No products found.</p>
<?php endif; ?>

</body>
</html>
