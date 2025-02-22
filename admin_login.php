<?php
require 'db_connect.php'; // Include database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    
    // Fetch admin credentials
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial, sans-serif; }
        form { width: 300px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        label, input { display: block; width: 100%; margin-bottom: 10px; }
        input[type="submit"] { background: blue; color: white; border: none; padding: 10px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Admin Login</h2>
    <form action="admin_login.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>
        
        <label>Password:</label>
        <input type="password" name="password" required>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>