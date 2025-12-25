<!doctype html>
<!-- Définit la langue du document -->
<html lang="fr">
<!-- En-tête du document HTML -->
<head>
    <!-- Déclare l'encodage des caractères -->
    <meta charset="utf-8">
    <!-- Configure le viewport pour les appareils mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Définit le titre de la page avec échappement -->
    <title><?= isset($title) ? htmlspecialchars($title) : 'App' ?></title>
</head>
<!-- Corps du document -->
<body>
<?php
// Détermine la page active pour la navigation
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$isHome = ($currentPath === '/');
$isProducts = ($currentPath === '/products' || strpos($currentPath, '/products/show') === 0);
$isProductsCreate = ($currentPath === '/products/create');
$isUsersCreate = ($currentPath === '/users/create');
$isCart = ($currentPath === '/cart');
$isOrders = (strpos($currentPath, '/orders') === 0);
// Utilisateur connecté (stocké en session)
$loggedUserId = $_SESSION['user_id'] ?? null;
$loggedUserName = $_SESSION['user_nom'] ?? null;
$loggedUserRole = $_SESSION['user_role'] ?? null;
$isAdmin = ($loggedUserRole === 'admin');
$user_id = $loggedUserId ?? 1; // Fallback démo si pas connecté
?>
<!-- En-tête de la page -->
<header style="background-color: #343a40; color: white; padding: 15px 0; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <!-- Logo/Titre -->
        <h1 style="margin: 0; font-size: 24px;">
            <a href="/" style="color: white; text-decoration: none;">Mini MVC</a>
        </h1>
        
        <!-- Navigation -->
        <nav>
            <ul style="list-style: none; margin: 0; padding: 0; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <li>
                    <a href="/" 
                       style="color: <?= $isHome ? '#ffc107' : 'white' ?>; 
                              text-decoration: none; 
                              padding: 8px 15px; 
                              border-radius: 4px;
                              display: inline-block;
                              transition: background-color 0.3s;"
                       onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.backgroundColor='transparent'">
                        🏠 Accueil
                    </a>
                </li>
                <li>
                    <a href="/products" 
                       style="color: <?= $isProducts ? '#ffc107' : 'white' ?>; 
                              text-decoration: none; 
                              padding: 8px 15px; 
                              border-radius: 4px;
                              display: inline-block;
                              transition: background-color 0.3s;"
                       onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.backgroundColor='transparent'">
                        📦 Produits
                    </a>
                </li>
                <?php if ($isAdmin): ?>
                <li>
                    <a href="/products/create" 
                       style="color: <?= $isProductsCreate ? '#ffc107' : 'white' ?>; 
                              text-decoration: none; 
                              padding: 8px 15px; 
                              border-radius: 4px;
                              display: inline-block;
                              transition: background-color 0.3s;"
                       onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.backgroundColor='transparent'">
                        ➕ Ajouter un produit
                    </a>
                </li>
                <?php endif; ?>
                <!-- <li>
                    <a href="/users/create" 
                       style="color: <?= $isUsersCreate ? '#ffc107' : 'white' ?>; 
                              text-decoration: none; 
                              padding: 8px 15px; 
                              border-radius: 4px;
                              display: inline-block;
                              transition: background-color 0.3s;"
                       onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.backgroundColor='transparent'">
                        👤 Ajouter un utilisateur
                    </a>
                </li> -->
                <li>
                    <a href="/cart" 
                       style="color: <?= $isCart ? '#ffc107' : 'white' ?>; 
                              text-decoration: none; 
                              padding: 8px 15px; 
                              border-radius: 4px;
                              display: inline-block;
                              transition: background-color 0.3s;
                              background-color: <?= $isCart ? 'rgba(255,255,255,0.1)' : 'transparent' ?>;
                              font-weight: <?= $isCart ? 'bold' : 'normal' ?>;"
                       onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.backgroundColor='<?= $isCart ? 'rgba(255,255,255,0.1)' : 'transparent' ?>'">
                        🛒 Panier
                    </a>
                </li>
                <li>
                    <a href="/orders" 
                       style="color: <?= $isOrders ? '#ffc107' : 'white' ?>; 
                              text-decoration: none; 
                              padding: 8px 15px; 
                              border-radius: 4px;
                              display: inline-block;
                              transition: background-color 0.3s;
                              background-color: <?= $isOrders ? 'rgba(255,255,255,0.1)' : 'transparent' ?>;
                              font-weight: <?= $isOrders ? 'bold' : 'normal' ?>;"
                       onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.backgroundColor='<?= $isOrders ? 'rgba(255,255,255,0.1)' : 'transparent' ?>'">
                        📋 Mes commandes
                    </a>
                </li>
                <?php if ($loggedUserId): ?>
                    <li style="color: #fff; font-size: 14px; padding: 0 10px;">
                        Bonjour, <?= htmlspecialchars($loggedUserName ?? 'Utilisateur') ?>
                    </li>
                    <li>
                        <a href="/logout"
                           style="color: white;
                                  text-decoration: none;
                                  padding: 8px 15px;
                                  border-radius: 4px;
                                  display: inline-block;
                                  background-color: #dc3545;">
                            🚪 Déconnexion
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="/login"
                           style="color: white;
                                  text-decoration: none;
                                  padding: 8px 15px;
                                  border-radius: 4px;
                                  display: inline-block;
                                  border: 1px solid #ffc107;">
                            🔑 Connexion
                        </a>
                    </li>
                    <li>
                        <a href="/register"
                           style="color: #343a40;
                                  background-color: #ffc107;
                                  text-decoration: none;
                                  padding: 8px 15px;
                                  border-radius: 4px;
                                  display: inline-block;
                                  font-weight: bold;">
                            🧾 Inscription
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<!-- Zone de contenu principal -->
<main>
    <!-- Insère le contenu rendu de la vue -->
    <?= $content ?>
    
</main>
<!-- Fin du corps de la page -->
</body>
<!-- Fin du document HTML -->
</html>

