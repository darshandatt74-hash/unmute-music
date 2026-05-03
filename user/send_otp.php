<?php
session_start();
require_once("../config/db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../includes/PHPMailer/Exception.php";
require "../includes/PHPMailer/PHPMailer.php";
require "../includes/PHPMailer/SMTP.php";

$name     = $_POST['name'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

/* Save registration data in session */
$_SESSION['reg_name']     = $name;
$_SESSION['reg_email']    = $email;
$_SESSION['reg_password'] = $password;

/* Generate OTP */
$otp = rand(100000,999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 600;

/* Send Mail */
$mail = new PHPMailer(true);

try{
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'darshandatt74@gmail.com';
    $mail->Password = 'ekqtbptwhvtkhdlu';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('darshandatt74@gmail.com','UNMUTE MUSIC');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "OTP Verification";
    $mail->Body = "<h2>Your OTP: <b>$otp</b></h2>";

    $mail->send();

    /* 🔥 IMPORTANT REDIRECT */
    header("Location: verify_otp.php");
    exit;

}catch(Exception $e){
    echo "MAIL_ERROR";
}
