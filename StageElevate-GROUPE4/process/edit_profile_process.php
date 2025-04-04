<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . '/../Config/config.php';
require_once '../models/User.php';

if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

$user_id = $_SESSION['id'];
$userModel = new User($pdo);

// Récupérer les valeurs actuelles (pour conserver l'avatar et le CV si non mis à jour)
$current = $userModel->getUserById($user_id);
$avatar_path = $current['avatar'] ?? '';
$cv_path = $current['cv'] ?? '';

// Récupérer et nettoyer les données du formulaire
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$statut_recherche = trim($_POST['statut_recherche'] ?? '');

// Vérifier que les champs obligatoires sont remplis
if (empty($nom) || empty($prenom) || empty($email)) {
    $_SESSION['edit_profile_error'] = "Tous les champs obligatoires doivent être remplis.";
    header("Location: edit_profile.php");
    exit;
}

// Traitement du téléversement de l'avatar si fourni
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../uploads/avatars/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $tmpAvatar = $_FILES['avatar']['tmp_name'];
    $origAvatar = basename($_FILES['avatar']['name']);
    $extAvatar = strtolower(pathinfo($origAvatar, PATHINFO_EXTENSION));
    $allowedAvatar = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($extAvatar, $allowedAvatar)) {
        $_SESSION['edit_profile_error'] = "Format d'image non autorisé. Formats acceptés : jpg, jpeg, png, gif.";
        header("Location: edit_profile.php");
        exit;
    }
    $newAvatarName = uniqid('avatar_', true) . '.' . $extAvatar;
    $targetAvatar = $uploadDir . $newAvatarName;
    if (!move_uploaded_file($tmpAvatar, $targetAvatar)) {
        $_SESSION['edit_profile_error'] = "Erreur lors de l'upload de l'avatar.";
        header("Location: edit_profile.php");
        exit;
    }
    file_exists(__DIR__ . '/../' . $current['avatar']) && unlink(__DIR__ . '/../' . $current['avatar']);

    // Stocker uniquement le chemin relatif
    $avatar_path = 'uploads/avatars/' . $newAvatarName;
}

// Traitement du téléversement du CV si fourni
if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../uploads/cv/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $tmpCV = $_FILES['cv']['tmp_name'];
    $origCV = basename($_FILES['cv']['name']);
    $extCV = strtolower(pathinfo($origCV, PATHINFO_EXTENSION));
    if ($extCV !== 'pdf') {
        $_SESSION['edit_profile_error'] = "Format de CV non autorisé. Seul le format PDF est accepté.";
        header("Location: edit_profile.php");
        exit;
    }
    $newCVName = uniqid('cv_', true) . '.' . $extCV;
    $targetCV = $uploadDir . $newCVName;
    if (!move_uploaded_file($tmpCV, $targetCV)) {
        $_SESSION['edit_profile_error'] = "Erreur lors de l'upload du CV.";
        header("Location: edit_profile.php");
        exit;
    }
    file_exists(__DIR__ . '/../' . $current['cv']) && unlink(__DIR__ . '/../' . $current['cv']);

    // Stocker uniquement le chemin relatif
    $cv_path = 'uploads/cv/' . $newCVName;
}

try {
    // Préparer les données pour la mise à jour
    $data = [
        'nom'              => $nom,
        'prenom'           => $prenom,
        'email'            => $email,
        'statut_recherche' => $statut_recherche,
        'avatar'           => $avatar_path,
        'cv'               => $cv_path
    ];

    if ($userModel->updateProfile($user_id, $data)) {
        $_SESSION['edit_profile_success'] = "Profil mis à jour avec succès.";
        header("Location: ../public/Accueil.php?openProfile=1");
        exit;
    } else {
        $_SESSION['edit_profile_error'] = "Erreur lors de la mise à jour du profil.";
        header("Location: edit_profile.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['edit_profile_error'] = "Exception PDO: " . $e->getMessage();
    header("Location: edit_profile.php");
    exit;
}
?>
