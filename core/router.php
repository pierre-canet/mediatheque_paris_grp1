<?php
// سیستم روتینگ ساده

/**
 * تجزیه URL و بازگشت کنترلر، اکشن و پارامترها
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
    
    // ریدایرکت /catalog/detail به /catalog/index
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
 * بارگذاری و اجرای کنترلر مناسب
 */
function dispatch() {
    $route = parse_request_url();
    
    $controller_name = $route['controller'];
    $action_name = $route['action'];
    $params = $route['params'];
    
    // نام فایل کنترلر
    $controller_file = CONTROLLER_PATH . '/' . $controller_name . '_controller.php';
    
    // چک کردن وجود کنترلر
    if (!file_exists($controller_file)) {
        load_404();
        return;
    }
    
    // لود کردن کنترلر
    require_once $controller_file;
    
    // نام تابع اکشن
    $action_function = $controller_name . '_' . $action_name;
    
    // چک کردن وجود اکشن
    if (!function_exists($action_function)) {
        load_404();
        return;
    }
    
    // مدیریت پارامترهای جستجو
    if ($controller_name === 'catalog' && $action_name === 'index') {
        $search_term = $_GET['search_term'] ?? '';
        $search_type = $_GET['type'] ?? 'all';
        $search_genre = $_GET['genre'] ?? 'all';
        $search_availability = $_GET['availability'] ?? 'all';
        $params = array_merge($params, ['search_term' => $search_term, 'search_type' => $search_type, 'search_genre' => $search_genre, 'search_availability' => $search_availability]);
    }
    
    // اجرای تابع با پارامترها
    call_user_func_array($action_function, $params);
}

/**
 * بارگذاری صفحه 404
 */
function load_404() {
    http_response_code(404);
    require_once VIEW_PATH . '/errors/404.php';
}
?>