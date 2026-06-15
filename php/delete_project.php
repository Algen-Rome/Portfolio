<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("sql207.infinityfree.com", "if0_42187207", "Algen081002", "if0_42187207_portfolio_database");

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Optional: delete the image file too
    $stmt = $conn->prepare("SELECT image FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if ($row["image"] && file_exists("uploads/" . $row["image"])) {
            unlink("uploads/" . $row["image"]);
        }
    }
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: view_project.php");
exit;
?>