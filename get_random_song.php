 <?php
include("config/db.php");

$q = mysqli_query($conn,"SELECT id FROM songs ORDER BY RAND() LIMIT 1");
$row = mysqli_fetch_assoc($q);
echo $row['id'];
?>