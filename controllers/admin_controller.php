<?php
require_once MODEL_PATH . '/user_model.php';
require_once MODEL_PATH . '/media_model.php';

function admin_dashboard() {
    $stats = [
        'users_count' => get_users_count(),
        'media_count' => get_media_count(),
    ];
    render('admin/dashboard', ['stats' => $stats]);
}

function admin_media_list() {
    $medias = get_all_media();
    render('admin/media_list', ['medias' => $medias]);
}

function admin_media_edit($id = null) {
    $media = $id ? get_media_by_id($id) : null;
    render('admin/media_edit', ['media' => $media]);
}

function admin_users_list() {
    $users = get_all_users();
    render('admin/users_list', ['users' => $users]);
}

function admin_user_detail($id) {
    $user = get_user_by_id($id);
    render('admin/user_detail', ['user' => $user]);
}
