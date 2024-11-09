<?php
require "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sortie_id = $_POST['sortie_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "INSERT INTO reservations (sortie_id, name, email, phone) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('isss', $sortie_id, $name, $email, $phone);

    if ($stmt->execute()) {
        echo "Réservation effectuée avec succès !";
    } else {
        echo "Erreur lors de la réservation. Veuillez réessayer.";
    }
}
?>
