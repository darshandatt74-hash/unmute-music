 <?php
session_start();
include("../config/db.php");

$id = intval($_GET['id']);
$name = mysqli_real_escape_string($conn,$_GET['name']);

mysqli_query($conn,"
UPDATE user_playlists
SET playlist_name='$name'
WHERE id=$id
");