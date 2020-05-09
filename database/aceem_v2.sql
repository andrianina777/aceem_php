-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 09 mai 2020 à 17:19
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
-- Structure de la table `ecolages`
--

CREATE TABLE `ecolages` (
  `ecolage_id` int(11) NOT NULL,
  `ecolage_date_depot` datetime NOT NULL,
  `ecolage_date_maj` datetime NOT NULL,
  `ecolage_montant` double NOT NULL,
  `ecolage_periode_param_fk` int(11) NOT NULL,
  `ecolage_status_param_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

CREATE TABLE `eleves` (
  `eleve_id` int(11) NOT NULL,
  `eleve_nom` varchar(255) NOT NULL,
  `eleve_matricule` varchar(20) NOT NULL,
  `eleve_classe_fk` int(11) NOT NULL,
  `eleve_ecolage_fk` int(11) NOT NULL,
  `eleve_droit_fk` int(11) NOT NULL
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
(0, 'Type_paiement', 'Ecolage', 'Ecolage', 'Ecolage', 5),
(3, 'categorie_classe', 'SS', 'SS', 'SpÃ©cial Samedi', 1),
(4, 'categorie_classe', 'TMS', 'TMS', 'Tous Mercredi Samedi', 2),
(5, 'categorie_classe', 'AM', 'AM', 'MatinÃ©e', 3),
(11, 'Type_paiement', 'Droit', 'Droit', 'Droit', 4),
(13, 'Type_paiement', 'BACC', 'BACC', 'BACC', 6),
(14, 'Type_paiement', 'BEPC', 'BEPC', 'BEPC', 7),
(15, 'Type_paiement', 'CARNET', 'CARNET', 'CARNET', 9),
(16, 'Type_paiement', 'CARTE', 'CARTE', 'CARTE', 10),
(18, 'Type_paiement', 'CERTIFICAT', 'CERTIFICAT', 'CERTIFICAT', 11),
(19, 'Type_paiement', 'CHANGEMENT DE CLASSE', 'CHANGEMENT DE CLASSE', 'CHANGEMENT DE CLASSE', 12),
(20, 'Type_paiement', 'EXAMEN BLANC', 'EXAMEN BLANC', 'EXAMEN BLANC', 13),
(22, 'Type_paiement', 'IDENTITE', 'IDENTITE', 'IDENTITE', 14),
(23, 'Type_paiement', 'RELEVER DE NOTE', 'RELEVER DE NOTE', 'RELEVER DE NOTE', 15),
(24, 'Type_paiement', 'SUPPL MATIERE', 'SUPPL MATIERE', 'MATIERE SUPPLEMENTAIRE', 16),
(25, 'Type_paiement', 'TEE-SHIRT', 'TEE-SHIRT', 'TEE-SHIRT', 17),
(26, 'Type_paiement', 'TRANSFERT', 'TRANSFERT', 'TRANSFERT', 18),
(27, 'mode_paiement', 'NORMAL', 'NORMAL', 'NORMAL', 19),
(28, 'mode_paiement', 'REDUIT', 'REDUIT', 'REDUIT', 20),
(31, 'categorie_classe', 'SS+TMS', 'SS+TMS', 'SpÃ©cial Samedi et Tous Mercredi', 0),
(32, 'categorie_classe', 'AM+SS', 'AM+SS', 'Matin et Special Samedi', 0),
(33, 'categorie_classe', 'AM+TMS', 'AM+TMS', 'MatinÃ© et Tous Mercredi', 0),
(34, 'categorie_classe', 'AM+SS+TMS', 'AM+SS+TMS', 'Matin,Special Samedi , Tous Mercredi Samedi', 0),
(35, 'mention', 'colleges', '3eme', 'classe de 3eme', 0),
(36, 'mention', 'Lycee', 'BACC A', 'BACC A', 0),
(37, 'mention', 'Lycee', 'BACC C', 'BACC C', 0),
(38, 'mention', 'Lycee', 'BACC D', 'BACC D', 0),
(39, 'mention', 'Lycee', 'technique', 'technique', 0),
(40, 'mention', 'universitaire', 'gestion', 'gestion', 0),
(41, 'categorie_classe', 'L1', 'L1', 'L1', 0),
(42, 'categorie_classe', 'L2', 'L2', 'L2', 0),
(43, 'categorie_classe', 'L3', 'L3', 'L3', 0),
(44, 'categorie_classe', 'M1', 'M1', 'M1', 0),
(45, 'categorie_classe', 'M2', 'M2', 'M2', 0),
(46, 'mention', 'universitaire', 'MADAGASCAR BUSINESS SCHOOL', 'MADAGASCAR BUSINESS SCHOOL', 0),
(47, 'mention', 'universitaire', 'SCIENCES ECONOMIQUES & ETUDE DU DEVELOPPEMENT', 'SCIENCES ECONOMIQUES & ETUDE DU DEVELOPPEMENT', 0),
(48, 'mention', 'universitaire', 'DROIT & SCIENCE POLITIQUE', 'DROIT & SCIENCE POLITIQUE', 0),
(49, 'mention', 'universitaire', 'COMMUNICATION', 'COMMUNICATION', 0),
(50, 'mention', 'universitaire', 'SCIENCES DE LA SANTE', 'SCIENCES DE LA SANTE', 0),
(51, 'mention', 'universitaire', 'INFORMATIQUES & ELECTRONIQUES', 'INFORMATIQUES & ELECTRONIQUES', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `utilisateur_id` int(11) NOT NULL,
  `utilisateur_nom` varchar(255) NOT NULL,
  `utilisateur_pseudo` varchar(255) NOT NULL,
  `utilisateur_email` varchar(255) NOT NULL,
  `utilisateur_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`classe_id`);

--
-- Index pour la table `ecolages`
--
ALTER TABLE `ecolages`
  ADD PRIMARY KEY (`ecolage_id`),
  ADD KEY `ecolage_montant_fk` (`ecolage_montant`),
  ADD KEY `ecolage_status_param_fk` (`ecolage_status_param_fk`),
  ADD KEY `ecolage_periode_param_fk` (`ecolage_periode_param_fk`);

--
-- Index pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD PRIMARY KEY (`eleve_id`),
  ADD KEY `eleve_classe_fk` (`eleve_classe_fk`),
  ADD KEY `eleve_ecolage_fk` (`eleve_ecolage_fk`);

--
-- Index pour la table `param_divers`
--
ALTER TABLE `param_divers`
  ADD PRIMARY KEY (`param_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`utilisateur_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `classe_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ecolages`
--
ALTER TABLE `ecolages`
  MODIFY `ecolage_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `eleve_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `param_divers`
--
ALTER TABLE `param_divers`
  MODIFY `param_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ecolages`
--
ALTER TABLE `ecolages`
  ADD CONSTRAINT `ecolages_ibfk_1` FOREIGN KEY (`ecolage_periode_param_fk`) REFERENCES `param_divers` (`param_id`),
  ADD CONSTRAINT `ecolages_ibfk_2` FOREIGN KEY (`ecolage_status_param_fk`) REFERENCES `param_divers` (`param_id`);

--
-- Contraintes pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD CONSTRAINT `eleves_ibfk_1` FOREIGN KEY (`eleve_classe_fk`) REFERENCES `classes` (`classe_id`),
  ADD CONSTRAINT `eleves_ibfk_2` FOREIGN KEY (`eleve_ecolage_fk`) REFERENCES `ecolages` (`ecolage_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
