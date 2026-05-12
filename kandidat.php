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
$user_id = $_SESSION["user_id"];
$event_id = $_GET['event_id'];

// Validate event access
$stmt = $pdo->prepare("
    SELECT * FROM voting_events 
    WHERE id = ? 
      AND is_active = 1 
      AND start_time <= NOW() 
      AND end_time >= NOW()
      AND (group_id IS NULL OR group_id IN (
          SELECT group_id FROM group_user WHERE user_id = ?
      ))
");
$stmt->execute([$event_id, $user_id]);
$event = $stmt->fetch();

if (!$event) {
    header("Location: index.php");
    exit;
}

// Check if already voted
$stmtVote = $pdo->prepare("SELECT 1 FROM votes WHERE user_id = ? AND voting_event_id = ?");
$stmtVote->execute([$user_id, $event_id]);
if ($stmtVote->fetchColumn()) {
    header("Location: hasilvotting.php?event_id=" . urlencode($event_id));
    exit;
}

$stmtOpt = $pdo->prepare("SELECT * FROM options WHERE voting_event_id = ?");
$stmtOpt->execute([$event_id]);
$options = $stmtOpt->fetchAll();
?>
<!DOCTYPE html>
<html>

<head>
    <title>MyOSIS Vote</title>
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

        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 15px;
            border: none;
            background: #5b8bd9;
            color: white;
            border-radius: 5px;
            text-decoration: none;
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
        <div class="sidebar">
            <h3>MyOSIS Vote</h3>
            <img src="logomyosis.png" alt="logo" width="100" height="100">
            <div class="menu">
                <a href="index.php">Voting Events</a>
                <a href="kandidat.php?event_id=<?= htmlspecialchars($event_id) ?>">Votting</a>
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
                <h1>Tentukan Pilihan Mu Sekarang</h1>
                <p><?= htmlspecialchars($event["title"]) ?></p>
            </div>
            <div class="cards">
                <?php foreach ($options as $opt): ?>
                    <div class="card">
                        <?php
                        $photoSrc = "default.jpg";
                        if (!empty($opt["photo"])) {
                            $photoSrc = "../admin-vote/app/" . $opt["photo"];
                        }
                        ?>
                        <img src="<?= htmlspecialchars($photoSrc) ?>" alt="Foto" onerror="this.src='../voting/default.jpg'">
                        <h3><?= htmlspecialchars($opt["candidate_name"]) ?></h3>
                        <a href="detail_kandidat.php?id=<?= $opt["id"] ?>">Detail</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>