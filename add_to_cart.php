<?php
// Démarrer la session si elle n'est pas déjà démarrée
session_start();

if (!isset($_POST['produit_id']) || !isset($_POST['quantité'])) {
    header("Location: produit.php");
    exit();
}

$id = $_POST['produit_id'];
$qT = $_POST['quantité'];

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Ajouter le produit au panier
if (isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id] += $qT;
} else {
    $_SESSION['panier'][$id] = $qT;
}

header("Location: panier.php");
exit();