<?php
session_start();
include 'db.php';

//  If user already logged in, go to homepage
if (isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
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
</style>
</head>
<body>

<form method="POST">
  <h2> Login</h2>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
  <p>No account? <a href="register.php">Signup</a></p>
</form>

<?php
//  Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  //  Check if user exists
  $result = $conn->query("SELECT * FROM users WHERE email='$email'");
  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    //  Verify password
    if (password_verify($password, $user['password'])) {
       $_SESSION['u_id'] = $user['u_id']; 
    $_SESSION['name'] = $user['name'];   
    $_SESSION['email'] = $user['email'];
        header("Location: index.php"); // redirect to home page after login
        exit;
    } else {
        echo "<p class='error'> Wrong password!</p>";
    }
  } else {
    echo "<p class='error'> Email not found!</p>";
  }
}
?>
</body>
</html>
