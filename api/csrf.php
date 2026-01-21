<?php
// api/csrf.php - Endpoint pour récupérer le token CSRF
session_start();

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

// Vérifier que l'utilisateur est authentifié
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit;
}

// S'assurer qu'un token CSRF existe
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

echo json_encode([
    'success' => true,
    'csrf_token' => $_SESSION['csrf_token']
]);
