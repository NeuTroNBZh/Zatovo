<?php
/**
 * Test d'upload sécurisé - API Backend
 * Utilisé par test-permissions.html
 */

header('Content-Type: application/json');
require_once __DIR__ . '/api/security.php';

$action = $_POST['action'] ?? '';

if ($action === 'test_upload') {
    // Test d'upload d'une image
    if (!isset($_FILES['test_image'])) {
        echo json_encode(['success' => false, 'message' => 'Aucun fichier reçu']);
        exit;
    }
    
    $file = $_FILES['test_image'];
    
    // Valider le fichier
    $validation = validateUploadedFile($file);
    
    if (!$validation['valid']) {
        echo json_encode([
            'success' => false, 
            'message' => $validation['error']
        ]);
        exit;
    }
    
    // Vérifier que le répertoire uploads est accessible
    $uploadDir = __DIR__ . '/uploads/';
    
    if (!is_writable($uploadDir)) {
        echo json_encode([
            'success' => false,
            'message' => 'Le répertoire uploads n\'est pas accessible en écriture. Permissions actuelles : ' . substr(sprintf('%o', fileperms($uploadDir)), -3)
        ]);
        exit;
    }
    
    // Générer un nom sécurisé
    $filename = 'test_' . generateSecureFilename($file['name']);
    $destination = $uploadDir . $filename;
    
    // Tenter de déplacer le fichier
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        // Succès - nettoyer le fichier de test
        chmod($destination, 0664);
        unlink($destination); // Supprimer le fichier de test
        
        echo json_encode([
            'success' => true,
            'message' => 'Le serveur peut écrire dans uploads/. Permissions OK !'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Impossible de déplacer le fichier. Vérifiez les permissions et le propriétaire du répertoire.'
        ]);
    }
    
} elseif ($action === 'test_rejection') {
    // Test de rejet d'un fichier non autorisé
    if (!isset($_FILES['test_file'])) {
        echo json_encode(['success' => false, 'message' => 'Aucun fichier reçu']);
        exit;
    }
    
    $file = $_FILES['test_file'];
    
    // Valider le fichier
    $validation = validateUploadedFile($file);
    
    if (!$validation['valid']) {
        // C'est ce qu'on veut ! Le fichier doit être rejeté
        echo json_encode([
            'success' => false,
            'rejected' => true,
            'message' => $validation['error']
        ]);
    } else {
        // Problème : le fichier non autorisé a été accepté
        echo json_encode([
            'success' => true,
            'rejected' => false,
            'message' => 'ATTENTION : Le fichier a été accepté alors qu\'il ne devrait pas !'
        ]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Action invalide']);
}
