<?php
session_start();
require_once 'bdd.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Correction: nous utilisons 'nom' dans session, pas 'user_nom'
$userName = $_SESSION['nom'];
$userId = $_SESSION['user_id'];

// Récupération des commandes
$stmt = $pdo->prepare("SELECT * FROM commandes WHERE utilisateur_id = ? ORDER BY date_commande DESC");
$stmt->execute([$userId]);
$commandes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Library Cafe</title>
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
        
        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        h2 {
            font-family: 'Instrument Serif', serif;
            font-size: 42px;
            color: #195908;
            margin-bottom: 10px;
        }
        
        .profile-actions {
            margin-top: 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FFCE70;
            color: #2D402D;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            margin: 0 10px;
        }
        
        .btn-secondary {
            background-color: #B2D99A;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        .section-title {
            font-family: 'Instrument Serif', serif;
            font-size: 28px;
            color: #195908;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #B2D99A;
        }
        
        .orders-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .order-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
        }
        
        .order-id {
            font-weight: 600;
            font-size: 18px;
        }
        
        .order-date {
            color: #666;
        }
        
        .order-total {
            font-weight: 500;
            color: #195908;
        }
        
        .order-items {
            list-style: none;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f5f5f5;
        }
        
        .item-name {
            flex-grow: 1;
        }
        
        .item-quantity {
            margin: 0 15px;
            color: #666;
        }
        
        .item-price {
            font-weight: 500;
            width: 80px;
            text-align: right;
        }
        
        .no-orders {
            text-align: center;
            padding: 40px 0;
            color: #666;
        }
        
        /* Footer style */
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
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
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
            <div class="profile-header">
                <h2>Bienvenue, <?= htmlspecialchars($userName) ?></h2>
                <div class="profile-actions">
                    <a href="Accueil.php" class="btn">Continuer les achats</a>
                    <a href="logout.php" class="btn btn-secondary">Se déconnecter</a>
                </div>
            </div>
            
            <h3 class="section-title">Historique des commandes</h3>
            
            <div class="orders-container">
                <?php if ($commandes): ?>
                    <?php foreach ($commandes as $commande): ?>
                        <div class="order-card">
                            <div class="order-header">
                                <div class="order-id">Commande #<?= $commande['id'] ?></div>
                                <div class="order-date"><?= date('d/m/Y à H:i', strtotime($commande['date_commande'])) ?></div>
                                <div class="order-total"><?= number_format($commande['total'], 2, ',', ' ') ?> €</div>
                            </div>
                            
                            <?php
                            // Récupérer les détails de la commande
                            $stmtItems = $pdo->prepare("
                                SELECT p.nom, ci.quantite, ci.prix
                                FROM commande_item ci
                                JOIN produits p ON ci.produit_id = p.id
                                WHERE ci.commande_id = ?
                            ");
                            $stmtItems->execute([$commande['id']]);
                            $items = $stmtItems->fetchAll();
                            ?>
                            
                            <ul class="order-items">
                                <?php foreach ($items as $item): ?>
                                    <li class="order-item">
                                        <span class="item-name"><?= htmlspecialchars($item['nom']) ?></span>
                                        <span class="item-quantity">x<?= $item['quantite'] ?></span>
                                        <span class="item-price"><?= number_format($item['prix'], 2, ',', ' ') ?> €</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-orders">
                        <p>Vous n'avez pas encore passé de commande.</p>
                    </div>
                <?php endif; ?>
            </div>
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