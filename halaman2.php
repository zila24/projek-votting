<?php
// contoh sederhana: nama user yang login
$user = "Wiwit";
?>

<!DOCTYPE html>
<html>
<head>

    <div class="logo">
<title>MyOSIS Vote</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</div>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f3f4f7;
}

/* BORDER LUAR PUTIH */
.border{
    border:10px solid white;
    min-height:100vh;
}

/* SIDEBAR */
.sidebar{
    width:200px;
    height:100vh;
    background:#B9CDEF;
    float:left;
    text-align:center;
}

.sidebar h3{
    margin-top:20px;
}

.menu{
    margin-top:40px;
}

.menu a{
    display:block;
    padding:12px;
    text-decoration:none;
    color:black;
    background:#468CFD;
    margin:5px 0;
}

.menu a:hover{
    background:#315ABF;
    color:white;
}

.logout{
    margin-top:200px;
    
}

.logout button{
    padding:10px 20px;
    border:none;
    background:#2f4f8f;
    color:white;
    border-radius:10px;
    background:#2F4f8f;
    color:white;
}

/* CONTENT */
.content{
    margin-left:200px;
    padding:20px;
}

.header{
    text-align:center;
}

.header h1{
    margin-bottom:5px;
}

.cards{
    display:flex;
    justify-content:center;
    gap:40px;
    margin-top:40px;
}

/* CARD KANDIDAT */
.card{
    width:200px;
    background:white;
    padding:20px;
    text-align:center;
    border-radius:10px;
    box-shadow:0 3px 8px rgba(0,0,0,0.2);
}

.card img{
    width:120px;
    height:150px;
    border-radius:20px;
    background:red;
}

.card button{
    margin-top:10px;
    padding:6px 15px;
    border:none;
    background:#5b8bd9;
    color:white;
    border-radius:5px;
}

.logo-sekolah {
    position: absolute;
    top: 20px;
    right: 20px;
}

</style>
</head>

<body>

<div class="wrapper">

<!-- SIDEBAR -->
<div class="sidebar">

<h3>MyOSIS Vote</h3>
<img src="logomyosis.png" alt="logo" width="100"; height="100">

<div class="logo-sekolah">
                <img src="logosmp.png" alt="Logo Sekolah" style="height: 50px;">
            </div>

<div class="menu">
<a href="#">Votting</a>
<a href="#">Hasil Votting</a>
</div>

<div class="logout">
<p>Hi, <?php echo $user; ?></p>
<button> <i class="fa-solid fa-arrow-left" style="font-size: 9px;"></i>Logout</button>
</div>

</div>

<!-- CONTENT -->
<div class="content">

<div class="header">
<h1>Tentukan Pilihan Mu Sekarang</h1>
<p>Pilih Dengan Visi Misi Yang Tepat</p>
</div>

<div class="cards">

<div class="card">
<img src="nabila.jpeg">
<h3>Nabila Zahra</h3>
<button>Detail</button>
</div>

<div class="card">
<img src="kaizan.jpeg">
<h3>Kaizan Erlangga</h3>
<button>Detail</button>
</div>

<div class="card">
<img src="ivana.jpeg">
<h3>Ivana Gwyneth</h3>
<button>Detail</button>
</div>

</div>

</div>

</div>

</body>
</html>