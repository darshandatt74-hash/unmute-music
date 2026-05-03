<?php
session_start();
include("../config/db.php");

$success = false;

if(isset($_POST['upload'])){

    $title  = mysqli_real_escape_string($conn,$_POST['title']);
    $artist = mysqli_real_escape_string($conn,$_POST['artist']);

    $songFile = time()."_".$_FILES['song']['name'];
    $songTmp  = $_FILES['song']['tmp_name'];

    $songImg = time()."_".$_FILES['song_image']['name'];
    $songImgTmp = $_FILES['song_image']['tmp_name'];

    $artistImg = time()."_".$_FILES['artist_image']['name'];
    $artistImgTmp = $_FILES['artist_image']['tmp_name'];

    move_uploaded_file($songTmp,"../assets/songs/".$songFile);
    move_uploaded_file($songImgTmp,"../assets/images/songs/".$songImg);
    move_uploaded_file($artistImgTmp,"../assets/images/artists/".$artistImg);

    mysqli_query($conn,"
        INSERT INTO songs (title,artist,file,song_image,artist_image)
        VALUES ('$title','$artist','$songFile','$songImg','$artistImg')
    ");

    $success = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<title>Add Song | UNMUTE Admin</title>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}
body{
    height:100vh;
    background:
        radial-gradient(circle at top,#1db95422,transparent 60%),
        linear-gradient(120deg,#000,#0f0f0f);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
}

/* CARD */
.card{
    width:420px;
    background:rgba(20,20,20,0.85);
    backdrop-filter: blur(14px);
    padding:35px;
    border-radius:18px;
    box-shadow:0 25px 80px rgba(0,0,0,.8);
    animation:fadeUp .7s ease;
}

@keyframes fadeUp{
    from{opacity:0; transform:translateY(40px) scale(.95)}
    to{opacity:1; transform:none}
}

h2{
    text-align:center;
    margin-bottom:30px;
    font-weight:600;
}
h2 i{
    color:#1db954;
}

/* INPUTS */
.input-group{
    margin-bottom:16px;
}
.input-group label{
    font-size:13px;
    color:#aaa;
}
.input-group input{
    width:100%;
    padding:12px 14px;
    border-radius:12px;
    border:none;
    background:#1e1e1e;
    color:#fff;
    outline:none;
    transition:.3s;
}
.input-group input:focus{
    background:#222;
    box-shadow:0 0 0 1px #1db954;
}

/* FILE INPUT */
input[type=file]{
    cursor:pointer;
}

/* BUTTON */
button{
    width:100%;
    padding:14px;
    margin-top:10px;
    border:none;
    border-radius:30px;
    background:linear-gradient(135deg,#1db954,#1ed760);
    color:#000;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}
button:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 30px #1db95455;
}

/* BACK */
.back{
    display:block;
    text-align:center;
    margin-top:18px;
    color:#1db954;
    text-decoration:none;
    font-size:14px;
}
.back:hover{
    text-decoration:underline;
}
</style>
</head>

<body>

<div class="card">
    <h2><i class="fa-solid fa-music"></i> Add New Song</h2>

    <form method="post" enctype="multipart/form-data">

        <div class="input-group">
            <label>Song Title</label>
            <input type="text" name="title" required>
        </div>

        <div class="input-group">
            <label>Artist Name</label>
            <input type="text" name="artist" required>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-file-audio"></i> Song File (mp3)</label>
            <input type="file" name="song" accept=".mp3" required>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-image"></i> Song Image</label>
            <input type="file" name="song_image" accept="image/*" required>
        </div>

        <div class="input-group">
            <label><i class="fa-solid fa-user"></i> Artist Image</label>
            <input type="file" name="artist_image" accept="image/*" required>
        </div>

        <button name="upload">
            <i class="fa-solid fa-cloud-arrow-up"></i> Upload Song
        </button>
    </form>

    <a href="dashboard.php" class="back">← Back to Admin</a>
</div>

<?php if($success){ ?>
<script>
Swal.fire({
    icon:'success',
    title:'Uploaded!',
    text:'Song added successfully',
    timer:1600,
    showConfirmButton:false
});
</script>
<?php } ?>

</body>
</html>
