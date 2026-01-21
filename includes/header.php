<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $pageDescription ?? 'Association Zatovo - Développement des jeunes Malgaches par le sport et l\'éducation'; ?>">
    <title><?php echo $pageTitle ?? 'Association Zatovo - Sport et Éducation à Madagascar'; ?></title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $basePath ?? ''; ?>assets/css/styles.css">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon & Icons -->
    <link rel="icon" type="image/svg+xml" href="<?php echo $basePath ?? ''; ?>images/favicon.svg">
    <link rel="alternate icon" type="image/x-icon" href="<?php echo $basePath ?? ''; ?>images/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo $basePath ?? ''; ?>images/apple-touch-icon.png">
    <link rel="manifest" href="<?php echo $basePath ?? ''; ?>images/site.webmanifest">
    <meta name="theme-color" content="#ffffff">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo $pageTitle ?? 'Association Zatovo'; ?>">
    <meta property="og:description" content="<?php echo $pageDescription ?? 'Association brestoise de solidarité internationale avec Madagascar.'; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://zatovo.fr/<?php echo $pageUrl ?? ''; ?>">
    <meta property="og:image" content="https://zatovo.fr/images/LOGO_Zatovo.png">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $pageTitle ?? 'Association Zatovo'; ?>">
    <meta name="twitter:description" content="<?php echo $pageDescription ?? 'Association brestoise de solidarité internationale avec Madagascar.'; ?>">
    <meta name="twitter:image" content="https://zatovo.fr/images/LOGO_Zatovo.png">
    
    <!-- Schema.org -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Association Zatovo",
      "url": "https://zatovo.fr/",
      "logo": "https://zatovo.fr/images/LOGO_Zatovo.png",
      "sameAs": [
        "https://www.facebook.com/p/Zatovo-100081987822483/?locale=fr_FR"
      ]
    }
    </script>
</head>
<body>
    <a class="skip-link" href="#main">Aller au contenu principal</a>
