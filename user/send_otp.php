<?php
session_start();
require_once("../config/db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../includes/PHPMailer/Exception.php";
require "../includes/PHPMailer/PHPMailer.php";
require "../includes/PHPMailer/SMTP.php";
require "../config/mail.php";

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
$mailConfig = app_mail_config();

try{
    $mail->isSMTP();
    $mail->Host = $mailConfig['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $mailConfig['username'];
    $mail->Password = $mailConfig['password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $mailConfig['port'];

    $mail->setFrom($mailConfig['from'], $mailConfig['from_name']);
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
