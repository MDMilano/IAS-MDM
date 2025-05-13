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
        <label for="username">Username</label><br>
        <input type="text" name="username" placeholder="Enter username" required><br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" placeholder="Enter password" required><br><br>
        <input type="submit" value="Login"><br>
    </form>

    <p>Don't have an account? <a href="register.php">Sign Up</a></p>
</body>
</html>