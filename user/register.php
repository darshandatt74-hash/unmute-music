<?php
session_start();
include("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        die("Email already registered");
    }

    mysqli_query($conn,
        "INSERT INTO users(name,email,password)
         VALUES('$name','$email','$pass')"
    );

    $_SESSION['otp_email'] = $email;

    header("Location: send_otp.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account | UNMUTE</title>

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

        .register-box{
            width:420px;
            background:#181818;
            padding:45px 35px;
            border-radius:20px;
            box-shadow:0 25px 70px rgba(0,0,0,0.7);
            animation:fadeInUp 0.8s ease;
        }

        .logo{
            text-align:center;
            font-size:28px;
            font-weight:700;
            margin-bottom:25px;
            color:#1DB954;
        }

        h2{
            text-align:center;
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
            outline:none;
            transition:0.3s;
        }

        input:focus{
            background:#333;
            box-shadow:0 0 12px #1DB954;
        }

        button{
            width:100%;
            padding:14px;
            border:none;
            border-radius:30px;
            background:#1DB954;
            color:black;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
            margin-top:10px;
        }

        button:hover{
            background:#1ed760;
            transform:scale(1.05);
        }

        .bottom-text{
            text-align:center;
            margin-top:20px;
            font-size:14px;
        }

        .bottom-text a{
            color:#1DB954;
            text-decoration:none;
            font-weight:500;
        }

        .bottom-text a:hover{
            text-decoration:underline;
        }
    </style>
</head>

<body>

<div class="register-box animate__animated animate__fadeInUp">

    <div class="logo">
        <i class="fa-solid fa-music"></i> UNMUTE
    </div>

    <h2>Create Account</h2>

    <form method="post" action="send_otp.php">

        <div class="input-group">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="name" placeholder="Full Name" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit">Register & Send OTP</button>
    </form>

    <div class="bottom-text">
        Already have account? <a href="login.php">Login</a>
    </div>

</div>

</body>
</html>
