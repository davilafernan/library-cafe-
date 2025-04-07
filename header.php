<?php session_start(); ?>
<nav>
  <a href="index.php">Accueil</a> |
  <a href="menu.php">Menu</a> |
  <a href="library.php">Bibliothèque</a> |
  <?php if (isset($_SESSION['user_id'])): ?>
      <a href="profil.php">Profil</a> |
      Bonjour <?= htmlspecialchars($_SESSION['nom']) ?> |
      <a href="logout.php">Se déconnecter</a>
  <?php else: ?>
      <a href="login.php">Connexion</a> |
      <a href="register.php">Inscription</a>
  <?php endif; ?>
</nav>