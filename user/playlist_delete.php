 <?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    exit;
}

$user = $_SESSION['user'];
$song_id = $_GET['id'];

mysqli_query($conn,"
DELETE FROM playlist 
WHERE user_email='$user' AND song_id='$song_id'
");
