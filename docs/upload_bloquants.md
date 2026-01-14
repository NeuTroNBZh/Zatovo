# Upload d'images – Bloquants et actions

## Blocages actuels
- **Reload PHP-FPM non fait** : la modification du `/etc/php/8.1/fpm/php.ini` (passage à `upload_max_filesize=10M`, `post_max_size=16M`, `upload_tmp_dir`) n’est pas appliquée car le reload a échoué sans droits root (`systemctl reload php8.1-fpm` refusé).
- **Limite applicative à 5 Mo** : la fonction `uploadImage()` côté API refuse toute image >5 Mo ([api/actualites.php](api/actualites.php#L270-L319)), alors que PHP est configuré pour 10 Mo. Le front annonce aussi 5 Mo ([admin/Backoffice.php](admin/Backoffice.php#L235-L255)).
- **Permissions en mode large** : pour débloquer l’écriture, `uploads/` et `tmp_uploads/` sont en `777`. C’est fonctionnel mais à resserrer dès que possible.

## Ce qu’il faut faire
1. **Appliquer la config PHP-FPM**
   - Exécuter avec privilèges : `sudo systemctl reload php8.1-fpm` (ou redémarrer le service web) pour prendre en compte `upload_max_filesize/post_max_size/upload_tmp_dir` du FPM.
   - Vérifier via `phpinfo()` côté web que `upload_tmp_dir` pointe sur `/var/www/html/CERCLE/depot/Zatovo/tmp_uploads` et que `upload_max_filesize=10M`, `post_max_size=16M` sont bien actifs.

2. **Aligner les limites de taille**
   - Si 10 Mo sont souhaités : porter `$maxSize` à `10 * 1024 * 1024` dans `uploadImage()` ([api/actualites.php](api/actualites.php#L270-L319)) et mettre à jour le message d’aide dans le formulaire ([admin/Backoffice.php](admin/Backoffice.php#L235-L255)).
   - Sinon, ramener `upload_max_filesize`/`post_max_size` à 5 Mo pour rester cohérent.

3. **Resserrez les permissions des dossiers**
   - Une fois le service web identifié (ex. `www-data`), appliquer : `chown -R CERCLE:www-data uploads tmp_uploads && chmod 775 uploads tmp_uploads` (ou ACL) et retirer le `777`.

4. **Tests à effectuer côté backoffice**
   - Création d’une actualité avec image locale <5 Mo (ou la nouvelle limite) et vérification que le fichier apparaît dans `uploads/`.
   - Création avec URL d’image (pas de fichier) pour valider le chemin stocké.
   - Suppression d’une actualité pour vérifier que le fichier local est bien supprimé.

## Contexte résumé
- Paramètres site (.user.ini) : `upload_max_filesize=10M`, `post_max_size=16M`, `upload_tmp_dir=/var/www/html/CERCLE/depot/Zatovo/tmp_uploads`.
- Code d’upload : vérifie type (jpeg/png/gif/webp) et taille max 5 Mo, crée `uploads/` au besoin, nom unique, retourne `uploads/<fichier>`.
- Formulaire backoffice : envoie `FormData` vers l’API avec fichier ou URL, pas de limite côté JS autre que le message 5 Mo.
