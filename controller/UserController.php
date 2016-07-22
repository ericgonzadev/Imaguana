<?php

require_once 'core/init.php';
require_once("classes/Image.php");

Class UserController {

    function profile($params) {
        $username = $params[0];
        //$image = Image::withID($id);
        include_once("profile.php");
    }

    function browse() {
        include_once("imageresults.php");
    }

}

?>
