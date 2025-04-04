<?php
// config.php

// Durée de la session en secondes (par exemple, 3600 = 1 heure)
$session_lifetime = 3600;

// Ne modifier les paramètres de session que si aucune session n'est active
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', $session_lifetime);
    session_set_cookie_params($session_lifetime);
    session_start();
}
// Définir l'URL de base de ton site
$baseUrl = 'http://168.63.6.6/';
// Connexion PDO à la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'stage_db'); // Adaptez selon votre base
define('DB_USER', 'hedi-rihani');     // Adaptez selon votre configuration
define('DB_PASS', 'G4@CESIweb');  // Adaptez selon votre configuration

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
