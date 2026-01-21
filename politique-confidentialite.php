<?php
// Configuration de la page
$pageTitle = 'Politique de confidentialité - Association Zatovo';
$pageDescription = 'Informations sur la protection des données traitées par l\'Association Zatovo.';
$currentPage = 'politique-confidentialite';
$pageUrl = 'politique-confidentialite.php';
$basePath = '';

// Inclure le header
include 'includes/header.php';
include 'includes/nav.php';
?>

    <main id="main">
        <section class="page-header">
            <div class="header-overlay"></div>
            <div class="container">
                <h1 class="page-title">Politique de confidentialité</h1>
                <p class="page-subtitle">Protection des données et droits RGPD</p>
            </div>
        </section>

        <section class="legal-section">
            <div class="container">
                <div class="legal-grid">
                    <div class="legal-block">
                        <h3>Responsable du traitement</h3>
                        <p>Association Zatovo (loi 1901), représentée par Claude André.</p>
                        <ul>
                            <li>Adresse : 53 Rue Sébastopol, 29200 Brest, France</li>
                            <li>Email : association.zatovo@gmail.com</li>
                            <li>Téléphone : 06 08 73 30 15</li>
                        </ul>
                    </div>

                    <div class="legal-block">
                        <h3>Finalités et bases légales</h3>
                        <p>Répondre aux demandes envoyées via le formulaire de contact, organiser les échanges liés aux actions sport/éducation, assurer la sécurité du site.</p>
                        <p>Base légale : consentement (envoi volontaire du formulaire) et intérêt légitime (sécurisation du site).</p>
                    </div>

                    <div class="legal-block">
                        <h3>Données collectées</h3>
                        <p>Données fournies volontairement : nom, email, contenu du message via le formulaire de contact.</p>
                        <p>Données techniques : journaux techniques anonymes nécessaires à la sécurité (adresses IP dans les logs serveur, durée limitée).</p>
                        <p>Aucune donnée de navigation pour la publicité ou l'analytics n'est collectée.</p>
                    </div>

                    <div class="legal-block">
                        <h3>Cookies</h3>
                        <p>Uniquement des cookies techniques nécessaires (ex. session PHP) pour la navigation et la sécurité.</p>
                        <p>Aucun cookie publicitaire, de mesure d'audience ou de traçage tiers n'est déposé.</p>
                    </div>

                    <div class="legal-block">
                        <h3>Durées de conservation</h3>
                        <p>Données de contact : le temps nécessaire pour traiter la demande, puis suppression au plus tard 12 mois après le dernier échange, sauf obligation légale.</p>
                        <p>Logs techniques : durée strictement nécessaire à la sécurité et à la détection d'incidents.</p>
                    </div>

                    <div class="legal-block">
                        <h3>Destinataires</h3>
                        <p>Uniquement les bénévoles habilités de l'association.</p>
                        <p>Aucune transmission à des tiers ni transfert hors UE, sauf obligation légale.</p>
                    </div>

                    <div class="legal-block">
                        <h3>Sécurité</h3>
                        <p>Accès restreint à l'administration (identifiant/mot de passe), hébergement interne au lycée Estran Charles de Foucauld (Brest), sauvegardes et mises à jour régulières.</p>
                        <p>Surveillance des journaux techniques pour prévenir les intrusions.</p>
                    </div>

                    <div class="legal-block">
                        <h3>Vos droits</h3>
                        <p>Accès, rectification, opposition, effacement, limitation. Pour exercer vos droits :</p>
                        <ul>
                            <li>Via la page « Contact »</li>
                            <li>Par email : association.zatovo@gmail.com</li>
                            <li>Par courrier : Association Zatovo, 53 Rue Sébastopol, 29200 Brest, France</li>
                        </ul>
                        <p>En cas de difficulté, vous pouvez saisir la CNIL (cnil.fr).</p>
                    </div>

                    <div class="legal-block">
                        <h3>Hébergement</h3>
                        <p>Site hébergé gracieusement au lycée Estran Charles de Foucauld (Brest, France).</p>
                        <p>Pour toute question technique ou signalement : nous contacter via le formulaire ou par email.</p>
                    </div>

                    <div class="legal-block">
                        <h3>Mises à jour</h3>
                        <p>La présente politique peut être mise à jour en fonction de l'évolution du site ou de la réglementation. Dernière mise à jour : <?php echo date('Y'); ?>.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
</body>
</html>
