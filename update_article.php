<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: index.php');
    exit();
}

$host = 'localhost';
$dbname = 'wedego';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_POST['author'];

        // Mettre à jour l'article
        $stmt = $pdo->prepare('UPDATE articles SET title = ?, content = ?, author = ? WHERE id = ?');
        $stmt->execute([$title, $content, $author, $id]);

        echo "Article mis à jour avec succès !";
        echo '<br><a href="dashboard.php">Retour au tableau de bord</a>';
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>