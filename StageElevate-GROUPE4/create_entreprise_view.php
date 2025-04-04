<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Créer une Entreprise - StageElevate</title>
    <link rel="stylesheet" href="create.css">
</head>
<body>
    <main>
        <h1>Créer une Nouvelle Entreprise</h1>
        <?php 
        if(isset($_SESSION['create_entreprise_error'])) {
            echo '<p style="color:red;">' . htmlspecialchars($_SESSION['create_entreprise_error']) . '</p>';
            unset($_SESSION['create_entreprise_error']);
        }
        ?>
        <form action="/process/create_entreprise_process.php" method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
            <br>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
            <br>
            <label for="email">Email de contact :</label>
            <input type="text" id="email" name="email" required>
            <br>
            <label for="telephone">Téléphone :</label>
            <input type="text" id="telephone" name="telephone" required>
            <br>
            <button type="submit" class="btn">Créer l'entreprise</button>
        </form>
    </main>
</body>
</html>
