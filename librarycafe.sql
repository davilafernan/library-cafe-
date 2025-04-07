-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : ven. 28 mars 2025 à 10:40
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `librarycafe`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `date_commande` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `total`, `utilisateur_id`, `date_commande`) VALUES
(1, 2.50, 2, '2025-02-23 15:49:36'),
(2, 15.50, 2, '2025-02-23 15:50:00'),
(3, 14.00, 2, '2025-02-23 16:01:03'),
(4, 15.50, 3, '2025-02-26 16:37:48'),
(5, 15.50, 3, '2025-02-26 18:04:48'),
(6, 2.50, 3, '2025-02-26 18:20:35'),
(7, 2.50, 3, '2025-02-26 18:20:49'),
(8, 2.50, 3, '2025-02-26 18:20:53'),
(9, 2.50, 3, '2025-02-26 18:21:09'),
(10, 2.50, 3, '2025-02-26 18:21:19'),
(11, 2.50, 3, '2025-02-26 18:21:55'),
(12, 2.50, 3, '2025-02-26 18:22:08'),
(13, 2.50, 3, '2025-02-26 18:23:03'),
(14, 2.50, 3, '2025-02-26 18:23:10'),
(15, 2.50, 3, '2025-02-26 18:23:16'),
(16, 18.00, 3, '2025-02-27 08:15:32'),
(17, 18.00, 3, '2025-02-27 08:16:23'),
(18, 10.00, 3, '2025-03-21 15:42:57'),
(19, 5.00, 3, '2025-03-21 15:43:05'),
(20, 22.50, 3, '2025-03-21 15:44:07'),
(21, 15.50, 3, '2025-03-21 15:49:13');

-- --------------------------------------------------------

--
-- Structure de la table `commande_item`
--

CREATE TABLE `commande_item` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande_item`
--

INSERT INTO `commande_item` (`id`, `commande_id`, `produit_id`, `quantite`, `prix`) VALUES
(1, 1, 2, 1, 2.50),
(2, 2, 1, 1, 2.50),
(3, 2, 2, 1, 2.50),
(4, 2, 3, 1, 3.00),
(5, 2, 4, 1, 3.00),
(6, 2, 5, 1, 4.50),
(7, 3, 1, 1, 2.50),
(8, 3, 2, 1, 2.50),
(9, 3, 3, 1, 3.00),
(10, 3, 4, 2, 3.00),
(11, 4, 1, 1, 2.50),
(12, 4, 2, 1, 2.50),
(13, 4, 3, 1, 3.00),
(14, 4, 4, 1, 3.00),
(15, 4, 5, 1, 4.50),
(16, 5, 1, 1, 2.50),
(17, 5, 2, 1, 2.50),
(18, 5, 3, 1, 3.00),
(19, 5, 4, 1, 3.00),
(20, 5, 5, 1, 4.50),
(21, 6, 2, 1, 2.50),
(22, 7, 2, 1, 2.50),
(23, 8, 2, 1, 2.50),
(24, 9, 2, 1, 2.50),
(25, 10, 2, 1, 2.50),
(26, 11, 2, 1, 2.50),
(27, 12, 2, 1, 2.50),
(28, 13, 2, 1, 2.50),
(29, 14, 2, 1, 2.50),
(30, 15, 2, 1, 2.50),
(31, 16, 2, 2, 2.50),
(32, 16, 1, 1, 2.50),
(33, 16, 3, 1, 3.00),
(34, 16, 4, 1, 3.00),
(35, 16, 5, 1, 4.50),
(36, 17, 2, 2, 2.50),
(37, 17, 1, 1, 2.50),
(38, 17, 3, 1, 3.00),
(39, 17, 4, 1, 3.00),
(40, 17, 5, 1, 4.50),
(41, 18, 1, 2, 2.50),
(42, 18, 2, 2, 2.50),
(43, 19, 1, 1, 2.50),
(44, 19, 2, 1, 2.50),
(45, 20, 1, 1, 2.50),
(46, 20, 2, 8, 2.50),
(47, 21, 1, 1, 2.50),
(48, 21, 2, 1, 2.50),
(49, 21, 3, 1, 3.00),
(50, 21, 4, 1, 3.50),
(51, 21, 6, 1, 4.00);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prix` decimal(5,2) NOT NULL,
  `stock` int(11) DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `prix`, `stock`) VALUES
(1, 'Thé', 2.50, 0),
(2, 'Expresso', 2.50, 97),
(3, 'Chocolat Chaud', 3.00, 100),
(4, 'Thé Glacé', 3.00, 99),
(5, 'Smoothie', 4.50, 96),
(6, 'Latte Noisette', 2.00, 100),
(7, 'Madelaine', 3.00, 100),
(8, 'Tarte au Fraise', 5.00, 50),
(9, 'Latte', 1.50, 100),
(10, 'Chai Latte', 2.50, 100),
(11, 'Matcha Latte', 2.50, 100),
(12, 'Matcha', 2.00, 100),
(13, 'Frappe', 2.00, 100),
(14, 'Thé en bouteille', 1.00, 100),
(15, 'Café en bouteille', 1.00, 100),
(16, 'Milk Tea en bouteille', 1.00, 100),
(17, 'Soda à la pêche en bouteille', 1.00, 100),
(18, 'Ginger Ale en bouteille', 1.00, 100);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `mot_de_passe`, `date_inscription`) VALUES
(1, 'admin', 'Nour.mesbahi.0@gmail.com', '$2y$10$w/emHcEtjtahKs4qYA.68.F4pSe/4jGJnIDouJx6rFUYOX4GFCLjy', '2025-02-12 10:59:29'),
(2, 'Mesbahi', 'Nour.mesbahi@gmail.com', '$2y$10$FxORK8KpNk6I9LJefznUNehJXxhQP6YK8q4q8QIWX53kfjOsgmUzO', '2025-02-22 17:46:50'),
(3, 'moi', 'Nour@gmail.com', '$2y$10$bwSX8iPish1CVWO8uJzz.OzP15eg8ohl9wcV11UAh8djxF7RJHLxK', '2025-02-26 16:37:28');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande_item`
--
ALTER TABLE `commande_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `commande_item`
--
ALTER TABLE `commande_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande_item`
--
ALTER TABLE `commande_item`
  ADD CONSTRAINT `commande_item_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`);
COMMIT;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL
);

ALTER TABLE produits ADD categorie_id INT DEFAULT NULL;
ALTER TABLE produits
  ADD FOREIGN KEY (categorie_id) REFERENCES categories(id);
ALTER TABLE produits ADD image VARCHAR(255) DEFAULT NULL;
ALTER TABLE produits
ADD description TEXT AFTER nom,
ADD statut VARCHAR(50) DEFAULT 'Disponible' AFTER stock,
MODIFY image VARCHAR(255) DEFAULT NULL;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
