<?php if(!isset($_SESSION)) session_start(); ?>

<style>
.mini-player{
position:fixed;
bottom:0;
left:0;
right:0;
height:85px;
background:#181818;
border-top:1px solid #282828;
display:none;
align-items:center;
justify-content:space-between;
padding:0 25px;
z-index:9999;
font-family:'Poppins',sans-serif;
color:white;
}

/* LEFT */
.mini-left{
display:flex;
align-items:center;
gap:15px;
width:30%;
}

.mini-left img{
width:55px;
height:55px;
border-radius:6px;
object-fit:cover;
}

.mini-title{font-size:14px;font-weight:500;}
.mini-artist{font-size:12px;color:#b3b3b3;}

/* CENTER */
.mini-center{
display:flex;
flex-direction:column;
align-items:center;
width:40%;
}

.mini-controls{
display:flex;
align-items:center;
gap:22px;
margin-bottom:6px;
}

.mini-controls i{
color:#b3b3b3;
font-size:16px;
cursor:pointer;
transition:.2s;
}

.mini-controls i:hover{color:white;}

.mini-play{
width:38px;
height:38px;
background:white;
color:black;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
cursor:pointer;
}

.mini-play i{font-size:14px;}

.mini-progress{width:100%;}
.mini-progress input{
width:100%;
accent-color:#1db954;
}

/* CLOSE */
.mini-close{
position:absolute;
right:15px;
top:8px;
font-size:14px;
color:#b3b3b3;
cursor:pointer;
}
.mini-close:hover{color:white;}
</style>

<?php if(!isset($_SESSION)) session_start(); ?>

<div class="mini-player" id="miniPlayer" style="display:none;">
<div class="mini-close" onclick="closeMini()">
<i class="fa-solid fa-xmark"></i>
</div>

<div class="mini-left">
<img id="miniImage" src="">
<div>
<div class="mini-title" id="miniTitle"></div>
<div class="mini-artist" id="miniArtist"></div>
</div>
</div>

<div class="mini-center">
<div class="mini-controls">
<i id="shuffleBtn" class="fa-solid fa-shuffle"></i>
<i class="fa-solid fa-backward" onclick="prevSong()"></i>

<div class="mini-play" onclick="togglePlay()">
<i id="miniIcon" class="fa-solid fa-play"></i>
</div>

<i class="fa-solid fa-forward" onclick="nextSong()"></i>
<i id="repeatBtn" class="fa-solid fa-repeat"></i>
</div>

<div class="mini-progress">
<input type="range" id="miniSeek" value="0">
</div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){

const miniPlayer = document.getElementById("miniPlayer");
const miniTitle = document.getElementById("miniTitle");
const miniArtist = document.getElementById("miniArtist");
const miniImage = document.getElementById("miniImage");
const miniIcon = document.getElementById("miniIcon");
const miniSeek = document.getElementById("miniSeek");
const shuffleBtn = document.getElementById("shuffleBtn");
const repeatBtn = document.getElementById("repeatBtn");

/* GLOBAL AUDIO */
if(!window.globalAudio){
    window.globalAudio = new Audio();
}
const audio = window.globalAudio;

/* STORAGE */

window.addEventListener("storage", function(){

playlist = getPlaylist();

if(playlist.length > 0){
miniPlayer.style.display = "flex";
loadSong(parseInt(localStorage.getItem("currentIndex")) || 0, true);
}

});

function getPlaylist(){
return JSON.parse(localStorage.getItem("playlist")) || [];
}

let playlist = getPlaylist();

let currentIndex = parseInt(localStorage.getItem("currentIndex")) || 0;
let isShuffle = localStorage.getItem("isShuffle") === "true";
let isRepeat = localStorage.getItem("isRepeat") === "true";


/* TIME MEMORY */
let songTimes = JSON.parse(localStorage.getItem("songTimes")) || {};

if(playlist.length === 0){
    miniPlayer.style.display="none";
    return;
}

miniPlayer.style.display="flex";
/* FORCE AUTOPLAY AFTER REDIRECT */
if(localStorage.getItem("autoPlay") === "true"){

    setTimeout(()=>{

        if(audio.src){
            audio.play().then(()=>{
                miniIcon.classList.replace("fa-play","fa-pause");
            }).catch(()=>{});
        }else{
            loadSong(currentIndex, true);
        }

        localStorage.removeItem("autoPlay");

    },300);

}

if(isShuffle) shuffleBtn.style.color="#1db954";
if(isRepeat) repeatBtn.style.color="#1db954";

/* LOAD SONG */
function loadSong(index, autoPlay = false){

playlist = getPlaylist();

    currentIndex = index;
    localStorage.setItem("currentIndex", currentIndex);

    let song = playlist[currentIndex];

    if(!song) return;

    audio.src = song.file;

    miniTitle.innerText = song.title;
    miniArtist.innerText = song.artist;
    miniImage.src = song.image;

    audio.addEventListener("loadedmetadata", function(){

        if(songTimes[song.file]){
            audio.currentTime = songTimes[song.file];
        }

        if(autoPlay){
            audio.play().then(()=>{
                miniIcon.classList.replace("fa-play","fa-pause");
            }).catch(()=>{});
        }

    }, { once:true });

}

/* FIRST LOAD */
if(audio.src === ""){

    loadSong(currentIndex);

}

/* HANDLE AUTOPLAY AFTER REDIRECT */
if(localStorage.getItem("autoPlay") === "true"){

    setTimeout(()=>{

        if(audio.src){

            audio.play().then(()=>{
                miniIcon.classList.replace("fa-play","fa-pause");
            }).catch(()=>{});

        }

        localStorage.removeItem("autoPlay");

    },200);

}

/* SAVE TIME */
audio.addEventListener("timeupdate", ()=>{
    let song = playlist[currentIndex];
    songTimes[song.file] = audio.currentTime;
    localStorage.setItem("songTimes", JSON.stringify(songTimes));

    if(audio.duration){
        miniSeek.value = (audio.currentTime/audio.duration)*100;
    }
});

/* SEEK */
miniSeek.addEventListener("input", ()=>{
    if(audio.duration){
        audio.currentTime = (miniSeek.value/100)*audio.duration;
    }
});

/* PLAY / PAUSE */
window.togglePlay = function(){
    if(audio.paused){
        audio.play().then(()=>{
            miniIcon.classList.replace("fa-play","fa-pause");
        });
    }else{
        audio.pause();
        miniIcon.classList.replace("fa-pause","fa-play");
    }
}

/* NEXT */
window.nextSong = function(){

    if(isShuffle){
        currentIndex = Math.floor(Math.random() * playlist.length);
    }else{
        currentIndex++;
        if(currentIndex >= playlist.length){
            currentIndex = 0;
        }
    }

    loadSong(currentIndex, true);
}

/* PREVIOUS */
window.prevSong = function(){

    currentIndex--;

    if(currentIndex < 0){
        currentIndex = playlist.length - 1;
    }

    loadSong(currentIndex, true);
}

/* AUTO END */
audio.addEventListener("ended", ()=>{
    let song = playlist[currentIndex];
    songTimes[song.file] = 0;
    localStorage.setItem("songTimes", JSON.stringify(songTimes));

    if(isRepeat){
        loadSong(currentIndex, true);
    }else{
        nextSong();
    }
});

/* SHUFFLE */
shuffleBtn.addEventListener("click", ()=>{
    isShuffle=!isShuffle;
    localStorage.setItem("isShuffle", isShuffle);
    shuffleBtn.style.color=isShuffle?"#1db954":"#b3b3b3";
});

/* REPEAT */
repeatBtn.addEventListener("click", ()=>{
    isRepeat=!isRepeat;
    localStorage.setItem("isRepeat", isRepeat);
    repeatBtn.style.color=isRepeat?"#1db954":"#b3b3b3";
});

/* CLOSE */
window.closeMini = function(){
    audio.pause();
    miniPlayer.style.display="none";
}

});
</script>