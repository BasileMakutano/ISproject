<?php
require "db.php";
$msg = ""; $ok = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $_POST["username"], $_POST["email"], $hash);
    try {
        $stmt->execute();
        $ok = true; $msg = "Account created. You can log in now.";
    } catch (mysqli_sql_exception $e) {
        $msg = ($e->getCode() == 1062) ? "That username is already taken. Try another one." : "Could not create the account. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Create account</title><link rel="stylesheet" href="style.css">
</head><body>
<div class="auth">
  <aside class="auth-side">
    <div class="brand">CAT2 Student Portal</div>
    <div><h1>Join the class feedback board.</h1><p>Create an account to share feedback with your lecturers.</p></div>
    <span></span>
  </aside>
  <main class="auth-main"><div class="card">
    <h2>Create your account</h2>
    <p class="sub">It takes less than a minute.</p>
    <?php if ($msg): ?><div class="alert <?= $ok ? 'ok' : 'err' ?>" role="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <form method="POST">
      <label for="username">Username</label>
      <input id="username" name="username" autocomplete="username" required>
      <label for="email">Email address</label>
      <input id="email" name="email" type="email" autocomplete="email" required>
      <label for="password">Password</label>
      <input id="password" name="password" type="password" minlength="6" autocomplete="new-password" required>
      <div class="hint">Use at least 6 characters.</div>
      <button class="btn" type="submit">Create account</button>
    </form>
    <p class="alt">Already registered? <a href="login.php">Log in</a></p>
  </div></main>
</div>
</body></html>
