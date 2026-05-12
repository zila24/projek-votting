<?php
session_start();
require_once "koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION["user_name"] ?? "User";
$user_id = $_SESSION["user_id"];
$option_id = $_GET['id'];

// Get option details
$stmtOpt = $pdo->prepare("SELECT * FROM options WHERE id = ?");
$stmtOpt->execute([$option_id]);
$option = $stmtOpt->fetch();

if (!$option) {
    header("Location: index.php");
    exit;
}

$event_id = $option['voting_event_id'];

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
?>
<!DOCTYPE html>
<html>

<head>
    <title>MyOSIS Vote</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f3f4f7;
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
            text-align: center;
            padding-top: 40px;
        }

        .card {
            width: 400px;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 10px auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .foto-box {
            background: #ddd;
            width: 150px;
            height: 160px;
            margin: auto;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .foto-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .nama {
            margin-top: 12px;
            font-weight: bold;
            color: #2a55a4;
        }

        .text {
            text-align: left;
            margin-top: 15px;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
            width: 100%;
        }

        .button-area {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .btn {
            background: #6ea3ff;
            border: none;
            padding: 10px 30px;
            color: white;
            border-radius: 6px;
            font-weight: bold;
            margin: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
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
            <div class="judul">
                <h1>Profil Calon</h1>
                <p>pilih calon yang sesuai dengan visi dan misi</p>
            </div>
            <div class="card">
                <div class="foto-box">
                    <?php
                    $photoSrc = "default.jpg";
                    if (!empty($option["photo"])) {
                        $photoSrc = "../admin-vote/app/" . $option["photo"];
                    }
                    ?>
                    <img src="<?= htmlspecialchars($photoSrc) ?>" onerror="this.src='../voting/default.jpg'">
                </div>
                <div class="nama"><?= htmlspecialchars($option["candidate_name"]) ?></div>
                <div class="text">
                    <b>Dekripsi</b><br>
                    <?= nl2br(htmlspecialchars($option["description"])) ?><br><br>

                </div>
            </div>
            <div class="button-area">
                <form action="vote.php" method="POST" style="display:inline;">
                    <input type="hidden" name="option_id" value="<?= htmlspecialchars($option["id"]) ?>">
                    <button type="submit" class="btn">PILIH</button>
                </form>
                <a href="kandidat.php?event_id=<?= htmlspecialchars($event_id) ?>" class="btn">Kembali</a>
            </div>
        </div>
    </div>
</body>

</html>