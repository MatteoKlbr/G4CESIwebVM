<?php
session_start();
$redirectPanel = ($_SESSION['role'] === 'admin') ? 'admin_panel.php' : 'pilote_panel.php';

// session_start();
// if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: connexion.php');
//     exit;
// }
require_once __DIR__ . '/../Config/config.php';   // Fichier qui définit $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    if (empty($id) || empty($nom) || empty($description) || empty($email) || empty($telephone)) {
        $_SESSION['edit_entreprise_error'] = "Tous les champs sont obligatoires.";
        header("Location: edit_entreprise.php?id=$id");
        exit;
    }

    $sql = "UPDATE entreprises SET nom = ?, description = ?, email = ?, telephone = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute([$nom, $description, $email, $telephone, $id])){
        header("Location: ../{$redirectPanel}?section=entreprises");
        exit;
    } else {
        $_SESSION['edit_entreprise_error'] = "Erreur lors de la mise à jour.";
        header("Location: edit_entreprise.php?id=$id");
        exit;
    }
} else {
    header("Location: ../{$redirectPanel}");
    exit;
}
?>
