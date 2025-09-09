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
--Données test pour la table livres
INSERT INTO `books` (`id`, `title`, `writer`, `ISBN13`, `gender`, `page_number`, `synopsis`, `year`, `image_url`, `available`, 
`stock`, `upload_date`) VALUES (NULL, 'Chroniques du Monde émergé - Intégrale', 'Licia Troisi', 
'978-2-266-24473-2', 'Fantaisie', '1200', 'Nihal est une jeune fille différente des autres : 
elle a les oreilles en pointe, les cheveux bleus et de grands yeux violets, ce qui ne l\'empêche 
pas de mener une vie normale... jusqu\'à ce que Tyran, un despote sanguinaire, envahisse la Terre 
des Vents et rase son village. Ce jour-là, le destin de Nihal bascule. Dès lors, la jeune fille 
n\'a plus qu\'une idée en tête : venger les siens et sauver les huit terres du Monde Émergé. Avec 
l\'aide de sa tante magicienne, du jeune mage Sennar et de l\'épée de cristal noir forgée par son 
père, elle se lance à corps perdu dans une bataille fantastique qui la conduira à travers les 
terres émergées, sur les traces d\'un continent oublié, à la recherche de talismans et la poussera 
aux limites de sa force, de son intelligence et de son courage...', '2006', 
'https://images.noosfere.org/couv/p/pocketj-24473-2013.jpg', '1', '1', '2025-09-09');
-- Données test pour la table films
INSERT INTO `movies` (`id`, `title`, `producer`, `year`, `gender`, `duration`, `synopsis`, 
`classification`, `image_url`, `available`, `stock`, `upload_date`) VALUES (NULL, 
'Retour vers le Futur', 'Robert Zemeckis', '1985', 'Science-fiction', '116', 
'L\'intrigue du film relate les aventures de Marty McFly (Michael J. Fox), un adolescent qui 
voyage dans le passé à bord d\'une machine à voyager dans le temps fabriquée par son ami le 
docteur Emmett Brown (Christopher Lloyd) à partir d\'une voiture DeLorean DMC-12. Parti de 
l\'année 1985 et propulsé le 5 novembre 1955, Marty, aidé du « Doc » de 1955, doit résoudre les 
paradoxes temporels provoqués par son passage dans le passé, et doit aussi trouver le moyen de 
faire fonctionner la machine pour retourner à son époque. Marty sera notamment confronté à ses 
parents, George (Crispin Glover) et Lorraine McFly (Lea Thompson) qui, à l\'époque, sont encore 
des adolescents. Enfin, Marty devra lutter contre les stratagèmes d\'un autre adolescent, Biff 
Tannen (Thomas F. Wilson).', 'Tout public', 
'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQ1SRzv6ghvKt42eUSFxrRC8xPiGf4fK2nCwp-p-IdZyS6qghetCaAVmLKVaumyjFkevfhQL1wDsCo9CXXvc-1AzsoCOx1XNzeGcL_P05Ledg', 
'1', '1', '2025-09-09');
-- Données test pour la table jeux vidéos
INSERT INTO `video_games` (`id`, `title`, `editor`, `platform`, `gender`, `year`, `min_age`, 
`description`, `image_url`, `available`, `stock`, `upload_date`) VALUES 
(NULL, 'Minecraft', 'Mojang Studios', 'Multi-plateforme', 'Aventure, bac à sable', '2009', 
'7', 'Minecraft plonge le joueur dans un monde créé de manière procédurale, composé de voxels 
représentant différents matériaux (terre, pierre, eau, fer, charbon, etc.). Le monde est formé de 
diverses structures (arbres, cavernes, montagnes, villages, etc.) et est peuplé par des animaux 
(vaches, moutons, etc.) ainsi que des monstres (zombies, araignées, squelettes, etc.). Le joueur 
peut modifier son monde à volonté, soit dans le but de survivre, soit pour créer.', 
'https://upload.wikimedia.org/wikipedia/commons/thumb/0/00/Minecraft_Alex_and_fauna.png/375px-Minecraft_Alex_and_fauna.png', 
'1', '1', '2025-09-09');

-- Table de messages de contact (exemple d'extension)
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at TIMESTAMP NULL
);


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
-- جدول items برای کاتالوگ
CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('book', 'movie', 'game') NOT NULL,
    image_url VARCHAR(255) DEFAULT 'https://via.placeholder.com/150',
    available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول rentals برای اجاره‌ها
CREATE TABLE IF NOT EXISTS rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    rent_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    return_date TIMESTAMP NULL,
    status ENUM('loué', 'retourné') DEFAULT 'loué',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
);

-- داده‌های تست
INSERT INTO items (title, description, type, image_url) VALUES
('Livre Test', 'Un livre de test', 'book', 'https://via.placeholder.com/150'),
('Film Test', 'Un film de test', 'movie', 'https://via.placeholder.com/150'),
('Jeu Test', 'Un jeu de test', 'game', 'https://via.placeholder.com/150');