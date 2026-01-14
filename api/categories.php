<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
require_once '../config/db.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';
if (empty($action)) {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? 'getAll';
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
        $nom = $_POST['nom'] ?? '';
        if ($nom) {
            try {
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
        $id = $data['id'] ?? 0;
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