<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

$plist = mysqli_query($conn,"
SELECT p.*, 
(SELECT COUNT(*) FROM playlist_songs ps WHERE ps.playlist_id = p.id) as total_songs
FROM user_playlists p
WHERE p.user_email='$user'
ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>My Playlists | UNMUTE</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
body{
margin:0;
font-family:'Poppins',sans-serif;
background:#121212;
color:white;
}

.container{
padding:50px 80px;
}

.top-bar{
display:flex;
align-items:center;
justify-content:space-between;
margin-bottom:40px;
}

.back-btn{
color:#b3b3b3;
text-decoration:none;
font-size:14px;
transition:.3s;
}
.back-btn:hover{ color:#1db954; }

h2{
font-size:28px;
margin:0;
}

.create-box{
display:flex;
gap:15px;
margin-bottom:40px;
}

.create-box input{
background:#181818;
border:none;
padding:14px 18px;
border-radius:30px;
color:white;
width:260px;
font-size:14px;
outline:none;
}

.create-box button{
background:#1db954;
border:none;
padding:14px 28px;
border-radius:30px;
color:black;
font-weight:600;
cursor:pointer;
}

.playlist-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
gap:30px;
}

.playlist-card{
background:linear-gradient(145deg,#111,#181818);
padding:20px;
border-radius:18px;
transition:.3s;
position:relative;
overflow:hidden;
}

.playlist-card:hover{
transform:translateY(-5px);
box-shadow:0 20px 40px rgba(0,0,0,.6);
}

.playlist-icon{
width:60px;
height:60px;
background:#282828;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
font-size:22px;
font-weight:600;
margin-bottom:15px;
}

.playlist-name{
font-size:16px;
font-weight:500;
}

.song-count{
font-size:12px;
color:#b3b3b3;
margin-top:5px;
}

.card-actions{
display:flex;
justify-content:space-between;
align-items:center;
margin-top:15px;
}

.play-btn{
background:#1db954;
width:40px;
height:40px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
color:black;
cursor:pointer;
}

.icon-btn{
color:#b3b3b3;
cursor:pointer;
transition:.3s;
}

.icon-btn:hover{
color:white;
}

.play-btn{
background:#1db954;
width:50px;
height:50px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
color:black;
cursor:pointer;

position:absolute;
bottom:20px;
right:20px;

opacity:0;
transform:translateY(15px);
transition:.3s;
}

/* hover effect */

.playlist-card:hover .play-btn{
opacity:1;
transform:translateY(0);
}

/* PLAY ALL TEXT */

.play-btn::after{
content:"Play All";
position:absolute;
bottom:60px;
background:#000;
color:white;
padding:4px 10px;
border-radius:6px;
font-size:11px;
opacity:0;
white-space:nowrap;
transition:.2s;
}

/* text show when hover icon */

.play-btn:hover::after{
opacity:1;
}

.play-btn{
transition: transform .3s ease, opacity .3s ease;
}

.playlist-card:hover .play-btn{
transform:translateY(0) scale(1.05);
}
.playlist-card:hover{
box-shadow:0 15px 40px rgba(0,0,0,.7);
background:#1a1a1a;
}
</style>
</head>

<body>

<div class="container">

<div class="top-bar">
<h2>🎶 My Playlists</h2>
<a href="../index.php" class="back-btn">
<i class="fa-solid fa-arrow-left"></i> Back to Home
</a>
</div>

<form method="POST" action="create_playlist.php" class="create-box">
<input type="text" name="playlist_name" placeholder="Create new playlist..." required>
<button>Create</button>
</form>

<div class="playlist-grid">

<?php while($p = mysqli_fetch_assoc($plist)){ ?>

<div class="playlist-card">

<a href="playlist_view.php?id=<?php echo $p['id']; ?>" 
style="text-decoration:none;color:white;display:block;">

<div class="playlist-icon">
<?php echo strtoupper(substr($p['playlist_name'],0,1)); ?>
</div>

<div class="playlist-name">
<?php echo htmlspecialchars($p['playlist_name']); ?>
</div>

<p class="song-count">
<?php echo $p['total_songs']; ?> Songs
</p>

</a>

<div class="card-actions">

<div class="play-btn" 
onclick="event.stopPropagation(); playPlaylist(<?php echo $p['id']; ?>)">
<i class="fa-solid fa-play"></i>
</div>

<div>
<i class="fa-solid fa-pen icon-btn"
onclick="renamePlaylist(<?php echo $p['id']; ?>,'<?php echo htmlspecialchars($p['playlist_name']); ?>')"></i>

<a href="delete_playlist.php?id=<?php echo $p['id']; ?>"
onclick="return confirm('Delete this playlist?')">
<i class="fa-solid fa-trash icon-btn"></i>
</a>
</div>

</div>

</div>

<?php } ?>

</div>
</div>

<script>

function playPlaylist(id){
fetch("get_playlist_songs.php?id="+id)
.then(res=>res.json())
.then(data=>{
localStorage.setItem("playlist", JSON.stringify(data));
localStorage.setItem("currentIndex", 0);
localStorage.setItem("isPlaying", "true");
window.location.href="../index.php";
});
}

function renamePlaylist(id,name){
let newName = prompt("Rename Playlist:", name);
if(newName && newName.trim() !== ""){
fetch("rename_playlist.php?id="+id+"&name="+encodeURIComponent(newName))
.then(()=> location.reload());
}
}

</script>

</body>
</html>