<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Zatovo</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="assets/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>⚽</text></svg>">
</head>
<body class="admin-body">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <img src="../images/LOGO_Zatovo.png" alt="Zatovo" class="admin-logo">
                <p>Administration</p>
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
                        // Ne plus utiliser sessionStorage - la session serveur gère tout
                        window.location.href = 'index.php';
                    } else {
                        errorDiv.textContent = data.message || 'Identifiants incorrects';
                        errorDiv.style.display = 'block';
                        
                        // Si compte bloqué, désactiver le formulaire temporairement
                        if (data.locked) {
                            document.getElementById('username').disabled = true;
                            document.getElementById('password').disabled = true;
                            document.querySelector('.btn-login').disabled = true;
                        }
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
