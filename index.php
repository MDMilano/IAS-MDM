<?php
session_start();

if(isset($_SESSION['email'])){
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <form action="auth/login.php" method="post">
        <label for="email">Email</label><br>
        <input type="text" name="email" placeholder="Enter email" required><br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" placeholder="Enter password" required><br><br>
        <button type="submit" name="btn-login">Login</button><br>
    </form>

    <p>Don't have an account? <a href="register.php">Sign Up</a></p>
</body>
</html>