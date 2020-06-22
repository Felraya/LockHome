-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mer. 22 jan. 2020 à 11:14
-- Version du serveur :  5.7.28-0ubuntu0.16.04.2
-- Version de PHP :  7.0.33-0ubuntu0.16.04.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lockhome`
--

-- --------------------------------------------------------

--
-- Structure de la table `Authentification`
--

CREATE TABLE `Authentification` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(25) NOT NULL,
  `notification` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Authentification`
--

INSERT INTO `Authentification` (`id`, `nom`, `prenom`, `email`, `password`, `role`, `notification`) VALUES
(4, 'Rocher', 'Nathan', '3007nat@gmail.com', '$2y$10$Puo.lxy4PaDxLOegFmCJqOUk7aw8wKyfbCxH4wGT1L4Ut51nFVnc2', 'admin', 1),
(5, 'Lecomte', 'Kylian', 'kylian.lec@gmail.com', '$2y$10$kGrXF9K7OopQ78JOcLcvBezRUBxp50yyGNyWV/Gt6wJpP3Kn5Wm8e', 'admin', 0),
(6, 'Rocher', 'Nathan', 'nathan.rocher@etu.univ-nantes.fr', '$2y$10$Puo.lxy4PaDxLOegFmCJqOUk7aw8wKyfbCxH4wGT1L4Ut51nFVnc2', 'admin', 0),
(7, 'Bernard', 'Adrien', 'adri85bernard@gmail.com', '$2y$10$d.SKMcXo70HLojj85aHWYOozXBLiOzIVqLnvM8Dzk/tcFB7875D0u', 'waiting', 1),
(8, '   ', '   ', 'a@a', '$2y$10$lztXM4PgqoEoH.Lc2Av2leURItIGq/PCtNX5J3mC6WsVvxdDMY/FS', 'waiting', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Camera`
--

CREATE TABLE `Camera` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Camera`
--

INSERT INTO `Camera` (`id`, `nom`, `ip`) VALUES
(4, 'Jardin', '192.168.43.43');

-- --------------------------------------------------------

--
-- Structure de la table `Capteur`
--

CREATE TABLE `Capteur` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Capteur`
--

INSERT INTO `Capteur` (`id`, `type`, `nom`, `ip`) VALUES
(7, 'ouverture', 'Porte d\'entrée', '192.168.0.1'),
(9, 'vibration', 'Fenêtre cuisine n°70', '192.168.0.13'),
(11, 'ouverture', 'RASPBERRY PI - Réseau Hugo', '192.168.43.43');

-- --------------------------------------------------------

--
-- Structure de la table `EtatCapteur`
--

CREATE TABLE `EtatCapteur` (
  `idProfil` int(12) NOT NULL,
  `idCapteur` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `EtatCapteur`
--

INSERT INTO `EtatCapteur` (`idProfil`, `idCapteur`) VALUES
(12, 7),
(12, 10),
(1, 9),
(9, 7),
(9, 8),
(9, 9),
(9, 10);

-- --------------------------------------------------------

--
-- Structure de la table `LogCapteur`
--

CREATE TABLE `LogCapteur` (
  `id` int(11) NOT NULL,
  `capteurId` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `LogCapteur`
--

INSERT INTO `LogCapteur` (`id`, `capteurId`, `action`, `date`) VALUES
(1, 11, 'intrusion', '2020-01-21 10:24:26'),
(2, 11, 'intrusion', '2020-01-21 10:24:51'),
(3, 11, 'intrusion', '2020-01-21 15:28:13'),
(4, 11, 'intrusion', '2020-01-21 15:28:33'),
(5, 11, 'intrusion', '2020-01-21 15:46:04'),
(6, 11, 'intrusion', '2020-01-21 15:48:57');

-- --------------------------------------------------------

--
-- Structure de la table `LogEmail`
--

CREATE TABLE `LogEmail` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `type` varchar(22) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `LogEmail`
--

INSERT INTO `LogEmail` (`id`, `user`, `type`, `date`) VALUES
(1, 4, 'intrusion', '2020-01-21 10:25:26'),
(2, 7, 'intrusion', '2020-01-21 10:25:26'),
(3, 8, 'intrusion', '2020-01-21 10:25:26'),
(4, 4, 'intrusion', '2020-01-21 10:25:51'),
(5, 7, 'intrusion', '2020-01-21 10:25:51'),
(6, 8, 'intrusion', '2020-01-21 10:25:51');

-- --------------------------------------------------------

--
-- Structure de la table `LogUser`
--

CREATE TABLE `LogUser` (
  `UserId` int(11) NOT NULL,
  `Action` varchar(255) NOT NULL,
  `IP` varchar(255) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Maison`
--

CREATE TABLE `Maison` (
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `profilactif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Maison`
--

INSERT INTO `Maison` (`nom`, `adresse`, `profilactif`) VALUES
('SAVIGNY-LE-TEMPLE', '84  rue du Président Roosevelt 77176 SAVIGNY-LE-TEMPLE', 9);

-- --------------------------------------------------------

--
-- Structure de la table `MotDePasseOublie`
--

CREATE TABLE `MotDePasseOublie` (
  `user` int(12) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Profil`
--

CREATE TABLE `Profil` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `debut` varchar(255) NOT NULL,
  `fin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Profil`
--

INSERT INTO `Profil` (`id`, `nom`, `debut`, `fin`) VALUES
(9, 'Vacances', '00:00', '12:00'),
(12, 'Journée', '11:00', '18:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Authentification`
--
ALTER TABLE `Authentification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`email`);

--
-- Index pour la table `Camera`
--
ALTER TABLE `Camera`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Capteur`
--
ALTER TABLE `Capteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `LogCapteur`
--
ALTER TABLE `LogCapteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `LogEmail`
--
ALTER TABLE `LogEmail`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Profil`
--
ALTER TABLE `Profil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Authentification`
--
ALTER TABLE `Authentification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `Camera`
--
ALTER TABLE `Camera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Capteur`
--
ALTER TABLE `Capteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `LogCapteur`
--
ALTER TABLE `LogCapteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `LogEmail`
--
ALTER TABLE `LogEmail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `Profil`
--
ALTER TABLE `Profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
