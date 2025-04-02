<?php
// session_start();
// if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: connexion.php');
//     exit;
// }
require_once __DIR__ . '/public/config.php';   // Fichier qui définit $pdo

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin_panel.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM entreprises WHERE id = ?");
$stmt->execute([$id]);
$entreprise = $stmt->fetch();
if (!$entreprise) {
    echo "Entreprise non trouvée.";
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Modifier l'Entreprise - StageElevate</title>
    <link rel="stylesheet" href="create.css">
</head>
<body>
    <!-- <?php // include 'header.php'; ?> -->
    <main>
        <h1>Modifier l'Entreprise</h1>
        <form action="edit_entreprise_process.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($entreprise['id']); ?>">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($entreprise['nom']); ?>" required>
            <br>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($entreprise['description']); ?></textarea>
            <br>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($entreprise['email']); ?>" required>
            <br>
            <label for="telephone">Téléphone :</label>
            <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($entreprise['telephone']); ?>" required>
            <br>
            <button type="submit" class="btn">Sauvegarder</button>
        </form>
    </main>
    <!-- <?php // include 'footer.php'; ?> -->
</body>
</html>
