<?php
// install.php
require_once 'config/db.php';

try {
    // Création de la table actualites
    $sqlActualites = "CREATE TABLE IF NOT EXISTS actualites (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(255) NOT NULL,
        auteur VARCHAR(100) NOT NULL,
        date DATE NOT NULL,
        texte TEXT NOT NULL,
        image VARCHAR(255),
        lien VARCHAR(255),
        categorie VARCHAR(50) NOT NULL
    )";
    $pdo->exec($sqlActualites);
    echo "Table 'actualites' créée ou déjà existante.<br>";

    // Création de la table admin_users
    $sqlAdmin = "CREATE TABLE IF NOT EXISTS admin_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )";
    $pdo->exec($sqlAdmin);
    echo "Table 'admin_users' créée ou déjà existante.<br>";

    // Création de l'admin par défaut
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE username = ?");
    $stmt->execute(['admin']);
    if ($stmt->fetchColumn() == 0) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
        $stmt->execute(['admin', $password]);
        echo "Utilisateur admin par défaut créé (admin / admin123).<br>";
    } else {
        echo "L'utilisateur admin existe déjà.<br>";
    }

    echo "Installation terminée avec succès !";

} catch (PDOException $e) {
    die("Erreur lors de l'installation : " . $e->getMessage());
}
?>