-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 23 mai 2020 à 10:52
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `aceem`
--

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `classe_id` int(11) NOT NULL,
  `classe_niveau` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

CREATE TABLE `eleves` (
  `eleve_id` int(11) NOT NULL,
  `eleve_photo` varchar(255) NOT NULL,
  `eleve_nom` varchar(255) NOT NULL,
  `eleve_prenom` varchar(100) NOT NULL,
  `eleve_adresse` varchar(100) NOT NULL,
  `eleve_date_naissance` date NOT NULL,
  `eleve_matricule` varchar(20) NOT NULL,
  `eleve_numero` int(11) NOT NULL,
  `eleve_date_inscription` date NOT NULL,
  `eleve_classe_param_fk` int(11) NOT NULL,
  `eleve_classe_cat_param_fk` int(11) NOT NULL,
  `eleve_classe_mention_param_fk` int(11) NOT NULL,
  `eleve_classe_session_param_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE `groupes` (
  `groupe_id` int(11) NOT NULL,
  `groupe_nom` varchar(100) NOT NULL,
  `groupe_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `groupes`
--

INSERT INTO `groupes` (`groupe_id`, `groupe_nom`, `groupe_description`) VALUES
(1, 'admin', 'Administrateur du site');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `menu_nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_nom`) VALUES
(1, 'utilisateurs'),
(2, 'groupes'),
(3, 'historiques'),
(4, 'parametrages'),
(5, 'eleves'),
(6, 'paiements'),
(7, 'changement de classe'),
(8, 'Deperdition');

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `paiement_id` int(11) NOT NULL,
  `paiement_total` int(11) NOT NULL,
  `paiement_montant` double NOT NULL,
  `paiement_eleve_fk` int(11) NOT NULL,
  `paiement_status_param_fk` int(11) NOT NULL,
  `paiement_type_paiement_param_fk` int(11) NOT NULL,
  `paiement_mode_paiement_param_fk` int(11) NOT NULL,
  `paiement_commentaire` text,
  `paiement_date_depot` datetime NOT NULL,
  `paiement_date_maj` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `param_divers`
--

CREATE TABLE `param_divers` (
  `param_id` int(11) NOT NULL,
  `param_table` varchar(255) NOT NULL,
  `param_sigle` varchar(255) NOT NULL,
  `param_valeur` varchar(255) NOT NULL,
  `param_description` varchar(255) NOT NULL,
  `param_ordre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `param_divers`
--

INSERT INTO `param_divers` (`param_id`, `param_table`, `param_sigle`, `param_valeur`, `param_description`, `param_ordre`) VALUES
(1, 'type_paiement', 'ecolage', 'ecolage', 'Ecolage', 5),
(3, 'categorie_session', 'ss', 'ss', 'SS', 1),
(4, 'categorie_session', 'tms', 'tms', 'TMS', 2),
(5, 'categorie_session', 'am', 'am', 'AM', 3),
(11, 'type_paiement', 'droit', 'droit', 'Droit', 4),
(13, 'type_paiement', 'bacc', 'bacc', 'BACC', 6),
(14, 'type_paiement', 'bepc', 'bepc', 'BEPC', 7),
(15, 'type_paiement', 'carnet', 'carnet', 'CARNET', 9),
(16, 'type_paiement', 'carte', 'carte', 'CARTE', 10),
(18, 'type_paiement', 'certificat', 'certificat', 'CERTIFICAT', 11),
(19, 'type_paiement', 'changement_de_classe', 'changement_de_classe', 'CHANGEMENT DE CLASSE', 12),
(20, 'type_paiement', 'examen_blanc', 'examen_blanc', 'EXAMEN BLANC', 13),
(22, 'type_paiement', 'identite', 'identite', 'IDENTITE', 14),
(23, 'type_paiement', 'relever_de_note', 'relever_de_note', 'RELEVER DE NOTE', 15),
(24, 'type_paiement', 'suppl_matiere', 'suppl_matiere', 'MATIERE SUPPLEMENTAIRE', 16),
(25, 'type_paiement', 'tee_shirt', 'tee_shirt', 'TEE-SHIRT', 17),
(26, 'type_paiement', 'transfert', 'transfert', 'TRANSFERT', 18),
(27, 'mode_paiement', 'normal', 'normal', 'NORMAL', 19),
(28, 'mode_paiement', 'reduit', 'reduit', 'REDUIT', 20),
(31, 'categorie_session', 'ss_tms', 'ss_tms', 'SS+TMS', 0),
(32, 'categorie_session', 'am_ss', 'am_ss', 'AM+SS', 0),
(33, 'categorie_session', 'am_tms', 'am_tms', 'AM+TMS', 0),
(34, 'categorie_session', 'am_ss_tms', 'am_ss_tms', 'AM+SS+TMS', 0),
(35, 'classe', 'troisième', 'troisième', 'Troisième', 0),
(36, 'mention', 'lycee', 'bacc_a', 'BACC A', 0),
(37, 'mention', 'lycee', 'bacc_c', 'BACC C', 0),
(38, 'mention', 'lycee', 'bacc_d', 'BACC D', 0),
(39, 'mention', 'lycee', 'technique', 'technique', 0),
(40, 'mention', 'universitaire', 'gestion', 'gestion', 0),
(41, 'classe', 'l1', 'l1', 'License1', 3),
(42, 'classe', 'l2', 'l2', 'License2', 0),
(43, 'classe', 'l3', 'l3', 'License3', 0),
(44, 'classe', 'm1', 'm1', 'Master1', 0),
(45, 'classe', 'm2', 'm2', 'Master2', 0),
(46, 'mention', 'universitaire', 'madagascar_business_school', 'MADAGASCAR BUSINESS SCHOOL', 0),
(47, 'mention', 'universitaire', 'sciences_economiques_etude_du_developpement', 'SCIENCES ECONOMIQUES & ETUDE DU DEVELOPPEMENT', 0),
(48, 'mention', 'universitaire', 'droit_science_politique', 'DROIT & SCIENCE POLITIQUE', 0),
(49, 'mention', 'universitaire', 'communication', 'COMMUNICATION', 0),
(50, 'mention', 'universitaire', 'sciences_de_la_sante', 'SCIENCES DE LA SANTE', 0),
(51, 'mention', 'universitaire', 'informatiques_electroniques', 'INFORMATIQUES & ELECTRONIQUES', 0),
(52, 'categorie_classe', '1', '1', '1', 0),
(53, 'categorie_classe', '2', '2', '2', 0),
(54, 'categorie_classe', '3', '3', '3', 0),
(55, 'categorie_classe', '4', '4', '4', 0),
(56, 'mention', 'option_a', 'option_a', 'Option A', 0),
(57, 'mention', 'option_b', 'option_b', 'Option B', 0),
(60, 'status_paiement', 'paiement_complet', 'complet', 'complet', 1),
(61, 'status_paiement', 'paiement_partiel', 'partiel', 'partiel', 1),
(62, 'classe', 'terminal', 'terminal', 'Terminal', 2),
(63, 'classe', '6eme', '6eme', '6ème', 0),
(64, 'classe', '5eme', '5eme', '5ème', 0),
(65, 'classe', '4eme', '4eme', '4ème', 0),
(66, 'categorie_classe', '5', '5', '5', 0),
(67, 'categorie_classe', '6', '6', '6', 0),
(68, 'categorie_classe', '7', '7', '7', 0),
(69, 'categorie_classe', '8', '8', '8', 0),
(70, 'categorie_classe', '9', '9', '9', 0),
(71, '', '', '', '', 0),
(72, '', '', '', '', 0),
(73, 'categorie_classe', '10', '10', '10', 0),
(74, 'categorie_classe', '11', '11', '11', 0),
(75, 'categorie_classe', '12', '12', '12', 0),
(76, 'categorie_classe', '13', '13', '13', 0),
(77, 'categorie_classe', '14', '14', '14', 0),
(78, 'categorie_classe', '15', '15', '15', 0),
(79, 'categorie_classe', '16', '16', '16', 0),
(80, 'categorie_classe', '17', '17', '17', 0),
(81, 'categorie_classe', '18', '18', '18', 0),
(82, 'categorie_classe', '19', '19', '19', 0),
(83, 'categorie_classe', '20', '20', '20', 0),
(84, 'categorie_classe', '21', '21', '21', 0),
(85, 'categorie_classe', '22', '22', '22', 0),
(86, 'categorie_classe', '23', '23', '23', 0),
(87, 'categorie_classe', '24', '24', '24', 0),
(88, 'categorie_classe', '25', '25', '25', 0),
(89, 'categorie_classe', '26', '26', '26', 0),
(90, 'categorie_classe', '27', '27', '27', 0),
(91, 'categorie_classe', '28', '28', '28', 0),
(92, 'categorie_classe', '29', '29', '29', 0),
(93, 'categorie_classe', '30', '30', '30', 0);

-- --------------------------------------------------------

--
-- Structure de la table `privileges`
--

CREATE TABLE `privileges` (
  `privilege_id` int(11) NOT NULL,
  `privilege_menu_fk` int(11) NOT NULL,
  `privilege_groupe_fk` int(11) NOT NULL,
  `privilege_is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `privileges`
--

INSERT INTO `privileges` (`privilege_id`, `privilege_menu_fk`, `privilege_groupe_fk`, `privilege_is_active`) VALUES
(67, 1, 1, 1),
(68, 2, 1, 1),
(69, 3, 1, 1),
(70, 4, 1, 1),
(71, 5, 1, 1),
(72, 6, 1, 1),
(73, 7, 1, 1),
(74, 8, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `utilisateur_id` int(11) NOT NULL,
  `utilisateur_nom` varchar(255) NOT NULL,
  `utilisateur_pseudo` varchar(255) NOT NULL,
  `utilisateur_email` varchar(255) NOT NULL,
  `utilisateur_groupe_fk` int(11) NOT NULL,
  `utilisateur_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`utilisateur_id`, `utilisateur_nom`, `utilisateur_pseudo`, `utilisateur_email`, `utilisateur_groupe_fk`, `utilisateur_password`) VALUES
(3, 'admin', 'admin', 'admin@admin.com', 1, '98a427e034649e41f2d61d0fcf0c593e');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`classe_id`);

--
-- Index pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD PRIMARY KEY (`eleve_id`),
  ADD KEY `eleve_classe_fk` (`eleve_classe_param_fk`),
  ADD KEY `eleve_etat_param_fk` (`eleve_classe_cat_param_fk`),
  ADD KEY `eleve_classe_mention_param_fk` (`eleve_classe_mention_param_fk`),
  ADD KEY `eleve_classe_session_param_fk` (`eleve_classe_session_param_fk`);

--
-- Index pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD PRIMARY KEY (`groupe_id`);

--
-- Index pour la table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`paiement_id`),
  ADD KEY `ecolage_montant_fk` (`paiement_montant`),
  ADD KEY `ecolage_periode_param_fk` (`paiement_mode_paiement_param_fk`),
  ADD KEY `paiement_type_param_fk` (`paiement_type_paiement_param_fk`),
  ADD KEY `paiement_eleve_fk` (`paiement_eleve_fk`),
  ADD KEY `paiement_status_param_fk` (`paiement_status_param_fk`);

--
-- Index pour la table `param_divers`
--
ALTER TABLE `param_divers`
  ADD PRIMARY KEY (`param_id`);

--
-- Index pour la table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`privilege_id`),
  ADD KEY `privilege_menu_fk` (`privilege_menu_fk`),
  ADD KEY `privilege_utilisateur_fk` (`privilege_groupe_fk`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`utilisateur_id`),
  ADD KEY `utiilisateur_groupe_fk` (`utilisateur_groupe_fk`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `classe_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `eleve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `groupes`
--
ALTER TABLE `groupes`
  MODIFY `groupe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `paiement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `param_divers`
--
ALTER TABLE `param_divers`
  MODIFY `param_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT pour la table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `privilege_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `paiements_ibfk_1` FOREIGN KEY (`paiement_mode_paiement_param_fk`) REFERENCES `param_divers` (`param_id`),
  ADD CONSTRAINT `paiements_ibfk_2` FOREIGN KEY (`paiement_eleve_fk`) REFERENCES `eleves` (`eleve_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `paiements_ibfk_3` FOREIGN KEY (`paiement_type_paiement_param_fk`) REFERENCES `param_divers` (`param_id`),
  ADD CONSTRAINT `paiements_ibfk_4` FOREIGN KEY (`paiement_status_param_fk`) REFERENCES `param_divers` (`param_id`);

--
-- Contraintes pour la table `privileges`
--
ALTER TABLE `privileges`
  ADD CONSTRAINT `privileges_ibfk_1` FOREIGN KEY (`privilege_groupe_fk`) REFERENCES `groupes` (`groupe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `privileges_ibfk_2` FOREIGN KEY (`privilege_menu_fk`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`utilisateur_groupe_fk`) REFERENCES `groupes` (`groupe_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
