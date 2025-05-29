<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    header("Location:cart.php"); // Redirect to the cart page
    exit();
} else {
    echo "Failed to clear cart. Please try again.";
}
?>
