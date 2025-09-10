<?php
require_once MODEL_PATH . '/rental_model.php';
require_once INCLUDE_PATH . '/helpers.php';

function rental_rent($item_id) {
    if (!is_logged_in()) {
        set_flash('error', 'Vous devez vous connecter pour emprunter.');
        redirect('auth/login');
    }
    $user_id = $_SESSION['user_id'];
    if (create_rental($user_id, $item_id)) {
        set_flash('success', 'Emprunté avec succès !');
    } else {
        set_flash('error', 'Erreur lors de l\'emprunt.');
    }
    redirect('rental/my_rentals');
}

function rental_my_rentals() {
    if (!is_logged_in()) redirect('auth/login');
    $user_id = $_SESSION['user_id'];
    $data = ['title' => 'Mes Locations', 'rentals' => get_user_rentals($user_id)];
    load_view_with_layout('rental/my_rentals', $data);
}

function rental_return($rental_id) {
    if (!is_logged_in()) redirect('auth/login');
    $user_id = $_SESSION['user_id'];
    if (return_rental($rental_id, $user_id)) {
        set_flash('success', 'Retourné avec succès!');
    } else {
        set_flash('error', 'Erreur lors du retour.');
    }
    redirect('rental/my_rentals');
}
?>