<?php
require_once 'bdd.php';
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier - Library Cafe</title>
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
        
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .cart-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .empty-cart {
            text-align: center;
            padding: 40px 0;
        }
        
        .empty-cart p {
            margin-bottom: 20px;
            font-size: 18px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        table th {
            text-align: left;
            padding: 12px;
            background-color: #B2D99A;
            color: #2D402D;
            font-weight: 500;
            border-top: 1px solid #195908;
            border-bottom: 1px solid #195908;
        }
        
        table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f5f5f5;
            vertical-align: middle;
        }
        
        .product-name {
            font-weight: 500;
            color: #195908;
        }
        
        .product-price {
            color: #666;
        }
        
        .quantity-input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }
        
        .delete-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 18px;
        }
        
        .cart-total {
            text-align: right;
            font-size: 18px;
            font-weight: 600;
            color: #195908;
            padding: 15px 0;
            border-top: 2px solid #B2D99A;
        }
        
        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .left-actions, .right-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .button {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }
        
        .update-btn {
            background-color: #B2D99A;
            color: #2D402D;
        }
        
        .empty-btn {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .continue-btn {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        .checkout-btn {
            background-color: #FFCE70;
            color: #2D402D;
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
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            .cart-actions {
                flex-direction: column;
            }
            
            .left-actions, .right-actions {
                justify-content: center;
                width: 100%;
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
                    <li><a href="#menu">Menu</a></li>
                    <li><a href="#library">Library</a></li>
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
            <h2>Votre Panier</h2>
            
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message <?= $_SESSION['message_type'] ?? 'info' ?>">
                    <?= htmlspecialchars($_SESSION['message']) ?>
                </div>
                <?php 
                // Effacer le message après l'avoir affiché
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            <?php endif; ?>
            
            <div class="cart-container">
                <?php if (empty($_SESSION['panier'])): ?>
                    <div class="empty-cart">
                        <p>Votre panier est vide.</p>
                        <a href="produit.php" class="button continue-btn">Parcourir nos produits</a>
                    </div>
                <?php else: ?>
                    <form method="post" action="maj_panier.php">
                        <table>
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total = 0;
                                foreach ($_SESSION['panier'] as $id => $qT): 
                                    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
                                    $stmt->execute([$id]);
                                    $prod = $stmt->fetch();
                                    
                                    if ($prod): // Vérifier que le produit existe
                                        $soustotal = $prod['prix'] * $qT;
                                        $total += $soustotal;
                                ?>
                                    <tr>
                                        <td>
                                            <span class="product-name"><?= htmlspecialchars($prod['nom']) ?></span>
                                        </td>
                                        <td class="product-price"><?= number_format($prod['prix'], 2, ',', ' ') ?> €</td>
                                        <td>
                                            <input type="number" name="quantite[<?= $id ?>]" value="<?= $qT ?>" min="1" class="quantity-input">
                                        </td>
                                        <td><strong><?= number_format($soustotal, 2, ',', ' ') ?> €</strong></td>
                                        <td>
                                            <button type="button" class="delete-btn" data-id="<?= $id ?>">❌</button>
                                        </td>
                                    </tr>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </tbody>
                        </table>
                        
                        <div class="cart-total">
                            Total: <strong><?= number_format($total, 2, ',', ' ') ?> €</strong>
                        </div>
                        
                        <div class="cart-actions">
                            <div class="left-actions">
                                <button type="submit" class="button update-btn">Mettre à jour</button>
                                <a href="vider_panier.php" class="button empty-btn" onclick="return confirm('Voulez-vous vraiment vider votre panier?')">Vider le panier</a>
                            </div>
                            <div class="right-actions">
                                <a href="produit.php" class="button continue-btn">Continuer les achats</a>
                                <a href="validercommande.php" class="button checkout-btn">Valider ma commande</a>
                            </div>
                        </div>
                    </form>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des boutons de suppression
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('Voulez-vous retirer ce produit du panier?')) {
                    window.location.href = `vider_panier.php?id=${id}`;
                }
            });
        });
    });
    </script>
</body>
</html>