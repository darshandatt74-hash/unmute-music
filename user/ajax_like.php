<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    echo "LOGIN_REQUIRED";
    exit;
}

$user = $_SESSION['user'];
$song_id = intval($_GET['id']);

/* Check already liked */
$check = mysqli_query($conn,
    "SELECT * FROM user_likes 
     WHERE user_email='$user' AND song_id=$song_id"
);

if(mysqli_num_rows($check) > 0){
    /* Remove like */
    mysqli_query($conn,
        "DELETE FROM user_likes 
         WHERE user_email='$user' AND song_id=$song_id"
    );
    echo "REMOVED";
}else{
    /* Add like */
    mysqli_query($conn,
        "INSERT INTO user_likes(user_email,song_id)
         VALUES('$user',$song_id)"
    );
    echo "ADDED";
}
?>
