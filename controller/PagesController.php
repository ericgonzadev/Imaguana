<?php

Class PagesController {

    function FAQ() {
        include_once("faq.php");
    }

    function purchases() {
        include_once("purchases.php");
    }

    function login() {
        include_once("login");
    }

    function signup() {
        include_once("register.php");
    }
}

?>
