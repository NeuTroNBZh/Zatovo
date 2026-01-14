<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Zatovo</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon & Icons -->
    <link rel="icon" type="image/svg+xml" href="../images/favicon.svg">
    <link rel="alternate icon" type="image/x-icon" href="../images/favicon.ico">
    <link rel="apple-touch-icon" href="../images/apple-touch-icon.png">
    <link rel="manifest" href="../images/site.webmanifest">
    <meta name="theme-color" content="#ffffff">
</head>
<body class="admin-body">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <img src="../images/LOGO_Zatovo.png" alt="Association Zatovo - Administration" class="login-logo" loading="lazy">
            </div>
            <form id="loginForm" class="login-form">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-login">Se connecter</button>
                </div>
                <div id="errorMessage" class="error-message" style="display: none;"></div>
            </form>
            <div class="login-footer">
                <a href="../index.php">← Retour au site</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorDiv = document.getElementById('errorMessage');

            try {
                const response = await fetch('../api/auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ username, password })
                });

                const text = await response.text();
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        sessionStorage.setItem('admin_logged_in', 'true');
                        sessionStorage.setItem('admin_username', data.username);
                        window.location.href = 'Backoffice.php';
                    } else {
                        errorDiv.textContent = data.message || 'Identifiants incorrects';
                        errorDiv.style.display = 'block';
                    }
                } catch (e) {
                    console.error('Erreur parsing JSON:', e);
                    console.log('Réponse serveur:', text);
                    // Affiche un message d'erreur plus explicite si ce n'est pas du JSON (ex: erreur PHP)
                    errorDiv.textContent = 'Erreur serveur : ' + text.replace(/<[^>]*>/g, '').substring(0, 150);
                    errorDiv.style.display = 'block';
                }
            } catch (error) {
                console.error('Erreur fetch:', error);
                errorDiv.textContent = 'Erreur de connexion au serveur.';
                errorDiv.style.display = 'block';
            }
        });
    </script>
</body>
</html>
