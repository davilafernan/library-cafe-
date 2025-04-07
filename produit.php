<?php
require_once 'bdd.php';
session_start();

// Vérifier qu'un ID de produit est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: menu.php');
    exit();
}

$id = intval($_GET['id']);

// Récupérer les informations du produit
$stmt = $pdo->prepare("SELECT p.*, c.nom AS categorie_nom 
                       FROM produits p 
                       LEFT JOIN categories c ON p.categorie_id = c.id 
                       WHERE p.id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch();

// Si le produit n'existe pas, rediriger vers la liste des produits
if (!$produit) {
    header('Location: menu.php');
    exit();
}

// Récupérer les produits similaires (même catégorie)
$produits_similaires = [];
if ($produit['categorie_id']) {
    $stmt = $pdo->prepare("SELECT * FROM produits 
                           WHERE categorie_id = ? AND id != ? 
                           LIMIT 4");
    $stmt->execute([$produit['categorie_id'], $id]);
    $produits_similaires = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produit['nom']) ?> - Library Cafe</title>
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
        
        /* Product Detail */
        .product-detail {
            display: flex;
            gap: 40px;
            margin-bottom: 60px;
        }
        
        .product-image {
            flex: 1;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            height: 400px;
            background-color: white;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-info {
            flex: 1;
        }
        
        .product-category {
            display: inline-block;
            background-color: #B2D99A;
            color: #2D402D;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .product-title {
            font-family: 'Instrument Serif', serif;
            font-size: 32px;
            color: #195908;
            margin-bottom: 15px;
        }
        
        .product-price {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .product-description {
            margin-bottom: 30px;
            color: #555;
        }
        
        .product-stock {
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
        
        .product-actions {
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
        
        /* Similar Products */
        .similar-products {
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
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .product-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .card-image {
            height: 180px;
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
            
            .product-detail {
                flex-direction: column;
            }
            
            .product-image, .product-info {
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
                <a href="menu.php">Menu</a> &gt; 
                <?php if ($produit['categorie_id']): ?>
                    <a href="menu.php?cat=<?= $produit['categorie_id'] ?>"><?= htmlspecialchars($produit['categorie_nom']) ?></a> &gt; 
                <?php endif; ?>
                <span><?= htmlspecialchars($produit['nom']) ?></span>
            </div>
            
            <!-- Product Detail -->
            <section class="product-detail">
                <div class="product-image">
                    <?php if (!empty($produit['image']) && file_exists($produit['image'])): ?>
                        <img src="<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
                    <?php else: ?>
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background-color:#f0f0f0;">
                            <span>Image non disponible</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="product-info">
                    <?php if ($produit['categorie_id']): ?>
                        <div class="product-category"><?= htmlspecialchars($produit['categorie_nom']) ?></div>
                    <?php endif; ?>
                    
                    <h1 class="product-title"><?= htmlspecialchars($produit['nom']) ?></h1>
                    <div class="product-price"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</div>
                    
                    <?php if (isset($produit['description']) && !empty($produit['description'])): ?>
                        <div class="product-description"><?= nl2br(htmlspecialchars($produit['description'])) ?></div>
                    <?php else: ?>
                        <div class="product-description">Aucune description disponible pour ce produit.</div>
                    <?php endif; ?>
                    
                    <div class="product-stock">
                        <?php if ($produit['stock'] > 10): ?>
                            <div class="stock-indicator in-stock"></div>
                            <span>En stock (<?= $produit['stock'] ?> disponibles)</span>
                        <?php elseif ($produit['stock'] > 0): ?>
                            <div class="stock-indicator low-stock"></div>
                            <span>Stock limité (<?= $produit['stock'] ?> restants)</span>
                        <?php else: ?>
                            <div class="stock-indicator out-of-stock"></div>
                            <span>Rupture de stock</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-actions">
                        <form method="post" action="add_to_cart.php">
                            <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                            
                            <div class="quantity-selector">
                                <label for="quantity">Quantité:</label>
                                <input type="number" id="quantity" name="quantité" value="1" min="1" max="<?= $produit['stock'] ?>" class="quantity-input">
                            </div>
                            
                            <button type="submit" class="add-to-cart-btn" <?= $produit['stock'] <= 0 ? 'disabled' : '' ?>>
                                Ajouter au panier
                            </button>
                        </form>
                    </div>
                </div>
            </section>
            
            <!-- Similar Products -->
            <?php if (!empty($produits_similaires)): ?>
                <section class="similar-products">
                    <h2 class="section-title">Vous pourriez aussi aimer</h2>
                    
                    <div class="products-grid">
                        <?php foreach ($produits_similaires as $produit): ?>
                            <div class="product-card">
                                <div class="card-image">
                                    <?php if (!empty($produit['image']) && file_exists($produit['image'])): ?>
                                        <img src="<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
                                    <?php else: ?>
                                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background-color:#f0f0f0;">
                                            <span>Pas d'image</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h3>
                                    <div class="card-price"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</div>
                                    <a href="produit.php?id=<?= $produit['id'] ?>" class="card-button">Voir détails</a>
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