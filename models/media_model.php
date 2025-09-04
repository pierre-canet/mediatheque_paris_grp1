<?php
/* media_model.php
Ce modèle couvre :

Création, mise à jour, suppression des médias

Gestion des champs spécifiques par type (livre/film/jeu)

Upload, validation et redimensionnement des images de couverture

Conformité avec le cahier des charges côté administration
*/

/**
 * Récupère tous les médias
 */
function get_all_media($limit = null, $offset = 0) {
    $query = "SELECT id, title, type, genre, stock FROM media ORDER BY title ASC";
    if ($limit !== null) {
        $query .= " LIMIT $offset, $limit";
    }
    return db_select($query);
}

/**
 * Récupère un média par son ID
 */
function get_media_by_id($id) {
    $db = db_connect();
    $stmt = $db->prepare("SELECT * FROM media WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Compte le nombre total de médias
 */
function get_media_count() {
    $db = db_connect();
    return $db->query("SELECT COUNT(*) FROM media")->fetchColumn();
}

/**
 * Crée un nouveau média
 */
function create_media($title, $type, $genre, $stock, $extra_fields = []) {
    $db = db_connect();

    $columns = 'title, type, genre, stock';
    $placeholders = '?, ?, ?, ?';
    $values = [$title, $type, $genre, $stock];

    foreach ($extra_fields as $key => $value) {
        $columns .= ", $key";
        $placeholders .= ", ?";
        $values[] = $value;
    }

    $stmt = $db->prepare("INSERT INTO media ($columns) VALUES ($placeholders)");
    return $stmt->execute($values);
}

/**
 * Met à jour un média existant
 */
function update_media($id, $title, $type, $genre, $stock, $extra_fields = []) {
    $db = db_connect();

    $set = "title = ?, type = ?, genre = ?, stock = ?";
    $values = [$title, $type, $genre, $stock];

    foreach ($extra_fields as $key => $value) {
        $set .= ", $key = ?";
        $values[] = $value;
    }

    $values[] = $id;

    $stmt = $db->prepare("UPDATE media SET $set WHERE id = ?");
    return $stmt->execute($values);
}

/**
 * Supprime un média
 */
function delete_media($id) {
    $db = db_connect();

    // Supprime l'image de couverture si existante
    $stmt = $db->prepare("SELECT cover_image FROM media WHERE id = ?");
    $stmt->execute([$id]);
    $media = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($media && !empty($media['cover_image'])) {
        $cover_path = __DIR__ . '/../uploads/covers/' . $media['cover_image'];
        if (file_exists($cover_path)) unlink($cover_path);
    }

    $stmt = $db->prepare("DELETE FROM media WHERE id = ?");
    return $stmt->execute([$id]);
}

/**
 * Upload et traitement d'image de couverture
 */
function upload_cover_image($file) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024; // 2 Mo

    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    if (!in_array($file['type'], $allowed_types)) return false;
    if ($file['size'] > $max_size) return false;

    // Génération d'un nom unique
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_name = uniqid() . '.' . $ext;
    $destination = __DIR__ . '/../uploads/covers/' . $new_name;

    // Déplacement du fichier
    if (!move_uploaded_file($file['tmp_name'], $destination)) return false;

    // Redimensionnement
    list($width, $height) = getimagesize($destination);
    $max_width = 300;
    $max_height = 400;

    $ratio = min($max_width/$width, $max_height/$height, 1);
    $new_width = (int)($width * $ratio);
    $new_height = (int)($height * $ratio);

    $src = null;
    switch ($file['type']) {
        case 'image/jpeg': $src = imagecreatefromjpeg($destination); break;
        case 'image/png': $src = imagecreatefrompng($destination); break;
        case 'image/gif': $src = imagecreatefromgif($destination); break;
    }

    if ($src) {
        $dst = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($dst, $src, 0,0,0,0, $new_width, $new_height, $width, $height);
        switch ($file['type']) {
            case 'image/jpeg': imagejpeg($dst, $destination); break;
            case 'image/png': imagepng($dst, $destination); break;
            case 'image/gif': imagegif($dst, $destination); break;
        }
        imagedestroy($src);
        imagedestroy($dst);
    }

    return $new_name;
}
