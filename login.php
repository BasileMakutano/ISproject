<?php
session_start();
require "db.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $_POST["username"]);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($_POST["password"], $user["password"])) {
        $_SESSION["user"] = $user["username"];
        header("Location: dashboard.php");
        exit;
    }
    $msg = "Username or password is incorrect. Check both and try again.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="auth">
        <aside class="auth-side">
            <div class="brand">Student Portal</div>
            <div>
                <h1>Good to see you again.</h1>
                <p>Log in to read and share class feedback.</p>
            </div>
            <span></span>
        </aside>
        <main class="auth-main">
            <div class="card">
                <h2>Log in</h2>
                <p class="sub">Enter your account details.</p>
                <?php if ($msg): ?>
                    <div class="alert err" role="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
                <form method="POST">
                    <label for="username">Username</label>
                    <input id="username" name="username" autocomplete="username" required autofocus>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required>
                    <button class="btn" type="submit">Log in</button>
                </form>
                <p class="alt">New here? <a href="signup.php">Create an account</a></p>
            </div>
        </main>
    </div>
</body>

</html>