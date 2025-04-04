<?php
session_start();
require_once __DIR__ . '../Config/config.php';

$entreprises = $pdo->query("SELECT id, nom FROM entreprises ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Créer une Offre - StageElevate</title>
    <link rel="stylesheet" href="create.css">
</head>
<body>
<main>
    <h1>Créer une Nouvelle Offre</h1>
    <?php 
    if(isset($_SESSION['create_offre_error'])) { 
        echo '<p style="color:red;">' . htmlspecialchars($_SESSION['create_offre_error']) . '</p>'; 
        unset($_SESSION['create_offre_error']);
    }
    ?>
    <form action="process/create_offre_process.php" method="post">
        <label for="entreprise_id">Entreprise :</label>
        <select id="entreprise_id" name="entreprise_id" required>
            <option value="">-- Sélectionner une entreprise --</option>
            <?php foreach ($entreprises as $entreprise): ?>
                <option value="<?= htmlspecialchars($entreprise['id']) ?>">
                    <?= htmlspecialchars($entreprise['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required>
        <br>
        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <label for="competences">Compétences :</label>
        <input type="text" id="competences" name="competences" required>
        <br>
        <label for="base_remuneration">Base rémunération :</label>
        <input type="text" id="base_remuneration" name="base_remuneration" required>
        <br>
        <label for="date_publication">Date Publication :</label>
        <input type="date" id="date_publication" name="date_publication" required>
        <br>
        <label for="date_expiration">Date Expiration :</label>
        <input type="date" id="date_expiration" name="date_expiration" required>
        <br>
        <label for="localisation">Localisation :</label>
        <input type="text" id="localisation" name="localisation" required>
        <br>
        <button type="submit" class="btn">Créer l'offre</button>
    </form>
</main>
</body>
</html>
