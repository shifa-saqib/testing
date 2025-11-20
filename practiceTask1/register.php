<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";
  if ($conn->query($sql)) {
    echo "<p class='success'> Registered Successfully! <a href='login.php'>Login here</a></p>";
  } else {
    echo "<p class='error'> Email already exists or error!</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Signup</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: #f0f0f0;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
form {
  background: #fff;
  padding: 30px;
  border-radius: 8px;
  width: 300px;
  text-align: center;
}
h2 { margin-bottom: 20px; color: #333; }
input, button {
  width: 100%;
  padding: 10px;
  margin: 8px 0;
  border-radius: 5px;
  border: 1px solid #ccc;
}
button {
  background: #667eea;
  color: white;
  border: none;
  cursor: pointer;
}
p { margin-top: 10px; font-size: 14px; }
.error { color: red; }
.success { color: green; }

</style>
</head>
<body>
<form method="POST">
  <h2> Signup</h2>
  <input type="text" name="name" placeholder="Full Name" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Register</button>
  <p>Already have an account? <a href="login.php">Login</a></p>
</form>
</body>
</html>