<?php
include("config/db.php");

if(!isset($_GET['artist'])){
    header("location:artists.php");
    exit;
}

$artist = $_GET['artist'];

$q = mysqli_query($conn,"
    SELECT * FROM songs 
    WHERE artist='$artist'
");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $artist; ?> Songs</title>
<link rel="stylesheet" href="assets/css/artist_songs.css">
</head>

<body class="dark">

<h1 class="artist-title"><?php echo strtoupper($artist); ?></h1>

<div class="song-list">
<?php while($s = mysqli_fetch_assoc($q)){ ?>
    <div class="song-row">
        <span><?php echo $s['title']; ?></span>
        <a href="player.php?id=<?php echo $s['id']; ?>" class="play-btn">▶ Play</a>
    </div>
<?php } ?>
</div>

<a href="artists.php" class="back">← Back to Artists</a>


</body>
</html>
