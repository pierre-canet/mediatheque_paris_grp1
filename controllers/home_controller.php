<?php
// Contrôleur pour la page d'accueil

/**
 * Page d'accueil
 */
function home_index() {
    $data = [
        'title' => 'Accueil',
        'message' => 'Bienvenue sur votre application PHP MVC !',
        'features' => [
            'Architecture MVC claire',
            'Système de routing simple',
            'Templating HTML/CSS',
            'Gestion de base de données',
            'Sécurité intégrée'
        ],
        'user_name' => $_SESSION['name'] ?? 'Invité'
    ];
    
    load_view_with_layout('home/index', $data);
}

/**
 * Page à propos
 */
function home_about() {
    $data = [
        'title' => 'À propos',
        'content' => 'Cette application est un starter kit PHP MVC développé avec une approche procédurale.'
    ];
    
    load_view_with_layout('home/about', $data);
}

/**
 * Page contact
 */
function home_contact() {
    $data = [
        'title' => 'Contact'
    ];
    
    if (is_post()) {
        $name = clean_input(post('name'));
        $email = clean_input(post('email'));
        $message = clean_input(post('message'));
        
        if (empty($name) || empty($email) || empty($message)) {
            set_flash('error', 'Tous les champs sont obligatoires.');
        } elseif (!validate_email($email)) {
            set_flash('error', 'Adresse email invalide.');
        } else {
            set_flash('success', 'Votre message a été envoyé avec succès !');
            redirect('home/contact');
        }
    }
    
    load_view_with_layout('home/contact', $data);
}

/**
 * Page profile
 */
function home_profile() {
    $data = [
        'title' => 'Profile',
        'message' => 'Bienvenue sur votre profil',
        'content' => 'Cette application est un starter kit PHP MVC développé avec une approche procédurale.',
        'user_name' => $_SESSION['name'] ?? 'Invité'
    ];
    
    load_view_with_layout('home/profile', $data);
}

/**
 * Page test
 */
function home_test() {
    $data = [
        'title' => 'Page test',
        'message' => 'Bienvenue sur votre page test',
    ];
    
    load_view_with_layout('home/test', $data);
}

/**
 * Page Catalogue
 */
function home_catalogue() {
    require_once MODEL_PATH.'/catalogue_model.php'; // adapte le chemin selon ton projet
    $data = [
        'title' => 'Catalogue',
        'content' => 'Découvrez tous les articles que nous avons à vous proposer dans ce vaste catalogue !',
        'books' => get_all_books(),
        'movies' => get_all_movies(),
        'video_games' => get_all_video_games(), // modification pour correspondre à la nouvelle BD
        'id' => get_id(),
        'type-title' => '',
        'type' => '',
        'gender-title' => '',
        'stock-title' => '',
        'stock' => '',        
    ];
    
    // Gestion du filtre type
    if(isset($_GET['submit'])) {        
        if(isset($_GET['type-filter']) && $_GET['type-filter'] !== 'type-display') {
            $type = $_GET['type-filter'];          
            if(in_array($type, ["books", "movies", "video_games"])){ // adapté à la BD
                if($type === "books"){
                    $data['type-title'] = 'Livres';
                    $data['type'] = get_all_books();
                }
                elseif($type === "movies"){
                    $data['type-title'] = 'Films';
                    $data['type'] = get_all_movies();
                }
                elseif($type === "video_games"){
                    $data['type-title'] = 'Jeux vidéos';
                    $data['type'] = get_all_video_games();
                }
            }
        }

        // Filtre genre
        if(isset($_GET['gender-filter']) && $_GET['gender-filter'] !== 'gender-display'){
            $data['gender-filter'] = get_articles_by_gender($_GET['gender-filter']);
        }

        // Filtre stock
        if(isset($_GET['stock-filter']) && $_GET['stock-filter'] !== 'stock-display'){
            $stock = $_GET['stock-filter'];
            if(in_array($stock, ["free", "loaned", "all"])){
                if($stock ==="free"){
                    $data['stock-title'] ='Médias disponibles';
                    $data['stock'] = get_articles_by_stock_free();
                }
                elseif($stock ==="loaned"){
                    $data['stock-title'] ='Médias empruntés';
                    $data['stock'] = get_articles_by_stock_loaned();
                }
                elseif($stock ==="all"){
                    $data['stock-title'] ='Médias disponibles et empruntés';
                    $data['stock'] = get_articles_by_stock_all();
                }
            }
        }
    }
    
    load_view_with_layout('home/catalogue', $data);
}
