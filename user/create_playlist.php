 <?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user'])){
    die("Login Required");
}

$name = mysqli_real_escape_string($conn,$_POST['playlist_name']);
$user = $_SESSION['user'];

mysqli_query($conn,"
    INSERT INTO user_playlists (user_email,playlist_name)
    VALUES ('$user','$name')
");

header("Location: playlist.php");
exit;
?>