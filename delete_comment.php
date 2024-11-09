<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentId = $_POST['comment_id'];

    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
    $stmt->bindParam(':id', $commentId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
