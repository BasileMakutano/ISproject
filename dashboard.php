<?php
session_start();
if (!isset($_SESSION["user"])) { header("Location: login.php"); exit; }
require "db.php";
$total = $conn->query("SELECT COUNT(*) c FROM feedback")->fetch_assoc()["c"];
$users = $conn->query("SELECT COUNT(*) c FROM users")->fetch_assoc()["c"];
$u = htmlspecialchars($_SESSION["user"]);
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title><link rel="stylesheet" href="style.css">
</head><body>
<nav class="nav">
  <span class="brand">CAT2 Student Portal</span>
  <a class="link active" href="dashboard.php">Dashboard</a>
  <a class="link" href="feedback.php">Feedback</a>
  <a class="btn ghost" href="logout.php">Log out</a>
</nav>
<div class="wrap">
  <h1>Welcome, <?= $u ?></h1>
  <p class="sub">You are logged in. Here is what is happening on the board.</p>
  <div class="grid">
    <div class="tile dark"><div class="n"><?= (int)$total ?></div>Feedback entries submitted</div>
    <div class="tile"><div class="n"><?= (int)$users ?></div>Registered students</div>
    <div class="tile"><h3>Have something to say?</h3><p class="sub">Tell your lecturers what is working and what is not.</p><a class="btn" href="feedback.php">Share feedback</a></div>
  </div>
</div>
</body></html>
