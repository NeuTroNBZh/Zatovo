<?php
session_start();

header('Content-Type: application/json');
require_once '../config/db.php';
require_once 'security.php';

setSecurityHeaders();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
if (empty($action)) {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? 'getAll';
}

// Les actions de modification nécessitent une authentification
$protected_actions = ['create', 'delete'];
if (in_array($action, $protected_actions)) {
    requireAuth();
    
    // Vérifier le token CSRF
    $csrf_token = $_POST['csrf_token'] ?? $input['csrf_token'] ?? '';
    if (!validateCSRF($csrf_token)) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Token CSRF invalide']);
        exit;
    }
}

switch ($action) {
    case 'getAll':
        try {
            $stmt = $pdo->query("SELECT * FROM galerie ORDER BY created_at DESC");
            echo json_encode(['success' => true, 'images' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
        
    case 'create':
        $titre = sanitizeInput($_POST['titre'] ?? '');
        $description = sanitizeInput($_POST['description'] ?? '');
        $imageUrl = trim($_POST['image_url'] ?? '');
        
        // Validation du titre
        if (empty($titre)) {
            echo json_encode(['success' => false, 'message' => 'Le titre est requis']);
            exit;
        }
        
        // Valider l'URL si fournie
        if (!empty($imageUrl) && !isValidUrl($imageUrl)) {
            echo json_encode(['success' => false, 'message' => 'URL de l\'image invalide']);
            exit;
        }
        
        $imagePath = '';
        
        // Priorité 1: Upload de fichier
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Valider le fichier
            $validation = validateUploadedFile($_FILES['image']);
            if (!$validation['valid']) {
                echo json_encode(['success' => false, 'message' => $validation['error']]);
                exit;
            }
            
            $uploadDir = '../uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $filename = generateSecureFilename($_FILES['image']['name']);
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                $imagePath = 'uploads/' . $filename;
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors du téléchargement du fichier']);
                exit;
            }
        }
        // Priorité 2: URL fournie
        elseif (!empty($imageUrl)) {
            $imagePath = $imageUrl;
        }
        // Aucune image fournie
        else {
            echo json_encode(['success' => false, 'message' => 'Veuillez fournir une image (fichier ou URL)']);
            exit;
        }

        // Insertion dans la base de données
        try {
            $stmt = $pdo->prepare("INSERT INTO galerie (titre, description, image) VALUES (?, ?, ?)");
            if ($stmt->execute([$titre, $description, $imagePath])) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Image ajoutée avec succès',
                    'id' => $pdo->lastInsertId()
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'insertion dans la base de données']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur SQL: ' . $e->getMessage()]);
        }
        break;
        
    case 'delete':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;
        if ($id) {
            try {
                // Get image path to delete file
                $stmt = $pdo->prepare("SELECT image FROM galerie WHERE id = ?");
                $stmt->execute([$id]);
                $img = $stmt->fetchColumn();
                
                $stmt = $pdo->prepare("DELETE FROM galerie WHERE id = ?");
                if ($stmt->execute([$id])) {
                    if ($img && file_exists('../' . $img) && strpos($img, 'uploads/') === 0) {
                        unlink('../' . $img);
                    }
                    echo json_encode(['success' => true, 'message' => 'Image supprimée avec succès']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
                }
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'Erreur SQL: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID requis pour la suppression']);
        }
        break;
}
?>