<?php 
require_once '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = 'utilisateur'; // Par défaut, tous les nouveaux sont "utilisateur"

    // Vérifier si le nom d'utilisateur est unique
    $checkStmt = $pdo->prepare("SELECT id FROM User WHERE username = ?");
    $checkStmt->execute([$username]);
    if ($checkStmt->fetch()) {
        echo "<p class='text-red-500 text-center'>Ce nom d'utilisateur est déjà pris.</p>";
        exit();
    }

    // Insérer le nouvel utilisateur
    $stmt = $pdo->prepare("INSERT INTO User (username, password, role) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $password, $role])) {
        header("Location: login.php");
        exit();
    } else {
        echo "<p class='text-red-500 text-center'>Erreur lors de l'inscription.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-900 flex items-center justify-center h-screen">

    <div class="bg-neutral-800 text-white rounded-lg shadow-lg p-8 w-96">
        <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

        <form method="POST" class="space-y-4">
            <!-- Champ Username -->
            <div>
                <label class="block text-sm mb-1">Username</label>
                <input type="text" name="username" class="w-full p-3 bg-gray-300 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500" required>
            </div>

            <!-- Champ Password -->
            <div>
                <label class="block text-sm mb-1">Password</label>
                <input type="password" name="password" class="w-full p-3 bg-gray-300 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500" required>
            </div>

            <!-- Bouton Register -->
            <button type="submit" class="w-full bg-red-500 text-white p-3 rounded-md hover:bg-red-600 transition">
                Register
            </button>
        </form>

        <!-- Lien vers Login -->
        <p class="text-center text-sm text-red-400 mt-4 italic">
            Déjà inscrit ? <a href="login.php" class="text-red-500 hover:underline">Login</a>
        </p>
    </div>

</body>
</html>
