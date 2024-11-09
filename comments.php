<?php
require 'db.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newsId = $_POST['id'];
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');

    $stmt = $pdo->prepare("INSERT INTO comments (news_id, content, created_at) VALUES (?, ?, NOW())");
    $success = $stmt->execute([$newsId, $comment]);

    echo json_encode(['success' => $success]);
}
?>
