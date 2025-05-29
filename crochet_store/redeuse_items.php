<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart_id'])) {
    $cart_id = intval($_POST['cart_id']);
    $user_id = $_SESSION['user_id'];

    // Get current quantity
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE cart_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $quantity = $row['quantity'];

        if ($quantity > 1) {
            // Reduce quantity by 1
            $update_stmt = $conn->prepare("UPDATE cart SET quantity = quantity - 1 WHERE cart_id = ?");
            $update_stmt->bind_param("i", $cart_id);
            $update_stmt->execute();
        } else {
            // Quantity is 1, remove item
            $delete_stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ?");
            $delete_stmt->bind_param("i", $cart_id);
            $delete_stmt->execute();
        }
    }
}

header("Location: view_cart.php");
exit();
?>
