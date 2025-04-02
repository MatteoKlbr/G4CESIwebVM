<?php
class Candidature {
    private $pdo;
    private $table = "candidatures";

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Enregistre une candidature dans la base de données.
     *
     * @param int    $etudiant_id
     * @param int    $offre_id
     * @param string $lettre
     * @param string $cvPath
     * @param string|null $apropos
     * @param string $majeur ('oui' ou 'non')
     * @return bool Retourne true en cas de succès, false sinon.
     */
    public function apply($etudiant_id, $offre_id, $lettre, $cvPath, $apropos = null, $majeur = 'non') {
        $sql = "INSERT INTO " . $this->table . " (etudiant_id, offre_id, lettre_motivation, cv, apropos, majeur, date_candidature)
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$etudiant_id, $offre_id, $lettre, $cvPath, $apropos, $majeur]);
    }
}
?>
