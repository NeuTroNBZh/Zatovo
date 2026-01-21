    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Association Zatovo</h3>
                    <p>Développement des jeunes Malgaches par le sport et l'éducation</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/p/Zatovo-100081987822483/?locale=fr_FR" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Liens Rapides</h4>
                    <ul>
                        <li><a href="<?php echo $basePath ?? ''; ?>index.php">Accueil</a></li>
                        <li><a href="<?php echo $basePath ?? ''; ?>index.php#mission">Notre Mission</a></li>
                        <li><a href="<?php echo $basePath ?? ''; ?>index.php#actions">Nos Actions</a></li>
                        <li><a href="<?php echo $basePath ?? ''; ?>actualites.php">Actualités</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Informations</h4>
                    <ul>
                        <li><a href="<?php echo $basePath ?? ''; ?>index.php#contact">Nous contacter</a></li>
                        <li><a href="<?php echo $basePath ?? ''; ?>mentions-legales.php">Mentions légales</a></li>
                        <li><a href="<?php echo $basePath ?? ''; ?>politique-confidentialite.php">Politique de confidentialité</a></li>
                        <li><a href="<?php echo $basePath ?? ''; ?>admin/login.php">Espace Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Association Zatovo. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scroll to top button -->
    <button class="scroll-top" id="scrollTop" aria-label="Retour en haut">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 15l-6-6-6 6"/>
        </svg>
    </button>
