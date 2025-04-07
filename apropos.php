<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - Library Cafe</title>
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
        
        /* Hero section */
        .hero {
            position: relative;
            height: 400px;
            background-image: url('img/library-cafe-bg.jpg');
            background-size: cover;
            background-position: center;
            background-color: #2D402D; /* Fallback if image doesn't load */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 60px;
            color: white;
            text-align: center;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(45, 64, 45, 0.7);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            padding: 0 20px;
        }
        
        .hero h1 {
            font-family: 'Instrument Serif', serif;
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        
        /* About section */
        .about-section {
            margin-bottom: 60px;
        }
        
        .section-title {
            font-family: 'Instrument Serif', serif;
            font-size: 36px;
            color: #195908;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .section-content {
            display: flex;
            gap: 40px;
            align-items: center;
        }
        
        .section-text {
            flex: 1;
        }
        
        .section-image {
            flex: 1;
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .section-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .section-paragraph {
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .highlight-box {
            background-color: #B2D99A;
            padding: 30px;
            border-radius: 10px;
            margin: 40px 0;
        }
        
        .quote {
            font-family: 'Instrument Serif', serif;
            font-size: 24px;
            font-style: italic;
            text-align: center;
            color: #195908;
            margin-bottom: 15px;
        }
        
        .quote-author {
            text-align: right;
            font-weight: 500;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        
        .feature-card {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .feature-icon {
            font-size: 48px;
            margin-bottom: 15px;
            color: #FFCE70;
        }
        
        .feature-title {
            font-weight: 600;
            font-size: 20px;
            margin-bottom: 10px;
            color: #195908;
        }
        
        .feature-description {
            color: #555;
        }
        
        .team {
            margin-top: 60px;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .team-member {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .member-image {
            height: 250px;
            overflow: hidden;
        }
        
        .member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .member-info {
            padding: 20px;
        }
        
        .member-name {
            font-weight: 600;
            font-size: 20px;
            margin-bottom: 5px;
            color: #195908;
        }
        
        .member-role {
            color: #777;
            font-style: italic;
            margin-bottom: 10px;
        }
        
        .member-bio {
            color: #555;
            font-size: 14px;
        }
        
        /* CTA section */
        .cta-section {
            background-color: #FFCE70;
            padding: 50px 0;
            text-align: center;
            margin: 60px 0;
        }
        
        .cta-title {
            font-family: 'Instrument Serif', serif;
            font-size: 36px;
            color: #2D402D;
            margin-bottom: 20px;
        }
        
        .cta-text {
            font-size: 18px;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta-button {
            display: inline-block;
            background-color: #2D402D;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .cta-button:hover {
            background-color: #1a2a1a;
        }
        
        /* Footer */
        footer {
            background-color: #2D402D;
            color: #B2D99A;
            padding: 40px 0;
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
            
            .section-content {
                flex-direction: column;
            }
            
            .section-text, .section-image {
                width: 100%;
            }
            
            .section-image {
                height: 300px;
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
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>Notre Histoire</h1>
                <p>Où les pages et les arômes se rencontrent dans une symphonie de sens.</p>
            </div>
        </section>
        
        <div class="container">
            <!-- About Section -->
            <section class="about-section">
                <h2 class="section-title">Bienvenue chez Library Cafe</h2>
                
                <div class="section-content">
                    <div class="section-text">
                        <p class="section-paragraph">
                            Né de la passion pour la littérature et l'art du café, Library Cafe est un espace unique où les amateurs de lecture et les gourmets se retrouvent dans une ambiance chaleureuse et inspirante.
                        </p>
                        <p class="section-paragraph">
                            Fondé en 2024, notre établissement combine une bibliothèque soigneusement curatée et un café de spécialité, offrant un refuge parfait pour se détendre, travailler ou simplement savourer un moment de qualité.
                        </p>
                        <p class="section-paragraph">
                            Chaque livre dans nos étagères et chaque grain de café dans nos tasses ont été sélectionnés avec soin, reflétant notre engagement envers l'excellence et l'authenticité.
                        </p>
                    </div>
                    
                    <div class="section-image">
                        <img src="img/cafe-interior.jpg" alt="Intérieur du Library Cafe" onerror="this.src='uploads/cafe_misto.jpg'">
                    </div>
                </div>
                
                <div class="highlight-box">
                    <div class="quote">
                        "Un bon livre, comme un bon café, doit être dégusté lentement, laissant à chaque page, à chaque gorgée, le temps de révéler sa profondeur."
                    </div>
                    <div class="quote-author">- Fondateurs du Library Cafe</div>
                </div>
            </section>
            
            <!-- Features Section -->
            <section>
                <h2 class="section-title">Ce qui nous rend uniques</h2>
                
                <div class="features">
                    <div class="feature-card">
                        <div class="feature-icon">📚</div>
                        <h3 class="feature-title">Bibliothèque Curatée</h3>
                        <p class="feature-description">Des centaines de livres soigneusement sélectionnés, des classiques aux œuvres contemporaines, dans une multitude de genres.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">☕</div>
                        <h3 class="feature-title">Café de Spécialité</h3>
                        <p class="feature-description">Des cafés de spécialité provenant des meilleurs producteurs, préparés avec expertise par nos baristas passionnés.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🍰</div>
                        <h3 class="feature-title">Pâtisseries Artisanales</h3>
                        <p class="feature-description">Nos pâtisseries et viennoiseries sont préparées sur place chaque jour, utilisant des ingrédients locaux et de saison.</p>
                    </div>
                </div>
                
                <div class="section-content" style="margin-top: 60px;">
                    <div class="section-image">
                        <img src="img/book-collection.jpg" alt="Notre collection de livres" onerror="this.src='uploads/petit_prince.jpg'">
                    </div>
                    
                    <div class="section-text">
                        <h3 style="color: #195908; margin-bottom: 20px; font-family: 'Instrument Serif', serif; font-size: 24px;">Notre philosophie</h3>
                        <p class="section-paragraph">
                            Au Library Cafe, nous croyons au pouvoir transformateur des mots et des saveurs. Notre espace a été conçu pour encourager la découverte, stimuler la réflexion et nourrir l'imagination.
                        </p>
                        <p class="section-paragraph">
                            Nous nous engageons à créer un environnement inclusif où chacun peut se sentir chez soi, qu'il soit plongé dans les pages d'un roman captivant, en train de discuter d'idées avec des amis, ou simplement en train d'apprécier un moment de solitude contemplative.
                        </p>
                        <p class="section-paragraph">
                            Notre mission est de raviver l'amour de la lecture à l'ère numérique et de célébrer l'art de prendre son temps, une page et une tasse à la fois.
                        </p>
                    </div>
                </div>
            </section>
            
           
            
        </div>
        
     
        <section class="cta-section">
            <div class="container">
                <h2 class="cta-title">Venez écrire votre histoire</h2>
                <p class="cta-text">Que vous cherchiez un espace de travail inspirant, un endroit pour vous détendre avec un bon livre, ou simplement un café exceptionnel, nous vous attendons au Library Cafe.</p>
                <a href="menu.php" class="cta-button">Découvrir notre menu</a>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <h3>SIGN UP FOR OUR NEWSLETTER</h3>
                <p>Need some help? Get in touch</p>
           
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