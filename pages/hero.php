<?php
require_once '../includes/header.php';

// Vérifier si l'ID est passé en paramètre
if (!isset($_GET['id'])) {
    header("Location: heros.php");
    exit();
}

$hero_id = $_GET['id'];

// Récupération des infos du héros
$stmt = $pdo->prepare("SELECT * FROM heros WHERE id = ?");
$stmt->execute([$hero_id]);
$hero = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hero) {
    header("Location: heros.php");
    exit();
}

// Récupération de la faction associée
$stmt = $pdo->prepare("SELECT id, name, image, regime FROM factions WHERE id = ?");
$stmt->execute([$hero['faction_id']]);
$faction = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupération des guildes associées
$stmt = $pdo->prepare("SELECT id, name, image, type FROM guildes WHERE id IN 
                      (SELECT guilde_id FROM heros_guildes WHERE hero_id = ?)");
$stmt->execute([$hero_id]);
$guildes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération de la race associée
$stmt = $pdo->prepare("SELECT id, name, image FROM races WHERE id = ?");
$stmt->execute([$hero['race_id']]);
$race = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupération des héros liés (alliés, ennemis, etc.)
$stmt = $pdo->prepare("SELECT id, name, image, fonction FROM heros WHERE id IN 
                      (SELECT hero2_id FROM heros_relations WHERE hero1_id = ?)");
$stmt->execute([$hero_id]);
$heros_lies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des contextes associés
$stmt = $pdo->prepare("SELECT id, titre FROM contextes WHERE id IN 
                      (SELECT contexte_id FROM heros_contextes WHERE hero_id = ?)");
$stmt->execute([$hero_id]);
$contextes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto py-10">
    <!-- Infos du héros -->
    <div class="flex items-start justify-between gap-6">
        <div class="flex gap-6">
            <img src="<?= $hero['image'] ?>" alt="<?= $hero['name'] ?>" class="w-80 h-80 object-cover rounded-lg">
            <div>
                <h1 class="text-3xl font-bold text-red-500"><?= $hero['name'] ?></h1>
                <p class="text-white"><strong>Âge :</strong> <?= $hero['age'] ?></p>
                <p class="text-white"><strong>Taille :</strong> <?= $hero['taille'] ?></p>
                <p class="text-white"><strong>Fonction :</strong> <?= $hero['fonction'] ?></p>
                <p class="text-white"><strong>Description :</strong> <?= $hero['description'] ?></p>
            </div>
        </div>

        <!-- Faction associée -->
        <?php if ($faction) : ?>
            <div class="text-center">
                <h2 class="text-lg font-bold text-white">Faction</h2>
                <a href="faction.php?id=<?= $faction['id'] ?>" class="transform transition duration-300 hover:scale-105">
                    <div class="faction-card bg-neutral-900 p-4 rounded-lg shadow-lg text-center border-neutral-700 w-32">
                        <img src="<?= $faction['image'] ?>" alt="<?= $faction['name'] ?>" class="w-full h-24 object-cover rounded-lg mb-2">
                        <p class="text-white font-bold"><?= $faction['name'] ?></p>
                        <p class="text-gray-400 text-sm"><?= $faction['regime'] ?></p>
                    </div>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Guildes -->
    <h2 class="text-2xl font-bold text-center text-white mt-10 bg-neutral-800 p-3">Guildes</h2>
    <div class="grid grid-cols-5 gap-6 justify-center px-10 mt-6">
        <?php foreach ($guildes as $guilde) : ?>
            <a href="guilde.php?id=<?= $guilde['id'] ?>" class="transform transition duration-300 hover:scale-105">
                <div class="guilde-card bg-neutral-900 p-4 rounded-lg shadow-lg text-center border-neutral-700 w-40">
                    <img src="<?= $guilde['image'] ?>" alt="<?= $guilde['name'] ?>" class="w-full h-24 object-cover rounded-lg mb-2">
                    <p class="text-white font-bold"><?= $guilde['name'] ?></p>
                    <p class="text-gray-400 text-sm"><?= $guilde['type'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Race -->
    <h2 class="text-2xl font-bold text-center text-white mt-10 bg-neutral-800 p-3">Race</h2>
    <div class="flex justify-center mt-6">
        <?php if ($race) : ?>
            <a href="race.php?id=<?= $race['id'] ?>" class="transform transition duration-300 hover:scale-105">
                <div class="race-card bg-neutral-900 p-4 rounded-lg shadow-lg text-center border-neutral-700 w-40">
                    <img src="<?= $race['image'] ?>" alt="<?= $race['name'] ?>" class="w-full h-24 object-cover rounded-lg mb-2">
                    <p class="text-white font-bold"><?= $race['name'] ?></p>
                </div>
            </a>
        <?php endif; ?>
    </div>

    <!-- Héros liés -->
    <h2 class="text-2xl font-bold text-center text-white mt-10 bg-neutral-800 p-3">Héros liés</h2>
    <div class="grid grid-cols-5 gap-6 justify-center px-10 mt-6">
        <?php foreach ($heros_lies as $hero_lie) : ?>
            <a href="hero.php?id=<?= $hero_lie['id'] ?>" class="transform transition duration-300 hover:scale-105">
                <div class="hero-card bg-neutral-900 p-4 rounded-lg shadow-lg text-center border-neutral-700 w-40">
                    <img src="<?= $hero_lie['image'] ?>" alt="<?= $hero_lie['name'] ?>" class="w-full h-24 object-cover rounded-lg mb-2">
                    <p class="text-white font-bold"><?= $hero_lie['name'] ?></p>
                    <p class="text-gray-400 text-sm"><?= $hero_lie['fonction'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Contextes -->
    <h2 class="text-2xl font-bold text-center text-white mt-10 bg-neutral-800 p-3">Contextes</h2>
    <div class="grid grid-cols-5 gap-6 justify-center px-10 mt-6">
        <?php foreach ($contextes as $contexte) : ?>
            <a href="contexte.php?id=<?= $contexte['id'] ?>" class="transform transition duration-300 hover:scale-105">
                <div class="contexte-card bg-neutral-900 p-4 rounded-lg shadow-lg text-center border-neutral-700 w-40">
                    <p class="text-white font-bold"><?= $contexte['titre'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
