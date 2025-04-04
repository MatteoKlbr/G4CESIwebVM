<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../Config/config.php';

if (isset($_SESSION['id'])) {
    $stmt = $pdo->prepare("SELECT id, nom, prenom, email, role, created_at, avatar, cv FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $user = $stmt->fetch();
}

if (!isset($pageTitle)) {
    $pageTitle = "StageElevate";
}
if (!isset($pageDescription)) {
    $pageDescription = "Bienvenue sur StageElevate, le site de gestion d'offres de stages et d'alternances.";
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Bomou Mahamadou">
  <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Votre CSS personnalisé -->
  <link rel="stylesheet" href="header.css">
  <title><?php echo htmlspecialchars($pageTitle); ?></title>
</head>
<body>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-orange px-4">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" 
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
      <img src="StageElevate.png" width="150" height="60" alt="StageElevate Logo">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link text-white" href="Accueil.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="Entreprise.php">Entreprises</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="Offres.php">Offres</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="Wishlist.php">Wishlist</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="Contact.php">Contact</a></li>
      </ul>

      <div class="d-flex gap-2">
        <?php if (isset($_SESSION['id'])): ?>
          <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#profileModal">
            Mon Profil
          </button>
          <a href="logout.php" class="btn btn-light btn-sm">Déconnexion</a>
        <?php else: ?>
          <a href="connexion.php" class="btn btn-light btn-sm">Connexion</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</header>
