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
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>

    <form action="auth/signup.php" method="post">
        <label for="email">Email</label><br>
        <input type="text" name="email" placeholder="Enter email" ><br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" placeholder="Enter password" ><br><br>
        <label for="confirm_password">Confirm Password</label><br>
        <input type="password" name="confirm_password" placeholder="Enter confirm password" ><br><br>
        <input type="submit" value="Sign Up"><br>
    </form>

    <p>Already have an account? <a href="index.php">Log in</a></p>
</body>
</html>