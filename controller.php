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
        $action = array_shift($elements);
        $params = $elements;
        $controller->$action($params);
        break;
    case 'user':
        $controller = new UserController();
        $username = array_shift($elements);
        $action = $elements;
        $action ? $controller->$action[0]($username) : $controller->profile($username);
        break;
    case 'video':
        $controller = new VideoController();
        $action = array_shift($elements);
        $params = $elements;
        $controller->$action($params);
        break;
    default:
       $controller = new PagesController();
       $controller->$type();
       break;
}
?>
