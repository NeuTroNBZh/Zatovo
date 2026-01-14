<?php
// api/actualites.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Connexion à la base de données MySQL via PDO
require_once '../config/db.php';

// Récupérer l'action
$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Si l'action est vide, vérifier le flux d'entrée JSON (pour les requêtes DELETE par exemple)
if (empty($action)) {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? 'getAll';
}

switch ($action) {
    case 'getAll':
        getAllArticles();
        break;
    
    case 'getOne':
        getOneArticle();
        break;
    
    case 'create':
        createArticle();
        break;
    
    case 'update':
        updateArticle();
        break;
    
    case 'delete':
        deleteArticle();
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Action invalide']);
}

// Récupérer tous les articles
function getAllArticles() {
    global $pdo;
    
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
    $filter = $_GET['filter'] ?? 'all';
    $offset = ($page - 1) * $limit;
    
    // Construire la requête
    $whereClause = "";
    $params = [];
    
    if ($filter !== 'all') {
        $whereClause = "WHERE categorie = :categorie";
        $params[':categorie'] = $filter;
    }
    
    // Compter le total
    $countQuery = "SELECT COUNT(*) as total FROM actualites $whereClause";
    $stmtCount = $pdo->prepare($countQuery);
    $stmtCount->execute($params);
    $total = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Récupérer les articles
    // Note: PDO a parfois du mal avec LIMIT/OFFSET en paramètres liés selon la config, 
    // donc on les injecte directement car ils sont castés en (int) ci-dessus (sécurisé).
    $query = "SELECT * FROM actualites $whereClause ORDER BY date DESC, id DESC LIMIT $limit OFFSET $offset";
    $stmt = $pdo->prepare($query);
    
    // Bind des paramètres du WHERE s'il y en a
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'articles' => $articles,
        'total' => $total,
        'totalPages' => ceil($total / $limit),
        'currentPage' => (int)$page
    ]);
}

// Récupérer un article
function getOneArticle() {
    global $pdo;
    
    $id = $_GET['id'] ?? 0;
    
    $stmt = $pdo->prepare('SELECT * FROM actualites WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($article) {
        echo json_encode(['success' => true, 'article' => $article]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Article non trouvé']);
    }
}

// Créer un article
function createArticle() {
    global $pdo;
    
    $titre = $_POST['titre'] ?? '';
    $auteur = $_POST['auteur'] ?? '';
    $date = $_POST['date'] ?? '';
    $texte = $_POST['texte'] ?? '';
    $lien = $_POST['lien'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $imageUrl = $_POST['image_url'] ?? '';
    
    // Validation
    if (empty($titre) || empty($auteur) || empty($date) || empty($texte) || empty($categorie)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs obligatoires doivent être remplis']);
        return;
    }
    
    // Gestion de l'image (Upload ou URL)
    $imagePath = $imageUrl; // Par défaut, on prend l'URL si fournie
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadedPath = uploadImage($_FILES['image']);
        if ($uploadedPath) {
            $imagePath = $uploadedPath;
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload de l\'image']);
            return;
        }
    }

    if (empty($imagePath)) {
        echo json_encode(['success' => false, 'message' => 'Une image (fichier ou lien) est requise']);
        return;
    }
    
    // Insérer dans la base de données
    try {
        $stmt = $pdo->prepare('INSERT INTO actualites (titre, auteur, date, texte, image, lien, categorie) VALUES (:titre, :auteur, :date, :texte, :image, :lien, :categorie)');
        $stmt->bindValue(':titre', $titre);
        $stmt->bindValue(':auteur', $auteur);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':texte', $texte);
        $stmt->bindValue(':image', $imagePath);
        $stmt->bindValue(':lien', $lien);
        $stmt->bindValue(':categorie', $categorie);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Article créé avec succès', 'id' => $pdo->lastInsertId()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la création de l\'article']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur SQL: ' . $e->getMessage()]);
    }
}

// Mettre à jour un article
function updateArticle() {
    global $pdo;
    
    $id = $_POST['id'] ?? 0;
    $titre = $_POST['titre'] ?? '';
    $auteur = $_POST['auteur'] ?? '';
    $date = $_POST['date'] ?? '';
    $texte = $_POST['texte'] ?? '';
    $lien = $_POST['lien'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $imageUrl = $_POST['image_url'] ?? '';
    
    // Validation
    if (empty($id) || empty($titre) || empty($auteur) || empty($date) || empty($texte) || empty($categorie)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs obligatoires doivent être remplis']);
        return;
    }
    
    // Récupérer l'ancienne image
    $stmt = $pdo->prepare('SELECT image FROM actualites WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $oldImage = $result['image'] ?? '';
    
    // Gestion de l'image
    $imagePath = $oldImage;
    
    // Si une URL est fournie et différente de l'ancienne image (et ce n'est pas un upload local qui va écraser)
    if (!empty($imageUrl)) {
        $imagePath = $imageUrl;
    }
    
    // Si un fichier est uploadé, il est prioritaire
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $newImagePath = uploadImage($_FILES['image']);
        if ($newImagePath) {
            $imagePath = $newImagePath;
            // Supprimer l'ancienne image si c'était un fichier local
            if ($oldImage && file_exists('../' . $oldImage) && strpos($oldImage, 'uploads/') === 0) {
                unlink('../' . $oldImage);
            }
        }
    }
    
    // Mettre à jour dans la base de données
    try {
        $stmt = $pdo->prepare('UPDATE actualites SET titre = :titre, auteur = :auteur, date = :date, texte = :texte, image = :image, lien = :lien, categorie = :categorie WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':titre', $titre);
        $stmt->bindValue(':auteur', $auteur);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':texte', $texte);
        $stmt->bindValue(':image', $imagePath);
        $stmt->bindValue(':lien', $lien);
        $stmt->bindValue(':categorie', $categorie);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Article mis à jour avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour de l\'article']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur SQL: ' . $e->getMessage()]);
    }
}

// Supprimer un article
function deleteArticle() {
    global $pdo;
    
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID manquant']);
        return;
    }
    
    // Récupérer l'image pour la supprimer
    $stmt = $pdo->prepare('SELECT image FROM actualites WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $image = $result['image'] ?? '';
    
    // Supprimer de la base de données
    $stmt = $pdo->prepare('DELETE FROM actualites WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Supprimer l'image
        if ($image && file_exists('../' . $image)) {
            unlink('../' . $image);
        }
        echo json_encode(['success' => true, 'message' => 'Article supprimé avec succès']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression de l\'article']);
    }
}

// Fonction pour uploader une image
function uploadImage($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    // Vérifier le type
    if (!in_array($file['type'], $allowedTypes)) {
        // Log error for debugging
        error_log("Type de fichier non autorisé: " . $file['type']);
        return false;
    }
    
    // Vérifier la taille
    if ($file['size'] > $maxSize) {
        error_log("Fichier trop volumineux: " . $file['size']);
        return false;
    }
    
    // Créer le dossier uploads s'il n'existe pas
    $uploadDir = '../uploads/';
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            error_log("Impossible de créer le dossier uploads");
            return false;
        }
    }
    
    // Générer un nom unique
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('article_', true) . '.' . $extension;
    
    // Retour aux chemins relatifs
    $uploadDir = '../uploads/';
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            error_log("Impossible de créer le dossier uploads");
            return false;
        }
    }
    
    $filepath = $uploadDir . $filename;
    
    // Déplacer le fichier
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return 'uploads/' . $filename;
    } else {
        error_log("Erreur lors du déplacement du fichier uploadé vers " . $filepath);
    }
    
    return false;
}
?>
