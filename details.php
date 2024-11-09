<?php
$connection = new mysqli('localhost', 'root', '', 'wedego');
$id = $_GET['id']; // Récupération de l'ID dans l'URL en toute sécurité

$query = "SELECT * FROM sorties WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$sortie = $result->fetch_assoc();

if (!$sortie) {
    echo "La sortie demandée est introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la sortie - <?= htmlspecialchars($sortie['titre']) ?></title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers vos styles CSS -->
</head>
<body>

<div class="container">
    <h1 class="display-5 text-capitalize mb-3"><?= htmlspecialchars($sortie['titre']) ?></h1>
    <img src="uploads/<?= htmlspecialchars($sortie['image']) ?>" alt="<?= htmlspecialchars($sortie['titre']) ?>" class="img-fluid w-100 mb-4" style="height: 500px; object-fit:cover;">
    <div class="blog-date"><?= date('d M Y', strtotime($sortie['date_sortie'])) ?></div>
    <p class="description-full"><?= nl2br(htmlspecialchars($sortie['description'])) ?></p>

    <!-- Formulaire de réservation -->
    <h2>Réserver une place</h2>
    <form id="reservationForm" onsubmit="redirectToWhatsApp(event)">
        <div class="form-group">
            <label for="name">Nom complet :</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone">Téléphone :</label>
            <input type="text" id="phone" name="phone" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Réserver</button>
    </form>
</div>

<script>
    function redirectToWhatsApp(event) {
        event.preventDefault(); // Empêche le formulaire de se soumettre normalement

        // Récupération des informations saisies dans le formulaire
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const sortieTitre = <?= json_encode($sortie['titre']) ?>; // Titre de la sortie

        // Message à envoyer sur WhatsApp
        const message = `Salut Cephas, je m'appelle ${name}. Je souhaite réserver une place pour "${sortieTitre}".\n\nInformations de contact :\n- Email : ${email}\n- Téléphone : ${phone}`;

        // Numéro WhatsApp cible (remplacez "1234567890" par votre numéro avec l'indicatif)
        const whatsappNumber = "+25765191580";

        // URL de redirection vers WhatsApp
        const whatsappURL = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

        // Redirection vers WhatsApp
        window.location.href = whatsappURL;
    }
</script>

</body>
</html>
