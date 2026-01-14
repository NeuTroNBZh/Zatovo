<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office - Zatovo</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Favicon & Icons -->
    <link rel="icon" type="image/svg+xml" href="../images/favicon.svg">
    <link rel="alternate icon" type="image/x-icon" href="../images/favicon.ico">
    <link rel="apple-touch-icon" href="../images/apple-touch-icon.png">
    <link rel="manifest" href="../images/site.webmanifest">
    <meta name="theme-color" content="#ffffff">
</head>
<body class="admin-body">
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <img src="../images/LOGO_Zatovo.png" alt="Association Zatovo - Back Office" class="sidebar-logo" loading="lazy">
            </div>
            <nav class="sidebar-nav">
                <a href="#" class="nav-item active" data-section="articles">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    Actualités
                </a>
                <a href="#" class="nav-item" data-section="new-article">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    Nouvelle actualité
                </a>
                <a href="../index.php" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Voir le site
                </a>
            </nav>
            <div class="sidebar-footer">
                <button id="logoutBtn" class="btn-logout">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Déconnexion
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <h1 id="pageTitle">Gestion des Actualités</h1>
                <div class="admin-user">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span id="username">Admin</span>
                </div>
            </header>

            <!-- Content Sections -->
            <div class="admin-content">
                <!-- Section: Liste des articles -->
                <section id="articles-section" class="content-section active">
                    <div class="section-actions">
                        <button class="btn btn-primary" onclick="showSection('new-article')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Nouvelle actualité
                        </button>
                    </div>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Date</th>
                                    <th>Catégorie</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="articlesTableBody">
                                <tr>
                                    <td colspan="7" class="loading-cell">
                                        <div class="spinner"></div>
                                        Chargement...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Section: Nouveau/Modifier article -->
                <section id="new-article-section" class="content-section">
                    <div class="form-container">
                        <form id="articleForm" class="article-form" enctype="multipart/form-data">
                            <input type="hidden" id="articleId" name="id">
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="titre">Titre de l'actualité *</label>
                                    <input type="text" id="titre" name="titre" required maxlength="200">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="auteur">Auteur *</label>
                                    <input type="text" id="auteur" name="auteur" required maxlength="100">
                                </div>
                                <div class="form-group">
                                    <label for="date">Date *</label>
                                    <input type="date" id="date" name="date" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="categorie">Catégorie *</label>
                                    <select id="categorie" name="categorie" required>
                                        <option value="">-- Choisir --</option>
                                        <option value="evenement">Événement</option>
                                        <option value="projet">Projet</option>
                                        <option value="reussite">Réussite</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="texte">Texte de l'actualité *</label>
                                <textarea id="texte" name="texte" rows="10" required></textarea>
                                <small>Le texte peut contenir plusieurs paragraphes</small>
                            </div>

                            <div class="form-group">
                                <label for="lien">Lien externe (optionnel)</label>
                                <input type="text" id="lien" name="lien" placeholder="http://example.com ou https://example.com">
                                <small>Ajoutez un lien vers plus d'informations</small>
                            </div>

                            <div class="form-group">
                                <label for="image">Image *</label>
                                <div class="file-upload">
                                    <input type="file" id="image" name="image" accept="image/*">
                                    <div class="file-upload-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="17 8 12 3 7 8"></polyline>
                                            <line x1="12" y1="3" x2="12" y2="15"></line>
                                        </svg>
                                        <span>Cliquez pour choisir une image</span>
                                    </div>
                                    <div id="imagePreview" class="image-preview"></div>
                                </div>
                                <small>Format: JPG, PNG, GIF (max 5MB)</small>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" onclick="showSection('articles')">Annuler</button>
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                        <polyline points="7 3 7 8 15 8"></polyline>
                                    </svg>
                                    Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>

    <script src="admin.js"></script>
</body>
</html>
