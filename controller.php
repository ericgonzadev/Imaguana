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
        if (method_exists($controller, $action)){
            $controller->$action($params);
        }
        else{
            $controller = new PagesController();
            $controller->error();
        }
        break;
    case 'user':
        $controller = new UserController();
        $username = array_shift($elements);
        $action = $elements;
        if ($action){
            if (method_exists($controller, $action[0])){
                $controller->$action[0]($username);
            }
            else{
                $controller = new PagesController();
                $controller->error();
            }
        }
        else{
            $controller->profile($username);
        }
        break;
    case 'video':
        $controller = new VideoController();
        $action = array_shift($elements);
        $params = $elements;
        if (method_exists($controller, $action)){
            $controller->$action($params);
        }
        else{
            $controller = new PagesController();
            $controller->error();
        }
        break;
    default:
       $controller = new PagesController();
       if (method_exists($controller, $type)){
            $controller->$type();
       }
       else{
            $controller->error();
       }
       break;
}
?>
