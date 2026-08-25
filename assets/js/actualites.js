// Configuration
const API_URL = 'api/actualites.php';

// Echappe le HTML avant insertion dans innerHTML (le champ "texte" n'est pas
// echappe cote serveur pour conserver les sauts de ligne)
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text ?? '';
    return div.innerHTML;
}
let currentPage = 1;
let currentFilter = 'all';
const articlesPerPage = 6;

// Charger les actualités au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    loadCategories();
    loadActualites();
    setupFilters();
    setupModal();
});

// Charger les catégories pour les filtres
async function loadCategories() {
    try {
        const response = await fetch('api/categories.php?action=getAll');
        const data = await response.json();
        
        if (data.success && data.categories.length > 0) {
            const filtersContainer = document.getElementById('categoryFilters');
            const buttonToutes = filtersContainer.querySelector('[data-filter="all"]');
            
            // Ajouter les boutons de catégories dynamiquement
            data.categories.forEach(cat => {
                const btn = document.createElement('button');
                btn.className = 'filter-btn';
                btn.setAttribute('data-filter', cat.nom);
                btn.textContent = cat.nom;
                filtersContainer.appendChild(btn);
            });
            
            // Reconfigurer les événements de filtres après ajout
            setupFilters();
        }
    } catch (error) {
        console.error('Erreur chargement catégories:', error);
    }
}

// Charger les actualités depuis la base de données
async function loadActualites(page = 1, filter = 'all') {
    const container = document.getElementById('actualitesContainer');
    container.innerHTML = '<div class="loading"><div class="spinner"></div><p>Chargement des actualités...</p></div>';

    try {
        const response = await fetch(`${API_URL}?action=getAll&page=${page}&filter=${filter}&limit=${articlesPerPage}`);
        
        if (!response.ok) {
            throw new Error('Erreur lors du chargement des actualités');
        }

        const data = await response.json();
        
        if (data.success) {
            displayActualites(data.articles);
            displayPagination(data.totalPages, page);
        } else {
            showError('Impossible de charger les actualités');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur de connexion. Vérifiez que le serveur PHP est démarré.');
    }
}

// Afficher les actualités
function displayActualites(articles) {
    const container = document.getElementById('actualitesContainer');
    
    if (articles.length === 0) {
        container.innerHTML = `
            <div class="no-articles">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <h3>Aucune actualité trouvée</h3>
                <p>Il n'y a pas encore d'actualités dans cette catégorie.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = articles.map(article => `
        <article class="article-card" data-id="${article.id}">
            <div class="article-image">
                <img src="${article.image || 'images/default-article.jpg'}" alt="${article.titre}">
                <span class="article-category">${getCategoryLabel(article.categorie)}</span>
            </div>
            <div class="article-content">
                <div class="article-meta">
                    <span class="article-author">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        ${article.auteur}
                    </span>
                    <span class="article-date">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        ${formatDate(article.date)}
                    </span>
                </div>
                <h3 class="article-title">${article.titre}</h3>
                <p class="article-excerpt">${escapeHtml(truncateText(article.texte, 150))}</p>
                <div class="article-footer">
                    <button class="btn-read-more" onclick="openArticleModal(${article.id})">
                        Lire la suite
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        </article>
    `).join('');

    // Animation d'apparition
    animateArticles();
}

// Afficher la pagination
function displayPagination(totalPages, currentPage) {
    const pagination = document.getElementById('pagination');
    
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }

    let html = '';
    
    // Bouton précédent
    if (currentPage > 1) {
        html += `<button class="page-btn" onclick="changePage(${currentPage - 1})">Précédent</button>`;
    }

    // Numéros de page
    for (let i = 1; i <= totalPages; i++) {
        if (i === currentPage) {
            html += `<button class="page-btn active">${i}</button>`;
        } else if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
            html += `<button class="page-btn" onclick="changePage(${i})">${i}</button>`;
        } else if (i === currentPage - 2 || i === currentPage + 2) {
            html += `<span class="page-dots">...</span>`;
        }
    }

    // Bouton suivant
    if (currentPage < totalPages) {
        html += `<button class="page-btn" onclick="changePage(${currentPage + 1})">Suivant</button>`;
    }

    pagination.innerHTML = html;
}

// Changer de page
function changePage(page) {
    currentPage = page;
    loadActualites(page, currentFilter);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Configurer les filtres
function setupFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            currentFilter = btn.dataset.filter;
            currentPage = 1;
            loadActualites(1, currentFilter);
        });
    });
}

// Configurer la modal
function setupModal() {
    const modal = document.getElementById('articleModal');
    const closeBtn = document.querySelector('.modal-close');

    closeBtn.addEventListener('click', () => {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    });
}

// Ouvrir la modal avec l'article complet
async function openArticleModal(articleId) {
    const modal = document.getElementById('articleModal');
    const modalBody = document.getElementById('modalBody');

    modalBody.innerHTML = '<div class="loading"><div class="spinner"></div></div>';
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';

    try {
        const response = await fetch(`${API_URL}?action=getOne&id=${articleId}`);
        const data = await response.json();

        if (data.success) {
            const article = data.article;
            modalBody.innerHTML = `
                <div class="modal-article">
                    <img src="${article.image || 'images/default-article.jpg'}" alt="${article.titre}" class="modal-image">
                    <div class="modal-header">
                        <span class="modal-category">${getCategoryLabel(article.categorie)}</span>
                        <h2>${article.titre}</h2>
                        <div class="modal-meta">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Par ${article.auteur}
                            </span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                Le ${formatDate(article.date)}
                            </span>
                        </div>
                    </div>
                    <div class="modal-text">
                        ${escapeHtml(article.texte).replace(/\n/g, '<br>')}
                    </div>
                    ${article.lien ? `
                        <div class="modal-link">
                            <a href="${article.lien}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                                En savoir plus
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                        </div>
                    ` : ''}
                </div>
            `;
        }
    } catch (error) {
        console.error('Erreur:', error);
        modalBody.innerHTML = '<p class="error">Erreur lors du chargement de l\'article</p>';
    }
}

// Fonctions utilitaires
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', options);
}

function truncateText(text, maxLength) {
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength).trim() + '...';
}

function getCategoryLabel(category) {
    // Les catégories viennent directement de la base de données
    return category || 'Sans catégorie';
}

function showError(message) {
    const container = document.getElementById('actualitesContainer');
    container.innerHTML = `
        <div class="error-message">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            <h3>Erreur</h3>
            <p>${message}</p>
            <button class="btn btn-primary" onclick="location.reload()">Réessayer</button>
        </div>
    `;
}

function animateArticles() {
    const articles = document.querySelectorAll('.article-card');
    articles.forEach((article, index) => {
        setTimeout(() => {
            article.style.opacity = '0';
            article.style.transform = 'translateY(30px)';
            article.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            
            setTimeout(() => {
                article.style.opacity = '1';
                article.style.transform = 'translateY(0)';
            }, 50);
        }, index * 100);
    });
}
