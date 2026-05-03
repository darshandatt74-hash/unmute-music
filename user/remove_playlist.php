<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$song_id = intval($_GET['id']);

mysqli_query($conn,
    "DELETE FROM user_playlist 
     WHERE user_email='$user' 
     AND song_id='$song_id'"
);

header("Location: playlist.php");
exit;
?>
