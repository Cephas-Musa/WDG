<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Non connecté']);
    exit;
}

$userId = $_SESSION['user_id'];
$postId = $_POST['id'];
$liked = filter_var($_POST['liked'], FILTER_VALIDATE_BOOLEAN);

// Récupérer l'état de "J'aime" de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM likes WHERE user_id = :user_id AND news_id = :news_id");
$stmt->execute(['user_id' => $userId, 'news_id' => $postId]);
$like = $stmt->fetch();

if ($liked) {
    // Si l'utilisateur aime déjà, annulez son "J'aime"
    if ($like) {
        $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = :user_id AND news_id = :news_id");
        $stmt->execute(['user_id' => $userId, 'news_id' => $postId]);
        $stmt = $pdo->prepare("UPDATE news SET likes = likes - 1 WHERE id = :id");
        $stmt->execute(['id' => $postId]);
    }
} else {
    // Si l'utilisateur n'aime pas encore, ajoutez son "J'aime"
    if (!$like) {
        $stmt = $pdo->prepare("INSERT INTO likes (user_id, news_id) VALUES (:user_id, :news_id)");
        $stmt->execute(['user_id' => $userId, 'news_id' => $postId]);
        $stmt = $pdo->prepare("UPDATE news SET likes = likes + 1 WHERE id = :id");
        $stmt->execute(['id' => $postId]);
    }
}

// Récupérer le nombre de "J'aime" actuel
$stmt = $pdo->prepare("SELECT likes FROM news WHERE id = :id");
$stmt->execute(['id' => $postId]);
$likes = $stmt->fetchColumn();

// Renvoyer le nouveau nombre de "J'aime" au format JSON
echo json_encode(['likes' => $likes]);
