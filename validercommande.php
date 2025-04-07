<?php
require_once 'bdd.php';
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Veuillez vous connecter pour finaliser votre commande.";
    $_SESSION['message_type'] = "error";
    header("Location: login.php");
    exit();
}

// Vérifie si le panier n'est pas vide
if (empty($_SESSION['panier'])) {
    $_SESSION['message'] = "Votre panier est vide.";
    $_SESSION['message_type'] = "error";
    header("Location: panier.php");
    exit();
}

$userId = $_SESSION['user_id'];
$total = 0;
$items = []; // Pour stocker les détails des produits

// Calcul du total et récupération des produits
foreach ($_SESSION['panier'] as $id => $qT) {
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $prod = $stmt->fetch();
    
    if ($prod) {
        $sousTotal = $prod['prix'] * $qT;
        $total += $sousTotal;
        
        // Ajout des informations du produit pour l'affichage
        $items[] = [
            'id' => $prod['id'],
            'nom' => $prod['nom'],
            'prix' => $prod['prix'],
            'quantite' => $qT,
            'sous_total' => $sousTotal
        ];
    }
}

// Traiter la validation de la commande
$orderPlaced = false;
$orderId = null;
$errorMsg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['valider'])) {
    try {
        // Commencer la transaction
        $pdo->beginTransaction();

        // Insérer la commande
        $stmt = $pdo->prepare("INSERT INTO commandes (utilisateur_id, total) VALUES (?, ?)");
        $stmt->execute([$userId, $total]);
        $commandeId = $pdo->lastInsertId();
        $orderId = $commandeId;

        // Insérer les articles
        foreach ($_SESSION['panier'] as $id => $qT) {
            $stmt = $pdo->prepare("SELECT prix FROM produits WHERE id = ?");
            $stmt->execute([$id]);
            $prod = $stmt->fetch();

            $stmt = $pdo->prepare("INSERT INTO commande_item (commande_id, produit_id, quantite, prix) VALUES (?, ?, ?, ?)");
            $stmt->execute([$commandeId, $id, $qT, $prod['prix']]);

            // Diminuer le stock
            $stmt = $pdo->prepare("UPDATE produits SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$qT, $id]);
        }

        $pdo->commit();
        $orderPlaced = true;
        unset($_SESSION['panier']);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $errorMsg = "Erreur lors de la validation de la commande: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider ma commande - Library Cafe</title>
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
        
        .order-container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .order-success {
            text-align: center;
            padding: 40px 20px;
        }
        
        .order-success h3 {
            color: #155724;
            margin-bottom: 15px;
            font-size: 24px;
        }
        
        .order-success p {
            margin-bottom: 20px;
        }
        
        .order-success .confirmation-number {
            font-size: 18px;
            font-weight: 500;
            color: #195908;
            margin-bottom: 30px;
            padding: 10px;
            background-color: #f1f8ee;
            display: inline-block;
            border-radius: 4px;
        }
        
        .order-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .order-summary {
            margin-bottom: 30px;
        }
        
        .order-summary h3 {
            font-family: 'Instrument Serif', serif;
            font-size: 24px;
            color: #195908;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #B2D99A;
        }
        
        .order-items {
            margin-bottom: 20px;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f5f5f5;
        }
        
        .item-details {
            flex-grow: 1;
        }
        
        .item-name {
            font-weight: 500;
        }
        
        .item-price {
            color: #666;
            font-size: 14px;
        }
        
        .item-quantity {
            width: 80px;
            text-align: center;
        }
        
        .item-total {
            width: 100px;
            text-align: right;
            font-weight: 500;
        }
        
        .order-total {
            text-align: right;
            font-size: 18px;
            font-weight: 600;
            color: #195908;
            padding: 15px 0;
            border-top: 2px solid #B2D99A;
        }
        
        .form-actions {
            text-align: center;
            margin-top: 30px;
        }
        
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #FFCE70;
            color: #2D402D;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .button:hover {
            background-color: #ffc04d;
        }
        
        .button-secondary {
            background-color: #B2D99A;
            margin-left: 15px;
        }
        
        .button-secondary:hover {
            background-color: #a1c789;
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
            
            .order-item {
                flex-direction: column;
                padding: 15px 0;
            }
            
            .item-quantity, .item-total {
                width: 100%;
                text-align: left;
                margin-top: 5px;
            }
            
            .form-actions {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            
            .button {
                width: 100%;
                margin: 5px 0;
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
            <?php if ($orderPlaced): ?>
                <!-- Commande validée -->
                <h2>Commande confirmée</h2>
                
                <div class="order-container">
                    <div class="order-success">
                        <h3>Merci pour votre commande !</h3>
                        <p>Votre commande a été validée avec succès et sera préparée prochainement.</p>
                        <p class="confirmation-number">Numéro de commande: #<?= $orderId ?></p>
                        <p>Un e-mail de confirmation a été envoyé à votre adresse.</p>
                        
                        <div class="form-actions">
                            <a href="Accueil.php" class="button">Retour à l'accueil</a>
                            <a href="profil.php" class="button button-secondary">Voir mes commandes</a>
                        </div>
                    </div>
                </div>
                
            <?php else: ?>
                <!-- Formulaire de validation de commande -->
                <h2>Valider ma commande</h2>
                
                <?php if ($errorMsg): ?>
                    <div class="order-error">
                        <?= htmlspecialchars($errorMsg) ?>
                    </div>
                <?php endif; ?>
                
                <div class="order-container">
                    <div class="order-summary">
                        <h3>Récapitulatif de la commande</h3>
                        
                        <div class="order-items">
                            <?php foreach ($items as $item): ?>
                                <div class="order-item">
                                    <div class="item-details">
                                        <div class="item-name"><?= htmlspecialchars($item['nom']) ?></div>
                                        <div class="item-price"><?= number_format($item['prix'], 2, ',', ' ') ?> € l'unité</div>
                                    </div>
                                    <div class="item-quantity">Quantité: <?= $item['quantite'] ?></div>
                                    <div class="item-total"><?= number_format($item['sous_total'], 2, ',', ' ') ?> €</div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="order-total">
                            Total: <?= number_format($total, 2, ',', ' ') ?> €
                        </div>
                    </div>
                    
                    <form method="post" action="">
                        <div class="form-actions">
                            <button type="submit" name="valider" class="button">Confirmer ma commande</button>
                            <a href="panier.php" class="button button-secondary">Retour au panier</a>
                        </div>
                    </form>
                </div>
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