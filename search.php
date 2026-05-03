<?php
session_start();
include("config/db.php");

$search = "";
if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn,$_GET['search']);
    $songs = mysqli_query($conn,"
        SELECT * FROM songs 
        WHERE title LIKE '%$search%' 
        OR artist LIKE '%$search%'
    ");
} else {
    $songs = mysqli_query($conn,"SELECT * FROM songs ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Search | UNMUTE</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/search.css">
</head>

<body>

<!-- TOP BAR -->
<div class="topbar">
    <a href="index.php" class="back-btn">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h2>🔍 Search Songs</h2>
</div>

<!-- MAIN -->
<div class="main">

<form method="GET" class="search-box">
    <i class="fa fa-search"></i>
    <input type="text" name="search" placeholder="Search song or artist..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

<div class="song-grid">

<?php while($row = mysqli_fetch_assoc($songs)){ ?>
    <div class="song-card" data-aos="zoom-in">
        <h3><?= $row['title'] ?></h3>
        <p><?= $row['artist'] ?></p>

        <a href="player.php?id=<?= $row['id'] ?>" class="play-btn">
            <i class="fa fa-play"></i> Play
        </a>
    </div>
<?php } ?>

<?php if(mysqli_num_rows($songs) == 0){ ?>
    <p class="no-result">No songs found 😢</p>
<?php } ?>

</div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, once:true });
</script>
<?php include("includes/mini_player.php"); ?>

</body>
</html>
