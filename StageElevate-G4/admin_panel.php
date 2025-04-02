<?php
session_start();

// Pour tester, simuler un admin si non connecté
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['id'] = 1; // ID d'un admin existant
    $_SESSION['role'] = 'admin';
}

require_once __DIR__ . '../Controllers/AdminController.php';
use Admin\AdminController;

$section = $_GET['section'] ?? 'dashboard';

$adminController = new AdminController();

// Traiter les actions POST
$adminController->handlePost($section);

// Récupérer un éventuel message
$message = $adminController->message;
?>
<?php include __DIR__ . '/admin_header.php'; ?>

<?php if ($message): ?>
    <div class="message" style="text-align:center; color:green; margin:10px 0;">
        <?= htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<main>
<?php
switch ($section) {
    case 'users':
        echo '<h1 class="section-title">Gestion des Utilisateurs</h1>';
        $users = $adminController->getUsers();
        if ($users) {
            echo '<table>';
            echo '<thead><tr>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Email</th>
                  <th>Rôle</th>
                  <th>Date d\'inscription</th>
                  <th>Actions</th>
                  </tr></thead><tbody>';
            foreach ($users as $user) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($user['nom']) . '</td>';
                echo '<td>' . htmlspecialchars($user['prenom']) . '</td>';
                echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                echo '<td>' . htmlspecialchars($user['role']) . '</td>';
                echo '<td>' . htmlspecialchars($user['created_at']) . '</td>';
                echo '<td>
                     <form action="admin_panel.php?section=users" method="post" style="display:inline;">
                         <input type="hidden" name="action" value="delete_user">
                         <input type="hidden" name="user_id" value="' . htmlspecialchars($user['id']) . '">
                         <button type="submit" class="action-btn btn-danger" onclick="return confirm(\'Confirmer la suppression ?\');">Supprimer</button>
                     </form>
                     </td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p style="text-align:center;">Aucun utilisateur trouvé.</p>';
        }
        break;

    case 'offres':
        echo '<h1 class="section-title">Gestion des Offres</h1>';
        // Ajoute un lien pour créer une offre
        echo '<div style="text-align:center;"><a href="create_offre.php" class="action-btn">Ajouter une offre</a></div>';
        $offres = $adminController->getOffres();
        echo '<h1 class="section-title">Liste des Offres</h1>';
        if ($offres) {
            echo '<table>';
            echo '<thead><tr>
                  <th>Titre</th>
                  <th>Entreprise</th>
                  <th>Localisation</th>
                  <th>Date Publication</th>
                  <th>Actions</th>
                  </tr></thead><tbody>';
            foreach ($offres as $offre) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($offre['titre']) . '</td>';
                echo '<td>' . htmlspecialchars($offre['entreprise'] ?? 'Non défini') . '</td>';
                echo '<td>' . htmlspecialchars($offre['localisation']) . '</td>';
                echo '<td>' . htmlspecialchars($offre['date_publication']) . '</td>';
                echo '<td>
                      <a href="edit_offre.php?id=' . htmlspecialchars($offre['id']) . '" class="action-btn">Modifier</a> |
                      <form action="admin_panel.php?section=offres" method="post" style="display:inline;">
                          <input type="hidden" name="action" value="delete_offre">
                          <input type="hidden" name="offre_id" value="' . htmlspecialchars($offre['id']) . '">
                          <button type="submit" class="action-btn btn-danger" onclick="return confirm(\'Confirmer la suppression ?\');">Supprimer</button>
                      </form>
                      </td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p style="text-align:center;">Aucune offre publiée pour le moment.</p>';
        }
        break;

    case 'entreprises':
        echo '<h1 class="section-title">Gestion des Entreprises</h1>';
        echo '<div style="text-align:center;"><a href="create_entreprise.php" class="action-btn">Ajouter une entreprise</a></div>';
        $entreprises = $adminController->getEntreprises();
        if ($entreprises) {
            echo '<table>';
            echo '<thead><tr>
                  <th>Nom</th>
                  <th>Description</th>
                  <th>Email</th>
                  <th>Téléphone</th>
                  <th>Actions</th>
                  </tr></thead><tbody>';
            foreach ($entreprises as $entreprise) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($entreprise['nom']) . '</td>';
                echo '<td>' . htmlspecialchars($entreprise['description']) . '</td>';
                echo '<td>' . htmlspecialchars($entreprise['email']) . '</td>';
                echo '<td>' . htmlspecialchars($entreprise['telephone']) . '</td>';
                echo '<td>
                     <a href="edit_entreprise.php?id=' . htmlspecialchars($entreprise['id']) . '" class="btn btn-primary">Modifier</a> 
                      <form action="admin_panel.php?section=entreprises" method="post" style="display:inline;">
                          <input type="hidden" name="action" value="delete_entreprise">
                          <input type="hidden" name="entreprise_id" value="' . htmlspecialchars($entreprise['id']) . '">
                          <button type="submit" class="action-btn btn-danger" onclick="return confirm(\'Confirmer la suppression ?\');">Supprimer</button>
                      </form>
                      </td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p style="text-align:center;">Aucune entreprise trouvée.</p>';
        }
        break;

    case 'candidatures':
        echo '<h1 class="section-title">Gestion des Candidatures</h1>';
        $candidatures = $adminController->getCandidatures();
        if ($candidatures) {
            echo '<table>';
            echo '<thead><tr>
                  <th>Étudiant</th>
                  <th>Offre</th>
                  <th>Date</th>
                  <th>CV</th>
                  <th>Lettre de motivation</th>
                  <th>Actions</th>
                  </tr></thead><tbody>';
            foreach ($candidatures as $cand) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($cand['prenom'] . " " . $cand['nom']) . '</td>';
                echo '<td>' . htmlspecialchars($cand['offre_titre']) . '</td>';
                echo '<td>' . htmlspecialchars($cand['date_candidature']) . '</td>';
                echo '<td>';
                if (!empty($cand['cv'])) {
                    echo '<a href="' . htmlspecialchars($cand['cv']) . '" target="_blank" class="action-btn">Voir CV</a>';
                } else {
                    echo 'Aucun';
                }
                echo '</td>';
                echo '<td>' . htmlspecialchars(substr($cand['lettre_motivation'], 0, 100)) . (strlen($cand['lettre_motivation']) > 100 ? '...' : '') . '</td>';
                echo '<td>
                      <form action="admin_panel.php?section=candidatures" method="post" style="display:inline;">
                          <input type="hidden" name="action" value="delete_candidature">
                          <input type="hidden" name="candidature_id" value="' . htmlspecialchars($cand['id']) . '">
                          <button type="submit" class="action-btn btn-danger" onclick="return confirm(\'Confirmer la suppression ?\');">Supprimer</button>
                      </form>
                      </td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p style="text-align:center;">Aucune candidature trouvée.</p>';
        }
        break;

    default:
        // Dashboard par défaut
        $total_users = $adminController->getTotalUsers();
        $total_offres = $adminController->getTotalOffres();
        $total_enterprises = $adminController->getTotalEntreprises();
        echo '<h1 class="section-title">Dashboard Administrateur</h1>';
        echo '<div class="stats">';
        echo '<div class="stat"><h3>Total Utilisateurs</h3><p>' . $total_users . '</p></div>';
        echo '<div class="stat"><h3>Total Offres</h3><p>' . $total_offres . '</p></div>';
        echo '<div class="stat"><h3>Total Entreprises</h3><p>' . $total_enterprises . '</p></div>';
        echo '</div>';
        break;
    }
    ?>
</main>

<footer>
    <p style="text-align:center;">&copy;2025 - Tous droits réservés - StageElevate</p>
</footer>
</body>
</html>
