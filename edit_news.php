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

    // Récupérer l'article avec l'ID
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            echo "Article introuvable.";
            exit();
        }
    } else {
        echo "ID manquant.";
        exit();
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'article</title>
</head>
<body>
    <h1>Modifier l'article</h1>
    <form action="update_article.php" method="POST">
        <input type="hidden" name="id" value="<?= $article['id']; ?>">

        <label for="title">Titre :</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($article['title']); ?>" required><br><br>

        <label for="content">Contenu :</label><br>
        <textarea id="content" name="content" rows="5" cols="40" required><?= htmlspecialchars($article['content']); ?></textarea><br><br>

        <label for="author">Auteur :</label><br>
        <input type="text" id="author" name="author" value="<?= htmlspecialchars($article['author']); ?>"><br><br>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
