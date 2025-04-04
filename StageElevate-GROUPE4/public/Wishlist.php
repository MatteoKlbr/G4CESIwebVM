<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

require_once __DIR__ . '/../Config/config.php';


// Récupération de la liste des offres en wishlist pour l'étudiant connecté
$user_id = $_SESSION['id'];
$sql = "SELECT o.id AS offre_id, o.titre, o.description, o.localisation 
        FROM wishlist w
        JOIN offres o ON w.offre_id = o.id
        WHERE w.etudiant_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$wishlist = $stmt->fetchAll();

$pageTitle = "Wishlist - StageElevate";
$pageDescription = "Consultez et gérez vos offres favorites de stages et alternances.";
include 'header.php';
?>
<link rel="stylesheet" href="wishlist.css">

<!-- Contenu principal -->
<main>
  <section>
    <center><h1>Mes offres de stage et alternance favorites</h1></center>
    <?php if (!empty($wishlist)): ?>
      <?php foreach ($wishlist as $item): ?>
        <article class="wishlist-offer">
          <center><h2><?php echo htmlspecialchars($item['titre']); ?></h2></center>
          <center><p><strong>Lieu :</strong> <?php echo htmlspecialchars($item['localisation']); ?></p></center>
          <center><p><?php echo htmlspecialchars($item['description']); ?></p></center>
          
          <!-- Lien pour retirer de la wishlist -->
          <center><a href="postuler.php?id=<?php echo $item['offre_id']; ?>" class="btn btn-primary">Postuler</a><hr></center>
          <center><a href="wishlist_remove.php?offre_id=<?php echo $item['offre_id']; ?>" class="btn btn-primary">Retirer de la wishlist</a></center>
        </article>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">Aucune offre n’a été ajoutée à la wishlist.</p>
    <?php endif; ?>
  </section>
</main>

<?php include 'footer.php'; ?>
