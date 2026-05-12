<?php
session_start();
require_once "koneksi.php";

$error = false;

if (isset($_POST["login"])) {
    $nama = $_POST["nama"];
    $kode = $_POST["kode"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$nama]);
    $user = $stmt->fetch();

    if ($user && password_verify($kode, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        header("Location: index.php");
        exit;
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>MyOSIS Vote</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial;
        }

        body {
            background: #f3f4f7;
        }

        .header {
            text-align: center;
            padding-top: 30px;
            position: relative;
        }

        .header h1 {
            font-size: 40px;
            font-weight: 600;
            color: #333;
        }

        .header p {
            font-size: 18px;
            margin-top: 8px;
            color: #555;
        }

        .logo-kiri {
            position: absolute;
            left: 40px;
            top: 10px;
            text-align: center;
        }

        .logo-kiri h3 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .logo-kiri img {
            width: 130px;
        }

        .logo-kanan {
            position: absolute;
            right: 40px;
            top: 20px;
        }

        .logo-kanan img {
            width: 90px;
        }

        .login-box,
        .error-box {
            width: 380px;
            background: white;
            margin: 60px auto;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .login-box img,
        .error-icon img {
            width: 90px;
            margin-bottom: 10px;
        }

        .login-box h2 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .login-box p {
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
        }

        .input-box {
            margin: 15px 0;
        }

        .input-box input {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            font-size: 15px;
            outline: none;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: #5a78d6;
            color: white;
            font-size: 16px;
            margin-top: 15px;
            cursor: pointer;
        }

        button:hover {
            background: #4a66c2;
        }

        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #777;
        }

        .footer hr {
            margin: 15px 0;
            border: 0.5px solid #ddd;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo-kiri">
            <h3>MyOSIS Vote</h3>
            <img src="myosis_votebg.png">
        </div>

        <h1>Pemilihan Ketua OSIS<br>SMP N 1 Kandeman</h1>
        <p>Satu Suara, satu pilihan, Untuk OSIS Masa Depan</p>

        <div class="logo-kanan">
            <img src="spensaka.png">
        </div>
    </div>

    <?php if ($error): ?>
        <div class="error-box">
            <div class="error-icon">
                <img src="error.jpg" alt="error">
            </div>
            <h2>UPS!<br>Login Gagal</h2>
            <p>Login anda tidak di terima oleh sistem</p>
            <form action="" method="GET">
                <button>Login Ulang</button>
            </form>
            <div class="footer">
                <hr>
                By Kelompok 5. 2025
            </div>
        </div>
    <?php else: ?>
        <div class="login-box">
            <img src="spensaka.png">
            <h2>Welcome</h2>
            <p>Login untuk memilih kandidat terbaik</p>
            <form method="POST">
                <div class="input-box">
                    <input type="text" name="nama" placeholder="Name" required>
                </div>
                <div class="input-box">
                    <input type="password" name="kode" placeholder="kode" required>
                </div>
                <button type="submit" name="login">Sign In</button>
            </form>
            <div class="footer">
                <hr>
                By Kelompok 5. 2025
            </div>
        </div>
    <?php endif; ?>

</body>

</html>