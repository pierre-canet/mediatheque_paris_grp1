<?php
// Contrôleur pour la gestion du catalogue
require_once MODEL_PATH . '/item_model.php';

function catalog_index($search_term = '', $search_type = 'all', $search_genre = 'all', $search_availability = 'all') {
    // Réinitialiser les paramètres si la requête est directe vers /catalog/index
    if (empty($_GET['search_term']) && empty($_GET['type']) && empty($_GET['genre']) && empty($_GET['availability'])) {
        $search_term = '';
        $search_type = 'all';
        $search_genre = 'all';
        $search_availability = 'all';
    } else {
        // Récupérer les paramètres de recherche depuis l'URL ou utiliser les valeurs par défaut
        $search_term = $_GET['search_term'] ?? $search_term;
        $search_type = $_GET['type'] ?? $search_type;
        $search_genre = $_GET['genre'] ?? $search_genre;
        $search_availability = $_GET['availability'] ?? $search_availability;
    }

    // Rechercher les items selon les filtres
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

    // Charger la vue du catalogue avec les données
    load_view_with_layout('catalog/index', $data);
}

function catalog_books() {
    // Récupérer les paramètres de recherche pour les livres
    $search_term = $_GET['search_term'] ?? '';
    $search_genre = $_GET['genre'] ?? 'all';
    $search_availability = $_GET['availability'] ?? 'all';

    // Nombre d'items par page
    $per_page = 20;
    // Récupérer le numéro de la page actuelle
    $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Récupérer le nombre total de livres avec les filtres de recherche
    $pdo = db_connect();
    $total_items = get_total_items_by_type('book', $search_term, $search_genre, $search_availability);
    // Calculer le nombre total de pages
    $total_pages = ceil($total_items / $per_page);
    // S'assurer que le numéro de page est valide
    $current_page = max(1, min($current_page, $total_pages));
    // Calculer le point de départ pour la requête
    $offset = ($current_page - 1) * $per_page;
    // Récupérer les items de la page actuelle avec les filtres de recherche
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
    // Charger la vue des livres avec les données
    load_view_with_layout('catalog/books', $data);
}

function catalog_movies() {
    // Récupérer les paramètres de recherche pour les films
    $search_term = $_GET['search_term'] ?? '';
    $search_genre = $_GET['genre'] ?? 'all';
    $search_availability = $_GET['availability'] ?? 'all';

    // Nombre d'items par page
    $per_page = 20;
    // Récupérer le numéro de la page actuelle
    $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Récupérer le nombre total de films avec les filtres de recherche
    $pdo = db_connect();
    $total_items = get_total_items_by_type('film', $search_term, $search_genre, $search_availability);
    // Calculer le nombre total de pages
    $total_pages = ceil($total_items / $per_page);
    // S'assurer que le numéro de page est valide
    $current_page = max(1, min($current_page, $total_pages));
    // Calculer le point de départ pour la requête
    $offset = ($current_page - 1) * $per_page;
    // Récupérer les items de la page actuelle avec les filtres de recherche
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
    // Charger la vue des films avec les données
    load_view_with_layout('catalog/movies', $data);
}

function catalog_games() {
    // Récupérer les paramètres de recherche pour les jeux
    $search_term = $_GET['search_term'] ?? '';
    $search_genre = $_GET['genre'] ?? 'all';
    $search_availability = $_GET['availability'] ?? 'all';

//number of items per page
    $per_page = 20;
// Obtenir le numéro de page actuel
    $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Récupérer le nombre total de jeux avec les filtres de recherche
    $pdo = db_connect();
    $total_items = get_total_items_by_type('game', $search_term, $search_genre, $search_availability);
    // Calculer le nombre total de pages
    $total_pages = ceil($total_items / $per_page);
    // S'assurer que le numéro de page est valide
    $current_page = max(1, min($current_page, $total_pages));
    // Calculer le point de départ pour la requête
    $offset = ($current_page - 1) * $per_page;
    // Récupérer les items de la page actuelle avec les filtres de recherche
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
    // Charger la vue des jeux vidéo avec les données
    load_view_with_layout('catalog/games', $data);
}
?>