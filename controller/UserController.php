<?php

require_once 'core/init.php';
require_once("classes/User.php");

Class UserController {

    function profile($params) {
        $username = $params;
        include_once("profile.php");
    }

    function update() {
        include_once("update.php");
    }

    function changepassword() {
        include_once("changepassword.php");
    }
}

?>
