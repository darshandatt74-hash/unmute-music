<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    exit;
}

$user = $_SESSION['user'];
$song_id = intval($_GET['id']);

// prevent duplicate like
$check = mysqli_query($conn,"SELECT * FROM likes WHERE user_email='$user' AND song_id='$song_id'");

if(mysqli_num_rows($check) == 0){
    mysqli_query($conn,"INSERT INTO likes (user_email, song_id) VALUES ('$user','$song_id')");
}

echo "liked";
