<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once 'config.php';
require_once '../models/Wishlist.php';

$offre_id = $_GET['id'] ?? null;
if (!$offre_id) {
    header("Location: Offres.php?message=offre_non_trouvee");
    exit;
}

$etudiant_id = $_SESSION['id'];
$wishlist = new Wishlist($pdo);

if ($wishlist->isAdded($etudiant_id, $offre_id)) {
    header("Location: Offres.php?message=offre_deja_ajoutee");
    exit;
}

if ($wishlist->add($etudiant_id, $offre_id)) {
    header("Location: Offres.php?message=offre_ajoutee");
    exit;
} else {
    header("Location: Offres.php?message=erreur_ajout");
    exit;
}
?>
