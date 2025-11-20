<?php
session_start();
include 'db.php';

// ✅ Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'];

// ✅ Get user ID from email
$user_result = $conn->query("SELECT u_id FROM users WHERE email='$user_email'");
$user = $user_result->fetch_assoc();
$user_id = $user['u_id'];

// ✅ Handle increment quantity via plus button
if (isset($_POST['increase_qty'])) {
    $cart_id = (int)$_POST['cart_id'];
    $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE c_id='$cart_id'");
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cart</title>
<style>
body { font-family: Arial; padding: 20px; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
th { background: #ddd; }
button { padding: 5px 10px; cursor: pointer; }
button.plus { background: #4CAF50; color: white; border: none; }
a { text-decoration: none; color: blue; }
</style>
</head>
<body>

<h2>Your Cart</h2>

<table>
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php
$total = 0;

// ✅ Get all cart items for this user
$cart_result = $conn->query("SELECT * FROM cart WHERE user_id='$user_id'");

if ($cart_result->num_rows > 0) {
    while ($cart_item = $cart_result->fetch_assoc()) {
        $product_id = $cart_item['product_id'];

        // ✅ Fetch product details
        $product_result = $conn->query("SELECT * FROM products WHERE p_id='$product_id'");
        $product = $product_result->fetch_assoc();

        // ✅ Calculate total price for this item
        $item_total = floatval($product['price']) * intval($cart_item['quantity']);
        $total += $item_total;

        // ✅ Display cart row
        echo "<tr>
                <td>{$product['name']}</td>
                <td>\${$product['price']}</td>
                <td>
                    {$cart_item['quantity']}
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='cart_id' value='{$cart_item['c_id']}'>
                        <button type='submit' name='increase_qty' class='plus'>+</button>
                    </form>
                </td>
                <td>\${$item_total}</td>
                <td><a href='remove_from_cart.php?id={$cart_item['c_id']}'><button>Remove</button></a></td>
              </tr>";
    }

    // ✅ Display grand total
    echo "<tr>
            <td colspan='3'><b>Grand Total</b></td>
            <td colspan='2'><b>\$$total</b></td>
          </tr>";
    echo "</table><br>";
    echo "<a href='order.php'><button>Place Order</button></a>";
} else {
    // ✅ Show if cart is empty
    echo "<tr><td colspan='5'>Your cart is empty!</td></tr></table>";
}
?>

</body>
</html>
