<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../includes/PHPMailer/Exception.php";
require "../includes/PHPMailer/PHPMailer.php";
require "../includes/PHPMailer/SMTP.php";
require "../config/mail.php";

$email = $_SESSION['reg_email'];

$otp = rand(100000,999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 600;

$mail = new PHPMailer(true);
$mailConfig = app_mail_config();

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
$mail->Subject = "Resent OTP";
$mail->Body = "<h2>Your OTP: <b>$otp</b></h2>";

$mail->send();

header("Location: verify_otp.php");
exit;
