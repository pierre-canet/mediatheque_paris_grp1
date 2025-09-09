<?php
// Système de routage simple
/**
 * Analyse l'URL et retourne le contrôleur, l'action et les paramètres
 */
function parse_request_url() {
    $url = $_GET['url'] ?? '';
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    if (empty($url)) {
        return ['controller' => 'home', 'action' => 'index', 'params' => []];
    }
    
    $url_parts = explode('/', $url);
    
    $controller = $url_parts[0] ?? 'home';
    $action = $url_parts[1] ?? 'index';
    $params = array_slice($url_parts, 2);
    
    // Redirection de /catalog/detail vers /catalog/index
    if ($controller === 'catalog' && $action === 'detail') {
        header('Location: ' . BASE_URL . '/catalog/index');
        exit;
    }
    
    return [
        'controller' => $controller,
        'action' => $action,
        'params' => $params
    ];
}

/**
 * Charge et exécute le contrôleur approprié
 */
function dispatch() {
    $route = parse_request_url();
    
    $controller_name = $route['controller'];
    $action_name = $route['action'];
    $params = $route['params'];
    
    // Nom du fichier du contrôleur
    $controller_file = CONTROLLER_PATH . '/' . $controller_name . '_controller.php';
    
    // Vérification de l'existence du contrôleur
    if (!file_exists($controller_file)) {
        load_404();
        return;
    }
    
    // Chargement du contrôleur
    require_once $controller_file;
    
    // Nom de la fonction d'action
    $action_function = $controller_name . '_' . $action_name;
    
    // Vérification de l'existence de l'action
    if (!function_exists($action_function)) {
        load_404();
        return;
    }
    
    // Gestion des paramètres de recherche
    if ($controller_name === 'catalog' && $action_name === 'index') {
        $search_term = $_GET['search_term'] ?? '';
        $search_type = $_GET['type'] ?? 'all';
        $search_genre = $_GET['genre'] ?? 'all';
        $search_availability = $_GET['availability'] ?? 'all';
        $params = array_merge($params, ['search_term' => $search_term, 'search_type' => $search_type, 'search_genre' => $search_genre, 'search_availability' => $search_availability]);
    }
    
    // Exécution de la fonction avec les paramètres
    call_user_func_array($action_function, $params);
}

/**
 * Charge la page 404
 */
function load_404() {
    http_response_code(404);
    require_once VIEW_PATH . '/errors/404.php';
}
?>