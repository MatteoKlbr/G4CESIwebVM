<?php
session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header('Location: public/connexion.php');
    exit;
}

// Vérifier que l'utilisateur connecté est un piloteistrateur
$currentRole = $_SESSION['role'] ?? '';
if ($currentRole !== 'pilote') {
    header('Location: public/connexion.php');
    exit;
}

// Vérifier qu'un ID d'utilisateur est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Aucun utilisateur spécifié.";
    exit;
}
$user_id = $_GET['id'];
require_once __DIR__ . '../Config/config.php';
require_once __DIR__ . '../models/User.php';


$userModel = new User($pdo);
$user = $userModel->getUserById($user_id);
if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modifier l'utilisateur</title>
  <link rel="stylesheet" href="Style2.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <header>
    <!-- Vous pouvez inclure ici un header commun -->
  </header>

  <main class="container my-5">
    <h1 class="section-title text-center">Modifier l'utilisateur</h1>
    <form action="process/pilote_edit_user_process.php" method="post" enctype="multipart/form-data">
    <!-- ID de l'utilisateur à modifier -->
      <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
      
      <div class="mb-3">
        <label for="nom" class="form-label">Nom :</label>
        <input type="text" id="nom" name="nom" class="form-control" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
      </div>
      
      <div class="mb-3">
        <label for="prenom" class="form-label">Prénom :</label>
        <input type="text" id="prenom" name="prenom" class="form-control" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
      </div>
      
      <div class="mb-3">
        <label for="email" class="form-label">Email :</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
      </div>
      
      <div class="mb-3">
        <label for="role" class="form-label">Rôle :</label>
        <select id="role" name="role" class="form-select" required>
          <option value="etudiant" <?php if($user['role'] == 'etudiant') echo 'selected'; ?>>Étudiant</option>
        </select>
      </div>
      
      <div class="mb-3">
        <label for="statut_recherche" class="form-label">Statut de recherche :</label>
        <input type="text" id="statut_recherche" name="statut_recherche" class="form-control" value="<?php echo htmlspecialchars($user['statut_recherche']); ?>">
      </div>
      
      <div class="mb-3">
        <label for="avatar" class="form-label">Avatar (Photo de profil) :</label>
        <?php if (!empty($user['avatar'])): ?>
          <p>Avatar actuel : <img src="<?php echo htmlspecialchars($baseUrl . $user['avatar']); ?>" style="width:100px;" alt="Avatar"></p>
        <?php else: ?>
          <p>Aucun avatar défini.</p>
        <?php endif; ?>
        <input type="file" id="avatar" name="avatar" class="form-control">
      </div>
      
      <div class="mb-3">
        <label for="cv" class="form-label">CV :</label>
        <?php if (!empty($user['cv'])): ?>
          <p>CV actuel : <a href="<?php echo htmlspecialchars($baseUrl . $user['cv']); ?>" target="_blank">Voir CV</a></p>
        <?php else: ?>
          <p>Aucun CV téléchargé.</p>
        <?php endif; ?>
        <input type="file" id="cv" name="cv" class="form-control">
      </div>
      
      <div class="text-center">
        <button type="submit" class="btn btn-success">Mettre à jour l'utilisateur</button>
        <a href="pilote_panel.php?section=users" class="btn btn-secondary">Annuler</a>
      </div>
    </form>
  </main>

  <footer class="text-center p-3" style="background-color:#007bff; color:white;">
    &copy;2025 - Tous droits réservés - StageElevate
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
