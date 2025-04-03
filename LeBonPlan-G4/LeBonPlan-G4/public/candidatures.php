<?php
session_start();
// Pour l'accès admin, vous pouvez ajouter la vérification d'authentification ici
// if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: connexion.php');
//     exit;
// }
require_once '../Config/config.php';

// Requête pour récupérer les candidatures avec le nom de l'étudiant et le titre de l'offre
$sql = "SELECT c.id, c.date_candidature, c.cv, c.lettre_motivation,
               u.nom, u.prenom,
               o.titre AS offre_titre
        FROM candidatures c
        LEFT JOIN users u ON c.etudiant_id = u.id
        LEFT JOIN offres o ON c.offre_id = o.id
        ORDER BY c.date_candidature DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$candidatures = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion des Candidatures - LeBonPlan</title>
    <link rel="stylesheet" href="Style.css">
    <style>
        table { width: 90%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background: #f4f4f4; }
        .action-btn { background: #ff6600; color: #fff; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-danger { background: #cc0000; }
    </style>
</head>
<body>
    <header>
         <div class="header-container">
             <center><h4>Gestion des Candidatures</h4></center>
             <center><img src="./images/logo-lbp-header.png" alt="LeBonPlan Logo"></center>
             <nav>
                 <a href="admin_panel.php?section=dashboard">Dashboard</a> |
                 <a href="admin_panel.php?section=offres">Offres</a> |
                 <a href="admin_panel.php?section=entreprises">Entreprises</a> |
                 <a href="candidatures.php">Candidatures</a> |
                 <a href="logout.php">Déconnexion</a>
             </nav>
         </div>
    </header>

    <main>
         <h1 style="text-align:center;">Liste des Candidatures</h1>
         <?php if (!empty($candidatures)): ?>
         <table>
             <thead>
                 <tr>
                     <th>ID</th>
                     <th>Étudiant</th>
                     <th>Offre</th>
                     <th>Date</th>
                     <th>CV</th>
                     <th>Lettre de motivation</th>
                     <th>Actions</th>
                 </tr>
             </thead>
             <tbody>
                 <?php foreach ($candidatures as $cand): ?>
                 <tr>
                     <td><?php echo htmlspecialchars($cand['id']); ?></td>
                     <td><?php echo htmlspecialchars($cand['prenom'] . " " . $cand['nom']); ?></td>
                     <td><?php echo htmlspecialchars($cand['offre_titre']); ?></td>
                     <td><?php echo htmlspecialchars($cand['date_candidature']); ?></td>
                     <td>
                         <?php if (!empty($cand['cv'])): ?>
                             <a href="<?php echo htmlspecialchars($cand['cv']); ?>" target="_blank" class="action-btn">Voir CV</a>
                         <?php else: ?>
                             Aucun
                         <?php endif; ?>
                     </td>
                     <td>
                         <?php 
                         $lettre = $cand['lettre_motivation'];
                         // Afficher un extrait de la lettre
                         echo htmlspecialchars(substr($lettre, 0, 100)) . (strlen($lettre) > 100 ? '...' : '');
                         ?>
                         <br>
                         <a href="candidature_detail.php?id=<?php echo htmlspecialchars($cand['id']); ?>">Lire la suite</a>
                     </td>
                     <td>
                         <!-- Vous pouvez ajouter des boutons pour supprimer ou marquer comme lue -->
                         <form action="delete_candidature.php" method="post" style="display:inline;">
                             <input type="hidden" name="candidature_id" value="<?php echo htmlspecialchars($cand['id']); ?>">
                             <button type="submit" class="action-btn btn-danger" onclick="return confirm('Confirmer la suppression ?');">Supprimer</button>
                         </form>
                     </td>
                 </tr>
                 <?php endforeach; ?>
             </tbody>
         </table>
         <?php else: ?>
             <p style="text-align:center;">Aucune candidature trouvée.</p>
         <?php endif; ?>
    </main>

    <footer>
         <p style="text-align:center;">&copy;2025 - Tous droits réservés - Web4All</p>
    </footer>
</body>
</html>
