<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin'])){
    header("location:login.php");
    exit;
}

$totalUsers = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM users"));
$totalSongs = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM songs"));
?>
<!DOCTYPE html>
<html>
<head>
<title>UNMUTE Admin Dashboard</title>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}
body{
    background:linear-gradient(135deg,#0b0b0b,#101010);
    color:#fff;
    min-height:100vh;
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    background:#0e0e0e;
    border-right:1px solid #222;
    padding:30px 20px;
}
.logo{
    font-size:22px;
    font-weight:700;
    color:#1db954;
    margin-bottom:40px;
}
.logo i{margin-right:8px;}

.menu a{
    display:flex;
    align-items:center;
    gap:14px;
    padding:14px 16px;
    margin-bottom:10px;
    border-radius:12px;
    text-decoration:none;
    color:#bbb;
    transition:.3s;
}
.menu a:hover{
    background:#1db954;
    color:#000;
}
.menu a i{
    width:20px;
    text-align:center;
}

/* MAIN */
.main{
    flex:1;
    padding:30px 40px;
}

/* TOP BAR */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}
.topbar h2{
    font-size:26px;
    font-weight:600;
}
.admin{
    display:flex;
    align-items:center;
    gap:10px;
    color:#aaa;
}

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}
.card{
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(20px);
    border-radius:20px;
    padding:25px;
    box-shadow:0 20px 60px rgba(0,0,0,.6);
    transition:.4s;
}
.card:hover{
    transform:translateY(-8px);
}
.card i{
    font-size:30px;
    color:#1db954;
}
.card h3{
    margin-top:15px;
    font-size:16px;
    color:#aaa;
}
.card span{
    font-size:38px;
    font-weight:700;
}

/* QUICK ACTIONS */
.actions{
    margin-top:50px;
}
.actions h3{
    margin-bottom:20px;
}
.action-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}
.action{
    padding:25px;
    border-radius:16px;
    background:#121212;
    text-decoration:none;
    color:#fff;
    transition:.3s;
}
.action:hover{
    background:#1db954;
    color:#000;
}
.action i{
    font-size:26px;
    margin-bottom:10px;
    display:block;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo">
        <i class="fa-solid fa-headphones"></i> UNMUTE
    </div>

    <div class="menu">
        <a href="index.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
        <a href="users.php"><i class="fa-solid fa-users"></i> Users</a>
        <a href="add_song.php"><i class="fa-solid fa-upload"></i> Upload Song</a>
        <a href="songs.php"><i class="fa-solid fa-music"></i> Manage Songs</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">

    <!-- TOP BAR -->
    <div class="topbar">
        <h2>Admin Dashboard</h2>
        <div class="admin">
            <i class="fa-solid fa-user-shield"></i> Admin
        </div>
    </div>

    <!-- STATS -->
    <div class="stats">
        <div class="card">
            <i class="fa-solid fa-users"></i>
            <h3>Total Users</h3>
            <span><?php echo $totalUsers; ?></span>
        </div>

        <div class="card">
            <i class="fa-solid fa-music"></i>
            <h3>Total Songs</h3>
            <span><?php echo $totalSongs; ?></span>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="actions">
        <h3>Quick Actions</h3>
        <div class="action-grid">
            <a href="add_song.php" class="action">
                <i class="fa-solid fa-upload"></i>
                Upload New Song
            </a>

            <a href="songs.php" class="action">
                <i class="fa-solid fa-music"></i>
                Manage Songs
            </a>

            <a href="users.php" class="action">
                <i class="fa-solid fa-users"></i>
                View Users
            </a>
        </div>
    </div>

</div>

</body>
</html>
