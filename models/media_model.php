```php
<?php
/* media_model.php - adapté à la nouvelle base de données */

/**
 * Récupère tous les médias
 */
function get_all_media($limit = null, $offset = 0) {
    $query = "
        SELECT id, title, 'book' AS type, gender AS genre, stock FROM books
        UNION ALL
        SELECT id, title, 'movie' AS type, gender AS genre, stock FROM movies
        UNION ALL
        SELECT id, title, 'game' AS type, gender AS genre, stock FROM video_games
        ORDER BY title ASC
    ";
    // Ajoute une limite et un décalage si spécifiés
    if ($limit !== null) {
        $query .= " LIMIT $offset, $limit";
    }
    return db_select($query);
}

/**
 * Récupère un média par son ID et son type
 */
function get_media_by_id($id, $type) {
    $db = db_connect();
    switch($type) {
        case 'book':
            // Prépare la requête pour les livres
            $stmt = $db->prepare("SELECT * FROM books WHERE id = ?");
            break;
        case 'movie':
            // Prépare la requête pour les films
            $stmt = $db->prepare("SELECT * FROM movies WHERE id = ?");
            break;
        case 'game':
            // Prépare la requête pour les jeux vidéo
            $stmt = $db->prepare("SELECT * FROM video_games WHERE id = ?");
            break;
        default:
            return false;
    }
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Compte le nombre total de médias
 */
function get_media_count() {
    $db = db_connect();
    // Calcule le total des médias dans toutes les tables
    return $db->query("
        SELECT 
            (SELECT COUNT(*) FROM books) +
            (SELECT COUNT(*) FROM movies) +
            (SELECT COUNT(*) FROM video_games) AS total
    ")->fetchColumn();
}

/**
 * Crée un nouveau média
 */
function create_media($type, $data) {
    $db = db_connect();
    switch($type) {
        case 'book':
            // Insère un nouveau livre
            $stmt = $db->prepare("INSERT INTO books (title, writer, ISBN13, gender, page_number, synopsis, year, stock, available, image_url, upload_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([
                $data['title'], $data['writer'], $data['ISBN13'], $data['genre'],
                $data['page_number'], $data['synopsis'], $data['year'], $data['stock'], 
                1, // Disponibilité par défaut à 1
                $data['image_url'] ?? '', // URL de l'image par défaut vide
                date('Y-m-d') // Date de téléchargement définie à la date actuelle
            ]);
        case 'movie':
            // Insère un nouveau film
            $stmt = $db->prepare("INSERT INTO movies (title, producer, year, gender, `duration(m)`, synopsis, classification, stock, available, image_url, upload_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([
                $data['title'], $data['producer'], $data['year'], $data['genre'],
                $data['duration(m)'], $data['synopsis'], $data['classification'], $data['stock'],
                1, // Disponibilité par défaut à 1
                $data['image_url'] ?? '', // URL de l'image par défaut vide
                date('Y-m-d') // Date de téléchargement définie à la date actuelle
            ]);
        case 'game':
            // Insère un nouveau jeu vidéo
            $stmt = $db->prepare("INSERT INTO video_games (title, editor, plateform, gender, min_age, synopsis, year, stock, available, image_url, upload_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([
                $data['title'], $data['editor'], $data['plateform'], $data['genre'],
                $data['min_age'], $data['synopsis'], $data['year'], $data['stock'],
                1, // Disponibilité par défaut à 1
                $data['image_url'] ?? '', // URL de l'image par défaut vide
                date('Y-m-d') // Date de téléchargement définie à la date actuelle
            ]);
        default:
            return false;
    }
}

/**
 * Met à jour un média
 */
function update_media($id, $type, $data) {
    $db = db_connect();
    switch($type) {
        case 'book':
            // Met à jour un livre
            $stmt = $db->prepare("UPDATE books SET title = ?, writer = ?, ISBN13 = ?, gender = ?, page_number = ?, synopsis = ?, year = ?, stock = ? WHERE id = ?");
            return $stmt->execute([
                $data['title'], $data['writer'], $data['ISBN13'], $data['genre'],
                $data['page_number'], $data['synopsis'], $data['year'], $data['stock'], $id
            ]);
        case 'movie':
            // Met à jour un film
            $stmt = $db->prepare("UPDATE movies SET title = ?, producer = ?, year = ?, gender = ?, `duration(m)` = ?, synopsis = ?, classification = ?, stock = ? WHERE id = ?");
            return $stmt->execute([
                $data['title'], $data['producer'], $data['year'], $data['genre'],
                $data['duration(m)'], $data['synopsis'], $data['classification'], $data['stock'], $id
            ]);
        case 'game':
            // Met à jour un jeu vidéo
            $stmt = $db->prepare("UPDATE video_games SET title = ?, editor = ?, plateform = ?, gender = ?, min_age = ?, synopsis = ?, year = ?, stock = ? WHERE id = ?");
            return $stmt->execute([
                $data['title'], $data['editor'], $data['plateform'], $data['genre'],
                $data['min_age'], $data['synopsis'], $data['year'], $data['stock'], $id
            ]);
        default:
            return false;
    }
}

/**
 * Supprime un média
 */
function delete_media($id, $type) {
    $db = db_connect();
    switch($type) {
        case 'book':
            // Supprime un livre
            $stmt = $db->prepare("DELETE FROM books WHERE id = ?");
            break;
        case 'movie':
            // Supprime un film
            $stmt = $db->prepare("DELETE FROM movies WHERE id = ?");
            break;
        case 'game':
            // Supprime un jeu vidéo
            $stmt = $db->prepare("DELETE FROM video_games WHERE id = ?");
            break;
        default:
            return false;
    }
    return $stmt->execute([$id]);
}

/**
 * Télécharge et traite une image de couverture
 */
function upload_cover_image($file) {
    // Types de fichiers autorisés
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    // Taille maximale du fichier (2 Mo)
    $max_size = 2 * 1024 * 1024;

    // Vérifie les erreurs d'upload
    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    // Vérifie le type de fichier
    if (!in_array($file['type'], $allowed_types)) return false;
    // Vérifie la taille du fichier
    if ($file['size'] > $max_size) return false;

    // Génère un nom unique pour l'image
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_name = uniqid() . '.' . $ext;
    $destination = __DIR__ . '/../Uploads/covers/' . $new_name;

    // Déplace le fichier téléchargé
    if (!move_uploaded_file($file['tmp_name'], $destination)) return false;

    // Obtient les dimensions de l'image
    list($width, $height) = getimagesize($destination);
    $max_width = 300;
    $max_height = 400;

    // Calcule le ratio pour le redimensionnement
    $ratio = min($max_width/$width, $max_height/$height, 1);
    $new_width = (int)($width * $ratio);
    $new_height = (int)($height * $ratio);

    // Crée une image source selon le type
    $src = null;
    switch ($file['type']) {
        case 'image/jpeg': $src = imagecreatefromjpeg($destination); break;
        case 'image/png': $src = imagecreatefrompng($destination); break;
        case 'image/gif': $src = imagecreatefromgif($destination); break;
    }

    // Redimensionne l'image si source valide
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

    // Retourne le nom du fichier
    return $new_name;
}
?>