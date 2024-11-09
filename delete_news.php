<?php
session_start();
require 'db.php';

// Vérifie si l'utilisateur est un admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM news WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();

    header('Location: dashboard.php');
}
