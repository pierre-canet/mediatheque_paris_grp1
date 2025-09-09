<?php
// Vue pour afficher la page principale du catalogue
// Utilisation de la fonction url() pour générer des liens dynamiques compatibles avec BASE_URL
// Cette fonction garantit que les URLs sont cohérentes avec la configuration de l'application
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Définition de l'encodage des caractères pour supporter les caractères spéciaux -->
    <meta charset="UTF-8">
    <!-- Configuration pour rendre la page responsive sur différents appareils -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <title>Bibliothèque Digitale</title>
    <!-- Inclusion de la feuille de style CSS avec la fonction url() pour un chemin dynamique -->
    <link rel="stylesheet" href="<?php echo url('assets/css/style.css'); ?>">
</head>

<body>
    <!-- Conteneur principal pour organiser le contenu de la page -->
    <section class="container">
        <!-- Section de la bannière principale -->
        <section class="banner">
            <!-- Section de la bannière héroïque pour accueillir les utilisateurs -->
            <section class="hero-banner">
                <!-- Titre principal de la section héroïque -->
                <h1>Catalogue de la Médiathèque</h1>
                <!-- Sous-titre décrivant la collection disponible -->
                <p class="hero-subtitle">Découvrez notre collection de 48 médias organisée par catégorie</p>
            </section>
        </section>

        <!-- Section du formulaire de recherche pour filtrer les médias -->
        <section class="search-filters">
            <!-- Formulaire pour soumettre les critères de recherche via la méthode GET -->
            <form method="GET" action="<?php echo url('catalog/index'); ?>">
                <!-- Utilisation de url() pour l'action du formulaire afin de générer un lien dynamique -->
                <input type="hidden" name="url" value="catalog/index">
                <!-- Barre de recherche pour entrer un terme de recherche -->
                <div class="search-bar">
                    <!-- Champ de saisie pour le terme de recherche avec échappement des caractères -->
                    <input type="text" name="search_term" placeholder="Rechercher dans tous les médias" class="search-input" value="<?php echo htmlspecialchars($search_term ?? ''); ?>">
                    <!-- Bouton pour soumettre le formulaire de recherche -->
                    <button type="submit" class="search-button">Rechercher</button>
                    <?php if ($is_searching): ?>
                        <!-- Lien pour réinitialiser les critères de recherche -->
                        <a href="<?php echo url('catalog/index'); ?>" class="btn btn-secondary" style="margin-left: 10px;">Effacer</a>
                        <!-- Lien de réinitialisation utilisant url() au lieu d'un chemin codé en dur -->
                    <?php endif; ?>
                </div>

                <!-- Conteneur pour les filtres de recherche -->
                <div class="filters">
                    <!-- Filtre pour sélectionner le type de média -->
                    <div class="filter-group">
                        <label for="type">Type de média</label>
                        <select id="type" name="type" class="filter-select">
                            <option value="all" <?php echo ($search_type ?? 'all') == 'all' ? 'selected' : ''; ?>>Tous</option>
                            <option value="book" <?php echo ($search_type ?? '') == 'book' ? 'selected' : ''; ?>>Livres</option>
                            <option value="film" <?php echo ($search_type ?? '') == 'film' ? 'selected' : ''; ?>>Films</option>
                            <option value="game" <?php echo ($search_type ?? '') == 'game' ? 'selected' : ''; ?>>Jeux Vidéo</option>
                        </select>
                    </div>
                    <!-- Filtre pour sélectionner le genre du média -->
                    <div class="filter-group">
                        <label for="genre">Genre</label>
                        <select id="genre" name="genre" class="filter-select">
                            <option value="all" <?php echo ($search_genre ?? 'all') == 'all' ? 'selected' : ''; ?>>Tous</option>
                            <option value="Classique" <?php echo ($search_genre ?? '') == 'Classique' ? 'selected' : ''; ?>>Classique</option>
                            <option value="Science-Fiction" <?php echo ($search_genre ?? '') == 'Science-Fiction' ? 'selected' : ''; ?>>Science-Fiction</option>
                            <option value="Drame" <?php echo ($search_genre ?? '') == 'Drame' ? 'selected' : ''; ?>>Drame</option>
                            <option value="Romance" <?php echo ($search_genre ?? '') == 'Romance' ? 'selected' : ''; ?>>Romance</option>
                            <option value="Fantaisie" <?php echo ($search_genre ?? '') == 'Fantaisie' ? 'selected' : ''; ?>>Fantaisie</option>
                            <option value="Crime" <?php echo ($search_genre ?? '') == 'Crime' ? 'selected' : ''; ?>>Crime</option>
                            <option value="Action" <?php echo ($search_genre ?? '') == 'Action' ? 'selected' : ''; ?>>Action</option>
                            <option value="Plateforme" <?php echo ($search_genre ?? '') == 'Plateforme' ? 'selected' : ''; ?>>Plateforme</option>
                            <option value="RPG" <?php echo ($search_genre ?? '') == 'RPG' ? 'selected' : ''; ?>>RPG</option>
                        </select>
                    </div>
                    <!-- Filtre pour sélectionner la disponibilité du média -->
                    <div class="filter-group">
                        <label for="availability">Disponibilité</label>
                        <select id="availability" name="availability" class="filter-select">
                            <option value="all" <?php echo ($search_availability ?? 'all') == 'all' ? 'selected' : ''; ?>>Tous</option>
                            <option value="true" <?php echo ($search_availability ?? '') == 'true' ? 'selected' : ''; ?>>En stock</option>
                            <option value="false" <?php echo ($search_availability ?? '') == 'false' ? 'selected' : ''; ?>>Emprunté</option>
                        </select>
                    </div>
                </div>
            </form>
        </section>
        <?php
        // Section des résultats de recherche et des carrousels - les carrousels sont toujours affichés
        // Cette section affiche les résultats filtrés ou tous les éléments si aucune recherche n'est effectuée
        ?>
        <section class="search-results">
            <?php if ($is_searching): ?>
                <!-- Affichage du titre pour les résultats de recherche si une recherche est active -->
                <h2>Résultats de recherche</h2>
                <?php if (empty($items)): ?>
                    <!-- Message affiché si aucun résultat n'est trouvé -->
                    <p class="no-results">Aucun résultat trouvé pour votre recherche.</p>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Section des livres dans le catalogue -->
            <div class="catalog-section">
                <!-- Titre de la section des livres -->
                <h2>Livres</h2>
                <!-- Conteneur pour le carrousel des livres -->
                <div class="carousel-container">
                    <?php
                    // Filtre les éléments pour ne garder que les livres
                    $books = array_filter($items, function ($item) {
                        return $item['type'] == 'book';
                    });
                    if (!empty($books)): ?>
                        <?php foreach ($books as $item): ?>
                            <!-- Élément individuel du carrousel pour chaque livre -->
                            <div class="carousel-item">
                                <!-- Image du livre avec une URL par défaut si non disponible -->
                                <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/150'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                <!-- Titre du livre avec échappement pour la sécurité -->
                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <!-- Affichage du genre du livre -->
                                <p>Genre: <?php echo htmlspecialchars($item['genre'] ?? 'N/A'); ?></p>
                                <!-- Affichage de l'année de publication -->
                                <p>Year: <?php echo htmlspecialchars($item['year'] ?? 'N/A'); ?></p>
                                <!-- Actions disponibles pour le livre -->
                                <div class="carousel-actions">
                                    <?php if ($item['available']): ?>
                                        <!-- Lien pour emprunter le livre si disponible -->
                                        <a href="<?php echo url('rental/rent/' . $item['id']); ?>" class="btn btn-rent">Emprunter</a>
                                    <?php endif; ?>
                                    <!-- Lien pour afficher les détails du livre dans une modale -->
                                    <a href="#item-<?php echo $item['id']; ?>" class="btn btn-detail">Détails</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Message affiché si aucun livre n'est trouvé -->
                        <p>Aucun livre trouvé.</p>
                    <?php endif; ?>
                </div>
                <!-- Bouton pour voir tous les livres dans une page dédiée -->
                <a href="<?php echo url('catalog/books'); ?>" class="btn btn-view-all">Tout voir!</a>
            </div>

            <!-- Section des films dans le catalogue -->
            <div class="catalog-section">
                <!-- Titre de la section des films -->
                <h2>Films</h2>
                <!-- Conteneur pour le carrousel des films -->
                <div class="carousel-container">
                    <?php
                    // Filtre les éléments pour ne garder que les films
                    $movies = array_filter($items, function ($item) {
                        return $item['type'] == 'film';
                    });
                    if (!empty($movies)): ?>
                        <?php foreach ($movies as $item): ?>
                            <!-- Élément individuel du carrousel pour chaque film -->
                            <div class="carousel-item">
                                <!-- Image du film avec une URL par défaut si non disponible -->
                                <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/150'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                <!-- Titre du film avec échappement pour la sécurité -->
                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <!-- Affichage du genre du film -->
                                <p>Genre: <?php echo htmlspecialchars($item['genre'] ?? 'N/A'); ?></p>
                                <!-- Affichage de l'année de sortie -->
                                <p>Year: <?php echo htmlspecialchars($item['year'] ?? 'N/A'); ?></p>
                                <!-- Actions disponibles pour le film -->
                                <div class="carousel-actions">
                                    <?php if ($item['available']): ?>
                                        <!-- Lien pour emprunter le film si disponible -->
                                        <a href="<?php echo url('rental/rent/' . $item['id']); ?>" class="btn btn-rent">Emprunter</a>
                                    <?php endif; ?>
                                    <!-- Lien pour afficher les détails du film dans une modale -->
                                    <a href="#item-<?php echo $item['id']; ?>" class="btn btn-detail">Détails</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Message affiché si aucun film n'est trouvé -->
                        <p>Aucun film trouvé.</p>
                    <?php endif; ?>
                </div>
                <!-- Bouton pour voir tous les films dans une page dédiée -->
                <a href="<?php echo url('catalog/movies'); ?>" class="btn btn-view-all">Tout voir!</a>
            </div>

            <!-- Section des jeux vidéo dans le catalogue -->
            <div class="catalog-section">
                <!-- Titre de la section des jeux vidéo -->
                <h2>Jeux Vidéo</h2>
                <!-- Conteneur pour le carrousel des jeux vidéo -->
                <div class="carousel-container">
                    <?php
                    // Filtre les éléments pour ne garder que les jeux vidéo
                    $games = array_filter($items, function ($item) {
                        return $item['type'] == 'game';
                    });
                    if (!empty($games)): ?>
                        <?php foreach ($games as $item): ?>
                            <!-- Élément individuel du carrousel pour chaque jeu vidéo -->
                            <div class="carousel-item">
                                <!-- Image du jeu vidéo avec une URL par défaut si non disponible -->
                                <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/150'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                <!-- Titre du jeu vidéo avec échappement pour la sécurité -->
                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <!-- Affichage du genre du jeu vidéo -->
                                <p>Genre: <?php echo htmlspecialchars($item['genre'] ?? 'N/A'); ?></p>
                                <!-- Affichage de l'année de sortie -->
                                <p>Year: <?php echo htmlspecialchars($item['year'] ?? 'N/A'); ?></p>
                                <!-- Actions disponibles pour le jeu vidéo -->
                                <div class="carousel-actions">
                                    <?php if ($item['available']): ?>
                                        <!-- Lien pour emprunter le jeu vidéo si disponible -->
                                        <a href="<?php echo url('rental/rent/' . $item['id']); ?>" class="btn btn-rent">Emprunter</a>
                                    <?php endif; ?>
                                    <!-- Lien pour afficher les détails du jeu vidéo dans une modale -->
                                    <a href="#item-<?php echo $item['id']; ?>" class="btn btn-detail">Détails</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Message affiché si aucun jeu vidéo n'est trouvé -->
                        <p>Aucun jeu vidéo trouvé.</p>
                    <?php endif; ?>
                </div>
                <!-- Bouton pour voir tous les jeux vidéo dans une page dédiée -->
                <a href="<?php echo url('catalog/games'); ?>" class="btn btn-view-all">Tout voir!</a>
            </div>

            <!-- Modale pour afficher les détails de chaque élément -->
            <?php foreach ($items as $item): ?>
                <!-- Conteneur de la modale avec un identifiant unique pour chaque élément -->
                <div class="modal" id="item-<?php echo $item['id']; ?>">
                    <!-- Contenu de la modale -->
                    <div class="modal-content">
                        <!-- Section des détails de l'élément -->
                        <div class="detail">
                            <!-- Image de l'élément avec une URL par défaut pour la modale -->
                            <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/300'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                            <!-- Titre de l'élément -->
                            <h2><?php echo htmlspecialchars($item['title']); ?></h2>
                            <!-- Affichage du genre de l'élément -->
                            <p>Genre: <?php echo htmlspecialchars($item['genre'] ?? 'N/A'); ?></p>
                            <!-- Affichage de l'année de l'élément -->
                            <p>Year: <?php echo htmlspecialchars($item['year'] ?? 'N/A'); ?></p>
                            <!-- Affichage du résumé de l'élément -->
                            <p>Résumé: <?php echo htmlspecialchars($item['description'] ?? 'N/A'); ?></p>
                            <?php if ($item['type'] == 'book'): ?>
                                <!-- Détails spécifiques pour les livres -->
                                <p>Auteur: <?php echo htmlspecialchars($item['writer_producer_editor'] ?? 'N/A'); ?></p>
                                <p>ISBN: <?php echo htmlspecialchars($item['ISBN13_classification_platform'] ?? 'N/A'); ?></p>
                                <p>Pages: <?php echo htmlspecialchars($item['page_number_duration_min_age'] ?? 'N/A'); ?></p>
                            <?php elseif ($item['type'] == 'film'): ?>
                                <!-- Détails spécifiques pour les films -->
                                <p>Directeur: <?php echo htmlspecialchars($item['writer_producer_editor'] ?? 'N/A'); ?></p>
                                <p>Note: <?php echo htmlspecialchars($item['ISBN13_classification_platform'] ?? 'N/A'); ?></p>
                                <p>Durée: <?php echo htmlspecialchars($item['page_number_duration_min_age'] ?? 'N/A'); ?> min</p>
                            <?php elseif ($item['type'] == 'game'): ?>
                                <!-- Détails spécifiques pour les jeux vidéo -->
                                <p>Éditeur: <?php echo htmlspecialchars($item['writer_producer_editor'] ?? 'N/A'); ?></p>
                                <p>Plate-forme: <?php echo htmlspecialchars($item['ISBN13_classification_platform'] ?? 'N/A'); ?></p>
                                <p>Âge minimum: <?php echo htmlspecialchars($item['page_number_duration_min_age'] ?? 'N/A'); ?></p>
                            <?php endif; ?>
                            <!-- Affichage de l'état de disponibilité de l'élément -->
                            <p>Statut: <?php echo $item['available'] ? 'Disponible' : 'Emprunté'; ?></p>
                            <!-- Conteneur des boutons d'action dans la modale -->
                            <div>
                                <?php if ($item['available']): ?>
                                    <!-- Bouton pour emprunter l'élément si disponible -->
                                    <a href="<?php echo url('rental/rent/' . $item['id']); ?>" class="btn btn-rent">Emprunter</a>
                                <?php endif; ?>
                                <!-- Bouton pour fermer la modale -->
                                <a href="#close-modal" class="btn btn-back">Fermer</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- Section pour guider les utilisateurs sur les étapes de démarrage -->
        <section class="getting-started">
            <!-- Titre de la section pour commencer -->
            <h2>Commencez</h2>
            <!-- Liste des étapes pour commencer à utiliser la médiathèque -->
            <div class="steps">
                <div class="step">1. Inscription</div>
                <div class="step">2. Recherches</div>
                <div class="step">3. Emprunts</div>
            </div>
        </section>

        <!-- Élément caché pour empêcher le saut de page lors de la fermeture de la modale -->
        <div id="close-modal" style="display: none;"></div>
    </section>

    <!-- Inclusion du script JavaScript pour ajouter des fonctionnalités interactives -->
    <script src="<?php echo url('assets/js/app.js'); ?>"></script>
</body>

</html>