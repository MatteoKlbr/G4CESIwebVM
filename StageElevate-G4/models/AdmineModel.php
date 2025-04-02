<?php
namespace Admin;

class AdminModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthodes de suppression
    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function deleteOffre($id) {
        $stmt = $this->pdo->prepare("DELETE FROM offres WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function deleteEntreprise($id) {
        $stmt = $this->pdo->prepare("DELETE FROM entreprises WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function deleteCandidature($id) {
        $stmt = $this->pdo->prepare("DELETE FROM candidatures WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Méthodes de récupération
    public function getUsers() {
        $stmt = $this->pdo->query("SELECT id, nom, prenom, email, role, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getOffres() {
        $sql = "SELECT o.id, o.titre, o.description, o.localisation, o.date_publication, e.nom AS entreprise
                FROM offres o
                LEFT JOIN entreprises e ON o.entreprise_id = e.id
                ORDER BY o.date_publication DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getEntreprises() {
        $stmt = $this->pdo->query("SELECT * FROM entreprises ORDER BY nom ASC");
        return $stmt->fetchAll();
    }

    public function getCandidatures() {
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

    // Pour le dashboard
    public function countUsers() {
        return $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public function countOffres() {
        return $this->pdo->query("SELECT COUNT(*) FROM offres")->fetchColumn();
    }

    public function countEntreprises() {
        return $this->pdo->query("SELECT COUNT(*) FROM entreprises")->fetchColumn();
    }
}
