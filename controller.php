<?php
include_once 'controller/ImageController.php';
include_once 'controller/UserController.php';
include_once 'controller/VideoController.php';
include_once 'controller/PagesController.php';

$path = ltrim($_SERVER['REQUEST_URI'], '/');    // Trim leading slash(es)
$elements = explode('/', $path);                // Split path on slashes to an array
$type = array_shift($elements); //Cut array[0]
switch($type) {
    case 'image':
        $controller = new ImageController();
        break;
    case 'user':
        $controller = new UserController();
        $controller->profile($type);
        break;
    case 'video':
        $controller = new VideoController();
        break;
    default:
       $controller = new PagesController();
       $controller->$type();
}

$action = array_shift($elements);
$params = $elements;

$controller->$action($params);


?>
