<?php

require_once MODEL_PATH . '/user_model.php';
require_once MODEL_PATH . '/media_model.php';
require_once MODEL_PATH . '/loan_model.php';

// ----------------- DASHBOARD -----------------
function get_total_media_count() {
    $books = db_select_one("SELECT COUNT(*) as total FROM books")['total'] ?? 0;
    $movies = db_select_one("SELECT COUNT(*) as total FROM movies")['total'] ?? 0;
    $video_games = db_select_one("SELECT COUNT(*) as total FROM video_games")['total'] ?? 0;
    return $books + $movies + $video_games;
}

function admin_dashboard() {
    require_admin();
    $stats = [
        'users_count' => get_users_count(),
        'media_count' => get_total_media_count(),
        'loans_count' => get_loans_count(),
    ];
    render('admin/dashboard', ['stats' => $stats]);
}

// ----------------- GESTION DES MÉDIAS -----------------
function admin_media_list() {
    require_admin();
    $medias = get_all_media();
    render('admin/media_list', ['medias' => $medias]);
}

function admin_media_edit($id = null) {
    require_admin();
    $media = $id ? get_media_by_id($id) : null;
    render('admin/media_edit', ['media' => $media]);
}

function admin_media_save($id = null) {
    require_admin();

    $title = trim($_POST['title'] ?? '');
    $type  = $_POST['type'] ?? '';
    $genre = trim($_POST['genre'] ?? '');
    $stock = intval($_POST['stock'] ?? 1);

    // Mapping type francais → anglais
    $type_map = ['livre'=>'book', 'film'=>'movie', 'jeu'=>'video_game'];
    $type_db = $type_map[$type] ?? null;

    if (!$type_db) {
        set_flash_message('error', 'Type de média invalide');
        redirect_to($id ? "/admin/media/edit/$id" : "/admin/media/add");
        return;
    }

    // Champs spécifiques
    $extra_fields = [];
    if ($type_db === 'book') {
        $extra_fields['writer'] = trim($_POST['writer'] ?? '');
        $extra_fields['ISBN_13'] = trim($_POST['ISBN_13'] ?? '');
        $extra_fields['page_number'] = intval($_POST['page_number'] ?? 0);
        $extra_fields['year_of_publication'] = intval($_POST['date_of_publication'] ?? 0);
    } elseif ($type_db === 'movie') {
        $extra_fields['producer'] = trim($_POST['producer'] ?? '');
        $extra_fields['year'] = intval($_POST['year'] ?? 0);
        $extra_fields['duration'] = intval($_POST['duration'] ?? 0);
        $extra_fields['classification'] = trim($_POST['classification'] ?? '');
    } elseif ($type_db === 'video_game') {
        $extra_fields['editor'] = trim($_POST['editor'] ?? '');
        $extra_fields['plateform'] = trim($_POST['platform'] ?? '');
        $extra_fields['minimal_age'] = intval($_POST['minimal_age'] ?? 0);
        $extra_fields['description'] = trim($_POST['description'] ?? '');
    }

    // Validation
    $errors = [];
    if ($title === '' || strlen($title) > 200) $errors[] = "Titre invalide";
    if ($genre === '') $errors[] = "Genre obligatoire";
    if ($stock < 1) $errors[] = "Stock invalide";

    if (!empty($errors)) {
        set_flash_message('error', implode(', ', $errors));
        redirect_to($id ? "/admin/media/edit/$id" : "/admin/media/add");
        return;
    }

    // Persistance
    if ($id) {
        update_media($id, $type_db, $extra_fields);
        set_flash_message('success', 'Média mis à jour avec succès.');
    } else {
        create_media($type_db, $extra_fields);
        set_flash_message('success', 'Média créé avec succès.');
    }

    redirect_to('/admin/media');
}

function admin_media_delete($id, $type) {
    require_admin();
    $type_map = ['livre'=>'book', 'film'=>'movie', 'jeu'=>'video_game'];
    $type_db = $type_map[$type] ?? null;

    if ($type_db && delete_media($id, $type_db)) {
        set_flash_message('success', 'Média supprimé avec succès.');
    } else {
        set_flash_message('error', 'Impossible de supprimer ce média.');
    }
    redirect_to('/admin/media');
}

// ----------------- GESTION DES UTILISATEURS -----------------
function admin_users_list() {
    require_admin();
    $users = get_all_users();
    render('admin/users_list', ['users' => $users]);
}

function admin_user_detail($id) {
    require_admin();
    $user = get_user_by_id($id);
    render('admin/user_detail', ['user' => $user]);
}

// ----------------- GESTION DES EMPRUNTS -----------------
function admin_loans_list() {
    require_admin();
    $loans = get_all_loans();
    render('admin/loans_list', ['loans' => $loans]);
}

function admin_loan_return($loan_id) {
    require_admin();
    if (return_loan($loan_id)) {
        set_flash_message('success', 'Emprunt marqué comme rendu.');
    } else {
        set_flash_message('error', 'Impossible de marquer cet emprunt comme rendu.');
    }
    redirect_to('/admin/loans');
}

function admin_loan_create($user_id, $media_id, $media_type) {
    require_admin();
    if (create_loan($user_id, $media_id, $media_type)) {
        set_flash_message('success', 'Emprunt enregistré avec succès.');
    } else {
        set_flash_message('error', 'Impossible de créer cet emprunt (limite atteinte ou média indisponible).');
    }
    redirect_to('/admin/loans');
}
