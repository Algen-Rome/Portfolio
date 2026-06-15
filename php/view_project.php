<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("sql207.infinityfree.com", "if0_42187207", "Algen081002", "if0_42187207_portfolio_database");

$result = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/styles.css">
    <title>Projects</title>
</head>
<body class="admin-page">
    <div class="admin-container admin-wide">
        <h2>Portfolio Projects</h2>
        <div class="admin-links">
            <a href="add_project.php">+ Add New Project</a>
            <a href="dashboard.php">Back to Dashboard</a>
        </div>
        <table class="admin-table">
            <table class="admin-table">
    <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Category</th>
        <th>Description</th>
        <th>Link</th>
        <th>Date Added</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td>
            <?php if ($row["image"]): ?>
                <img src="uploads/<?= htmlspecialchars($row["image"]) ?>" width="80">
            <?php else: ?>
                No image
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($row["title"]) ?></td>
        <td><?= htmlspecialchars($row["category"]) ?></td>
        <td><?= htmlspecialchars($row["description"]) ?></td>
        <td>
            <?php if ($row["link"]): ?>
                <a href="<?= htmlspecialchars($row["link"]) ?>" target="_blank">View</a>
            <?php endif; ?>
        </td>
        <td><?= $row["created_at"] ?></td>
        <td>
            <a href="edit_project.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="delete_project.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this project?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
        </table>
    </div>
</body>
</html>