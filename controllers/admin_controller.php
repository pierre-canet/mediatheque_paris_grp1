```php
<?php

require_once MODEL_PATH . '/user_model.php';
require_once MODEL_PATH . '/media_model.php';
require_once MODEL_PATH . '/loan_model.php';

// ----------------- TABLEAU DE BORD -----------------
function get_total_media_count() {
    // Récupère le nombre total de livres
    $books = db_select_one("SELECT COUNT(*) as total FROM books")['total'] ?? 0;
    // Récupère le nombre total de films
    $movies = db_select_one("SELECT COUNT(*) as total FROM movies")['total'] ?? 0;
    // Récupère le nombre total de jeux vidéo
    $video_games = db_select_one("SELECT COUNT(*) as total FROM video_games")['total'] ?? 0;
    // Retourne la somme des médias
    return $books + $movies + $video_games;
}

function admin_dashboard() {
    // Vérifie les droits d'administrateur
    require_admin();
    // Prépare les statistiques pour le tableau de bord
    $stats = [
        'users_count' => get_users_count(), // Supposé défini dans user_model.php
        'media_count' => get_total_media_count(),
        'loans_count' => get_loans_count(),
    ];
    // Affiche la vue du tableau de bord
    render('admin/dashboard', ['stats' => $stats]);
}

// ----------------- GESTION DES MÉDIAS -----------------
function admin_media_list() {
    // Vérifie les droits d'administrateur
    require_admin();
    // Récupère tous les médias
    $medias = get_all_media();
    // Affiche la liste des médias
    render('admin/media_list', ['medias' => $medias]);
}

function admin_media_edit($id = null) {
    // Vérifie les droits d'administrateur
    require_admin();
    // Initialisation de la variable média
    $media = null;
    if ($id) {
        // Sépare l'ID en type et identifiant
        $parts = explode('_', $id);
        if (count($parts) === 2) {
            $type = $parts[0];
            $media_id = $parts[1];
            // Récupère le média par ID et type
            $media = get_media_by_id($media_id, $type);
        }
    }
    // Affiche la vue d'édition du média
    render('admin/media_edit', ['media' => $media]);
}

function admin_media_save($id = null) {
    // Vérifie les droits d'administrateur
    require_admin();

    // Récupère et nettoie les données du formulaire
    $title = trim($_POST['title'] ?? '');
    $type  = $_POST['type'] ?? '';
    $genre = trim($_POST['genre'] ?? '');
    $stock = intval($_POST['stock'] ?? 1);

    // Mapping type français → anglais
    $type_map = ['livre'=>'book', 'film'=>'movie', 'jeu'=>'game'];
    $type_db = $type_map[$type] ?? null;

    // Vérifie si le type est valide
    if (!$type_db) {
        set_flash_message('error', 'Type de média invalide');
        redirect_to($id ? "/admin/media/edit/$id" : "/admin/media/add");
        return;
    }

    // Champs spécifiques pour chaque type de média
    $extra_fields = [];
    $extra_fields['title'] = $title;
    $extra_fields['genre'] = $genre;
    $extra_fields['stock'] = $stock;
    if ($type_db === 'book') {
        // Champs spécifiques pour les livres
        $extra_fields['writer'] = trim($_POST['writer'] ?? '');
        $extra_fields['ISBN13'] = trim($_POST['ISBN13'] ?? '');
        $extra_fields['page_number'] = intval($_POST['page_number'] ?? 0);
        $extra_fields['year'] = intval($_POST['year'] ?? 0);
        $extra_fields['synopsis'] = trim($_POST['synopsis'] ?? '');
    } elseif ($type_db === 'movie') {
        // Champs spécifiques pour les films
        $extra_fields['producer'] = trim($_POST['producer'] ?? '');
        $extra_fields['year'] = intval($_POST['year'] ?? 0);
        $extra_fields['duration(m)'] = intval($_POST['duration'] ?? 0);
        $extra_fields['classification'] = trim($_POST['classification'] ?? '');
        $extra_fields['synopsis'] = trim($_POST['synopsis'] ?? '');
    } elseif ($type_db === 'game') {
        // Champs spécifiques pour les jeux vidéo
        $extra_fields['editor'] = trim($_POST['editor'] ?? '');
        $extra_fields['plateform'] = trim($_POST['plateform'] ?? '');
        $extra_fields['min_age'] = intval($_POST['min_age'] ?? 0);
        $extra_fields['synopsis'] = trim($_POST['synopsis'] ?? '');
        $extra_fields['year'] = intval($_POST['year'] ?? 0);
    }

    // Validation des données
    $errors = [];
    if ($title === '' || strlen($title) > 255) $errors[] = "Titre invalide";
    if ($genre === '') $errors[] = "Genre obligatoire";
    if ($stock < 1) $errors[] = "Stock invalide";

    // Gestion des erreurs
    if (!empty($errors)) {
        set_flash_message('error', implode(', ', $errors));
        redirect_to($id ? "/admin/media/edit/$id" : "/admin/media/add");
        return;
    }

    // Persistance des données
    if ($id) {
        // Mise à jour d'un média existant
        $parts = explode('_', $id);
        if (count($parts) === 2) {
            $type_db = $parts[0];
            $media_id = $parts[1];
            update_media($media_id, $type_db, $extra_fields);
            set_flash_message('success', 'Média mis à jour avec succès.');
        }
    } else {
        // Création d'un nouveau média
        create_media($type_db, $extra_fields);
        set_flash_message('success', 'Média créé avec succès.');
    }

    // Redirection vers la liste des médias
    redirect_to('/admin/media');
}

function admin_media_delete($id, $type) {
    // Vérifie les droits d'administrateur
    require_admin();
    // Mapping type français → anglais
    $type_map = ['livre'=>'book', 'film'=>'movie', 'jeu'=>'game'];
    $type_db = $type_map[$type] ?? null;

    // Supprime le média si le type est valide
    if ($type_db && delete_media($id, $type_db)) {
        set_flash_message('success', 'Média supprimé avec succès.');
    } else {
        set_flash_message('error', 'Impossible de supprimer ce média.');
    }
    // Redirection vers la liste des médias
    redirect_to('/admin/media');
}

// ----------------- GESTION DES UTILISATEURS -----------------
function admin_users_list() {
    // Vérifie les droits d'administrateur
    require_admin();
    // Récupère tous les utilisateurs
    $users = get_all_users();
    // Affiche la liste des utilisateurs
    render('admin/users_list', ['users' => $users]);
}

function admin_user_detail($id) {
    // Vérifie les droits d'administrateur
    require_admin();
    // Récupère les détails de l'utilisateur
    $user = get_user_by_id($id);
    // Affiche la vue des détails de l'utilisateur
    render('admin/user_detail', ['user' => $user]);
}

// ----------------- GESTION DES EMPRUNTS -----------------
function admin_loans_list() {
    // Vérifie les droits d'administrateur
    require_admin();
    // Récupère tous les emprunts
    $loans = get_all_loans();
    // Affiche la liste des emprunts
    render('admin/loans_list', ['loans' => $loans]);
}

function admin_loan_return($loan_id) {
    // Vérifie les droits d'administrateur
    require_admin();
    // Marque l'emprunt comme rendu
    if (return_loan($loan_id)) {
        set_flash_message('success', 'Emprunt marqué comme rendu.');
    } else {
        set_flash_message('error', 'Impossible de marquer cet emprunt comme rendu.');
    }
    // Redirection vers la liste des emprunts
    redirect_to('/admin/loans');
}

function admin_loan_create($user_id, $media_id, $media_type) {
    // Vérifie les droits d'administrateur
    require_admin();
    // Crée un nouvel emprunt
    if (create_loan($user_id, $media_id, $media_type)) {
        set_flash_message('success', 'Emprunt enregistré avec succès.');
    } else {
        set_flash_message('error', 'Impossible de créer cet emprunt (limite atteinte ou média indisponible).');
    }
    // Redirection vers la liste des emprunts
    redirect_to('/admin/loans');
}
?>