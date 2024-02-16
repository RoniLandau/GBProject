<?php

// Define routes
$routes = [
    '/' => 'App\Controllers\UserController@index',
    '/create-user' => 'App\Controllers\UserController@post',
    '/delete-user' => 'App\Controllers\UserController@deleteUser',
    '/all-users' => 'App\Controllers\UserController@getAllUsers',
    '/all-users-list' => 'App\Controllers\UserController@getAllUsersList',
    '/get-user-details' => 'App\Controllers\UserController@getUserDetails',
    '/test' => 'App\Controllers\UserController@test',
];

// Parse the request URL
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/GBProject/public';
// Extract query parameters
$queryString = parse_url($requestUri, PHP_URL_QUERY);
// Extract path
$path = parse_url($requestUri,PHP_URL_PATH);
parse_str($queryString, $queryParams);
$route = str_replace($basePath, '', $path);

// Route the request
if (array_key_exists($route, $routes)) {
    $handler = $routes[$route];
    list($controllerName, $methodName) = explode('@', $handler);
    // echo $controllerName. "<br>";
    require_once '../' . $controllerName . '.php';
    $controller = new $controllerName();    
    $controller->$methodName($queryParams);
} else {
    // Handle 404 Not Found
    http_response_code(404);
    echo '404 Not Found';
}