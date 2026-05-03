<?php
include("../config/db.php");

$id = $_GET['id'];
$data = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM songs WHERE id=$id")
);

if(isset($_POST['update'])){
    $title  = $_POST['title'];
    $artist = $_POST['artist'];

    if(!empty($_FILES['song']['name'])){
        $song = time()."_".$_FILES['song']['name'];
        move_uploaded_file($_FILES['song']['tmp_name'],"../assets/songs/".$song);
        mysqli_query($conn,"UPDATE songs SET title='$title',artist='$artist',file='$song' WHERE id=$id");
    } else {
        mysqli_query($conn,"UPDATE songs SET title='$title',artist='$artist' WHERE id=$id");
    }

    header("location:songs.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Song | Admin</title>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- ANIMATE.CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
*{
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
}
body{
    margin:0;
    min-height:100vh;
    background: radial-gradient(circle at top, #111 0%, #000 70%);
    display:flex;
    justify-content:center;
    align-items:center;
    color:#fff;
}

/* CARD */
.card{
    width:420px;
    background:rgba(255,255,255,0.08);
    backdrop-filter: blur(14px);
    border-radius:18px;
    padding:30px;
    box-shadow:0 30px 80px rgba(0,0,0,.7);
}

/* HEADER */
.card h2{
    margin:0 0 20px;
    text-align:center;
    color:#22c55e;
}

/* INPUT */
input[type=text],
input[type=file]{
    width:100%;
    padding:12px;
    margin-bottom:14px;
    border-radius:10px;
    border:none;
    outline:none;
    background:#111;
    color:#fff;
}

input[type=text]:focus{
    box-shadow:0 0 0 2px #22c55e;
}

/* FILE INFO */
.file-info{
    font-size:13px;
    opacity:.8;
    margin-bottom:10px;
}

/* BUTTON */
button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:999px;
    font-size:15px;
    cursor:pointer;
    background:linear-gradient(135deg,#22c55e,#16a34a);
    color:#000;
    font-weight:600;
    transition:.3s;
}
button:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 30px rgba(34,197,94,.5);
}

/* BACK */
.back{
    text-align:center;
    margin-top:18px;
}
.back a{
    color:#9ca3af;
    text-decoration:none;
    font-size:14px;
}
.back a:hover{
    color:#22c55e;
}
</style>
</head>

<body>

<div class="card animate__animated animate__fadeInUp">
    <h2><i class="fa-solid fa-pen-to-square"></i> Edit Song</h2>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" value="<?= $data['title'] ?>" required>
        <input type="text" name="artist" value="<?= $data['artist'] ?>" required>

        <div class="file-info">
            <i class="fa-solid fa-music"></i>
            Current File: <?= $data['file'] ?>
        </div>

        <input type="file" name="song" accept="audio/mp3">

        <button name="update">
            <i class="fa-solid fa-floppy-disk"></i> Update Song
        </button>
    </form>

    <div class="back">
        <a href="songs.php"><i class="fa-solid fa-arrow-left"></i> Back to Songs</a>
    </div>
</div>

</body>
</html>
