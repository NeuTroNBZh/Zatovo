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
            $stmt = $pdo->query("SELECT * FROM galerie ORDER BY created_at DESC");
            echo json_encode(['success' => true, 'images' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
        
    case 'create':
        $titre = $_POST['titre'] ?? '';
        $description = $_POST['description'] ?? '';
        $imageUrl = $_POST['image_url'] ?? '';
        
        $imagePath = $imageUrl;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (in_array($_FILES['image']['type'], $allowedTypes)) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('galerie_', true) . '.' . $ext;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                    $imagePath = 'uploads/' . $filename;
                }
            }
        }

        if ($titre && $imagePath) {
            try {
                $stmt = $pdo->prepare("INSERT INTO galerie (titre, description, image) VALUES (?, ?, ?)");
                if ($stmt->execute([$titre, $description, $imagePath])) {
                    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de la création de l\'image dans la galerie']);
                }
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'Erreur SQL: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Titre et image (ou URL) requis']);
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