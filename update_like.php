<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

$user_id = $_SESSION['user_id'] ?? null;
$news_id = $_POST['news_id'] ?? null;
$action = $_POST['action'] ?? null;

if ($user_id && $news_id) {
    if ($action === 'increment') {
        // Ajouter un like
        $stmt = $pdo->prepare("INSERT INTO likes (user_id, news_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $news_id]);
        // Mettre à jour le compteur de likes dans la table news
        $pdo->prepare("UPDATE news SET likes = likes + 1 WHERE id = ?")->execute([$news_id]);
    } elseif ($action === 'decrement') {
        // Supprimer un like
        $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND news_id = ?");
        $stmt->execute([$user_id, $news_id]);
        // Mettre à jour le compteur de likes dans la table news
        $pdo->prepare("UPDATE news SET likes = likes - 1 WHERE id = ?")->execute([$news_id]);
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not logged in or invalid news ID']);
}
?>
