<?php

// Define your routes
$routes = [
    '/' => 'App\Controllers\UserController@index',
    '/services' => 'App\Controllers\ServicesController@index',
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
$path = parse_url($requestUri,PHP_URL_PATH);

parse_str($queryString, $queryParams);

// echo $queryString . "<br>";

// echo $path . "<br>"; 
// echo $basePath . "<br>";

// echo $queryParams["user"] . "<br>";

$route = str_replace($basePath, '', $path);
// echo $route . "<br>";

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


/* working pattern dirty but cross server (nginx and apache)
$route = $_GET['path'];
// echo $requestUri . "<br>"; 
// echo $basePath . "<br>";
// Remove the base path from the request URI
// $route = str_replace($basePath, '', $requestUri);
echo $route;
// Route to the appropriate controller/action based on the requested URI
switch ($route) {
    case '/user':
        require_once '../app/controllers/UserController.php';
        echo "hi all im here!!!! <br>";
        $userController = new UserController();
        $userController->index();
        break;
        //example http://localhost/GBProject/public/?path=/services
    case '/services':
        echo $requestUri . "<br>";
        require_once '../app/controllers/ServicesController.php';
        $servicesController = new ServicesController();
        $servicesController->index();
        break;
    // Add more cases for other routes as needed
    default:
        // Handle 404 Not Found
        http_response_code(404);
        echo '404 Not Found';
        break;
}

*/