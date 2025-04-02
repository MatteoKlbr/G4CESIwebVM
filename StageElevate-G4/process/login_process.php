<?php
require_once __DIR__ . '/../Config/config.php';// Ce fichier démarre la session et établit la connexion PDO
require_once '../models/User.php'; // Inclusion du modèle User

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $motdepasse = $_POST['motdepasse'] ?? '';

    if (empty($email) || empty($motdepasse)) {
        $_SESSION['login_error'] = "Tous les champs sont obligatoires.";
        header("Location: connexion.php");
        exit;
    }

    // Instanciation du modèle User et authentification
    $userModel = new User($pdo);
    $user = $userModel->authenticate($email, $motdepasse);

    if ($user) {
        // Définition des variables de session
        $_SESSION['id'] = $user['id'];
        $_SESSION['user_name'] = $user['nom'] . " " . $user['prenom'];
        $_SESSION['role'] = $user['role'];

        // Mise à jour du champ last_login
        $userModel->updateLastLogin($user['id']);

        // Redirection en fonction du rôle
        if ($user['role'] === 'etudiant') {
            header("Location: Accueil.php");
        }

        if ($user['role'] === 'admin') {
            header("Location: admin_panel.php");
        }
        if ($user['role'] === 'pilote') {
            header("Location: admin_panel.php");
        }
         else {
            header("Location: ../public/Accueil.php");
        }
        exit;
    } else {
        $_SESSION['login_error'] = "Identifiants incorrects.";
        header("Location: public/connexion.php");
        exit;
    }
} else {
    header("Location: connexion.php");
    exit;
}
?>
