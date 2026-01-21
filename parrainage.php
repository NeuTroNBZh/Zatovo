<?php
// Configuration de la page
$pageTitle = 'Nous aider - Association Zatovo';
$pageDescription = 'Association Zatovo - Comment nous aider ?';
$currentPage = 'aider';
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
                <h1 class="page-title">Comment nous aider ?</h1>
                <p class="page-subtitle">Chacun peut aider à sa façon mais que deviennent nos jeunes malgaches parrainés ?</p>
            </div>
        </section>

        <!-- Galerie Section -->
        <!-- Gallery Section -->
        <section id="galerie" class="gallery">
            <div class="container">
                <div class="section-header">
                    <h2>Comment nous aider ?</h2>
                    <div class="underline"></div>
                    <p class="section-subtitle">Chacun peut aider à sa façon<br>Ne cherchez pas de cagnotte en ligne, 
                    nous privilégions le contact humain et n'hésitez pas à nous laisser un mail à <a href='mailto:zatovo@gmail.com'>zatovo@gmail.com </a></p>
                </div>
                <div class="actions-content">
                    <div class="actions-list">
                        <div class="action-item">
                            <div class="action-number">01</div>
                            <div class="action-text">
                                <h3>Repas malgache</h3>
                                <p>Chaque année, nous organisons un grand repas malgache, sous la direction de Josiane, originaire de Madagascar qui nous fait toujours découvrir de nouvelles saveurs.
                                    Ces repas à emporter sont à votre disposition à Brest au lycée Charles de Foucauld, à Plougastel ou à Plouguerneau.
                                </p>
                            </div>
                        </div>
                        <div class="action-item">
                            <div class="action-number">02</div>
                            <div class="action-text">
                                <h3>Parrainer un enfant</h3>
                                <p> 70 enfants sont parrainés chaque année. Les fournitures scolaires, un uniforme pour aller à l'école, ...voilà ce que vous financerez si vous souhaitez parrainer un enfant. 
                                    Après déduction fiscale, c'est en réalité 70€ que vous aurez dépensé pour l'aider à aller à l'école. 
                                    Zatovo assure un suivi de la scolarité des enfants et vous recevrez au cours de l'année, des nouvelles de votre filleul, des photos et ses bulletins scolaires.
                                 </p>
                            </div>
                        </div>
                            <div class="action-item">
                            <div class="action-number">03</div>
                            <div class="action-text">
                                <h3>Ils nous soutiennent</h3>
                                <p>Un grand MERCI à nos sponsors pour leur confiance et leur accompagnement depuis de nombreuses années: 
                                    <ul>
                                    <li><a href='https://www.abm-caisse-enregistreuse.fr/abm-brest/'>ABM </a></li>
                                    <li><a href='???'>Arctique ???</a></li>
                                    <li><a href='https://www.finistere.fr/'>le département du Finistère </a></li>
                                    <li><a href='https://ville-plougastel.bzh/'>la mairie de Plougastel-Daoulas </a></li>   
                                    </ul>
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="actions-stats">
                        <div class="stat-card">
                            <div class="stat-number" data-target="16">0</div>
                            <div class="stat-label">euros<br> un délicieux repas malgache</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" data-target="140">0</div>
                            <div class="stat-label">euros<br> pour parrainer un enfant sur une année scolaire</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" data-target="500">0</div>
                            <div class="stat-label">euros<br> pour ????</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" data-target="5000">0</div>
                            <div class="stat-label">euros<br> pour financer l'ensemble du tournoi de Dirinon</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Actualités Section -->
        <section class="actualites-section">
            <div class="container">
                <div class="section-header">
                    <h2>Que sont-ils devenus ?</h2>
                    <div class="underline"></div>
                    <p class="section-subtitle"> Quelques exemples d'enfants parrainés qui font notre fierté !</p>
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
    <script src="assets/js/aider.js"></script>
</body>
</html>
