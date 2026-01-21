<?php
// Configuration de la page
$pageTitle = 'Actualités - Association Zatovo';
$pageDescription = 'Actualités de l\'Association Zatovo - Suivez nos dernières nouvelles et événements';
$currentPage = 'actualites';
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
                <h1 class="page-title">Actualités</h1>
                <p class="page-subtitle">Suivez nos dernières nouvelles et événements</p>
            </div>
        </section>

        <!-- Actualités Section -->
        <section class="actualites-section">
            <div class="container">
                <div class="actualites-filter" id="categoryFilters">
                    <button class="filter-btn active" data-filter="all">Toutes</button>
                    <!-- Les catégories sont chargées dynamiquement depuis la base de données -->
                </div>

                <div id="actualitesContainer" class="actualites-grid">
                    <!-- Les articles seront chargés dynamiquement depuis la base de données -->
                    <div class="loading">
                        <div class="spinner"></div>
                        <p>Chargement des actualités...</p>
                    </div>
                </div>

                <!-- Pagination -->
                <div id="pagination" class="pagination">
                    <!-- La pagination sera générée dynamiquement -->
                </div>
            </div>
        </section>

        <!-- Article Modal -->
        <div id="articleModal" class="modal">
            <div class="modal-content">
                <button class="modal-close" aria-label="Fermer">&times;</button>
                <div id="modalBody">
                    <!-- Le contenu sera chargé dynamiquement -->
                </div>
            </div>
        </div>
    </main>

<?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/actualites.js"></script>
</body>
</html>
