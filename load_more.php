<?php
include 'db_connect.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Requête sécurisée avec préparation
$stmt = $conn->prepare("SELECT * FROM gallery LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($item = $result->fetch_assoc()) {
        echo '<div class="relative group">';
        echo '<img src="uploads/' . htmlspecialchars($item['filename']) . '" 
                  alt="' . htmlspecialchars($item['image_title']) . '" 
                  class="w-full h-48 object-cover rounded-lg">';
        echo '<div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 
                    flex items-center justify-center text-white text-lg">';
        echo '<p>' . htmlspecialchars($item['image_title']) . '</p>';
        echo '</div></div>';
    }
} else {
    echo "<p>Aucune image supplémentaire à afficher.</p>";
}
$stmt->close();
$conn->close();
?>
