
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
  `nom` varchar(100) NOT NULL,
  `type` varchar(20) DEFAULT 'Boisson'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `type`) VALUES
(1, 'Lattes', 'Boisson'),
(2, 'Macchiatos', 'Boisson'),
(3, 'Matcha', 'Boisson'),
(4, 'Thés', 'Boisson'),
(5, 'Boissons Glacées', 'Boisson'),
(6, 'Romans', 'Livre'),
(7, 'Science-Fiction', 'Livre'),
(8, 'Biographies', 'Livre'),
(9, 'Poésie', 'Livre'),
(10, 'Essais', 'Livre'),
(11, 'BD & Mangas', 'Livre');

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
(1, 4.50, 1, '2025-04-06 21:51:09'),
(2, 4.50, 1, '2025-04-07 07:17:32');

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
(1, 1, 1, 1, 4.50),
(2, 2, 1, 1, 4.50);

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
  `categorie_id` int(11) DEFAULT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `auteur` varchar(100) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT 'Boisson'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `stock`, `statut`, `image`, `categorie_id`, `categorie`, `auteur`, `annee`, `type`) VALUES
(1, 'Caramel Macchiato', 'Espresso mélangé à du lait chaud avec un filet de caramel.', 4.50, 98, 'Disponible', 'uploads/caramel_macchiato.jpg', 2, NULL, NULL, NULL, 'Boisson'),
(2, 'Espresso', 'Café serré au goût intense.', 2.50, 100, 'Disponible', 'uploads/expresso.jpg', 5, NULL, NULL, NULL, 'Boisson'),
(3, 'Frappé Mangue', 'Boisson glacée à la mangue, parfaite pour l’été.', 4.00, 100, 'Populaire', 'uploads/frappemangue.jpg', 5, NULL, NULL, NULL, 'Boisson'),
(4, 'Latte Classique', 'Espresso doux avec une grande quantité de lait chaud.', 3.50, 100, 'Disponible', 'uploads/latte_classique.jpg', 1, NULL, NULL, NULL, 'Boisson'),
(5, 'Mint Citrus Tea', 'Thé rafraîchissant à la menthe et agrumes.', 3.20, 100, 'Disponible', 'uploads/mint_citrus.jpg', 4, NULL, NULL, NULL, 'Boisson'),
(6, 'Thé Menthe', 'Thé vert parfumé à la menthe douce.', 2.80, 100, 'Disponible', 'uploads/Thé_menthe.jpg', 4, NULL, NULL, NULL, 'Boisson'),
(7, 'Thé Hibiscus Glacé', 'Infusion glacée d’hibiscus, fruitée et désaltérante.', 3.00, 100, 'Disponible', 'uploads/théhybiscusglace.jpg', 4, NULL, NULL, NULL, 'Boisson'),
(8, 'Thé Glacé Noir', 'Thé noir servi froid avec des glaçons.', 2.70, 100, 'Disponible', 'uploads/black_iced_tea.jpg', 5, NULL, NULL, NULL, 'Boisson'),
(9, 'Café Misto', 'Mélange de café filtre et de lait chaud.', 3.00, 100, 'Disponible', 'uploads/cafe_misto.jpg', 1, NULL, NULL, NULL, 'Boisson'),
(10, 'English Breakfast Latte', 'Thé noir corsé avec du lait chaud et de la mousse.', 3.80, 100, 'Disponible', 'uploads/english_breakfast_latte.jpg', 1, NULL, NULL, NULL, 'Boisson'),
(11, 'Macchiato Crème', 'Boisson froide à la crème et caramel.', 4.80, 100, 'Populaire', 'uploads/macchiatocreme.jpg', 2, NULL, NULL, NULL, 'Boisson'),
(12, 'Matcha Latte Glacé', 'Boisson fraîche au matcha, légère et énergisante.', 4.20, 100, 'Disponible', 'uploads/matcha.jpg', 3, NULL, NULL, NULL, 'Boisson'),
(13, 'Matcha Latte Spécial', 'Double dose de matcha pour les amateurs.', 4.80, 100, 'Nouveautés', 'uploads/matcha_special.jpg', 3, NULL, NULL, NULL, 'Boisson'),
(14, 'Thé au Lait', 'Mélange doux de thé et de lait chaud.', 3.30, 100, 'Disponible', 'uploads/thélait.jpg', 4, NULL, NULL, NULL, 'Boisson'),
(15, 'Youthberry Tea', 'Infusion fruitée à la baie et fleurs.', 3.50, 100, 'Populaire', 'uploads/youthberry_tea.jpg', 4, NULL, NULL, NULL, 'Boisson'),
(16, 'Yuzu Citrus Tea', 'Thé aux agrumes japonais et yuzu rafraîchissant.', 3.60, 100, 'Disponible', 'uploads/yuzu_citrus_tea.jpg', 4, NULL, NULL, NULL, 'Boisson'),
(17, 'Camomille Tea', 'Infusion relaxante à base de camomille.', 2.90, 100, 'Disponible', 'uploads/chamomile_tea.jpg', 4, NULL, NULL, NULL, 'Boisson'),
(18, 'Coffee at Home', 'Café filtre maison pour une dégustation simple.', 2.00, 100, 'Disponible', 'uploads/coffee_home.jpg', 5, NULL, NULL, NULL, 'Boisson'),
(19, 'Thé English Breakfast', 'Thé noir robuste, idéal pour bien commencer la journée.', 2.80, 100, 'Disponible', 'uploads/english_breakfast_tea.jpg', 4, NULL, NULL, NULL, 'Boisson'),
(20, 'Matcha Tea Latte', 'Boisson chaude au matcha doux et onctueux.', 3.90, 100, 'Disponible', 'uploads/matcha_tea_latte.jpg', 3, NULL, NULL, NULL, 'Boisson'),
(21, 'Zencloud Oolong Tea', 'Oolong léger aux notes florales pour une expérience zen.', 3.50, 100, 'Nouveautés', 'uploads/zencloud_oolong.jpg', 4, NULL, NULL, NULL, 'Boisson'),
(22, 'Le Petit Prince', 'Un récit poétique qui aborde les thèmes de l\'amitié, de l\'amour et du sens de la vie.', 12.90, 5, 'Disponible', 'uploads/petit_prince.jpg', 6, NULL, 'Antoine de Saint-Exupéry', 1943, 'Livre'),
(23, '1984', 'Une dystopie qui présente une critique de la dictature et des régimes totalitaires.', 11.50, 3, 'Disponible', 'uploads/1984.jpg', 7, NULL, 'George Orwell', 1949, 'Livre'),
(24, 'L\'Étranger', 'Roman existentialiste qui explore l\'absurdité de la vie humaine.', 9.90, 2, 'Disponible', 'uploads/etranger.jpg', 6, NULL, 'Albert Camus', 1942, 'Livre'),
(25, 'Dune', 'Œuvre majeure de la science-fiction, mêlant aventure, politique et mystique.', 14.50, 4, 'Disponible', 'uploads/dune.jpg', 7, NULL, 'Frank Herbert', 1965, 'Livre'),
(26, 'Steve Jobs', 'Biographie officielle du fondateur d\'Apple, détaillant sa vie personnelle et professionnelle.', 16.90, 2, 'Disponible', 'uploads/steve_jobs.jpg', 8, NULL, 'Walter Isaacson', 2011, 'Livre'),
(27, 'Persepolis', 'Une autobiographie en bande dessinée sur l\'Iran pendant la révolution islamique.', 19.99, 3, 'Disponible', 'uploads/persepolis.jpg', 11, NULL, 'Marjane Satrapi', 2000, 'Livre');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commande_item`
--
ALTER TABLE `commande_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
