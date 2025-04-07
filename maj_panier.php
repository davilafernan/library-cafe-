<?php
session_start();
foreach ($_POST['quantite'] as $id => $qT) {
    $id = intval($id);
    $qT = intval($qT);

    if ($qT > 0) {
        $_SESSION['panier'][$id] = $qT;
    } else {
        unset($_SESSION['panier'][$id]);
    }
}
header("Location: panier.php");
exit();
