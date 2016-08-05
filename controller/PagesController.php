<?php

Class PagesController {

    function FAQ() {
        include_once("faq.php");
    }

    function login() {
        include_once("login.php");
    }

    function signup() {
        include_once("register.php");
    }
}

?>
