<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $title = $_POST["title"];
    $description = $_POST["description"];
    $link = $_POST["link"];
    $category = $_POST["category"];
    $image = "";

    // Handle image upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $image = time() . "_" . basename($_FILES["image"]["name"]);
        $targetPath = $uploadDir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);
    }

    $stmt = $conn->prepare("INSERT INTO projects (title, description, image, link, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $description, $image, $link, $category);

    if ($stmt->execute()) {
        header("Location: view_project.php");
        exit;
    } else {
        $error = "Failed to add project.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/styles.css">
    <title>Add Project</title>
</head>
<body class="admin-page">
    <div class="admin-container admin-form">
        <h2>Add New Project</h2>
        <?php if ($error) echo "<p class='error-msg'>$error</p>"; ?>
        <form method="POST" action="add_project.php" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" required>

            <label>Description:</label>
            <textarea name="description" rows="4"></textarea>

            <label>Category:</label>
            <input type="text" name="category">

            <label>Link (optional):</label>
            <input type="url" name="link">

            <label>Image:</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">Add Project</button>
        </form>
        <a href="view_project.php">Back to Projects</a>
    </div>
</body>
</html>