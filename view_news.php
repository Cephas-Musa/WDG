<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$news = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Actualités</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Retour au Dashboard</a>
    <h1>Liste des Actualités</h1>

    <?php foreach ($news as $new): ?>
        <div class="news-item">
            <h3><?= htmlspecialchars($new['title']) ?></h3>
            <p><?= htmlspecialchars($new['content']) ?></p>
            <?php if ($new['image']): ?>
                <img src="uploads/<?= htmlspecialchars($new['image']) ?>" width="100">
            <?php endif; ?>
            <a href="edit_news.php?id=<?= $new['id'] ?>">Modifier</a> |
            <a href="delete_news.php?id=<?= $new['id'] ?>">Supprimer</a>
        </div>
    <?php endforeach; ?>

</body>
</html>
