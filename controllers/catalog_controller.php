<?php
// Contrôleur pour la gestion du catalogue
require_once MODEL_PATH . '/item_model.php';

function catalog_index($search_term = '', $search_type = 'all', $search_genre = 'all', $search_availability = 'all') {
    // Réinitialisation des paramètres si la requête est directe vers /catalog/index
    if (empty($_GET['search_term']) && empty($_GET['type']) && empty($_GET['genre']) && empty($_GET['availability'])) {
        $search_term = '';
        $search_type = 'all';
        $search_genre = 'all';
        $search_availability = 'all';
    } else {
        $search_term = $_GET['search_term'] ?? $search_term;
        $search_type = $_GET['type'] ?? $search_type;
        $search_genre = $_GET['genre'] ?? $search_genre;
        $search_availability = $_GET['availability'] ?? $search_availability;
    }

    $items = search_items($search_term, $search_type, $search_genre, $search_availability);

    $data = [
        'title' => 'Catalogue',
        'items' => $items,
        'is_searching' => !empty($search_term) || $search_type != 'all' || $search_genre != 'all' || $search_availability != 'all',
        'search_term' => $search_term,
        'search_type' => $search_type,
        'search_genre' => $search_genre,
        'search_availability' => $search_availability
    ];

    load_view_with_layout('catalog/index', $data);
}

function catalog_books() {
    // Récupération des paramètres de recherche pour les livres
    $search_term = $_GET['search_term'] ?? '';
    $search_genre = $_GET['genre'] ?? 'all';
    $search_availability = $_GET['availability'] ?? 'all';

    // Nombre d'éléments par page
    $per_page = 20;
    // Récupération du numéro de la page actuelle
    $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Récupération du nombre total de livres avec les filtres de recherche
    $pdo = db_connect();
    $total_items = get_total_items_by_type('book', $search_term, $search_genre, $search_availability);
    // Calcul du nombre total de pages
    $total_pages = ceil($total_items / $per_page);
    // Vérification de la validité du numéro de page
    $current_page = max(1, min($current_page, $total_pages));
    // Calcul du point de départ pour la requête
    $offset = ($current_page - 1) * $per_page;
    // Récupération des éléments de la page actuelle avec les filtres de recherche
    $items = get_items_by_type('book', $search_term, $search_genre, $search_availability, $per_page, $offset);

    $data = [
        'title' => 'Livres',
        'items' => $items,
        'current_page' => $current_page,
        'total_pages' => $total_pages,
        'search_term' => $search_term,
        'search_genre' => $search_genre,
        'search_availability' => $search_availability
    ];
    load_view_with_layout('catalog/books', $data);
}

function catalog_movies() {
    // Récupération des paramètres de recherche pour les films
    $search_term = $_GET['search_term'] ?? '';
    $search_genre = $_GET['genre'] ?? 'all';
    $search_availability = $_GET['availability'] ?? 'all';

    // Nombre d'éléments par page
    $per_page = 20;
    // Récupération du numéro de la page actuelle
    $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Récupération du nombre total de films avec les filtres de recherche
    $pdo = db_connect();
    $total_items = get_total_items_by_type('film', $search_term, $search_genre, $search_availability);
    // Calcul du nombre total de pages
    $total_pages = ceil($total_items / $per_page);
    // Vérification de la validité du numéro de page
    $current_page = max(1, min($current_page, $total_pages));
    // Calcul du point de départ pour la requête
    $offset = ($current_page - 1) * $per_page;
    // Récupération des éléments de la page actuelle avec les filtres de recherche
    $items = get_items_by_type('film', $search_term, $search_genre, $search_availability, $per_page, $offset);

    $data = [
        'title' => 'Films',
        'items' => $items,
        'current_page' => $current_page,
        'total_pages' => $total_pages,
        'search_term' => $search_term,
        'search_genre' => $search_genre,
        'search_availability' => $search_availability
    ];
    load_view_with_layout('catalog/movies', $data);
}

function catalog_games() {
    // Récupération des paramètres de recherche pour les jeux vidéo
    $search_term = $_GET['search_term'] ?? '';
    $search_genre = $_GET['genre'] ?? 'all';
    $search_availability = $_GET['availability'] ?? 'all';

    // Nombre d'éléments par page
    $per_page = 20;
    // Récupération du numéro de la page actuelle
    $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Récupération du nombre total de jeux vidéo avec les filtres de recherche
    $pdo = db_connect();
    $total_items = get_total_items_by_type('game', $search_term, $search_genre, $search_availability);
    // Calcul du nombre total de pages
    $total_pages = ceil($total_items / $per_page);
    // Vérification de la validité du numéro de page
    $current_page = max(1, min($current_page, $total_pages));
    // Calcul du point de départ pour la requête
    $offset = ($current_page - 1) * $per_page;
    // Récupération des éléments de la page actuelle avec les filtres de recherche
    $items = get_items_by_type('game', $search_term, $search_genre, $search_availability, $per_page, $offset);
    $data = [
        'title' => 'Jeux Vidéo',
        'items' => $items,
        'current_page' => $current_page,
        'total_pages' => $total_pages,
        'search_term' => $search_term,
        'search_genre' => $search_genre,
        'search_availability' => $search_availability
    ];
    load_view_with_layout('catalog/games', $data);
}
?>