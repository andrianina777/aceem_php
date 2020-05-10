-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2020 at 12:20 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aceem`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `classe_id` int(11) NOT NULL,
  `classe_niveau` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `droits`
--

CREATE TABLE `droits` (
  `droit_id` int(11) NOT NULL,
  `droit_eleve_fk` int(11) NOT NULL,
  `droit_paiement_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ecolages`
--

CREATE TABLE `ecolages` (
  `ecolage_id` int(11) NOT NULL,
  `ecolage_eleve_fk` int(11) NOT NULL,
  `ecolage_paiement_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `eleves`
--

CREATE TABLE `eleves` (
  `eleve_id` int(11) NOT NULL,
  `eleve_nom` varchar(255) NOT NULL,
  `eleve_matricule` varchar(20) NOT NULL,
  `eleve_etat_param_fk` int(11) NOT NULL,
  `eleve_classe_fk` int(11) NOT NULL,
  `eleve_ecolage_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groupes`
--

CREATE TABLE `groupes` (
  `groupe_id` int(11) NOT NULL,
  `groupe_nom` varchar(100) NOT NULL,
  `groupe_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groupes`
--

INSERT INTO `groupes` (`groupe_id`, `groupe_nom`, `groupe_description`) VALUES
(1, 'admin', 'Administrateur du site ');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `menu_nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_nom`) VALUES
(1, 'utilisateurs'),
(2, 'groupes'),
(3, 'historiques'),
(4, 'parametrages'),
(5, 'eleves'),
(6, 'paiements');

-- --------------------------------------------------------

--
-- Table structure for table `paiements`
--

CREATE TABLE `paiements` (
  `paiement_id` int(11) NOT NULL,
  `paiement_date_depot` datetime NOT NULL,
  `paiement_date_maj` datetime NOT NULL,
  `paiement_montant` double NOT NULL,
  `paiement_type_param_fk` int(11) NOT NULL,
  `paiement_periode_param_fk` int(11) NOT NULL,
  `paiement_status_param_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `param_divers`
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
-- Dumping data for table `param_divers`
--

INSERT INTO `param_divers` (`param_id`, `param_table`, `param_sigle`, `param_valeur`, `param_description`, `param_ordre`) VALUES
(1, 'Type_paiement', 'Ecolage', 'Ecolage', 'Ecolage', 5),
(3, 'categorie_classe', 'SS', 'SS', 'Spécial Samedi', 1),
(4, 'categorie_classe', 'TMS', 'TMS', 'Tous Mercredi Samedi', 2),
(5, 'categorie_classe', 'AM', 'AM', 'Matinée', 3),
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
(31, 'categorie_classe', 'SS+TMS', 'SS+TMS', 'Spécial Samedi et Tous Mercredi', 0),
(32, 'categorie_classe', 'AM+SS', 'AM+SS', 'Matin et Special Samedi', 0),
(33, 'categorie_classe', 'AM+TMS', 'AM+TMS', 'Matin et Tous Mercredi', 0),
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
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `privilege_id` int(11) NOT NULL,
  `privilege_menu_fk` int(11) NOT NULL,
  `privilege_groupe_fk` int(11) NOT NULL,
  `privilege_is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`privilege_id`, `privilege_menu_fk`, `privilege_groupe_fk`, `privilege_is_active`) VALUES
(31, 1, 1, 1),
(32, 2, 1, 1),
(33, 3, 1, 1),
(34, 4, 1, 1),
(35, 5, 1, 1),
(36, 6, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
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
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`utilisateur_id`, `utilisateur_nom`, `utilisateur_pseudo`, `utilisateur_email`, `utilisateur_groupe_fk`, `utilisateur_password`) VALUES
(3, 'admin', 'admin', 'admin@admin.com', 1, '98a427e034649e41f2d61d0fcf0c593e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`classe_id`);

--
-- Indexes for table `droits`
--
ALTER TABLE `droits`
  ADD PRIMARY KEY (`droit_id`),
  ADD KEY `droit_eleve_fk` (`droit_eleve_fk`),
  ADD KEY `droit_paiement_fk` (`droit_paiement_fk`);

--
-- Indexes for table `ecolages`
--
ALTER TABLE `ecolages`
  ADD PRIMARY KEY (`ecolage_id`),
  ADD KEY `ecolage_eleve_fk` (`ecolage_eleve_fk`),
  ADD KEY `ecolage_paiement_fk` (`ecolage_paiement_fk`);

--
-- Indexes for table `eleves`
--
ALTER TABLE `eleves`
  ADD PRIMARY KEY (`eleve_id`),
  ADD KEY `eleve_classe_fk` (`eleve_classe_fk`),
  ADD KEY `eleve_ecolage_fk` (`eleve_ecolage_fk`),
  ADD KEY `eleve_etat_param_fk` (`eleve_etat_param_fk`);

--
-- Indexes for table `groupes`
--
ALTER TABLE `groupes`
  ADD PRIMARY KEY (`groupe_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`paiement_id`),
  ADD KEY `ecolage_montant_fk` (`paiement_montant`),
  ADD KEY `ecolage_status_param_fk` (`paiement_status_param_fk`),
  ADD KEY `ecolage_periode_param_fk` (`paiement_periode_param_fk`),
  ADD KEY `paiement_type_param_fk` (`paiement_type_param_fk`);

--
-- Indexes for table `param_divers`
--
ALTER TABLE `param_divers`
  ADD PRIMARY KEY (`param_id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`privilege_id`),
  ADD KEY `privilege_menu_fk` (`privilege_menu_fk`),
  ADD KEY `privilege_utilisateur_fk` (`privilege_groupe_fk`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`utilisateur_id`),
  ADD KEY `utiilisateur_groupe_fk` (`utilisateur_groupe_fk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `classe_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `droits`
--
ALTER TABLE `droits`
  MODIFY `droit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ecolages`
--
ALTER TABLE `ecolages`
  MODIFY `ecolage_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `eleve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groupes`
--
ALTER TABLE `groupes`
  MODIFY `groupe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `paiement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `param_divers`
--
ALTER TABLE `param_divers`
  MODIFY `param_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `privilege_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eleves`
--
ALTER TABLE `eleves`
  ADD CONSTRAINT `eleves_ibfk_1` FOREIGN KEY (`eleve_classe_fk`) REFERENCES `classes` (`classe_id`),
  ADD CONSTRAINT `eleves_ibfk_2` FOREIGN KEY (`eleve_ecolage_fk`) REFERENCES `paiements` (`paiement_id`);

--
-- Constraints for table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `paiements_ibfk_1` FOREIGN KEY (`paiement_periode_param_fk`) REFERENCES `param_divers` (`param_id`),
  ADD CONSTRAINT `paiements_ibfk_2` FOREIGN KEY (`paiement_status_param_fk`) REFERENCES `param_divers` (`param_id`);

--
-- Constraints for table `privileges`
--
ALTER TABLE `privileges`
  ADD CONSTRAINT `privileges_ibfk_1` FOREIGN KEY (`privilege_groupe_fk`) REFERENCES `groupes` (`groupe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `privileges_ibfk_2` FOREIGN KEY (`privilege_menu_fk`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE;

--
-- Constraints for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`utilisateur_groupe_fk`) REFERENCES `groupes` (`groupe_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
