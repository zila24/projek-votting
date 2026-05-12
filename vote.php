<?php
session_start();
require_once "koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["option_id"])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$option_id = $_POST["option_id"];

try {
    $pdo->beginTransaction();

    // Get option and event details
    $stmtOpt = $pdo->prepare("SELECT * FROM options WHERE id = ?");
    $stmtOpt->execute([$option_id]);
    $option = $stmtOpt->fetch();

    if (!$option) {
        throw new Exception("Option not found.");
    }

    $event_id = $option["voting_event_id"];

    // Validate event access
    $stmtEvent = $pdo->prepare("
        SELECT * FROM voting_events 
        WHERE id = ? 
          AND is_active = 1 
          AND start_time <= NOW() 
          AND end_time >= NOW()
          AND (group_id IS NULL OR group_id IN (
              SELECT group_id FROM group_user WHERE user_id = ?
          ))
    ");
    $stmtEvent->execute([$event_id, $user_id]);
    $event = $stmtEvent->fetch();

    if (!$event) {
        throw new Exception("Voting event is not active or you do not have access.");
    }

    // Check if already voted
    $stmtVoteCheck = $pdo->prepare("SELECT 1 FROM votes WHERE user_id = ? AND voting_event_id = ?");
    $stmtVoteCheck->execute([$user_id, $event_id]);
    if ($stmtVoteCheck->fetchColumn()) {
        header("Location: hasilvotting.php?event_id=" . urlencode($event_id));
        exit;
    }

    // Insert vote
    $stmtInsert = $pdo->prepare("INSERT INTO votes (user_id, voting_event_id, option_id, created_at) VALUES (?, ?, ?, NOW())");
    $stmtInsert->execute([$user_id, $event_id, $option_id]);

    $pdo->commit();

    if ($event["show_results"]) {
        header("Location: hasilvotting.php?event_id=" . urlencode($event_id));
    } else {
        // Redirection to a success page or index
        header("Location: index.php?voted=1");
    }
    exit;
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die("Error: " . htmlspecialchars($e->getMessage()));
}
?>
