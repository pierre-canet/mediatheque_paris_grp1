<?php
// Affichage de la page des livres
// Utilisation de la fonction url() pour les liens
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title ?? 'Livres'); ?></title>
    <link rel="stylesheet" href="<?php echo url('assets/css/style.css'); ?>">
</head>

<body>
    <section class="container">
        <section class="banner">
            <section class="hero-banner">
                <h1>Catalogue des Livres</h1>
                <p class="hero-subtitle">Découvrez notre collection de livres</p>
            </section>
        </section>
        <!-- Début de la section des filtres de recherche pour la page des livres -->
        <section class="search-filters">
            <!-- Formulaire de recherche avec méthode GET pour envoyer les paramètres à catalog/books -->
            <form method="GET" action="<?php echo url('catalog/books'); ?>">
                <!-- Barre de recherche pour la saisie du titre et les boutons -->
                <div class="search-bar">
                    <!-- Champ de saisie pour la recherche du titre du livre -->
                    <input type="text" name="search_term" placeholder="Rechercher un livre..." class="search-input" value="<?php echo htmlspecialchars($search_term ?? ''); ?>">
                    <!-- Bouton pour soumettre le formulaire et lancer la recherche -->
                    <button type="submit" class="search-button">Rechercher</button>
                    <!-- Affichage du bouton reset : seulement si au moins un filtre est actif -->
                    <?php if (!empty($search_term) || ($search_genre ?? 'all') != 'all' || ($search_availability ?? 'all') != 'all'): ?>
                        <!-- Bouton reset pour effacer tous les filtres et revenir à l'état initial -->
                        <a href="<?php echo url('catalog/books'); ?>" class="btn btn-secondary" style="margin-left: 10px;">Effacer</a>
                    <?php endif; ?>
                </div>
                <!-- Section des filtres supplémentaires (genre et disponibilité) -->
                <div class="filters">
                    <!-- Groupe de filtre pour le genre -->
                    <div class="filter-group">
                        <!-- Label pour le menu déroulant du genre -->
                        <label for="genre">Genre</label>
                        <!-- Menu déroulant pour sélectionner le genre du livre -->
                        <select id="genre" name="genre" class="filter-select">
                            <!-- Option par défaut : tous les genres -->
                            <option value="all" <?php echo ($search_genre ?? 'all') == 'all' ? 'selected' : ''; ?>>Tous</option>
                            <!-- Options spécifiques de genre pour les livres -->
                            <option value="Classique" <?php echo ($search_genre ?? '') == 'Classique' ? 'selected' : ''; ?>>Classique</option>
                            <option value="Science-Fiction" <?php echo ($search_genre ?? '') == 'Science-Fiction' ? 'selected' : ''; ?>>Science-Fiction</option>
                            <option value="Drame" <?php echo ($search_genre ?? '') == 'Drame' ? 'selected' : ''; ?>>Drame</option>
                            <option value="Romance" <?php echo ($search_genre ?? '') == 'Romance' ? 'selected' : ''; ?>>Romance</option>
                            <option value="Fantaisie" <?php echo ($search_genre ?? '') == 'Fantaisie' ? 'selected' : ''; ?>>Fantaisie</option>
                            <option value="Crime" <?php echo ($search_genre ?? '') == 'Crime' ? 'selected' : ''; ?>>Crime</option>
                        </select>
                    </div>
                    <!-- Groupe de filtre pour la disponibilité -->
                    <div class="filter-group">
                        <!-- Label pour le menu déroulant de disponibilité -->
                        <label for="availability">Disponibilité</label>
                        <!-- Menu déroulant pour sélectionner l'état de disponibilité -->
                        <select id="availability" name="availability" class="filter-select">
                            <!-- Option par défaut : tous les états -->
                            <option value="all" <?php echo ($search_availability ?? 'all') == 'all' ? 'selected' : ''; ?>>Tous</option>
                            <!-- Option pour afficher les articles disponibles -->
                            <option value="true" <?php echo ($search_availability ?? '') == 'true' ? 'selected' : ''; ?>>En stock</option>
                            <!-- Option pour afficher les articles empruntés -->
                            <option value="false" <?php echo ($search_availability ?? '') == 'false' ? 'selected' : ''; ?>>Emprunté</option>
                        </select>
                    </div>
                </div>
            </form>
        </section>
        <!-- Fin de la section des filtres de recherche -->
        <div class="grid-container">
            <?php if (empty($items)): ?>
                <p class="no-results">Aucun livre trouvé.</p>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <div class="item">
                        <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/300'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p>Auteur : <?php echo htmlspecialchars($item['writer_producer_editor']); ?></p>
                        <p>Pages : <?php echo htmlspecialchars($item['page_number_duration_min_age']); ?></p>
                        <p>Statut : <?php echo $item['available'] ? 'Disponible' : 'Emprunté'; ?> | Stock : <?php echo htmlspecialchars($item['stock'] ?? '0'); ?></p>
                        <div class="item-buttons">
                            <a href="#item-<?php echo $item['id']; ?>" class="btn btn-detail">Détails</a>
                            <?php if ($item['available']): ?>
                                <a href="<?php echo url('rental/rent/' . $item['id']); ?>" class="btn btn-rent">Emprunter</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <!-- Bouton retour au catalogue -->
            <a href="<?php echo url('catalog/index'); ?>" class="btn btn-catalog-return">Retour au catalogue</a>

            <!-- Bouton page précédente -->
            <?php $current_page = isset($current_page) ? $current_page : 1; ?>
            <?php $total_pages = isset($total_pages) ? $total_pages : 1; ?>
            <?php if ($current_page > 1): ?>
                <a href="<?php echo url('catalog/books?page=' . ($current_page - 1)); ?>" class="btn btn-prev-page">Page précédente</a>
            <?php endif; ?>

            <!-- Liens numériques des pages -->
            <div class="page-numbers">
                <!-- Toujours afficher la page 1 -->
                <a href="<?php echo url('catalog/books?page=1'); ?>" class="page-number <?php echo $current_page == 1 ? 'active' : ''; ?>">1</a>

                <?php
                // Si la page courante est supérieure à 3, afficher "..."
                if ($current_page > 3) {
                    echo '<span class="ellipsis">...</span>';
                }

                // Affichage des pages autour de la page courante (sauf page 1)
                $start_page = max(2, $current_page - 2);
                $end_page = min($total_pages, $current_page + 2);
                for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <a href="<?php echo url('catalog/books?page=' . $i); ?>" class="page-number <?php echo $i == $current_page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <!-- Si la page courante est inférieure au total - 2, afficher "..." -->
                <?php if ($current_page < $total_pages - 2): ?>
                    <span class="ellipsis">...</span>
                <?php endif; ?>
            </div>

            <!-- Bouton page suivante -->
            <?php if ($current_page < $total_pages): ?>
                <a href="<?php echo url('catalog/books?page=' . ($current_page + 1)); ?>" class="btn btn-next-page">Page suivante</a>
            <?php endif; ?>
        </div>

        <!-- Modal pour les détails -->
        <?php foreach ($items as $item): ?>
            <div class="modal" id="item-<?php echo $item['id']; ?>">
                <div class="modal-content">
                    <div class="detail">
                        <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/300'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <h2><?php echo htmlspecialchars($item['title']); ?></h2>
                        <p>Genre : <?php echo htmlspecialchars($item['genre'] ?? 'N/A'); ?></p>
                        <p>Année : <?php echo htmlspecialchars($item['year'] ?? 'N/A'); ?></p>
                        <p>Résumé : <?php echo htmlspecialchars($item['description'] ?? 'N/A'); ?></p>
                        <p>Auteur : <?php echo htmlspecialchars($item['writer_producer_editor'] ?? 'N/A'); ?></p>
                        <p>ISBN : <?php echo htmlspecialchars($item['ISBN13_classification_platform'] ?? 'N/A'); ?></p>
                        <p>Pages : <?php echo htmlspecialchars($item['page_number_duration_min_age'] ?? 'N/A'); ?></p>
                        <p>Statut : <?php echo $item['available'] ? 'Disponible' : 'Emprunté'; ?> | Stock : <?php echo htmlspecialchars($item['stock'] ?? '0'); ?></p>
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

        <!-- Élément caché pour éviter le saut de page -->
        <div id="close-modal" style="display: none;"></div>
    </section>

    <script src="<?php echo url('assets/js/app.js'); ?>"></script>
</body>

</html>