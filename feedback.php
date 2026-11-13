<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
require "db.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("INSERT INTO feedback (name, message) VALUES (?,?)");
    $stmt->bind_param("ss", $_POST["name"], $_POST["message"]);
    $msg = $stmt->execute() ? "Feedback saved." : "Error: " . $stmt->error;
}
$rows = $conn->query("SELECT name, message, submitted_at FROM feedback ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Feedback</title>
</head>

<body>
    <h2>Student Feedback</h2>
    <p><?= htmlspecialchars($msg) ?></p>
    <form method="POST">
        <input name="name" placeholder="Your name" required><br>
        <textarea name="message" placeholder="Your feedback" required></textarea><br>
        <button type="submit">Submit</button>
    </form>
    <h3>Submitted feedback</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Name</th>
            <th>Message</th>
            <th>Time</th>
        </tr>
        <?php while ($r = $rows->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($r["name"]) ?></td>
                <td><?= htmlspecialchars($r["message"]) ?></td>
                <td><?= $r["submitted_at"] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">Back</a>
</body>

</html>