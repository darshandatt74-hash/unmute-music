<?php
session_start();
include("../config/db.php");

$playlist_id = intval($_GET['playlist_id']);
$song_id = intval($_GET['song_id']);

mysqli_query($conn,"
DELETE FROM playlist_songs
WHERE playlist_id=$playlist_id
AND song_id=$song_id
");
