<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));
    $image = $_FILES['image']['name'];

    if (move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image)) {
        $stmt = $pdo->prepare("INSERT INTO news (title, content, image, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$title, $content, $image]);
        header("Location: view_news.php");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Actualité</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Retour au Dashboard</a>
    <h1>Ajouter une Actualité</h1>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Titre" required>
        <textarea name="content" placeholder="Contenu" required></textarea>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Ajouter</button>
    </form>

</body>
</html>
