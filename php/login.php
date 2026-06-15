<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("sql207.infinityfree.com", "if0_42187207", "Algen081002", "if0_42187207_portfolio_database");

    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/styles.css">
    <title>Admin Login</title>
</head>
<body class="admin-page">
    <div class="admin-container admin-form">
        <h2>Admin Login</h2>
        <?php if ($error) echo "<p class='error-msg'>$error</p>"; ?>
        <form method="POST" action="login.php">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>