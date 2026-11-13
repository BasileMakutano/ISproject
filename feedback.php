<?php
session_start();
if (!isset($_SESSION["user"])) { header("Location: login.php"); exit; }
require "db.php";
$msg = ""; $ok = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("INSERT INTO feedback (name, message) VALUES (?,?)");
    $stmt->bind_param("ss", $_POST["name"], $_POST["message"]);
    if ($stmt->execute()) { $ok = true; $msg = "Feedback submitted. Thank you!"; }
    else { $msg = "Could not save your feedback. Please try again."; }
}
$rows = $conn->query("SELECT name, message, submitted_at FROM feedback ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Feedback</title><link rel="stylesheet" href="style.css">
</head><body>
<nav class="nav">
  <span class="brand">CAT2 Student Portal</span>
  <a class="link" href="dashboard.php">Dashboard</a>
  <a class="link active" href="feedback.php">Feedback</a>
  <a class="btn ghost" href="logout.php">Log out</a>
</nav>
<div class="wrap">
  <h1>Share your feedback</h1>
  <p class="sub">Be specific. Your lecturers read every entry.</p>
  <div class="panel">
    <?php if ($msg): ?><div class="alert <?= $ok ? 'ok' : 'err' ?>" role="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <form method="POST">
      <label for="name">Your name</label>
      <input id="name" name="name" value="<?= htmlspecialchars($_SESSION['user']) ?>" required>
      <label for="message">Your feedback</label>
      <textarea id="message" name="message" required></textarea>
      <button class="btn" type="submit">Submit feedback</button>
    </form>
  </div>
  <h2>What others said</h2><br>
  <?php if ($rows->num_rows === 0): ?>
    <div class="empty">No feedback yet. Be the first to share.</div>
  <?php else: while ($r = $rows->fetch_assoc()): ?>
    <div class="entry"><b><?= htmlspecialchars($r["name"]) ?></b>
      <div><?= nl2br(htmlspecialchars($r["message"])) ?></div>
      <time><?= htmlspecialchars($r["submitted_at"]) ?></time></div>
  <?php endwhile; endif; ?>
</div>
</body></html>
