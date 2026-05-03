<?php
session_start();
require_once("../config/db.php");

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $q = mysqli_query($conn,"
        SELECT * FROM users 
        WHERE email='$email' AND is_verified=1
    ");

    if(mysqli_num_rows($q)==1){
        $u = mysqli_fetch_assoc($q);

        if(password_verify($pass,$u['password'])){
            $_SESSION['user'] = $u['email'];
            header("Location: ../index.php");
            exit;
        }
    }

    $err = "Invalid Login";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | UNMUTE</title>

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

        .login-box{
            width:380px;
            background:#181818;
            padding:40px 30px;
            border-radius:20px;
            box-shadow:0 20px 60px rgba(0,0,0,0.6);
            animation:fadeInUp 0.8s ease;
        }

        .logo{
            text-align:center;
            font-size:28px;
            font-weight:700;
            margin-bottom:30px;
            color:#1DB954;
        }

        h2{
            text-align:center;
            margin-bottom:25px;
            font-weight:600;
        }

        .input-group{
            margin-bottom:20px;
            position:relative;
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
            padding:12px 12px 12px 40px;
            border:none;
            border-radius:30px;
            background:#282828;
            color:white;
            outline:none;
            transition:0.3s;
        }

        input:focus{
            background:#333;
            box-shadow:0 0 10px #1DB954;
        }

        button{
            width:100%;
            padding:12px;
            border:none;
            border-radius:30px;
            background:#1DB954;
            color:black;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#1ed760;
            transform:scale(1.03);
        }

        .error{
            text-align:center;
            margin-top:15px;
            color:#ff4d4d;
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

<div class="login-box animate__animated animate__fadeInUp">
    
    <div class="logo">
        <i class="fa-solid fa-music"></i> UNMUTE
    </div>

    <h2>Welcome Back</h2>

    <form method="post">
        
        <div class="input-group">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button name="login">Login</button>

    </form>

    <?php if(isset($err)) echo "<p class='error'>$err</p>"; ?>

    <div class="bottom-text">
        No account? <a href="register.php">Create Account</a>
    </div>

</div>

</body>
</html>
