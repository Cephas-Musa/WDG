<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$notifications = $pdo->query("SELECT * FROM notifications WHERE is_read = 0")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['mark_as_read'])) {
    $id = (int)$_GET['mark_as_read'];
    $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: view_notifications.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Retour au Dashboard</a>
    <h1>Notifications</h1>

    <?php if (count($notifications) > 0): ?>
        <ul>
            <?php foreach ($notifications as $notif): ?>
                <li>
                    <?= htmlspecialchars($notif['message']) ?> - 
                    <a href="?mark_as_read=<?= $notif['id'] ?>">Marquer comme lu</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune nouvelle notification.</p>
    <?php endif; ?>

</body>
</html>
