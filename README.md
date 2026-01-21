# 🚀 Environnement de Test Web - VPS

## 📋 Configuration

Cet environnement de test est prêt à l'emploi avec :

- ✅ **Serveur Web** : Nginx (écoute sur le port 8080)
- ✅ **PHP** : Version 8.4.16 avec extensions essentielles
- ✅ **Base de données** : MariaDB (MySQL compatible)
- ✅ **Répertoire Web** : `/var/www/test-sites/`

## 🔐 Informations de Connexion

### Base de Données
- **Host** : `localhost`
- **Database** : `test_db`
- **User** : `test_user`
- **Password** : `Test123!`
- **Charset** : `utf8mb4`

## 📂 Structure des Fichiers

```
/var/www/test-sites/
├── index.php          # Page de test avec diagnostic complet
├── README.md          # Ce fichier
└── [vos sites ici]    # Placez vos sites web ici
```

## 🌐 Accès au Site de Test

Le serveur écoute sur le **port 8090**

- URL locale : `http://localhost:8090`
- URL externe : `http://37.59.99.20:8090`

### 🗄️ Accès à Adminer (Gestion de Base de Données)

- URL locale : `http://localhost:8090/adminer.php`
- URL externe : `http://37.59.99.20:8090/adminer.php`

**Identifiants de connexion :**
- **Serveur** : `localhost`
- **Utilisateur** : `test_user`
- **Mot de passe** : `Test123!`
- **Base de données** : `test_db`

## 🔧 Commandes Utiles

### Services

```bash
# Redémarrer Nginx
sudo systemctl restart nginx

# Redémarrer PHP-FPM
sudo systemctl restart php8.4-fpm

# Redémarrer MariaDB
sudo systemctl restart mariadb

# Vérifier le statut des services
sudo systemctl status nginx
sudo systemctl status php8.4-fpm
sudo systemctl status mariadb
```

### Base de Données

```bash
# Se connecter à MySQL en tant qu'administrateur
sudo mysql

# Se connecter avec l'utilisateur de test
mysql -u test_user -p test_db
# (Mot de passe : Test123!)

# Lister les bases de données
sudo mysql -e "SHOW DATABASES;"

# Créer une nouvelle base de données
sudo mysql -e "CREATE DATABASE nom_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Créer un nouvel utilisateur
sudo mysql -e "CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';"

# Donner les permissions
sudo mysql -e "GRANT ALL PRIVILEGES ON nom_db.* TO 'user'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"
```

### Nginx

```bash
# Tester la configuration
sudo nginx -t

# Recharger la configuration (sans interruption)
sudo systemctl reload nginx

# Voir les logs d'accès
sudo tail -f /var/log/nginx/test-sites-access.log

# Voir les logs d'erreur
sudo tail -f /var/log/nginx/test-sites-error.log
```

### PHP

```bash
# Vérifier la version
php --version

# Lister les extensions installées
php -m

# Voir la configuration PHP-FPM
php-fpm8.4 -i

# Logs PHP-FPM
sudo tail -f /var/log/php8.4-fpm.log
```

## 📝 Exemple de Connexion PHP à MySQL

```php
<?php
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=test_db;charset=utf8mb4',
        'test_user',
        'Test123!'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
```

## 🎨 Ajouter un Nouveau Site

1. Créez un dossier dans `/var/www/test-sites/monsite/`
2. Ajoutez vos fichiers PHP/HTML
3. Accédez via : `http://VOTRE_IP:8080/monsite/`

## 🔒 Sécurité

⚠️ **IMPORTANT** : Cet environnement est configuré pour le TEST uniquement !

Pour la production :
- Changez les mots de passe
- Configurez un nom de domaine
- Activez HTTPS avec Let's Encrypt
- Renforcez les permissions des fichiers
- Configurez un pare-feu (UFW)

## 🆘 Dépannage

### PHP ne s'exécute pas
```bash
# Vérifier que PHP-FPM fonctionne
sudo systemctl status php8.4-fpm

# Vérifier le socket PHP
ls -la /var/run/php/php8.4-fpm.sock
```

### Erreur de connexion à la base de données
```bash
# Vérifier que MariaDB fonctionne
sudo systemctl status mariadb

# Tester la connexion
mysql -u test_user -pTest123! test_db
```

### Page blanche
```bash
# Vérifier les logs
sudo tail -f /var/log/nginx/test-sites-error.log
sudo tail -f /var/log/php8.4-fpm.log
```

## 📦 Extensions PHP Installées

- ✅ PDO & PDO_MySQL (connexion base de données)
- ✅ MySQLi
- ✅ cURL (requêtes HTTP)
- ✅ GD (traitement d'images)
- ✅ MBString (gestion des chaînes multi-octets)
- ✅ XML
- ✅ ZIP
- ✅ JSON

## 🔄 Mise à Jour

```bash
# Mettre à jour les paquets
sudo apt update && sudo apt upgrade -y

# Redémarrer les services après mise à jour
sudo systemctl restart nginx php8.4-fpm mariadb
```

---

**Environnement créé le** : 20 Janvier 2026
**Configuration** : Debian 13 (Trixie) + Nginx + PHP 8.4 + MariaDB
