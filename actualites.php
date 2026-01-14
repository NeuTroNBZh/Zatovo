<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Actualités de l'Association Zatovo">
    <title>Actualités - Association Zatovo</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Favicon & Icons -->
    <link rel="icon" type="image/svg+xml" href="images/favicon.svg">
    <link rel="alternate icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="manifest" href="images/site.webmanifest">
    <meta name="theme-color" content="#ffffff">
    <meta property="og:title" content="Actualités - Association Zatovo">
    <meta property="og:description" content="Suivez les actions sportives et éducatives entre Brest et Diego Suarez menées par l'Association Zatovo.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://zatovo.fr/actualites.php">
    <meta property="og:image" content="https://zatovo.fr/images/LOGO_Zatovo.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Actualités - Association Zatovo">
    <meta name="twitter:description" content="Découvrir les nouvelles de l'Association Zatovo : sport, éducation et solidarité Brest ↔ Madagascar.">
    <meta name="twitter:image" content="https://zatovo.fr/images/LOGO_Zatovo.png">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Association Zatovo",
      "url": "https://zatovo.fr/",
      "logo": "https://zatovo.fr/images/LOGO_Zatovo.png",
      "sameAs": [
        "https://www.facebook.com/p/Zatovo-100081987822483/?locale=fr_FR"
      ]
    }
    </script>
</head>
<body>
    <a class="skip-link" href="#main">Aller au contenu principal</a>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <img src="images/LOGO_Zatovo.png" alt="Association Zatovo - Sport & Éducation : Brest ↔ Madagascar" class="logo-img" loading="lazy">
                </div>
                <button class="menu-toggle" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="main-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <ul class="nav-menu" id="main-menu">
                    <li><a href="index.php" class="nav-link">Accueil</a></li>
                    <li><a href="index.php#mission" class="nav-link">Notre Mission</a></li>
                    <li><a href="index.php#actions" class="nav-link">Nos Actions</a></li>
                    <li><a href="actualites.php" class="nav-link active">Actualités</a></li>
                    <li><a href="index.php#contact" class="nav-link">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <main id="main">
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
            <div class="actualites-filter">
                <button class="filter-btn active" data-filter="all">Toutes</button>
                <button class="filter-btn" data-filter="evenement">Événements</button>
                <button class="filter-btn" data-filter="projet">Projets</button>
                <button class="filter-btn" data-filter="reussite">Réussites</button>
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

    <!-- Footer -->
    </main>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Association Zatovo</h3>
                    <p>Développement des jeunes Malgaches par le sport et l'éducation</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/p/Zatovo-100081987822483/?locale=fr_FR" aria-label="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Liens Rapides</h4>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="index.php#mission">Notre Mission</a></li>
                        <li><a href="index.php#actions">Nos Actions</a></li>
                        <li><a href="actualites.php">Actualités</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <ul>
                        <li><a href="index.php#contact">Nous contacter</a></li>
                        <li><a href="admin/login.php">Connexion Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Association Zatovo. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scroll to top button -->
    <button class="scroll-top" id="scrollTop" aria-label="Retour en haut">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 15l-6-6-6 6"/>
        </svg>
    </button>

    <script src="script.js"></script>
    <script src="actualites.js"></script>
</body>
</html>
