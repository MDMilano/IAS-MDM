<?php
session_start();

if(!isset($_SESSION['email'])){
    echo "<script>alert('Please login.'); window.location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h1>
    <button><a href="auth/logout.php">Logout</a></button>
    <!-- <button><a href="auth/logout.php" onclick="return confirm('Are you sure you want to log out?')">Logout</a></button> -->
</body>
</html>