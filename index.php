<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

// Récupérer les actualités et les événements depuis la base de données.
try {
    $news = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    $events = $pdo->query("SELECT * FROM events ORDER BY date DESC")->fetchAll(PDO::FETCH_ASSOC);
    $gallery = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC LIMIT 5 ")->fetchAll();
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <style>
        .share-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            z-index: 1000;
            padding: 20px;
        }

        .popup-content {
            text-align: center;
        }

        .icons a {
            margin: 0 10px;
            color: #333;
            text-decoration: none;
        }

        .icons a i {
            transition: color 0.3s;
        }

        .icons a:hover i {
            color: #007bff;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        .d-none {
            display: none;
        }

        .title {
            max-width: 240px;
            font-size: 1.2em;
            /* Taille de police de base */
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            text-align: center;
        }

        /* Ajustement de la taille du texte si le contenu dépasse 240px */
        @media (max-width: 240px) {
            .title {
                font-size: 1em;
            }
        }
    </style>

    <meta charset="UTF-8">
    <title>we.de.go</title>

    <!-- Fonts et styles externes -->
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

    <!-- Inclure les différentes sections -->
    <?php require 'navbar.php'; ?>
    <?php require 'page_acc.php'; ?>
    <?php require 'about.php'; ?>
    <?php require 'fact.php'; ?>
    <?php require 'services.php'; ?>



    <div class="container-fluid categories">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3" id="title">Recent <span class="text-primary">News</span></h1>
                <p>Discover the wonders of Burundi through iconic places and rich culture.</p>
            </div>

            <div class="categories-carousel owl-carousel wow fadeInUp" data-wow-delay="0.1s">
                <?php foreach ($news as $new): ?>
                    <div class="categories-item p-4 bg-white shadow-lg rounded-lg position-relative" style="border-color: #A1DFC23F;">
                        <div style="display: flex; justify-content:center;">
                            <h3 class="text-center pb-3 title" style="font-weight: 600;">
                                <?= htmlspecialchars($new['title'], ENT_QUOTES, 'UTF-8'); ?>
                            </h3>
                        </div>


                        <?php if ($new['image']): ?>
                            <img src="uploads/<?= htmlspecialchars($new['image']); ?>"
                                alt="<?= htmlspecialchars($new['title']); ?>"
                                width="300" height="400" style="border-radius: 8px; object-fit:cover">
                        <?php endif; ?>

                        <?php if ($new['video']): ?>
                            <video width="320" height="240" controls>
                                <source src="uploads/<?= htmlspecialchars($new['video']); ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button class="like-btn btn btn-light" data-id="<?= $new['id']; ?>">
                                <i class="far fa-heart fa-lg"></i>
                                <span class="like-count ms-1"><?= htmlspecialchars($new['likes']); ?></span>
                            </button>

                            <button class="btn btn-outline-secondary share-btn">
                                <i class="fas fa-share-alt" style="color: #198754;"></i> Share
                            </button>
                        </div>

                        <!-- <div class="mt-3">
                            <textarea class="form-control mb-2" rows="2" placeholder="Add a comment..."></textarea>
                            <button class="btn btn-primary w-100">Comment</button>
                        </div> -->
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Popup de partage -->
            <div id="sharePopup" class="share-popup d-none">
                <div class="popup-content">
                    <span class="close-btn">&times;</span>
                    <div class="icons bg-transparent">
                        <a href="#" target="_blank" id="facebook-link">
                            <i class="fab fa-facebook fa-2x"></i>
                        </a>
                        <a href="#" target="_blank" id="whatsapp-link">
                            <i class="fab fa-whatsapp fa-2x"></i>
                        </a>
                        <a href="#" target="_blank" id="instagram-link">
                            <i class="fab fa-instagram fa-2x"></i>
                        </a>
                        <a href="#" target="_blank" id="twitter-link">
                            <i class="fab fa-twitter fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-- gallery -->

    <div class="container" style="margin-bottom: 50px;">
        <h1 class="display-5 text-capitalize mb-5 text-center" id="title">WEDEGO <span class="text-primary">gallery</span></h1>

        <div class="gallery-container">
            <!-- 3 premières images -->
            <div class="gallery-row">
                <?php foreach (array_slice($gallery, 0, 3) as $item): ?>
                    <div class="gallery-item">
                        <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $item['filename'])): ?>
                            <img src="uploads/<?= htmlspecialchars($item['filename']); ?>"
                                alt="<?= htmlspecialchars($item['image_title']); ?>">
                        <?php else: ?>
                            <video controls>
                                <source src="uploads/<?= htmlspecialchars($item['filename']); ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- 2 dernières images -->
            <div class="gallery-row">
                <?php foreach (array_slice($gallery, 3, 2) as $item): ?>
                    <div class="gallery-item">
                        <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $item['filename'])): ?>
                            <img src="uploads/<?= htmlspecialchars($item['filename']); ?>"
                                alt="<?= htmlspecialchars($item['image_title']); ?>">
                        <?php else: ?>
                            <video controls>
                                <source src="uploads/<?= htmlspecialchars($item['filename']); ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <a href="gallery.php" class="btn btn-primary mt-3 btn-more d-block text-center" style="width: 300px; position:relative; left:36%;">Read more</a>
    </div>


    <?php require 'outil.php'; ?>
    <div id="map" style="display: flex; align-items: center; justify-content:center; margin-bottom: 20px;">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63956.2762329694!2d29.332027642967556!3d-3.376217708187524!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19c1815d0dd808b1%3A0xaebd3cfe5d6b1c4d!2sBujumbura%2C%20Burundi!5e0!3m2!1sen!2sbi!4v1698240901013!5m2!1sen!2sbi"
            width="84%"
            height="400px"
            frameborder="0"
            style="border:0; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15);"
            allowfullscreen="">
        </iframe>
    </div>
    <?php require 'footer.php'; ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="like.js"></script>
    <script>
        $(document).ready(function() {
            // Gestion des likes
            $('.like-btn').on('click', function() {
                const btn = $(this);
                const newsId = btn.data('id');
                const likeCountSpan = btn.find('.like-count');
                let currentLikes = parseInt(likeCountSpan.text());

                const liked = btn.find('i').hasClass('fas'); // Icône pleine (fas) indique un "like"

                if (liked) {
                    // Annuler le like
                    btn.find('i').removeClass('fas').addClass('far');
                    likeCountSpan.text(currentLikes - 1);
                    updateLike(newsId, 'decrement');
                } else {
                    // Ajouter un like
                    btn.find('i').removeClass('far').addClass('fas');
                    likeCountSpan.text(currentLikes + 1);
                    updateLike(newsId, 'increment');
                }
            });

            // Fonction AJAX pour envoyer l'état des likes au serveur
            function updateLike(newsId, action) {
                $.ajax({
                    url: 'update_like.php',
                    type: 'POST',
                    data: {
                        news_id: newsId,
                        action: action
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function() {
                        alert('Erreur lors de la mise à jour du like.');
                    }
                });
            }

            // Gestion des commentaires
            $('.btn-primary').on('click', function() {
                const commentBox = $(this).siblings('textarea');
                const comment = commentBox.val().trim();
                const newsId = $(this).closest('.categories-item').find('.like-btn').data('id');

                if (comment) {
                    $.ajax({
                        url: 'add_comment.php',
                        type: 'POST',
                        data: {
                            news_id: newsId,
                            comment: comment
                        },
                        success: function(response) {
                            alert('Commentaire ajouté avec succès.');
                            commentBox.val(''); // Vider la zone de texte après ajout
                        },
                        error: function() {
                            alert('Erreur lors de l\'ajout du commentaire.');
                        }
                    });
                } else {
                    alert('Veuillez saisir un commentaire.');
                }
            });

            // Sélection des éléments du popup de partage
            const sharePopup = $('#sharePopup'); // Popup de partage
            const closeBtn = $('.close-btn'); // Bouton de fermeture

            // Ouvrir le popup de partage au clic sur un bouton Share
            $('.share-btn').on('click', function() {
                const postUrl = window.location.href; // URL de la page actuelle

                // Mettre à jour les liens de partage dynamiquement
                $('#facebook-link').attr('href', generateShareLink('facebook', postUrl));
                $('#whatsapp-link').attr('href', generateShareLink('whatsapp', postUrl));
                $('#instagram-link').attr('href', generateShareLink('instagram', postUrl));
                $('#twitter-link').attr('href', generateShareLink('twitter', postUrl));

                // Afficher le popup
                sharePopup.removeClass('d-none');
            });

            // Fermer le popup au clic sur le bouton de fermeture
            closeBtn.on('click', function() {
                sharePopup.addClass('d-none');
            });

            // Fonction pour générer les URLs de partage dynamiques
            function generateShareLink(network, url) {
                switch (network) {
                    case 'facebook':
                        return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                    case 'whatsapp':
                        return `https://wa.me/?text=${encodeURIComponent(url)}`;
                    case 'instagram':
                        return `https://www.instagram.com/?url=${encodeURIComponent(url)}`;
                    case 'twitter':
                        return `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}`;
                }
            }
        });
    </script>

</body>

</html>