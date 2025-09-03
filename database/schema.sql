-- Schéma de base de données pour l'application PHP MVC
-- Exécutez ce script dans votre base de données MySQL

CREATE DATABASE IF NOT EXISTS php_mvc_app CHARACTER SET utf8 COLLATE utf8_general_ci;
USE php_mvc_app;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Index pour optimiser les recherches
CREATE INDEX idx_users_email ON users(email);

-- Données de test (optionnel)
-- Mot de passe : "password123"
INSERT INTO users (name, email, password) VALUES 
('John Doe', 'john@example.com', '$2y$10$/vD8hGtkBJsAae2TiSkbV.jg0bnNDAFv8xBewH14.OKvR0PpeVbq6'),
('Jane Smith', 'jane@example.com', '$2y$10$/vD8hGtkBJsAae2TiSkbV.jg0bnNDAFv8xBewH14.OKvR0PpeVbq6'),
('Admin User', 'admin@example.com', '$2y$10$/vD8hGtkBJsAae2TiSkbV.jg0bnNDAFv8xBewH14.OKvR0PpeVbq6');
-- Données test livres
INSERT INTO `books` (`id`, `title`, `writer`, `ISBN_13`, `gender`, `page_number`, `synopsis`, `date_of_publication`, `stock`) VALUES
(1, 'essai', 'Tester', 123, 'crash test', 1, 'Ceci est un test, si la feature est bien codée et opérationnelle, alors ce test devrait s\''afficher', '2025-09-01', 1),
(2, 'Barbecue', 'Moi', 122, 'genre', 1, 'Pourquoi ça marche ?', '2025-09-01', 1);
-- Données test films
INSERT INTO `movies` (`id`, `title`, `producer`, `year`, `gender`, `duration(m)`, `synopsis`, `classification`, `stock`) VALUES
(1, 'Retour vers le Futur', 'Robert Zemeckis', 1985, 'science-fiction', 116, 'L\''intrigue du film relate les aventures de Marty McFly (Michael J. Fox), un adolescent qui voyage dans le passé à bord d\''une machine à voyager dans le temps fabriquée par son ami le docteur Emmett Brown (Christopher Lloyd) à partir d\''une voiture DeLorean DMC-12. Parti de l\''année 1985 et propulsé le 5 novembre 1955, Marty, aidé du « Doc » de 1955, doit résoudre les paradoxes temporels provoqués par son passage dans le passé, et doit aussi trouver le moyen de faire fonctionner la machine pour retourner à son époque. Marty sera notamment confronté à ses parents, George (Crispin Glover) et Lorraine McFly (Lea Thompson) qui, à l\''époque, sont encore des adolescents. Enfin, Marty devra lutter contre les stratagèmes d\''un autre adolescent, Biff Tannen (Thomas F. Wilson).', 'tout public', 1);
-- Données test jeux vidéos
INSERT INTO `video_games` (`id`, `title`, `editor`, `plateform`, `gender`, `minimal_age`, `description`, `stock`) VALUES
(1, 'Minecraft', 'Mojang Studios', 'pc, console, mobile', 'bac à sable', 7, 'Minecraft est un jeu vidéo de type aventure « bac à sable » développé par le Suédois Markus Persson, alias Notch, puis par la société Mojang Studios. Il s\''agit d\''un univers composé de voxels et généré de façon procédurale, qui intègre un système d\''artisanat axé sur la collecte puis la transformation de ressources naturelles (minéralogiques, fossiles, animales et végétales).', 1);

-- Table de messages de contact (exemple d'extension)
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at TIMESTAMP NULL
);

-- Table pour les jeux vidéos
CREATE TABLE `video_games` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `editor` varchar(255) NOT NULL,
  `plateform` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `minimal_age` int NOT NULL,
  `description` TEXT(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Table pour les films
CREATE TABLE `movies` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `producer` varchar(255) NOT NULL,
  `year` int NOT NULL,
  `gender` varchar(255) NOT NULL,
  `duration(m)` int NOT NULL,
  `synopsis` TEXT(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `classification` varchar(255) NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Table pour les livres
CREATE TABLE `books` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `writer` varchar(255) NOT NULL,
  `ISBN_13` int NOT NULL,
  `gender` varchar(255) NOT NULL,
  `page_number` int NOT NULL,
  `synopsis` TEXT(1000) NOT NULL,
  `date_of_publication` date NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Table de paramètres de configuration
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    key_name VARCHAR(100) NOT NULL UNIQUE,
    value TEXT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Paramètres par défaut
INSERT INTO settings (key_name, value, description) VALUES 
('site_name', 'PHP MVC Starter', 'Nom du site web'),
('maintenance_mode', '0', 'Mode maintenance (0 = désactivé, 1 = activé)'),
('max_login_attempts', '5', 'Nombre maximum de tentatives de connexion'),
('session_timeout', '3600', 'Timeout de session en secondes');



-- Vue pour les statistiques
CREATE VIEW user_stats AS
SELECT 
    COUNT(*) as total_users,
    COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 END) as new_users_30d,
    COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 END) as new_users_7d
FROM users; 