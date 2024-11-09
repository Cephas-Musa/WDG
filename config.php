<?php
// Démarre une session sécurisée
session_start([
    'cookie_lifetime' => 86400, // Durée de vie du cookie de session (1 jour)
    'cookie_secure' => true,   // Empêche l'accès au cookie via JavaScript
    'cookie_httponly' => true,  // Assurez-vous que les cookies sont envoyés via HTTPS seulement
    'use_strict_mode' => true,  // Empêche les attaques de fixation de session
]);
// Redirection automatique vers HTTPS si pas déjà sur HTTPS
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $redirect);
    exit();
}
