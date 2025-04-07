<?php

require_once 'bdd.php';

if (!is_dir('uploads')) {
    mkdir('uploads', 0755, true);
}
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    http_response_code(403); // Forbidden
    echo "<div style='text-align:center; margin-top:50px;'>";
    echo "<h1>Accès réservé à l'administrateur</h1>";
    echo "<p>Vous n'avez pas les droits nécessaires pour accéder à cette page.</p>";
    echo "<a href='Accueil.php'>Retour à l'accueil</a>";
    echo "</div>";
    exit();
}

$message = '';
$messageType = '';

// Gestion de l'ajout de produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom = trim($_POST['nom']);
    $prix = floatval($_POST['prix']);
    $stock = intval($_POST['stock']);
    $categorie_id = !empty($_POST['categorie_id']) ? intval($_POST['categorie_id']) : null;
    
    // Validation des données
    if (empty($nom) || $prix <= 0 || $stock < 0) {
        $message = "Erreur: Veuillez vérifier les données du produit.";
        $messageType = "error";
    } else {
        $image = null;
        
        // Traitement de l'image si une a été téléchargée
        if (!empty($_FILES['image']['name'])) {
            // Création du répertoire uploads s'il n'existe pas
            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = "uploads/" . $fileName;
            
            // Vérification des erreurs de téléchargement
            if ($_FILES['image']['error'] === 0) {
                // Vérification du type de fichier (uniquement les images)
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (in_array($_FILES['image']['type'], $allowedTypes)) {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                        $image = $targetPath;
                    } else {
                        $message = "Erreur lors du téléchargement de l'image.";
                        $messageType = "error";
                    }
                } else {
                    $message = "Type de fichier non autorisé. Seules les images sont acceptées.";
                    $messageType = "error";
                }
            } else {
                $message = "Erreur lors du téléchargement du fichier: " . $_FILES['image']['error'];
                $messageType = "error";
            }
        }
        
        // Si pas d'erreur, insertion en base de données
        if (empty($message)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO produits (nom, prix, stock, categorie_id, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $prix, $stock, $categorie_id, $image]);
                $message = "✅ Produit ajouté avec succès.";
                $messageType = "success";
            } catch (PDOException $e) {
                $message = "Erreur lors de l'ajout du produit: " . $e->getMessage();
                $messageType = "error";
            }
        }
    }
}

// Gestion de la suppression
if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);
    
    try {
        // Récupérer l'image pour la supprimer du serveur si elle existe
        $stmt = $pdo->prepare("SELECT image FROM produits WHERE id = ?");
        $stmt->execute([$id]);
        $produit = $stmt->fetch();
        
        if ($produit && !empty($produit['image']) && file_exists($produit['image'])) {
            unlink($produit['image']);
        }
        
        // Suppression du produit
        $pdo->prepare("DELETE FROM produits WHERE id = ?")->execute([$id]);
        $message = "🗑 Produit supprimé avec succès.";
        $messageType = "success";
    } catch (PDOException $e) {
        $message = "Erreur lors de la suppression: " . $e->getMessage();
        $messageType = "error";
    }
}

// Récupération des données
try {
    $categories = $pdo->query("SELECT * FROM categories ORDER BY nom")->fetchAll();
    $produits = $pdo->query("SELECT p.*, c.nom AS categorie_nom 
                           FROM produits p 
                           LEFT JOIN categories c ON p.categorie_id = c.id
                           ORDER BY p.id DESC")->fetchAll();
} catch (PDOException $e) {
    $message = "Erreur lors de la récupération des données: " . $e->getMessage();
    $messageType = "error";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des Produits - Library Cafe</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f9f7f2;
            color: #2D402D;
        }
        
        h2, h3 {
            color: #195908;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e5e5;
        }
        
        .header a {
            background-color: #b2d99a;
            color: #2D402D;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
        }
        
        .message {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        form {
            background-color: #f1f8ee;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        form div {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        input, select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        button {
            background-color: #ffce70;
            color: #2D402D;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        
        button:hover {
            background-color: #ffc04d;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background-color: #b2d99a;
            color: #2D402D;
            font-weight: 500;
        }
        
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        table img {
            max-width: 50px;
            height: auto;
            border-radius: 4px;
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .actions a {
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .delete {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .edit {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
            
            .form-group {
                width: 100%;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Interface Admin - Produits</h2>
            <a href="Accueil.php">Retour au site</a>
        </div>
        
        <?php if (!empty($message)) : ?>
            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <h3>Ajouter un produit</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="form-row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label for="nom">Nom du produit</label>
                    <input type="text" id="nom" name="nom" placeholder="Nom du produit" required>
                </div>
                
                <div class="form-group" style="flex: 1;">
                    <label for="categorie_id">Catégorie</label>
                    <select id="categorie_id" name="categorie_id">
                        <option value="">-- Sélectionner une catégorie --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label for="prix">Prix (€)</label>
                    <input type="number" id="prix" name="prix" step="0.01" min="0" placeholder="0.00" required>
                </div>
                
                <div class="form-group" style="flex: 1;">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" min="0" placeholder="Quantité en stock" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="image">Image du produit</label>
                <input type="file" id="image" name="image" accept="image/*">
                <small style="display: block; margin-top: 5px; color: #6c757d;">Formats acceptés : JPEG, PNG, GIF, WEBP</small>
            </div>
            
            <button type="submit" name="ajouter">Ajouter le produit</button>
        </form>
        
        <h3>Liste des produits</h3>
        <?php if (count($produits) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td>
                                <?php if (!empty($p['image']) && file_exists($p['image'])): ?>
                                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
                                <?php else: ?>
                                    <span style="color: #6c757d;">Aucune image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($p['nom']) ?></td>
                            <td><?= number_format($p['prix'], 2, ',', ' ') ?> €</td>
                            <td><?= $p['stock'] ?></td>
                            <td><?= htmlspecialchars($p['categorie_nom'] ?? 'Non catégorisé') ?></td>
                            <td class="actions">
                                <a href="modifier_produit.php?id=<?= $p['id'] ?>" class="edit">Modifier</a>
                                <a href="?supprimer=<?= $p['id'] ?>" class="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun produit n'a été trouvé.</p>
        <?php endif; ?>
    </div>
</body>
</html>