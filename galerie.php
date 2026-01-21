<?php
// Configuration de la page
$pageTitle = 'Galerie - Association Zatovo';
$pageDescription = 'Galerie de l\'Association Zatovo - Découvrez nos photos et moments partagés';
$currentPage = 'galerie';
$basePath = '';

// Inclure le header
include 'includes/header.php';
include 'includes/nav.php';
?>

    <main id="main">
        <!-- Header Section -->
        <section class="page-header">
            <div class="header-overlay"></div>
            <div class="container">
                <h1 class="page-title">Galerie</h1>
                <p class="page-subtitle">Suivez nos dernières nouvelles et événements</p>
            </div>
        </section>

        <!-- Galerie Section -->
        <!-- Gallery Section -->
        <section id="galerie" class="gallery">
            <div class="container">
                <div class="section-header">
                    <h2>Galerie</h2>
                    <div class="underline"></div>
                    <p class="section-subtitle">Moments de vie de nos jeunes footballeurs</p>
                </div>
                <div class="gallery-grid" id="gallery-container">
                    <!-- Chargé dynamiquement par JS -->
                    <div class="loading-spinner">Chargement...</div>
                </div>
            </div>
        </section>

        <script>
            // Script pour charger la galerie dynamiquement
            document.addEventListener('DOMContentLoaded', function() {
                fetch('api/galerie.php?action=getAll')
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('gallery-container');
                        if (data.success && data.images.length > 0) {
                            container.innerHTML = data.images.map(img => {
                                let imgSrc = img.image;
                                return `
                                <div class="gallery-item">
                                    <img src="${imgSrc}" alt="${img.titre}" onerror="this.src='https://via.placeholder.com/400x300?text=Image+non+trouvée'">
                                    <div class="gallery-overlay">
                                        <h3>${img.titre}</h3>
                                        <p>${img.description || ''}</p>
                                    </div>
                                </div>
                            `}).join('');
                        } else {
                            container.innerHTML = '<p style="text-align:center; width:100%;">Aucune image dans la galerie pour le moment.</p>';
                        }
                    })
                    .catch(err => {
                        console.error('Erreur galerie:', err);
                        document.getElementById('gallery-container').innerHTML = '<p>Erreur de chargement de la galerie.</p>';
                    });
            });
        </script>
    </main>

<?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/actualites.js"></script>
</body>
</html>
