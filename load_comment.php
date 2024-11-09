<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $newsId = $_GET['news_id'];

    $stmt = $pdo->prepare("SELECT * FROM comments WHERE news_id = :news_id");
    $stmt->bindParam(':news_id', $newsId);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'comments' => $comments]);
}
?>
