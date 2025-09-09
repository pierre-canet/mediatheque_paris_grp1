<?php
require_once CORE_PATH . '/database.php';
require_once MODEL_PATH . '/item_model.php';

function create_rental($user_id, $item_id) {
    $item = get_item_by_id($item_id);
    if (!$item || !$item['available']) return false;
    
    db_begin_transaction();
    try {
        $query = "INSERT INTO rentals (user_id, item_id) VALUES (?, ?)";
        db_execute($query, [$user_id, $item_id]);
        update_item_availability($item_id, 0);
        db_commit();
        return db_last_insert_id();
    } catch (Exception $e) {
        db_rollback();
        return false;
    }
}

function get_user_rentals($user_id) {
    $query = "SELECT r.*, i.title, i.type, i.image_url 
              FROM rentals r JOIN items i ON r.item_id = i.id 
              WHERE r.user_id = ? AND r.status = 'loué' 
              ORDER BY r.rent_date DESC";
    return db_select($query, [$user_id]);
}

function return_rental($rental_id, $user_id) {
    $rental = db_select_one("SELECT * FROM rentals WHERE id = ? AND user_id = ?", [$rental_id, $user_id]);
    if (!$rental || $rental['status'] !== 'loué') return false;
    
    db_begin_transaction();
    try {
        $query = "UPDATE rentals SET return_date = NOW(), status = 'retourné' WHERE id = ?";
        db_execute($query, [$rental_id]);
        update_item_availability($rental['item_id'], 1);
        db_commit();
        return true;
    } catch (Exception $e) {
        db_rollback();
        return false;
    }
}
?>