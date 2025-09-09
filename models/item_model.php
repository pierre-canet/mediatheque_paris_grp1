<?php
require_once CORE_PATH . '/database.php';

// Modèle pour la gestion des items (livres, films, jeux)

/**
 * Récupère tous les items (tous types confondus)
 * Utilisé pour afficher l'ensemble du catalogue
 */
function get_all_items()
{
    // Prépare la requête pour récupérer tous les items triés par année décroissante
    $query = "
        ORDER BY year DESC";
    return db_select($query);
}

/**
 * Récupère les items selon leur type avec filtres et pagination
 * $type : 'book', 'film', 'game'
 * $search_term : mot-clé de recherche sur le titre
 * $search_genre : filtre sur le genre
 * $search_availability : filtre sur la disponibilité
 * $per_page : nombre d'éléments par page
 * $offset : décalage pour la pagination
 */
function get_items_by_type($type, $search_term = '', $search_genre = 'all', $search_availability = 'all', $per_page = 20, $offset = 0)
{
    $pdo = db_connect();
    $conditions = [];
    $params = [];

    // Ajoute une condition si un mot-clé est saisi
    if (!empty($search_term)) {
        $conditions[] = "LOWER(title) LIKE LOWER(?)";
        $params[] = "%" . trim($search_term) . "%";
    }

    // Ajoute une condition si un genre est sélectionné
    if ($search_genre != 'all') {
        $conditions[] = "gender = ?";
        $params[] = $search_genre;
    }

    // Ajoute une condition si la disponibilité est sélectionnée
    if ($search_availability != 'all') {
        $conditions[] = "available = ?";
        $params[] = ($search_availability == 'true') ? 1 : 0;
    }

    // Construit la chaîne WHERE pour la requête SQL
    $condition_str = !empty($conditions) ? " WHERE " . implode(" AND ", $conditions) : "";

    // Sélectionne la table selon le type demandé
    if ($type == 'book') {
        // Requête pour les livres
        $query = "SELECT CONCAT('book_', id) AS id, title, writer AS writer_producer_editor, ISBN13 AS ISBN13_classification_platform, gender, page_number AS page_number_duration_min_age, synopsis, year, available, stock, image_url, 'book' AS type 
                  FROM books" . $condition_str . "
                  ORDER BY year DESC 
                  LIMIT ? OFFSET ?";
    } elseif ($type == 'movies') {
        // Requête pour les films
        $query = "SELECT CONCAT('movies_', id) AS id, title, producer AS writer_producer_editor, classification AS ISBN13_classification_platform, gender, duration AS page_number_duration_min_age, synopsis, year, available, stock, image_url, 'film' AS type 
                  FROM movies" . $condition_str . "
                  ORDER BY year DESC 
                  LIMIT ? OFFSET ?";
    } elseif ($type == 'game') {
        // Requête pour les jeux
        $query = "SELECT CONCAT('video_games_', id) AS id, title, editor AS writer_producer_editor, platform AS ISBN13_classification_platform, gender, min_age AS page_number_duration_min_age, description, year, available, stock, image_url, 'game' AS type 
                  FROM video_games" . $condition_str . "
                  ORDER BY year DESC 
                  LIMIT ? OFFSET ?";
    } else {
        // Si le type n'est pas reconnu, retourne un tableau vide
        return [];
    }

    // Ajoute les paramètres pour la pagination
    $params[] = (int)$per_page;
    $params[] = (int)$offset;

    // Prépare et exécute la requête SQL
    $stmt = $pdo->prepare($query);
    foreach ($params as $index => $value) {
        $stmt->bindValue($index + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère le nombre total d'items selon le type et les filtres
 * Utile pour la pagination
 */
function get_total_items_by_type($type, $search_term = '', $search_genre = 'all', $search_availability = 'all')
{
    $pdo = db_connect();
    $conditions = [];
    $params = [];

    // Ajoute une condition si un mot-clé est saisi
    if (!empty($search_term)) {
        $conditions[] = "LOWER(title) LIKE LOWER(?)";
        $params[] = "%" . trim($search_term) . "%";
    }

    // Ajoute une condition si un genre est sélectionné
    if ($search_genre != 'all') {
        $conditions[] = "gender = ?";
        $params[] = $search_genre;
    }

    // Ajoute une condition si la disponibilité est sélectionnée
    if ($search_availability != 'all') {
        $conditions[] = "available = ?";
        $params[] = ($search_availability == 'true') ? 1 : 0;
    }

    // Construit la chaîne WHERE pour la requête SQL
    $condition_str = !empty($conditions) ? " WHERE " . implode(" AND ", $conditions) : "";

    // Sélectionne la table selon le type demandé
    if ($type == 'book') {
        // Compte les livres
        $query = "SELECT COUNT(*) FROM books" . $condition_str;
    } elseif ($type == 'movies') {
        // Compte les films
        $query = "SELECT COUNT(*) FROM movies" . $condition_str;
    } elseif ($type == 'video_games') {
        // Compte les jeux
        $query = "SELECT COUNT(*) FROM video_games" . $condition_str;
    } else {
        // Si le type n'est pas reconnu, retourne 0
        return 0;
    }

    // Prépare et exécute la requête SQL
    $stmt = $pdo->prepare($query);
    foreach ($params as $index => $value) {
        $stmt->bindValue($index + 1, $value);
    }
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Récupère un item selon son ID (avec préfixe pour le type)
 * Permet d'afficher les détails d'un item
 */
function get_item_by_id($id)
{
    $pdo = db_connect();

    // Diagnosis of the original type and ID
    if (strpos($id, 'book_') === 0) {
        $type = 'book';
        $real_id = str_replace('book_', '', $id);
        $query = "SELECT id, title, writer AS writer_producer_editor, ISBN13 AS ISBN13_classification_platform, gender, page_number AS page_number_duration, synopsis, year, available, stock, image_url, 'book' AS type FROM books WHERE id = ?";
    } elseif (strpos($id, 'movies_') === 0) {
        $type = 'movies';
        $real_id = str_replace('movies_', '', $id);
        $query = "SELECT id, title, producer AS writer_producer_editor, classification AS ISBN13_classification_platform, gender, duration AS page_number_duration_min_age, synopsis, year, available, stock, image_url, 'film' AS type FROM films WHERE id = ?";
    } elseif (strpos($id, 'video_games_') === 0) {
        $type = 'video_games';
        $real_id = str_replace('video_games_', '', $id);
        $query = "SELECT id, title, editor AS writer_producer_editor, platform AS ISBN13_classification_platform, gender, min_age AS page_number_duration_min_age, description, year, available, stock, image_url, 'video_games' AS type FROM video_games WHERE id = ?";
    } else {
        // Prise en charge des identifiants sans préfixes pour la compatibilité avec les pages plus anciennes
        $query = "
            SELECT id, title, writer AS writer_producer_editor, ISBN13 AS ISBN13_classification_platform, gender, page_number AS page_number_duration_min_age, synopsis, year, available, stock, image_url, 'book' AS type FROM books WHERE id = ?
            UNION
            SELECT id, title, producer AS writer_producer_editor, classification AS ISBN13_classification_platform, gender, duration AS page_number_duration_min_age, synopsis, year, available, stock, image_url, 'film' AS type FROM films WHERE id = ?
            UNION
            SELECT id, title, editor AS writer_producer_editor, platform AS ISBN13_classification_platform, gender, min_age AS page_number_duration_min_age, description, year, available, stock, image_url, 'video_games' AS type FROM video_games WHERE id = ?
            ORDER BY year DESC LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id, $id, $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute([$real_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        $item['id'] = $type . '_' . $item['id']; // Retourne l'ID combiné
    }

    return $item;
}

/**
 * Met à jour la disponibilité et le stock d'un item
 * Utilisé lors de l'emprunt ou du retour d'un item
 */
function update_item_availability($item_id, $available)
{
    $pdo = db_connect();

    if (strpos($item_id, 'book_') === 0) {
        $real_id = str_replace('book_', '', $item_id);
        $query = "UPDATE books SET available = ?, stock = stock + ? WHERE id = ?";
    } elseif (strpos($item_id, 'movies_') === 0) {
        $real_id = str_replace('movies_', '', $item_id);
        $query = "UPDATE movies SET available = ?, stock = stock + ? WHERE id = ?";
    } elseif (strpos($item_id, 'video_games_') === 0) {
        $real_id = str_replace('video_games_', '', $item_id);
        $query = "UPDATE video_games SET available = ?, stock = stock + ? WHERE id = ?";
    } else {
        return false;
    }

    $stock_change = ($available == 1) ? 1 : -1;
    $stmt = $pdo->prepare($query);
    return $stmt->execute([$available, $stock_change, $real_id]);
}

/**
 * Recherche des items selon les filtres
 * Utilisé pour la recherche globale dans le catalogue
 */
function search_items($search_term, $search_type, $search_genre, $search_availability)
{
    $pdo = db_connect();
    $conditions = [];
    $params = [];

    if (!empty($search_term)) {
        $conditions[] = "LOWER(title) LIKE LOWER(?)";
        $params[] = "%" . trim($search_term) . "%";
    }

    if ($search_genre != 'all') {
        $conditions[] = "gender = ?";
        $params[] = $search_genre;
    }

    if ($search_availability != 'all') {
        $conditions[] = "available = ?";
        $params[] = ($search_availability == 'true') ? 1 : 0;
    }

    $condition_str = !empty($conditions) ? " AND " . implode(" AND ", $conditions) : "";

    if ($search_type == 'book') {
        $query = "
            SELECT CONCAT('book_', id) AS id, title, writer AS writer_producer_editor, ISBN13 AS ISBN13_classification_platform, gender, page_number AS page_number_duration_min_age, synopsis, year, available, stock, image_url, 'book' AS type
            FROM books
            WHERE 1=1 $condition_str";
    } elseif ($search_type == 'movies') {
        $query = "
            SELECT CONCAT('movies_', id) AS id, title, producer AS writer_producer_editor, classification AS ISBN13_classification_platform, gender, duration AS page_number_duration_min_age, synopsis, year, available, stock, image_url, 'film' AS type
            FROM movies
            WHERE 1=1 $condition_str";
    } elseif ($search_type == 'video_games') {
        $query = "
            SELECT CONCAT('video_games_', id) AS id, title, editor AS writer_producer_editor, platform AS ISBN13_classification_platform, gender, min_age AS page_number_duration_min_age, description, year, available, stock, image_url, 'video_games' AS type
            FROM video_games
            WHERE 1=1 $condition_str";
    } else {
        // Correction : Utilisation de UNION ALL pour combiner les données avec des ID uniques
        $query = "
            SELECT CONCAT('book_', id) AS id, title, writer AS writer_producer_editor, ISBN13 AS ISBN13_classification_platform, gender, page_number AS page_number_duration_min_age, synopsis, year, available, stock, image_url, 'book' AS type
            FROM books
            WHERE 1=1 $condition_str
            UNION ALL
            SELECT CONCAT('movies_', id) AS id, title, producer AS writer_producer_editor, classification AS ISBN13_classification_platform, gender, duration AS page_number_duration_min_age, synopsis, year, available, stock, image_url, 'film' AS type
            FROM movies
            WHERE 1=1 $condition_str
            UNION ALL
            SELECT CONCAT('video_games_', id) AS id, title, editor AS writer_producer_editor, platform AS ISBN13_classification_platform, gender, min_age AS page_number_duration_min_age, description, year, available, stock, image_url, 'video_games' AS type
            FROM video_games
            WHERE 1=1 $condition_str";
        // Répéter les paramètres pour chaque section UNION
        if (!empty($params)) {
            $params = array_merge($params, $params, $params);
        }
    }

    $query .= " ORDER BY year DESC";

    $stmt = $pdo->prepare($query);
    foreach ($params as $index => $value) {
        $stmt->bindValue($index + 1, $value);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
