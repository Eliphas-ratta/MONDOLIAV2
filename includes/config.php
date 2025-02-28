<?php
$host = 'localhost';
$dbname = 'mondolia';
$username = 'root';  // Mets ton utilisateur MySQL
$password = 'root';      // Mets ton mot de passe MySQL (vide par défaut sur WAMP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


define('BASE_URL', '/MondoliaV2/'); // Mets le bon chemin de ton projet

?>
