-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 23 déc. 2023 à 17:58
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sdn_php_projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `benevole`
--

DROP TABLE IF EXISTS `benevole`;
CREATE TABLE IF NOT EXISTS `benevole` (
  `id_benevole` int(11) NOT NULL AUTO_INCREMENT,
  `nom_benevole` char(50) NOT NULL,
  `prenom_benevole` char(50) NOT NULL,
  `role_benevole` varchar(50) NOT NULL,
  `id_joueur` int(11) DEFAULT NULL,
  `id_entraineur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_benevole`),
  KEY `id_joueur` (`id_joueur`),
  KEY `id_entraineur` (`id_entraineur`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `benevole`
--

INSERT INTO `benevole` (`id_benevole`, `nom_benevole`, `prenom_benevole`, `role_benevole`, `id_joueur`, `id_entraineur`) VALUES
(1, 'nom_president', 'prenom_president', 'president', NULL, NULL),
(2, 'nom_secretaire', 'prenom_secretaire', 'secretaire', NULL, NULL),
(3, 'nom_tresorier', 'prenom_tresorier', 'tresorier', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `entraineur`
--

DROP TABLE IF EXISTS `entraineur`;
CREATE TABLE IF NOT EXISTS `entraineur` (
  `id_entraineur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_entraineur` char(50) NOT NULL,
  `prenom_entraineur` char(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `date_arrivee` date NOT NULL,
  `mail` varchar(100) NOT NULL,
  `id_equipe` int(11) NOT NULL,
  `photo_entraineur` varchar(100) NOT NULL DEFAULT 'image_inconnu.jpg',
  PRIMARY KEY (`id_entraineur`),
  KEY `id_equipe` (`id_equipe`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `entraineur`
--

INSERT INTO `entraineur` (`id_entraineur`, `nom_entraineur`, `prenom_entraineur`, `date_naissance`, `date_arrivee`, `mail`, `id_equipe`, `photo_entraineur`) VALUES
(27, 'Polfiet', 'Benjamin', '2023-11-29', '2023-12-07', 'mail', 1, 'image_inconnu.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE IF NOT EXISTS `equipe` (
  `id_equipe` int(11) NOT NULL AUTO_INCREMENT,
  `nom_equipe` char(40) NOT NULL,
  `categorie` varchar(20) NOT NULL,
  PRIMARY KEY (`id_equipe`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id_equipe`, `nom_equipe`, `categorie`) VALUES
(1, 'Séniors A', 'D2'),
(2, 'u19', 'D1'),
(4, 'u17', 'R3'),
(5, 'u15', 'D2'),
(6, 'u13', 'D2'),
(7, 'u12', 'D3'),
(8, 'u11', 'D1'),
(9, 'u10', 'D2');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE IF NOT EXISTS `joueur` (
  `id_joueur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_joueur` char(40) NOT NULL,
  `prenom_joueur` char(40) NOT NULL,
  `date_naissance_joueur` date NOT NULL,
  `date_arrivee_joueur` date NOT NULL,
  `mail_joueur` char(60) NOT NULL,
  `poste_joueur` char(20) NOT NULL,
  `id_equipe` int(11) NOT NULL,
  `photo_joueur` varchar(100) NOT NULL DEFAULT 'image_inconnu.jpg',
  PRIMARY KEY (`id_joueur`),
  KEY `id_equipe` (`id_equipe`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id_joueur`, `nom_joueur`, `prenom_joueur`, `date_naissance_joueur`, `date_arrivee_joueur`, `mail_joueur`, `poste_joueur`, `id_equipe`, `photo_joueur`) VALUES
(9, 'aaaaaaa', 'aaaaaaa', '2023-12-27', '2023-12-10', 'dzede', 'milieu gauche', 1, 'image_inconnu.jpg'),
(10, 'Hebbinckuys', 'Hugo', '2003-03-29', '2010-10-30', 'hugo1.heb@gmail.com', 'Ailier Gauche', 1, 'image_inconnu.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `lienequipeentraineur`
--

DROP TABLE IF EXISTS `lienequipeentraineur`;
CREATE TABLE IF NOT EXISTS `lienequipeentraineur` (
  `equipe_id` int(11) NOT NULL,
  `entraineur_id` int(11) NOT NULL,
  PRIMARY KEY (`equipe_id`,`entraineur_id`),
  KEY `entraineur_id` (`entraineur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom_user` char(50) NOT NULL,
  `prenom_user` char(50) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'supporter',
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom_user`, `prenom_user`, `mail`, `role`, `password`) VALUES
(30, 'compte_supporter', 'supp', 'supporter@gmail.com', 'supporter', 'abcd'),
(16, 'hugo', 'hebb', 'hugo29.heb@gmail.com', 'admin', 'abcd'),
(47, 'nouveau', 'nouveau', 'nouveau@gmail.com', 'supporter', 'abcd'),
(46, 'aaa', 'aaa', 'aaa', 'supporter', 'abcd');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
