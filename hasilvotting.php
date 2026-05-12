<?php
session_start();
require_once "koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['event_id'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION["user_name"] ?? "User";
$event_id = $_GET['event_id'];

// Fetch event details
$stmtEvent = $pdo->prepare("SELECT * FROM voting_events WHERE id = ?");
$stmtEvent->execute([$event_id]);
$event = $stmtEvent->fetch();

if (!$event) {
    header("Location: index.php");
    exit;
}

// Fetch total votes
$stmtTotal = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE voting_event_id = ?");
$stmtTotal->execute([$event_id]);
$total_votes = $stmtTotal->fetchColumn();

// Fetch options & counts
$stmtOpt = $pdo->prepare("
    SELECT o.*, COUNT(v.id) as vote_count 
    FROM options o 
    LEFT JOIN votes v ON o.id = v.option_id 
    WHERE o.voting_event_id = ? 
    GROUP BY o.id
");
$stmtOpt->execute([$event_id]);
$options = $stmtOpt->fetchAll();
?>
<!DOCTYPE html>
<html>

<head>
    <title>MyOSIS Vote - Hasil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f3f4f7;
        }

        .wrapper {
            min-height: 100vh;
        }

        .sidebar {
            width: 200px;
            height: 100vh;
            background: #B9CDEF;
            float: left;
            text-align: center;
            position: fixed;
        }

        .sidebar h3 {
            margin-top: 20px;
        }

        .menu {
            margin-top: 40px;
        }

        .menu a {
            display: block;
            padding: 12px;
            text-decoration: none;
            color: black;
            background: #468CFD;
            margin: 5px 0;
        }

        .menu a:hover {
            background: #315ABF;
            color: white;
        }

        .logout {
            margin-top: 200px;
        }

        .logout a {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            background: #2f4f8f;
            color: white;
            border-radius: 10px;
            text-decoration: none;
        }

        .content {
            margin-left: 200px;
            padding: 20px;
        }

        .header {
            text-align: center;
        }

        .header h1 {
            margin-bottom: 5px;
        }

        .cards {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .card {
            width: 200px;
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 120px;
            height: 150px;
            border-radius: 20px;
            object-fit: cover;
        }

        .card .btn-info {
            margin-top: 10px;
            padding: 6px 15px;
            border: none;
            background: #5b8bd9;
            color: white;
            border-radius: 5px;
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .logo-sekolah {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .alert-box {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .alert-box a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #468CFD;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar">
            <h3>MyOSIS Vote</h3>
            <img src="logomyosis.png" alt="logo" width="100" height="100">
            <div class="menu">
                <a href="index.php">Voting Events</a>
            </div>
            <div class="logout">
                <p>Hi, <?= htmlspecialchars($user); ?></p>
                <a href="logout.php"><i class="fa-solid fa-arrow-left" style="font-size: 9px; margin-right:5px;"></i> Logout</a>
            </div>
        </div>
        <div class="content">
            <div class="logo-sekolah">
                <img src="logosmp.png" alt="Logo Sekolah" style="height: 50px;">
            </div>
            <div class="header">
                <h1>Hasil Voting: <?= htmlspecialchars($event["title"]) ?></h1>
            </div>

            <?php if ($event["show_results"]): ?>
                <div class="cards">
                    <?php foreach ($options as $opt):
                        $percent = $total_votes > 0 ? round(($opt["vote_count"] / $total_votes) * 100, 1) : 0;
                        $photoSrc = "default.jpg";
                        if (!empty($opt["photo"])) {
                            $photoSrc = ".../admin-vote/public/storage/app/" . $opt["photo"];
                        }
                    ?>
                        <div class="card">
                            <img src="<?= htmlspecialchars($photoSrc) ?>" onerror="this.src='../voting/default.jpg'">
                            <h3><?= htmlspecialchars($opt["candidate_name"]) ?></h3>
                            <div class="btn-info"><?= $percent ?>% Suara</div>
                            <div class="btn-info"><?= $opt["vote_count"] ?> Orang</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert-box">
                    <h2>Terima Kasih Telah Memilih!</h2>
                    <p>Hasil voting untuk event ini bersifat rahasia dan tidak ditampilkan untuk publik saat ini.</p>
                    <a href="index.php">Kembali ke Beranda</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>