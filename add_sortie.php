<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = htmlspecialchars(trim($_POST['titre']));
    $description = htmlspecialchars(trim($_POST['description']));
    $date_sortie = $_POST['date_sortie'];
    $activites = htmlspecialchars(trim($_POST['activites']));
    $image = $_FILES['image']['name'];

    if (move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image)) {
        $stmt = $pdo->prepare("INSERT INTO sorties (titre, description, date_sortie, activites, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titre, $description, $date_sortie, $activites, $image]);
        header("Location: view_sorties.php");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Sortie</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Retour au Dashboard</a>
    <h1>Ajouter une Sortie</h1>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="titre" placeholder="Titre" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="date" name="date_sortie" required>
        <textarea name="activites" placeholder="Activités" required></textarea>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Ajouter</button>
    </form>

</body>
</html>
