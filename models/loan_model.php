<?php
// loan_model.php - adapté à la nouvelle BD

/**
 * Compter le nombre total d'emprunts
 */
function get_loans_count() {
    $query = "SELECT COUNT(*) as total FROM loans";
    $result = db_select_one($query);
    return $result['total'] ?? 0;
}

/**
 * Récupère le stock d'un média selon son type
 */
function get_media_stock($media_id, $type) {
    switch($type) {
        case 'book': return db_select_one("SELECT stock FROM books WHERE id = ?", [$media_id])['stock'] ?? 0;
        case 'movie': return db_select_one("SELECT stock FROM movies WHERE id = ?", [$media_id])['stock'] ?? 0;
        case 'video_game': return db_select_one("SELECT stock FROM video_games WHERE id = ?", [$media_id])['stock'] ?? 0;
    }
    return 0;
}

/**
 * Met à jour le stock d'un média selon son type
 */
function update_media_stock($media_id, $type, $delta) {
    switch($type) {
        case 'book':
            db_execute("UPDATE books SET stock = stock + ? WHERE id = ?", [$delta, $media_id]);
            break;
        case 'movie':
            db_execute("UPDATE movies SET stock = stock + ? WHERE id = ?", [$delta, $media_id]);
            break;
        case 'video_game':
            db_execute("UPDATE video_games SET stock = stock + ? WHERE id = ?", [$delta, $media_id]);
            break;
    }
}

/**
 * Crée un nouvel emprunt
 */
function create_loan($user_id, $media_id, $media_type) {
    // Vérifie si l'utilisateur a déjà 3 emprunts en cours
    $query = "SELECT COUNT(*) as total FROM loans WHERE user_id = ? AND returned_at IS NULL";
    $count = db_select_one($query, [$user_id]);
    if ($count['total'] >= 3) return false;

    // Vérifie si le média est disponible
    $stock = get_media_stock($media_id, $media_type);
    if ($stock < 1) return false;

    // Insère l'emprunt
    $loan_date = date('Y-m-d');
    $return_date = date('Y-m-d', strtotime('+14 days'));
    $query = "INSERT INTO loans (user_id, media_id, media_type, loan_date, return_date) VALUES (?, ?, ?, ?, ?)";
    if (db_execute($query, [$user_id, $media_id, $media_type, $loan_date, $return_date])) {
        update_media_stock($media_id, $media_type, -1);
        return true;
    }

    return false;
}

/**
 * Marque un emprunt comme retourné
 */
function return_loan($loan_id) {
    $loan = db_select_one("SELECT media_id, media_type FROM loans WHERE id = ? AND returned_at IS NULL", [$loan_id]);
    if (!$loan) return false;

    if (db_execute("UPDATE loans SET returned_at = NOW() WHERE id = ?", [$loan_id])) {
        update_media_stock($loan['media_id'], $loan['media_type'], 1);
        return true;
    }

    return false;
}

/**
 * Récupère tous les emprunts
 */
function get_all_loans() {
    $query = "
        SELECT l.id, l.user_id, u.name AS user_name, l.media_id, l.media_type,
               CASE l.media_type
                   WHEN 'book' THEN b.title
                   WHEN 'movie' THEN m.title
                   WHEN 'video_game' THEN v.title
               END AS media_title,
               l.loan_date, l.return_date, l.returned_at
        FROM loans l
        JOIN users u ON l.user_id = u.id
        LEFT JOIN books b ON l.media_id = b.id AND l.media_type='book'
        LEFT JOIN movies m ON l.media_id = m.id AND l.media_type='movie'
        LEFT JOIN video_games v ON l.media_id = v.id AND l.media_type='video_game'
        ORDER BY l.loan_date DESC
    ";
    return db_select($query);
}

/**
 * Récupère les emprunts d'un utilisateur
 */
function get_user_loans($user_id) {
    $query = "
        SELECT l.id, l.media_id, l.media_type,
               CASE l.media_type
                   WHEN 'book' THEN b.title
                   WHEN 'movie' THEN m.title
                   WHEN 'video_game' THEN v.title
               END AS media_title,
               l.loan_date, l.return_date, l.returned_at
        FROM loans l
        LEFT JOIN books b ON l.media_id = b.id AND l.media_type='book'
        LEFT JOIN movies m ON l.media_id = m.id AND l.media_type='movie'
        LEFT JOIN video_games v ON l.media_id = v.id AND l.media_type='video_game'
        WHERE l.user_id = ?
        ORDER BY l.loan_date DESC
    ";
    return db_select($query, [$user_id]);
}

/**
 * Compte les emprunts actifs pour un utilisateur
 */
function count_active_loans($user_id) {
    $query = "SELECT COUNT(*) as total FROM loans WHERE user_id = ? AND returned_at IS NULL";
    $result = db_select_one($query, [$user_id]);
    return $result['total'] ?? 0;
}
