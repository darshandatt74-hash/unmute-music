<?php
include("../config/db.php");

$users = mysqli_query($conn,"SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Users</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{font-family:Poppins}
body{
    margin:0;
    background:#000;
    color:#fff;
}
.header{
    padding:20px;
    border-bottom:1px solid #222;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.header h2{
    color:#22c55e;
}
.back{
    color:#9ca3af;
    text-decoration:none;
}
.back:hover{color:#22c55e}

.container{
    padding:30px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
    gap:20px;
}

/* USER CARD */
.user-card{
    background:rgba(255,255,255,.07);
    backdrop-filter:blur(12px);
    border-radius:16px;
    padding:20px;
    box-shadow:0 15px 40px rgba(0,0,0,.6);
    display:flex;
    justify-content:space-between;
    align-items:center;
    transition:.3s;
}
.user-card:hover{
    transform:translateY(-3px);
}

/* INFO */
.user-info h3{
    margin:0;
    color:#22c55e;
}
.user-info p{
    margin:5px 0 0;
    font-size:14px;
    opacity:.8;
}

/* DELETE BTN */
.delete-btn{
    background:#ef4444;
    color:#fff;
    border:none;
    padding:10px 14px;
    border-radius:999px;
    cursor:pointer;
    transition:.3s;
}
.delete-btn:hover{
    background:#dc2626;
    transform:scale(1.05);
}
</style>

<script>
function deleteUser(id){
    if(confirm("⚠ Are you sure you want to delete this user?\nThis action cannot be undone!")){
        window.location = "delete_user.php?id=" + id;
    }
}
</script>
</head>

<body>

<div class="header">
    <h2><i class="fa-solid fa-users"></i> Users</h2>
    <a href="dashboard.php" class="back">← Back</a>
</div>

<div class="container">
<?php while($u = mysqli_fetch_assoc($users)){ ?>
    <div class="user-card">
        <div class="user-info">
            <h3><?= strtoupper($u['name']) ?></h3>
            <p><?= $u['email'] ?></p>
        </div>

        <button class="delete-btn" onclick="deleteUser(<?= $u['id'] ?>)">
            <i class="fa-solid fa-trash"></i>
        </button>
    </div>
<?php } ?>
</div>

</body>
</html>
