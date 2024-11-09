<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comment_id'];
    $user_id = $_SESSION['user_id'];

    // Vérifiez si l'utilisateur a déjà aimé ce commentaire
    $stmt = $pdo->prepare("SELECT * FROM comment_likes WHERE user_id = ? AND comment_id = ?");
    $stmt->execute([$user_id, $comment_id]);
    $liked = $stmt->fetch();

    if ($liked) {
        // Si l'utilisateur a déjà aimé, annulez le like
        $stmt = $pdo->prepare("DELETE FROM comment_likes WHERE user_id = ? AND comment_id = ?");
        $stmt->execute([$user_id, $comment_id]);
        echo 'unliked';
    } else {
        // Sinon, ajoutez le like
        $stmt = $pdo->prepare("INSERT INTO comment_likes (user_id, comment_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $comment_id]);
        echo 'liked';
    }
}
?>