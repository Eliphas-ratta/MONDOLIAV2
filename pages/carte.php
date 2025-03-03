<?php
require_once '../includes/header.php';
?>

<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold text-center text-white mb-6">Carte de Mondolia</h1>
    
    <!-- Conteneur de la carte -->
    <div id="map" class="w-full h-[80vh] rounded-lg shadow-lg border-2 border-neutral-700"></div>
</div>

<!-- Leaflet.js pour la carte interactive -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // Dimensions de l'image de la carte
    var w = 4000, h = 3990;
    var url = "<?= BASE_URL ?>img/carte/Carte_mondolia.png";

    // Initialisation de la carte Leaflet
    var map = L.map('map', {
        minZoom: -10, // Permet un dézoom total
        maxZoom: 3,  // Zoom maximal
        center: [0, 0], // Centre initial
        zoom: -4, // Zoom de départ pour voir toute la carte
        crs: L.CRS.Simple, // Système de coordonnées simple
        zoomSnap: 0.5, // Zoom fluide
    });

    // Définition des bornes basées sur la taille de l'image
    var southWest = map.unproject([0, h], map.getMinZoom());
    var northEast = map.unproject([w, 0], map.getMinZoom());
    var bounds = new L.LatLngBounds(southWest, northEast);

    // Ajout de l'image de la carte
    L.imageOverlay(url, bounds).addTo(map);

    // Ajuste la vue pour voir toute la carte dès le chargement
    map.fitBounds(bounds);

    // Désactivation des limites de déplacement
    map.setMaxBounds(null);
</script>

<?php require_once '../includes/footer.php'; ?>
