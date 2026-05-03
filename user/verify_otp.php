<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['otp']) || empty($_POST['otp'])) {
        $error = "OTP_REQUIRED";
    } else {

        $enteredOtp = $_POST['otp'];

        if (time() > $_SESSION['otp_expiry']) {
            $error = "OTP_EXPIRED";
        } elseif ($enteredOtp != $_SESSION['otp']) {
            $error = "INVALID_OTP";
        } else {
            // ✅ OTP VERIFIED
            require_once("../config/db.php");

            $name     = $_SESSION['reg_name'];
            $email    = $_SESSION['reg_email'];
            $password = $_SESSION['reg_password'];

            mysqli_query($conn,"
                INSERT INTO users (name,email,password,is_verified)
                VALUES ('$name','$email','$password',1)
            ");

            session_destroy();

            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP | UNMUTE</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{
            height:100vh;
            background:linear-gradient(135deg,#121212,#000000);
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;
        }

        .otp-box{
            width:400px;
            background:#181818;
            padding:40px 30px;
            border-radius:20px;
            box-shadow:0 20px 60px rgba(0,0,0,0.6);
            text-align:center;
            animation:fadeInUp 0.8s ease;
        }

        .logo{
            font-size:28px;
            font-weight:700;
            margin-bottom:20px;
            color:#1DB954;
        }

        h2{
            margin-bottom:25px;
            font-weight:600;
        }

        .input-group{
            position:relative;
            margin-bottom:20px;
        }

        .input-group i{
            position:absolute;
            left:15px;
            top:50%;
            transform:translateY(-50%);
            color:#aaa;
        }

        input{
            width:100%;
            padding:14px 14px 14px 45px;
            border:none;
            border-radius:30px;
            background:#282828;
            color:white;
            font-size:16px;
            letter-spacing:5px;
            text-align:center;
            outline:none;
            transition:0.3s;
        }

        input:focus{
            background:#333;
            box-shadow:0 0 12px #1DB954;
        }

        .btn{
            width:100%;
            padding:12px;
            border:none;
            border-radius:30px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
            margin-top:10px;
        }

        .verify-btn{
            background:#1DB954;
            color:black;
        }

        .verify-btn:hover{
            background:#1ed760;
            transform:scale(1.05);
        }

        .resend-btn{
            background:transparent;
            border:1px solid #1DB954;
            color:#1DB954;
        }

        .resend-btn:hover{
            background:#1DB954;
            color:black;
            transform:scale(1.05);
        }

        .error{
            margin-top:15px;
            padding:10px;
            background:#ff4d4d22;
            border:1px solid #ff4d4d;
            border-radius:8px;
            color:#ff4d4d;
            font-size:14px;
        }
    </style>
</head>
<body>

<div class="otp-box animate__animated animate__fadeInUp">

    <div class="logo">
        <i class="fa-solid fa-music"></i> UNMUTE
    </div>

    <h2>OTP Verification</h2>

    <form method="post">
        <div class="input-group">
            <i class="fa-solid fa-key"></i>
            <input type="number" name="otp" placeholder="Enter OTP" required>
        </div>

        <button type="submit" class="btn verify-btn">
            Verify OTP
        </button>
    </form>

    <form method="post" action="resend_otp.php">
        <button type="submit" class="btn resend-btn">
            Resend OTP
        </button>
    </form>

    <?php if($error!=""){ ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

</div>

</body>
</html>
