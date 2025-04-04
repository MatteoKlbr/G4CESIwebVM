<?php
////////////////////////////////
// Démarrage de la session
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}
/////////////////////////////////////////
// Inclusion de la configuration et des modèles
require_once '../Config/config.php';
require_once '../models/candidature.php';
require_once '../models/User.php';

// Récupérer les informations de l'utilisateur (pour accéder à son CV existant)
$userModel = new User($pdo);
$userInfo = $userModel->getUserById($_SESSION['id']);
$existing_cv = $userInfo['cv'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offre_id   = trim($_POST['offre_id'] ?? '');
    $lettre     = trim($_POST['lettre'] ?? '');
    $etudiant_id = $_SESSION['id'];

    // Vérifier que les champs obligatoires sont remplis
    if (empty($offre_id) || empty($lettre)) {
        $_SESSION['postuler_error'] = "Tous les champs sont obligatoires.";
        header("Location: ../public/postuler.php?id=" . $offre_id);
        exit;
    }

    // Gestion du téléversement du CV
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/cv/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $fileTmp  = $_FILES['cv']['tmp_name'];
        $fileName = basename($_FILES['cv']['name']);
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Vérifier que le fichier est au format PDF uniquement
        if ($fileExt !== 'pdf') {
            $_SESSION['postuler_error'] = "Seuls les fichiers PDF sont autorisés.";
            header("Location: ../public/postuler.php?id=" . $offre_id);
            exit;
        }

        // Vérifier la taille du fichier (2 Mo maximum)
        $maxSize = 2 * 1024 * 1024; // 2 Mo
        if ($_FILES['cv']['size'] > $maxSize) {
            $_SESSION['postuler_error'] = "La taille du fichier dépasse 2 Mo.";
            header("Location: ../public/postuler.php?id=" . $offre_id);
            exit;
        }

        $newFileName = uniqid('cv_', true) . '.' . $fileExt;
        $targetFile  = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmp, $targetFile)) {
            $_SESSION['postuler_error'] = "Erreur lors du téléversement du CV.";
            header("Location: ../public/postuler.php?id=" . $offre_id);
            exit;
        }
        // Stocker uniquement le chemin relatif
        $cv_path = 'uploads/cv/' . $newFileName;
    } else {
        // Si aucun nouveau fichier n'est fourni, on conserve le CV existant s'il y en a un
        if (empty($existing_cv)) {
            $_SESSION['postuler_error'] = "Veuillez téléverser votre CV.";
            header("Location: ../public/postuler.php?id=" . $offre_id);
            exit;
        } else {
            $cv_path = $existing_cv;
        }
    }

    try {
        // Instanciation du modèle Candidature et enregistrement de la candidature
        $candidatureModel = new Candidature($pdo);
        if ($candidatureModel->apply($etudiant_id, $offre_id, $lettre, $cv_path)) {
            header("Location: ../public/postuler.php?id=$offre_id&success=1");
            exit;
        } else {
            $_SESSION['postuler_error'] = "Erreur lors de l'enregistrement de la candidature.";
            header("Location: ../public/postuler.php?id=" . $offre_id);
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['postuler_error'] = "Exception PDO: " . $e->getMessage();
        header("Location: ../public/postuler.php?id=" . $offre_id);
        exit;
    }
} else {
    header("Location: ../public/Offres.php");
    exit;
}
?>
