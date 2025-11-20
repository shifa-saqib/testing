<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'];

// Use correct column names
$user_result = $conn->query("SELECT u_id FROM users WHERE email='$user_email'");
$user = $user_result->fetch_assoc();
$user_id = $user['u_id'];

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $product_id = $_POST['product_id'];
//     $qty = $_POST['quantity'];

// ✅ Add product to cart with default quantity = 1
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $default_qty = 1; // default quantity

    $sql = "INSERT INTO cart (user_id, product_id, quantity)
            VALUES ('$user_id', '$product_id', '$default_qty')";
    if ($conn->query($sql)) {
        header("Location: cart.php");
        exit;
    } else {
        echo "Error adding to cart: " . $conn->error;
    }
}
?>
