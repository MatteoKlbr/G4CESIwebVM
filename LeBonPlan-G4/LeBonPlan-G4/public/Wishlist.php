<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once __DIR__ . '/../Config/config.php';

$user_id = $_SESSION['id'];

// Paramètres de pagination pour la wishlist
$wishlistParPage = 3; // Nombre d'offres par page
$pageActuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Page actuelle
$offset = ($pageActuelle - 1) * $wishlistParPage;

// Requête pour compter le nombre total d'offres en wishlist pour l'étudiant connecté
$sqlCount = "SELECT COUNT(*) FROM wishlist w WHERE w.etudiant_id = :user_id";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmtCount->execute();
$totalWishlist = $stmtCount->fetchColumn();
$totalPages = ceil($totalWishlist / $wishlistParPage);

// Requête pour récupérer les offres en wishlist avec limite et offset
$sql = "SELECT o.id AS offre_id, o.titre, o.description, o.localisation 
        FROM wishlist w
        JOIN offres o ON w.offre_id = o.id
        WHERE w.etudiant_id = :user_id
        ORDER BY o.date_publication DESC 
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':limit', $wishlistParPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$wishlist = $stmt->fetchAll();

$pageTitle = "Wishlist - LeBonPlan";
$pageDescription = "Consultez et gérez vos offres favorites de stages et alternances.";
include 'header.php';
?>
<link rel="stylesheet" href="wishlist.css">

<main>
  <section>
    <center><h1>Mes offres de stage et alternance favorites</h1></center>
    <?php if (!empty($wishlist)): ?>
      <div class="wishlist-container">
        <?php foreach ($wishlist as $item): ?>
          <article class="wishlist-offer">
            <h2><?php echo htmlspecialchars($item['titre']); ?></h2>
            <p><strong>Lieu :</strong> <?php echo htmlspecialchars($item['localisation']); ?></p>
            <p><?php echo htmlspecialchars($item['description']); ?></p>
            <div class="wishlist-buttons">
              <a href="wishlist_remove.php?offre_id=<?php echo $item['offre_id']; ?>" class="btn btn-danger">Retirer</a>
              <a href="postuler.php?id=<?php echo $item['offre_id']; ?>" class="btn btn-primary">Postuler</a>
            </div>
          </article>
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
      <p class="text-center">Aucune offre n’a été ajoutée à la wishlist.</p>
    <?php endif; ?>
  </section>
</main>

<?php include 'footer.php'; ?>
