<?php
/**
 * Script d'initialisation de la base de données
 * Ce fichier crée toutes les tables nécessaires pour le site
 * 
 * Pour exécuter ce script : accédez à setup.php via votre navigateur
 * ou exécutez : php setup.php
 */

// Configuration de la base de données
$host = 'localhost';
$dbname = 'test_db';
$username = 'test_user';
$password = 'Test123!';

// Connexion sans spécifier de base de données pour pouvoir la créer si nécessaire
try {
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Connexion au serveur MySQL réussie<br>\n";
    
    // Créer la base de données si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Base de données '$dbname' créée ou déjà existante<br>\n";
    
    // Se connecter à la base de données
    $pdo->exec("USE `$dbname`");
    
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage() . "<br>\n");
}

// Liste des requêtes SQL pour créer les tables
$queries = [
    // Table des utilisateurs admin
    'admin_users' => "
        CREATE TABLE IF NOT EXISTS `admin_users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(100) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX `idx_username` (`username`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ",
    
    // Table des catégories
    'categories' => "
        CREATE TABLE IF NOT EXISTS `categories` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `nom` VARCHAR(100) NOT NULL UNIQUE,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX `idx_nom` (`nom`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ",
    
    // Table des actualités
    'actualites' => "
        CREATE TABLE IF NOT EXISTS `actualites` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `titre` VARCHAR(255) NOT NULL,
            `auteur` VARCHAR(100) NOT NULL,
            `date` DATE NOT NULL,
            `texte` TEXT NOT NULL,
            `image` VARCHAR(500) NOT NULL,
            `lien` VARCHAR(500) DEFAULT NULL,
            `categorie` VARCHAR(100) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_date` (`date` DESC),
            INDEX `idx_categorie` (`categorie`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ",
    
    // Table de la galerie
    'galerie' => "
        CREATE TABLE IF NOT EXISTS `galerie` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `titre` VARCHAR(255) NOT NULL,
            `description` TEXT DEFAULT NULL,
            `image` VARCHAR(500) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX `idx_created` (`created_at` DESC)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    "
];

// Créer les tables
foreach ($queries as $tableName => $sql) {
    try {
        $pdo->exec($sql);
        echo "✓ Table '$tableName' créée avec succès<br>\n";
    } catch (PDOException $e) {
        echo "❌ Erreur lors de la création de la table '$tableName': " . $e->getMessage() . "<br>\n";
    }
}

echo "<br>\n<strong>Insertion des données par défaut...</strong><br>\n<br>\n";

// Insérer un utilisateur admin par défaut (mot de passe: admin123)
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE username = 'admin'");
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password, email) VALUES (?, ?, ?)");
        $stmt->execute(['admin', $hashedPassword, 'admin@example.com']);
        echo "✓ Utilisateur admin créé (username: admin, password: admin123)<br>\n";
    } else {
        echo "ℹ️ Utilisateur admin existe déjà<br>\n";
    }
} catch (PDOException $e) {
    echo "❌ Erreur lors de la création de l'utilisateur admin: " . $e->getMessage() . "<br>\n";
}

// Insérer des catégories par défaut
$defaultCategories = ['Actualité', 'Événement', 'Annonce', 'Info'];
foreach ($defaultCategories as $catName) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE nom = ?");
        $stmt->execute([$catName]);
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            $stmt = $pdo->prepare("INSERT INTO categories (nom) VALUES (?)");
            $stmt->execute([$catName]);
            echo "✓ Catégorie '$catName' créée<br>\n";
        } else {
            echo "ℹ️ Catégorie '$catName' existe déjà<br>\n";
        }
    } catch (PDOException $e) {
        echo "❌ Erreur lors de la création de la catégorie '$catName': " . $e->getMessage() . "<br>\n";
    }
}

// Insérer des actualités d'exemple
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM actualites");
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $exampleArticles = [
            [
                'titre' => 'Bienvenue sur notre site',
                'auteur' => 'Admin',
                'date' => date('Y-m-d'),
                'texte' => 'Bienvenue sur notre nouveau site web ! Vous trouverez ici toutes les dernières actualités et informations importantes.',
                'image' => 'https://via.placeholder.com/800x400?text=Bienvenue',
                'lien' => '',
                'categorie' => 'Annonce'
            ],
            [
                'titre' => 'Première actualité',
                'auteur' => 'Admin',
                'date' => date('Y-m-d', strtotime('-1 day')),
                'texte' => 'Ceci est un exemple d\'actualité. Vous pouvez modifier ou supprimer cet article depuis l\'interface d\'administration.',
                'image' => 'https://via.placeholder.com/800x400?text=Actualité',
                'lien' => '',
                'categorie' => 'Actualité'
            ]
        ];
        
        $stmt = $pdo->prepare("INSERT INTO actualites (titre, auteur, date, texte, image, lien, categorie) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        foreach ($exampleArticles as $article) {
            $stmt->execute([
                $article['titre'],
                $article['auteur'],
                $article['date'],
                $article['texte'],
                $article['image'],
                $article['lien'],
                $article['categorie']
            ]);
        }
        
        echo "✓ Articles d'exemple créés<br>\n";
    } else {
        echo "ℹ️ Des actualités existent déjà<br>\n";
    }
} catch (PDOException $e) {
    echo "❌ Erreur lors de la création des articles: " . $e->getMessage() . "<br>\n";
}

// Insérer des images d'exemple dans la galerie
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM galerie");
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $exampleImages = [
            [
                'titre' => 'Image 1',
                'description' => 'Description de la première image',
                'image' => 'https://via.placeholder.com/600x400?text=Image+1'
            ],
            [
                'titre' => 'Image 2',
                'description' => 'Description de la deuxième image',
                'image' => 'https://via.placeholder.com/600x400?text=Image+2'
            ],
            [
                'titre' => 'Image 3',
                'description' => 'Description de la troisième image',
                'image' => 'https://via.placeholder.com/600x400?text=Image+3'
            ]
        ];
        
        $stmt = $pdo->prepare("INSERT INTO galerie (titre, description, image) VALUES (?, ?, ?)");
        
        foreach ($exampleImages as $img) {
            $stmt->execute([
                $img['titre'],
                $img['description'],
                $img['image']
            ]);
        }
        
        echo "✓ Images d'exemple créées dans la galerie<br>\n";
    } else {
        echo "ℹ️ Des images existent déjà dans la galerie<br>\n";
    }
} catch (PDOException $e) {
    echo "❌ Erreur lors de la création des images: " . $e->getMessage() . "<br>\n";
}

echo "<br>\n<hr><br>\n";
echo "<strong style='color: green;'>🎉 Installation terminée avec succès !</strong><br>\n<br>\n";
echo "<strong>Informations de connexion :</strong><br>\n";
echo "• URL Admin: <a href='admin/index.php'>admin/index.php</a><br>\n";
echo "• Username: <strong>admin</strong><br>\n";
echo "• Password: <strong>admin123</strong><br>\n<br>\n";
echo "<strong>⚠️ Important :</strong> Pour des raisons de sécurité, pensez à :<br>\n";
echo "1. Changer le mot de passe admin par défaut<br>\n";
echo "2. Supprimer ou sécuriser ce fichier setup.php après l'installation<br>\n<br>\n";
echo "<a href='index.php'>← Retour à l'accueil</a> | ";
echo "<a href='admin/index.php'>Accéder à l'administration →</a><br>\n";
?>
