<?php
session_start();
include("config/db.php");

$songs = mysqli_query($conn, "SELECT * FROM songs ORDER BY id DESC LIMIT 12");

$trending = mysqli_query($conn,"
SELECT * FROM songs
ORDER BY play_count DESC, id DESC
LIMIT 6
");

$mostPlayed = mysqli_query($conn,"
SELECT * FROM songs
ORDER BY play_count DESC
LIMIT 6
");

$topArtists = mysqli_query($conn,"
SELECT artist, SUM(play_count) as total
FROM songs
GROUP BY artist
ORDER BY total DESC
LIMIT 5
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>UNMUTE MUSIC</title>

<link rel="stylesheet" href="assets/css/home.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* ===== LAYOUT ===== */

.app{
display:flex;
}

/* ===== SIDEBAR ===== */

.sidebar{
width:220px;
background:#000;
height:100vh;
position:fixed;
left:0;
top:0;
padding:25px 20px;
display:flex;
flex-direction:column;
}

.logo{
color:#1db954;
margin-bottom:25px;
}

.sidebar a{
color:#b3b3b3;
text-decoration:none;
margin:8px 0;
display:block;
}

.sidebar a:hover{
color:white;
}

.sidebar-bottom{
margin-top:auto;
}

/* ===== MAIN ===== */

.main{
margin-left:220px;
padding:40px 60px;
width:100%;
}

/* ===== SONG GRID ===== */

.song-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
gap:25px;
}

/* ===== SONG CARD ===== */

.song-card{
background:#111;
border-radius:18px;
padding:14px;
transition:.3s;
}

.song-card:hover{
background:#181818;
transform:translateY(-5px);
}

/* IMAGE */

.song-img-wrapper{
position:relative;
width:100%;
height:260px;
border-radius:14px;
overflow:hidden;
}

.song-img-wrapper img{
width:100%;
height:100%;
object-fit:cover;
}

/* PLAY BUTTON */

.play-hover{
position:absolute;
inset:0;
display:flex;
align-items:center;
justify-content:center;
opacity:0;
transition:.3s;
text-decoration:none;
}

.play-hover i{
width:55px;
height:55px;
background:#1db954;
color:black;
font-size:20px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
}

.song-card:hover .play-hover{
opacity:1;
}

/* TEXT */

.song-card h4{
margin-top:12px;
font-size:15px;
}

.song-card p{
font-size:13px;
color:#aaa;
}

.top-title{
margin-bottom:25px;
}

</style>
</head>

<body>

<div class="app">

<!-- SIDEBAR -->

<div class="sidebar">

<h2 class="logo">🎧 UNMUTE</h2>

<?php
if(isset($_SESSION['user'])){
$email = $_SESSION['user'];
$q = mysqli_query($conn,"SELECT name,profile_pic FROM users WHERE email='$email'");
$u = mysqli_fetch_assoc($q);
?>

<a href="user/profile.php" class="user-box-link">

<div class="user-box">

<?php if($u['profile_pic']){ ?>

<img src="uploads/profile/<?php echo $u['profile_pic']; ?>" class="nav-avatar">

<?php } else { ?>

<div class="avatar-letter">
<?php echo strtoupper(substr($u['name'],0,1)); ?>
</div>

<?php } ?>

<p><?php echo $u['name']; ?></p>

</div>

</a>

<?php } ?>

<a href="index.php">🏠 Home</a>
<a href="search.php">🔍 Search</a>
<a href="artists.php">🎤 Artists</a>

<?php if(isset($_SESSION['user'])){ ?>

<a href="user/playlist.php">🎶 My Playlist</a>
<a href="user/likes.php">❤️ Liked Songs</a>

<?php } else { ?>

<a href="user/login.php">🎶 My Playlist</a>
<a href="user/login.php">❤️ Liked Songs</a>

<?php } ?>

<div class="sidebar-bottom">

<a href="logout.php">🚪 Logout</a>

</div>

</div>

<!-- MAIN -->

<div class="main">

<!-- TODAY'S TOP HITS -->

<div class="top-title">
<h2>Today's Top Hits</h2>
</div>

<div class="song-grid">

<?php while($s = mysqli_fetch_assoc($songs)) {

$img = "assets/images/songs/".$s['song_image'];

if(empty($s['song_image']) || !file_exists($img)){
$img = "assets/images/default-song.png";
}
?>

<div class="song-card">

<div class="song-img-wrapper">

<img src="<?php echo $img; ?>">

<a href="player.php?id=<?php echo $s['id']; ?>" class="play-hover">
<i class="fa-solid fa-play"></i>
</a>

</div>

<h4><?php echo $s['title']; ?></h4>
<p><?php echo $s['artist']; ?></p>

</div>

<?php } ?>

</div>


<!-- TRENDING SONGS -->

<div class="top-title" style="margin-top:40px;">
<h2>Trending Songs</h2>
</div>

<div class="song-grid">

<?php while($s = mysqli_fetch_assoc($trending)) {

$img = "assets/images/songs/".$s['song_image'];

if(empty($s['song_image']) || !file_exists($img)){
$img = "assets/images/default-song.png";
}
?>

<div class="song-card">

<div class="song-img-wrapper">

<img src="<?php echo $img; ?>">

<a href="player.php?id=<?php echo $s['id']; ?>" class="play-hover">
<i class="fa-solid fa-play"></i>
</a>

</div>

<h4><?php echo $s['title']; ?></h4>
<p><?php echo $s['artist']; ?></p>

</div>

<?php } ?>

</div>


<!-- MOST PLAYED SONGS -->

<div class="top-title" style="margin-top:40px;">
<h2>Most Played Songs</h2>
</div>

<div class="song-grid">

<?php while($s = mysqli_fetch_assoc($mostPlayed)) {

$img = "assets/images/songs/".$s['song_image'];

if(empty($s['song_image']) || !file_exists($img)){
$img = "assets/images/default-song.png";
}
?>

<div class="song-card">

<div class="song-img-wrapper">

<img src="<?php echo $img; ?>">

<a href="player.php?id=<?php echo $s['id']; ?>" class="play-hover">
<i class="fa-solid fa-play"></i>
</a>

</div>

<h4><?php echo $s['title']; ?></h4>
<p><?php echo $s['artist']; ?></p>

</div>

<?php } ?>

</div>


<!-- TOP ARTISTS -->

<div class="top-title" style="margin-top:40px;">
<h2>Top Artists</h2>
</div>

<div style="
display:grid;
grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
gap:20px;
">

<?php while($a = mysqli_fetch_assoc($topArtists)){ ?>

<div style="
background:#111;
padding:20px;
border-radius:14px;
text-align:center;
">

<h3><?php echo $a['artist']; ?></h3>

<p style="color:#aaa;">
<?php echo $a['total']; ?> Plays
</p>

</div>

<?php } ?>

</div>

</div>

</div>

<?php include("includes/mini_player.php"); ?>

</body>
</html>