<?php
include 'db.php';

if (!isset($_GET['p_id'])) {
  die("Invalid request.");
}

$p_id = $_GET['p_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $desc = $_POST['description'];
  $price = $_POST['price'];
 

  // Simple image upload
  $image = $_FILES['image']['name'];
  $target = "uploads/" . basename($image);
  move_uploaded_file($_FILES['image']['tmp_name'], $target);

  if (!empty($image)) {
    $sql = "UPDATE products SET name='$name', description='$desc', price='$price',  image='$image' WHERE p_id='$p_id'";
  } else {
    $sql = "UPDATE products SET name='$name', description='$desc', price='$price' WHERE p_id='$p_id'";
  }

  if ($conn->query($sql)) {
    echo "<p class='success'>✅ Product updated successfully!</p>";
  } else {
    echo "<p class='error'>❌ Error updating product!</p>";
  }
}

$sql = "SELECT * FROM products WHERE p_id='$p_id'";
$result = $conn->query($sql);
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
  <style>
    body { font-family: Arial; background: #f2f2f2; padding: 20px; }
    form { background: #fff; padding: 20px; width: 350px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
    input, textarea { width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 5px; }
    button { background: #4CAF50; color: white; border: none; padding: 10px; cursor: pointer; width: 100%; border-radius: 5px; }
    .success { color: green; }
    .error { color: red; }
    a { text-decoration: none; color: #4CAF50; }
  </style>
</head>
<body>
  <h2>Edit Product</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" value="<?= $product['name'] ?>" required>
    <textarea name="description" required><?= $product['description'] ?></textarea>
    <input type="number" name="price" value="<?= $product['price'] ?>" required>
    <input type="file" name="image" >
    <button type="submit">Update Product</button>
  </form>

  <p><a href="view_product.php">⬅ Back to Product List</a></p>
</body>
</html>
