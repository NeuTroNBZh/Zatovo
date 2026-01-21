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
            $stmt = $pdo->query("SELECT * FROM categories ORDER BY nom");
            echo json_encode(['success' => true, 'categories' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
        
    case 'create':
        $nom = sanitizeInput($_POST['nom'] ?? '');
        if ($nom) {
            // Vérifier que la catégorie n'existe pas déjà
            try {
                $check = $pdo->prepare("SELECT id FROM categories WHERE nom = ?");
                $check->execute([$nom]);
                if ($check->fetch()) {
                    echo json_encode(['success' => false, 'message' => 'Cette catégorie existe déjà']);
                    exit;
                }
                
                $stmt = $pdo->prepare("INSERT INTO categories (nom) VALUES (?)");
                if ($stmt->execute([$nom])) {
                    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId(), 'nom' => $nom]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur création']);
                }
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Nom requis']);
        }
        break;
        
    case 'delete':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = (int)($data['id'] ?? 0);
        if ($id) {
            try {
                $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
                if ($stmt->execute([$id])) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur suppression']);
                }
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID requis']);
        }
        break;
}
?>