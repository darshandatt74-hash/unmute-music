<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    echo "LOGIN_REQUIRED";
    exit;
}

$user = $_SESSION['user'];
$song_id = intval($_GET['id']);

$check = mysqli_query($conn,
    "SELECT * FROM user_playlist
     WHERE user_email='$user' AND song_id=$song_id"
);

if(mysqli_num_rows($check) > 0){
    mysqli_query($conn,
        "DELETE FROM user_playlist
         WHERE user_email='$user' AND song_id=$song_id"
    );
    echo "REMOVED";
}else{
    mysqli_query($conn,
        "INSERT INTO user_playlist(user_email,song_id)
         VALUES('$user',$song_id)"
    );
    echo "ADDED";
}
?>
