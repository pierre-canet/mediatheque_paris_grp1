<?php
// loan_model.php

/**
 * Crée un nouvel emprunt
 */
function create_loan($user_id, $media_id) {
    $db = get_db();

    // Vérifie si l'utilisateur a déjà 3 emprunts en cours
    $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE user_id = ? AND returned_at IS NULL");
    $stmt->execute([$user_id]);
    if ($stmt->fetchColumn() >= 3) {
        return false; // Limite atteinte
    }

    // Vérifie si le média est disponible
    $stmt = $db->prepare("SELECT stock FROM media WHERE id = ?");
    $stmt->execute([$media_id]);
    $media = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$media || $media['stock'] < 1) {
        return false; // Pas disponible
    }

    // Insère l'emprunt
    $loan_date = date('Y-m-d');
    $return_date = date('Y-m-d', strtotime('+14 days'));
    $stmt = $db->prepare("INSERT INTO loans (user_id, media_id, loan_date, return_date) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $media_id, $loan_date, $return_date])) {
        // Décrémente le stock
        $stmt = $db->prepare("UPDATE media SET stock = stock - 1 WHERE id = ?");
        $stmt->execute([$media_id]);
        return true;
    }

    return false;
}

/**
 * Marque un emprunt comme retourné
 */
function return_loan($loan_id) {
    $db = get_db();

    // Récupère l'emprunt
    $stmt = $db->prepare("SELECT media_id FROM loans WHERE id = ? AND returned_at IS NULL");
    $stmt->execute([$loan_id]);
    $loan = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$loan) return false;

    // Met à jour l'emprunt
    $stmt = $db->prepare("UPDATE loans SET returned_at = NOW() WHERE id = ?");
    if ($stmt->execute([$loan_id])) {
        // Incrémente le stock
        $stmt = $db->prepare("UPDATE media SET stock = stock + 1 WHERE id = ?");
        $stmt->execute([$loan['media_id']]);
        return true;
    }

    return false;
}

/**
 * Récupère tous les emprunts
 */
function get_all_loans() {
    $db = get_db();
    $stmt = $db->query("
        SELECT l.id, l.user_id, u.name as user_name, l.media_id, m.title as media_title,
               l.loan_date, l.return_date, l.returned_at
        FROM loans l
        JOIN users u ON l.user_id = u.id
        JOIN media m ON l.media_id = m.id
        ORDER BY l.loan_date DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les emprunts d'un utilisateur
 */
function get_user_loans($user_id) {
    $db = get_db();
    $stmt = $db->prepare("
        SELECT l.id, l.media_id, m.title as media_title, l.loan_date, l.return_date, l.returned_at
        FROM loans l
        JOIN media m ON l.media_id = m.id
        WHERE l.user_id = ?
        ORDER BY l.loan_date DESC
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Compte les emprunts en cours
 */
function count_active_loans($user_id) {
    $db = get_db();
    $stmt = $db->prepare("SELECT COUNT(*) FROM loans WHERE user_id = ? AND returned_at IS NULL");
    $stmt->execute([$user_id]);
    return $stmt->fetchColumn();
}
