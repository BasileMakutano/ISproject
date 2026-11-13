<?php
require "db.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $_POST["username"], $_POST["email"], $hash);
    $msg = $stmt->execute() ? "Account created. You can now log in." : "Error: " . $stmt->error;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
</head>

<body>
    <h2>Sign Up</h2>
    <p>
        <?= htmlspecialchars($msg) ?>
    </p>
    <form method="POST">
        <input name="username" placeholder="Username" required><br>
        <input name="email" type="email" placeholder="Email" required><br>
        <input name="password" type="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
    <a href="login.php">Already registered? Log in</a>
</body>

</html>