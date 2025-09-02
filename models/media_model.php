<?php

function get_all_media() {
    $db = get_db();
    $stmt = $db->query("SELECT id, title, type, available FROM media");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_media_by_id($id) {
    $db = get_db();
    $stmt = $db->prepare("SELECT * FROM media WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_media_count() {
    $db = get_db();
    return $db->query("SELECT COUNT(*) FROM media")->fetchColumn();
}
