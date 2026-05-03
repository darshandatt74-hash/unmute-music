 <?php
session_start();
require_once("../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];

if(isset($_POST['upload'])){

    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0){

        $allowed = ['jpg','jpeg','png'];

        $fileName = $_FILES['profile_pic']['name'];
        $tmpName  = $_FILES['profile_pic']['tmp_name'];

        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if(in_array($ext,$allowed)){

            $newName = uniqid().".".$ext;
            $uploadPath = "../uploads/profile/".$newName;

            move_uploaded_file($tmpName,$uploadPath);

            mysqli_query($conn,"
                UPDATE users 
                SET profile_pic='$newName' 
                WHERE email='$email'
            ");

            header("Location: profile.php");
            exit;
        }
    }
}

$q = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
<title>User Profile | UNMUTE</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    background:#121212;
    font-family:'Poppins',sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    color:#fff;
}

.card{
    background:#1e1e1e;
    padding:40px;
    border-radius:20px;
    text-align:center;
    width:350px;
    box-shadow:0 0 40px rgba(0,0,0,0.5);
    animation:fadeIn 0.6s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

.card img{
    width:130px;
    height:130px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #1DB954;
    margin-bottom:15px;
}

input[type=file]{
    margin:15px 0;
    color:#fff;
}

button{
    background:#1DB954;
    border:none;
    padding:10px 25px;
    border-radius:25px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:scale(1.05);
}

a{
    display:block;
    margin-top:20px;
    color:#1DB954;
    text-decoration:none;
}
</style>
</head>
<body>

<div class="card">

<?php if($user['profile_pic']){ ?>
    <img src="../uploads/profile/<?php echo $user['profile_pic']; ?>">
<?php } else { ?>
    <img src="https://ui-avatars.com/api/?name=<?php echo $user['name']; ?>&background=1DB954&color=000">
<?php } ?>

<h3><?php echo $user['name']; ?></h3>
<p><?php echo $user['email']; ?></p>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="profile_pic" required>
    <br>
    <button name="upload">Upload Photo</button>
</form>

<a href="../index.php">Back to Home</a>

</div>

</body>
</html>
