<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin'])){
    header("location:login.php");
    exit;
}

$songs = mysqli_query($conn,"SELECT * FROM songs ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<title>Manage Songs | UNMUTE Admin</title>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}
body{
    background:linear-gradient(135deg,#0b0b0b,#101010);
    color:#fff;
    min-height:100vh;
}

/* HEADER */
.header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:25px 40px;
    border-bottom:1px solid #222;
}
.header h2{
    font-size:26px;
}
.header a{
    color:#1db954;
    text-decoration:none;
    font-weight:500;
}

/* CONTAINER */
.container{
    padding:40px;
}

/* SONG CARD */
.song-card{
    display:flex;
    align-items:center;
    gap:20px;
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(15px);
    padding:20px;
    border-radius:18px;
    margin-bottom:20px;
    box-shadow:0 20px 50px rgba(0,0,0,.6);
    transition:.4s;
}
.song-card:hover{
    transform:translateY(-6px);
}

/* IMAGE */
.song-img{
    width:80px;
    height:80px;
    border-radius:14px;
    object-fit:cover;
}

/* INFO */
.song-info{
    flex:1;
}
.song-info h3{
    font-size:18px;
    margin-bottom:4px;
}
.song-info p{
    color:#aaa;
    font-size:14px;
}

/* AUDIO */
audio{
    width:280px;
    height:36px;
}

/* ACTIONS */
.actions{
    display:flex;
    gap:12px;
}
.actions a{
    padding:10px 16px;
    border-radius:12px;
    font-size:14px;
    text-decoration:none;
    font-weight:500;
    transition:.3s;
}
.edit{
    background:#3b82f6;
    color:#fff;
}
.edit:hover{
    background:#2563eb;
}
.delete{
    background:#ef4444;
    color:#fff;
}
.delete:hover{
    background:#dc2626;
}

/* EMPTY */
.empty{
    text-align:center;
    color:#777;
    margin-top:80px;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>🎵 Manage Songs</h2>
    <a href="dashboard.php">← Back to Dashboard</a>
</div>

<!-- CONTENT -->
<div class="container">

<?php if(mysqli_num_rows($songs)==0){ ?>
    <div class="empty">
        <h3>No songs uploaded yet</h3>
    </div>
<?php } ?>

<?php while($s=mysqli_fetch_assoc($songs)){ ?>

<div class="song-card">

    <img src="../assets/images/songs/<?php echo $s['song_image']; ?>" class="song-img">

    <div class="song-info">
        <h3><?php echo $s['title']; ?></h3>
        <p><?php echo $s['artist']; ?></p>
    </div>

    <audio controls>
        <source src="../assets/songs/<?php echo $s['file']; ?>">
    </audio>

    <div class="actions">
        <a href="edit_song.php?id=<?php echo $s['id']; ?>" class="edit">
            <i class="fa-solid fa-pen"></i> Edit
        </a>
        <a href="delete_song.php?id=<?php echo $s['id']; ?>" class="delete" onclick="return confirm('Delete this song?')">
            <i class="fa-solid fa-trash"></i> Delete
        </a>
    </div>

</div>

<?php } ?>

</div>

</body>
</html>
