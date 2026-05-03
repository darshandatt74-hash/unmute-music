 <?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);

mysqli_query($conn,"DELETE FROM playlist_songs WHERE playlist_id=$id");
mysqli_query($conn,"DELETE FROM user_playlists WHERE id=$id");

header("Location: playlist.php");
exit;
?>