<?php
session_start();
require_once("../config/db.php");

$entered_otp = $_POST['otp'];

if(time() > $_SESSION['otp_expiry']){
    die("OTP_EXPIRED");
}

if($entered_otp != $_SESSION['otp']){
    die("INVALID_OTP");
}

/* Insert user */
$name = $_SESSION['reg_name'];
$email = $_SESSION['reg_email'];
$password = $_SESSION['reg_password'];

mysqli_query($conn,"
    INSERT INTO users (name,email,password,is_verified)
    VALUES ('$name','$email','$password',1)
");

/* Cleanup */
session_destroy();

/* Redirect to login */
header("Location: login.php");
exit;
