<?php
/**
 * Test de configuration du serveur pour les uploads
 * Accédez à ce fichier via votre navigateur pour vérifier la configuration
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Configuration Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .test-box {
            background: white;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        h1 { color: #333; }
        h2 { color: #666; font-size: 18px; margin-top: 0; }
        code { 
            background: #f0f0f0; 
            padding: 2px 6px; 
            border-radius: 3px;
            font-family: monospace;
        }
        .icon { font-size: 20px; margin-right: 10px; }
    </style>
</head>
<body>
    <h1>🔍 Test de Configuration - Upload de Fichiers</h1>
    
    <div class="test-box">
        <h2>📁 Dossier uploads/</h2>
        <?php
        $uploadDir = __DIR__ . '/uploads/';
        if (file_exists($uploadDir)) {
            echo '<p class="success"><span class="icon">✓</span>Le dossier existe</p>';
            
            if (is_writable($uploadDir)) {
                echo '<p class="success"><span class="icon">✓</span>Le dossier est accessible en écriture</p>';
            } else {
                echo '<p class="error"><span class="icon">✗</span>Le dossier n\'est PAS accessible en écriture</p>';
                echo '<p>Exécutez: <code>chmod 777 ' . $uploadDir . '</code></p>';
            }
            
            echo '<p>Chemin: <code>' . $uploadDir . '</code></p>';
        } else {
            echo '<p class="error"><span class="icon">✗</span>Le dossier n\'existe pas</p>';
            echo '<p>Création automatique...</p>';
            if (mkdir($uploadDir, 0777, true)) {
                echo '<p class="success"><span class="icon">✓</span>Dossier créé avec succès</p>';
            } else {
                echo '<p class="error"><span class="icon">✗</span>Impossible de créer le dossier</p>';
            }
        }
        ?>
    </div>

    <div class="test-box">
        <h2>⚙️ Configuration PHP</h2>
        <?php
        $fileUploads = ini_get('file_uploads');
        $uploadMaxFilesize = ini_get('upload_max_filesize');
        $postMaxSize = ini_get('post_max_size');
        $maxExecutionTime = ini_get('max_execution_time');
        $memoryLimit = ini_get('memory_limit');
        ?>
        
        <p><strong>file_uploads:</strong> 
            <?php 
            if ($fileUploads) {
                echo '<span class="success">✓ Activé</span>';
            } else {
                echo '<span class="error">✗ Désactivé</span>';
            }
            ?>
        </p>
        
        <p><strong>upload_max_filesize:</strong> <code><?php echo $uploadMaxFilesize; ?></code>
            <?php
            if (intval($uploadMaxFilesize) < 5) {
                echo ' <span class="warning">⚠️ Trop petit (recommandé: 5M minimum)</span>';
            }
            ?>
        </p>
        
        <p><strong>post_max_size:</strong> <code><?php echo $postMaxSize; ?></code>
            <?php
            if (intval($postMaxSize) < 6) {
                echo ' <span class="warning">⚠️ Trop petit (recommandé: 6M minimum)</span>';
            }
            ?>
        </p>
        
        <p><strong>max_execution_time:</strong> <code><?php echo $maxExecutionTime; ?>s</code></p>
        <p><strong>memory_limit:</strong> <code><?php echo $memoryLimit; ?></code></p>
    </div>

    <div class="test-box">
        <h2>🗄️ Base de données</h2>
        <?php
        try {
            require_once __DIR__ . '/config/db.php';
            echo '<p class="success"><span class="icon">✓</span>Connexion à la base de données réussie</p>';
            
            // Vérifier les tables
            $tables = ['actualites', 'galerie', 'categories', 'admin_users'];
            foreach ($tables as $table) {
                $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
                if ($stmt->rowCount() > 0) {
                    echo '<p class="success"><span class="icon">✓</span>Table <code>' . $table . '</code> existe</p>';
                } else {
                    echo '<p class="error"><span class="icon">✗</span>Table <code>' . $table . '</code> manquante</p>';
                }
            }
        } catch (Exception $e) {
            echo '<p class="error"><span class="icon">✗</span>Erreur: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        ?>
    </div>

    <div class="test-box">
        <h2>🔐 Sécurité</h2>
        <p class="warning"><span class="icon">⚠️</span><strong>Important:</strong> Supprimez ce fichier après vos tests !</p>
        <p>Ce fichier révèle des informations sur votre configuration serveur.</p>
    </div>

    <div class="test-box">
        <h2>🚀 Étapes suivantes</h2>
        <ol>
            <li>Si tout est vert ci-dessus, accédez à <a href="setup.php">setup.php</a> pour initialiser la base de données</li>
            <li>Connectez-vous à l'admin: <a href="admin/index.php">admin/index.php</a></li>
            <li>Utilisez les identifiants par défaut: <code>admin</code> / <code>admin123</code></li>
            <li>Changez le mot de passe après la première connexion</li>
            <li>Supprimez ce fichier de test: <code>rm test-upload.php</code></li>
        </ol>
    </div>

    <p style="text-align: center; margin-top: 30px;">
        <a href="index.php" style="text-decoration: none; color: #007bff;">← Retour au site</a> |
        <a href="admin/index.php" style="text-decoration: none; color: #007bff;">Administration →</a>
    </p>
</body>
</html>
