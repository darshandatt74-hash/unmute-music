<?php
session_start();
include("config/db.php");

/* CHECK ID SAFELY */
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

/* FETCH SONG */
$q = mysqli_query($conn, "SELECT * FROM songs WHERE id=$id");

if(!$q || mysqli_num_rows($q)==0){
    header("Location: index.php");
    exit();
}

$song = mysqli_fetch_assoc($q);

$song_id = intval($_GET['id']);

mysqli_query($conn,"
UPDATE songs 
SET play_count = play_count + 1 
WHERE id = $song_id
");


/* Current Song */
$q = mysqli_query($conn, "SELECT * FROM songs WHERE id=$id");
if(!$q || mysqli_num_rows($q)==0){
    die("Song not found");
}
$song = mysqli_fetch_assoc($q);

$song_id = intval($_GET['id']);

mysqli_query($conn,"
UPDATE songs 
SET play_count = play_count + 1 
WHERE id = $song_id
");


/* TOTAL SONGS */
$totalQ = mysqli_query($conn,"SELECT COUNT(*) as total FROM songs");
$totalRow = mysqli_fetch_assoc($totalQ);
$totalSongs = $totalRow['total'];

/* Next Song */
$nextQ = mysqli_query($conn,"SELECT id FROM songs WHERE id>$id ORDER BY id ASC LIMIT 1");
if($nextQ && mysqli_num_rows($nextQ)>0){
    $nextRow = mysqli_fetch_assoc($nextQ);
    $nextId = $nextRow['id'];
}else{
    $firstQ = mysqli_query($conn,"SELECT id FROM songs ORDER BY id ASC LIMIT 1");
    $firstRow = mysqli_fetch_assoc($firstQ);
    $nextId = $firstRow['id'];
}

/* Previous Song */
$prevQ = mysqli_query($conn,"SELECT id FROM songs WHERE id<$id ORDER BY id DESC LIMIT 1");
if($prevQ && mysqli_num_rows($prevQ)>0){
    $prevRow = mysqli_fetch_assoc($prevQ);
    $prevId = $prevRow['id'];
}else{
    $lastQ = mysqli_query($conn,"SELECT id FROM songs ORDER BY id DESC LIMIT 1");
    $lastRow = mysqli_fetch_assoc($lastQ);
    $prevId = $lastRow['id'];
}

/* Image */
$img = "assets/images/songs/".$song['song_image'];
if(empty($song['song_image']) || !file_exists($img)){
    $img = "assets/images/default-song.png";
}

$file = "assets/songs/".$song['file'];

/* Playlist & Like Check */
$isPlaylist = false;
$isLiked = false;

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];

    $check1 = mysqli_query($conn,"SELECT id FROM playlist WHERE user_email='$user' AND song_id=$id");
    if($check1 && mysqli_num_rows($check1)>0){
        $isPlaylist = true;
    }

    $check2 = mysqli_query($conn,"SELECT id FROM liked_songs WHERE user_email='$user' AND song_id=$id");
    if($check2 && mysqli_num_rows($check2)>0){
        $isLiked = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $song['title']; ?> | UNMUTE</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
body{
margin:0;
font-family:'Poppins',sans-serif;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:#000;
color:white;
overflow:hidden;
}
.bg{
position:fixed;
inset:0;
background:url('<?php echo $img; ?>') center/cover no-repeat;
filter:blur(60px) brightness(0.4);
z-index:-1;
}
.player{
width:360px;
text-align:center;
}
.cover img{
width:260px;
border-radius:20px;
box-shadow:0 20px 60px rgba(0,0,0,.7);
}
.title{
font-size:22px;
font-weight:600;
margin-top:25px;
}
.artist{
opacity:.7;
font-size:14px;
}
.time{
display:flex;
justify-content:space-between;
font-size:12px;
opacity:.7;
margin:10px 0 5px;
}
.progress{
width:100%;
}
.controls{
display:flex;
justify-content:center;
align-items:center;
gap:30px;
margin-top:15px;
}
.controls i{
font-size:22px;
cursor:pointer;
opacity:.8;
transition:.2s;
}
.controls i.active{
color:#1db954;
}
.play-btn{
width:70px;
height:70px;
border-radius:50%;
background:white;
color:black;
display:flex;
justify-content:center;
align-items:center;
font-size:26px;
cursor:pointer;
}
.actions{
display:flex;
justify-content:center;
gap:15px;
margin-top:25px;
}
.action-btn{
padding:10px 20px;
border-radius:30px;
border:none;
cursor:pointer;
font-size:13px;
background:rgba(255,255,255,0.1);
color:white;
}
.action-btn.active{
background:#1db954;
}

.back-btn{
position:absolute;
top:20px;
left:20px;
color:white;
text-decoration:none;
font-size:14px;
background:rgba(0,0,0,.6);
padding:8px 16px;
border-radius:30px;
transition:.3s;
}

.back-btn:hover{
background:#1db954;
}

/* MODAL */
.modal{
display:none;
position:fixed;
inset:0;
background:rgba(0,0,0,.7);
backdrop-filter:blur(8px);
justify-content:center;
align-items:center;
z-index:999;
}

.modal-content{
background:#181818;
padding:30px;
border-radius:16px;
width:300px;
animation:fadeIn .3s ease;
}

@keyframes fadeIn{
from{transform:scale(.8);opacity:0;}
to{transform:scale(1);opacity:1;}
}

.playlist-option{
padding:12px;
margin-bottom:10px;
background:#242424;
border-radius:8px;
cursor:pointer;
transition:.3s;
}

.playlist-option:hover{
background:#1db954;
color:black;
}

.close-btn{
margin-top:10px;
background:#333;
color:white;
border:none;
padding:8px 15px;
border-radius:20px;
cursor:pointer;
}
.control-item{
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
}

.control-item i{
    font-size:20px;
    cursor:pointer;
    opacity:.7;
    transition:.3s;
}

.control-item i:hover{
    opacity:1;
    transform:scale(1.2);
}

.controls i.active{
    color:#1db954;
    opacity:1;
}

/* TOOLTIP */
.tooltip{
    position:absolute;
    bottom:-30px;
    background:#1db954;
    color:black;
    padding:5px 10px;
    border-radius:6px;
    font-size:12px;
    opacity:0;
    transform:translateY(5px);
    transition:.3s;
    white-space:nowrap;
}

.control-item:hover .tooltip{
    opacity:1;
    transform:translateY(0);
}

</style>
</head>

<body>

<div class="bg"></div>

<div class="player">

<div class="cover">
<img src="<?php echo $img; ?>">
</div>

<div class="title"><?php echo $song['title']; ?></div>
<div class="artist"><?php echo $song['artist']; ?></div>

<div class="time">
<span id="current">0:00</span>
<span id="duration">0:00</span>
</div>

<input type="range" id="progress" class="progress" value="0">

<div class="controls">

    <div class="control-item">
        <i class="fa-solid fa-shuffle" id="shuffleBtn"></i>
        <span class="tooltip">Shuffle</span>
    </div>

    <div class="control-item">
        <i class="fa-solid fa-backward" onclick="prevSong()"></i>
        <span class="tooltip">Previous</span>
    </div>

    <div class="play-btn" onclick="togglePlay()" title="Play / Pause">
        <i id="playIcon" class="fa-solid fa-play"></i>
    </div>

    <div class="control-item">
        <i class="fa-solid fa-forward" onclick="nextSong()"></i>
        <span class="tooltip">Next</span>
    </div>

    <div class="control-item">
        <i class="fa-solid fa-repeat" id="repeatBtn"></i>
        <span class="tooltip">Repeat</span>
    </div>

</div>

<div class="actions">
<button class="action-btn" onclick="openPlaylistModal()">
+ Playlist
</button>

<button id="likeBtn"
class="action-btn <?php if($isLiked) echo 'active'; ?>"
onclick="toggleLike(<?php echo $id; ?>)">
❤ Like
</button>
</div>


<!-- PLAYLIST MODAL -->
<div id="playlistModal" class="modal">

<div class="modal-content">
<h3>Select Playlist</h3>

<?php
if(isset($_SESSION['user'])){
$user = $_SESSION['user'];
$plist = mysqli_query($conn,"
SELECT * FROM user_playlists
WHERE user_email='$user'
ORDER BY id DESC
");

while($pl = mysqli_fetch_assoc($plist)){
?>
<div class="playlist-option"
onclick="addToPlaylist(<?php echo $pl['id']; ?>)">
<?php echo htmlspecialchars($pl['playlist_name']); ?>
</div>
<?php
}
}
?>

<button class="close-btn" onclick="closePlaylistModal()">Close</button>
</div>

</div>

<?php
if(isset($_GET['from']) && $_GET['from']=="playlist"){
$back="user/playlist_view.php?id=".$_GET['playlist_id'];
}else{
$back="index.php";
}
?>

<a href="<?php echo $back; ?>">← Back</a>


</div>

<script>

const playIcon = document.getElementById("playIcon");
const progress = document.getElementById("progress");
const currentTimeEl = document.getElementById("current");
const durationEl = document.getElementById("duration");

const shuffleBtn = document.getElementById("shuffleBtn");
const repeatBtn = document.getElementById("repeatBtn");

let totalSongs = <?php echo $totalSongs; ?>;

window.addEventListener("load",()=>{

let playlist = JSON.parse(localStorage.getItem("playlist")) || [];
let currentIndex = parseInt(localStorage.getItem("currentIndex")) || 0;
let songTimes = JSON.parse(localStorage.getItem("songTimes")) || {};

if(playlist.length > 0){

let song = playlist[currentIndex];

audio.src = song.file;

/* RESTORE TIME */
audio.addEventListener("loadedmetadata", function(){

if(songTimes[song.file]){
audio.currentTime = songTimes[song.file];
}

}, { once:true });

}


});

let playlist = [];
<?php
$listQ = mysqli_query($conn,"SELECT id, file, title, artist, song_image FROM songs ORDER BY id ASC");
while($row = mysqli_fetch_assoc($listQ)){
?>
playlist.push({
id: <?php echo $row['id']; ?>,
file: "assets/songs/<?php echo $row['file']; ?>",
title: "<?php echo addslashes($row['title']); ?>",
artist: "<?php echo addslashes($row['artist']); ?>",
image: "assets/images/songs/<?php echo $row['song_image']; ?>"
});
<?php } ?>

localStorage.setItem("playlist", JSON.stringify(playlist));
localStorage.setItem("currentIndex", playlist.findIndex(s => s.id == <?php echo $id; ?>));



/* USE GLOBAL AUDIO ENGINE */
if(!window.globalAudio){
    window.globalAudio = new Audio();
}

const audio = window.globalAudio;

/* =========================
   PERSISTENT STATES
========================= */
let isShuffle = localStorage.getItem("shuffle") === "true";
let isRepeat  = localStorage.getItem("repeat") === "true";

if(isShuffle) shuffleBtn.classList.add("active");
if(isRepeat)  repeatBtn.classList.add("active");

/* =========================
   AUTO PLAY AFTER CHANGE
========================= */
window.addEventListener("load",()=>{
    if(localStorage.getItem("autoPlayNext")==="true"){
        audio.play();
        playIcon.classList.replace("fa-play","fa-pause");
        localStorage.removeItem("autoPlayNext");
    }
});

/* =========================
   FORMAT TIME
========================= */
function formatTime(sec){
    const m = Math.floor(sec/60);
    const s = Math.floor(sec%60);
    return m+":"+(s<10?"0"+s:s);
}

/* =========================
   LOAD META
========================= */
audio.addEventListener("loadedmetadata",()=>{
    durationEl.textContent = formatTime(audio.duration);
});

/* =========================
   TIME UPDATE
========================= */
audio.addEventListener("timeupdate",()=>{
    if(audio.duration){
        progress.value = (audio.currentTime/audio.duration)*100;
        currentTimeEl.textContent = formatTime(audio.currentTime);

        let songTimes = JSON.parse(localStorage.getItem("songTimes")) || {};
        let playlist = JSON.parse(localStorage.getItem("playlist")) || [];
        let currentIndex = parseInt(localStorage.getItem("currentIndex")) || 0;

        let song = playlist[currentIndex];
        songTimes[song.file] = audio.currentTime;
        localStorage.setItem("songTimes", JSON.stringify(songTimes));
    }
});

/* =========================
   SEEK
========================= */
progress.addEventListener("input",()=>{
    if(audio.duration){
        audio.currentTime = (progress.value/100)*audio.duration;
    }
});

/* =========================
   PLAY / PAUSE
========================= */
function togglePlay(){
    if(audio.paused){
        audio.play();
        playIcon.classList.replace("fa-play","fa-pause");
    }else{
        audio.pause();
        playIcon.classList.replace("fa-pause","fa-play");
    }
}

/* =========================
   NEXT
========================= */
function nextSong(){

    localStorage.setItem("autoPlayNext","true");

    if(isShuffle){
        fetch("get_random_song.php")
        .then(res=>res.text())
        .then(id=>{
            window.location.href="player.php?id="+id;
        });
        return;
    }

    window.location.href="player.php?id=<?php echo $nextId; ?>";
}

/* =========================
   PREVIOUS
========================= */
function prevSong(){
    localStorage.setItem("autoPlayNext","true");
    window.location.href="player.php?id=<?php echo $prevId; ?>";
}

/* =========================
   AUTO END BEHAVIOR
========================= */
audio.addEventListener("ended",()=>{
    if(isRepeat){
        audio.currentTime = 0;
        audio.play();
        return;
    }

    nextSong();
});

/* =========================
   SHUFFLE TOGGLE
========================= */
shuffleBtn.addEventListener("click",function(){
    isShuffle=!isShuffle;
    localStorage.setItem("shuffle",isShuffle);
    this.classList.toggle("active");
});

/* =========================
   REPEAT TOGGLE
========================= */
repeatBtn.addEventListener("click",function(){
    isRepeat=!isRepeat;
    localStorage.setItem("repeat",isRepeat);
    this.classList.toggle("active");
});

/* =========================
   TOAST
========================= */
function showToast(msg){
    const toast=document.createElement("div");
    toast.innerText=msg;
    toast.style.position="fixed";
    toast.style.bottom="40px";
    toast.style.left="50%";
    toast.style.transform="translateX(-50%)";
    toast.style.background="#1db954";
    toast.style.padding="12px 25px";
    toast.style.borderRadius="30px";
    toast.style.fontSize="14px";
    toast.style.boxShadow="0 10px 30px rgba(0,0,0,.5)";
    document.body.appendChild(toast);
    setTimeout(()=>toast.remove(),2000);
}

/* =========================
   LIKE
========================= */
function toggleLike(id){
    fetch("user/ajax_like.php?id="+id)
    .then(res=>res.text())
    .then(data=>{
        if(data.trim()==="ADDED"){
            document.getElementById("likeBtn").classList.add("active");
            showToast("❤️ Added to Liked Songs");
        }else{
            document.getElementById("likeBtn").classList.remove("active");
            showToast("❌ Removed from Liked Songs");
        }
    });
}

/* =========================
   PLAYLIST MODAL
========================= */
function openPlaylistModal(){
    document.getElementById("playlistModal").style.display="flex";
}

function closePlaylistModal(){
    document.getElementById("playlistModal").style.display="none";
}

function addToPlaylist(playlistId){
    fetch("user/add_to_playlist.php?playlist_id="+playlistId+"&song_id=<?php echo $id; ?>")
    .then(res=>res.text())
    .then(data=>{
        showToast("🎶 Added to Playlist");
        closePlaylistModal();
    });
}
</script>