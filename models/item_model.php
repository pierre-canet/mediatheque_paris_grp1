<?php
require_once CORE_PATH . '/database.php';

// Sélectionner tous les items
// Correction : Utilisation de producer au lieu de director pour la table movies
function get_all_items() {
    $query = "
        SELECT CONCAT('book_', id) AS id, title, writer AS author_director_publisher, ISBN13 AS isbn_rating_platform, gender AS genre, page_number AS pages_duration_min_age, synopsis AS description, year, available, stock, image_url, 'book' AS type FROM books
        UNION
        SELECT CONCAT('film_', id) AS id, title, producer AS author_director_publisher, classification AS isbn_rating_platform, gender AS genre, `duration(m)` AS pages_duration_min_age, synopsis AS description, year, available, stock, image_url, 'film' AS type FROM movies
        UNION
        SELECT CONCAT('game_', id) AS id, title, editor AS author_director_publisher, plateform AS isbn_rating_platform, gender AS genre, min_age AS pages_duration_min_age, description, year, available, stock, image_url, 'game' AS type FROM video_games
        ORDER BY year DESC";
    return db_select($query);
}

// Sélectionner les items par type
// Correction : Utilisation de producer au lieu de director pour la table movies
function get_items_by_type($type, $search_term = '', $search_genre = 'all', $search_availability = 'all', $per_page = 20, $offset = 0) {
    $pdo = db_connect();
    $conditions = [];
    $params = [];

    // Recherche par titre
    if (!empty($search_term)) {
        $conditions[] = "LOWER(title) LIKE LOWER(?)";
        $params[] = "%" . trim($search_term) . "%";
    }

    // Filtrer par genre
    if ($search_genre != 'all') {
        $conditions[] = "gender = ?";
        $params[] = $search_genre;
    }

    // Filtrer par disponibilité
    if ($search_availability != 'all') {
        $conditions[] = "available = ?";
        $params[] = ($search_availability == 'true') ? 1 : 0;
    }

    $condition_str = !empty($conditions) ? " WHERE " . implode(" AND ", $conditions) : "";

    // Sélection selon le type
    if ($type == 'book') {
        $query = "SELECT CONCAT('book_', id) AS id, title, writer AS author_director_publisher, ISBN13 AS isbn_rating_platform, gender AS genre, page_number AS pages_duration_min_age, synopsis AS description, year, available, stock, image_url, 'book' AS type 
                  FROM books" . $condition_str . "
                  ORDER BY year DESC 
                  LIMIT ? OFFSET ?";
    } elseif ($type == 'film') {
        $query = "SELECT CONCAT('film_', id) AS id, title, producer AS author_director_publisher, classification AS isbn_rating_platform, gender AS genre, `duration(m)` AS pages_duration_min_age, synopsis AS description, year, available, stock, image_url, 'film' AS type 
                  FROM movies" . $condition_str . "
                  ORDER BY year DESC 
                  LIMIT ? OFFSET ?";
    } elseif ($type == 'game') {
        $query = "SELECT CONCAT('game_', id) AS id, title, editor AS author_director_publisher, plateform AS isbn_rating_platform, gender AS genre, min_age AS pages_duration_min_age, description, year, available, stock, image_url, 'game' AS type 
                  FROM video_games" . $condition_str . "
                  ORDER BY year DESC 
                  LIMIT ? OFFSET ?";
    } else {
        return [];
    }

    $params[] = (int)$per_page;
    $params[] = (int)$offset;

    $stmt = $pdo->prepare($query);
    foreach ($params as $index => $value) {
        $stmt->bindValue($index + 1, $value);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtenir le nombre total d'items par type avec filtres de recherche
// Sans modification : car ne dépend pas de la colonne producer
function get_total_items_by_type($type, $search_term = '', $search_genre = 'all', $search_availability = 'all') {
    $pdo = db_connect();
    $conditions = [];
    $params = [];

    // Recherche par titre
    if (!empty($search_term)) {
        $conditions[] = "LOWER(title) LIKE LOWER(?)";
        $params[] = "%" . trim($search_term) . "%";
    }

    // Filtrer par genre
    if ($search_genre != 'all') {
        $conditions[] = "gender = ?";
        $params[] = $search_genre;
    }

    // Filtrer par disponibilité
    if ($search_availability != 'all') {
        $conditions[] = "available = ?";
        $params[] = ($search_availability == 'true') ? 1 : 0;
    }

    $condition_str = !empty($conditions) ? " WHERE " . implode(" AND ", $conditions) : "";

    // Sélection selon le type
    if ($type == 'book') {
        $query = "SELECT COUNT(*) FROM books" . $condition_str;
    } elseif ($type == 'film') {
        $query = "SELECT COUNT(*) FROM movies" . $condition_str;
    } elseif ($type == 'game') {
        $query = "SELECT COUNT(*) FROM video_games" . $condition_str;
    } else {
        return 0;
    }

    $stmt = $pdo->prepare($query);
    foreach ($params as $index => $value) {
        $stmt->bindValue($index + 1, $value);
    }
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

// Sélectionner un item par ID combiné
// Correction : Utilisation de producer au lieu de director pour la table movies
function get_item_by_id($item_id) {
    $parts = explode('_', $item_id);
    if (count($parts) !== 2) return false;
    [$type, $id] = $parts;

    $pdo = db_connect();

    // Sélection selon le type
    if ($type == 'book') {
        $query = "SELECT CONCAT('book_', id) AS id, title, writer AS author_director_publisher, ISBN13 AS isbn_rating_platform, gender AS genre, page_number AS pages_duration_min_age, synopsis AS description, year, available, stock, image_url, 'book' AS type 
                  FROM books WHERE id = ?";
    } elseif ($type == 'film') {
        $query = "SELECT CONCAT('film_', id) AS id, title, producer AS author_director_publisher, classification AS isbn_rating_platform, gender AS genre, `duration(m)` AS pages_duration_min_age, synopsis AS description, year, available, stock, image_url, 'film' AS type 
                  FROM movies WHERE id = ?";
    } elseif ($type == 'game') {
        $query = "SELECT CONCAT('game_', id) AS id, title, editor AS author_director_publisher, plateform AS isbn_rating_platform, gender AS genre, min_age AS pages_duration_min_age, description, year, available, stock, image_url, 'game' AS type 
                  FROM video_games WHERE id = ?";
    } else {
        return false;
    }

    return db_select_one($query, [$id]);
}

// Mettre à jour la disponibilité d'un item
// Sans modification : car ne dépend pas de la colonne producer
function update_item_availability($item_id, $available) {
    $parts = explode('_', $item_id);
    if (count($parts) !== 2) return false;
    [$type, $id] = $parts;

    // Déterminer la table selon le type
    if ($type == 'book') {
        $table = 'books';
    } elseif ($type == 'film') {
        $table = 'movies';
    } elseif ($type == 'game') {
        $table = 'video_games';
    } else {
        return false;
    }

    $query = "UPDATE $table SET available = ? WHERE id = ?";
    return db_execute($query, [$available, $id]);
}

// Recherche des items
// Correction : Utilisation de producer au lieu de director pour la table movies
function search_items($search_term = '', $search_type = 'all', $search_genre = 'all', $search_availability = 'all') {
    $pdo = db_connect();
    $conditions = [];
    $params = [];

    // Recherche par titre
    if (!empty($search_term)) {
        $conditions[] = "LOWER(title) LIKE LOWER(?)";
        $params[] = "%" . trim($search_term) . "%";
    }

    // Filtrer par genre
    if ($search_genre != 'all') {
        $conditions[] = "gender = ?";
        $params[] = $search_genre;
    }

    // Filtrer par disponibilité
    if ($search_availability != 'all') {
        $conditions[] = "available = ?";
        $params[] = ($search_availability == 'true') ? 1 : 0;
    }

    $condition_str = !empty($conditions) ? " AND " . implode(" AND ", $conditions) : "";

    // Sélection selon le type
    if ($search_type == 'book') {
        $query = "
            SELECT CONCAT('book_', id) AS id, title, writer AS author_director_publisher, ISBN13 AS isbn_rating_platform, gender AS genre, page_number AS pages_duration_min_age, synopsis AS description, year, available, stock, image_url, 'book' AS type
            FROM books
            WHERE 1=1 $condition_str";
    } elseif ($search_type == 'film') {
        $query = "
            SELECT CONCAT('film_', id) AS id, title, producer AS author_director_publisher, classification AS isbn_rating_platform, gender AS genre, `duration(m)` AS pages_duration_min_age, synopsis AS description, year, available, stock, image_url, 'film' AS type
            FROM movies
            WHERE 1=1 $condition_str";
    } elseif ($search_type == 'game') {
        $query = "
            SELECT CONCAT('game_', id) AS id, title, editor AS author_director_publisher, plateform AS isbn_rating_platform, gender AS genre, min_age AS pages_duration_min_age, description, year, available, stock, image_url, 'game' AS type
            FROM video_games
            WHERE 1=1 $condition_str";
    } else {
        $query = "
            SELECT CONCAT('book_', id) AS id, title, writer AS author_director_publisher, ISBN13 AS isbn_rating_platform, gender AS genre, page_number AS pages_duration_min_age, synopsis AS description, year, available, stock, image_url, 'book' AS type
            FROM books
            WHERE 1=1 $condition_str
            UNION ALL
            SELECT CONCAT('film_', id) AS id, title, producer AS author_director_publisher, classification AS isbn_rating_platform, gender AS genre, `duration(m)` AS pages_duration_min_age, synopsis AS description, year, available, stock, image_url, 'film' AS type
            FROM movies
            WHERE 1=1 $condition_str
            UNION ALL
            SELECT CONCAT('game_', id) AS id, title, editor AS author_director_publisher, plateform AS isbn_rating_platform, gender AS genre, min_age AS pages_duration_min_age, description, year, available, stock, image_url, 'game' AS type
            FROM video_games
            WHERE 1=1 $condition_str";
        // Répéter les params pour chaque partie du UNION
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
?>