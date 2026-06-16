<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style/styles.css">
    <title>Portfolio</title>
</head>

<body>
    <header>
        <nav class="navbar" id="navbar">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    <section id="home" class="home">
        <div class="home-content">
            <img src="assets/Rome.jpg" alt="Profile Picture" class="profile-picture">
            <h1>Hi, I'm <span class="name">Algen</span></h1>
            <p>An aspiring web developer. Explore my work and get in touch!</p>
        </div>
    </section>

    <section id="projects" class="projects">
    <h2>Projects</h2>
    <div class="project-list">
        <?php
try {
    require_once 'php/db_config.php';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $result = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
} catch (Exception $e) {
    echo "<p style='color:red;'>DB Error: " . $e->getMessage() . "</p>";
    $result = false;
}
if ($result):
while ($row = $result->fetch_assoc()):
?>
        <div class="project-card">
            <?php if ($row['image']): ?>
                <img src="php/uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
            <?php endif; ?>
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= htmlspecialchars($row['description']) ?></p>
            <?php if ($row['category']): ?>
                <span class="category"><?= htmlspecialchars($row['category']) ?></span>
            <?php endif; ?>
            <?php if ($row['link']): ?>
                <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank">View Project</a>
            <?php endif; ?>
            <p class="project-date">Added: <?= date("M d, Y", strtotime($row['created_at'])) ?></p>
        </div>
        <?php endwhile; endif; ?>
        <?php $conn->close(); ?>
    </div>
</section>

    <section id="about" class="about">
        <h2>About Me</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel sapien eget nunc efficitur
            tincidunt. Curabitur at felis ac nisi efficitur bibendum. Sed ut perspiciatis unde omnis iste
            natus error sit voluptatem accusantium doloremque laudantium.</p>
    </section>

    <section id="contact" class="contact">
        <h2>Contact Me</h2>
        <div class="contact-info">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Your name here...">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your email here...">
            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="Your message here..."></textarea>
            <button type="submit">Send</button>
        </div>
    </section>
    <footer>
        <div class="social-links">
            <a href="https://github.com/Algen-Rome" target="_blank"><i class="fab fa-github"></i></a>
            <a href="https://www.facebook.com/Gano.AlgenRome.Mari" target="_blank"><i class="fab fa-facebook"></i></a>
        </div>
    </footer>
</body>

</html>