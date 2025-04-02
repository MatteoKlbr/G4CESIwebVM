<?php 
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once __DIR__ . '/../Config/config.php';

$sql = "SELECT id, nom, description FROM entreprises ORDER BY nom ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$entreprises = $stmt->fetchAll();

$pageTitle = "Entreprises - StageElevate";
$pageDescription = "Découvrez les entreprises partenaires proposant des offres de stage et alternance.";
include 'header.php';
?>
<link rel="stylesheet" href="Entreprise.css">
<main>
  <section>
    <center><h1>Nos Entreprises Partenaires</h1></center>
    <p>Retrouvez ici les informations des entreprises qui recrutent des étudiants en stage et alternance.</p>

    <?php if (!empty($entreprises)): ?>
      <div class="entreprises-container">
        <?php foreach ($entreprises as $entreprise): ?>
          <div class="entreprise-item" style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
            <p><strong><?= htmlspecialchars($entreprise['nom']); ?></strong></p>
            <p><?= nl2br(htmlspecialchars($entreprise['description'])); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p style="text-align: center;">Aucune entreprise trouvée.</p>
    <?php endif; ?>
  </section>
</main>

<?php include 'footer.php'; ?>
