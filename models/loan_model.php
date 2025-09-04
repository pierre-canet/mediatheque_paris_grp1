<?php
// loan_model.php

/**
 * Compter le nombre total d'emprunts
 */
function get_loans_count() {
    $query = "SELECT COUNT(*) as total FROM loans";
    $result = db_select_one($query);
    return $result['total'] ?? 0;
}

/**
 * Crée un nouvel emprunt
 */
function create_loan($user_id, $media_id) {
    // Vérifie si l'utilisateur a déjà 3 emprunts en cours
    $query = "SELECT COUNT(*) FROM loans WHERE user_id = ? AND returned_at IS NULL";
    $count = db_select_one($query, [$user_id]);
    if ($count['COUNT(*)'] >= 3) return false;

    // Vérifie si le média est disponible
    $query = "SELECT stock FROM media WHERE id = ?";
    $media = db_select_one($query, [$media_id]);
    if (!$media || $media['stock'] < 1) return false;

    // Insère l'emprunt
    $loan_date = date('Y-m-d');
    $return_date = date('Y-m-d', strtotime('+14 days'));
    $query = "INSERT INTO loans (user_id, media_id, loan_date, return_date) VALUES (?, ?, ?, ?)";
    if (db_execute($query, [$user_id, $media_id, $loan_date, $return_date])) {
        // Décrémente le stock
        db_execute("UPDATE media SET stock = stock - 1 WHERE id = ?", [$media_id]);
        return true;
    }

    return false;
}

/**
 * Marque un emprunt comme retourné
 */
function return_loan($loan_id) {
    $loan = db_select_one("SELECT media_id FROM loans WHERE id = ? AND returned_at IS NULL", [$loan_id]);
    if (!$loan) return false;

    if (db_execute("UPDATE loans SET returned_at = NOW() WHERE id = ?", [$loan_id])) {
        db_execute("UPDATE media SET stock = stock + 1 WHERE id = ?", [$loan['media_id']]);
        return true;
    }

    return false;
}

/**
 * Récupère tous les emprunts
 */
function get_all_loans() {
    $query = "
        SELECT l.id, l.user_id, u.name AS user_name, l.media_id, m.title AS media_title,
               l.loan_date, l.return_date, l.returned_at
        FROM loans l
        JOIN users u ON l.user_id = u.id
        JOIN media m ON l.media_id = m.id
        ORDER BY l.loan_date DESC
    ";
    return db_select($query);
}

/**
 * Récupère les emprunts d'un utilisateur
 */
function get_user_loans($user_id) {
    $query = "
        SELECT l.id, l.media_id, m.title AS media_title, l.loan_date, l.return_date, l.returned_at
        FROM loans l
        JOIN media m ON l.media_id = m.id
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
