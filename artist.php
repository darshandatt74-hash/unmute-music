 <?php
include("config/db.php");

if(!isset($_GET['name'])){
    header("location:artists.php");
    exit;
}

$artist = mysqli_real_escape_string($conn, $_GET['name']);

$songs = mysqli_query($conn, "
    SELECT * FROM songs 
    WHERE artist='$artist'
");
?>
<!DOCTYPE html>
<html>
<head>
<title><?= $artist ?> Songs</title>
<link rel="stylesheet" href="assets/css/home.css">
</head>
<body>

<div class="main">
<h2>🎶 <?= $artist ?> Songs</h2>

<div class="cards">
<?php while($s = mysqli_fetch_assoc($songs)) { 
    $img = $s['song_image'] ?? "default.jpg";
?>
    <div class="card">
        <img src="assets/images/songs/<?= $img ?>">
        <h4><?= $s['title'] ?></h4>

        <button class="play-btn"
        onclick="playSong(
            '<?= $s['file'] ?>',
            '<?= $s['title'] ?>',
            '<?= $s['artist'] ?>',
            '<?= $img ?>'
        )">
        ▶ Play
        </button>
    </div>
<?php } ?>
</div>
</div>

<?php include("includes/player_bar.php"); ?>
<script src="assets/js/player.js"></script>


</body>
</html>
