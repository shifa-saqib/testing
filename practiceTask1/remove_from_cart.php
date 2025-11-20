<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $c_id = $_GET['id']; // use correct column name

    $sql = "DELETE FROM cart WHERE c_id='$c_id'";
    if ($conn->query($sql)) {
        header("Location: cart.php");
        exit;
    } else {
        echo "Error removing item: " . $conn->error;
    }
}
?>
