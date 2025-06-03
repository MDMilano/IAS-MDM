<?php
    require_once '../database/database.php';

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;

        if(empty($email) || empty($password) || empty($confirm_password)){
            echo "<script>alert('Please enter both email, password and confirm password.'); window.location.href='../register.php';</script>";
            exit;
        }

        if($password != $confirm_password){
            echo "<script>alert('Password and Confirm Password do not match.'); window.location.href='../register.php';</script>";
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([":email" => $email]);
        
        if($stmt->rowCount() > 0){
            echo "<script>alert('email already exist.'); window.location.href='../register.php';</script>";
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $execute = $stmt->execute([
            ":email" => $email,
            ":password" => $password
        ]);

        if($execute){
            echo "<script>alert('Sign Up Successfully'); window.location.href='../';</script>";
            exit;
        }else{
            echo "<script>alert('Sign Up Failed'); window.location.href='../register.php';</script>";
            exit;
        }

    }else{
        header("Location: ../register.php");
        exit;
    }
?>