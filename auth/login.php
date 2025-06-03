<?php
require_once '../database/database.php';
require_once '../src/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

function send_email($email, $subject, $message)
{
    try {
        $smtp_email = "marcdanielmilano@gmail.com";
        $smtp_password = "crxu ljdr mvuv dfik";

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->Username = $smtp_email;
        $mail->Password = $smtp_password;
        $mail->setFrom($smtp_email, "Marc System");
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        $mail->send();
    } catch (Exception $e) {
        throw new Exception("Failed to send email");
    }
}

function store_otp($conn, $email, $otp)
{
    try {
        $stmt = $conn->prepare("DELETE FROM login_verification WHERE email = :email");
        $stmt->execute([":email" => $email]);

        $stmt = $conn->prepare("INSERT INTO login_verification (email, otp, expired_at) VALUES (:email, :otp, now() +interval 10 minute);");
        $stmt->execute([":email" => $email, ":otp" => $otp]);
    } catch (PDOException $e) {
        echo "Connection Error: " . $e->getMessage();
    }
}

function regenerate_otp($conn, $otp, $email){
    try {
        $stmt = $conn->prepare("UPDATE login_verification SET otp = :otp, expired_at = now() + interval 10 minute WHERE email = :email;");
        $stmt->execute([":otp" => $otp, ":email" => $email]);
    } catch (PDOException $e) {
        echo "Connection Error: " . $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    try {
        if(isset($_POST['btn-login'])){
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            if(empty($email) || empty($password)){
                echo "<script>alert('Please enter both email and password.'); window.location.href='../';</script>";
                exit;
            }

            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password =:password;");
            $stmt->execute([":email" => $email, ":password" => $password]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if($userData){
                $otp = rand(100000, 999999);
                $email = $userData['email'];
                $subject = "Verify OTP";
                $message = "Your OTP is <b>$otp</b><br>";
                $message .= "This OTP will expire in 10 minutes";

                $_SESSION['verify_email'] = $email;

                send_email($email, $subject, $message);
                store_otp($conn, $email, $otp);
                echo "<script>alert('We have sent an OTP to {$email}'); window.location.href='../verify.php';</script>";
                exit;
            }else{
                echo "<script>alert('Wrong login credentials!'); window.location.href='../';</script>";
                exit;
            }
        }else if(isset($_POST['btn-resend'])){
            $otp = rand(100000, 999999);
            $email = $_SESSION['verify_email'];
            $subject = "Verify OTP";
            $message = "Your OTP is <b>$otp</b><br>";
            $message .= "This OTP will expire in 10 minutes";

            send_email($email, $subject, $message);
            regenerate_otp($conn, $otp, $email);

            echo "<script>alert('We have sent new OTP to {$email}'); window.location.href='../verify.php';</script>";
            unset($_SESSION['verify_email']);
            exit;
        }
    } catch (PDOException $e) {
        echo "Connection Error: " . $e->getMessage();
    }
}else{
    header("Location: ../index.php");
    exit;
}
?>