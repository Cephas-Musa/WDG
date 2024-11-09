<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Récupération des sections existantes dans la galerie pour le formulaire
$sections = $pdo->query("SELECT DISTINCT section FROM gallery")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_FILES['filename']['name'];
    $section = htmlspecialchars($_POST['section']);

    // Vérification et déplacement du fichier dans le répertoire 'uploads'
    if (move_uploaded_file($_FILES['filename']['tmp_name'], "uploads/" . $image)) {
        $stmt = $pdo->prepare("INSERT INTO gallery (filename, section, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$image, $section]);
        header("Location: view_gallery.php");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Image</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Retour au Dashboard</a>
    <h1>Ajouter une Image</h1>

    <form method="POST" enctype="multipart/form-data">
        <label for="section">Section :</label>
        <select name="section" id="section" required>
            <?php foreach ($sections as $sec): ?>
                <option value="<?= htmlspecialchars($sec['section']); ?>"><?= htmlspecialchars($sec['section']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="file" name="filename" accept="image/*,video/*" required>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
