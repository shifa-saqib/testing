<?php
include 'db.php';
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Products</title>
  <style>
    body { font-family: Arial; background: #f9f9f9; padding: 20px; }
    table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 0 10px #ccc; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background: #4CAF50; color: white; }
    img { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; }
    a { text-decoration: none; color: #4CAF50; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <h2>Product List</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Description</th>
      <th>Price</th>
       <th>Quantity</th>
      <th>Image</th>
      <th>Actions</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['p_id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['description']}</td>
                <td>{$row['price']}</td>
                 <td>{$row['quantity']}</td>
                <td><img src='uploads/{$row['image']}' alt='{$row['name']}'></td>
                <td>
                  <a href='edit_product.php?p_id={$row['p_id']}'>✏️ Edit</a> | 
                  <a href='delete_product.php?p_id={$row['p_id']}' onclick=\"return confirm('Are you sure you want to delete this product?');\">🗑 Delete</a>
                </td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='7'>No products available.</td></tr>";
    }
    ?>
  </table>

  <p><a href="add_product.php">➕ Add New Product</a></p>
</body>
</html>
