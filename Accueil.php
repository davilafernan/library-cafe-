<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Cafe</title>
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Serif:wght@400&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;700;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Liberation+Mono:wght@400&display=swap">
    
    <style>
        /* Réinitialisation CSS */
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
        
        /* Header */
        header {
            background-color: #FEFAEF;
            border-bottom: 1px solid #195908;
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
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
            transition: color 0.3s;
        }
        
        nav a:hover {
            color: #195908;
        }
        
        /* Hero Section */
        .hero {
            position: relative;
            height: 500px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 50px;
        }
        
        .hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }
        
        .hero-text {
            position: relative;
            z-index: 2;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 64px;
            font-weight: 800;
            color: white;
            text-align: center;
        }
        
        /* Badge Section */
        .badge-section {
            background-color: #B2D99A;
            border-top: 1px solid #195908;
            border-bottom: 1px solid #195908;
            padding: 15px 0;
            margin: 30px 0;
        }
        
        .badge-container {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        
        .badge {
            display: flex;
            align-items: center;
            font-size: 16px;
            font-weight: 500;
            margin: 0 10px;
        }
        
        .badge img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        
        /* Categories Section */
        .categories {
            max-width: 1100px;
            margin: 50px auto;
            padding: 0 20px;
        }
        
        .category-title {
            font-family: 'Instrument Serif', serif;
            font-size: 24px;
            color: #195908;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .category-list {
            border-top: 1px solid #195908;
        }
        
        .category-item {
            padding: 30px 0;
            border-bottom: 1px solid #195908;
            font-family: 'Instrument Serif', serif;
            font-size: 42px;
            text-align: center;
            position: relative;
        }
        
        .category-item a {
            color: #2D402D;
            text-decoration: none;
            display: block;
        }
        
        .category-item img {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
        }
        
        /* Products Section */
        .products-section {
            padding: 70px 0;
            background-color: #FFCE70;
        }
        
        .products-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
        }
        
        .product-image {
            width: 50%;
        }
        
        .product-info {
            width: 50%;
            padding-left: 50px;
        }
        
        .product-title {
            font-family: 'Instrument Serif', serif;
            font-size: 42px;
            margin-bottom: 20px;
            color: #2D402D;
        }
        
        .product-description {
            font-size: 18px;
            margin-bottom: 30px;
        }
        
        .menu-link {
            font-size: 24px;
            font-weight: 500;
            color: #2D402D;
            text-decoration: underline;
            display: inline-flex;
            align-items: center;
        }
        
        .menu-link img {
            width: 20px;
            margin-left: 10px;
        }
        
        /* Flavors Section */
        .flavors {
            max-width: 1280px;
            margin: 70px auto;
            padding: 0 20px;
        }
        
        .flavors-title {
            font-family: 'Instrument Serif', serif;
            font-size: 42px;
            text-align: center;
            margin-bottom: 40px;
            color: #2D402D;
        }
        
        .flavor-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }
        
        .flavor-card {
            text-align: center;
            background-color: #F9F5EA;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .flavor-image {
            width: 100%;
            height: 200px;
            background-color: #E5E5E5;
        }
        
        .flavor-name {
            padding: 15px 0;
            font-weight: 500;
            font-size: 20px;
            color: #2D402D;
            text-decoration: underline;
        }
        
        /* Benefits Section */
        .benefits {
            background-color: #B2D99A;
            padding: 70px 0;
        }
        
        .benefits-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .benefits-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 48px;
            font-weight: 700;
            color: #195908;
            text-align: center;
            margin-bottom: 50px;
        }
        
        .benefits-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .benefit-item {
            background-color: #91C085;
            border-radius: 24px;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: 500;
        }
        
        .benefit-item img {
            width: 30px;
            height: 30px;
            margin-right: 15px;
        }
        
        /* bouquins Section */
        .bouquins {
            max-width: 1280px;
            margin: 70px auto;
            padding: 0 20px;
        }
        
        .bouquins-title {
            font-family: 'Liberation Mono', monospace;
            font-size: 42px;
            margin-bottom: 30px;
        }
        
        .bouquins-container {
            position: relative;
        }
        
        .bouquins-navigation {
            position: absolute;
            top: 0;
            right: 0;
            display: flex;
        }
        
        .bouquins-navigation button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
        }
        
        /* CTA Section */
        .cta-section {
            max-width: 1280px;
            margin: 70px auto;
            padding: 0 20px;
            display: flex;
            gap: 50px;
        }
        
        .cta-text {
            font-family: 'Liberation Mono', monospace;
            font-size: 36px;
            flex: 1;
        }
        
        .cta-actions {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .button {
            background-color: #FFCE70;
            border: none;
            border-radius: 50px;
            color: #2D402D;
            font-weight: 500;
            padding: 15px 30px;
            font-size: 16px;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            margin-top: 20px;
        }
        
        /* Footer */
        footer {
            background-color: #2D402D;
            color: #B2D99A;
            padding: 70px 0;
        }
        
        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
        }
        
        .footer-left {
            flex: 2;
            padding-right: 50px;
        }
        
        .footer-right {
            flex: 1;
        }
        
        .newsletter {
            margin-bottom: 50px;
        }
        
        .newsletter-title {
            font-size: 20px;
            text-transform: uppercase;
            font-weight: 500;
            margin-bottom: 15px;
        }
        
        .newsletter-text {
            margin-bottom: 20px;
        }
        
        .newsletter-form {
            display: flex;
            margin-top: 15px;
        }
        
        .newsletter-input {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 16px 0 0 16px;
            background-color: #F0E7CE;
        }
        
        .newsletter-button {
            width: 50px;
            background-color: #F0E7CE;
            border: none;
            border-radius: 0 16px 16px 0;
            cursor: pointer;
        }
        
        .footer-links {
            display: flex;
            justify-content: space-between;
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 15px;
        }
        
        .footer-links a {
            color: #B2D99A;
            text-decoration: underline;
            font-size: 20px;
            font-weight: 500;
        }
        
        .footer-logo {
            margin-top: 50px;
            width: 100%;
            max-width: 300px;
        }
        
        .social-links {
            margin-top: 20px;
        }
        
        .social-links a {
            margin-right: 15px;
            display: inline-block;
        }
        
        .social-links img {
            width: 30px;
            height: 30px;
        }

        /* Responsive fixes */
        @media (max-width: 768px) {
            .header-container, 
            .products-container,
            .footer-container,
            .cta-section {
                flex-direction: column;
            }
            
            .flavor-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .product-image,
            .product-info,
            .footer-left,
            .footer-right {
                width: 100%;
                padding: 0;
                margin-bottom: 30px;
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
            
            <a href="index.php" class="logo">Library Cafe</a>
            
            <nav class="right-nav">
                <ul>
                    <li><a href="profil.php">Compte</a></li>
                    <li><a href="panier.php">Panier (<?= isset($_SESSION['panier']) ? count($_SESSION['panier']) : 0 ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <img src="uploads/matcha_mousse.jpeg" alt="Matcha Mousse">
        <div class="hero-text">Bonjour</div>
    </section>

    <!-- Badge Section -->
    <section class="badge-section">
        <div class="badge-container">
            <div class="badge">
                <img src="uploads/Container.png" alt="Check">
                <span>Frais</span>
            </div>
            <div class="badge">
                <img src="uploads/Container.png" alt="Check">
                <span>Sans Gluten</span>
            </div>
            <div class="badge">
                <img src="uploads/Container.png" alt="Check">
                <span>Sans Pesticides</span>
            </div>
            <div class="badge">
                <img src="uploads/Container.png" alt="Check">
                <span>Sans Sucres Ajoutés</span>
            </div>
            <div class="badge">
                <img src="uploads/Container.png" alt="Check">
                <span>Option Halal</span>
            </div>
            <div class="badge">
                <img src="uploads/Container.png" alt="Check">
                <span>Option Vegan</span>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories">
        <h2 class="category-title">Pas mal, hein!</h2>
        <div class="category-list">
            <div class="category-item">
                <a href="menu.php">Nos Délicieuses Boissons</a>
                <img src="uploads/Margin.png" alt="Arrow Right">
            </div>
            <div class="category-item">
                <a href="snacks.php">Nos Bons Petits Plats</a>
                <img src="uploads/Margin.png" alt="Arrow Right">
            </div>
            <div class="category-item">
                <a href="library.php">Nos Superbes Livres</a>
                <img src="uploads/Margin.png" alt="Arrow Right">
            </div>
        </div>
        <div style="text-align: center; margin-top: 30px;">
            <a href="produit.php" class="button">Get Started</a>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="products-container">
            <div class="product-image">
                
                <img src="uploads/image 3 (vectorized).png" alt="Nos Boissons et Snacks" style="width:100%; height:auto;">
            </div>
            <div class="product-info">
                <h2 class="product-title">Nos Boissons et Snacks Epicerie Style</h2>
                <p class="product-description">Trop la flemme de sortir? Pas de problèmes, on a Librarycafe à la maison</p>
                <a href="menu.php" class="menu-link">
                    Menu
                    <img src="uploads/Margin.png" alt="Arrow Right">
                </a>
            </div>
        </div>
    </section>

    <!-- Flavors Section -->
    <section class="flavors">
        <h2 class="flavors-title">Nouvelles Saveurs</h2>
        <div class="flavor-grid">
            <div class="flavor-card">
                <div class="flavor-image"><img src='uploads/macchiatocreme.jpg'></div>
                <a href="produit.php?id=1" class="flavor-name">Caramel Macchiato</a>
            </div>
            <div class="flavor-card">
                <div class="flavor-image"><img src='uploads/expresso.jpg'></div>
                <a href="produit.php?id=2" class="flavor-name">Espresso</a>
            </div>
            <div class="flavor-card">
                <div class="flavor-image"><img src='uploads/frappemangue.jpg'></div>
                <a href="produit.php?id=3" class="flavor-name">Frappé Mangue</a>
            </div>
            <div class="flavor-card">
                <div class="flavor-image"><img src='uploads/latte_classique.jpg'></div>
                <a href="produit.php?id=4" class="flavor-name">Latte Classique</a>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits">
        <div class="benefits-container">
            <h2 class="benefits-title">Juste le meilleur</h2>
            <div class="benefits-list">
                <div class="benefit-item">
				<img src="uploads/Container (1).png" alt="Wifi">
                    <span>Wifi Gratuite</span>
                </div>
                <div class="benefit-item">
				<img src="uploads/Container (1).png" alt="Local">
                    <span>Des Produits Frais et locaux</span>
                </div>
                <div class="benefit-item">
                    <img src="uploads/Container (1).png" alt="Halal">
                    <span>Halal & Vegan option</span>
                </div>
                <div class="benefit-item">
				<img src="uploads/Container (1).png"alt="Natural">
                    <span>100% Naturel</span>
                </div>
                <div class="benefit-item">
				<img src="uploads/Container (1).png" alt="Bio">
                    <span>Biologique</span>
                </div>
            </div>
        </div>
    </section>

    <!-- bouquins Section -->
    <section class="bouquins">
        <div class="bouquins-container">
            <h2 class="bouquins-title">Let's read</h2>
            <div class="bouquins-navigation">
                <button><img src="uploads/Button - Previous Slide_mask-group.png" alt="Previous"></button>
                <button><img src="uploads/Button - Next Slide_mask-group.png" alt="Next"></button>
            </div>
			<div class="bouquins-content">
				<img src="uploads/inferno.jpg" alt="Inferno" class="bouquin-image">
				<h3 class="bouquin-title">Inferno</h3>
				<p class="bouquin-description">Un roman captivant de Dante Alighieri, mêlant mystère et aventure.</p>
				<a href="library.php" class="bouquin-link">Découvrir</a>
				<img src="uploads/iliade.jpg" alt="Iliade" class="bouquin-image">
				<h3 class="bouquin-title">Iliade</h3>
				<p class="bouquin-description">Un chef-d'œuvre de la littérature grecque antique, racontant la guerre de Troie.</p>
				<a href="library.php" class="bouquin-link">Découvrir</a>
				<img src="uploads/odyssee.jpg" alt="Odyssee" class="bouquin-image">
				<h3 class="bouquin-title">Odyssee</h3>
				<p class="bouquin-description">Un voyage épique d'Ulysse, rempli d'aventures et de défis.</p>
				<a href="library.php" class="bouquin-link">Découvrir</a>

        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-text">
            <p>Avec un petit<br>cafe<br>pour mieux<br>lire<br>durant sa pose.</p>
        </div>
        <div class="cta-actions">
            <a href="library.php" class="button">Lisons</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <div class="newsletter">
                    <h3 class="newsletter-title">Inscrivez-vous à notre newsletter</h3>
                    <p class="newsletter-text">Besoin d'aide? On est là pour vous.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Email address" class="newsletter-input">
                        <button type="submit" class="newsletter-button">
                            <img src="uploads/Margin.png" alt="Submit">
                        </button>
                    </form>
                </div>
                
                <div class="footer-links">
                    <ul>
                        <li><a href="#">Our Science</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Account</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                    
                    <div class="social-links">
                        <a href="#"><img src="icons/instagram.svg" alt="Instagram"></a>
                        <a href="#"><img src="icons/twitter.svg" alt="Twitter"></a>
                    </div>
                </div>
                
                <img src="logo.svg" alt="Library Cafe" class="footer-logo">
            </div>
            
            <div class="footer-right">
                <!-- Image décorative ou carte du café -->
            </div>
        </div>
    </footer>

    <script>
    // Script pour vérifier les images manquantes
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.addEventListener('error', function() {
                console.error('Erreur de chargement pour l\'image:', img.src);
                this.style.border = '1px dashed red';
                this.style.padding = '5px';
                this.title = 'Image non trouvée: ' + img.src;
            });
        });
    });
    </script>
</body>
</html>