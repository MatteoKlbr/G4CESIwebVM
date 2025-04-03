<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once __DIR__ . '/../Config/config.php';

// Récupérer les informations de l'utilisateur pour pré-remplir le formulaire
$user_id = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT id, nom, prenom, email, avatar, statut_recherche, cv FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

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
  <meta name="description" content="Modifier votre profil sur LeBonPlan.">
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Modifier mon profil - LeBonPlan</title>
  <style>
    /* Styles additionnels si besoin */
    body { background-color: #f8f9fa; }
    h1 { color: #343a40; }
  </style>
</head>
<body>
  <main class="container my-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="mb-4 text-center">Modifier votre profil</h1>
        <?php 
          // Affichage des messages de succès ou d'erreur
          if (isset($_SESSION['edit_profile_error'])) {
              echo '<div class="alert alert-danger" role="alert">' . $_SESSION['edit_profile_error'] . '</div>';
              unset($_SESSION['edit_profile_error']);
          }
          if (isset($_SESSION['edit_profile_success'])) {
              echo '<div class="alert alert-success" role="alert">' . $_SESSION['edit_profile_success'] . '</div>';
              unset($_SESSION['edit_profile_success']);
          }
        ?>

        <form action="../process/edit_profile_process.php" method="post" enctype="multipart/form-data" class="row g-3">
          <div class="col-md-6">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
          </div>
          <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom :</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email :</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
          </div>
          <div class="col-md-6">
            <label for="statut_recherche" class="form-label">Statut de recherche :</label>
            <input type="text" class="form-control" id="statut_recherche" name="statut_recherche" value="<?php echo htmlspecialchars($user['statut_recherche']); ?>">
          </div>
          <div class="col-md-6">
            <label for="avatar" class="form-label">Avatar (Photo de profil) :</label>
            <?php if (!empty($user['avatar'])): ?>
              <div class="mb-2">
                <!-- Concaténation de $baseUrl avec le chemin relatif de l'avatar -->
                <img src="<?php echo htmlspecialchars($baseUrl . $user['avatar']); ?>" alt="Avatar" class="img-thumbnail" style="width:100px;">
              </div>
            <?php else: ?>
              <p class="text-muted">Aucun avatar défini.</p>
            <?php endif; ?>
            <input type="file" class="form-control" id="avatar" name="avatar">
          </div>
          <div class="col-md-6">
            <label for="cv" class="form-label">CV :</label>
            <?php if (!empty($user['cv'])): ?>
              <p><a href="<?php echo htmlspecialchars($baseUrl . $user['cv']); ?>" target="_blank">Voir mon CV</a></p>
            <?php else: ?>
              <p class="text-muted">Aucun CV défini.</p>
            <?php endif; ?>
            <input type="file" class="form-control" id="cv" name="cv">
          </div>
          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-success">Sauvegarder les modifications</button>
            <a href="Accueil.php" class="btn btn-secondary ms-2">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </main>
  
  <!-- Bootstrap JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
