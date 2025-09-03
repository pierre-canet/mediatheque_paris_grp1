-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 03 sep. 2025 à 08:41
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `php_mvc_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `writer` varchar(255) NOT NULL,
  `ISBN_13` bigint NOT NULL,
  `gender` varchar(255) NOT NULL,
  `page_number` int NOT NULL,
  `synopsis` text NOT NULL,
  `date_of_publication` date NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `read_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `producer` varchar(255) NOT NULL,
  `year` int NOT NULL,
  `gender` varchar(255) NOT NULL,
  `duration_m` int NOT NULL,
  `synopsis` text NOT NULL,
  `classification` varchar(255) NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key_name` varchar(100) NOT NULL,
  `value` text,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_name` (`key_name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `key_name`, `value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'PHP MVC Starter', 'Nom du site web', '2025-08-26 12:54:38', '2025-08-26 12:54:38'),
(2, 'maintenance_mode', '0', 'Mode maintenance (0 = désactivé, 1 = activé)', '2025-08-26 12:54:38', '2025-08-26 12:54:38'),
(3, 'max_login_attempts', '5', 'Nombre maximum de tentatives de connexion', '2025-08-26 12:54:38', '2025-08-26 12:54:38'),
(4, 'session_timeout', '3600', 'Timeout de session en secondes', '2025-08-26 12:54:38', '2025-08-26 12:54:38');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_name` varchar(50) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_users_email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `last_name`, `role`) VALUES
(10, 'Ronaldo', 'ronaldo@gmail.com', '$2y$10$DY3n97zU7Pr7EjwEaFpM1OuynJKbRcxgUgeiHUuK9mRZ2JJ2dLHcK', '2025-09-02 13:01:22', '2025-09-02 13:01:22', 'Cronaldo', 'user'),
(9, 'adama', 'adama@gmail.com', '$2y$10$9MV.zf/6ihb9mVkc6uybWujQ5Bj5spgWJBU2e.6ed5C/73BkjjuZ.', '2025-09-02 10:12:48', '2025-09-02 10:12:48', 'kanoute', 'user'),
(8, 'sadio', 'sadio@gmail.com', '$2y$10$NapvBqr3UfUwN7lBGcI37.lElbH1ww3dTdpi1h6Mznr0F4TdpI6XW', '2025-09-02 09:30:07', '2025-09-02 09:30:07', 'sadioka', 'user');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `user_stats`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `user_stats`;
CREATE TABLE IF NOT EXISTS `user_stats` (
`new_users_30d` bigint
,`new_users_7d` bigint
,`total_users` bigint
);

-- --------------------------------------------------------

--
-- Structure de la table `video_games`
--

DROP TABLE IF EXISTS `video_games`;
CREATE TABLE IF NOT EXISTS `video_games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `editor` varchar(255) NOT NULL,
  `plateform` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `minimal_age` int NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `video_games`
--

INSERT INTO `video_games` (`id`, `title`, `editor`, `plateform`, `gender`, `minimal_age`, `description`, `stock`) VALUES
(1, 'Minecraft', 'Mojang Studios', 'pc, console, mobile', 'bac à sable', 7, 'Minecraft est un jeu vidéo de type aventure « bac à sable »...', 1);

-- --------------------------------------------------------

--
-- Structure de la vue `user_stats`
--
DROP TABLE IF EXISTS `user_stats`;

DROP VIEW IF EXISTS `user_stats`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_stats`  AS SELECT count(0) AS `total_users`, count((case when (`users`.`created_at` >= (now() - interval 30 day)) then 1 end)) AS `new_users_30d`, count((case when (`users`.`created_at` >= (now() - interval 7 day)) then 1 end)) AS `new_users_7d` FROM `users` ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
