<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newsId = $_POST['news_id'];
    $comment = $_POST['comment'];

    $stmt = $pdo->prepare("INSERT INTO comments (news_id, comment) VALUES (:news_id, :comment)");
    $stmt->bindParam(':news_id', $newsId);
    $stmt->bindParam(':comment', $comment);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
