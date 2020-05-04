-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2020 at 08:00 AM
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
-- Table structure for table `ecolages`
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
-- Table structure for table `eleves`
--

CREATE TABLE `eleves` (
  `eleve_id` int(11) NOT NULL,
  `eleve_nom` varchar(255) NOT NULL,
  `eleve_matricule` varchar(20) NOT NULL,
  `eleve_classe_fk` int(11) NOT NULL,
  `eleve_ecolage_fk` int(11) NOT NULL
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
  `param_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `utilisateur_id` int(11) NOT NULL,
  `utilisateur_nom` varchar(255) NOT NULL,
  `utilisateur_pseudo` varchar(255) NOT NULL,
  `utilisateur_email` varchar(255) NOT NULL,
  `utilisateur_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`classe_id`);

--
-- Indexes for table `ecolages`
--
ALTER TABLE `ecolages`
  ADD PRIMARY KEY (`ecolage_id`),
  ADD KEY `ecolage_montant_fk` (`ecolage_montant`),
  ADD KEY `ecolage_status_param_fk` (`ecolage_status_param_fk`),
  ADD KEY `ecolage_periode_param_fk` (`ecolage_periode_param_fk`);

--
-- Indexes for table `eleves`
--
ALTER TABLE `eleves`
  ADD PRIMARY KEY (`eleve_id`),
  ADD KEY `eleve_classe_fk` (`eleve_classe_fk`),
  ADD KEY `eleve_ecolage_fk` (`eleve_ecolage_fk`);

--
-- Indexes for table `param_divers`
--
ALTER TABLE `param_divers`
  ADD PRIMARY KEY (`param_id`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`utilisateur_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `classe_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ecolages`
--
ALTER TABLE `ecolages`
  MODIFY `ecolage_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `eleve_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `param_divers`
--
ALTER TABLE `param_divers`
  MODIFY `param_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ecolages`
--
ALTER TABLE `ecolages`
  ADD CONSTRAINT `ecolages_ibfk_1` FOREIGN KEY (`ecolage_periode_param_fk`) REFERENCES `param_divers` (`param_id`),
  ADD CONSTRAINT `ecolages_ibfk_2` FOREIGN KEY (`ecolage_status_param_fk`) REFERENCES `param_divers` (`param_id`);

--
-- Constraints for table `eleves`
--
ALTER TABLE `eleves`
  ADD CONSTRAINT `eleves_ibfk_1` FOREIGN KEY (`eleve_classe_fk`) REFERENCES `classes` (`classe_id`),
  ADD CONSTRAINT `eleves_ibfk_2` FOREIGN KEY (`eleve_ecolage_fk`) REFERENCES `ecolages` (`ecolage_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
