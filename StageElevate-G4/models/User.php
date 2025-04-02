<?php
class User {
    private $pdo;
    private $table = "users";

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Authentifie un utilisateur.
     */
    public function authenticate($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    /**
     * Met à jour le champ last_login de l'utilisateur.
     */
    public function updateLastLogin($userId) {
        $stmt = $this->pdo->prepare("UPDATE " . $this->table . " SET last_login = NOW() WHERE id = ?");
        $stmt->execute([$userId]);
    }

    /**
     * Récupère les informations d'un utilisateur par son ID.
     */
    public function getUserById($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour le profil d'un utilisateur.
     *
     * @param int   $userId
     * @param array $data  Associatif contenant : nom, prenom, email, statut_recherche, avatar, cv.
     * @return bool
     */
    public function updateProfile($userId, $data) {
        $sql = "UPDATE " . $this->table . " SET 
                    nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    statut_recherche = :statut_recherche,
                    avatar = :avatar,
                    cv = :cv
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $userId;
        return $stmt->execute($data);
    }


    public function register($nom, $prenom, $email, $password, $role = 'etudiant') {
        // Vérifier que l'email n'est pas déjà utilisé
        $stmt = $this->pdo->prepare("SELECT id FROM " . $this->table . " WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return false; // ou lever une exception, ou retourner un message d'erreur
        }
        
        // Hacher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insérer l'utilisateur
        $stmt = $this->pdo->prepare("INSERT INTO " . $this->table . " (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $prenom, $email, $hashedPassword, $role]);
    }
    
}
?>
