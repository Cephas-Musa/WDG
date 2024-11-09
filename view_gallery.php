<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$sections = $pdo->query("SELECT DISTINCT section FROM gallery")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Galerie</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Retour au Dashboard</a>
    <h1 style="text-align: center;">Galerie</h1>

    <?php foreach ($sections as $section): ?>
        <h2><?= htmlspecialchars($section['section']) ?></h2>
        <?php
        $images = $pdo->prepare("SELECT * FROM gallery WHERE section = ? ORDER BY created_at DESC");
        $images->execute([$section['section']]);
        ?>
        <?php foreach ($images as $image): ?>
            <div class="gallery-item" style="
    display: flex;
    gap: 10px;
    justify-content: center;
    padding: 10px;
    ">
                <img src="uploads/<?= htmlspecialchars($image['filename']) ?>" style="width: 700px; height: 400px; object-fit:cover;">
                <a href="delete_gallery.php?id=<?= $image['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?');" style="display: inline-block;
    padding: 5px 30px;
    height: 31px;
    font-family: sans-serif;
    margin: 5px;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
    background-color: #871919FF;" >Supprimer</a>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</body>
</html>
