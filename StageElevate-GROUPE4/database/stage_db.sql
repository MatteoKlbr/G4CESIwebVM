-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 03 avr. 2025 à 22:11
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stage_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidatures`
--

CREATE TABLE `candidatures` (
  `id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `etudiant_id` int(11) NOT NULL,
  `date_candidature` timestamp NULL DEFAULT current_timestamp(),
  `cv` varchar(255) DEFAULT NULL,
  `lettre_motivation` text DEFAULT NULL,
  `apropos` text DEFAULT NULL,
  `majeur` enum('oui','non') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `candidatures`
--

INSERT INTO `candidatures` (`id`, `offre_id`, `etudiant_id`, `date_candidature`, `cv`, `lettre_motivation`, `apropos`, `majeur`) VALUES
(13, 6, 4, '2025-03-20 21:06:37', 'uploads/cv/cv_67dc835dc00190.94301675.pdf', 'Bonjour je m\'appelle Mahamadou Bomou je suis a la recherche d\'un stage de 12 a 15 semaines', NULL, 'oui'),
(14, 7, 4, '2025-03-26 10:15:01', 'uploads/cv/cv_67e3d3a53fedb8.67162819.pdf', 'usyhguohijmzouibidhjdoidcuboud', NULL, 'oui'),
(0, 8, 6, '2025-04-02 09:13:30', 'uploads/cv/cv_67ecfac8be1d82.91619942.pdf', 'Je m\'appelle Hedi', 'vehicule', 'oui'),
(0, 8, 6, '2025-04-02 09:15:12', 'uploads/cv/cv_67ecfac8be1d82.91619942.pdf', 'uyfiuog', 'permis', 'oui'),
(0, 8, 6, '2025-04-02 09:18:15', 'uploads/cv/cv_67ecfac8be1d82.91619942.pdf', 'FEUR BHBEJCBF HB BHBGYE', 'vehicule', 'oui');

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id`, `nom`, `description`, `email`, `telephone`, `created_at`) VALUES
(1, 'Innovatech Industries', 'Innovatech Industries est une entreprise leader dans le domaine de l\'ingénierie et de l\'innovation technologique. Nous proposons des solutions avancées en automatisation industrielle et en gestion de données, tout en nous engageant à offrir des produits durables et à haute performance.', 'info@innovatechindustries.com', '+33 1 75 89 34 21', '2025-02-24 12:46:52'),
(4, 'Nexa Solutions', 'Nexa Solutions est une entreprise dynamique spécialisée dans la fourniture de services informatiques et de solutions numériques personnalisées. Nous nous engageons à aider nos clients à optimiser leur infrastructure IT et à améliorer leur productivité grâce à des technologies de pointe.', 'contact@nexasolutions.com', '+33 4 56 78 90 12', '2025-03-26 10:17:13');

-- --------------------------------------------------------

--
-- Structure de la table `evaluations`
--

CREATE TABLE `evaluations` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `evaluation` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `evaluations`
--

INSERT INTO `evaluations` (`id`, `entreprise_id`, `user_id`, `evaluation`, `created_at`) VALUES
(0, 3, 6, 5, '2025-04-03 13:33:55'),
(0, 4, 6, 5, '2025-04-03 14:17:05'),
(0, 1, 6, 5, '2025-04-03 14:17:13');

-- --------------------------------------------------------

--
-- Structure de la table `offres`
--

CREATE TABLE `offres` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `competences` varchar(255) DEFAULT NULL,
  `base_remuneration` decimal(10,2) DEFAULT 0.00,
  `date_publication` date DEFAULT NULL,
  `date_expiration` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `localisation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `offres`
--

INSERT INTO `offres` (`id`, `entreprise_id`, `titre`, `description`, `competences`, `base_remuneration`, `date_publication`, `date_expiration`, `created_at`, `localisation`) VALUES
(5, 1, 'Ingénieur en Cybersécurité', 'Rejoignez notre équipe en tant qu\'Ingénieur en Cybersécurité pour renforcer la sécurité de nos systèmes. Vous serez responsable de l\'analyse des menaces, de la mise en place de solutions de protection et de la gestion des incidents de sécurité.', 'Sécurité des systèmes, Firewall, Cryptographie, Pentesting', 4000.00, '2025-03-05', '2025-05-14', '2025-03-04 14:31:02', 'Lyon'),
(6, 4, 'Ingénieur en Automatisation Industrielle', 'Innovatech Industries cherche un ingénieur spécialisé en automatisation industrielle pour concevoir et mettre en œuvre des systèmes automatisés dans nos processus de production. Une expérience avec des outils de contrôle et des systèmes SCADA est un plus.', 'Automatisation, SCADA, PLC, Programmation industrielle', 3700.00, '2025-03-19', '2025-04-03', '2025-03-18 13:34:01', 'Bordeaux'),
(8, 1, 'Développeur Full-Stack', 'Nous recherchons un Développeur Full-Stack passionné par la création d\'applications web robustes et évolutives. Le candidat idéal maîtrisera JavaScript, Node.js et React, et sera capable de travailler sur des projets de grande envergure.', 'JavaScript, Node.js, React, SQL, Git', 3500.00, '2025-03-01', '2025-06-06', '2025-03-20 22:20:54', 'Paris'),
(9, 4, 'Data Scientist', 'Innovatech Industries recrute un Data Scientist pour analyser et exploiter les données afin de guider les décisions stratégiques. Vous utiliserez des outils de machine learning et d’analyse de données pour optimiser nos processus industriels.', 'Python, Machine Learning, SQL, Analyse de données', 3800.00, '2025-02-21', '2025-10-23', '2025-03-21 08:19:45', 'Nice');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('etudiant','pilote','admin') DEFAULT 'etudiant',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL,
  `statut_recherche` varchar(50) DEFAULT 'Recherche active',
  `last_login` datetime DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `role`, `created_at`, `avatar`, `statut_recherche`, `last_login`, `cv`) VALUES
(6, 'Bomou', 'Mahamadou', 'mahamadou.bomou@viacesi.fr', '$2y$10$rFsORUf0a1oUHqusvUTzE.yWeoSUYrm7knvYCUBIyREofbGGZKWay', 'admin', '2025-03-16 20:17:12', '', 'Recherche active', '2025-04-03 21:24:02', 'uploads/cv/cv_67ecfac8be1d82.91619942.pdf'),
(0, 'Rihani', 'Hedi', 'hedi.rihani@viacesi.fr', '$2y$10$B1tpyEOtVYTlie8dMxPq9eZXgIU7ocUcrAvJHFls3dWf1o9TLEtPS', 'etudiant', '2025-04-03 15:22:50', NULL, 'Recherche active', NULL, NULL),
(0, 'JUNICO', 'Maximilien', 'maximilien.junico@viacesi.fr', '$2y$10$OyrlYr/lyvtTduMAL7baYOz3Fe7UB6Yn5Ahq37Ajm/li4HVV065CK', 'pilote', '2025-04-03 19:35:41', NULL, 'Recherche active', NULL, NULL),
(0, 'KLEBER', 'Matteo', 'matteo.kleber@viacesi.fr', '$2y$10$SGBeFU7XwHHCXz7sLzY/eensMMeL7alAz9m5M9l1HhuHCSwhFCaPC', 'pilote', '2025-04-03 19:36:35', NULL, 'Recherche active', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `etudiant_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wishlist`
--

INSERT INTO `wishlist` (`id`, `etudiant_id`, `offre_id`, `created_at`) VALUES
(1, 4, 5, '2025-03-18 10:28:16'),
(2, 4, 6, '2025-03-18 10:28:22'),
(3, 4, 7, '2025-03-20 22:16:26'),
(4, 4, 8, '2025-03-20 22:18:00'),
(5, 4, 9, '2025-03-21 08:21:26'),
(0, 6, 9, '2025-04-03 13:35:18'),
(0, 6, 8, '2025-04-03 18:37:43'),
(0, 6, 5, '2025-04-03 18:37:52');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
