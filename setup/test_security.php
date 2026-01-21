<?php
/**
 * Script de test de sécurité
 * Vérifie que toutes les protections sont en place
 */

echo "=== Test de Sécurité du Site Zatovo ===\n\n";

$tests_passed = 0;
$tests_failed = 0;

function test($name, $condition, $message) {
    global $tests_passed, $tests_failed;
    
    if ($condition) {
        echo "✅ $name\n";
        $tests_passed++;
    } else {
        echo "❌ $name: $message\n";
        $tests_failed++;
    }
}

// Test 1: Vérifier que security.php existe
test(
    "Fichier security.php",
    file_exists(__DIR__ . '/../api/security.php'),
    "Le fichier api/security.php n'existe pas"
);

// Test 2: Vérifier que csrf.php existe
test(
    "Fichier csrf.php",
    file_exists(__DIR__ . '/../api/csrf.php'),
    "Le fichier api/csrf.php n'existe pas"
);

// Test 3: Vérifier les .htaccess
test(
    ".htaccess admin",
    file_exists(__DIR__ . '/../admin/.htaccess'),
    "Le fichier admin/.htaccess n'existe pas"
);

test(
    ".htaccess uploads",
    file_exists(__DIR__ . '/../uploads/.htaccess'),
    "Le fichier uploads/.htaccess n'existe pas"
);

test(
    ".htaccess racine",
    file_exists(__DIR__ . '/../.htaccess'),
    "Le fichier .htaccess racine n'existe pas"
);

// Test 4: Vérifier les permissions du répertoire uploads
$uploads_perms = fileperms(__DIR__ . '/../uploads');
test(
    "Permissions uploads",
    ($uploads_perms & 0777) <= 0775,
    "Les permissions du répertoire uploads sont trop permissives (max: 775)"
);

// Test 5: Vérifier que session_start est présent dans les API
$auth_content = file_get_contents(__DIR__ . '/../api/auth.php');
test(
    "Session dans auth.php",
    strpos($auth_content, 'session_start()') !== false,
    "session_start() non trouvé dans auth.php"
);

// Test 6: Vérifier que les API utilisent requireAuth
$actualites_content = file_get_contents(__DIR__ . '/../api/actualites.php');
test(
    "Protection actualites.php",
    strpos($actualites_content, 'requireAuth()') !== false,
    "requireAuth() non trouvé dans actualites.php"
);

// Test 7: Vérifier que CORS * n'est plus présent
test(
    "CORS sécurisé",
    strpos($auth_content, 'Access-Control-Allow-Origin: *') === false,
    "CORS trop permissif détecté"
);

// Test 8: Vérifier que password_verify est utilisé
test(
    "Vérification de mot de passe",
    strpos($auth_content, 'password_verify') !== false,
    "password_verify() non trouvé dans auth.php"
);

// Test 9: Vérifier que PDO est en mode exception
require_once __DIR__ . '/../config/db.php';
test(
    "PDO en mode exception",
    $pdo->getAttribute(PDO::ATTR_ERRMODE) === PDO::ERRMODE_EXCEPTION,
    "PDO n'est pas configuré en mode exception"
);

// Test 10: Vérifier que la table admin_users existe
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'admin_users'");
    $table_exists = $stmt->rowCount() > 0;
    test(
        "Table admin_users",
        $table_exists,
        "La table admin_users n'existe pas"
    );
} catch (PDOException $e) {
    test("Table admin_users", false, $e->getMessage());
}

// Résumé
echo "\n" . str_repeat("=", 50) . "\n";
echo "Tests réussis: $tests_passed\n";
echo "Tests échoués: $tests_failed\n";

if ($tests_failed === 0) {
    echo "\n🎉 Tous les tests de sécurité sont passés!\n";
    exit(0);
} else {
    echo "\n⚠️  Certains tests ont échoué. Veuillez corriger les problèmes.\n";
    exit(1);
}
