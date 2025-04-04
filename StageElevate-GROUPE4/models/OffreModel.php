<?php
namespace Models;

use PDO;

class OffreModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Insère une nouvelle offre dans la base de données
    public function createOffre($entreprise_id, $titre, $description, $competences, $base_remuneration, $date_publication, $date_expiration, $localisation) {
        $sql = "INSERT INTO offres (entreprise_id, titre, description, competences, base_remuneration, date_publication, date_expiration, localisation, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$entreprise_id, $titre, $description, $competences, $base_remuneration, $date_publication, $date_expiration, $localisation]);
    }
}
?>
