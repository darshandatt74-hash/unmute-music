 <?php
session_start();
include("../config/db.php");

$id = intval($_GET['id']);

$q = mysqli_query($conn,"
SELECT s.id, s.title, s.artist, s.file, s.song_image
FROM playlist_songs ps
JOIN songs s ON ps.song_id = s.id
WHERE ps.playlist_id=$id
ORDER BY ps.id ASC
");

$playlist = [];

while($row = mysqli_fetch_assoc($q)){
$playlist[] = [
"id"=>$row['id'],
"title"=>$row['title'],
"artist"=>$row['artist'],
"file"=>"assets/songs/".$row['file'],
"image"=>"assets/images/songs/".$row['song_image']
];
}

echo json_encode($playlist);