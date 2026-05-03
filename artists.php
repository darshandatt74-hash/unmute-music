<?php
include("config/db.php");

$query = mysqli_query($conn,"
    SELECT artist, artist_image 
    FROM songs 
    GROUP BY artist
");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Artists | UNMUTE</title>

<link rel="stylesheet" href="assets/css/artists.css">
<link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
body{
background:#121212;
font-family:'Poppins',sans-serif;
color:white;
margin:0;
padding:40px 80px;
}

/* TITLE */
.page-title{
margin-bottom:30px;
}

/* SEARCH BAR */
.artist-search{
position:relative;
width:350px;
margin-bottom:50px;
}

.artist-search input{
width:100%;
padding:14px 45px;
border-radius:30px;
border:none;
outline:none;
background:#1f1f1f;
color:white;
font-size:14px;
transition:.3s;
}

.artist-search input:focus{
background:#2a2a2a;
}

.artist-search i{
position:absolute;
left:15px;
top:50%;
transform:translateY(-50%);
color:#b3b3b3;
}

/* GRID */
.artist-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
gap:30px;
}

/* CARD */
.artist-card{
background:#181818;
padding:20px;
border-radius:16px;
text-align:center;
transition:.3s;
}

.artist-card:hover{
background:#242424;
transform:translateY(-6px);
}

.artist-card img{
width:100%;
height:200px;
object-fit:cover;
border-radius:12px;
margin-bottom:15px;
}

.artist-card h3{
margin:10px 0;
font-weight:500;
}

.btn{
display:inline-block;
background:#1db954;
color:black;
padding:10px 25px;
border-radius:30px;
text-decoration:none;
font-size:14px;
transition:.3s;
}

.btn:hover{
transform:scale(1.05);
}

/* BACK */
.back{
display:inline-block;
margin-top:50px;
color:#b3b3b3;
text-decoration:none;
}

.back:hover{
color:#1db954;
}

/* NO RESULT */
.no-result{
display:none;
margin-top:20px;
color:#b3b3b3;
}

/* ===== ARTISTS GRID ===== */

.artist-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
gap:30px;
margin-top:40px;
}

/* ===== ARTIST CARD ===== */

.artist-card{
background:linear-gradient(145deg,#111,#1a1a1a);
border-radius:20px;
padding:18px;
text-align:center;
position:relative;
overflow:hidden;
transition:0.35s;
box-shadow:0 15px 40px rgba(0,0,0,.5);
}

/* HOVER EFFECT */

.artist-card:hover{
transform:translateY(-10px) scale(1.02);
box-shadow:0 25px 60px rgba(0,0,0,.7);
}

/* ===== IMAGE WRAPPER ===== */

.artist-img{
position:relative;
border-radius:16px;
overflow:hidden;
}

/* IMAGE */

.artist-img img{
width:100%;
height:230px;
object-fit:cover;
transition:.4s;
border-radius:16px;
}

/* DARK OVERLAY */

.artist-img::after{
content:'';
position:absolute;
inset:0;
background:rgba(0,0,0,.45);
opacity:0;
transition:.35s;
}

/* PLAY BUTTON */

.artist-play{
position:absolute;
inset:0;
display:flex;
align-items:center;
justify-content:center;
opacity:0;
transform:translateY(15px);
transition:.35s;
}

.artist-play i{
background:#1db954;
width:55px;
height:55px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:18px;
color:#000;
box-shadow:0 10px 30px rgba(0,0,0,.6);
}

/* HOVER IMAGE EFFECT */

.artist-card:hover img{
transform:scale(1.08);
}

.artist-card:hover .artist-img::after{
opacity:1;
}

.artist-card:hover .artist-play{
opacity:1;
transform:translateY(0);
}

/* ===== ARTIST NAME ===== */

.artist-card h3{
margin-top:15px;
font-size:18px;
font-weight:600;
letter-spacing:.5px;
color:#fff;
}

/* ===== BUTTON ===== */

.view-btn{
display:inline-block;
margin-top:12px;
padding:10px 22px;
background:#1db954;
color:#000;
border-radius:30px;
font-weight:600;
font-size:14px;
text-decoration:none;
transition:.3s;
}

.view-btn:hover{
background:#1ed760;
transform:scale(1.05);
box-shadow:0 8px 25px rgba(29,185,84,.6);
}

/* ===== PAGE TITLE ===== */

.page-title{
font-size:28px;
font-weight:700;
margin-bottom:20px;
}

/* ===== RESPONSIVE ===== */

@media(max-width:900px){

.artist-grid{
grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
}

.artist-img img{
height:180px;
}

}

</style>

</head>
<body class="dark">

<h1 class="page-title">🎤 Artists</h1>

<!-- SEARCH BAR -->
<div class="artist-search">
<i class="fa-solid fa-magnifying-glass"></i>
<input type="text" id="artistSearch" placeholder="Search artists...">
</div>

<div class="artist-grid" id="artistGrid">

<?php while($row = mysqli_fetch_assoc($query)){ ?>

    <div class="artist-card animate__animated animate__fadeInUp">

        <img src="assets/images/artists/<?php echo $row['artist_image']; ?>"
             onerror="this.src='assets/images/default_artist.jpg'">

        <h3><?php echo strtoupper($row['artist']); ?></h3>

        <a href="artist_songs.php?artist=<?php echo urlencode($row['artist']); ?>"
           class="btn">
           View Songs
        </a>

    </div>

<?php } ?>

</div>

<div class="no-result" id="noResult">No artist found 🎧</div>

<a href="index.php" class="back">← Back</a>

<script>
const searchInput = document.getElementById("artistSearch");
const cards = document.querySelectorAll(".artist-card");
const noResult = document.getElementById("noResult");

searchInput.addEventListener("keyup", function(){
    const value = this.value.toLowerCase();
    let visibleCount = 0;

    cards.forEach(card=>{
        const name = card.querySelector("h3").innerText.toLowerCase();
        if(name.includes(value)){
            card.style.display="block";
            visibleCount++;
        }else{
            card.style.display="none";
        }
    });

    if(visibleCount === 0){
        noResult.style.display="block";
    }else{
        noResult.style.display="none";
    }
});
</script>

</body>
</html>