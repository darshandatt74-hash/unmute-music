 <?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin'])){
    header("location:login.php");
    exit;
}

$id = $_GET['id'];

// get file name
$row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT file FROM songs WHERE id=$id"));
$filePath = "../assets/music/".$row['file'];

// delete file
if(file_exists($filePath)){
    unlink($filePath);
}

// delete record
mysqli_query($conn,"DELETE FROM songs WHERE id=$id");

header("location:songs.php");
