<?php
// Configuration de la page
$pageTitle = 'Association Zatovo - Sport et Éducation à Madagascar';
$pageDescription = 'Association Zatovo - Développement des jeunes Malgaches par le sport et l\'éducation';
$currentPage = 'accueil';
$basePath = '';

// Inclure le header
include 'includes/header.php';
include 'includes/nav.php';
?>

    <main id="main">
        <!-- Hero Section -->
        <section id="accueil" class="hero">
            <div class="hero-overlay"></div>
            <div class="container">
                <div class="hero-content">
                    <h2 class="hero-title">L'éducation est leur plus beau but.</h2>
                    <p class="hero-subtitle">Solidarité internationale avec Madagascar - Développement des jeunes par le sport et l'éducation depuis Madagascar</p>
                    <div class="hero-buttons">
                        <a href="#contact" class="btn btn-primary">Envie d'aider</a>
                        <a href="actualites.php" class="btn btn-secondary">Nos actualités</a>
                    </div>
                </div>
            </div>
            <div class="scroll-indicator">
                <span></span>
            </div>
        </section>

        <!-- Mission Section -->
        <section id="mission" class="mission">
            <div class="container">
                <div class="section-header">
                    <h2>Notre Mission</h2>
                    <div class="underline"></div>
                    <p class="section-subtitle">Construire l'avenir des jeunes Malgaches</p>
                </div>
                <div class="mission-grid">
                    <div class="mission-card">
                        <div class="mission-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 8v8m-4-4h8"></path>
                            </svg>
                        </div>
                        <h3>Développement par le Sport</h3>
                        <p>Organisation de la venue de jeunes footballeurs malgaches de Madagascar pour participer à des tournois internationaux en Bretagne, notamment le tournoi de Dirinon. Le sport comme vecteur d'échanges culturels.</p>
                    </div>
                    <div class="mission-card">
                        <div class="mission-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                            </svg>
                        </div>
                        <h3>Soutien à la Scolarisation</h3>
                        <p>Actions concrètes pour favoriser la scolarisation des jeunes à Madagascar. Collecte de fonds et mise en place de projets éducatifs en partenariat avec les établissements locaux.</p>
                    </div>
                    <div class="mission-card">
                        <div class="mission-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87m-4-12a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3>Échanges Culturels</h3>
                        <p>Rencontres entre jeunes Malgaches et Brestois, interventions dans les écoles (Notre-Dame de Tourbian), actions de solidarité. Créer des ponts entre la Bretagne et Madagascar.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Actions Section -->
        <section id="actions" class="actions">
            <div class="container">
                <div class="section-header">
                    <h2>Nos Actions</h2>
                    <div class="underline"></div>
                    <p class="section-subtitle">Ce que nous faisons pour les jeunes</p>
                </div>
                <div class="actions-content">
                    <div class="actions-list">
                        <div class="action-item">
                            <div class="action-number">01</div>
                            <div class="action-text">
                                <h3>Tournoi de Dirinon</h3>
                                <p>Organisation de la venue de jeunes footballeurs malgaches, catégories U11 & U13F, pour participer au prestigieux tournoi international de football de Dirinon en Bretagne.</p>
                            </div>
                        </div>
                        <div class="action-item">
                            <div class="action-number">02</div>
                            <div class="action-text">
                                <h3>Parrainage Scolaire</h3>
                                <p>Organisation d'un parrainage pour les enfants des écoles primaires, collège et lycée comme les Petits Lascars, les Lionceaux. </p>
                            </div>
                        </div>
                            <div class="action-item">
                            <div class="action-number">03</div>
                            <div class="action-text">
                                <h3>Actions Scolaires</h3>
                                <p>Interventions dans les établissements scolaires brestois et malgaches pour sensibiliser et créer des liens entre jeunes Français et Malgaches.</p>
                            </div>
                        </div>
                        <div class="action-item">
                            <div class="action-number">04</div>
                            <div class="action-text">
                                <h3>Collecte de Fonds</h3>
                                <p>Organisation d'un grand repas malgache annuel, participation à des opérations de solidarité ("Bol de riz") pour financer les projets de scolarisation à Madagascar.</p>
                            </div>
                        </div>
                        <div class="action-item">
                            <div class="action-number">05</div>
                            <div class="action-text">
                                <h3>Échanges Culturels</h3>
                                <p>Facilitation des rencontres entre jeunes Malgaches et Brestois pour favoriser la compréhension mutuelle et la solidarité internationale.</p>
                            </div>
                        </div>
                    </div>
                    <div class="actions-stats">
                        <div class="stat-card">
                            <div class="stat-number" data-target="20">0</div>
                            <div class="stat-label">ans</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" data-target="250">0</div>
                            <div class="stat-label">enfants parrainés</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" data-target="20">0</div>
                            <div class="stat-label">Tournois organisés</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
            // Script pour charger la galerie dynamiquement (limité à 6 images)
            document.addEventListener('DOMContentLoaded', function() {
                fetch('api/galerie.php?action=getAll')
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('gallery-container');
                        if (data.success && data.images.length > 0) {
                            const totalImages = data.images.length;
                            const maxImages = 6;
                            const imagesToShow = data.images.slice(0, maxImages);
                            
                            let html = imagesToShow.map(img => {
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
                            
                            // Ajouter le bouton "Afficher plus" si il y a plus de 6 images
                            if (totalImages > maxImages) {
                                html += `
                                <div class="gallery-more" style="grid-column: 1 / -1; text-align: center; margin-top: 30px;">
                                    <a href="galerie.php" class="btn btn-primary">
                                        Afficher plus (${totalImages - maxImages} image${totalImages - maxImages > 1 ? 's' : ''})
                                    </a>
                                </div>
                                `;
                            }
                            
                            container.innerHTML = html;
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

        <!-- Contact Section -->
        <section id="contact" class="contact">
            <div class="container">
                <div class="section-header">
                    <h2>Contactez-nous</h2>
                    <div class="underline"></div>
                    <p class="section-subtitle">Association brestoise de solidarité internationale</p>
                </div>
                <div class="contact-content">
                    <div class="contact-info">
                        <h3>Informations</h3>
                        <div class="info-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <div>
                                <strong>Siège Social</strong>
                                <p>Association ZATOVO<br>Président : Claude André<br>29200 Brest<br>
                                06 08 73 30 15<br> zatovo@gmail.com<br>
                                </p>
                            </div>
                        </div>
                        <div class="info-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                            <div>
                                <strong>Association Loi 1901</strong>
                                <p>Créée le 5 septembre 2005<br>SIREN: 498 712 868</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 6v6l4 2"></path>
                            </svg>
                            <div>
                                <strong>Depuis 2005</strong>
                                <p>20 ans de solidarité<br>Brest ↔ Madagascar</p>
                            </div>
                        </div>
                    </div>
                    <div class="contact-map">
                        <h3>Notre Mission</h3>
                        <p style="line-height: 1.8; color: #666;">
                            <strong>Zatovo</strong> signifie "Force de la jeunesse" en dialecte du nord de Madagascar.
                            <br><br>
                            Nous sommes une association brestoise bénévole dédiée à la <strong>solidarité internationale</strong> avec Madagascar, 
                            particulièrement la région nord avec <strong> Nosy Be, Ambilobe, Diego Suarez (Antsiranana), Sambava et Antalaha</strong>.
                            <br><br>
                            Nos actions combinent <strong>sport</strong> et <strong>éducation</strong> pour créer des ponts durables entre 
                            la Bretagne et Madagascar.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
</body>
</html>
