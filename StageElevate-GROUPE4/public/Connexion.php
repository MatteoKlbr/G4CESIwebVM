<?php 
$pageTitle = "Connexion - StageElevate";
$pageDescription = "Connexion à StageAlternance, retrouvez vos opportunités de stage et alternance.";
include 'header.php';
?>
<link rel="stylesheet" href="login.css">

<!-- Contenu principal -->
<main>
  <section>
    <center><h1>Formulaire de connexion</h1></center>
    <?php 
    // Afficher un message d'erreur s'il existe
    if (isset($_SESSION['login_error'])) {
        echo '<p style="color:red;">' . $_SESSION['login_error'] . '</p>';
        unset($_SESSION['login_error']);
    }
    ?>
    <form action="../process/login_process.php" method="POST">
      <div class="form-group">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="motdepasse">Mot de passe :</label>
        <input type="password" id="motdepasse" name="motdepasse" required>
      </div>
      <button type="submit" class="btnn">Se connecter</button>
    </form>
  </section>
</main>

<?php include 'footer.php'; ?>
