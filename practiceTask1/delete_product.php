<?php
include 'db.php';

if (isset($_GET['p_id'])) {
  $p_id = $_GET['p_id'];
  $conn->query("DELETE FROM products WHERE p_id = $p_id");
  header("Location: view_product.php");
  exit;
} else {
  header("Location: view_product.php");
  exit;
}
?>
