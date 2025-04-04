<?php
session_start();

// Vérifier que l'utilisateur est connecté et qu'il est pilote
if (!isset($_SESSION['id']) || ($_SESSION['role'] ?? '') !== 'pilote') {
    header('Location: public/connexion.php');
    exit;
}

// Vérifier que la requête est en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pilote_panel.php?section=users');
    exit;
}

// Inclure la configuration et le modèle User
require_once __DIR__ . '/../Config/config.php';
require_once __DIR__ . '/../models/User.php';

// Instancier le modèle utilisateur
$userModel = new User($pdo);

// Récupérer et nettoyer les données du formulaire
$user_id         = $_POST['user_id'] ?? null;
if (!$user_id) {
    $_SESSION['error'] = "ID de l'utilisateur manquant.";
    header('Location: pilote_panel.php?section=users');
    exit;
}

$nom             = trim($_POST['nom'] ?? '');
$prenom          = trim($_POST['prenom'] ?? '');
$email           = trim($_POST['email'] ?? '');
$role            = trim($_POST['role'] ?? '');
$statut_recherche= trim($_POST['statut_recherche'] ?? '');

// Préparer les données à mettre à jour
$data = [
    'nom'              => $nom,
    'prenom'           => $prenom,
    'email'            => $email,
    'role'             => $role,
    'statut_recherche' => $statut_recherche,
];

// Traitement de l'upload de l'avatar si un fichier a été envoyé
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    // Types MIME autorisés pour l'avatar
    $allowedAvatarTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($_FILES['avatar']['type'], $allowedAvatarTypes)) {
        $avatarDir = __DIR__ . '/../uploads/avatars/';
        if (!is_dir($avatarDir)) {
            mkdir($avatarDir, 0777, true);
        }
        // Génération d'un nom unique pour éviter les conflits
        $avatarFileName = uniqid() . '_' . basename($_FILES['avatar']['name']);
        $avatarFilePath = $avatarDir . $avatarFileName;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarFilePath)) {
            // Stocker le chemin relatif pour la base de données
            $data['avatar'] = 'uploads/avatars/' . $avatarFileName;
        }
    }
}

// Traitement de l'upload du CV si un fichier a été envoyé
if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
    // Types MIME autorisés pour le CV
    $allowedCvTypes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    if (in_array($_FILES['cv']['type'], $allowedCvTypes)) {
        $cvDir = __DIR__ . '/../uploads/cv/';
        if (!is_dir($cvDir)) {
            mkdir($cvDir, 0777, true);
        }
        $cvFileName = uniqid() . '_' . basename($_FILES['cv']['name']);
        $cvFilePath = $cvDir . $cvFileName;
        if (move_uploaded_file($_FILES['cv']['tmp_name'], $cvFilePath)) {
            $data['cv'] = 'uploads/cv/' . $cvFileName;
        }
    }
}

// Mise à jour de l'utilisateur via le modèle avec gestion des exceptions
try {
    $result = $userModel->updateUser($user_id, $data);

    if ($result) {
        $_SESSION['message'] = "Utilisateur mis à jour avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour de l'utilisateur.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Erreur lors de la mise à jour: " . $e->getMessage();
}


header('Location: ../pilote_panel.php?section=users');
exit;
?>
