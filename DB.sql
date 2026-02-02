-- Adminer 4.8.1 MySQL 11.8.3-MariaDB-0+deb13u1 from Debian dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `actualites`;
CREATE TABLE `actualites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `texte` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `lien` varchar(500) DEFAULT NULL,
  `categorie` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_date` (`date` DESC),
  KEY `idx_categorie` (`categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `actualites` (`id`, `titre`, `auteur`, `date`, `texte`, `image`, `lien`, `categorie`, `created_at`, `updated_at`) VALUES
(1,	'Grand tournoi de football inter-quartiers',	'Jean Rakoto',	'2025-11-10',	'Ce weekend, nous avons organisé un grand tournoi de football réunissant 8 équipes de différents quartiers d\'Antananarivo. Plus de 100 jeunes ont participé à cet événement sportif qui s\'est déroulé dans une ambiance festive et conviviale.\n\nLes jeunes de l\'association Zatovo ont brillé par leur fair-play et leur esprit d\'équipe. Plusieurs de nos joueurs ont été remarqués par des recruteurs locaux.\n\nCet événement a permis de renforcer les liens entre les différents quartiers et de promouvoir les valeurs du sport : respect, solidarité et dépassement de soi.',	'images/306755946_138904095519184_847306085790273263_n.jpg',	'',	'evenement',	'2026-01-21 09:16:58',	'2026-01-21 09:16:58'),
(3,	'Rakoto, de Zatovo à l\'équipe nationale U17',	'Pierre Andrianina',	'2025-10-28',	'Une immense fierté pour l\'association Zatovo ! Rakoto, l\'un de nos jeunes footballeurs formés depuis 5 ans dans notre club, vient d\'être sélectionné dans l\'équipe nationale U17 de Madagascar.\n\nSon parcours est exemplaire : malgré des difficultés familiales, il n\'a jamais abandonné son rêve. Grâce à notre programme de bourses, il a pu continuer ses études tout en s\'entraînant régulièrement.\n\nAujourd\'hui, il est en classe de première avec d\'excellents résultats scolaires ET il représente son pays au football. Un bel exemple de ce que l\'association Zatovo peut accomplir : développer les jeunes par le sport ET l\'éducation.\n\nBravo Rakoto, tu es une inspiration pour tous les jeunes de Zatovo !',	'images/306755946_138904095519184_847306085790273263_n.jpg',	'',	'reussite',	'2026-01-21 09:16:58',	'2026-01-21 09:16:58'),
(4,	'Nouveau partenariat avec une école locale',	'Sophie Martin',	'2025-10-20',	'L\'association Zatovo est heureuse d\'annoncer un nouveau partenariat avec le Collège Tana Centre. Ce partenariat permettra à nos jeunes bénéficiaires d\'accéder à des cours de soutien gratuits chaque mercredi après-midi.\n\nDes professeurs bénévoles de l\'établissement assureront des cours de mathématiques, français et malgache pour aider les élèves en difficulté.\n\nCette collaboration renforce notre mission d\'accompagnement global des jeunes, en complément de nos activités sportives.',	'images/471587261_569944412415148_7155253093133488950_n.jpg',	'https://example.com',	'projet',	'2026-01-21 09:16:58',	'2026-01-21 09:16:58'),
(5,	'Stage de formation pour les entraîneurs',	'Thomas Randria',	'2025-10-15',	'Du 12 au 14 octobre, nos 6 entraîneurs bénévoles ont participé à un stage de formation organisé par la Fédération Malgache de Football.\n\nCette formation leur a permis d\'acquérir de nouvelles compétences pédagogiques et techniques pour mieux encadrer nos jeunes joueurs.\n\nInvestir dans la formation de nos encadrants, c\'est garantir un enseignement de qualité à nos jeunes footballeurs.',	'images/306755946_138904095519184_847306085790273263_n.jpg',	'',	'evenement',	'2026-01-21 09:16:58',	'2026-01-21 09:16:58'),
(6,	'Mélina en 8ème année de médecine',	'Pierre Andrianina',	'2025-10-28',	'Une immense fierté pour l\'association Zatovo ! Rakoto, l\'un de nos jeunes footballeurs formés depuis 5 ans dans notre club, vient d\'être sélectionné dans l\'équipe nationale U17 de Madagascar.\r\n\r\nSon parcours est exemplaire : malgré des difficultés familiales, il n\'a jamais abandonné son rêve. Grâce à notre programme de bourses, il a pu continuer ses études tout en s\'entraînant régulièrement.\r\n\r\nAujourd\'hui, il est en classe de première avec d\'excellents résultats scolaires ET il représente son pays au football. Un bel exemple de ce que l\'association Zatovo peut accomplir : développer les jeunes par le sport ET l\'éducation.\r\n\r\nBravo Rakoto, tu es une inspiration pour tous les jeunes de Zatovo !',	'images/306755946_138904095519184_847306085790273263_n.jpg',	'',	'reussite',	'2026-01-21 09:16:58',	'2026-01-21 09:16:58'),
(7,	'Abedi semi-pro dans l\'équipe de foot de la Réunion',	'Pierre Andrianina',	'2025-10-28',	'Une immense fierté pour l\'association Zatovo ! Rakoto, l\'un de nos jeunes footballeurs formés depuis 5 ans dans notre club, vient d\'être sélectionné dans l\'équipe nationale U17 de Madagascar.\r\n\r\nSon parcours est exemplaire : malgré des difficultés familiales, il n\'a jamais abandonné son rêve. Grâce à notre programme de bourses, il a pu continuer ses études tout en s\'entraînant régulièrement.\r\n\r\nAujourd\'hui, il est en classe de première avec d\'excellents résultats scolaires ET il représente son pays au football. Un bel exemple de ce que l\'association Zatovo peut accomplir : développer les jeunes par le sport ET l\'éducation.\r\n\r\nBravo Rakoto, tu es une inspiration pour tous les jeunes de Zatovo !',	'images/306755946_138904095519184_847306085790273263_n.jpg',	'',	'reussite',	'2026-01-21 09:16:58',	'2026-01-21 09:16:58'),
(8,	'Ismaël',	'Pierre Andrianina',	'2025-10-28',	'Une immense fierté pour l\'association Zatovo ! Rakoto, l\'un de nos jeunes footballeurs formés depuis 5 ans dans notre club, vient d\'être sélectionné dans l\'équipe nationale U17 de Madagascar.\r\n\r\nSon parcours est exemplaire : malgré des difficultés familiales, il n\'a jamais abandonné son rêve. Grâce à notre programme de bourses, il a pu continuer ses études tout en s\'entraînant régulièrement.\r\n\r\nAujourd\'hui, il est en classe de première avec d\'excellents résultats scolaires ET il représente son pays au football. Un bel exemple de ce que l\'association Zatovo peut accomplir : développer les jeunes par le sport ET l\'éducation.\r\n\r\nBravo Rakoto, tu es une inspiration pour tous les jeunes de Zatovo !',	'images/306755946_138904095519184_847306085790273263_n.jpg',	'',	'reussite',	'2026-01-21 09:16:58',	'2026-01-21 09:16:58'),
(9,	'Rakoto, de Zatovo à l\'équipe nationale U17',	'Pierre Andrianina',	'2025-10-28',	'Une immense fierté pour l\'association Zatovo ! Rakoto, l\'un de nos jeunes footballeurs formés depuis 5 ans dans notre club, vient d\'être sélectionné dans l\'équipe nationale U17 de Madagascar.\n\nSon parcours est exemplaire : malgré des difficultés familiales, il n\'a jamais abandonné son rêve. Grâce à notre programme de bourses, il a pu continuer ses études tout en s\'entraînant régulièrement.\n\nAujourd\'hui, il est en classe de première avec d\'excellents résultats scolaires ET il représente son pays au football. Un bel exemple de ce que l\'association Zatovo peut accomplir : développer les jeunes par le sport ET l\'éducation.\n\nBravo Rakoto, tu es une inspiration pour tous les jeunes de Zatovo !',	'images/306755946_138904095519184_847306085790273263_n.jpg',	'',	'reussite',	'2026-01-21 09:16:58',	'2026-01-21 09:16:58'),
(10,	'Rakoto, de Zatovo à l\'équipe nationale U17',	'Pierre Andrianina',	'2025-10-28',	'Une immense fierté pour l\'association Zatovo ! Rakoto, l\'un de nos jeunes footballeurs formés depuis 5 ans dans notre club, vient d\'être sélectionné dans l\'équipe nationale U17 de Madagascar.\n\nSon parcours est exemplaire : malgré des difficultés familiales, il n\'a jamais abandonné son rêve. Grâce à notre programme de bourses, il a pu continuer ses études tout en s\'entraînant régulièrement.\n\nAujourd\'hui, il est en classe de première avec d\'excellents résultats scolaires ET il représente son pays au football. Un bel exemple de ce que l\'association Zatovo peut accomplir : développer les jeunes par le sport ET l\'éducation.\n\nBravo Rakoto, tu es une inspiration pour tous les jeunes de Zatovo !',	'images/306755946_138904095519184_847306085790273263_n.jpg',	'',	'reussite',	'2026-01-21 09:16:58',	'2026-01-21 09:16:58'),
(11,	'tittre',	'ezrzr',	'2026-01-15',	'dsqfsqfsqf',	'http://lab.sio-estran.fr:18102/PENVERN/depot/Zatovo/photos_2025_compr/match_foot_exterieur.webp',	'',	'Événement',	'2026-01-22 15:19:52',	'2026-01-22 15:19:52');

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin_users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1,	'admin',	'REDACTED_HASH',	'admin@example.com',	'2026-01-20 13:53:11');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`),
  KEY `idx_nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `nom`, `created_at`) VALUES
(1,	'Actualité',	'2026-01-20 13:53:11'),
(2,	'Événement',	'2026-01-20 13:53:11'),
(3,	'Annonce',	'2026-01-20 13:53:11'),
(4,	'Info',	'2026-01-20 13:53:11'),
(5,	'Réussite',	'2026-01-20 16:15:26');

DROP TABLE IF EXISTS `galerie`;
CREATE TABLE `galerie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_created` (`created_at` DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `galerie` (`id`, `titre`, `description`, `image`, `created_at`) VALUES
(4,	'dfdg',	'dgdgfgd',	'uploads/galerie_696f8b6cd1bfd5.70755316.png',	'2026-01-20 14:04:28'),
(5,	'dgdgdfgd',	'fgdgfdg',	'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3wxJ0c-jC6VcDASO9aiDWD9zWAeJLKrS5gg&s',	'2026-01-20 14:04:51'),
(7,	'bxcbxcb',	'',	'https://scontent-cdg4-3.xx.fbcdn.net/v/t39.30808-6/509419649_695309926545262_6136937325309602106_n.jpg?stp=dst-jpg_s590x590_tt6&_nc_cat=111&ccb=1-7&_nc_sid=127cfc&_nc_ohc=ZsV5PPVvBFcQ7kNvwFQXP81&_nc_oc=AdmTI539RTpg5tvpklstjsz1xlDTeiye3cy6noYT2s-mw7CnYLLaAFqjXT7NWbj1mOw&_nc_zt=23&_nc_ht=scontent-cdg4-3.xx&_nc_gid=2Q4AUfV6nCye6giBohOLcQ&oh=00_Afp6qquaiYsSPsajzNRjz6rTJbsK8DZ0S-iowaizDWftKw&oe=697824DC',	'2026-01-22 15:22:34');

-- 2026-02-02 14:27:27
