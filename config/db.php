<?php
// config/db.php

// Configuration de la base de données
$host = 'localhost';
$dbname = 'REDACTED_DB';
$username = 'root';
$password = 'REDACTED'; // Mettez votre mot de passe ici si nécessaire (souvent 'root' ou vide)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Activer les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>