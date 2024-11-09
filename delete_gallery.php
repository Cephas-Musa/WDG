<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Vérification de l'existence de l'ID d'image dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $imageId = intval($_GET['id']);

    // Récupération du nom de fichier de l'image
    $stmt = $pdo->prepare("SELECT filename FROM gallery WHERE id = ?");
    $stmt->execute([$imageId]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification si l'image existe dans la base de données
    if ($image) {
        // Suppression du fichier de l'image dans le dossier "uploads" s'il existe
        $filePath = "uploads/" . $image['filename'];
        if (file_exists($filePath) && is_writable($filePath)) {
            unlink($filePath);
        }

        // Suppression de l'enregistrement dans la base de données
        $deleteStmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $deleteStmt->execute([$imageId]);
    }
}

// Redirection silencieuse vers la galerie
header("Location: view_gallery.php");
exit();
?>
