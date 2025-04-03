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

$pageTitle = "Entreprises - LeBonPlan";
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

        <?php
          // Récupérer la moyenne des évaluations de l’entreprise
          $sqlEval = "SELECT AVG(evaluation) AS moyenne FROM evaluations WHERE entreprise_id = ?";
          $stmtEval = $pdo->prepare($sqlEval);
          $stmtEval->execute([$entreprise['id']]);
          $resultEval = $stmtEval->fetch();
          $moyenne = round($resultEval['moyenne'], 1);
        ?>

        <p class="etoiles">Évaluation :
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <?= $i <= round($moyenne) ? '⭐' : '☆' ?>
          <?php endfor; ?>
          (<?= $moyenne ?>/5)
        </p>

        <?php
          // Vérifier si l'utilisateur a déjà évalué cette entreprise
          $sqlCheck = "SELECT evaluation FROM evaluations WHERE entreprise_id = ? AND user_id = ?";
          $stmtCheck = $pdo->prepare($sqlCheck);
          $stmtCheck->execute([$entreprise['id'], $_SESSION['id']]);
          $dejaNote = $stmtCheck->fetch();
        ?>

        <?php if (!$dejaNote): ?>
          <form method="post" action="evaluer_entreprise.php">
            <input type="hidden" name="entreprise_id" value="<?= $entreprise['id'] ?>">
            <label for="evaluation">Votre note :</label>
            <select name="evaluation" required>
              <option value="">--</option>
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?> ⭐</option>
              <?php endfor; ?>
            </select>
            <button type="submit">Noter</button>
          </form>
        <?php else: ?>
          <p>Vous avez déjà noté cette entreprise : <?= $dejaNote['evaluation'] ?> ⭐</p>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>

      <p style="text-align: center;">Aucune entreprise trouvée.</p>
    <?php endif; ?>
  </section>
</main>

<?php include 'footer.php'; ?>
