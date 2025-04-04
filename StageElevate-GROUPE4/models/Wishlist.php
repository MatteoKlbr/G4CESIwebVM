<?php
class Wishlist {
    private $pdo;
    private $table = "wishlist";

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Vérifie si une offre est déjà ajoutée à la wishlist de l'étudiant.
     *
     * @param int $etudiant_id
     * @param int $offre_id
     * @return bool
     */
    public function isAdded($etudiant_id, $offre_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE etudiant_id = ? AND offre_id = ?");
        $stmt->execute([$etudiant_id, $offre_id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Ajoute une offre à la wishlist.
     *
     * @param int $etudiant_id
     * @param int $offre_id
     * @return bool
     */
    public function add($etudiant_id, $offre_id) {
        // Vérifie si l'étudiant existe dans la table users
        $stmtUser = $this->pdo->prepare("SELECT id FROM users WHERE id = ?");
        $stmtUser->execute([$etudiant_id]);
        if ($stmtUser->rowCount() == 0) {
            // L'utilisateur n'existe pas, vous pouvez gérer l'erreur autrement, ici on retourne false.
            return false;
        }
        
        // Insertion dans la wishlist
        $stmt = $this->pdo->prepare("INSERT INTO " . $this->table . " (etudiant_id, offre_id) VALUES (?, ?)");
        return $stmt->execute([$etudiant_id, $offre_id]);
    }

    /**
     * Supprime une offre de la wishlist.
     *
     * @param int $etudiant_id
     * @param int $offre_id
     * @return bool
     */
    public function remove($etudiant_id, $offre_id) {
        $stmt = $this->pdo->prepare("DELETE FROM " . $this->table . " WHERE etudiant_id = ? AND offre_id = ?");
        return $stmt->execute([$etudiant_id, $offre_id]);
    }
}
?>
