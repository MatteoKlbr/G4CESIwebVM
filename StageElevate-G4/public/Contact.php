<?php 
// Pas besoin d'appeler session_start() ici puisque header.php s'en charge
$pageTitle = "Contact - StageElevate";
$pageDescription = "Contactez-nous en utilisant notre formulaire.";
include 'header.php';
?>

<link rel="stylesheet" href="Contact.css">
<!-- Contenu principal -->
<main>
  <section>
    <center><h1>Nous sommes à votre écoute</h1></center>
    <p>
      Vous pouvez nous contacter directement via 
      <a href="mailto:info@stageelevate.fr">notre adresse de courriel</a> 
      ou utiliser le formulaire ci-dessous. Nous vous répondrons dans les délais les plus brefs.
    </p>
    <article>
      <form method="post" action="contact_process.php">
        <label>
          Nom complet<br>
          <input name="fullname" type="text" size="100" placeholder="Ex : Eden SMITH" required>
        </label>
        <br><br>
        <label>
          Votre message<br>
          <textarea name="feedbacks" rows="5" cols="100" placeholder="Décrivez votre problème/Question/Clarification..." required></textarea>
        </label>
        <br><br>
        <button type="submit" class="postuler">Envoyer</button>
        <button type="reset" class="postuler">Effacer</button>
      </form>
    </article>
  </section>
</main>

<?php include 'footer.php'; ?>
