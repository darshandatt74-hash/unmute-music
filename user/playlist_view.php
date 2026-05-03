<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
header("Location: login.php");
exit;
}

if(!isset($_GET['id'])){
header("Location: playlist.php");
exit;
}

$playlist_id = intval($_GET['id']);
$user = $_SESSION['user'];

/* Playlist Info */
$plQ = mysqli_query($conn,"
SELECT * FROM user_playlists 
WHERE id=$playlist_id AND user_email='$user'
");

if(mysqli_num_rows($plQ)==0){
header("Location: playlist.php");
exit;
}

$playlist = mysqli_fetch_assoc($plQ);

/* Songs */
$songsQ = mysqli_query($conn,"
SELECT s.*
FROM playlist_songs ps
JOIN songs s ON ps.song_id = s.id
WHERE ps.playlist_id=$playlist_id
ORDER BY ps.id ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $playlist['playlist_name']; ?> | UNMUTE</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>

body{
margin:0;
background:#121212;
color:white;
font-family:'Poppins',sans-serif;
}

.container{
padding:60px 100px;
}

.song-list{
margin-top:30px;
}

.song-item{
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 20px;
background:#181818;
margin-bottom:10px;
border-radius:12px;
}

.song-info{
display:flex;
align-items:center;
gap:15px;
}

.song-info img{
width:50px;
height:50px;
border-radius:6px;
object-fit:cover;
}

.song-title{
font-weight:500;
}

.song-artist{
font-size:13px;
color:#b3b3b3;
}

.song-play{
color:#1db954;
cursor:pointer;
}

.back{
color:#b3b3b3;
text-decoration:none;
display:inline-block;
margin-bottom:20px;
}

.add-song-btn{
background:#1db954;
padding:10px 20px;
border-radius:25px;
color:black;
text-decoration:none;
font-weight:600;
display:inline-flex;
align-items:center;
gap:8px;
}

</style>
</head>

<body>

<div class="container">

<a href="playlist.php" class="back">
<i class="fa-solid fa-arrow-left"></i> Back
</a>

<h2><?php echo htmlspecialchars($playlist['playlist_name']); ?></h2>

<a href="add_songs.php?playlist_id=<?php echo $playlist_id; ?>" class="add-song-btn">
<i class="fa-solid fa-plus"></i> Add Songs
</a>

<div class="song-list">

<?php
$playlistArray = [];

while($song = mysqli_fetch_assoc($songsQ)){

$img = "../assets/images/songs/".$song['song_image'];

if(empty($song['song_image']) || !file_exists($img)){
$img = "../assets/images/default-song.png";
}

$file = "../assets/songs/".$song['file'];

$playlistArray[] = [
"id"=>$song['id'],
"title"=>$song['title'],
"artist"=>$song['artist'],
"file"=>$file,
"image"=>$img
];
?>

<div class="song-item">

<div class="song-info">

<img src="<?php echo $img; ?>">

<div>
<div class="song-title"><?php echo $song['title']; ?></div>
<div class="song-artist"><?php echo $song['artist']; ?></div>
</div>

</div>

<div style="display:flex;gap:15px;align-items:center;">

<div class="song-play"
onclick="playSingle(<?php echo $song['id']; ?>)">
<i class="fa-solid fa-play"></i>
</div>

<div style="color:#b3b3b3;cursor:pointer;"
onclick="removeSong(<?php echo $song['id']; ?>)">
<i class="fa-solid fa-trash"></i>
</div>

</div>

</div>

<?php } ?>

</div>
</div>

<script>

let playlistData = <?php echo json_encode($playlistArray); ?>;

/* PLAY SONG */

function playSingle(id){
window.location.href="../player.php?id="+id+"&from=playlist&playlist_id=<?php echo $playlist_id; ?>";
}

/* REMOVE SONG */

function removeSong(songId){

if(confirm("Remove this song from playlist?")){

fetch("remove_from_playlist.php?playlist_id=<?php echo $playlist_id; ?>&song_id="+songId)
.then(()=>location.reload());

}

}

</script>

</body>
</html>