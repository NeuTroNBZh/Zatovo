<?php
require_once '../config/db.php';

try {
    // Create categories table
    $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(50) NOT NULL UNIQUE
    )");
    
    // Insert default categories if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM categories");
    if ($stmt->fetchColumn() == 0) {
        $cats = ['evenement', 'projet', 'reussite', 'autre'];
        $stmt = $pdo->prepare("INSERT INTO categories (nom) VALUES (?)");
        foreach ($cats as $cat) {
            $stmt->execute([$cat]);
        }
        echo "Categories created.<br>";
    }

    // Create galerie table
    $pdo->exec("CREATE TABLE IF NOT EXISTS galerie (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(100) NOT NULL,
        description TEXT,
        image VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Galerie table created.<br>";

    // Add image_url column to actualites if not exists
    $stmt = $pdo->query("SHOW COLUMNS FROM actualites LIKE 'image_url'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE actualites ADD COLUMN image_url VARCHAR(255) AFTER image");
        echo "Column image_url added to actualites.<br>";
    }

    echo "Database updated successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>