<?php
session_start();
require_once __DIR__ . '/../Config/config.php'; // ajuste le chemin si besoin

// Vérification des données envoyées et de la session utilisateur
if (!isset($_POST['entreprise_id'], $_POST['evaluation'], $_SESSION['id'])) {
    header('Location: entreprise.php');
    exit;
}

$entreprise_id = intval($_POST['entreprise_id']);
$evaluation = intval($_POST['evaluation']);
$user_id = $_SESSION['id'];

// Vérifie que la note est entre 1 et 5
if ($evaluation < 1 || $evaluation > 5) {
    die("Note invalide. La note doit être entre 1 et 5.");
}

// Vérifie si l'utilisateur a déjà noté cette entreprise
$sqlCheck = "SELECT id FROM evaluations WHERE entreprise_id = ? AND user_id = ?";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([$entreprise_id, $user_id]);

if ($stmtCheck->fetch()) {
    die("Vous avez déjà évalué cette entreprise.");
}

// Insère la nouvelle évaluation
$sqlInsert = "INSERT INTO evaluations (entreprise_id, user_id, evaluation, created_at) VALUES (?, ?, ?, NOW())";
$stmtInsert = $pdo->prepare($sqlInsert);
$stmtInsert->execute([$entreprise_id, $user_id, $evaluation]);

// Redirection après l'évaluation
header('Location: entreprise.php');
exit;
