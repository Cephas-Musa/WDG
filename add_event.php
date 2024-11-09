<?php
session_start();
require 'db.php';

// Vérifie si l'utilisateur est un admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $stmt = $pdo->prepare("INSERT INTO events (title, description, date) VALUES (:title, :description, :date)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $date);
    $stmt->execute();

    header('Location: dashboard.php');
}
