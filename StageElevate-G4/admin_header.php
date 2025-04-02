<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Bomou Mahamadou">
  <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
  <title>Dashboard Admin</title>

  <!-- CSS -->
  <link rel="stylesheet" href="Style1.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #007bff; padding: 10px 20px;">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold text-white m-0" href="#">StageElevate</a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar"
          aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse" id="adminNavbar">
        <div class="d-flex flex-column flex-lg-row w-100 justify-content-between px-3">
          <!-- Bloc gauche -->
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link text-white" href="admin_panel.php?section=dashboard">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="admin_panel.php?section=users">Utilisateurs</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="admin_panel.php?section=offres">Offres</a></li>
          </ul>

          <!-- Bloc droit -->
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link text-white" href="admin_panel.php?section=entreprises">Entreprises</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="admin_panel.php?section=candidatures">Candidatures</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="Inscription.php">Inscription</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="public/logout.php">Déconnexion</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Ton contenu principal ici -->

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
