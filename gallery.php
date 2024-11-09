<?php
require 'db.php';

// Récupérer tout le contenu de la galerie.
$gallery = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Styles externes -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@100;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <h1 class="display-5 text-capitalize mb-3 text-center mt-4">WEDEGO <span class="text-primary">gallery</span></h1>

    <div class="grid grid-cols-3 gap-4 p-5">
        <?php foreach ($gallery as $item): ?>
            <div class="relative group">
                <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $item['filename'])): ?>
                    <img src="uploads/<?= $item['filename']; ?>" alt="<?= htmlspecialchars($item['description']); ?>" class="w-full h-48 object-cover rounded-lg">
                <?php elseif (preg_match('/\.(mp4|mov)$/i', $item['filename'])): ?>
                    <video controls class="w-full h-48 object-cover rounded-lg">
                        <source src="uploads/<?= $item['filename']; ?>" type="video/mp4">
                    </video>
                <?php endif; ?>

                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-lg px-2">
                    <p class="text-center"><?= htmlspecialchars($item['description']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="flex justify-center items-center h-[100vh] my-4  absolute top-1 left-4 w-[40px] h-[40px] bg-blue-600 rounded-full text-white">
        <a href="index.php" class="rounded-lg bg-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>