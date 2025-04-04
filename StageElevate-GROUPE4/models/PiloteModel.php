<?php
namespace Models;

class PiloteModel {
    private $pdo;

    // Ici, nous passons directement la variable $pdo (définie dans config.php)
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function deleteUser($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$userId]);
    }

    public function deleteOffre($offreId) {
        $stmt = $this->pdo->prepare("DELETE FROM offres WHERE id = ?");
        return $stmt->execute([$offreId]);
    }

    public function deleteEntreprise($entrepriseId) {
        $stmt = $this->pdo->prepare("DELETE FROM entreprises WHERE id = ?");
        return $stmt->execute([$entrepriseId]);
    }

    public function deleteCandidature($candId) {
        $stmt = $this->pdo->prepare("DELETE FROM candidatures WHERE id = ?");
        return $stmt->execute([$candId]);
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT id, nom, prenom, email, role, created_at FROM users WHERE role='etudiant'");
        return $stmt->fetchAll();
    }

    public function getAllOffres() {
        $sql = "SELECT o.id, o.titre, o.description, o.localisation, o.date_publication, e.nom AS entreprise
                FROM offres o
                LEFT JOIN entreprises e ON o.entreprise_id = e.id
                ORDER BY o.date_publication DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllEntreprises() {
        $stmt = $this->pdo->query("SELECT * FROM entreprises ORDER BY nom ASC");
        return $stmt->fetchAll();
    }

    public function getAllCandidatures() {
        $sql = "SELECT c.id, c.date_candidature, c.cv, c.lettre_motivation,
                       u.nom, u.prenom,
                       o.titre AS offre_titre
                FROM candidatures c
                LEFT JOIN users u ON c.etudiant_id = u.id
                LEFT JOIN offres o ON c.offre_id = o.id
                ORDER BY c.date_candidature DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
