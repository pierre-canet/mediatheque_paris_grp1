<?php
// Vue pour la page du catalogue
// Utilisation de la fonction url() pour générer des liens dynamiques et compatibles avec BASE_URL
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Digitale</title>
    <link rel="stylesheet" href="<?php echo url('assets/css/style.css'); ?>">
</head>
<body>
    <section class="container">
        <section class="banner">
            <section class="hero-banner">
                <h1>Catalogue de la Médiathèque</h1>
                <p class="hero-subtitle">Découvrez notre collection de médias organisée par catégorie</p>
            </section>
        </section>

        <!-- Formulaire de recherche -->
        <section class="search-filters">
            <form method="GET" action="<?php echo url('catalog/index'); ?>">
                <!-- Utilisation de url() pour l'action du formulaire -->
                <input type="hidden" name="url" value="catalog/index">
                <div class="search-bar">
                    <input type="text" name="search_term" placeholder="Rechercher dans tous les médias" class="search-input" value="<?php echo htmlspecialchars($search_term ?? ''); ?>">
                    <button type="submit" class="search-button">Rechercher</button>
                    <?php if ($is_searching): ?>
                        <a href="<?php echo url('catalog/index'); ?>" class="btn btn-secondary" style="margin-left: 10px;">Effacer</a>
                        <!-- Lien reset au lieu d'un chemin codé en dur -->
                    <?php endif; ?>
                </div>

                <div class="filters">
                    <div class="filter-group">
                        <label for="type">Type de média</label>
                        <select id="type" name="type" class="filter-select">
                            <option value="all" <?php echo ($search_type ?? 'all') == 'all' ? 'selected' : ''; ?>>Tous</option>
                            <option value="book" <?php echo ($search_type ?? '') == 'book' ? 'selected' : ''; ?>>Livres</option>
                            <option value="film" <?php echo ($search_type ?? '') == 'film' ? 'selected' : ''; ?>>Films</option>
                            <option value="game" <?php echo ($search_type ?? '') == 'game' ? 'selected' : ''; ?>>Jeux Vidéo</option>
                        </select>
                    </div>
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
// Section des résultats de recherche et carrousels - les carrousels sont toujours affichés
?>
<section class="search-results">
    <?php if ($is_searching): ?>
        <h2>Résultats de recherche</h2>
        <?php if (empty($items)): ?>
            <p class="no-results">Aucun résultat trouvé pour votre recherche.</p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Section des livres -->
    <div class="catalog-section">
        <h2>Livres</h2>
        <div class="carousel-container">
            <?php
            $books = array_filter($items, function($item) {
                return $item['type'] == 'book';
            });
            if (!empty($books)): ?>
                <?php foreach ($books as $item): ?>
                    <div class="carousel-item">
                        <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/150'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p>Genre: <?php echo htmlspecialchars($item['genre'] ?? 'N/A'); ?></p>
                        <p>Année: <?php echo htmlspecialchars($item['year'] ?? 'N/A'); ?></p>
                        <div class="carousel-actions">
                            <?php if ($item['available']): ?>
                                <a href="<?php echo url('rental/rent/' . $item['id']); ?>" class="btn btn-rent">Emprunter</a>
                            <?php endif; ?>
                            <a href="#item-<?php echo $item['id']; ?>" class="btn btn-detail">Détails</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun livre trouvé.</p>
            <?php endif; ?>
        </div>
        <!-- Bouton voir tous les livres -->
        <a href="<?php echo url('catalog/books'); ?>" class="btn btn-view-all">Tout voir!</a>
    </div>

    <!-- Section des films -->
    <div class="catalog-section">
        <h2>Films</h2>
        <div class="carousel-container">
            <?php
            $movies = array_filter($items, function($item) {
                return $item['type'] == 'film';
            });
            if (!empty($movies)): ?>
                <?php foreach ($movies as $item): ?>
                    <div class="carousel-item">
                        <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/150'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p>Genre: <?php echo htmlspecialchars($item['genre'] ?? 'N/A'); ?></p>
                        <p>Année: <?php echo htmlspecialchars($item['year'] ?? 'N/A'); ?></p>
                        <div class="carousel-actions">
                            <?php if ($item['available']): ?>
                                <a href="<?php echo url('rental/rent/' . $item['id']); ?>" class="btn btn-rent">Emprunter</a>
                            <?php endif; ?>
                            <a href="#item-<?php echo $item['id']; ?>" class="btn btn-detail">Détails</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun film trouvé.</p>
            <?php endif; ?>
        </div>
        <!-- Bouton voir tous les films -->
        <a href="<?php echo url('catalog/movies'); ?>" class="btn btn-view-all">Tout voir!</a>
    </div>

    <!-- Section des jeux vidéo -->
    <div class="catalog-section">
        <h2>Jeux Vidéo</h2>
        <div class="carousel-container">
            <?php
            $games = array_filter($items, function($item) {
                return $item['type'] == 'game';
            });
            if (!empty($games)): ?>
                <?php foreach ($games as $item): ?>
                    <div class="carousel-item">
                        <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/150'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p>Genre: <?php echo htmlspecialchars($item['genre'] ?? 'N/A'); ?></p>
                        <p>Année: <?php echo htmlspecialchars($item['year'] ?? 'N/A'); ?></p>
                        <div class="carousel-actions">
                            <?php if ($item['available']): ?>
                                <a href="<?php echo url('rental/rent/' . $item['id']); ?>" class="btn btn-rent">Emprunter</a>
                            <?php endif; ?>
                            <a href="#item-<?php echo $item['id']; ?>" class="btn btn-detail">Détails</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun jeu vidéo trouvé.</p>
            <?php endif; ?>
        </div>
        <!-- Bouton voir tous les jeux vidéo -->
        <a href="<?php echo url('catalog/games'); ?>" class="btn btn-view-all">Tout voir!</a>
    </div>

    <!-- Menu déroulant (modal) pour les détails de chaque item -->
    <?php foreach ($items as $item): ?>
        <div class="modal" id="item-<?php echo $item['id']; ?>">
            <div class="modal-content">
                <div class="detail">
                    <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/300'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                    <h2><?php echo htmlspecialchars($item['title']); ?></h2>
                    <p>Genre: <?php echo htmlspecialchars($item['genre'] ?? 'N/A'); ?></p>
                    <p>Année: <?php echo htmlspecialchars($item['year'] ?? 'N/A'); ?></p>
                    <p>Résumé: <?php echo htmlspecialchars($item['description'] ?? 'N/A'); ?></p>
                    <?php if ($item['type'] == 'book'): ?>
                        <p>Auteur: <?php echo htmlspecialchars($item['author_director_publisher'] ?? 'N/A'); ?></p>
                        <p>ISBN: <?php echo htmlspecialchars($item['isbn_rating_platform'] ?? 'N/A'); ?></p>
                        <p>Pages: <?php echo htmlspecialchars($item['pages_duration_min_age'] ?? 'N/A'); ?></p>
                    <?php elseif ($item['type'] == 'film'): ?>
                        <p>Réalisateur: <?php echo htmlspecialchars($item['author_director_publisher'] ?? 'N/A'); ?></p>
                        <p>Note: <?php echo htmlspecialchars($item['isbn_rating_platform'] ?? 'N/A'); ?></p>
                        <p>Durée: <?php echo htmlspecialchars($item['pages_duration_min_age'] ?? 'N/A'); ?> min</p>
                    <?php elseif ($item['type'] == 'game'): ?>
                        <p>Éditeur: <?php echo htmlspecialchars($item['author_director_publisher'] ?? 'N/A'); ?></p>
                        <p>Plate-forme: <?php echo htmlspecialchars($item['isbn_rating_platform'] ?? 'N/A'); ?></p>
                        <p>Âge minimum: <?php echo htmlspecialchars($item['pages_duration_min_age'] ?? 'N/A'); ?></p>
                    <?php endif; ?>
                    <p>Statut: <?php echo $item['available'] ? 'Disponible' : 'Emprunté'; ?></p>
                    <div>
                        <?php if ($item['available']): ?>
                            <a href="<?php echo url('rental/rent/' . $item['id']); ?>" class="btn btn-rent">Emprunter</a>
                        <?php endif; ?>
                        <a href="#close-modal" class="btn btn-back">Fermer</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>

        <section class="getting-started">
            <h2>Commencez</h2>
            <div class="steps">
                <div class="step">1. Inscription</div>
                <div class="step">2. Recherches</div>
                <div class="step">3. Emprunts</div>
            </div>
        </section>

        <!-- Élément caché pour éviter le saut de page -->
        <div id="close-modal" style="display: none;"></div>
    </section>

</body>
</html>