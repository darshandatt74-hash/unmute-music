 <?php
include("../config/db.php");

$q = $_GET['q'];
$playlist_id = intval($_GET['playlist_id']);

$sql="SELECT * FROM songs 
WHERE title LIKE '%$q%' OR artist LIKE '%$q%'
ORDER BY title ASC";

$res=mysqli_query($conn,$sql);

while($s=mysqli_fetch_assoc($res)){

$check=mysqli_query($conn,"
SELECT * FROM playlist_songs
WHERE playlist_id=$playlist_id
AND song_id=".$s['id']);

$added=mysqli_num_rows($check)>0;

?>

<div class="song">

<div>

<div class="song-title"><?php echo $s['title']; ?></div>
<div class="song-artist"><?php echo $s['artist']; ?></div>

</div>

<div class="add-btn <?php if($added) echo 'added'; ?>"

onclick="addSong(<?php echo $s['id']; ?>,this)">

<?php echo $added ? "✔" : "+"; ?>

</div>

</div>

<?php } ?>