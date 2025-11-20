<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Mini E-Commerce</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: #fafafa;
  padding: 20px;
}
a {
  text-decoration: none;
  color: #667eea;
}
.product {
  background: white;
  border: 1px solid #ddd;
  padding: 10px;
  margin: 10px;
  display: inline-block;
  width: 220px;
  text-align: center;
  border-radius: 8px;
  vertical-align: top;
}
button {
  background: #667eea;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 5px;
}
nav {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}
img {
  width: 180px;
  height: 160px;
  object-fit: cover;
  border-radius: 6px;
  margin-bottom: 10px;
}
</style>
</head>
<body>

<nav>
  <div>Welcome, <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?></div>
  <div>
    <a href="add_product.php">Add Product</a> |
    <a href="view_product.php">Manage Products</a> |
    <a href="cart.php">🛒 Cart</a> |
    <a href="logout.php">Logout</a>
  </div>
</nav>

<h2>🛍 Available Products</h2>

<?php
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<div class='product'>";
    
    // ✅ Product image
    if (!empty($row['image'])) {
      echo "<img src='uploads/{$row['image']}' alt='Product Image'>";
    } else {
      echo "<img src='uploads/no-image.png' alt='No Image'>";
    }

    // ✅ Product details
    echo "
      <h3>{$row['name']}</h3>
      <p><b>ID:</b> {$row['p_id']}</p>
      <p><b>Price:</b> $ {$row['price']}</p>
      <p><b>Description:</b> {$row['description']}</p>
      
      <form method='POST' action='add_to_cart.php'>
        <input type='hidden' name='product_id' value='{$row['p_id']}'>
        <button type='submit'>Add to Cart</button>
      </form>
    </div>";
  }
} else {
  echo "<p>No products available.</p>";
}
?>
</body>
</html>
