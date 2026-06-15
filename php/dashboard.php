<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/styles.css">
    <title>Admin Dashboard</title>
</head>
<body class="admin-page">
    <div class="admin-container">
        <h2>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>!</h2>
        <p>This is your admin panel.</p>
        <div class="admin-links">
            <a href="view_project.php">Manage Projects</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>