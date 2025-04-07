<?php

$host = 'localhost';
$bdd = 'librarycafe';
$utilisateur = 'root';
$mdp = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$bdd;charset=utf8mb4", $utilisateur, $mdp);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>