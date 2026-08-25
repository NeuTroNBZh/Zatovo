<?php
// api/auth.php
session_start();

// Headers de sécurité
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Connexion à la base de données MySQL via PDO
require_once '../config/db.php';

// Protection contre le brute force - rate limiting
function checkRateLimit($username) {
    $max_attempts = 5;
    $lockout_time = 900; // 15 minutes
    
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }
    
    $now = time();
    $attempts = $_SESSION['login_attempts'];
    
    // Nettoyer les anciennes tentatives
    $attempts = array_filter($attempts, function($attempt) use ($now, $lockout_time) {
        return ($now - $attempt['time']) < $lockout_time;
    });
    
    // Compter les tentatives pour cet utilisateur
    $user_attempts = array_filter($attempts, function($attempt) use ($username) {
        return $attempt['username'] === $username;
    });
    
    if (count($user_attempts) >= $max_attempts) {
        return false;
    }
    
    return true;
}

function recordFailedAttempt($username) {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }
    $_SESSION['login_attempts'][] = [
        'username' => $username,
        'time' => time()
    ];
}

// Traiter la connexion
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Nom d\'utilisateur et mot de passe requis']);
    exit;
}

// Vérifier le rate limiting
if (!checkRateLimit($username)) {
    echo json_encode([
        'success' => false, 
        'message' => 'Trop de tentatives. Veuillez réessayer dans 15 minutes.',
        'locked' => true
    ]);
    exit;
}

// Vérifier les identifiants
try {
    $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE username = :username');
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Régénérer l'ID de session pour prévenir le session fixation
        session_regenerate_id(true);
        
        // Nettoyer les tentatives échouées
        unset($_SESSION['login_attempts']);
        
        // Crée une session serveur pour sécuriser l'accès au backoffice
        $_SESSION['admin_auth'] = true;
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_login_time'] = time();
        $_SESSION['admin_ip'] = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $_SESSION['admin_user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        // Générer un token CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        echo json_encode([
            'success' => true,
            'message' => 'Connexion réussie',
            'username' => $user['username'],
            'csrf_token' => $_SESSION['csrf_token']
        ]);
    } else {
        // Enregistrer la tentative échouée
        recordFailedAttempt($username);
        
        // Petit délai pour ralentir les attaques brute force
        sleep(1);
        
        echo json_encode([
            'success' => false,
            'message' => 'Nom d\'utilisateur ou mot de passe incorrect'
        ]);
    }
} catch (PDOException $e) {
    error_log('Erreur base de donnees (auth) : ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur, veuillez reessayer'
    ]);
}
?>
