<?php
session_start();
require 'db.php'; // Connexion à la base de données

// Vérification du rôle de l'utilisateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Récupérer les comptages
$newsCount = $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
$sortiesCount = $pdo->query("SELECT COUNT(*) FROM sorties")->fetchColumn();
$galleryCount = $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
$notifications = $pdo->query("SELECT * FROM notifications WHERE is_read = 0")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@100;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/galerie.css" rel="stylesheet">
</head>
<body>

    <?php require 'navbar.php'; ?>

    <h1 style="text-align: center; margin-top:10px">Tableau de bord Administrateur</h1>

    <div class="container" style="
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 10px;
    ">
        <!-- Actualités -->
        <div class="box" style="
        width: 550px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
        ">
            <i class="fas fa-newspaper" style="font-size: 48px;
    color: #00385EFF;"></i>
            <h3 style="font-size: 21px;margin: 10px 0;">Actualités</h3>
            <p><?= $newsCount ?> publiées</p>
            <a href="add_news.php" class="btn btn-add" style="display: inline-block;
    padding: 5px 30px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
    background-color: #198754;
    ">Ajouter</a>
            <a href="view_news.php" class="btn btn-view" style="display: inline-block;
    padding: 5px 30px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
    background-color: #00385EFF;
    ">Voir</a>
        </div>

        <!-- Sorties -->
        <div class="box" style="
        width: 550px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
        ">
            <i class="fas fa-map" style="font-size: 48px;
    color: #00385EFF;"></i>
            <h3 style="font-size: 21px;margin: 10px 0;">Sorties</h3>
            <p><?= $sortiesCount ?> publiées</p>
            <a href="add_sortie.php" class="btn btn-add" style="display: inline-block;
    padding: 5px 30px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
    background-color: #198754;
    ">Ajouter</a>
            <a href="view_sorties.php" class="btn btn-view" style="display: inline-block;
    padding: 5px 30px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
    background-color: #00385EFF;
    ">Voir</a>
        </div>

        <!-- Galerie -->
        <div class="box" style="width: 550px; padding: 20px; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; position: relative;">
    <i class="fas fa-image" style="font-size: 48px; color: #00385EFF;"></i>
    <h3 style="font-size: 21px;margin: 10px 0;">Galerie</h3>
    <p><?= $galleryCount ?> images</p>
    <a href="add_image.php" class="btn btn-add" style="display: inline-block; padding: 5px 30px; margin: 5px; border: none; border-radius: 5px; color: #ffffff; text-decoration: none; font-weight: bold; background-color: #198754;">Ajouter</a>
    <a href="view_gallery.php" class="btn btn-view" style="display: inline-block; padding: 5px 30px; margin: 5px; border: none; border-radius: 5px; color: #ffffff; text-decoration: none; font-weight: bold; background-color: #00385EFF;">Voir</a>
</div>


        <!-- Notifications -->
        <div class="box" style="
        width: 550px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
        ">
            <i class="fas fa-bell" style="font-size: 48px;
    color: #00385EFF;"></i>
            <h3 style="font-size: 21px;margin: 10px 0;">Notifications</h3>
            <p><?= count($notifications) ?> non lues</p>
            <a href="view_notifications.php" class="btn btn-view" style="display: inline-block;
    padding: 5px 30px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
    background-color: #00385EFF;
    ">Voir</a>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="like.js"></script>
</body>
</html>
