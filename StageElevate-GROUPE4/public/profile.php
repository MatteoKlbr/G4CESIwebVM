<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Config/config.php';
require_once __DIR__ . '/../models/User.php';  // Chemin correct vers User.php

if (!isset($_SESSION['id'])) {
    return; // On ne fait rien si l'utilisateur n'est pas connecté
}

$UserModel = new User($pdo);  // Instancier la classe User
$user = $UserModel->getUserById($_SESSION['id']); // Récupérer l'utilisateur

if (!$user) {
    echo "<p>Utilisateur non trouvé.</p>";
    exit;
}
?>

<link rel="stylesheet" href="profile.css">

<!-- Modale Bootstrap pour afficher le profil -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content"> <!-- Nous avons ici une modale classique, mais les styles s'appliqueront via le CSS intégré -->
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Mon Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4 text-center">
            <img src="<?php echo !empty($user['avatar']) ? htmlspecialchars($baseUrl . $user['avatar']) : htmlspecialchars($baseUrl . 'images/logo-lb.png'); ?>" alt="Avatar" class="img-fluid rounded-circle">
          </div>
          <div class="col-md-8">
            <h2><?php echo htmlspecialchars($user['prenom'] . " " . $user['nom']); ?></h2>
            <h6><strong>Rôle :</strong> <?php echo htmlspecialchars($user['role']); ?></h6>
            <h6><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></h6>
            <h6><strong>Date d'inscription :</strong> <?php echo htmlspecialchars($user['created_at']); ?></h6>
            <?php if (!empty($user['cv'])): ?>
              <h6><strong>CV :</strong> <a href="<?php echo htmlspecialchars($baseUrl . $user['cv']); ?>" target="_blank">Voir mon CV</a></h6>
            <?php else: ?>
              <h6><strong>CV :</strong> Aucun CV téléchargé.</h6>
            <?php endif; ?>
            <div class="mt-3">
              <a href="edit_profile.php" class="btn btn-primary">Éditer</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
