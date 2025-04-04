<?php 
//AUTHENTIFICATION
////////////////////////////////
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}
require_once __DIR__ . '/../Config/config.php';
/////////////////////////////////////////

// Requête pour afficher les offres
$sql = "SELECT o.*, e.nom AS entreprise, o.localisation AS lieu 
        FROM offres o 
        LEFT JOIN entreprises e ON o.entreprise_id = e.id 
        ORDER BY o.date_publication DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$offres = $stmt->fetchAll();

$pageTitle = "Offres - StageElevate";
$pageDescription = "Découvrez les offres de stage et alternance.";
include 'header.php';
?>
  <link rel="stylesheet" href="Offre.css">

<!-- Contenu principal -->
<main>
  <section>
    <center><h1>Liste des Offres de Stage et Alternance</h1></center>

    <?php if (!empty($offres)): ?>
      <div class="d-flex flex-wrap justify-content-center">
        <?php foreach ($offres as $offre): ?>
          <div class="card m-3" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($offre['titre']); ?></h5>
              <p class="card-text">
                <strong>Entreprise :</strong> <?php echo htmlspecialchars($offre['entreprise']); ?><br>
                <strong>Lieu :</strong> <?php echo htmlspecialchars($offre['lieu']); ?><br>
                <strong>Publiée le :</strong> <?php echo htmlspecialchars($offre['date_publication']); ?>
                <strong>Competences :</strong> <?php echo htmlspecialchars($offre['competences']); ?>

              </p>
              <p class="card-text"><?php echo htmlspecialchars($offre['description']); ?></p>
              <a href="postuler.php?id=<?php echo $offre['id']; ?>" class="btn btn-primary">Postuler</a><br> <br>
              <a href="wishlist_add.php?id=<?php echo $offre['id']; ?>" class="btn btn-secondary">Ajouter à ma wishlist</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center">Aucune offre n'est disponible pour le moment.</p>
    <?php endif; ?>
  </section>
</main>

<?php include 'footer.php'; ?>
