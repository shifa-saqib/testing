<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practice_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

} 
$sql = " CREATE TABLE IF NOT EXISTS cart (
    c_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT,
    FOREIGN KEY (user_id) REFERENCES users(u_id),
    FOREIGN KEY (product_id) REFERENCES products(p_id)
);";



$sql_orders = "CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(u_id),
    FOREIGN KEY (product_id) REFERENCES products(p_id)
);";

if ($conn->query($sql_orders) === TRUE) {
    // Table created or already exists
} else {
    echo "Error creating orders table: " . $conn->error;
}

// if ($conn->query($sql) === TRUE) {
//     echo "Table 'cart' created successfully";
// } else {
//     echo "Error creating table: " . $conn->error;
// }

// echo "Connected Succcessfully";
?>