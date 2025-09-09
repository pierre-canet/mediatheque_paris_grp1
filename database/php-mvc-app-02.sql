
-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 08, 2025 at 08:08 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_mvc_app`
--
CREATE DATABASE IF NOT EXISTS `php_mvc_app` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `php_mvc_app`;

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `pages` int DEFAULT NULL,
  `description` text,
  `year` int DEFAULT NULL,
  `available` tinyint(1) DEFAULT '1',
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `stock` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `genre`, `pages`, `description`, `year`, `available`, `image_url`, `created_at`, `stock`) VALUES
(1, '1984', 'George Orwell', '9780451524935', 'Science-Fiction', 328, 'Un roman dystopique sur un régime totalitaire.', 1949, 1, 'https://via.placeholder.com/300?text=1984', '2025-09-05 13:56:29', 5),
(2, 'L\'Étranger', 'Albert Camus', '9782070360024', 'Philosophie', 184, 'Un homme confronté à l\'absurde.', 1942, 0, 'https://via.placeholder.com/300?text=L\'Étranger', '2025-09-05 13:56:29', 0),
(3, 'Le Petit Prince', 'Antoine de Saint-Exupéry', '9780156013987', 'Children', 96, 'Un conte poétique sur l\'amitié et l\'amour.', 1943, 1, 'https://via.placeholder.com/300?text=Petit+Prince', '2025-09-05 13:56:29', 5),
(4, 'Orgueil et Préjugés', 'Jane Austen', '9780141439518', 'Romance', 432, 'Une histoire d\'amour dans l\'Angleterre du 19e siècle.', 1813, 1, 'https://via.placeholder.com/300?text=Orgueil+Préjugés', '2025-09-05 13:56:29', 5),
(5, 'Le Seigneur des Anneaux', 'J.R.R. Tolkien', '9780261103573', 'Fantaisie', 1216, 'Une épopée fantastique dans un monde imaginaire.', 1954, 0, 'https://via.placeholder.com/300?text=Seigneur+Anneaux', '2025-09-05 13:56:29', 0),
(6, 'Crime et Châtiment', 'Fiodor Dostoïevski', '9780140449136', 'Classique', 671, 'Un étudiant confronté à la morale.', 1866, 1, 'https://via.placeholder.com/300?text=Crime+Châtiment', '2025-09-05 13:56:29', 5),
(7, 'Les Misérables', 'Victor Hugo', '9780140444308', 'Classique', 1232, 'Une fresque sociale dans la France du 19e siècle.', 1862, 1, 'https://via.placeholder.com/300?text=Les+Misérables', '2025-09-05 13:56:29', 5),
(8, 'Cent Ans de Solitude', 'Gabriel García Márquez', '9780060883287', 'Réalisme Magique', 417, 'La saga d\'une famille sur plusieurs générations.', 1967, 0, 'https://via.placeholder.com/300?text=Cent+Ans', '2025-09-05 13:56:29', 0),
(9, 'Dune', 'Frank Herbert', '9780441172719', 'Science-Fiction', 896, 'Une épopée sur une planète désertique.', 1965, 1, 'https://via.placeholder.com/300?text=Dune', '2025-09-05 13:56:29', 5),
(10, 'Gatsby le Magnifique', 'F. Scott Fitzgerald', '9780141182636', 'Classique', 180, 'Un portrait de l\'Amérique des années 1920.', 1925, 1, 'https://via.placeholder.com/300?text=Gatsby', '2025-09-05 13:56:29', 5),
(11, 'Harry Potter à l\'école des sorciers', 'J.K. Rowling', '9782070541270', 'Fantaisie', 320, 'Les aventures d\'un jeune sorcier.', 1997, 1, 'https://via.placeholder.com/300?text=Harry+Potter', '2025-09-05 13:56:29', 5),
(12, 'Le Nom de la Rose', 'Umberto Eco', '9782253033134', 'Historique', 512, 'Un mystère médiéval dans une abbaye.', 1980, 0, 'https://via.placeholder.com/300?text=Nom+Rose', '2025-09-05 13:56:29', 0),
(13, 'L\'Alchimiste', 'Paulo Coelho', '9780061122415', 'Fiction', 208, 'Un voyage spirituel pour trouver son trésor.', 1988, 1, 'https://via.placeholder.com/300?text=Alchimiste', '2025-09-05 13:56:29', 5),
(14, 'Le Parfum', 'Patrick Süskind', '9782253044901', 'Historique', 336, 'L\'histoire d\'un parfumeur meurtrier.', 1985, 1, 'https://via.placeholder.com/300?text=Parfum', '2025-09-05 13:56:29', 5),
(15, 'Fahrenheit 451', 'Ray Bradbury', '9781451673319', 'Science-Fiction', 249, 'Un monde où les livres sont interdits.', 1953, 0, 'https://via.placeholder.com/300?text=Fahrenheit+451', '2025-09-05 13:56:29', 0),
(16, 'L\'Odyssée', 'Homère', '9780140268867', 'Classique', 541, 'Les aventures d\'Ulysse après la guerre de Troie.', 800, 1, 'https://via.placeholder.com/300?text=Odyssée', '2025-09-05 13:56:29', 5),
(17, 'Le Comte de Monte-Cristo', 'Alexandre Dumas', '9780140449266', 'Aventure', 1276, 'Une quête de vengeance et de rédemption.', 1844, 1, 'https://via.placeholder.com/300?text=Comte+Monte-Cristo', '2025-09-05 13:56:29', 5),
(18, 'Madame Bovary', 'Gustave Flaubert', '9780140449129', 'Classique', 329, 'Les désillusions d\'une femme romantique.', 1857, 0, 'https://via.placeholder.com/300?text=Madame+Bovary', '2025-09-05 13:56:29', 0),
(19, 'Don Quichotte', 'Miguel de Cervantes', '9780060934347', 'Classique', 992, 'Les aventures d\'un chevalier errant.', 1605, 1, 'https://via.placeholder.com/300?text=Don+Quichotte', '2025-09-05 13:56:29', 5),
(20, 'L\'Île au trésor', 'Robert Louis Stevenson', '9780141321004', 'Aventure', 304, 'Une chasse au trésor pleine de pirates.', 1883, 1, 'https://via.placeholder.com/300?text=Île+Trésor', '2025-09-05 13:56:29', 5),
(21, 'Les Hauts de Hurlevent', 'Emily Brontë', '9780141439556', 'Romance', 416, 'Une histoire d\'amour tragique.', 1847, 0, 'https://via.placeholder.com/300?text=Hauts+Hurlevent', '2025-09-05 13:56:29', 0),
(22, 'Le Meilleur des mondes', 'Aldous Huxley', '9780060850524', 'Science-Fiction', 288, 'Une dystopie sur un futur contrôlé.', 1932, 1, 'https://via.placeholder.com/300?text=Meilleur+Mondes', '2025-09-05 13:56:29', 5),
(23, 'Anna Karénine', 'Léon Tolstoï', '9780143035008', 'Classique', 864, 'Une tragédie amoureuse en Russie.', 1877, 1, 'https://via.placeholder.com/300?text=Anna+Karénine', '2025-09-05 13:56:29', 5),
(24, 'L\'Amour au temps du choléra', 'Gabriel García Márquez', '9780140123890', 'Romance', 348, 'Une histoire d\'amour à travers le temps.', 1985, 0, 'https://via.placeholder.com/300?text=Amour+Choléra', '2025-09-05 13:56:29', 0),
(25, 'Dracula', 'Bram Stoker', '9780141439846', 'Horreur', 454, 'Un vampire menace l\'Angleterre victorienne.', 1897, 1, 'https://via.placeholder.com/300?text=Dracula', '2025-09-05 13:56:29', 5),
(26, 'L\'Écume des jours', 'Boris Vian', '9782253140870', 'Romance', 317, 'Un roman surréaliste sur l\'amour.', 1947, 0, 'https://via.placeholder.com/300?text=Écume', '2025-09-05 13:56:29', 0),
(27, 'Le Rouge et le Noir', 'Stendhal', '9780140447644', 'Classique', 576, 'Les ambitions d\'un jeune homme.', 1830, 1, 'https://via.placeholder.com/300?text=Rouge+Noir', '2025-09-05 13:56:29', 5),
(28, 'Moby Dick', 'Herman Melville', '9780142437247', 'Aventure', 720, 'La chasse obsessionnelle d\'une baleine.', 1851, 0, 'https://via.placeholder.com/300?text=Moby+Dick', '2025-09-05 13:56:29', 0),
(29, 'Les Raisins de la colère', 'John Steinbeck', '9780143039433', 'Classique', 464, 'Une famille face à la Grande Dépression.', 1939, 1, 'https://via.placeholder.com/300?text=Raisins+Colère', '2025-09-05 13:56:29', 5),
(30, 'Le Portrait de Dorian Gray', 'Oscar Wilde', '9780141439570', 'Classique', 304, 'Un homme conserve sa jeunesse éternelle.', 1890, 1, 'https://via.placeholder.com/300?text=Dorian+Gray', '2025-09-05 13:56:29', 5),
(31, 'Siddhartha', 'Hermann Hesse', '9780553208849', 'Philosophie', 152, 'Un voyage spirituel en Inde.', 1922, 0, 'https://via.placeholder.com/300?text=Siddhartha', '2025-09-05 13:56:29', 0),
(32, 'Les Fleurs du mal', 'Charles Baudelaire', '9780140449914', 'Poésie', 464, 'Un recueil de poèmes symbolistes.', 1857, 1, 'https://via.placeholder.com/300?text=Fleurs+Mal', '2025-09-05 13:56:29', 5),
(33, 'Frankenstein', 'Mary Shelley', '9780141439471', 'Horreur', 280, 'Un scientifique crée une créature monstrueuse.', 1818, 1, 'https://via.placeholder.com/300?text=Frankenstein', '2025-09-05 13:56:29', 5),
(34, 'La Métamorphose', 'Franz Kafka', '9780553213690', 'Classique', 96, 'Un homme se réveille transformé en insecte.', 1915, 0, 'https://via.placeholder.com/300?text=Métamorphose', '2025-09-05 13:56:29', 0),
(35, 'Bel-Ami', 'Guy de Maupassant', '9780140443158', 'Classique', 432, 'L\'ascension sociale d\'un jeune homme.', 1885, 1, 'https://via.placeholder.com/300?text=Bel+ Ami', '2025-09-05 13:56:29', 5),
(36, 'Candide', 'Voltaire', '9780140455106', 'Classique', 144, 'Une satire des idées optimistes.', 1759, 1, 'https://via.placeholder.com/300?text=Candide', '2025-09-05 13:56:29', 5),
(37, 'Le Procès', 'Franz Kafka', '9780805209990', 'Classique', 312, 'Un homme confronté à une justice absurde.', 1925, 0, 'https://via.placeholder.com/300?text=Procès', '2025-09-05 13:56:29', 0),
(38, 'L\'Éneide', 'Virgile', '9780140449327', 'Classique', 496, 'Le voyage d\'Énée après la guerre de Troie.', 19, 1, 'https://via.placeholder.com/300?text=Éneide', '2025-09-05 13:56:29', 5),
(39, 'À la recherche du temps perdu', 'Marcel Proust', '9780142437964', 'Classique', 4211, 'Une exploration de la mémoire et du temps.', 1913, 0, 'https://via.placeholder.com/300?text=Temps+Perdu', '2025-09-05 13:56:29', 0),
(40, 'La Divine Comédie', 'Dante Alighieri', '9780142437223', 'Classique', 798, 'Un voyage à travers l\'Enfer, le Purgatoire et le Paradis.', 1320, 1, 'https://via.placeholder.com/300?text=Divine+Comédie', '2025-09-05 13:56:29', 5),
(41, 'Guerre et Paix', 'Léon Tolstoï', '9780140447934', 'Classique', 1440, 'Une fresque sur la Russie napoléonienne.', 1869, 0, 'https://via.placeholder.com/300?text=Guerre+Paix', '2025-09-05 13:56:29', 0),
(42, 'Les Liaisons dangereuses', 'Pierre Choderlos de Laclos', '9780140449570', 'Classique', 448, 'Des intrigues amoureuses et manipulatrices.', 1782, 1, 'https://via.placeholder.com/300?text=Liaisons+Dangereuses', '2025-09-05 13:56:29', 5),
(43, 'Le Hobbit', 'J.R.R. Tolkien', '9780547928227', 'Fantaisie', 320, 'Les aventures de Bilbon Sacquet.', 1937, 1, 'https://via.placeholder.com/300?text=Hobbit', '2025-09-05 13:56:29', 5),
(44, 'L\'Appel de la forêt', 'Jack London', '9780141321059', 'Aventure', 160, 'Un chien face à la nature sauvage.', 1903, 1, 'https://via.placeholder.com/300?text=Appel+Forêt', '2025-09-05 13:56:29', 5),
(45, 'Jane Eyre', 'Charlotte Brontë', '9780141441146', 'Romance', 576, 'Une orpheline trouve l\'amour et l\'indépendance.', 1847, 0, 'https://via.placeholder.com/300?text=Jane+Eyre', '2025-09-05 13:56:29', 0),
(46, 'Les Aventures de Huckleberry Finn', 'Mark Twain', '9780141321097', 'Aventure', 416, 'Les aventures d\'un garçon sur le Mississippi.', 1884, 1, 'https://via.placeholder.com/300?text=Huckleberry+Finn', '2025-09-05 13:56:29', 5),
(47, 'Le Magicien d\'Oz', 'L. Frank Baum', '9780141321028', 'Fantaisie', 208, 'Une aventure dans un monde magique.', 1900, 1, 'https://via.placeholder.com/300?text=Magicien+Oz', '2025-09-05 13:56:29', 5),
(48, 'L\'Homme invisible', 'H.G. Wells', '9780141439983', 'Science-Fiction', 208, 'Un scientifique devient invisible.', 1897, 0, 'https://via.placeholder.com/300?text=Homme+Invisible', '2025-09-05 13:56:29', 0),
(49, 'Vingt Ans après', 'Alexandre Dumas', '9780140442151', 'Aventure', 880, 'La suite des Trois Mousquetaires.', 1845, 1, 'https://via.placeholder.com/300?text=Vingt+Ans+Après', '2025-09-05 13:56:29', 5),
(50, 'Le Temps des cerises', 'Montserrat Roig', '9788472235823', 'Historique', 320, 'Une fresque sur la guerre civile espagnole.', 1977, 0, 'https://via.placeholder.com/300?text=Temps+Cerises', '2025-09-05 13:56:29', 0),
(51, 'L\'Éducation sentimentale', 'Gustave Flaubert', '9780140447569', 'Classique', 464, 'Les désillusions d\'un jeune homme amoureux.', 1869, 0, 'https://via.placeholder.com/300?text=Éducation+Sentimentale', '2025-09-05 13:56:29', 0),
(52, 'L\'Iliade', 'Homère', '9780140275360', 'Classique', 704, 'La guerre de Troie et les héros grecs.', 800, 1, 'https://via.placeholder.com/300?text=Iliade', '2025-09-05 13:56:29', 5),
(53, 'L\'Étrange Cas du Dr Jekyll et de Mr Hyde', 'Robert Louis Stevenson', '9780141439730', 'Horreur', 128, 'Un homme aux deux personnalités.', 1886, 1, 'https://via.placeholder.com/300?text=Jekyll+Hyde', '2025-09-05 13:56:29', 5),
(54, 'Les Frères Karamazov', 'Fiodor Dostoïevski', '9780140449242', 'Classique', 960, 'Un drame familial et philosophique.', 1880, 0, 'https://via.placeholder.com/300?text=Frères+Karamazov', '2025-09-05 13:56:29', 0),
(55, 'Le Tour du monde en quatre-vingts jours', 'Jules Verne', '9780140449068', 'Aventure', 248, 'Un voyage autour du monde contre la montre.', 1873, 1, 'https://via.placeholder.com/300?text=Tour+Monde', '2025-09-05 13:56:29', 5),
(56, 'La Chartreuse de Parme', 'Stendhal', '9780140449662', 'Classique', 528, 'Les intrigues d\'un jeune noble italien.', 1839, 1, 'https://via.placeholder.com/300?text=Chartreuse+Parme', '2025-09-05 13:56:29', 5),
(57, 'Les Contes de Canterbury', 'Geoffrey Chaucer', '9780140424386', 'Classique', 528, 'Des récits de pèlerins médiévaux.', 1400, 0, 'https://via.placeholder.com/300?text=Contes+Canterbury', '2025-09-05 13:56:29', 0),
(58, 'L\'Archipel du Goulag', 'Alexandre Soljenitsyne', '9782020021166', 'Histoire', 672, 'Une chronique des camps soviétiques.', 1973, 1, 'https://via.placeholder.com/300?text=Archipel+Goulag', '2025-09-05 13:56:29', 5),
(59, 'Le Grand Meaulnes', 'Alain-Fournier', '9780141441894', 'Romance', 224, 'Une histoire d\'amour et de mystère.', 1913, 1, 'https://via.placeholder.com/300?text=Grand+Meaulnes', '2025-09-05 13:56:29', 5),
(60, 'Les Âmes mortes', 'Nikolaï Gogol', '9780140448078', 'Classique', 496, 'Un escroc achète des âmes de serfs décédés.', 1842, 0, 'https://via.placeholder.com/300?text=Âmes+Mortes', '2025-09-05 13:56:29', 0),
(61, 'Matilda', 'Roald Dahl', '9780142410370', 'Children', 240, 'Une petite fille avec des pouvoirs extraordinaires.', 1988, 1, 'https://via.placeholder.com/300?text=Matilda', '2025-09-05 13:56:29', 5),
(62, 'Le Journal d\'Anne Frank', 'Anne Frank', '9780553296983', 'Biographie', 283, 'Le journal d\'une jeune fille pendant l\'Holocauste.', 1947, 0, 'https://via.placeholder.com/300?text=Anne+Frank', '2025-09-05 13:56:29', 0),
(63, 'Les Voyages de Gulliver', 'Jonathan Swift', '9780141439495', 'Classique', 336, 'Les aventures dans des mondes étranges.', 1726, 1, 'https://via.placeholder.com/300?text=Gulliver', '2025-09-05 13:56:29', 5),
(64, 'Le Fantôme de l\'Opéra', 'Gaston Leroux', '9780060809249', 'Horreur', 368, 'Un mystère dans l\'Opéra de Paris.', 1910, 1, 'https://via.placeholder.com/300?text=Fantôme+Opéra', '2025-09-05 13:56:29', 5),
(65, 'Vingt Mille Lieues sous les mers', 'Jules Verne', '9780141441979', 'Aventure', 496, 'Une exploration sous-marine.', 1870, 0, 'https://via.placeholder.com/300?text=Vingt+Mille+Lieues', '2025-09-05 13:56:29', 0),
(66, 'Autant en emporte le vent', 'Margaret Mitchell', '9780446675536', 'Romance', 960, 'Une saga dans le Sud américain.', 1936, 1, 'https://via.placeholder.com/300?text=Autant+Emporte', '2025-09-05 13:56:29', 5),
(67, 'Les Piliers de la Terre', 'Ken Follett', '9780451166890', 'Historique', 983, 'La construction d\'une cathédrale médiévale.', 1989, 1, 'https://via.placeholder.com/300?text=Piliers+Terre', '2025-09-05 13:56:29', 5),
(68, 'Le Da Vinci Code', 'Dan Brown', '9780307474278', 'Thriller', 592, 'Un mystère autour de secrets religieux.', 2003, 0, 'https://via.placeholder.com/300?text=Da+Vinci+Code', '2025-09-05 13:56:29', 0),
(69, 'L\'Attrape-cœurs', 'J.D. Salinger', '9782253151425', 'Classique', 277, 'Un adolescent en crise.', 1951, 1, 'https://via.placeholder.com/300?text=Attrape+Cœurs', '2025-09-05 13:56:29', 5),
(70, 'La Ferme des animaux', 'George Orwell', '9782070368228', 'Classique', 112, 'Une satire du totalitarisme.', 1945, 0, 'https://via.placeholder.com/300?text=Ferme+Animaux', '2025-09-05 13:56:29', 0),
(71, 'Le Vieillard et la Mer', 'Ernest Hemingway', '9782070362363', 'Classique', 128, 'Un pêcheur face à un défi.', 1952, 1, 'https://via.placeholder.com/300?text=Vieillard+Mer', '2025-09-05 13:56:29', 5),
(72, 'Le Silence des agneaux', 'Thomas Harris', '9780312924584', 'Thriller', 352, 'Un tueur en série et une agente du FBI.', 1988, 1, 'https://via.placeholder.com/300?text=Silence+Agneaux', '2025-09-05 13:56:29', 5),
(73, 'Les Chroniques de Narnia', 'C.S. Lewis', '9780066238500', 'Fantaisie', 784, 'Une série d\'aventures dans un monde magique.', 1950, 0, 'https://via.placeholder.com/300?text=Narnia+Chroniques', '2025-09-05 13:56:29', 0),
(74, 'Le Monde de Sophie', 'Jostein Gaarder', '9782020238120', 'Philosophie', 544, 'Une introduction à la philosophie.', 1991, 1, 'https://via.placeholder.com/300?text=Monde+Sophie', '2025-09-05 13:56:29', 5),
(75, 'L\'Homme qui rit', 'Victor Hugo', '9780141441481', 'Classique', 672, 'Un homme défiguré dans une société cruelle.', 1869, 0, 'https://via.placeholder.com/300?text=Homme+Rit', '2025-09-05 13:56:29', 0),
(76, 'L\'Énigme des sables', 'Erskine Childers', '9780143106142', 'Aventure', 336, 'Un mystère d\'espionnage maritime.', 1903, 1, 'https://via.placeholder.com/300?text=Énigme+Sables', '2025-09-05 13:56:29', 5),
(77, 'Le Horla', 'Guy de Maupassant', '9780140449112', 'Horreur', 80, 'Un homme hanté par une présence invisible.', 1887, 1, 'https://via.placeholder.com/300?text=Horla', '2025-09-05 13:56:29', 5),
(78, 'La Peste', 'Albert Camus', '9782070360420', 'Classique', 336, 'Une ville confrontée à une épidémie.', 1947, 0, 'https://via.placeholder.com/300?text=Peste', '2025-09-05 13:56:29', 0),
(79, 'Les Enfants de Húrin', 'J.R.R. Tolkien', '9780007246229', 'Fantaisie', 320, 'Une tragédie dans l\'univers de Tolkien.', 2007, 1, 'https://via.placeholder.com/300?text=Enfants+Húrin', '2025-09-05 13:56:29', 5),
(80, 'Le Désert des Tartares', 'Dino Buzzati', '9782070360680', 'Classique', 256, 'Un officier attend une guerre qui ne vient pas.', 1940, 1, 'https://via.placeholder.com/300?text=Désert+Tartares', '2025-09-05 13:56:29', 5),
(81, 'L\'Iliade', 'Homère', '9780140275360', 'Classique', 704, 'La guerre de Troie et les héros grecs.', 800, 1, 'https://via.placeholder.com/300?text=Iliade', '2025-09-05 13:56:29', 5),
(82, 'L\'Étrange Cas du Dr Jekyll et de Mr Hyde', 'Robert Louis Stevenson', '9780141439730', 'Horreur', 128, 'Un homme aux deux personnalités.', 1886, 1, 'https://via.placeholder.com/300?text=Jekyll+Hyde', '2025-09-05 13:56:29', 5),
(83, 'Les Frères Karamazov', 'Fiodor Dostoïevski', '9780140449242', 'Classique', 960, 'Un drame familial et philosophique.', 1880, 0, 'https://via.placeholder.com/300?text=Frères+Karamazov', '2025-09-05 13:56:29', 0),
(84, 'Le Tour du monde en quatre-vingts jours', 'Jules Verne', '9780140449068', 'Aventure', 248, 'Un voyage autour du monde contre la montre.', 1873, 1, 'https://via.placeholder.com/300?text=Tour+Monde', '2025-09-05 13:56:29', 5),
(85, 'La Chartreuse de Parme', 'Stendhal', '9780140449662', 'Classique', 528, 'Les intrigues d\'un jeune noble italien.', 1839, 1, 'https://via.placeholder.com/300?text=Chartreuse+Parme', '2025-09-05 13:56:29', 5),
(86, 'Les Contes de Canterbury', 'Geoffrey Chaucer', '9780140424386', 'Classique', 528, 'Des récits de pèlerins médiévaux.', 1400, 0, 'https://via.placeholder.com/300?text=Contes+Canterbury', '2025-09-05 13:56:29', 0),
(87, 'L\'Archipel du Goulag', 'Alexandre Soljenitsyne', '9782020021166', 'Histoire', 672, 'Une chronique des camps soviétiques.', 1973, 1, 'https://via.placeholder.com/300?text=Archipel+Goulag', '2025-09-05 13:56:29', 5),
(88, 'Le Grand Meaulnes', 'Alain-Fournier', '9780141441894', 'Romance', 224, 'Une histoire d\'amour et de mystère.', 1913, 1, 'https://via.placeholder.com/300?text=Grand+Meaulnes', '2025-09-05 13:56:29', 5),
(89, 'Les Âmes mortes', 'Nikolaï Gogol', '9780140448078', 'Classique', 496, 'Un escroc achète des âmes de serfs décédés.', 1842, 0, 'https://via.placeholder.com/300?text=Âmes+Mortes', '2025-09-05 13:56:29', 0),
(90, 'Le Joueur d\'échecs', 'Stefan Zweig', '9782253153757', 'Classique', 112, 'Un duel psychologique sur un paquebot.', 1943, 1, 'https://via.placeholder.com/300?text=Joueur+Échecs', '2025-09-05 13:56:29', 5),
(91, 'L\'Amant de Lady Chatterley', 'D.H. Lawrence', '9780141441498', 'Romance', 384, 'Une histoire d\'amour controversée.', 1928, 1, 'https://via.placeholder.com/300?text=Lady+Chatterley', '2025-09-05 13:56:29', 5),
(92, 'Le Pavillon d\'or', 'Yukio Mishima', '9782070369775', 'Classique', 288, 'Un moine obsédé par un temple.', 1956, 0, 'https://via.placeholder.com/300?text=Pavillon+Or', '2025-09-05 13:56:29', 0),
(93, 'Le Bruit et la Fureur', 'William Faulkner', '9782070215324', 'Classique', 352, 'Une famille en déclin dans le Sud américain.', 1929, 1, 'https://via.placeholder.com/300?text=Bruit+Fureur', '2025-09-05 13:56:29', 5),
(94, 'Le Guépard', 'Giuseppe Tomasi di Lampedusa', '9782070360284', 'Classique', 320, 'Le déclin de l\'aristocratie sicilienne.', 1958, 0, 'https://via.placeholder.com/300?text=Guépard', '2025-09-05 13:56:29', 0),
(95, 'Le Mur', 'Jean-Paul Sartre', '9782070368785', 'Philosophie', 192, 'Un recueil de nouvelles existentialistes.', 1939, 1, 'https://via.placeholder.com/300?text=Mur', '2025-09-05 13:56:29', 5),
(96, 'La Condition humaine', 'André Malraux', '9782070360017', 'Classique', 368, 'Une révolte en Chine dans les années 1920.', 1933, 1, 'https://via.placeholder.com/300?text=Condition+Humaine', '2025-09-05 13:56:29', 5),
(97, 'Zazie dans le métro', 'Raymond Queneau', '9782070361038', 'Classique', 192, 'Les aventures d\'une jeune fille à Paris.', 1959, 0, 'https://via.placeholder.com/300?text=Zazie', '2025-09-05 13:56:29', 0),
(98, 'Iliade', 'Homère', '9780140275360', 'Classique', 704, 'La guerre de Troie et ses héros.', 800, 1, 'https://via.placeholder.com/300?text=Iliade', '2025-09-05 13:56:29', 5);

-- (The `films` and `games` tables remain unchanged from the previous artifact and are included for completeness)

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `director` varchar(255) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `description` text,
  `year` int DEFAULT NULL,
  `available` tinyint(1) DEFAULT '1',
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `stock` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`id`, `title`, `director`, `rating`, `genre`, `duration`, `description`, `year`, `available`, `image_url`, `created_at`, `stock`) VALUES
(1, 'The Shawshank Redemption', 'Frank Darabont', 'R', 'Drame', 142, 'Two imprisoned men bond over years, finding solace and eventual redemption.', 1994, 1, 'https://resizing.flixster.com/tdMXmsVnR-vIj4Q5IACpEZ7O1ak=/fit-in/705x460/v2/https://resizing.flixster.com/-XZAfHZM39UwaGJIFWKAE8fS0ak=/v3/t/assets/p15987_v_h8_au.jpg', '2025-09-03 10:25:21', 5),
(2, 'The Godfather', 'Francis Ford Coppola', 'R', 'Crime', 175, 'The aging patriarch of an organized crime dynasty transfers control to his son.', 1972, 1, 'https://images.mubicdn.net/images/film/488/cache-47680-1745490954/image-w1280.jpg', '2025-09-03 10:25:21', 5),
(3, 'The Dark Knight', 'Christopher Nolan', 'PG-13', 'Action', 152, 'Batman faces the Joker in a battle for Gotham\'s soul.', 2008, 1, 'https://musicart.xboxlive.com/7/176b5100-0000-0000-0000-000000000002/504/image.jpg', '2025-09-03 10:25:21', 5),
(4, 'The Godfather Part II', 'Francis Ford Coppola', 'R', 'Crime', 202, 'The early life and career of Vito Corleone in 1920s New York.', 1974, 1, 'https://m.media-amazon.com/images/S/pv-target-images/111135eb34a021b419d09f2f149f3221e593a31e8d4bc27eec679fb9dd4768ee.jpg', '2025-09-03 10:25:21', 5),
(5, '12 Angry Men', 'Sidney Lumet', 'Approved', 'Drame', 96, 'A jury holdout attempts to prevent a miscarriage of justice.', 1957, 1, 'https://m.media-amazon.com/images/S/pv-target-images/b92d2865829416e35e7102a3934a2ee745f3b903a95678710442d4299d86f39c.jpg', '2025-09-03 10:25:21', 5),
(6, 'Schindler\'s List', 'Steven Spielberg', 'R', 'Drame', 195, 'A German businessman saves Jews during the Holocaust.', 1993, 1, 'https://ds.static.rtbf.be/article/image/1920x1080/9/1/b/b0df46967b8ef41b029914b28affcbd6-1549961359.jpg', '2025-09-03 10:25:21', 5),
(7, 'The Lord of the Rings: The Return of the King', 'Peter Jackson', 'PG-13', 'Fantaisie', 201, 'Gandalf and Aragorn lead the World of Men against Sauron\'s army.', 2003, 1, 'https://m.media-amazon.com/images/S/pv-target-images/367c0542c4a8ce887a6d10229bfa06de1d90b1f52b33301ea426c52f06ae0432.jpg', '2025-09-03 10:25:21', 5),
(8, 'Pulp Fiction', 'Quentin Tarantino', 'R', 'Crime', 154, 'The lives of two mob hitmen, a boxer, and others intertwine.', 1994, 1, 'https://m.media-amazon.com/images/I/71rpGtseYcL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(9, 'Forrest Gump', 'Robert Zemeckis', 'PG-13', 'Drame', 142, 'The life of a man with low IQ who achieves great things.', 1994, 1, 'https://static.fnac-static.com/multimedia/Images/FR/NR/69/5b/09/613225/1507-1/tsp20180829112024/Forrest-gump.jpg', '2025-09-03 10:25:21', 5),
(10, 'Inception', 'Christopher Nolan', 'PG-13', 'Science-Fiction', 148, 'A thief enters the subconscious of his targets to steal information.', 2010, 1, 'https://shunrize.com/blog/wp-content/uploads/2010/07/Inception.jpg', '2025-09-03 10:25:21', 5),
(11, 'Fight Club', 'David Fincher', 'R', 'Drame', 139, 'An office worker and a soap salesman form an underground fight club.', 1999, 1, 'https://m.media-amazon.com/images/I/51v5ZpFyaFL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(12, 'The Lord of the Rings: The Fellowship of the Ring', 'Peter Jackson', 'PG-13', 'Fantaisie', 178, 'A hobbit begins a quest to destroy a powerful ring.', 2001, 1, 'https://m.media-amazon.com/images/I/81EBp0vOZZL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(13, 'Star Wars: Episode V - The Empire Strikes Back', 'Irvin Kershner', 'PG', 'Science-Fiction', 124, 'The rebels face the Galactic Empire.', 1980, 1, 'https://upload.wikimedia.org/wikipedia/en/3/3c/SW_-_Empire_Strikes_Back.jpg', '2025-09-03 10:25:21', 5),
(14, 'The Matrix', 'Lana Wachowski, Lilly Wachowski', 'R', 'Science-Fiction', 136, 'A hacker discovers a simulated reality.', 1999, 1, 'https://m.media-amazon.com/images/S/pv-target-images/7a8050a4b6e5b9f2c1b0b9e7a92c9b0d4d5f6b2c5c6f7b0a8c9d9a0b1c2d3e4f.jpg', '2025-09-03 10:25:21', 5),
(15, 'Goodfellas', 'Martin Scorsese', 'R', 'Crime', 146, 'The rise and fall of a mob associate.', 1990, 1, 'https://m.media-amazon.com/images/I/81b1HGHWv6L._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(16, 'One Flew Over the Cuckoo\'s Nest', 'Milos Forman', 'R', 'Drame', 133, 'A criminal fakes insanity to avoid prison.', 1975, 1, 'https://m.media-amazon.com/images/I/61D2+6v2V0L._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(17, 'Seven', 'David Fincher', 'R', 'Thriller', 127, 'Two detectives hunt a serial killer.', 1995, 1, 'https://m.media-amazon.com/images/I/51k0D7HF5gL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(18, 'The Lord of the Rings: The Two Towers', 'Peter Jackson', 'PG-13', 'Fantaisie', 179, 'The fellowship continues their quest.', 2002, 1, 'https://m.media-amazon.com/images/I/81M4I7O0PPL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(19, 'Star Wars: Episode IV - A New Hope', 'George Lucas', 'PG', 'Science-Fiction', 121, 'A farm boy joins the rebellion.', 1977, 1, 'https://upload.wikimedia.org/wikipedia/en/8/87/StarWarsMoviePoster1977.jpg', '2025-09-03 10:25:21', 5),
(20, 'City of God', 'Fernando Meirelles', 'R', 'Crime', 130, 'Life in a Brazilian slum.', 2002, 1, 'https://m.media-amazon.com/images/I/81zjdVq4G+L._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(21, 'Se7en', 'David Fincher', 'R', 'Thriller', 127, 'A serial killer uses the seven sins.', 1995, 1, 'https://m.media-amazon.com/images/I/51k0D7HF5gL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(22, 'The Silence of the Lambs', 'Jonathan Demme', 'R', 'Thriller', 118, 'An FBI agent seeks a cannibal\'s help.', 1991, 1, 'https://m.media-amazon.com/images/I/91hkbq2N+LL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(23, 'It\'s a Wonderful Life', 'Frank Capra', 'PG', 'Drame', 130, 'An angel shows a man his life\'s impact.', 1946, 1, 'https://m.media-amazon.com/images/I/91z7J0p1+6L._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(24, 'Life Is Beautiful', 'Roberto Benigni', 'PG-13', 'Drame', 116, 'A father protects his son in a concentration camp.', 1997, 1, 'https://m.media-amazon.com/images/I/81+5V6y0oFL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(25, 'The Usual Suspects', 'Bryan Singer', 'R', 'Crime', 106, 'A con artist tells a twisted tale.', 1995, 1, 'https://m.media-amazon.com/images/I/71k8D2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(26, 'Léon: The Professional', 'Luc Besson', 'R', 'Action', 110, 'A hitman befriends a young girl.', 1994, 1, 'https://m.media-amazon.com/images/I/71kJ7eY3gWL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(27, 'Spirited Away', 'Hayao Miyazaki', 'PG', 'Animation', 125, 'A girl navigates a spirit world.', 2001, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(28, 'Saving Private Ryan', 'Steven Spielberg', 'R', 'Guerre', 169, 'Soldiers search for a paratrooper.', 1998, 1, 'https://m.media-amazon.com/images/I/91o6+2B1eDL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(29, 'Once Upon a Time in the West', 'Sergio Leone', 'PG-13', 'Western', 165, 'A mysterious stranger in a land dispute.', 1968, 1, 'https://m.media-amazon.com/images/I/91k8D2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(30, 'American History X', 'Tony Kaye', 'R', 'Drame', 119, 'A reformed neo-Nazi tries to save his brother.', 1998, 1, 'https://m.media-amazon.com/images/I/71z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(31, 'Interstellar', 'Christopher Nolan', 'PG-13', 'Science-Fiction', 169, 'Astronauts seek a new home for humanity.', 2014, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(32, 'Casablanca', 'Michael Curtiz', 'PG', 'Romance', 102, 'A love story in wartime Morocco.', 1942, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(33, 'City Lights', 'Charlie Chaplin', 'G', 'Comédie', 87, 'A tramp falls in love with a blind girl.', 1931, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(34, 'Psycho', 'Alfred Hitchcock', 'R', 'Thriller', 109, 'A woman hides in a motel with a dark secret.', 1960, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(35, 'The Green Mile', 'Frank Darabont', 'R', 'Drame', 189, 'A prison guard discovers an inmate\'s powers.', 1999, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(36, 'The Intouchables', 'Olivier Nakache, Éric Toledano', 'R', 'Comédie', 112, 'A paraplegic aristocrat hires a young man.', 2011, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(37, 'Modern Times', 'Charlie Chaplin', 'G', 'Comédie', 87, 'A worker struggles in the industrial age.', 1936, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(38, 'Raiders of the Lost Ark', 'Steven Spielberg', 'PG', 'Aventure', 115, 'An archaeologist races to find the Ark.', 1981, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(39, 'Rear Window', 'Alfred Hitchcock', 'PG', 'Thriller', 112, 'A photographer suspects a murder.', 1954, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(40, 'The Pianist', 'Roman Polanski', 'R', 'Drame', 150, 'A Jewish pianist survives the Holocaust.', 2002, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(41, 'The Departed', 'Martin Scorsese', 'R', 'Crime', 151, 'An undercover cop and a mole in the police.', 2006, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(42, 'Terminator 2: Judgment Day', 'James Cameron', 'R', 'Science-Fiction', 137, 'A cyborg protects a boy from a killer robot.', 1991, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(43, 'Back to the Future', 'Robert Zemeckis', 'PG', 'Science-Fiction', 116, 'A teen travels back to 1955.', 1985, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(44, 'Whiplash', 'Damien Chazelle', 'R', 'Drame', 107, 'A young drummer and his intense teacher.', 2014, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(45, 'Gladiator', 'Ridley Scott', 'R', 'Action', 155, 'A Roman general seeks revenge.', 2000, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(46, 'The Prestige', 'Christopher Nolan', 'PG-13', 'Drame', 130, 'Two magicians in a deadly rivalry.', 2006, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(47, 'The Lion King', 'Roger Allers, Rob Minkoff', 'G', 'Animation', 88, 'A lion cub becomes king.', 1994, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(48, 'Memento', 'Christopher Nolan', 'R', 'Thriller', 113, 'A man with memory loss seeks his wife\'s killer.', 2000, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(49, 'Apocalypse Now', 'Francis Ford Coppola', 'R', 'Guerre', 147, 'A soldier\'s mission in Vietnam.', 1979, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(50, 'Alien', 'Ridley Scott', 'R', 'Science-Fiction', 117, 'A crew faces a deadly alien.', 1979, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(51, 'Sunset Boulevard', 'Billy Wilder', 'Approved', 'Drame', 110, 'A faded star and a screenwriter.', 1950, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(52, 'Dr. Strangelove', 'Stanley Kubrick', 'PG', 'Comédie', 95, 'A satirical take on the Cold War.', 1964, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(53, 'The Great Dictator', 'Charlie Chaplin', 'G', 'Comédie', 125, 'A barber mistaken for a dictator.', 1940, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(54, 'Cinema Paradiso', 'Giuseppe Tornatore', 'PG', 'Drame', 155, 'A filmmaker recalls his childhood.', 1988, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(55, 'The Lives of Others', 'Florian Henckel von Donnersmarck', 'R', 'Drame', 137, 'A Stasi officer spies on a playwright.', 2006, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(56, 'Grave of the Fireflies', 'Isao Takahata', 'Unrated', 'Animation', 89, 'Two siblings survive WWII Japan.', 1988, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(57, 'Paths of Glory', 'Stanley Kubrick', 'Approved', 'Guerre', 88, 'Soldiers face injustice in WWI.', 1957, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(58, 'Django Unchained', 'Quentin Tarantino', 'R', 'Western', 165, 'A freed slave seeks his wife.', 2012, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(59, 'The Shining', 'Stanley Kubrick', 'R', 'Horreur', 146, 'A writer goes mad in an isolated hotel.', 1980, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(60, 'WALL-E', 'Andrew Stanton', 'G', 'Animation', 98, 'A robot cleans a deserted Earth.', 2008, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(61, 'American Beauty', 'Sam Mendes', 'R', 'Drame', 122, 'A man faces a midlife crisis.', 1999, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(62, 'The Dark Knight Rises', 'Christopher Nolan', 'PG-13', 'Action', 164, 'Batman faces a new threat in Gotham.', 2012, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(63, 'Princess Mononoke', 'Hayao Miyazaki', 'PG-13', 'Animation', 134, 'A prince caught in a conflict.', 1997, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(64, 'Aliens', 'James Cameron', 'R', 'Science-Fiction', 137, 'Ripley faces a colony of aliens.', 1986, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(65, 'Oldboy', 'Park Chan-wook', 'R', 'Thriller', 120, 'A man seeks revenge after captivity.', 2003, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(66, 'Once Upon a Time in America', 'Sergio Leone', 'R', 'Crime', 229, 'A gangster\'s life in New York.', 1984, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(67, 'Witness for the Prosecution', 'Billy Wilder', 'Approved', 'Drame', 116, 'A lawyer defends a man accused of murder.', 1957, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(68, 'Das Boot', 'Wolfgang Petersen', 'R', 'Guerre', 149, 'Life aboard a German U-boat.', 1981, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(69, 'Citizen Kane', 'Orson Welles', 'PG', 'Drame', 119, 'The rise and fall of a media tycoon.', 1941, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(70, 'North by Northwest', 'Alfred Hitchcock', 'Approved', 'Thriller', 136, 'A man is mistaken for a spy.', 1959, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(71, 'Vertigo', 'Alfred Hitchcock', 'PG', 'Thriller', 128, 'A detective with a fear of heights.', 1958, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(72, 'Star Wars: Episode VI - Return of the Jedi', 'Richard Marquand', 'PG', 'Science-Fiction', 131, 'The rebels fight to destroy the Death Star.', 1983, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(73, 'Reservoir Dogs', 'Quentin Tarantino', 'R', 'Crime', 99, 'A heist gone wrong.', 1992, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(74, 'Braveheart', 'Mel Gibson', 'R', 'Historique', 178, 'A Scotsman leads a rebellion.', 1995, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(75, 'M', 'Fritz Lang', 'Not Rated', 'Thriller', 99, 'A city hunts a child murderer.', 1931, 1, 'https://m.media-amazon.com/images/I/91z3J2z3WvL._UF1000,1000_QL80_.jpg', '2025-09-03 10:25:21', 5),
(76, 'Requiem for a Dream', 'Darren Aronofsky', 'R', 'Drame', 102, 'Four lives spiral due to addiction.', 2000, 1, 'https://m.media-amazon.com/images/I/91z3J