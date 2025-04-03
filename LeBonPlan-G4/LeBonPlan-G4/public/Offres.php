<?php 
// AUTHENTIFICATION
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}
require_once __DIR__ . '/../Config/config.php';

// Paramètres de pagination
$offresParPage = 3; // Nombre d'offres par page
$pageActuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Page actuelle
$offset = ($pageActuelle - 1) * $offresParPage;

// Requête pour compter le nombre total d'offres
$sqlCount = "SELECT COUNT(*) FROM offres";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->execute();
$totalOffres = $stmtCount->fetchColumn();
$totalPages = ceil($totalOffres / $offresParPage);

// Requête pour afficher les offres avec limite et offset
$sql = "SELECT o.*, e.nom AS entreprise, o.localisation AS lieu 
        FROM offres o 
        LEFT JOIN entreprises e ON o.entreprise_id = e.id 
        ORDER BY o.date_publication DESC 
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':limit', $offresParPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$offres = $stmt->fetchAll();

$pageTitle = "Offres - StageElevate";
$pageDescription = "Découvrez les offres de stage et alternance.";
include 'header.php';
?>
<link rel="stylesheet" href="Offre.css">
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
                <strong>Publiée le :</strong> <?php echo htmlspecialchars($offre['date_publication']); ?><br>
                <strong>Compétences :</strong> <?php echo htmlspecialchars($offre['competences']); ?>
              </p>
              <p class="card-text"><?php echo htmlspecialchars($offre['description']); ?></p>
              <a href="postuler.php?id=<?php echo $offre['id']; ?>" class="btn btn-primary">Postuler</a><br><br>
              <a href="wishlist_add.php?id=<?php echo $offre['id']; ?>" class="btn btn-secondary">Ajouter à ma wishlist</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      
      <!-- Liens de pagination -->
      <nav aria-label="Pagination">
        <ul class="pagination justify-content-center">
          <?php if ($pageActuelle > 1): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?php echo $pageActuelle - 1; ?>" aria-label="Précédent">
                <span aria-hidden="true">&laquo; Précédent</span>
              </a>
            </li>
          <?php endif; ?>
          
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php if ($i == $pageActuelle) echo 'active'; ?>">
              <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
          <?php endfor; ?>
          
          <?php if ($pageActuelle < $totalPages): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?php echo $pageActuelle + 1; ?>" aria-label="Suivant">
                <span aria-hidden="true">Suivant &raquo;</span>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php else: ?>
      <p class="text-center">Aucune offre n'est disponible pour le moment.</p>
    <?php endif; ?>
  </section>
</main>
<?php include 'footer.php'; ?>
