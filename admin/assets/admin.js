
const API_URL = '../api/actualites.php';
const CAT_API_URL = '../api/categories.php';
const GAL_API_URL = '../api/galerie.php';
let editingArticleId = null;
let csrfToken = null;

// L'authentification est gérée côté serveur via PHP session
// Pas besoin de checkAuth() côté client - index.php fait la vérification

document.addEventListener('DOMContentLoaded', () => {
    setupNavigation();
    loadArticles();
    loadCategories();
    loadGallery();
    setupForm();
    setupCategoryForm();
    setupGalleryForm();
    setupLogout();
    setTodayDate();
    getCSRFToken();
});

// Récupérer le token CSRF du serveur
async function getCSRFToken() {
    try {
        const response = await fetch('../api/csrf.php');
        const data = await response.json();
        if (data.success) {
            csrfToken = data.csrf_token;
        }
    } catch (error) {
        console.error('Erreur récupération CSRF token:', error);
    }
}


function setupNavigation() {
    const navItems = document.querySelectorAll('.nav-item[data-section]');
    
    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const section = item.dataset.section;
            showSection(section);
            
            navItems.forEach(n => n.classList.remove('active'));
            item.classList.add('active');
        });
    });
}


function showSection(sectionName) {
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(s => s.classList.remove('active'));
    
    const section = document.getElementById(`${sectionName}-section`);
    if (section) {
        section.classList.add('active');
        
        
        const titles = {
            'articles': 'Gestion des Actualités',
            'categories': 'Gestion des Catégories',
            'galerie': 'Gestion de la Galerie',
            'new-article': editingArticleId ? 'Modifier l\'actualité' : 'Nouvelle actualité'
        };
        document.getElementById('pageTitle').textContent = titles[sectionName] || 'Administration';
        
        
        if (sectionName === 'new-article' && !editingArticleId) {
            document.getElementById('articleForm').reset();
            document.getElementById('imagePreview').innerHTML = '';
            document.getElementById('articleId').value = '';
        }
    }
}




async function loadArticles() {
    const tbody = document.getElementById('articlesTableBody');
    tbody.innerHTML = '<tr><td colspan="7" class="loading-cell"><div class="spinner"></div> Chargement...</td></tr>';

    try {
        const response = await fetch(`${API_URL}?action=getAll&limit=100`);
        const data = await response.json();

        if (data.success && data.articles.length > 0) {
            tbody.innerHTML = data.articles.map(article => {
                let imgSrc = article.image;
                if (!imgSrc.startsWith('http')) {
                    imgSrc = '../' + imgSrc;
                }
                
                return `
                <tr>
                    <td>${article.id}</td>
                    <td><img src="${imgSrc}" alt="${article.titre}" class="table-image" referrerpolicy="no-referrer" onerror="if(!this.hasAttribute('data-error')){this.setAttribute('data-error','1');this.src='https://via.placeholder.com/50?text=Err'}else{this.style.display='none'}"></td>
                    <td><strong>${article.titre}</strong></td>
                    <td>${article.auteur}</td>
                    <td>${formatDate(article.date)}</td>
                    <td><span class="badge">${getCategoryLabel(article.categorie)}</span></td>
                    <td>
                        <div class="table-actions">
                            <button class="btn-icon btn-edit" onclick="editArticle(${article.id})" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </button>
                            <button class="btn-icon btn-delete" onclick="deleteArticle(${article.id})" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `}).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 40px;">Aucune actualité trouvée</td></tr>';
        }
    } catch (error) {
        console.error('Erreur:', error);
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 40px; color: #e74c3c;">Erreur lors du chargement des articles</td></tr>';
    }
}


function setupForm() {
    const form = document.getElementById('articleForm');
    const imageInput = document.getElementById('image');
    const imageUrlInput = document.getElementById('image_url');

    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('imagePreview').innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                `;
            };
            reader.readAsDataURL(file);
            imageUrlInput.value = ''; 
        }
    });


    imageUrlInput.addEventListener('input', (e) => {
        const url = e.target.value;
        if (url) {
            document.getElementById('imagePreview').innerHTML = `
                <img src="${url}" alt="Preview" onerror="if(!this.hasAttribute('data-error')){this.setAttribute('data-error','1')}else{this.style.display='none'}">
            `;
            imageInput.value = ''; 
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(form);
        const articleId = document.getElementById('articleId').value;
        
        if (articleId) {
            formData.append('action', 'update');
        } else {
            formData.append('action', 'create');
        }
        
        // Ajouter le token CSRF
        if (csrfToken) {
            formData.append('csrf_token', csrfToken);
        }

        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.success) {
                showToast('Actualité enregistrée avec succès !', 'success');
                form.reset();
                document.getElementById('imagePreview').innerHTML = '';
                document.getElementById('articleId').value = '';
                editingArticleId = null;
                loadArticles();
                showSection('articles');
            } else {
                showToast(data.message || 'Erreur lors de l\'enregistrement', 'error');
            }
        } catch (error) {
            console.error('Erreur:', error);
            showToast('Erreur de connexion', 'error');
        }
    });
}


async function editArticle(id) {
    editingArticleId = id;
    showSection('new-article');

    try {
        const response = await fetch(`${API_URL}?action=getOne&id=${id}`);
        const data = await response.json();

        if (data.success) {
            const article = data.article;
            document.getElementById('articleId').value = article.id;
            document.getElementById('titre').value = article.titre;
            document.getElementById('auteur').value = article.auteur;
            document.getElementById('date').value = article.date;
            document.getElementById('categorie').value = article.categorie;
            document.getElementById('texte').value = article.texte;
            document.getElementById('lien').value = article.lien || '';
            
            if (article.image) {
                const imgSrc = article.image.startsWith('http') ? article.image : '../' + article.image;
                document.getElementById('imagePreview').innerHTML = `
                    <img src="${imgSrc}" alt="${article.titre}">
                `;
                if (article.image.startsWith('http')) {
                    document.getElementById('image_url').value = article.image;
                }
            }
        }
    } catch (error) {
        console.error('Erreur:', error);
        showToast('Erreur lors du chargement de l\'article', 'error');
    }
}


async function deleteArticle(id) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cette actualité ?')) {
        return;
    }

    try {
        const body = { 
            action: 'delete', 
            id: id 
        };
        
        // Ajouter le token CSRF
        if (csrfToken) {
            body.csrf_token = csrfToken;
        }
        
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(body),
            credentials: 'same-origin'
        });

        const data = await response.json();

        if (data.success) {
            showToast('Actualité supprimée', 'success');
            loadArticles();
        } else {
            showToast(data.message || 'Erreur lors de la suppression', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showToast('Erreur de connexion', 'error');
    }
}


async function loadCategories() {
    const tbody = document.getElementById('categoriesTableBody');
    const select = document.getElementById('categorie');
    
    try {
        const response = await fetch(`${CAT_API_URL}?action=getAll`);
        const data = await response.json();

        if (data.success) {
            // Remplir le tableau
            tbody.innerHTML = data.categories.map(cat => `
                <tr>
                    <td>${cat.id}</td>
                    <td>${cat.nom}</td>
                    <td>
                        <button class="btn-icon btn-delete" onclick="deleteCategory(${cat.id})" title="Supprimer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
            `).join('');

            const currentVal = select.value;
            select.innerHTML = '<option value="">-- Choisir --</option>' + 
                data.categories.map(cat => `<option value="${cat.nom}">${cat.nom}</option>`).join('');
            if (currentVal) select.value = currentVal;
        }
    } catch (error) {
        console.error('Erreur chargement catégories:', error);
    }
}

function setupCategoryForm() {
    document.getElementById('categoryForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const nom = document.getElementById('cat_nom').value;
        const formData = new FormData();
        formData.append('action', 'create');
        formData.append('nom', nom);
        
        // Ajouter le token CSRF
        if (csrfToken) {
            formData.append('csrf_token', csrfToken);
        }

        try {
            const response = await fetch(CAT_API_URL, { 
                method: 'POST', 
                body: formData,
                credentials: 'same-origin'
            });
            const data = await response.json();
            if (data.success) {
                showToast('Catégorie ajoutée');
                document.getElementById('cat_nom').value = '';
                loadCategories();
            } else {
                showToast(data.message || 'Erreur', 'error');
            }
        } catch (error) {
            showToast('Erreur connexion', 'error');
        }
    });
}

async function deleteCategory(id) {
    if (!confirm('Supprimer cette catégorie ?')) return;
    try {
        const body = { 
            action: 'delete', 
            id: id 
        };
        
        // Ajouter le token CSRF
        if (csrfToken) {
            body.csrf_token = csrfToken;
        }
        
        const response = await fetch(CAT_API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(body),
            credentials: 'same-origin'
        });
        const data = await response.json();
        if (data.success) {
            showToast('Catégorie supprimée');
            loadCategories();
        } else {
            showToast(data.message || 'Erreur', 'error');
        }
    } catch (error) {
        showToast('Erreur connexion', 'error');
    }
}


async function loadGallery() {
    const grid = document.getElementById('galleryGrid');
    try {
        const response = await fetch(`${GAL_API_URL}?action=getAll`);
        const data = await response.json();

        if (data.success) {
            grid.innerHTML = data.images.map(img => {
                // Gestion de l'affichage de l'image (URL ou chemin local)
                let imgSrc = img.image;
                if (!imgSrc.startsWith('http')) {
                    imgSrc = '../' + imgSrc;
                }

                return `
                <div class="gallery-item-card">
                    <img src="${imgSrc}" alt="${img.titre}" referrerpolicy="no-referrer" onerror="if(!this.hasAttribute('data-error')){this.setAttribute('data-error','1');this.src='https://via.placeholder.com/300x200?text=Image+non+trouvée'}else{this.style.display='none'}">
                    <div class="gallery-info">
                        <h4>${img.titre}</h4>
                        <p>${img.description || ''}</p>
                        <button class="btn-icon btn-delete" onclick="deleteGalleryItem(${img.id})" style="float:right; color:red;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `}).join('');
        }
    } catch (error) {
        console.error('Erreur chargement galerie:', error);
    }
}

function setupGalleryForm() {
    const galerieForm = document.getElementById('galerieForm');
    const galImageInput = document.getElementById('gal_image');
    const galImageUrlInput = document.getElementById('gal_image_url');
    
    // Prévisualisation de l'image de la galerie
    galImageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            galImageUrlInput.value = ''; // Vider l'URL si un fichier est choisi
        }
    });

    galImageUrlInput.addEventListener('input', (e) => {
        if (e.target.value) {
            galImageInput.value = ''; // Vider le fichier si une URL est saisie
        }
    });
    
    galerieForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const titre = document.getElementById('gal_titre').value.trim();
        const imageFile = galImageInput.files[0];
        const imageUrl = galImageUrlInput.value.trim();
        
        // Validation
        if (!titre) {
            showToast('Le titre est requis', 'error');
            return;
        }
        
        if (!imageFile && !imageUrl) {
            showToast('Veuillez fournir une image (fichier ou URL)', 'error');
            return;
        }
        
        const formData = new FormData(galerieForm);
        formData.append('action', 'create');
        
        // Ajouter le token CSRF
        if (csrfToken) {
            formData.append('csrf_token', csrfToken);
        }

        try {
            const response = await fetch(GAL_API_URL, { 
                method: 'POST', 
                body: formData,
                credentials: 'same-origin'
            });
            const data = await response.json();
            if (data.success) {
                showToast('Image ajoutée à la galerie', 'success');
                galerieForm.reset();
                loadGallery();
            } else {
                showToast(data.message || 'Erreur lors de l\'ajout', 'error');
            }
        } catch (error) {
            console.error('Erreur:', error);
            showToast('Erreur de connexion', 'error');
        }
    });
}

async function deleteGalleryItem(id) {
    if (!confirm('Supprimer cette image ?')) return;
    try {
        const body = { 
            action: 'delete', 
            id: id 
        };
        
        // Ajouter le token CSRF
        if (csrfToken) {
            body.csrf_token = csrfToken;
        }
        
        const response = await fetch(GAL_API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(body),
            credentials: 'same-origin'
        });
        const data = await response.json();
        if (data.success) {
            showToast('Image supprimée');
            loadGallery();
        } else {
            showToast(data.message || 'Erreur', 'error');
        }
    } catch (error) {
        showToast('Erreur connexion', 'error');
    }
}


function setupLogout() {
    document.getElementById('logoutBtn').addEventListener('click', async () => {
        if (!confirm('Voulez-vous vraiment vous déconnecter ?')) return;

        try {
            await fetch('../api/logout.php', { 
                method: 'POST', 
                credentials: 'same-origin'
            });
        } catch (err) {
            console.error('Erreur lors de la déconnexion serveur', err);
        }

        // Redirection vers la page de login
        window.location.href = 'login.php';
    });
}


function setTodayDate() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date').value = today;
}


function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `toast ${type} show`;
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('fr-FR', options);
}

function getCategoryLabel(category) {
    // Les catégories viennent directement de la base de données
    return category || 'Sans catégorie';
}
