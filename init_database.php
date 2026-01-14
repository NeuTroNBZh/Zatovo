<?php
// init_database.php
// Script pour initialiser la base de données avec des exemples d'actualités

require_once 'config/db.php';

try {
    // Créer la table actualites si elle n'existe pas (au cas où install.php n'a pas été lancé)
    $pdo->exec("CREATE TABLE IF NOT EXISTS actualites (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(255) NOT NULL,
        auteur VARCHAR(100) NOT NULL,
        date DATE NOT NULL,
        texte TEXT NOT NULL,
        image VARCHAR(255),
        lien VARCHAR(255),
        categorie VARCHAR(50) NOT NULL
    )");

    // Vérifier s'il y a déjà des articles
    $stmt = $pdo->query("SELECT COUNT(*) FROM actualites");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        echo "Ajout d'exemples d'actualités...<br>";

        // Exemples d'actualités
        $articles = [
            [
                'titre' => 'Grand tournoi de football inter-quartiers',
                'auteur' => 'Jean Rakoto',
                'date' => '2025-11-10',
                'texte' => "Ce weekend, nous avons organisé un grand tournoi de football réunissant 8 équipes de différents quartiers d'Antananarivo. Plus de 100 jeunes ont participé à cet événement sportif qui s'est déroulé dans une ambiance festive et conviviale.\n\nLes jeunes de l'association Zatovo ont brillé par leur fair-play et leur esprit d'équipe. Plusieurs de nos joueurs ont été remarqués par des recruteurs locaux.\n\nCet événement a permis de renforcer les liens entre les différents quartiers et de promouvoir les valeurs du sport : respect, solidarité et dépassement de soi.",
                'image' => '306755946_138904095519184_847306085790273263_n.jpg',
                'lien' => '',
                'categorie' => 'evenement'
            ],
            [
                'titre' => 'Distribution de fournitures scolaires',
                'auteur' => 'Marie Ravelo',
                'date' => '2025-11-05',
                'texte' => "Dans le cadre de notre programme de soutien à la scolarisation, nous avons distribué des fournitures scolaires à 50 élèves bénéficiaires de notre association.\n\nChaque enfant a reçu un kit complet comprenant : des cahiers, des stylos, des crayons, une règle, une gomme, et un sac à dos. Ces fournitures permettront aux jeunes de poursuivre leur année scolaire dans de bonnes conditions.\n\nNous remercions tous nos donateurs qui rendent ces actions possibles. Grâce à votre générosité, nous pouvons continuer à accompagner ces jeunes vers la réussite éducative.",
                'image' => '471587261_569944412415148_7155253093133488950_n.jpg',
                'lien' => '',
                'categorie' => 'projet'
            ],
            [
                'titre' => 'Rakoto, de Zatovo à l\'équipe nationale U17',
                'auteur' => 'Pierre Andrianina',
                'date' => '2025-10-28',
                'texte' => "Une immense fierté pour l'association Zatovo ! Rakoto, l'un de nos jeunes footballeurs formés depuis 5 ans dans notre club, vient d'être sélectionné dans l'équipe nationale U17 de Madagascar.\n\nSon parcours est exemplaire : malgré des difficultés familiales, il n'a jamais abandonné son rêve. Grâce à notre programme de bourses, il a pu continuer ses études tout en s'entraînant régulièrement.\n\nAujourd'hui, il est en classe de première avec d'excellents résultats scolaires ET il représente son pays au football. Un bel exemple de ce que l'association Zatovo peut accomplir : développer les jeunes par le sport ET l'éducation.\n\nBravo Rakoto, tu es une inspiration pour tous les jeunes de Zatovo !",
                'image' => '306755946_138904095519184_847306085790273263_n.jpg',
                'lien' => '',
                'categorie' => 'reussite'
            ],
            [
                'titre' => 'Nouveau partenariat avec une école locale',
                'auteur' => 'Sophie Martin',
                'date' => '2025-10-20',
                'texte' => "L'association Zatovo est heureuse d'annoncer un nouveau partenariat avec le Collège Tana Centre. Ce partenariat permettra à nos jeunes bénéficiaires d'accéder à des cours de soutien gratuits chaque mercredi après-midi.\n\nDes professeurs bénévoles de l'établissement assureront des cours de mathématiques, français et malgache pour aider les élèves en difficulté.\n\nCette collaboration renforce notre mission d'accompagnement global des jeunes, en complément de nos activités sportives.",
                'image' => '471587261_569944412415148_7155253093133488950_n.jpg',
                'lien' => 'https://example.com',
                'categorie' => 'projet'
            ],
            [
                'titre' => 'Stage de formation pour les entraîneurs',
                'auteur' => 'Thomas Randria',
                'date' => '2025-10-15',
                'texte' => "Du 12 au 14 octobre, nos 6 entraîneurs bénévoles ont participé à un stage de formation organisé par la Fédération Malgache de Football.\n\nCette formation leur a permis d'acquérir de nouvelles compétences pédagogiques et techniques pour mieux encadrer nos jeunes joueurs.\n\nInvestir dans la formation de nos encadrants, c'est garantir un enseignement de qualité à nos jeunes footballeurs.",
                'image' => '306755946_138904095519184_847306085790273263_n.jpg',
                'lien' => '',
                'categorie' => 'evenement'
            ]
        ];

        // Insérer les articles
        $stmt = $pdo->prepare('INSERT INTO actualites (titre, auteur, date, texte, image, lien, categorie) VALUES (:titre, :auteur, :date, :texte, :image, :lien, :categorie)');
        
        foreach ($articles as $article) {
            $stmt->execute([
                ':titre' => $article['titre'],
                ':auteur' => $article['auteur'],
                ':date' => $article['date'],
                ':texte' => $article['texte'],
                ':image' => $article['image'],
                ':lien' => $article['lien'],
                ':categorie' => $article['categorie']
            ]);
            
            echo "- Ajouté : {$article['titre']}<br>";
        }

        echo "<br>✅ Base de données initialisée avec succès !<br>";
    } else {
        echo "ℹ️  La base de données contient déjà $count article(s).<br>";
    }

    // Créer la table admin si elle n'existe pas
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )");

    // Vérifier s'il y a déjà un admin
    $stmt = $pdo->query("SELECT COUNT(*) FROM admin_users");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        $username = 'admin';
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password) VALUES (:username, :password)");
        $stmt->execute([':username' => $username, ':password' => $password]);
        
        echo "✅ Utilisateur admin créé<br>";
        echo "   Username: admin<br>";
        echo "   Password: admin123<br><br>";
    }

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
