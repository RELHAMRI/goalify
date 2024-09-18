<?php

// Récupération de l'URI actuelle de la requête utilisateur
// Cette partie extrait uniquement le chemin de l'URL (sans les paramètres GET ou les fragments)
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// Définition des routes
// Ce tableau associe des chemins d'URI à des fichiers de contrôleurs spécifiques
// Le chemin dans l'URL (comme '/') est relié au contrôleur correspondnat 'comme 'HomeController.php')

    $routes = [
        '/' => 'HomeController.php'
    ];

// Vérification de l'existance de la route dans le tableau des routes
// Si l'URI demandée existe dans le tableau, le contrôleur associé est inclus
if (array_key_exists($uri, $routes)) {
    // Inclusion dynamique du fichier contrôleur correspondant à l'URI
    require_once(__DIR__ . "/../app/Controllers/" . $routes[$uri]);
} else {
    // Si l'URI n'existe pas dans le tableau des routes, renvoie une erreur 404
    // http_response_code(404) indique que la page n'a pas été trouvée
    http_response_code(404);
     // Inclusion du fichier 404.php pour gérer l'affichage d'une page d'erreur personnalisée
    // require_once(__DIR__ . '/../app/Controllers/404.php');
}