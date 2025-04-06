-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 06 avr. 2025 à 21:35
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
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'Lattes'),
(2, 'Macchiatos'),
(3, 'Matcha'),
(4, 'Thés'),
(5, 'Boissons Glacées');

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

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(5,2) NOT NULL,
  `stock` int(11) DEFAULT 100,
  `statut` varchar(50) DEFAULT 'Disponible',
  `image` varchar(255) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `stock`, `statut`, `image`, `categorie_id`) VALUES
(1, 'Latte Classique', 'Un délicieux latte onctueux classique.', 2.50, 100, 'Disponible', 'latte_classique.jpg', 1),
(2, 'Macchiato Crème', 'Macchiato doux avec crème fouettée.', 3.00, 100, 'Disponible', 'macchiato_creme.jpg', 2),
(3, 'Caramel Macchiato', 'Espresso riche, lait chaud et caramel.', 3.80, 100, 'Disponible', 'caramel_macchiato.jpg', 2),
(4, 'Matcha Latte', 'Latte au matcha onctueux, doux et rafraîchissant.', 3.50, 100, 'Disponible', 'matcha_latte.jpg', 3),
(5, 'Matcha Latte Duo', 'Version chaude et glacée du célèbre matcha.', 4.20, 100, 'Disponible', 'matcha_latte_duo.jpg', 3),
(6, 'Matcha Latte Glacé', 'Latte glacé au matcha vibrant.', 3.60, 100, 'Disponible', 'iced_matcha_latte.jpg', 3),
(7, 'Matcha Latte Crème', 'Latte au matcha avec mousse crémeuse.', 3.40, 100, 'Disponible', 'matcha_latte_creme.jpg', 3),
(8, 'English Breakfast Latte', 'Thé noir classique avec une touche de lait.', 3.00, 100, 'Disponible', 'english_breakfast_latte.jpg', 4),
(9, 'Thé Noir Glacé', 'Thé noir infusé à froid, parfait pour l’été.', 2.00, 100, 'Disponible', 'iced_black_tea.jpg', 4),
(10, 'Latte Classique', 'Un délicieux latte onctueux classique.', 2.50, 100, 'Disponible', 'latte_classique.jpg', 1),
(11, 'Macchiato Crème', 'Macchiato doux avec crème fouettée.', 3.00, 100, 'Disponible', 'macchiato_creme.jpg', 2),
(12, 'Caramel Macchiato', 'Espresso riche, lait chaud et caramel.', 3.80, 100, 'Disponible', 'caramel_macchiato.jpg', 2),
(13, 'Matcha Latte', 'Latte au matcha onctueux, doux et rafraîchissant.', 3.50, 100, 'Disponible', 'matcha_latte.jpg', 3),
(14, 'Matcha Latte Duo', 'Version chaude et glacée du célèbre matcha.', 4.20, 100, 'Disponible', 'matcha_latte_duo.jpg', 3),
(15, 'Matcha Latte Glacé', 'Latte glacé au matcha vibrant.', 3.60, 100, 'Disponible', 'iced_matcha_latte.jpg', 3),
(16, 'Matcha Latte Crème', 'Latte au matcha avec mousse crémeuse.', 3.40, 100, 'Disponible', 'matcha_latte_creme.jpg', 3),
(17, 'English Breakfast Latte', 'Thé noir classique avec une touche de lait.', 3.00, 100, 'Disponible', 'english_breakfast_latte.jpg', 4),
(18, 'Thé Noir Glacé', 'Thé noir infusé à froid, parfait pour l’été.', 2.00, 100, 'Disponible', 'iced_black_tea.jpg', 4),
(19, 'Latte Classique', 'Un délicieux latte onctueux classique.', 2.50, 100, 'Disponible', 'latte_classique.jpg', 1),
(20, 'Macchiato Crème', 'Macchiato doux avec crème fouettée.', 3.00, 100, 'Disponible', 'macchiato_creme.jpg', 2),
(21, 'Caramel Macchiato', 'Espresso riche, lait chaud et caramel.', 3.80, 100, 'Disponible', 'caramel_macchiato.jpg', 2),
(22, 'Matcha Latte', 'Latte au matcha onctueux, doux et rafraîchissant.', 3.50, 100, 'Disponible', 'matcha_latte.jpg', 3),
(23, 'Matcha Latte Duo', 'Version chaude et glacée du célèbre matcha.', 4.20, 100, 'Disponible', 'matcha_latte_duo.jpg', 3),
(24, 'Matcha Latte Glacé', 'Latte glacé au matcha vibrant.', 3.60, 100, 'Disponible', 'iced_matcha_latte.jpg', 3),
(25, 'Matcha Latte Crème', 'Latte au matcha avec mousse crémeuse.', 3.40, 100, 'Disponible', 'matcha_latte_creme.jpg', 3),
(26, 'English Breakfast Latte', 'Thé noir classique avec une touche de lait.', 3.00, 100, 'Disponible', 'english_breakfast_latte.jpg', 4),
(27, 'Thé Noir Glacé', 'Thé noir infusé à froid, parfait pour l’été.', 2.00, 100, 'Disponible', 'iced_black_tea.jpg', 4),
(28, 'Latte Classique', 'Un délicieux latte onctueux classique.', 2.50, 100, 'Disponible', 'latte_classique.jpg', 1),
(29, 'Macchiato Crème', 'Macchiato doux avec crème fouettée.', 3.00, 100, 'Disponible', 'macchiato_creme.jpg', 2),
(30, 'Caramel Macchiato', 'Espresso riche, lait chaud et caramel.', 3.80, 100, 'Disponible', 'caramel_macchiato.jpg', 2),
(31, 'Matcha Latte', 'Latte au matcha onctueux, doux et rafraîchissant.', 3.50, 100, 'Disponible', 'matcha_latte.jpg', 3),
(32, 'Matcha Latte Duo', 'Version chaude et glacée du célèbre matcha.', 4.20, 100, 'Disponible', 'matcha_latte_duo.jpg', 3),
(33, 'Matcha Latte Glacé', 'Latte glacé au matcha vibrant.', 3.60, 100, 'Disponible', 'iced_matcha_latte.jpg', 3),
(34, 'Matcha Latte Crème', 'Latte au matcha avec mousse crémeuse.', 3.40, 100, 'Disponible', 'matcha_latte_creme.jpg', 3),
(35, 'English Breakfast Latte', 'Thé noir classique avec une touche de lait.', 3.00, 100, 'Disponible', 'english_breakfast_latte.jpg', 4),
(36, 'Thé Noir Glacé', 'Thé noir infusé à froid, parfait pour l’été.', 2.00, 100, 'Disponible', 'iced_black_tea.jpg', 4);

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
(1, 'admin', 'Nour@gmail.com', '$2y$10$1RO9YZuXQwdRVGUt2IAMCuHSInZkVO5rUZMzgkeJ7K3s08AAnWpvW', '2025-04-06 16:38:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

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
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande_item`
--
ALTER TABLE `commande_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commande_item`
--
ALTER TABLE `commande_item`
  ADD CONSTRAINT `commande_item_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
