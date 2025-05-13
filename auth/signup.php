<?php
    require_once '../database/database.php';

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $username = isset($_POST['username']) ? trim($_POST['username']) : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;

        if(empty($username) || empty($password) || empty($confirm_password)){
            echo "<script>alert('Please enter both username, password and confirm password.'); window.location.href='../register.php';</script>";
            exit;
        }

        if($password != $confirm_password){
            echo "<script>alert('Password and Confirm Password do not match.'); window.location.href='../register.php';</script>";
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute([":username" => $username]);
        
        if($stmt->rowCount() > 0){
            echo "<script>alert('Username already exist.'); window.location.href='../register.php';</script>";
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
        $execute = $stmt->execute([
            ":username" => $username,
            ":password" => $password
        ]);

        if($execute){
            echo "<script>alert('Sign Up Successfully'); window.location.href='../';</script>";
            exit;
        }else{
            echo "<script>alert('Sign Up Failed'); window.location.href='../register.php';</script>";
            exit;
        }

    }
?>