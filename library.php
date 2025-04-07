<?php
require_once 'bdd.php';
session_start();

// Récupérer les catégories de type Livre
$categories = $pdo->query("SELECT * FROM categories WHERE type = 'Livre' ORDER BY nom")->fetchAll();
$catID = isset($_GET['cat']) ? intval($_GET['cat']) : null;

// Récupérer les livres selon la catégorie sélectionnée
if ($catID) {
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE categorie_id = ? AND type = 'Livre'");
    $stmt->execute([$catID]);
} else {
    $stmt = $pdo->query("SELECT * FROM produits WHERE type = 'Livre'");
}
$livres = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque - Library Cafe</title>
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Serif:wght@400&display=swap">
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FEFAEF;
            color: #2D402D;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        header {
            background-color: #FEFAEF;
            border-bottom: 1px solid #195908;
            padding: 15px 0;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .logo {
            font-family: 'Inter', sans-serif;
            font-size: 36px;
            font-weight: 600;
            color: #40573D;
            text-decoration: none;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav li {
            margin: 0 15px;
        }
        
        nav a {
            color: #2D402D;
            text-decoration: none;
            font-weight: 500;
            font-size: 20px;
        }
        
        /* Main content */
        main {
            padding: 40px 0;
        }
        
        h2 {
            font-family: 'Instrument Serif', serif;
            font-size: 42px;
            color: #195908;
            text-align: center;
            margin-bottom: 30px;
        }
        
        /* Filter Section */
        .filter-section {
            background-color: #B2D99A;
            padding: 15px 0;
            margin-bottom: 30px;
            border-top: 1px solid #195908;
            border-bottom: 1px solid #195908;
        }
        
        .filter-form {
            text-align: center;
        }
        
        .filter-label {
            font-weight: 500;
            margin-right: 10px;
        }
        
        .filter-select {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #FEFAEF;
            margin-right: 10px;
        }
        
        /* Books Grid */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .book-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
        }
        
        .book-image {
            height: 300px;
            overflow: hidden;
        }
        
        .book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .book-details {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .book-name {
            font-weight: 600;
            font-size: 18px;
            color: #195908;
            margin-bottom: 8px;
        }
        
        .book-author {
            font-style: italic;
            color: #666;
            margin-bottom: 8px;
        }
        
        .book-year {
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }
        
        .book-price {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .book-stock {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
        
        .book-actions {
            margin-top: auto;
            display: flex;
            gap: 10px;
        }
        
        .view-btn, .add-btn {
            display: inline-block;
            padding: 8px 0;
            text-align: center;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            flex: 1;
        }
        
        .view-btn {
            background-color: #B2D99A;
            color: #2D402D;
        }
        
        .add-btn {
            background-color: #FFCE70;
            color: #2D402D;
            border: none;
            cursor: pointer;
        }
        
        .view-btn:hover, .add-btn:hover {
            opacity: 0.9;
        }
        
        .no-books {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        /* Featured Section */
        .featured-section {
            background-color: #FFCE70;
            padding: 50px 0;
            margin: 60px 0;
        }
        
        .featured-container {
            display: flex;
            align-items: center;
            gap: 40px;
        }
        
        .featured-image {
            flex: 1;
            border-radius: 8px;
            overflow: hidden;
            height: 300px;
        }
        
        .featured-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .featured-content {
            flex: 1;
        }
        
        .featured-title {
            font-family: 'Instrument Serif', serif;
            font-size: 32px;
            color: #2D402D;
            margin-bottom: 20px;
        }
        
        .featured-text {
            margin-bottom: 25px;
        }
        
        .featured-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2D402D;
            color: #FEFAEF;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
        }
        
        /* Footer */
        footer {
            background-color: #2D402D;
            color: #B2D99A;
            padding: 40px 0;
            margin-top: 60px;
        }
        
        .footer-container {
            display: flex;
            justify-content: space-between;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .footer-links h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #B2D99A;
            text-decoration: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .books-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .featured-container {
                flex-direction: column;
            }
            
            .featured-image, .featured-content {
                width: 100%;
            }
            
            .footer-container {
                flex-direction: column;
                gap: 30px;
            }
        }
        
        @media (max-width: 480px) {
            .books-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <nav class="left-nav">
                <ul>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="librairie.php">Library</a></li>
                </ul>
            </nav>
            
            <a href="Accueil.php" class="logo">Library Cafe</a>
            
            <nav class="right-nav">
                <ul>
                    <li><a href="profil.php">Compte</a></li>
                    <li><a href="panier.php">Panier (<?= isset($_SESSION['panier']) ? count($_SESSION['panier']) : 0 ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Notre Bibliothèque</h2>
            
            <!-- Filter Section -->
            <section class="filter-section">
                <div class="container">
                    <form class="filter-form" method="get">
                        <label for="cat" class="filter-label">Genre:</label>
                        <select name="cat" id="cat" class="filter-select" onchange="this.form.submit()">
                            <option value="">-- Tous les genres --</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= $catID == $c['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
            </section>
            
            <!-- Books Grid -->
            <section class="books-grid">
                <?php if (count($livres) > 0): ?>
                    <?php foreach ($livres as $livre): ?>
                        <div class="book-card">
                            <div class="book-image">
                                <?php if (!empty($livre['image']) && file_exists($livre['image'])): ?>
                                    <img src="<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['nom']) ?>">
                                <?php else: ?>
                                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background-color:#f0f0f0;">
                                        <span>Pas d'image</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="book-details">
                                <h3 class="book-name"><?= htmlspecialchars($livre['nom']) ?></h3>
                                <?php if (!empty($livre['auteur'])): ?>
                                    <p class="book-author">par <?= htmlspecialchars($livre['auteur']) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($livre['annee'])): ?>
                                    <p class="book-year"><?= $livre['annee'] ?></p>
                                <?php endif; ?>
                                <p class="book-price"><?= number_format($livre['prix'], 2, ',', ' ') ?> €</p>
                                <p class="book-stock">En stock: <?= $livre['stock'] ?></p>
                                <div class="book-actions">
                                    <a href="livre.php?id=<?= $livre['id'] ?>" class="view-btn">Détails</a>
                                    <form method="post" action="add_to_cart.php" style="flex: 1;">
                                        <input type="hidden" name="produit_id" value="<?= $livre['id'] ?>">
                                        <input type="hidden" name="quantité" value="1">
                                        <button type="submit" class="add-btn" <?= $livre['stock'] <= 0 ? 'disabled' : '' ?>>
                                            Ajouter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-books">
                        <p>Aucun livre ne correspond à vos critères de recherche.</p>
                        <p><a href="librairie.php" style="color: #195908; text-decoration: underline;">Voir tous les livres</a></p>
                    </div>
                <?php endif; ?>
            </section>
            
            <!-- Featured Book Section -->
            <section class="featured-section">
                <div class="container">
                    <div class="featured-container">
                        <div class="featured-image">
                            <img src="uploads/petit_prince.png" alt="Livre du mois" onerror="this.src='uploads/petit_prince.jpg'">
                        </div>
                        <div class="featured-content">
                            <h2 class="featured-title">Le livre du mois</h2>
                            <p class="featured-text">Découvrez notre livre du mois: "Le Petit Prince" d'Antoine de Saint-Exupéry. Un récit poétique intemporel sur l'amitié, l'amour et les mystères de la vie. Parfait pour accompagner un bon café!</p>
                            <a href="livre.php?id=22" class="featured-button">Découvrir</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <h3>SIGN UP FOR OUR NEWSLETTER</h3>
                <p>Need some help? Get in touch</p>
                <!-- Newsletter form would go here -->
            </div>
            
            <div class="footer-links">
                <ul>
                    <li><a href="#">Our Science</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Account</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>