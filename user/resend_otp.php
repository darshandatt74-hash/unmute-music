<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../includes/PHPMailer/Exception.php";
require "../includes/PHPMailer/PHPMailer.php";
require "../includes/PHPMailer/SMTP.php";

$email = $_SESSION['reg_email'];

$otp = rand(100000,999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 600;

$mail = new PHPMailer(true);

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
$mail->Subject = "Resent OTP";
$mail->Body = "<h2>Your OTP: <b>$otp</b></h2>";

$mail->send();

header("Location: verify_otp.php");
exit;
