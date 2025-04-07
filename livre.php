<?php
require_once 'bdd.php';
session_start();

// Vérifier qu'un ID de livre est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: librairie.php');
    exit();
}

$id = intval($_GET['id']);

// Récupérer les informations du livre
$stmt = $pdo->prepare("SELECT p.*, c.nom AS categorie_nom 
                       FROM produits p 
                       LEFT JOIN categories c ON p.categorie_id = c.id 
                       WHERE p.id = ? AND p.type = 'Livre'");
$stmt->execute([$id]);
$livre = $stmt->fetch();

// Si le livre n'existe pas, rediriger vers la bibliothèque
if (!$livre) {
    header('Location: librairie.php');
    exit();
}

// Récupérer les livres similaires (même catégorie)
$livres_similaires = [];
if ($livre['categorie_id']) {
    $stmt = $pdo->prepare("SELECT * FROM produits 
                           WHERE categorie_id = ? AND id != ? AND type = 'Livre'
                           LIMIT 4");
    $stmt->execute([$livre['categorie_id'], $id]);
    $livres_similaires = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($livre['nom']) ?> - Library Cafe</title>
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
        
        .breadcrumb {
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .breadcrumb a {
            color: #2D402D;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        /* Book Detail */
        .book-detail {
            display: flex;
            gap: 40px;
            margin-bottom: 60px;
        }
        
        .book-image {
            flex: 1;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            height: 500px;
            background-color: white;
        }
        
        .book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .book-info {
            flex: 1;
        }
        
        .book-category {
            display: inline-block;
            background-color: #B2D99A;
            color: #2D402D;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .book-title {
            font-family: 'Instrument Serif', serif;
            font-size: 32px;
            color: #195908;
            margin-bottom: 15px;
        }
        
        .book-author {
            font-size: 18px;
            font-style: italic;
            color: #555;
            margin-bottom: 10px;
        }
        
        .book-year {
            font-size: 16px;
            color: #777;
            margin-bottom: 15px;
        }
        
        .book-price {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .book-description {
            margin-bottom: 30px;
            color: #555;
            line-height: 1.8;
        }
        
        .book-stock {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .stock-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .in-stock {
            background-color: #28a745;
        }
        
        .low-stock {
            background-color: #ffc107;
        }
        
        .out-of-stock {
            background-color: #dc3545;
        }
        
        .book-actions {
            margin-top: 30px;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .quantity-selector label {
            margin-right: 15px;
            font-weight: 500;
        }
        
        .quantity-input {
            width: 60px;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .add-to-cart-btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #FFCE70;
            color: #2D402D;
            border: none;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .add-to-cart-btn:hover {
            background-color: #ffc04d;
        }
        
        .add-to-cart-btn:disabled {
            background-color: #e0e0e0;
            color: #777;
            cursor: not-allowed;
        }
        
        .back-btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #B2D99A;
            color: #2D402D;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            margin-right: 15px;
        }
        
        .back-btn:hover {
            background-color: #a1c789;
        }
        
        /* Similar Books */
        .similar-books {
            margin-top: 60px;
        }
        
        .section-title {
            font-family: 'Instrument Serif', serif;
            font-size: 24px;
            color: #195908;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #B2D99A;
        }
        
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .book-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
        }
        
        .card-image {
            height: 250px;
            overflow: hidden;
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .card-content {
            padding: 15px;
        }
        
        .card-title {
            font-weight: 500;
            margin-bottom: 5px;
            color: #195908;
            font-size: 16px;
        }
        
        .card-author {
            font-style: italic;
            color: #666;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .card-price {
            color: #555;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .card-button {
            display: block;
            width: 100%;
            padding: 8px 0;
            background-color: #B2D99A;
            color: #2D402D;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .card-button:hover {
            background-color: #a1c789;
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
            
            .book-detail {
                flex-direction: column;
            }
            
            .book-image, .book-info {
                width: 100%;
            }
            
            .footer-container {
                flex-direction: column;
                gap: 30px;
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
                    <li><a href="library.php">Library</a></li>
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
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="Accueil.php">Accueil</a> &gt; 
                <a href="librairie.php">Bibliothèque</a> &gt; 
                <?php if ($livre['categorie_id']): ?>
                    <a href="librairie.php?cat=<?= $livre['categorie_id'] ?>"><?= htmlspecialchars($livre['categorie_nom']) ?></a> &gt; 
                <?php endif; ?>
                <span><?= htmlspecialchars($livre['nom']) ?></span>
            </div>
            
            <!-- Book Detail -->
            <section class="book-detail">
                <div class="book-image">
                    <?php if (!empty($livre['image']) && file_exists($livre['image'])): ?>
                        <img src="<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['nom']) ?>">
                    <?php else: ?>
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background-color:#f0f0f0;">
                            <span>Image non disponible</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="book-info">
                    <?php if ($livre['categorie_id']): ?>
                        <div class="book-category"><?= htmlspecialchars($livre['categorie_nom']) ?></div>
                    <?php endif; ?>
                    
                    <h1 class="book-title"><?= htmlspecialchars($livre['nom']) ?></h1>
                    
                    <?php if (!empty($livre['auteur'])): ?>
                        <div class="book-author">par <?= htmlspecialchars($livre['auteur']) ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($livre['annee'])): ?>
                        <div class="book-year">Publié en <?= $livre['annee'] ?></div>
                    <?php endif; ?>
                    
                    <div class="book-price"><?= number_format($livre['prix'], 2, ',', ' ') ?> €</div>
                    
                    <?php if (isset($livre['description']) && !empty($livre['description'])): ?>
                        <div class="book-description"><?= nl2br(htmlspecialchars($livre['description'])) ?></div>
                    <?php else: ?>
                        <div class="book-description">Aucune description disponible pour ce livre.</div>
                    <?php endif; ?>
                    
                    <div class="book-stock">
                        <?php if ($livre['stock'] > 10): ?>
                            <div class="stock-indicator in-stock"></div>
                            <span>Disponible (<?= $livre['stock'] ?> exemplaires)</span>
                        <?php elseif ($livre['stock'] > 0): ?>
                            <div class="stock-indicator low-stock"></div>
                            <span>Stock limité (<?= $livre['stock'] ?> exemplaires restants)</span>
                        <?php else: ?>
                            <div class="stock-indicator out-of-stock"></div>
                            <span>Actuellement indisponible</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="book-actions">
                        <form method="post" action="add_to_cart.php">
                            <input type="hidden" name="produit_id" value="<?= $livre['id'] ?>">
                            
                            <div class="quantity-selector">
                                <label for="quantity">Quantité:</label>
                                <input type="number" id="quantity" name="quantité" value="1" min="1" max="<?= $livre['stock'] ?>" class="quantity-input">
                            </div>
                            
                            <a href="librairie.php" class="back-btn">Retour à la bibliothèque</a>
                            
                            <button type="submit" class="add-to-cart-btn" <?= $livre['stock'] <= 0 ? 'disabled' : '' ?>>
                                Ajouter au panier
                            </button>
                        </form>
                    </div>
                </div>
            </section>
            
            <!-- Similar Books -->
            <?php if (!empty($livres_similaires)): ?>
                <section class="similar-books">
                    <h2 class="section-title">Vous pourriez aussi aimer</h2>
                    
                    <div class="books-grid">
                        <?php foreach ($livres_similaires as $similaire): ?>
                            <div class="book-card">
                                <div class="card-image">
                                    <?php if (!empty($similaire['image']) && file_exists($similaire['image'])): ?>
                                        <img src="<?= htmlspecialchars($similaire['image']) ?>" alt="<?= htmlspecialchars($similaire['nom']) ?>">
                                    <?php else: ?>
                                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background-color:#f0f0f0;">
                                            <span>Pas d'image</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title"><?= htmlspecialchars($similaire['nom']) ?></h3>
                                    <?php if (!empty($similaire['auteur'])): ?>
                                        <div class="card-author">par <?= htmlspecialchars($similaire['auteur']) ?></div>
                                    <?php endif; ?>
                                    <div class="card-price"><?= number_format($similaire['prix'], 2, ',', ' ') ?> €</div>
                                    <a href="livre.php?id=<?= $similaire['id'] ?>" class="card-button">Voir détails</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <h3>Inscrivez-vous à notre Newsletter!!!</h3>
                <p>Besoin d'aide? Contactez-nous.</p>
               
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