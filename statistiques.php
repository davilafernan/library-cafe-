<?php
session_start();
require_once 'bdd.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    echo "Accès interdit.";
    exit();
}

$totalCommandes = $pdo->query("SELECT COUNT(*) FROM commandes")->fetchColumn();
$montantTotal = $pdo->query("SELECT SUM(total) FROM commandes")->fetchColumn();
$produitsPopulaires = $pdo->query("
    SELECT p.nom, SUM(ci.quantite) as total
    FROM commande_item ci
    JOIN produits p ON ci.produit_id = p.id
    GROUP BY ci.produit_id
    ORDER BY total DESC
    LIMIT 5
")->fetchAll();
?>

<h2>📊 Statistiques</h2>
<p>Total commandes : <strong><?= $totalCommandes ?></strong></p>
<p>Montant généré : <strong><?= number_format($montantTotal, 2) ?> €</strong></p>

<h3>🥇 Produits les plus vendus :</h3>
<ul>
<?php foreach ($produitsPopulaires as $prod): ?>
    <li><?= htmlspecialchars($prod['nom']) ?> — <?= $prod['total'] ?> vendus</li>
<?php endforeach; ?>
</ul>
