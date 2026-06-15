<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("sql207.infinityfree.com", "if0_42187207", "Algen081002", "if0_42187207_portfolio_database");
$error = "";

if (!isset($_GET["id"])) {
    header("Location: view_project.php");
    exit;
}

$id = $_GET["id"];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $link = $_POST["link"];
    $category = $_POST["category"];

    // Get current image (in case no new image is uploaded)
    $stmt = $conn->prepare("SELECT image FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $current = $stmt->get_result()->fetch_assoc();
    $image = $current["image"];
    $stmt->close();

    // If a new image was uploaded, replace it
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Delete old image
        if ($image && file_exists($uploadDir . $image)) {
            unlink($uploadDir . $image);
        }

        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDir . $image);
    }

    $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, image=?, link=?, category=? WHERE id=?");
    $stmt->bind_param("sssssi", $title, $description, $image, $link, $category, $id);

    if ($stmt->execute()) {
        header("Location: view_project.php");
        exit;
    } else {
        $error = "Failed to update project.";
    }
    $stmt->close();
}

// Fetch current project data to pre-fill the form
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$project = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$project) {
    header("Location: view_project.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/styles.css">
    <title>Edit Project</title>
</head>
<body class="admin-page">
    <div class="admin-container admin-form">
        <h2>Edit Project</h2>
        <?php if ($error) echo "<p class='error-msg'>$error</p>"; ?>
        <form method="POST" action="edit_project.php?id=<?= $project['id'] ?>" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required>

            <label>Description:</label>
            <textarea name="description" rows="4"><?= htmlspecialchars($project['description']) ?></textarea>

            <label>Category:</label>
            <input type="text" name="category" value="<?= htmlspecialchars($project['category']) ?>">

            <label>Link (optional):</label>
            <input type="url" name="link" value="<?= htmlspecialchars($project['link']) ?>">

            <label>Current Image:</label>
            <?php if ($project['image']): ?>
                <img src="uploads/<?= htmlspecialchars($project['image']) ?>" class="current-image">
            <?php else: ?>
                <p>No image</p>
            <?php endif; ?>

            <label>Replace Image (optional):</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">Update Project</button>
        </form>
        <a href="view_project.php">Back to Projects</a>
    </div>
</body>
</html>