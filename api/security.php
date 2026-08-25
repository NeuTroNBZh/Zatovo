<?php
// api/security.php - Fonctions de sécurité réutilisables

/**
 * Vérifier que l'utilisateur est authentifié
 */
function requireAuth() {
    if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Authentification requise']);
        exit;
    }
    
    // Vérifier la durée de la session (timeout après 2 heures d'inactivité)
    $session_timeout = 7200; // 2 heures
    if (isset($_SESSION['admin_login_time'])) {
        if (time() - $_SESSION['admin_login_time'] > $session_timeout) {
            session_destroy();
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Session expirée']);
            exit;
        }
    }
    
    // Vérifier que l'IP et le user agent n'ont pas changé (protection contre session hijacking)
    if (isset($_SESSION['admin_ip']) && isset($_SESSION['admin_user_agent'])) {
        $current_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $current_ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        if ($_SESSION['admin_ip'] !== $current_ip || $_SESSION['admin_user_agent'] !== $current_ua) {
            session_destroy();
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Session invalide - détection de session hijacking']);
            exit;
        }
    }
    
    // Mettre à jour le timestamp de dernière activité
    $_SESSION['admin_login_time'] = time();
}

/**
 * Vérifier le token CSRF
 */
function validateCSRF($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Nettoyer et valider les données d'entrée
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Valider une URL
 */
function isValidUrl($url) {
    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return false;
    }
    // FILTER_VALIDATE_URL accepte "javascript://..." (schema suivi de //) -
    // on restreint explicitement aux schemas http/https pour eviter l'injection
    // de liens executant du JS (ex: dans un attribut href)
    $scheme = parse_url($url, PHP_URL_SCHEME);
    return in_array(strtolower((string) $scheme), ['http', 'https'], true);
}

/**
 * Valider un fichier uploadé
 */
function validateUploadedFile($file, $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'], $max_size = 5242880) {
    // Vérifier si le fichier existe et n'a pas d'erreur
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['valid' => false, 'error' => 'Paramètres invalides'];
    }
    
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            return ['valid' => false, 'error' => 'Fichier trop volumineux'];
        default:
            return ['valid' => false, 'error' => 'Erreur lors de l\'upload'];
    }
    
    // Vérifier la taille
    if ($file['size'] > $max_size) {
        return ['valid' => false, 'error' => 'Fichier trop volumineux (max 5MB)'];
    }
    
    // Vérifier le type MIME réel du fichier
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    
    if (!in_array($mime, $allowed_types)) {
        return ['valid' => false, 'error' => 'Type de fichier non autorisé'];
    }
    
    // Vérifier que c'est vraiment une image
    if (strpos($mime, 'image/') === 0) {
        if (!getimagesize($file['tmp_name'])) {
            return ['valid' => false, 'error' => 'Le fichier n\'est pas une image valide'];
        }
    }
    
    return ['valid' => true];
}

/**
 * Générer un nom de fichier sécurisé
 */
function generateSecureFilename($original_name) {
    $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!in_array($ext, $allowed_extensions)) {
        $ext = 'jpg';
    }
    
    return bin2hex(random_bytes(16)) . '.' . $ext;
}

/**
 * Ajouter les headers de sécurité
 */
function setSecurityHeaders() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Content-Security-Policy: default-src \'self\'; img-src \'self\' data: https:; style-src \'self\' \'unsafe-inline\' https://fonts.googleapis.com; font-src \'self\' https://fonts.gstatic.com;');
}
