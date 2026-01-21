<?php
/**
 * Script pour créer un nouvel administrateur
 * Usage: php create_admin.php
 */

require_once 'config/db.php';

echo "=== Création d'un nouvel administrateur ===\n\n";

// Demander le nom d'utilisateur
echo "Nom d'utilisateur: ";
$username = trim(fgets(STDIN));

if (empty($username)) {
    die("❌ Le nom d'utilisateur ne peut pas être vide.\n");
}

// Vérifier si l'utilisateur existe déjà
$stmt = $pdo->prepare('SELECT id FROM admin_users WHERE username = ?');
$stmt->execute([$username]);
if ($stmt->fetch()) {
    die("❌ Un utilisateur avec ce nom existe déjà.\n");
}

// Demander le mot de passe
echo "Mot de passe: ";
$password = trim(fgets(STDIN));

if (strlen($password) < 8) {
    die("❌ Le mot de passe doit contenir au moins 8 caractères.\n");
}

// Demander confirmation
echo "Confirmer le mot de passe: ";
$password_confirm = trim(fgets(STDIN));

if ($password !== $password_confirm) {
    die("❌ Les mots de passe ne correspondent pas.\n");
}

// Hacher le mot de passe
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insérer dans la base de données
try {
    $stmt = $pdo->prepare('INSERT INTO admin_users (username, password, created_at) VALUES (?, ?, NOW())');
    $stmt->execute([$username, $hashed_password]);
    
    echo "\n✅ Administrateur créé avec succès!\n";
    echo "   Username: $username\n";
    echo "   ID: " . $pdo->lastInsertId() . "\n";
} catch (PDOException $e) {
    echo "\n❌ Erreur lors de la création: " . $e->getMessage() . "\n";
}
