<?php
namespace Admin;

require_once __DIR__ . '/../Config/config.php';
require_once __DIR__ . '/../models/AdmineModel.php';

class AdminController {
    private $pdo;
    private $model;
    public $message = ''; // Pour stocker le message (ex: "Utilisateur supprimé.")

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        $this->model = new AdminModel($this->pdo);

        // Vérification simplifiée : on simule un admin pour le test
        if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['id'] = 1;    // ID d'un admin existant
            $_SESSION['role'] = 'admin';
        }
    }

    // Gérer les actions POST
    public function handlePost($section) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            switch ($section) {
                case 'users':
                    if ($action === 'delete_user') {
                        $userId = $_POST['user_id'] ?? '';
                        if ($userId) {
                            $this->model->deleteUser($userId);
                            $this->message = "Utilisateur supprimé.";
                        }
                    }
                    break;
                case 'offres':
                    if ($action === 'delete_offre') {
                        $offreId = $_POST['offre_id'] ?? '';
                        if ($offreId) {
                            $this->model->deleteOffre($offreId);
                            $this->message = "Offre supprimée.";
                        }
                    }
                    break;
                case 'entreprises':
                    if ($action === 'delete_entreprise') {
                        $entrepriseId = $_POST['entreprise_id'] ?? '';
                        if ($entrepriseId) {
                            $this->model->deleteEntreprise($entrepriseId);
                            $this->message = "Entreprise supprimée.";
                        }
                    }
                    break;
                case 'candidatures':
                    if ($action === 'delete_candidature') {
                        $candId = $_POST['candidature_id'] ?? '';
                        if ($candId) {
                            $this->model->deleteCandidature($candId);
                            $this->message = "Candidature supprimée.";
                        }
                    }
                    break;
            }
            // Rediriger après l'action pour éviter le rechargement du POST
            header("Location: admin_panel.php?section=" . $section);
            exit;
        }
    }

    // Méthodes pour récupérer les données et renvoyer au "admin_panel.php"
    public function getUsers() {
        return $this->model->getUsers();
    }

    public function getOffres() {
        return $this->model->getOffres();
    }

    public function getEntreprises() {
        return $this->model->getEntreprises();
    }

    public function getCandidatures() {
        return $this->model->getCandidatures();
    }

    public function getTotalUsers() {
        return $this->model->countUsers();
    }

    public function getTotalOffres() {
        return $this->model->countOffres();
    }

    public function getTotalEntreprises() {
        return $this->model->countEntreprises();
    }
}
