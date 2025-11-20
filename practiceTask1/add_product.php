<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $desc = $_POST['description'];
  $price = $_POST['price'];
    
  $quantity = 1;

  //  Simple image upload
  $image = $_FILES['image']['name'];
  $temp = $_FILES['image']['tmp_name'];
  move_uploaded_file($temp, "uploads/$image");

  $sql = "INSERT INTO products (name, description, price, image ,quantity)
          VALUES ('$name', '$desc', '$price', '$image' ,'$quantity')";
  if ($conn->query($sql)) {
      echo "<p class='success'> Product added successfully!</p>";
  } else {
      echo "<p class='error'> Error adding product!</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <style>
    body { 
        font-family: Arial; 
        background: #f2f2f2;
         padding: 20px; 
        }
    form { 
        background: #fff; 
        padding: 20px; width: 350px;
         border-radius: 8px;
         }
    input, textarea { 
        width: 100%; 
        padding: 8px; 
        margin: 8px 0; border: 1px solid #ccc; 
        border-radius: 5px; 
    }
    button { 
        background: #4CAF50; 
        color: white; 
        border: none; 
        padding: 10px; 
        cursor: pointer;
         width: 100%; 
         border-radius: 5px;
         }
    .success { 
        color: green; 
    }
    .error { 
        color: red;
     }
    a { text-decoration: none;
         color: #4CAF50; 
    }
  </style>
</head>
<body>
  <h2>Add Product</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required>
    <textarea name="description" placeholder="Product Description" required></textarea>
    <input type="number" name="price" placeholder="Price" required>
    <input type="file" name="image" accept="image/*" required>
    <button type="submit">Add Product</button>
  </form>
  <p><a href="view_product.php"> View All Products</a></p>
</body>
</html>
