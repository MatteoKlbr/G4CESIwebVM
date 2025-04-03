<?php
// EntrepriseController.php
namespace Controllers;
require_once __DIR__ . '/../Config/config.php';   // Fichier qui définit $pdo
require_once __DIR__ . '/../models/EntrepriseModel.php';

use Models\EntrepriseModel;

class EntrepriseController {
    private $pdo;
    private $model;

    public function __construct() {
        global $pdo;
        if (!isset($pdo)) {
            die("La connexion PDO n'est pas définie.");
        }
        $this->pdo = $pdo;
        $this->model = new EntrepriseModel($this->pdo);
        // Pour tester, on simule un admin
        if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['id'] = 1;
            $_SESSION['role'] = 'admin';
        }
    }

    // Afficher le formulaire
    public function create() {
        require_once 'create_entreprise_view.php';
    }
    
    public function getAllEntreprises() {
        $stmt = $this->pdo->query("SELECT id, nom, description, email, telephone, created_at FROM entreprises ORDER BY nom ASC");
        return $stmt->fetchAll();
    }
    

    // Traiter le formulaire
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');

            if (empty($nom) || empty($description) || empty($email) || empty($telephone)) {
                $_SESSION['create_entreprise_error'] = "Tous les champs doivent être remplis.";
                header("Location: ../admin_panel.php?section=entreprises.php");
                exit;
            }

            if ($this->model->createEntreprise($nom, $description, $email, $telephone)) {
                header("Location: ../admin_panel.php?section=entreprises");
                exit;
            } else {
                $_SESSION['create_entreprise_error'] = "Erreur lors de la création de l'entreprise.";
                header("Location: ../admin_panel.php?section=entreprises");
                exit;
            }
        } else {
            header("Location: ../admin_panel.php?section=entreprises");
            exit;
        }
    }
}
