<?php
session_start();
// Sécurité : autoriser seulement les admins
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}

require_once __DIR__ . '/Config/config.php';   // Fichier qui définit $pdo

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin_panel.php");
    exit;
}

// Récupérer l'offre
$stmt = $pdo->prepare("SELECT * FROM offres WHERE id = ?");
$stmt->execute([$id]);
$offre = $stmt->fetch();
if (!$offre) {
    echo "Offre non trouvée.";
    exit;
}

// Récupérer toutes les entreprises pour affichage du select
$entreprises = $pdo->query("SELECT id, nom FROM entreprises ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Modifier l'Offre - StageElevate</title>
    <link rel="stylesheet" href="create.css">
</head>
<body>
    <main>
        <h1>Modifier l'Offre</h1>
        <form action="process/edit_offre_process.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($offre['id']) ?>">

            <label for="entreprise_id">Entreprise :</label>
            <select id="entreprise_id" name="entreprise_id" required>
                <option value="">-- Sélectionner une entreprise --</option>
                <?php foreach ($entreprises as $entreprise): ?>
                    <option value="<?= $entreprise['id'] ?>"
                        <?= $entreprise['id'] == $offre['entreprise_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($entreprise['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>

            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($offre['titre']) ?>" required>
            <br>

            <label for="description">Description :</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($offre['description']) ?></textarea>
            <br>

            <label for="competences">Compétences :</label>
            <input type="text" id="competences" name="competences" value="<?= htmlspecialchars($offre['competences']) ?>" required>
            <br>

            <label for="base_remuneration">Base rémunération :</label>
            <input type="number" step="0.01" id="base_remuneration" name="base_remuneration" value="<?= htmlspecialchars($offre['base_remuneration']) ?>" required>
            <br>

            <label for="date_publication">Date Publication :</label>
            <input type="date" id="date_publication" name="date_publication" value="<?= htmlspecialchars($offre['date_publication']) ?>" required>
            <br>

            <label for="date_expiration">Date Expiration :</label>
            <input type="date" id="date_expiration" name="date_expiration" value="<?= htmlspecialchars($offre['date_expiration']) ?>" required>
            <br>

            <label for="localisation">Localisation :</label>
            <input type="text" id="localisation" name="localisation" value="<?= htmlspecialchars($offre['localisation']) ?>" required>
            <br>

            <button type="submit" class="btn">Sauvegarder les modifications</button>
        </form>
    </main>
</body>
</html>
