<?php
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
    <title>Verify OTP</title>
</head>
<body>
    <h1>Verify OTP</h1>

    <form action="auth/verify-otp.php" method="post">
        <label for="otp">OTP</label><br>
        <input type="number" name="otp" placeholder="Enter otp" ><br><br>
        <input type="submit" value="Submit"><br>
    </form>

    <form action="auth/login.php" method="post">
        <button type="submit" name="btn-resend">Resend OTP</button>
    </form>
</body>
</html>