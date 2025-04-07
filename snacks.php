<?php
session_start();
require_once 'bdd.php'; // Ensure database connection

// Filter for snack categories
$categorieStmt = $pdo->query("SELECT * FROM categories WHERE nom LIKE '%Snack%' OR nom LIKE '%Dessert%'");
$categories = $categorieStmt->fetchAll();

// Default category filter
$catID = isset($_GET['cat']) ? intval($_GET['cat']) : null;

// Query for snacks
if ($catID) {
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE categorie_id = ?");
    $stmt->execute([$catID]);
} else {
    // If no category selected, show all snacks
    $stmt = $pdo->query("SELECT p.*, c.nom AS categorie_nom 
                         FROM produits p 
                         LEFT JOIN categories c ON p.categorie_id = c.id 
                         WHERE c.nom LIKE '%Snack%' OR c.nom LIKE '%Dessert%'");
}
$produits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Snacks - Library Cafe</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fefaef;
            color: #195908;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #40573d;
            font-family: 'Instrument Serif', serif;
        }

        .filter {
            text-align: center;
            margin-bottom: 30px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-card img {
            max-width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }

        .product-card h3 {
            margin: 10px 0 5px;
            color: #40573d;
        }

        .product-card p {
            margin: 5px 0;
            color: #6b4f2d;
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #91c085;
            color: white;
        }

        .btn-primary:hover {
            background-color: #6b4f2d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nos Délicieux Snacks</h1>

        <div class="filter">
            <form method="get">
                <label for="cat">Filtrer par catégorie :</label>
                <select name="cat" id="cat" onchange="this.form.submit()">
                    <option value="">-- Toutes les catégories --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $catID == $c['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <div class="products-grid">
            <?php foreach ($produits as $p): ?>
                <div class="product-card">
                    <?php if (!empty($p['image'])): ?>
                        <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($p['nom']) ?></h3>
                    <p><?= htmlspecialchars($p['description'] ?? 'Délicieux snack de la maison') ?></p>
                    <p>
                        <strong><?= number_format($p['prix'], 2) ?> €</strong>
                        <br>
                        <small><?= htmlspecialchars($p['categorie_nom'] ?? 'Snack') ?></small>
                    </p>
                    <div class="product-actions">
                        <a href="#" class="btn btn-primary">Détails</a>
                        <a href="add_to_cart.php?id=<?= $p['id'] ?>" class="btn btn-primary">🛒 Ajouter</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>