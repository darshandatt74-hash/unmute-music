 <?php
include("../config/db.php");

$id = $_GET['id'];

/* Optional safety: prevent admin deletion
if($id == 1){
    header("location:users.php");
    exit;
}
*/

mysqli_query($conn,"DELETE FROM users WHERE id=$id");

header("location:users.php");
