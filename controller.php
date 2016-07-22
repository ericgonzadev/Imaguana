<?php
include_once 'controller/ImageController.php';
include_once 'controller/UserController.php';
include_once 'controller/VideoController.php';

$path = ltrim($_SERVER['REQUEST_URI'], '/');    // Trim leading slash(es)
echo "path: ". $path. "\r\n";;
$elements = explode('/', $path);                // Split path on slashes
echo "elements: ". $elements . "\r\n";
array_shift($elements);
echo print_r(array_shift($elements)). "\r\n";;
switch(array_shift($elements)) {
    case 'image':
        $controller = new ImageController();
        break;
    case 'user':
        $controller = new UserController();
        break;
    case 'video':
        $controller = new VideoController();
        break;
    default:
        break;
}


$action = array_shift($elements);
$params = $elements;

$controller->$action($params);


?>
