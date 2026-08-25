# Zatovo

> Site vitrine pour l'association Zatovo, avec panel d'administration pour gérer actualités et galerie.

[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql)](https://www.mysql.com/)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=black)](https://developer.mozilla.org/fr/docs/Web/JavaScript)

[Démo en ligne](https://demo-zatovo.neutronbzh.fr) — connexion admin : `admin` / `Demo1234`

## À propos

Site vitrine de l'association Zatovo (version 0.2) : pages publiques (accueil, actualités, galerie, parrainage, mentions légales) et panel d'administration pour publier des actualités et gérer la galerie photo, sans toucher au code.

## Fonctionnalités

- Pages publiques : accueil, actualités (avec catégories et pagination), galerie photo, parrainage, mentions légales, politique de confidentialité
- Panel admin : authentification (rate limiting, verrouillage après 5 tentatives), CRUD actualités/catégories/galerie, upload d'images (validation MIME + taille)
- Protection CSRF sur les actions de modification, sessions liées à l'IP/user-agent

## Stack technique

| Techno | Usage |
|--------|-------|
| PHP 8.x (vanilla) | API REST (`api/`), panel admin |
| MySQL/MariaDB (PDO) | Stockage |
| HTML5 / CSS3 / JavaScript vanilla | Frontend public, appels `fetch` vers l'API |

## Installation locale

```bash
git clone https://github.com/NeuTroNBZh/Zatovo.V0.2.git
cd Zatovo.V0.2
```

1. Créer une base MySQL et importer `DB.sql`, ou exécuter `setup/setup.php` (crée les tables si absentes).
2. Copier `.env.example` en `config/db.php` équivalent (voir les identifiants dans `config/db.php`, absent du dépôt) et adapter `DB_HOST`/`DB_NAME`/`DB_USER`/`DB_PASS`.
3. Créer votre compte admin avec `php setup/create_admin.php` (en CLI).
4. Servir le dossier avec Apache/PHP (`.htaccess` fourni) ou `php -S localhost:8000`.

**Avant tout déploiement en production**, supprimez ou protégez `adminer.php`, `setup/`, `test-upload.php` — outils de développement, ne doivent jamais rester accessibles publiquement.

## Structure du projet

```
Zatovo.V0.2/
├── admin/              # Panel d'administration
├── api/                # API REST (auth, actualites, categories, galerie, security, csrf)
├── config/              # Connexion DB (non commité, voir .env.example)
├── assets/              # CSS et JS du site public
├── includes/             # Header/nav/footer partagés
├── setup/                # Scripts d'installation/diagnostic (à ne PAS déployer en prod)
├── uploads/              # Images uploadées via l'admin
└── DB.sql                # Schéma + compte admin placeholder
```

## Licence

Projet personnel, publié à titre de portfolio.
