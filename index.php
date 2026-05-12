<?php
session_start();
require_once "koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION["user_name"] ?? "User";
$user_id = $_SESSION["user_id"];

// Get available events
$stmt = $pdo->prepare("
    SELECT * FROM voting_events 
    WHERE is_active = 1 
      AND start_time <= NOW() 
      AND end_time >= NOW()
      AND (group_id IS NULL OR group_id IN (
          SELECT group_id FROM group_user WHERE user_id = ?
      ))
");
$stmt->execute([$user_id]);
$events = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>

<head>
    <title>MyOSIS Vote - Events</title>
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

        /* SIDEBAR */
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
            margin-top: 150px;
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

        /* CONTENT */
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
            width: 250px;
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            margin-top: 10px;
            font-size: 18px;
        }

        .card p {
            font-size: 14px;
            color: #555;
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
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
        <!-- SIDEBAR -->
        <div class="sidebar">
            <h3>MyOSIS Vote</h3>
            <img src="logomyosis.png" alt="logo" width="100" height="100">
            <div class="menu">
                <a href="index.php">Voting Events</a>
            </div>
            <div class="logout">
                <p>Hi, <?php echo htmlspecialchars($user); ?></p>
                <a href="logout.php"><i class="fa-solid fa-arrow-left" style="font-size: 12px; margin-right:5px;"></i>Logout</a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <div class="logo-sekolah">
                <img src="logosmp.png" alt="Logo Sekolah" style="height: 50px;">
            </div>
            <div class="header">
                <h1>Available Voting Events</h1>
                <p>Please select an event to cast your vote</p>
            </div>

            <div class="cards">
                <?php if (count($events) > 0): ?>
                    <?php foreach ($events as $event): ?>
                        <div class="card">
                            <h3><?= htmlspecialchars($event['title']) ?></h3>
                            <p><?= htmlspecialchars($event['description'] ?? '') ?></p>
                            <p style="font-size: 12px; color: #888;">Ends: <?= htmlspecialchars($event['end_time']) ?></p>
                            <a href="kandidat.php?event_id=<?= $event['id'] ?>">Enter</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No active voting events available for you right now.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>