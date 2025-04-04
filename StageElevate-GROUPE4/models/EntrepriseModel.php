<?php
// EntrepriseModel.php
namespace Models;

class EntrepriseModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createEntreprise($nom, $description, $email, $telephone) {
        $sql = "INSERT INTO entreprises (nom, description, email, telephone) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $description, $email, $telephone]);
    }
    public function getAllEntreprises() {
        $sql = "SELECT id, nom, description, email, telephone, localisation, secteur, created_at FROM entreprises ORDER BY nom ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}

