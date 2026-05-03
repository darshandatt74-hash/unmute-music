<?php
session_start();
include("../config/db.php");

if(isset($_POST['login'])){
    $u = $_POST['username'];
    $p = $_POST['password'];

    $q = mysqli_query($conn,"SELECT * FROM admin WHERE username='$u' AND password='$p'");
    if(mysqli_num_rows($q)>0){
        $_SESSION['admin']=$u;
        header("location:dashboard.php");
    }else{
        $error = "Invalid Admin Login";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<form method="post" class="admin-form">
<h2>Admin Login</h2>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<input name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>

</body>
</html>
