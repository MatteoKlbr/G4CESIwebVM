<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once __DIR__ . '/../Config/config.php';   
require_once '../models/Wishlist.php';

$offre_id = $_GET['offre_id'] ?? null;
if (!$offre_id) {
    header("Location: Wishlist.php?message=offre_non_trouvee");
    exit;
}

$etudiant_id = $_SESSION['id'];
$wishlist = new Wishlist($pdo);

if ($wishlist->remove($etudiant_id, $offre_id)) {
    header("Location: Wishlist.php?message=offre_retiree");
    exit;
} else {
    header("Location: Wishlist.php?message=erreur_retrait");
    exit;
}
?>
