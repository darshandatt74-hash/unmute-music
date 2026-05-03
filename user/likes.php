<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

/* FIXED QUERY */
$query = mysqli_query($conn,"
    SELECT songs.*
    FROM user_likes 
    JOIN songs ON user_likes.song_id = songs.id
    WHERE user_likes.user_email='$user'
    ORDER BY user_likes.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Liked Songs | UNMUTE</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    background:#121212;
    font-family:'Poppins', sans-serif;
    color:white;
    padding:40px;
}

/* Back */
.back{
    display:inline-block;
    margin-bottom:30px;
    color:#1db954;
    text-decoration:none;
    font-weight:500;
}

/* Header */
.header{
    margin-bottom:30px;
}

.header h1{
    font-size:40px;
    font-weight:700;
    margin:0;
}

.header p{
    color:#b3b3b3;
    margin-top:5px;
    font-size:14px;
}

/* Song List */
.song-list{
    margin-top:20px;
}

/* Song Row */
.song{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:15px 20px;
    border-radius:10px;
    transition:0.3s;
}

.song:hover{
    background:#1a1a1a;
}

/* Left Side */
.song-left{
    display:flex;
    flex-direction:column;
}

.song-title{
    font-size:16px;
    font-weight:500;
    text-transform:none; /* NORMAL LETTERS */
}

.song-artist{
    font-size:13px;
    color:#b3b3b3;
    margin-top:3px;
}

/* Right Side */
.song-actions a{
    text-decoration:none;
    margin-left:20px;
    font-size:14px;
    font-weight:500;
    transition:0.2s;
}

.play{
    color:#1db954;
}

.play:hover{
    opacity:0.8;
}

.remove{
    color:#ff4d4d;
}

.remove:hover{
    opacity:0.8;
}

/* Empty */
.empty{
    color:#b3b3b3;
    margin-top:20px;
}
</style>
</head>

<body>

<a href="../index.php" class="back">← Back to Home</a>

<div class="header">
    <h1>Liked Songs</h1>
    <p><?php echo mysqli_num_rows($query); ?> songs</p>
</div>

<div class="song-list">

<?php
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
?>
    <div class="song">
        <div class="song-left">
            <div class="song-title">
                <?php echo htmlspecialchars($row['title']); ?>
            </div>
            <div class="song-artist">
                <?php echo htmlspecialchars($row['artist']); ?>
            </div>
        </div>

        <div class="song-actions">
            <a class="play" href="../player.php?id=<?php echo $row['id']; ?>">
                ▶ Play
            </a>
            <a class="remove" href="remove_like.php?id=<?php echo $row['id']; ?>">
                Remove
            </a>
        </div>
    </div>
<?php
    }
}else{
    echo "<div class='empty'>No liked songs yet.</div>";
}
?>

</div>

</body>
</html>