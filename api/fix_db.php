<?php
require_once '../config/db.php';

try {
    echo "Correction de la base de données en cours...<br>";

    // 1. Modifier la colonne 'image' de la table 'actualites' pour accepter des textes longs (URLs)
    $pdo->exec("ALTER TABLE actualites MODIFY COLUMN image TEXT");
    echo "✅ Colonne 'image' de la table 'actualites' modifiée en TEXT.<br>";

    // 2. Modifier la colonne 'image' de la table 'galerie' pour accepter des textes longs
    $pdo->exec("ALTER TABLE galerie MODIFY COLUMN image TEXT");
    echo "✅ Colonne 'image' de la table 'galerie' modifiée en TEXT.<br>";

    echo "<strong>Succès ! Les problèmes de longueur d'URL sont corrigés.</strong>";

} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>
