<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION["user"]) ?>!</h2>
    <p>Login successful.</p>
    <a href="feedback.php">Feedback form</a> | <a href="logout.php">Logout</a>
</body>

</html>