<?php
require_once '../database/database.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $otp = $_POST['otp'] ?? null;

    if(empty($otp)){
        echo "<script>alert('Please enter otp.'); window.location.href='../verify.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT lv.*, u.email FROM login_verification lv JOIN users u WHERE lv.otp = :otp AND lv.expired_at > now();");
    $stmt->execute([":otp" => $otp]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user_data){
        if($otp == $user_data['otp']){
            $stmt = $conn->prepare("DELETE FROM login_verification WHERE email = :email");
            $stmt->execute([":email" => $user_data['email']]);

            $_SESSION['email'] = $user_data['email'];

            echo "<script>alert('Welcome, {$user_data['email']}!'); window.location.href='../home.php';</script>";
            exit;
        }else{
            echo "<script>alert('Invalid OTP.'); window.location.href='../verify.php';</script>";
            exit;
        }
    }else{
        echo "<script>alert('Your OTP is expired or invalid.'); window.location.href='../verify.php';</script>";
        exit;
    }
}else{
    header("Location: ../verify.php");
    exit;
}
?>