 <?php
session_start();
include("../config/db.php");

$playlist_id = intval($_GET['playlist_id']);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Add Songs</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<style>

body{
background:#000;
color:white;
font-family:'Poppins',sans-serif;
margin:0;
padding:20px;
}

.header{
display:flex;
align-items:center;
gap:15px;
margin-bottom:20px;
}

.header a{
color:white;
text-decoration:none;
font-size:20px;
}

.search-box input{
width:100%;
padding:12px;
border:none;
border-radius:20px;
background:#111;
color:white;
margin-bottom:20px;
}

.song{
display:flex;
justify-content:space-between;
align-items:center;
padding:12px 0;
border-bottom:1px solid #222;
}

.song-title{
font-size:15px;
}

.song-artist{
font-size:12px;
color:#aaa;
}

.add-btn{
font-size:24px;
cursor:pointer;
}

.added{
color:#1db954;
}

</style>

</head>

<body>

<div class="header">
<a href="playlist_view.php?id=<?php echo $playlist_id; ?>">⬅</a>
<h2>Add Songs</h2>
</div>

<div class="search-box">
<input type="text" id="search" placeholder="Search songs...">
</div>

<div id="songList"></div>

<script>

let playlistId = <?php echo $playlist_id; ?>;

function loadSongs(search=""){

fetch("fetch_songs.php?q="+search+"&playlist_id="+playlistId)

.then(res=>res.text())

.then(data=>{

document.getElementById("songList").innerHTML=data;

});

}

loadSongs();

document.getElementById("search").addEventListener("keyup",function(){

loadSongs(this.value);

});

function addSong(song_id,btn){

fetch("add_to_playlist.php?playlist_id="+playlistId+"&song_id="+song_id)

.then(()=>{

btn.innerHTML="✔";
btn.classList.add("added");

});

}

</script>

</body>
</html>