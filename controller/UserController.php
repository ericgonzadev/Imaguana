<?php
require_once("classes/User.php");

Class UserController {

    function profile($params) {
        $username = $params;
        include_once("profile.php");
    }
}

?>
