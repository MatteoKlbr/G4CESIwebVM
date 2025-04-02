<?php
session_start();
require_once __DIR__ . '/public/config.php';   // Fichier qui définit $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $entreprise_id = trim($_POST['entreprise_id'] ?? '');
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $competences = trim($_POST['competences'] ?? '');
    $base_remuneration = trim($_POST['base_remuneration'] ?? '');
    $date_publication = $_POST['date_publication'] ?? '';
    $date_expiration = $_POST['date_expiration'] ?? '';
    $localisation = trim($_POST['localisation'] ?? '');

    // Vérification des champs requis
    if (
        empty($id) || empty($entreprise_id) || empty($titre) || empty($description) ||
        empty($competences) || empty($base_remuneration) || empty($date_publication) ||
        empty($date_expiration) || empty($localisation)
    ) {
        $_SESSION['edit_offre_error'] = "Tous les champs sont obligatoires.";
        header("Location: edit_offre.php?id=" . urlencode($id));
        exit;
    }

    // Vérification que la base de rémunération est un nombre
    if (!is_numeric($base_remuneration)) {
        $_SESSION['edit_offre_error'] = "La base de rémunération doit être un nombre.";
        header("Location: edit_offre.php?id=" . urlencode($id));
        exit;
    }

    // Vérification que l'entreprise existe
    $stmtCheck = $pdo->prepare("SELECT id FROM entreprises WHERE id = ?");
    $stmtCheck->execute([$entreprise_id]);
    if (!$stmtCheck->fetch()) {
        $_SESSION['edit_offre_error'] = "L'entreprise sélectionnée n'existe pas.";
        header("Location: edit_offre.php?id=" . urlencode($id));
        exit;
    }

    // Mise à jour de l'offre
    $sql = "UPDATE offres SET 
                entreprise_id = ?, 
                titre = ?, 
                description = ?, 
                competences = ?, 
                base_remuneration = ?, 
                date_publication = ?, 
                date_expiration = ?, 
                localisation = ? 
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        $entreprise_id, $titre, $description, $competences,
        $base_remuneration, $date_publication, $date_expiration,
        $localisation, $id
    ]);

    if ($success) {
        header("Location: admin_panel.php");
        exit;
    } else {
        $_SESSION['edit_offre_error'] = "Erreur lors de la mise à jour de l'offre.";
        header("Location: edit_offre.php?id=" . urlencode($id));
        exit;
    }
} else {
    header("Location: admin_panel.php.php");
    exit;
}
?>
