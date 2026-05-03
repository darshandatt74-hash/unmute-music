<?php
include("../config/db.php");

$playlist_id=intval($_GET['playlist_id']);
$song_id=intval($_GET['song_id']);

$check=mysqli_query($conn,"
SELECT * FROM playlist_songs
WHERE playlist_id=$playlist_id
AND song_id=$song_id
");

if(mysqli_num_rows($check)==0){

mysqli_query($conn,"
INSERT INTO playlist_songs(playlist_id,song_id)
VALUES($playlist_id,$song_id)
");

}
?>