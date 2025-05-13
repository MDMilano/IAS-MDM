<?php
    require_once '../database/database.php';
    session_start();

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if(empty($username) || empty($password)){
            echo "<script>alert('Please enter both username and password.'); window.location.href='../';</script>";
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute([":username" => $username]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if($userData){
            if($password == $userData['password']){
                $_SESSION['username'] = $userData['username'];

                echo "<script>alert('Welcome, {$userData['username']}'); window.location.href='../home.php';</script>";
                exit;
            }else{
                echo "<script>alert('Incorrect Password!'); window.location.href='../';</script>";
                exit;
            }
        }else{
            echo "<script>alert('No account found!'); window.location.href='../';</script>";
            exit;
        }
    }
?>