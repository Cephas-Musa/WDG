<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$sorties = $pdo->query("SELECT * FROM sorties ORDER BY date_sortie DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Sorties</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Retour au Dashboard</a>
    <h1>Liste des Sorties</h1>

    <?php foreach ($sorties as $sortie): ?>
        <div class="sortie-item">
            <h3><?= htmlspecialchars($sortie['titre']) ?></h3>
            <p><?= htmlspecialchars($sortie['description']) ?></p>
            <p>Date : <?= htmlspecialchars($sortie['date_sortie']) ?></p>
            <p>Activités : <?= htmlspecialchars($sortie['activites']) ?></p>
            <?php if ($sortie['image']): ?>
                <img src="uploads/<?= htmlspecialchars($sortie['image']) ?>" width="100">
            <?php endif; ?>
            <a href="edit_sortie.php?id=<?= $sortie['id'] ?>">Modifier</a> |
            <a href="delete_sortie.php?id=<?= $sortie['id'] ?>">Supprimer</a>
        </div>
    <?php endforeach; ?>

</body>
</html>
