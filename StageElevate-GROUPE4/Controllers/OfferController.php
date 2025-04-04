<?php
namespace Controllers;

require_once __DIR__ . '/../Config/config.php';   // Fichier qui définit $pdo
require_once '../models/OffreModel.php';                 // Inclusion du modèle

use Models\OffreModel;
use PDO;

class OfferController {
    private $pdo;
    private $offreModel;

    public function __construct() {
        global $pdo;
        if (!isset($pdo)) {
            die("La connexion PDO n'est pas définie dans config.php");
        }
        $this->pdo = $pdo;
        
        
        $this->offreModel = new OffreModel($this->pdo);
    }

    // Méthode pour traiter le formulaire et insérer l'offre
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: create_offre.php");
            exit;
        }
        
        $entreprise_id     = trim($_POST['entreprise_id'] ?? '');
        $titre             = trim($_POST['titre'] ?? '');
        $description       = trim($_POST['description'] ?? '');
        $competences       = trim($_POST['competences'] ?? '');
        $base_remuneration = trim($_POST['base_remuneration'] ?? '');
        $date_publication  = $_POST['date_publication'] ?? '';
        $date_expiration   = $_POST['date_expiration'] ?? '';
        $localisation      = trim($_POST['localisation'] ?? '');

        // Vérifier que tous les champs sont remplis
        if (
            empty($entreprise_id) || empty($titre) || empty($description) || 
            empty($competences) || empty($base_remuneration) || 
            empty($date_publication) || empty($date_expiration) || empty($localisation)
        ) {
            $_SESSION['create_offre_error'] = "Tous les champs sont obligatoires.";
            header("Location: create_offre.php");
            exit;
        }

        // Vérifier que la base de rémunération est un nombre
        if (!is_numeric($base_remuneration)) {
            $_SESSION['create_offre_error'] = "La base de rémunération doit être un nombre.";
            header("Location: create_offre.php");
            exit;
        }
        // Vérifier que l'ID entreprise existe
        $stmtCheck = $this->pdo->prepare("SELECT id FROM entreprises WHERE id = ?");
        $stmtCheck->execute([$entreprise_id]);
        if (!$stmtCheck->fetch()) {
            $_SESSION['create_offre_error'] = "ID entreprise invalide. L'entreprise n'existe pas.";
            header("Location: create_offre.php");
            exit;
        }

        // Essayer d'insérer l'offre dans la base
        if ($this->offreModel->createOffre(
            $entreprise_id, $titre, $description, $competences,
            $base_remuneration, $date_publication, $date_expiration, $localisation
        )) {
            header("Location: ../admin_panel.php");
            exit;
        } else {
            $errorInfo = $this->pdo->errorInfo();
            $_SESSION['create_offre_error'] = "Erreur lors de la création de l'offre: " . $errorInfo[2];
            header("Location: create_offre.php");
            exit;
        }
    }
}
?>
