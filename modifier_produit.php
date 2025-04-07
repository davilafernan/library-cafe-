<?php
session_start();
require_once 'bdd.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    echo "Accès interdit.";
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch();

if (!$produit) {
    echo "Produit introuvable.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];

    $update = $pdo->prepare("UPDATE produits SET nom = ?, prix = ?, stock = ? WHERE id = ?");
    $update->execute([$nom, $prix, $stock, $id]);
    header("Location: admin_produits.php");
    exit();
}
?>

<h2>Modifier Produit #<?= $id ?></h2>
<form method="post">
    <input type="text" name="nom" value="<?= htmlspecialchars($produit['nom']) ?>" required>
    <input type="number" step="0.01" name="prix" value="<?= $produit['prix'] ?>" required>
    <input type="number" name="stock" value="<?= $produit['stock'] ?>" required>
    <button type="submit">Mettre à jour</button>
</form>
