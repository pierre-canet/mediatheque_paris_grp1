<?php
//Modèle pour le catalogue

/**
 * Récupère les 20 premiers articles de chaque table du catalogue
 */
//CONTROLLER_PATH . '/home_controller.php';
/**
 * Récupère tous les livres
 */
function get_all_books() {
    $query = "SELECT * FROM books WHERE id BETWEEN 1 AND 20";
    return db_select($query);
}

/**
 * Récupère tous les films
 */
function get_all_movies() {
    $query = "SELECT * FROM movies WHERE id BETWEEN 1 AND 20";
    return db_select($query);
}

/**
 * Récupère tous les jeux vidéo
 */
function get_all_video_games() {    
    $query = "SELECT * FROM video_games WHERE id BETWEEN 1 AND 20";
    return db_select($query);
}

/**
 * Récupère l'id des docs
 */
function get_id(){
    $query ="SELECT id FROM movies, books, video_games";
}

    //return db_select($query);

/**
 * Récupère les articles du catalogue en fonction du genre filtré
 */
function get_articles_by_gender($gender) {    
    $query ="SELECT * from books WHERE gender = :'gender-filter';             
             SELECT * FROM movies WHERE gender = :'gender-filter';
             SELECT * FROM video_games WHERE gender = :'gender-filter';";
    return db_select($query, [':gender-filter' => $gender]);
}

/**
 * Récupère les articles du catalogue selon le filtre "stock"
 */
function get_articles_by_stock_all() {
    $query ="SELECT * FROM books;
             SELECT * FROM movies;
             SELECT * FROM video_gamesw;";
    return db_select($query);
}
function get_articles_by_stock_free() {
    $query ="SELECT * FROM books WHERE stock <=1;
             SELECT * FROM movies WHERE stock <=1;
             SELECT * FROM video_games WHERE stock <=1;";
    return db_select($query);
}
function get_articles_by_stock_loaned() {
    $query ="SELECT * FROM books WHERE stock =0;
             SELECT * FROM movies WHERE stock =0;
             SELECT * FROM video_games WHERE stock =0;";
    return db_select($query);
}
?>