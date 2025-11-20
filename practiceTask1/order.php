<?php
session_start();
include 'db.php';

// ✅ Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'];

// ✅ Get user ID
$user_result = $conn->query("SELECT u_id FROM users WHERE email='$user_email'");
$user = $user_result->fetch_assoc();
$user_id = $user['u_id'];

// ✅ Get all cart items for this user
$cart_result = $conn->query("SELECT * FROM cart WHERE user_id='$user_id'");

if ($cart_result->num_rows > 0) {
    // ✅ Loop through each cart item and insert into orders table
    while ($item = $cart_result->fetch_assoc()) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        // ✅ Get product price at the time of order
        $product_result = $conn->query("SELECT price FROM products WHERE p_id='$product_id'");
        $product = $product_result->fetch_assoc();
        $price = $product['price'];

        // ✅ Insert into orders table
        $conn->query("INSERT INTO orders (user_id, product_id, quantity, price, order_date)
                      VALUES ('$user_id', '$product_id', '$quantity', '$price', NOW())");
    }

    // ✅ Clear the cart
    $conn->query("DELETE FROM cart WHERE user_id='$user_id'");

    echo "<h2 style='text-align:center;color:green;'>✅ Order placed successfully!</h2>
          <p style='text-align:center;'><a href='index.php'>Continue Shopping</a></p>";
} else {
    echo "<h2 style='text-align:center;color:red;'>Your cart is empty!</h2>
          <p style='text-align:center;'><a href='index.php'>Go Shopping</a></p>";
}
?>
