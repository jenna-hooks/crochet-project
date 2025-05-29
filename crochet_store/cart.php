<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT c.cart_id, p.name, p.price, p.image_url, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
    background-color: rgba(255, 255, 255, 0.); /* Light dimming layer */
    z-index: -1; /* Put behind content */
}


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo img {
            height: 60px;
            border-radius: 50%;
        }

        .logo h1 {
            font-size: 24px;
            color: #a65f4a;
        }

        .cart-item {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cart-item img {
            width: 100px;
            border-radius: 10px;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item h3 {
            margin: 0 0 5px;
            color: #d76e4b;
        }

        .cart-item p {
            margin: 4px 0;
            color: #444;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }

        a.back-link {
            text-decoration: none;
            color: white;
            background: #d76e4b;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: bold;
        }

        a.back-link:hover {
            background: #c75d3f;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo">
        <img src="logo.png" alt="Logo">
        <h1><i class="fa-solid fa-yarn"></i>Crochet Store </h1> <br>
        <h1><i class="fa-solid fa-yarn"></i>Cart </h1>
    </div>
    <div>
        <a href="products.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Continue Shopping</a>
    </div>
</div>

<?php
$total = 0;

if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
?>
    <div class="cart-item">
        <?php if ($row['image_url']): ?>
            <img src="<?php echo $row['image_url']; ?>" alt="Product Image">
        <?php endif; ?>
        <div class="cart-item-details">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p>Quantity: <?php echo $row['quantity']; ?></p>
            <p>Price: ksh<?php echo number_format($row['price'], 2); ?></p>
            <p>Subtotal: ksh<?php echo number_format($subtotal, 2); ?></p>
        </div>

    </div>
<?php endwhile; ?>
    <div class="total">
        Total: ksh<?php echo number_format($total, 2); ?>
    </div>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>

<form method="POST" action="clear_cart.php" onsubmit="return confirm('Are you sure you want to clear the cart?');">
    <button type="submit" style="background:#c0392b; color:white; padding:10px 15px; border:none; border-radius:6px;">
        <i class="fa fa-trash"></i> Clear Cart
    </button>
</form>


</body>
</html>
