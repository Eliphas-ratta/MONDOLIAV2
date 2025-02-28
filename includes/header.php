<?php
session_start();
require_once __DIR__ . '/config.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est bien connecté
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$isAdmin = $isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Liste des pages accessibles sans connexion
$currentFile = basename($_SERVER['PHP_SELF']);
$allowedPages = ['login.php', 'register.php', 'index.php'];

// Redirection forcée vers login.php si non connecté
if (!$isLoggedIn && !in_array($currentFile, $allowedPages)) {
    header("Location: " . BASE_URL . "Security/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mondolia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-800 text-white">

<header class="bg-neutral-900 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="<?= BASE_URL ?>index.php" class="text-white text-xl font-bold">
            <img src="<?= BASE_URL ?>img/default/logo_header.png" alt="Logo" width="80" height="80">
        </a>

        <!-- Navigation -->
        <nav class="flex space-x-6">
            <a href="<?= BASE_URL ?>pages/factions.php" class="hover:text-gray-300">Factions</a>
            <a href="<?= BASE_URL ?>pages/guildes.php" class="hover:text-gray-300">Guildes</a>
            <a href="<?= BASE_URL ?>pages/races.php" class="hover:text-gray-300">Races</a>
            <a href="<?= BASE_URL ?>pages/heros.php" class="hover:text-gray-300">Héros</a>
            <a href="<?= BASE_URL ?>pages/contextes.php" class="hover:text-gray-300">Contextes</a>
            <a href="<?= BASE_URL ?>pages/carte.php" class="hover:text-gray-300">Carte</a>
        </nav>

        <!-- Authentification -->
        <div class="flex items-center space-x-4">
            <?php if (!$isLoggedIn) : ?>
                <!-- Utilisateur non connecté -->
                <a href="<?= BASE_URL ?>Security/login.php" class="hover:text-gray-300">Connexion</a>
                <a href="<?= BASE_URL ?>Security/register.php" class="hover:text-gray-300">S'inscrire</a>
            <?php else : ?>
                <!-- Utilisateur connecté -->
                <?php if ($isAdmin) : ?>
                    <a href="<?= BASE_URL ?>backoffice/dashboard.php" class="text-red-500 font-semibold">Backoffice</a>
                <?php endif; ?>

                <!-- Profil & Logout -->
                <div class="flex items-center space-x-2">
                    <img src="<?= BASE_URL ?>img/default/pdp.png" alt="Profile Pic" class="w-10 h-10 rounded-full object-cover">
                    <span class="text-white font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="<?= BASE_URL ?>Security/logout.php" class="hover:text-gray-300">Déconnexion</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
