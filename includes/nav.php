    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <a href="<?php echo $basePath ?? ''; ?>index.php" aria-label="Retour à l'accueil Zatovo">
                        <img src="<?php echo $basePath ?? ''; ?>images/LOGO_Zatovo.png" alt="Association Zatovo - Sport & Éducation : Brest ↔ Madagascar" class="logo-img" loading="lazy">
                    </a>
                </div>
                <button class="menu-toggle" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="main-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <ul class="nav-menu" id="main-menu">
                    <li class="nav-item has-dropdown">
                        <a href="<?php echo $basePath ?? ''; ?>index.php" class="nav-link<?php echo ($currentPage ?? '') === 'accueil' ? ' active' : ''; ?>">
                            Accueil
                            <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $basePath ?? ''; ?>index.php#mission" class="dropdown-link">Notre Mission</a></li>
                            <li><a href="<?php echo $basePath ?? ''; ?>index.php#actions" class="dropdown-link">Nos Actions</a></li>
                            <li><a href="<?php echo $basePath ?? ''; ?>index.php#contact" class="dropdown-link">Contact</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo $basePath ?? ''; ?>actualites.php" class="nav-link<?php echo ($currentPage ?? '') === 'actualites' ? ' active' : ''; ?>">Actualités</a></li>
                    <li><a href="<?php echo $basePath ?? ''; ?>galerie.php" class="nav-link<?php echo ($currentPage ?? '') === 'galerie' ? ' active' : ''; ?>">Galerie</a></li>
                    <li><a href="<?php echo $basePath ?? ''; ?>parrainage.php" class="nav-link<?php echo ($currentPage ?? '') === 'parrainage' ? ' active' : ''; ?>">Parrainage</a></li>
                </ul>
            </div>
        </div>
    </nav>
