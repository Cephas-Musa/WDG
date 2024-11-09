<?php
session_start();

require 'services.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_id'], $_POST['comment']) && !empty($_POST['comment'])) {
        // Ajouter un commentaire
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, text) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['post_id'], $_SESSION['id'], $_POST['comment']]);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (isset($_POST['post_id'], $_POST['action']) && $_POST['action'] === 'like') {
        // Gérer les likes
        $stmt = $pdo->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$_POST['post_id'], $_SESSION['id']]);

        if ($stmt->fetch()) {
            // Si le like existe déjà, le supprimer
            $stmt = $pdo->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
            $stmt->execute([$_POST['post_id'], $_SESSION['id']]);
        } else {
            // Ajouter un like
            $stmt = $pdo->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
            $stmt->execute([$_POST['post_id'], $_SESSION['id']]);
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>


<!-- <div class="container-fluid steps py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h1 class="display-5 text-capitalize text-white mb-3">We.De.Go<span class="text-primary"> Process</span></h1>
                    <p class="mb-0 text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut amet nemo expedita asperiores commodi accusantium at cum harum, excepturi, quia tempora cupiditate! Adipisci facilis modi quisquam quia distinctio,
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="steps-item p-4 mb-4">
                            <h4>Tavel planning</h4>
                            <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, dolorem!</p>
                            <div class="setps-number">01.</div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="steps-item p-4 mb-4">
                            <h4>choose a destination</h4>
                            <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, dolorem!</p>
                            <div class="setps-number">02.</div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="steps-item p-4 mb-4">
                            <h4>Come In Contact</h4>
                            <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, dolorem!</p>
                            <div class="setps-number">03.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
